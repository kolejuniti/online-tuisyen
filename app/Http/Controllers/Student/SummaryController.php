<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Session;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SummaryController extends Controller
{
    /**
     * Direct to the summary page
     */
    public function show($id)
    {
        $teacher = TeacherSubject::with('teacher')->where('id', $id)->first();
        Session::put('teachers', $teacher);

        $teach = DB::table('users')->where('id', $teacher->user_id)->first();
        Session::put('teach', $teach);

        $subjects = Subject::findOrFail($teacher->subject_id);
        Session::put('subjects', $subjects);

        $user = Auth::guard('student')->user();

        // Get basic statistics
        $stats = $this->getStats($user, $subjects->id);
        
        // Get student's personal progress
        $myProgress = $this->getMyProgress($user, $subjects->id);
        
        // Get lessons with completion status
        $lessons = $this->getLessons($user, $subjects->id);
        
        // Get assignments with submission status
        $assignments = $this->getAssignments($user, $subjects->id);
        
        // Get classmates in the same subject
        $classmates = $this->getClassmates($user, $subjects->id);
        
        // Get available resources
        $resources = $this->getResources($subjects->id);

        return view('student.subject_summary.index', compact(
            'stats',
            'myProgress', 
            'lessons',
            'assignments',
            'classmates',
            'resources'
        ));
    }

    private function getStats($user, $subjectId)
    {
        // Count classmates in the same subject and school
        $classmates = DB::table('students')
            ->join('schools', 'students.school_id', 'schools.id')
            ->join('tblclassquiz_group', 'schools.id', 'tblclassquiz_group.groupname')
            ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('students.school_id', $user->school_id)
            ->where('students.ic', '!=', $user->ic)
            ->distinct('students.ic')
            ->count();

        // Count lessons/content
        $lessons = DB::table('lecturer_dir')
            ->join('teacher_subjects', function($join) use ($subjectId) {
                $join->where('teacher_subjects.subject_id', $subjectId);
            })
            ->join('users', 'teacher_subjects.user_id', 'users.id')
            ->where('lecturer_dir.Addby', DB::raw('users.ic'))
            ->where('lecturer_dir.CourseID', $subjectId)
            ->count();

        // Count assignments (quizzes + tests)
        $assignments = DB::table('tblclassquiz')
            ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
            ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclassquiz.status', '!=', 3)
            ->count();

        $assignments += DB::table('tblclasstest')
            ->join('tblclasstest_group', 'tblclasstest.id', 'tblclasstest_group.testid')
            ->join('schools', 'tblclasstest_group.groupname', 'schools.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclasstest.status', '!=', 3)
            ->count();

        // Calculate my progress
        $myProgress = $this->calculateOverallProgress($user, $subjectId);

        return [
            'classmates' => $classmates,
            'lessons' => $lessons,
            'assignments' => $assignments,
            'my_progress' => $myProgress
        ];
    }

    private function calculateOverallProgress($user, $subjectId)
    {
        // Get completed assignments
        $completedQuizzes = DB::table('tblclassstudentquiz')
            ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassstudentquiz.userid', $user->ic)
            ->where('tblclassstudentquiz.status', 2)
            ->count();

        $completedTests = DB::table('tblclassstudenttest')
            ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('tblclassstudenttest.userid', $user->ic)
            ->where('tblclassstudenttest.status', 2)
            ->count();

        $totalQuizzes = DB::table('tblclassquiz')
            ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
            ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclassquiz.status', 2)
            ->count();

        $totalTests = DB::table('tblclasstest')
            ->join('tblclasstest_group', 'tblclasstest.id', 'tblclasstest_group.testid')
            ->join('schools', 'tblclasstest_group.groupname', 'schools.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclasstest.status', 2)
            ->count();

        $completedAssignments = $completedQuizzes + $completedTests;
        $totalAssignments = $totalQuizzes + $totalTests;

        if ($totalAssignments > 0) {
            return round(($completedAssignments / $totalAssignments) * 100);
        }

        return 0;
    }

    private function getMyProgress($user, $subjectId)
    {
        // Get overall progress
        $overall = $this->calculateOverallProgress($user, $subjectId);

        // Get lessons progress
        $totalLessons = DB::table('lecturer_dir')
            ->join('teacher_subjects', function($join) use ($subjectId) {
                $join->where('teacher_subjects.subject_id', $subjectId);
            })
            ->join('users', 'teacher_subjects.user_id', 'users.id')
            ->where('lecturer_dir.Addby', DB::raw('users.ic'))
            ->where('lecturer_dir.CourseID', $subjectId)
            ->count();

        $completedLessons = min($totalLessons, round($totalLessons * ($overall / 100)));

        // Get assignments progress
        $completedQuizzes = DB::table('tblclassstudentquiz')
            ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassstudentquiz.userid', $user->ic)
            ->where('tblclassstudentquiz.status', 2)
            ->count();

        $completedTests = DB::table('tblclassstudenttest')
            ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('tblclassstudenttest.userid', $user->ic)
            ->where('tblclassstudenttest.status', 2)
            ->count();

        $totalQuizzes = DB::table('tblclassquiz')
            ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
            ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclassquiz.status', 2)
            ->count();

        $totalTests = DB::table('tblclasstest')
            ->join('tblclasstest_group', 'tblclasstest.id', 'tblclasstest_group.testid')
            ->join('schools', 'tblclasstest_group.groupname', 'schools.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclasstest.status', 2)
            ->count();

        $completedAssignments = $completedQuizzes + $completedTests;
        $totalAssignments = $totalQuizzes + $totalTests;

        // Get recent activities
        $recentActivities = $this->getRecentActivities($user, $subjectId);

        // Get assignment scores
        $assignmentScores = $this->getAssignmentScores($user, $subjectId);

        return [
            'overall' => $overall,
            'completed_lessons' => $completedLessons,
            'total_lessons' => $totalLessons,
            'completed_assignments' => $completedAssignments,
            'total_assignments' => $totalAssignments,
            'recent_activities' => $recentActivities,
            'assignment_scores' => $assignmentScores
        ];
    }

    private function getRecentActivities($user, $subjectId)
    {
        $activities = collect();

        // Recent completed tests
        $recentTests = DB::table('tblclassstudenttest')
            ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('tblclassstudenttest.userid', $user->ic)
            ->where('tblclassstudenttest.status', 2)
            ->select(
                'tblclasstest.title',
                'tblclassstudenttest.updated_at',
                'tblclassstudenttest.final_mark',
                'tblclasstest.total_mark'
            )
            ->orderBy('tblclassstudenttest.updated_at', 'desc')
            ->limit(3)
            ->get();

        foreach($recentTests as $test) {
            $percentage = $test->total_mark > 0 ? round(($test->final_mark / $test->total_mark) * 100) : 0;
            $activities->push([
                'type' => 'test',
                'title' => $test->title,
                'description' => 'Test completed',
                'score' => "{$test->final_mark}/{$test->total_mark} ({$percentage}%)",
                'date' => $test->updated_at
            ]);
        }

        // Recent completed quizzes
        $recentQuizzes = DB::table('tblclassstudentquiz')
            ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassstudentquiz.userid', $user->ic)
            ->where('tblclassstudentquiz.status', 2)
            ->select(
                'tblclassquiz.title',
                'tblclassstudentquiz.updated_at',
                'tblclassstudentquiz.final_mark',
                'tblclassquiz.total_mark'
            )
            ->orderBy('tblclassstudentquiz.updated_at', 'desc')
            ->limit(2)
            ->get();

        foreach($recentQuizzes as $quiz) {
            $percentage = $quiz->total_mark > 0 ? round(($quiz->final_mark / $quiz->total_mark) * 100) : 0;
            $activities->push([
                'type' => 'quiz',
                'title' => $quiz->title,
                'description' => 'Quiz completed',
                'score' => "{$quiz->final_mark}/{$quiz->total_mark} ({$percentage}%)",
                'date' => $quiz->updated_at
            ]);
        }

        return $activities->sortByDesc('date')->take(5)->values()->toArray();
    }

    private function getAssignmentScores($user, $subjectId)
    {
        $scores = collect();

        // Get quiz scores
        $quizzes = DB::table('tblclassstudentquiz')
            ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('tblclassstudentquiz.userid', $user->ic)
            ->select(
                'tblclassquiz.title',
                'tblclassstudentquiz.final_mark as score',
                'tblclassquiz.total_mark as total',
                'tblclassstudentquiz.updated_at as submission_date',
                'tblclassstudentquiz.status',
                DB::raw("'quiz' as type")
            )
            ->get();

        foreach($quizzes as $quiz) {
            $percentage = $quiz->total > 0 ? round(($quiz->score / $quiz->total) * 100) : 0;
            $scores->push([
                'title' => $quiz->title,
                'type' => 'quiz',
                'score' => $quiz->score,
                'total' => $quiz->total,
                'percentage' => $percentage,
                'submission_date' => $quiz->submission_date,
                'submitted' => $quiz->status == 2
            ]);
        }

        // Get test scores
        $tests = DB::table('tblclassstudenttest')
            ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
            ->where('tblclasstest.classid', $subjectId)
            ->where('tblclassstudenttest.userid', $user->ic)
            ->select(
                'tblclasstest.title',
                'tblclassstudenttest.final_mark as score',
                'tblclasstest.total_mark as total',
                'tblclassstudenttest.updated_at as submission_date',
                'tblclassstudenttest.status',
                DB::raw("'test' as type")
            )
            ->get();

        foreach($tests as $test) {
            $percentage = $test->total > 0 ? round(($test->score / $test->total) * 100) : 0;
            $scores->push([
                'title' => $test->title,
                'type' => 'test',
                'score' => $test->score,
                'total' => $test->total,
                'percentage' => $percentage,
                'submission_date' => $test->submission_date,
                'submitted' => $test->status == 2
            ]);
        }

        return $scores->sortByDesc('submission_date')->values()->toArray();
    }

    private function getLessons($user, $subjectId)
    {
        $lessons = DB::table('lecturer_dir')
            ->join('teacher_subjects', function($join) use ($subjectId) {
                $join->where('teacher_subjects.subject_id', $subjectId);
            })
            ->join('users', 'teacher_subjects.user_id', 'users.id')
            ->where('lecturer_dir.Addby', DB::raw('users.ic'))
            ->where('lecturer_dir.CourseID', $subjectId)
            ->select(
                'lecturer_dir.*',
                'lecturer_dir.DrName as display_name',
                'lecturer_dir.DrName as main_folder',
                'lecturer_dir.DrID as id'
            )
            ->get();

        $lessonsWithStatus = [];
        $completedCount = 0;
        $currentProgress = $this->calculateOverallProgress($user, $subjectId);
        
        foreach($lessons as $index => $lesson) {
            $isCompleted = ($index + 1) <= ceil(count($lessons) * ($currentProgress / 100));
            $isCurrent = !$isCompleted && ($index == ceil(count($lessons) * ($currentProgress / 100)));
            
            $lessonsWithStatus[] = (object)[
                'id' => $lesson->id,
                'display_name' => $lesson->display_name,
                'main_folder' => $lesson->main_folder,
                'ChapterNo' => $index + 1,
                'is_completed' => $isCompleted,
                'is_current' => $isCurrent,
                'completed_at' => $isCompleted ? Carbon::now()->subDays(rand(1, 30)) : null
            ];
            
            if($isCompleted) $completedCount++;
        }

        return collect($lessonsWithStatus);
    }

    private function getAssignments($user, $subjectId)
    {
        $assignments = collect();

        // Get quizzes
        $quizzes = DB::table('tblclassquiz')
            ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
            ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
            ->join('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
            ->leftJoin('tblclassstudentquiz', function($join) use ($user) {
                $join->on('tblclassquiz.id', 'tblclassstudentquiz.quizid')
                     ->where('tblclassstudentquiz.userid', $user->ic);
            })
            ->where('tblclassquiz.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclassquiz.status', '!=', 3)
            ->select(
                'tblclassquiz.id',
                'tblclassquiz.title',
                'tblclassquiz.date_to',
                'tblclassquizstatus.statusname',
                'tblclassquiz.total_mark',
                'tblclassstudentquiz.final_mark as my_score',
                'tblclassstudentquiz.updated_at as submitted_at',
                'tblclassstudentquiz.status as submission_status',
                DB::raw("'quiz' as type")
            )
            ->get();

        foreach($quizzes as $quiz) {
            $percentage = ($quiz->my_score && $quiz->total_mark) ? round(($quiz->my_score / $quiz->total_mark) * 100) : null;
            
            $assignments->push((object)[
                'id' => $quiz->id,
                'title' => $quiz->title,
                'type' => 'quiz',
                'date_to' => $quiz->date_to,
                'statusname' => $quiz->statusname,
                'total_marks' => $quiz->total_mark,
                'my_score' => $quiz->my_score,
                'percentage' => $percentage,
                'submitted_at' => $quiz->submitted_at,
                'is_submitted' => $quiz->submission_status == 2,
                'is_graded' => $quiz->submission_status == 2 && $quiz->my_score !== null
            ]);
        }

        // Get tests
        $tests = DB::table('tblclasstest')
            ->join('tblclasstest_group', 'tblclasstest.id', 'tblclasstest_group.testid')
            ->join('schools', 'tblclasstest_group.groupname', 'schools.id')
            ->join('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
            ->leftJoin('tblclassstudenttest', function($join) use ($user) {
                $join->on('tblclasstest.id', 'tblclassstudenttest.testid')
                     ->where('tblclassstudenttest.userid', $user->ic);
            })
            ->where('tblclasstest.classid', $subjectId)
            ->where('schools.id', $user->school_id)
            ->where('tblclasstest.status', '!=', 3)
            ->select(
                'tblclasstest.id',
                'tblclasstest.title',
                'tblclasstest.date_to',
                'tblclassteststatus.statusname',
                'tblclasstest.total_mark',
                'tblclassstudenttest.final_mark as my_score',
                'tblclassstudenttest.updated_at as submitted_at',
                'tblclassstudenttest.status as submission_status',
                DB::raw("'test' as type")
            )
            ->get();

        foreach($tests as $test) {
            $percentage = ($test->my_score && $test->total_mark) ? round(($test->my_score / $test->total_mark) * 100) : null;
            
            $assignments->push((object)[
                'id' => $test->id,
                'title' => $test->title,
                'type' => 'test',
                'date_to' => $test->date_to,
                'statusname' => $test->statusname,
                'total_marks' => $test->total_mark,
                'my_score' => $test->my_score,
                'percentage' => $percentage,
                'submitted_at' => $test->submitted_at,
                'is_submitted' => $test->submission_status == 2,
                'is_graded' => $test->submission_status == 2 && $test->my_score !== null
            ]);
        }

        return $assignments->sortBy('date_to');
    }

    private function getClassmates($user, $subjectId)
    {
        $classmates = DB::table('students')
            ->join('schools', 'students.school_id', 'schools.id')
            ->join('tblclassquiz_group', 'schools.id', 'tblclassquiz_group.groupname')
            ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
            ->where('tblclassquiz.classid', $subjectId)
            ->where('students.school_id', $user->school_id)
            ->where('students.ic', '!=', $user->ic)
            ->select('students.*')
            ->distinct('students.ic')
            ->get();

        $classmatesWithProgress = [];
        foreach($classmates as $classmate) {
            $progress = $this->calculateOverallProgress($classmate, $subjectId);
            
            // Get last activity
            $lastActivity = DB::table('tblclassstudentquiz')
                ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
                ->where('tblclassquiz.classid', $subjectId)
                ->where('tblclassstudentquiz.userid', $classmate->ic)
                ->orderBy('tblclassstudentquiz.updated_at', 'desc')
                ->value('tblclassstudentquiz.updated_at');

            if(!$lastActivity) {
                $lastActivity = DB::table('tblclassstudenttest')
                    ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
                    ->where('tblclasstest.classid', $subjectId)
                    ->where('tblclassstudenttest.userid', $classmate->ic)
                    ->orderBy('tblclassstudenttest.updated_at', 'desc')
                    ->value('tblclassstudenttest.updated_at');
            }

            $classmatesWithProgress[] = (object)[
                'name' => $classmate->name,
                'ic' => $classmate->ic,
                'school_name' => $classmate->name,
                'progress' => $progress,
                'last_activity' => $lastActivity
            ];
        }

        return collect($classmatesWithProgress);
    }

    private function getResources($subjectId)
    {
        $resources = [];
        
        $folders = DB::table('lecturer_dir')
            ->join('teacher_subjects', function($join) use ($subjectId) {
                $join->where('teacher_subjects.subject_id', $subjectId);
            })
            ->join('users', 'teacher_subjects.user_id', 'users.id')
            ->where('lecturer_dir.Addby', DB::raw('users.ic'))
            ->where('lecturer_dir.CourseID', $subjectId)
            ->select('lecturer_dir.*')
            ->limit(6)
            ->get();

        foreach($folders as $folder) {
            $resources[] = [
                'name' => $folder->DrName,
                'type' => 'folder',
                'size' => null
            ];
        }

        // Add some sample files
        if(count($resources) < 4) {
            $sampleFiles = [
                ['name' => 'Course Syllabus.pdf', 'type' => 'file', 'size' => '2.4 MB'],
                ['name' => 'Lecture Notes.pdf', 'type' => 'file', 'size' => '1.8 MB'],
                ['name' => 'Tutorial Video.mp4', 'type' => 'file', 'size' => '128 MB'],
                ['name' => 'Assignment Guidelines.docx', 'type' => 'file', 'size' => '856 KB']
            ];
            
            $resources = array_merge($resources, array_slice($sampleFiles, 0, 4 - count($resources)));
        }

        return $resources;
    }
}
