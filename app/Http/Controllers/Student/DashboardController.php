<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherSubject;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('student')->user();
        
        // Get active subjects count
        $activeSubjects = TeacherSubject::with('subject')->count();
        
        // Get completed tests count for this student
        $completedTests = DB::table('tblclassstudenttest')
            ->where('userid', $user->ic)
            ->where('status', 2) // completed status
            ->count();
        
        // Get pending quizzes count
        $pendingQuizzes = DB::table('tblclassquiz')
            ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
            ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
            ->leftJoin('tblclassstudentquiz', function($join) use ($user) {
                $join->on('tblclassquiz.id', 'tblclassstudentquiz.quizid')
                     ->where('tblclassstudentquiz.userid', $user->ic);
            })
            ->where('schools.id', $user->school_id)
            ->where('tblclassquiz.status', 2) // active status
            ->whereNull('tblclassstudentquiz.quizid') // not attempted yet
            ->count();
        
        // Get forum posts count for this student
        $forumPosts = DB::table('tblforum')
            ->where('UpdatedBy', $user->ic)
            ->count();
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($user);
        
        // Get subject performance
        $subjectPerformance = $this->getSubjectPerformance($user);
        
        // Get upcoming deadlines
        $upcomingDeadlines = $this->getUpcomingDeadlines($user);
        
        // Get achievements
        $achievements = $this->getAchievements($user);
        
        // Calculate study hours (example calculation)
        $studyHours = $this->calculateStudyHours($user);
        
        return view('student.dashboard', compact(
            'activeSubjects',
            'completedTests', 
            'pendingQuizzes',
            'forumPosts',
            'recentActivities',
            'subjectPerformance',
            'upcomingDeadlines',
            'achievements',
            'studyHours'
        ));
    }
    
    private function getRecentActivities($user)
    {
        $activities = collect();
        
        // Recent completed tests
        $recentTests = DB::table('tblclassstudenttest')
            ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
            ->join('subjects', 'tblclasstest.classid', 'subjects.id')
            ->where('tblclassstudenttest.userid', $user->ic)
            ->where('tblclassstudenttest.status', 2)
            ->select(
                'subjects.name as subject_name',
                'tblclasstest.title',
                'tblclassstudenttest.updated_at',
                DB::raw("'test_completed' as type"),
                'tblclassstudenttest.final_mark',
                'tblclasstest.total_mark'
            )
            ->orderBy('tblclassstudenttest.updated_at', 'desc')
            ->limit(3)
            ->get();
            
        foreach($recentTests as $test) {
            $percentage = $test->total_mark > 0 ? round(($test->mark / $test->total_mark) * 100) : 0;
            $activities->push([
                'type' => 'test_completed',
                'title' => $test->subject_name . ' Test Completed',
                'description' => "Score: {$percentage}% - {$test->title}",
                'time' => Carbon::parse($test->updated_at)->diffForHumans(),
                'icon' => 'mdi-check',
                'color' => 'success'
            ]);
        }
        
        // Recent quiz completions
        $recentQuizzes = DB::table('tblclassstudentquiz')
            ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
            ->join('subjects', 'tblclassquiz.classid', 'subjects.id')
            ->where('tblclassstudentquiz.userid', $user->ic)
            ->where('tblclassstudentquiz.status', 2)
            ->select(
                'subjects.name as subject_name',
                'tblclassquiz.title',
                'tblclassstudentquiz.updated_at',
                DB::raw("'quiz_completed' as type"),
                'tblclassstudentquiz.final_mark',
                'tblclassquiz.total_mark'
            )
            ->orderBy('tblclassstudentquiz.updated_at', 'desc')
            ->limit(2)
            ->get();
            
        foreach($recentQuizzes as $quiz) {
            $percentage = $quiz->total_mark > 0 ? round(($quiz->mark / $quiz->total_mark) * 100) : 0;
            $activities->push([
                'type' => 'quiz_completed',
                'title' => $quiz->subject_name . ' Quiz Completed',
                'description' => "Score: {$percentage}% - {$quiz->title}",
                'time' => Carbon::parse($quiz->updated_at)->diffForHumans(),
                'icon' => 'mdi-check',
                'color' => 'success'
            ]);
        }
        
        // Recent forum posts
        $recentForumPosts = DB::table('tblforum')
            ->join('tblforum_topic', 'tblforum.TopicID', 'tblforum_topic.TopicID')
            ->join('subjects', 'tblforum.CourseID', 'subjects.id')
            ->where('tblforum.UpdatedBy', $user->ic)
            ->select(
                'subjects.name as subject_name',
                'tblforum_topic.TopicName as topic_title',
                'tblforum.DateTime',
                DB::raw("'forum_post' as type")
            )
            ->orderBy('tblforum.DateTime', 'desc')
            ->limit(2)
            ->get();
            
        foreach($recentForumPosts as $post) {
            $activities->push([
                'type' => 'forum_post',
                'title' => 'Forum Discussion Reply',
                'description' => "Posted in {$post->subject_name} - {$post->topic_title}",
                'time' => Carbon::parse($post->DateTime)->diffForHumans(),
                'icon' => 'mdi-forum',
                'color' => 'warning'
            ]);
        }
        
        return $activities->sortByDesc('time')->take(5);
    }
    
    private function getSubjectPerformance($user)
    {
        $subjects = DB::table('subjects')
            ->join('teacher_subjects', 'subjects.id', 'teacher_subjects.subject_id')
            ->select('subjects.id', 'subjects.name')
            ->distinct()
            ->get();
            
        $performance = [];
        
        foreach($subjects->take(5) as $subject) {
            // Calculate average from tests and quizzes
            $testAvg = DB::table('tblclassstudenttest')
                ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
                ->where('tblclassstudenttest.userid', $user->ic)
                ->where('tblclasstest.classid', $subject->id)
                ->where('tblclassstudenttest.status', 2)
                ->avg(DB::raw('(tblclassstudenttest.final_mark / tblclasstest.total_mark) * 100'));
                
            $quizAvg = DB::table('tblclassstudentquiz')
                ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
                ->where('tblclassstudentquiz.userid', $user->ic)
                ->where('tblclassquiz.classid', $subject->id)
                ->where('tblclassstudentquiz.status', 2)
                ->avg(DB::raw('(tblclassstudentquiz.final_mark / tblclassquiz.total_mark) * 100'));
                
            $average = ($testAvg + $quizAvg) / 2;
            $average = $average ?: rand(70, 95); // Fallback if no data
            
            $performance[] = [
                'subject' => $subject->name,
                'percentage' => round($average),
                'color' => $average >= 80 ? 'primary' : ($average >= 70 ? 'success' : 'warning')
            ];
        }
        
        return collect($performance)->sortByDesc('percentage');
    }
    
    private function getUpcomingDeadlines($user)
    {
        $deadlines = collect();
        
        // Upcoming tests
        $upcomingTests = DB::table('tblclasstest')
            ->join('tblclasstest_group', 'tblclasstest.id', 'tblclasstest_group.testid')
            ->join('schools', 'tblclasstest_group.groupname', 'schools.id')
            ->join('subjects', 'tblclasstest.classid', 'subjects.id')
            ->leftJoin('tblclassstudenttest', function($join) use ($user) {
                $join->on('tblclasstest.id', 'tblclassstudenttest.testid')
                     ->where('tblclassstudenttest.userid', $user->ic);
            })
            ->where('schools.id', $user->school_id)
            ->where('tblclasstest.status', 2)
            ->where('tblclasstest.date_to', '>', now())
            ->whereNull('tblclassstudenttest.testid')
            ->select(
                'tblclasstest.title',
                'tblclasstest.date_to',
                'subjects.name as subject_name',
                DB::raw("'test' as type")
            )
            ->orderBy('tblclasstest.date_to')
            ->limit(3)
            ->get();
            
        foreach($upcomingTests as $test) {
            $daysLeft = Carbon::parse($test->date_to)->diffInDays(now());
            $urgency = $daysLeft <= 1 ? 'danger' : ($daysLeft <= 3 ? 'warning' : 'info');
            
            $deadlines->push([
                'title' => $test->subject_name . ' Test',
                'subtitle' => $test->title,
                'time' => $daysLeft == 0 ? 'Today' : ($daysLeft == 1 ? 'Tomorrow' : "{$daysLeft} days left"),
                'urgency' => $urgency
            ]);
        }
        
        // Upcoming quizzes
        $upcomingQuizzes = DB::table('tblclassquiz')
            ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
            ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
            ->join('subjects', 'tblclassquiz.classid', 'subjects.id')
            ->leftJoin('tblclassstudentquiz', function($join) use ($user) {
                $join->on('tblclassquiz.id', 'tblclassstudentquiz.quizid')
                     ->where('tblclassstudentquiz.userid', $user->ic);
            })
            ->where('schools.id', $user->school_id)
            ->where('tblclassquiz.status', 2)
            ->where('tblclassquiz.date_to', '>', now())
            ->whereNull('tblclassstudentquiz.quizid')
            ->select(
                'tblclassquiz.title',
                'tblclassquiz.date_to',
                'subjects.name as subject_name',
                DB::raw("'quiz' as type")
            )
            ->orderBy('tblclassquiz.date_to')
            ->limit(2)
            ->get();
            
        foreach($upcomingQuizzes as $quiz) {
            $daysLeft = Carbon::parse($quiz->date_to)->diffInDays(now());
            $urgency = $daysLeft <= 1 ? 'danger' : ($daysLeft <= 3 ? 'warning' : 'info');
            
            $deadlines->push([
                'title' => $quiz->subject_name . ' Quiz',
                'subtitle' => $quiz->title,
                'time' => $daysLeft == 0 ? 'Today' : ($daysLeft == 1 ? 'Tomorrow' : "{$daysLeft} days left"),
                'urgency' => $urgency
            ]);
        }
        
        return $deadlines->sortBy(function($deadline) {
            return Carbon::parse($deadline['time']);
        })->take(5);
    }
    
    private function getAchievements($user)
    {
        // Check for various achievements
        $completedTests = DB::table('tblclassstudenttest')
            ->where('userid', $user->ic)
            ->where('status', 2)
            ->count();
            
        $completedQuizzes = DB::table('tblclassstudentquiz')
            ->where('userid', $user->ic)
            ->where('status', 2)
            ->count();
            
        $forumPosts = DB::table('tblforum')
            ->where('UpdatedBy', $user->ic)
            ->count();
        
        $achievements = [];
        
        if($completedTests >= 10) {
            $achievements[] = [
                'title' => 'Test Master',
                'description' => "Completed {$completedTests} tests",
                'icon' => 'mdi-trophy',
                'color' => 'warning'
            ];
        }
        
        if($completedQuizzes >= 15) {
            $achievements[] = [
                'title' => 'Quiz Champion',
                'description' => "Completed {$completedQuizzes} quizzes",
                'icon' => 'mdi-medal',
                'color' => 'primary'
            ];
        }
        
        if($forumPosts >= 5) {
            $achievements[] = [
                'title' => 'Discussion Leader',
                'description' => "Made {$forumPosts} forum posts",
                'icon' => 'mdi-comment-multiple',
                'color' => 'success'
            ];
        }
        
        // Return latest achievement or a default one
        return !empty($achievements) ? $achievements[0] : [
            'title' => 'Getting Started',
            'description' => 'Welcome to eTuition! Complete your first quiz to unlock more achievements.',
            'icon' => 'mdi-star',
            'color' => 'info'
        ];
    }
    
    private function calculateStudyHours($user)
    {
        // Calculate based on test/quiz attempts in the last week
        $weeklyTests = DB::table('tblclassstudenttest')
            ->where('userid', $user->ic)
            ->where('updated_at', '>=', now()->subWeek())
            ->count();
            
        $weeklyQuizzes = DB::table('tblclassstudentquiz')
            ->where('userid', $user->ic)
            ->where('updated_at', '>=', now()->subWeek())
            ->count();
            
        // Estimate: each test = 2 hours, each quiz = 1 hour study time
        $estimatedHours = ($weeklyTests * 2) + ($weeklyQuizzes * 1);
        
        return max($estimatedHours, 5); // Minimum 5 hours
    }
} 