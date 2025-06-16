<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    /**
     * Direct to the summary page
     */
    public function index($id)
    {
        $user = Auth::user();
        $subjects = Subject::findOrFail($id);
        Session::put('subjects', $subjects);

        // Get statistics for the subject
        $stats = $this->getSubjectStatistics($subjects->id, $user->ic);
        $students = $this->getStudents($subjects->id, $user->ic);
        $lessons = $this->getLessons($subjects->id, $user->ic);
        $assignments = $this->getAssignments($subjects->id, $user->ic);
        $resources = $this->getResources($subjects->id, $user->ic);

        return view('user.subject_summary.index', compact('stats', 'students', 'lessons', 'assignments', 'resources'));
    }

    private function getSubjectStatistics($subjectId, $teacherIc)
    {
        // Get total students enrolled
        $totalStudents = DB::table('students')
            ->join('schools', 'students.school_id', 'schools.id')
            ->join('tblclassquiz_group', function($join) use ($subjectId, $teacherIc) {
                $join->on('schools.id', 'tblclassquiz_group.groupname');
            })
            ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassquiz.addby', $teacherIc)
            ->distinct('students.ic')
            ->count();

        // Get total lessons (chapters)
        $totalLessons = DB::table('material_dir')
            ->join('lecturer_dir', 'material_dir.LecturerDirID', 'lecturer_dir.DrID')
            ->where('lecturer_dir.CourseID', $subjectId)
            ->where('lecturer_dir.Addby', $teacherIc)
            ->count();

        // Get total assignments (quizzes + tests)
        $totalAssignments = DB::table('tblclassquiz')
            ->where('classid', $subjectId)
            ->where('addby', $teacherIc)
            ->where('status', '!=', 3)
            ->count();

        $totalTests = DB::table('tblclasstest')
            ->where('classid', $subjectId)
            ->where('addby', $teacherIc)
            ->where('status', '!=', 3)
            ->count();

        // Calculate completion percentage
        $completedAssignments = DB::table('tblclassstudentquiz')
            ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassquiz.addby', $teacherIc)
            ->where('tblclassstudentquiz.status', 2)
            ->count();

        $completedTests = DB::table('tblclassstudenttest')
            ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('tblclasstest.addby', $teacherIc)
            ->where('tblclassstudenttest.status', 2)
            ->count();

        $totalCompletions = $completedAssignments + $completedTests;
        $totalPossibleCompletions = ($totalAssignments + $totalTests) * max($totalStudents, 1);
        $completionPercentage = $totalPossibleCompletions > 0 ? round(($totalCompletions / $totalPossibleCompletions) * 100) : 0;

        return [
            'students' => $totalStudents,
            'lessons' => $totalLessons,
            'assignments' => $totalAssignments + $totalTests,
            'completion' => $completionPercentage
        ];
    }

    private function getStudents($subjectId, $userIc)
    {
        $user = Auth::user();
        
        // Get all students enrolled in this subject through the quiz/test groups
        // Following the same pattern as QuizController and TestController
        $students = DB::table('students')
            ->join('schools', 'students.school_id', 'schools.id')
            ->join('tblclassquiz_group', function($join) use ($subjectId, $userIc) {
                $join->on('schools.id', 'tblclassquiz_group.groupname');
            })
            ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassquiz.addby', $userIc)
            ->select('students.*', 'schools.name as school_name')
            ->distinct('students.ic')
            ->get();

        // If no students from quiz groups, try test groups
        if($students->isEmpty()) {
            $students = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclasstest_group', function($join) use ($subjectId, $userIc) {
                    $join->on('schools.id', 'tblclasstest_group.groupname');
                })
                ->join('tblclasstest', 'tblclasstest_group.testid', 'tblclasstest.id')
                ->where('tblclasstest.classid', $subjectId)
                ->where('tblclasstest.addby', $userIc)
                ->select('students.*', 'schools.name as school_name')
                ->distinct('students.ic')
                ->get();
        }

        $studentsWithProgress = [];

        foreach($students as $student) {
            // Get quiz submissions for this student
            $quizSubmissions = DB::table('tblclassstudentquiz')
                ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
                ->where('tblclassquiz.classid', $subjectId)
                ->where('tblclassquiz.addby', $userIc)
                ->where('tblclassstudentquiz.userid', $student->ic)
                ->select(
                    'tblclassstudentquiz.*',
                    'tblclassquiz.total_mark',
                    'tblclassquiz.title',
                    'tblclassquiz.id as quiz_id'
                )
                ->get();

            // Get test submissions for this student
            $testSubmissions = DB::table('tblclassstudenttest')
                ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
                ->where('tblclasstest.classid', $subjectId)
                ->where('tblclasstest.addby', $userIc)
                ->where('tblclassstudenttest.userid', $student->ic)
                ->select(
                    'tblclassstudenttest.*',
                    'tblclasstest.total_mark',
                    'tblclasstest.title',
                    'tblclasstest.id as test_id'
                )
                ->get();

            // Get total quizzes and tests available for this subject
            $totalQuizzes = DB::table('tblclassquiz')
                ->where('classid', $subjectId)
                ->where('addby', $userIc)
                ->where('status', '!=', 3)
                ->count();

            $totalTests = DB::table('tblclasstest')
                ->where('classid', $subjectId)
                ->where('addby', $userIc)
                ->where('status', '!=', 3)
                ->count();

            $totalAssignments = $totalQuizzes + $totalTests;
            $completedAssignments = $quizSubmissions->count() + $testSubmissions->count();

            // Calculate average score
            $totalMarks = 0;
            $totalPossibleMarks = 0;
            $assignmentDetails = [];

            foreach($quizSubmissions as $submission) {
                if($submission->final_mark !== null && $submission->total_mark > 0) {
                    $totalMarks += $submission->final_mark;
                    $totalPossibleMarks += $submission->total_mark;
                }
                
                $assignmentDetails[] = [
                    'type' => 'Quiz',
                    'title' => $submission->title,
                    'submitted' => $submission->submittime ? true : false,
                    'submission_date' => $submission->submittime,
                    'score' => $submission->final_mark,
                    'total' => $submission->total_mark,
                    'status' => $submission->status,
                    'id' => $submission->quiz_id
                ];
            }

            foreach($testSubmissions as $submission) {
                if($submission->final_mark !== null && $submission->total_mark > 0) {
                    $totalMarks += $submission->final_mark;
                    $totalPossibleMarks += $submission->total_mark;
                }
                
                $assignmentDetails[] = [
                    'type' => 'Test',
                    'title' => $submission->title,
                    'submitted' => $submission->submittime ? true : false,
                    'submission_date' => $submission->submittime,
                    'score' => $submission->final_mark,
                    'total' => $submission->total_mark,
                    'status' => $submission->status,
                    'id' => $submission->test_id
                ];
            }

            $averageScore = $totalPossibleMarks > 0 ? round(($totalMarks / $totalPossibleMarks) * 100, 1) : 0;
            $progress = $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100, 1) : 0;

            $studentsWithProgress[] = (object) [
                'ic' => $student->ic,
                'name' => $student->name,
                'email' => $student->email ?? '',
                'school_name' => $student->school_name,
                'progress' => $progress,
                'completed_assignments' => $completedAssignments,
                'total_assignments' => $totalAssignments,
                'average_score' => $averageScore,
                'assignment_details' => $assignmentDetails,
                'last_activity' => $this->getLastActivity($quizSubmissions, $testSubmissions)
            ];
        }

        return collect($studentsWithProgress)->sortBy('name');
    }

    private function getLastActivity($quizSubmissions, $testSubmissions)
    {
        $lastActivity = null;
        
        foreach($quizSubmissions as $submission) {
            if($submission->submittime && (!$lastActivity || $submission->submittime > $lastActivity)) {
                $lastActivity = $submission->submittime;
            }
        }
        
        foreach($testSubmissions as $submission) {
            if($submission->submittime && (!$lastActivity || $submission->submittime > $lastActivity)) {
                $lastActivity = $submission->submittime;
            }
        }
        
        return $lastActivity;
    }

    private function getLessons($subjectId, $teacherIc)
    {
        return DB::table('material_dir')
            ->join('lecturer_dir', 'material_dir.LecturerDirID', 'lecturer_dir.DrID')
            ->select('material_dir.*', 'lecturer_dir.DrName as main_folder')
            ->where('lecturer_dir.CourseID', $subjectId)
            ->where('lecturer_dir.Addby', $teacherIc)
            ->orderBy('material_dir.ChapterNo')
            ->get()
            ->map(function($lesson) {
                $lesson->display_name = $lesson->newDrName ?: $lesson->DrName;
                $lesson->status = 'completed'; // You can implement logic to determine status
                return $lesson;
            });
    }

    private function getAssignments($subjectId, $teacherIc)
    {
        // Get quizzes
        $quizzes = DB::table('tblclassquiz')
            ->join('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
            ->select('tblclassquiz.*', 'tblclassquizstatus.statusname', DB::raw("'quiz' as type"))
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassquiz.addby', $teacherIc)
            ->where('tblclassquiz.status', '!=', 3)
            ->get();

        // Get tests
        $tests = DB::table('tblclasstest')
            ->join('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
            ->select('tblclasstest.*', 'tblclassteststatus.statusname', DB::raw("'test' as type"))
            ->where('tblclasstest.classid', $subjectId)
            ->where('tblclasstest.addby', $teacherIc)
            ->where('tblclasstest.status', '!=', 3)
            ->get();

        return $quizzes->concat($tests)->map(function($assignment) use ($subjectId, $teacherIc) {
            // Count submissions
            if ($assignment->type === 'quiz') {
                $submissions = DB::table('tblclassstudentquiz')
                    ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
                    ->where('tblclassquiz.classid', $subjectId)
                    ->where('tblclassquiz.addby', $teacherIc)
                    ->where('tblclassstudentquiz.quizid', $assignment->id)
                    ->count();

                $totalStudents = DB::table('students')
                    ->join('schools', 'students.school_id', 'schools.id')
                    ->join('tblclassquiz_group', function($join) use ($assignment) {
                        $join->on('schools.id', 'tblclassquiz_group.groupname')
                             ->where('tblclassquiz_group.quizid', $assignment->id);
                    })
                    ->distinct('students.ic')
                    ->count();

                $avgScore = DB::table('tblclassstudentquiz')
                    ->where('quizid', $assignment->id)
                    ->where('status', 2)
                    ->avg(DB::raw('(final_mark / ' . ($assignment->total_mark ?: 1) . ') * 100'));
            } else {
                $submissions = DB::table('tblclassstudenttest')
                    ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
                    ->where('tblclasstest.classid', $subjectId)
                    ->where('tblclasstest.addby', $teacherIc)
                    ->where('tblclassstudenttest.testid', $assignment->id)
                    ->count();

                $totalStudents = DB::table('students')
                    ->join('schools', 'students.school_id', 'schools.id')
                    ->join('tblclasstest_group', function($join) use ($assignment) {
                        $join->on('schools.id', 'tblclasstest_group.groupname')
                             ->where('tblclasstest_group.testid', $assignment->id);
                    })
                    ->distinct('students.ic')
                    ->count();

                $avgScore = DB::table('tblclassstudenttest')
                    ->where('testid', $assignment->id)
                    ->where('status', 2)
                    ->avg(DB::raw('(final_mark / ' . ($assignment->total_mark ?: 1) . ') * 100'));
            }

            $assignment->submissions = $submissions;
            $assignment->total_students = $totalStudents;
            $assignment->average_score = $avgScore ? round($avgScore) : 0;
            
            return $assignment;
        })->sortByDesc('created_at');
    }

    private function getResources($subjectId, $teacherIc)
    {
        // Get main folders/directories
        $mainFolders = DB::table('lecturer_dir')
            ->where('CourseID', $subjectId)
            ->where('Addby', $teacherIc)
            ->get();

        // Get sub folders and files
        $resources = collect();
        
        foreach ($mainFolders as $folder) {
            $subFolders = DB::table('material_dir')
                ->where('LecturerDirID', $folder->DrID)
                ->get();
                
            foreach ($subFolders as $subFolder) {
                $resources->push([
                    'name' => $subFolder->newDrName ?: $subFolder->DrName,
                    'type' => 'folder',
                    'size' => null,
                    'path' => "eTutor/SubjectContent/{$subjectId}/{$folder->DrName}/{$subFolder->DrName}"
                ]);
            }
        }

        return $resources->take(8); // Limit to 8 resources for display
    }
}
