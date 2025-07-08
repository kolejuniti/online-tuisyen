<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\OnlineClass;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OnlineClassController extends Controller
{
    /**
     * Display a listing of online classes available to the student
     */
    public function index($id)
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in as a student to access this page.');
        }

        // Get the subject information from session or database
        $course = DB::table('subjects')->where('id', $id)->first();
        
        if (!$course) {
            return redirect()->route('student.subjects.index')
                ->with('error', 'Subject not found.');
        }

        // Get all active online classes where student's school is included
        // Convert school_id to string since JSON stores school IDs as strings
        $studentSchoolId = (string) $student->school_id;
        
        $onlineClasses = OnlineClass::where('status', 'active')
            ->whereJsonContains('school', $studentSchoolId)
            ->orderBy('datetime', 'desc')
            ->get();

        // Categorize classes by time
        $today = Carbon::today();
        $now = Carbon::now();
        
        $previousClasses = $onlineClasses->filter(function ($class) use ($now) {
            return $class->datetime->lt($now);
        });
        
        $todayClasses = $onlineClasses->filter(function ($class) use ($today) {
            return $class->datetime->isToday();
        });
        
        $upcomingClasses = $onlineClasses->filter(function ($class) use ($now) {
            return $class->datetime->gt($now) && !$class->datetime->isToday();
        });

        return view('student.online-class.index', compact(
            'course', 
            'onlineClasses', 
            'previousClasses', 
            'todayClasses', 
            'upcomingClasses'
        ));
    }

    /**
     * Show details of a specific online class
     */
    public function show($id, $classId)
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in as a student to access this page.');
        }

        $course = DB::table('subjects')->where('id', $id)->first();
        $onlineClass = OnlineClass::find($classId);
        
        if (!$onlineClass) {
            return redirect()->route('student.online-class.index', $id)
                ->with('error', 'Online class not found.');
        }

        // Check if student's school is authorized for this class
        $selectedSchoolIds = $onlineClass->school ?? [];
        $studentSchoolId = (string) $student->school_id;
        if (!in_array($studentSchoolId, $selectedSchoolIds)) {
            return redirect()->route('student.online-class.index', $id)
                ->with('error', 'You are not authorized to view this online class.');
        }

        // Get other students from the same schools who can join this class
        $classStudents = Student::whereIn('school_id', $selectedSchoolIds)
            ->where('status', 'active')
            ->with('school:id,name')
            ->get();

        return view('student.online-class.show', compact('course', 'onlineClass', 'classStudents'));
    }

    /**
     * Join an online class (redirect to the actual meeting URL)
     */
    public function join($id, $classId)
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in as a student to join this class.');
        }

        $onlineClass = OnlineClass::find($classId);
        
        if (!$onlineClass) {
            return redirect()->route('student.online-class.index', $id)
                ->with('error', 'Online class not found.');
        }

        // Check if class is active
        if ($onlineClass->status !== 'active') {
            return redirect()->route('student.online-class.index', $id)
                ->with('error', 'This online class is not active.');
        }

        // Check if student's school is authorized
        $selectedSchoolIds = $onlineClass->school ?? [];
        $studentSchoolId = (string) $student->school_id;
        if (!in_array($studentSchoolId, $selectedSchoolIds)) {
            return redirect()->route('student.online-class.index', $id)
                ->with('error', 'You are not authorized to join this online class.');
        }

        // Check if student account is active
        if ($student->status !== 'active') {
            return redirect()->route('student.online-class.index', $id)
                ->with('error', 'Your student account is not active. Please contact administrator.');
        }

        // Log the access for tracking purposes
        Log::info('Student accessed online class', [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'student_email' => $student->email,
            'school_id' => $student->school_id,
            'class_id' => $onlineClass->id,
            'class_name' => $onlineClass->name,
            'access_time' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Redirect to the actual meeting URL
        return redirect()->away($onlineClass->url);
    }
} 