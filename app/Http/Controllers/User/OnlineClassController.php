<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OnlineClass;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OnlineClassController extends Controller
{
    /**
     * Display a listing of online classes for the current subject
     */
    public function index($id)
    {
        $course = DB::table('subjects')->where('id', Session::get('subjects')->id)->first();
        
        $onlineClasses = OnlineClass::active()
            ->orderBy('datetime', 'desc')
            ->get();

        return view('user.online-class.index', compact('onlineClasses', 'course'));
    }

    /**
     * Show the form for creating a new online class
     */
    public function create($id)
    {
        $course = DB::table('subjects')->where('id', Session::get('subjects')->id)->first();
        $schools = School::where('status', 'active')->with('students')->get();
        
        return view('user.online-class.create', compact('course', 'schools'));
    }

    /**
     * Store a newly created online class
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'datetime' => 'required|date|after:now',
            'schools' => 'required|array|min:1',
            'schools.*' => 'exists:schools,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            OnlineClass::create([
                'name' => $request->name,
                'url' => $request->url,
                'datetime' => $request->datetime,
                'school' => $request->schools,
                'status' => 'active',
            ]);

            return redirect()->route('user.online-class.index', Session::get('subjects')->id)
                ->with('success', 'Online class created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create online class. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing an online class
     */
    public function edit($id, $classId)
    {
        $course = DB::table('subjects')->where('id', Session::get('subjects')->id)->first();
        $onlineClass = OnlineClass::find($classId);
        
        if (!$onlineClass) {
            return redirect()->route('user.online-class.index', $id)
                ->with('error', 'Online class not found.');
        }

        $schools = School::where('status', 'active')->with('students')->get();
        $selectedSchools = $onlineClass->school ?? [];
        
        return view('user.online-class.edit', compact('course', 'onlineClass', 'schools', 'selectedSchools'));
    }

    /**
     * Update an online class
     */
    public function update(Request $request, $id, $classId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'datetime' => 'required|date',
            'schools' => 'required|array|min:1',
            'schools.*' => 'exists:schools,id',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $onlineClass = OnlineClass::find($classId);
            
            if (!$onlineClass) {
                return redirect()->route('user.online-class.index', $id)
                    ->with('error', 'Online class not found.');
            }

            $onlineClass->update([
                'name' => $request->name,
                'url' => $request->url,
                'datetime' => $request->datetime,
                'school' => $request->schools,
                'status' => $request->status,
            ]);

            return redirect()->route('user.online-class.index', $id)
                ->with('success', 'Online class updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update online class. Please try again.')
                ->withInput();
        }
    }

    /**
     * Delete an online class
     */
    public function destroy($id, $classId)
    {
        try {
            $onlineClass = OnlineClass::find($classId);
            
            if (!$onlineClass) {
                return redirect()->route('user.online-class.index', $id)
                    ->with('error', 'Online class not found.');
            }

            $onlineClass->delete();
            
            return redirect()->route('user.online-class.index', $id)
                ->with('success', 'Online class deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete online class. Please try again.');
        }
    }

    /**
     * Show details of an online class with students
     */
    public function show($id, $classId)
    {
        $course = DB::table('subjects')->where('id', Session::get('subjects')->id)->first();
        $onlineClass = OnlineClass::find($classId);
        
        if (!$onlineClass) {
            return redirect()->route('user.online-class.index', $id)
                ->with('error', 'Online class not found.');
        }

        $schoolIds = $onlineClass->school ?? [];
        $schools = School::whereIn('id', $schoolIds)
            ->with(['students' => function($query) {
                $query->where('status', 'active');
            }])
            ->get();

        return view('user.online-class.show', compact('course', 'onlineClass', 'schools'));
    }

    /**
     * Get students for selected schools (AJAX)
     */
    public function getStudents(Request $request)
    {
        $schoolIds = $request->input('school_ids', []);
        
        if (empty($schoolIds)) {
            return response()->json(['students' => []]);
        }

        $students = Student::whereIn('school_id', $schoolIds)
            ->where('status', 'active')
            ->with('school:id,name')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'ic' => $student->ic,
                    'school_name' => $student->school->name ?? 'N/A'
                ];
            });

        return response()->json(['students' => $students]);
    }

    /**
     * Gateway method to authenticate and authorize students before redirecting to meeting URL
     */
    public function joinClass($classId)
    {
        // Find the online class
        $onlineClass = OnlineClass::find($classId);
        
        if (!$onlineClass) {
            return redirect()->route('student.subjects.index')
                ->with('error', 'Online class not found.');
        }

        // Check if class is active
        if ($onlineClass->status !== 'active') {
            return redirect()->route('student.subjects.index')
                ->with('error', 'This online class is not active.');
        }

        // Check if user is authenticated as student
        if (!auth()->guard('student')->check()) {
            // Store the intended URL in session for redirect after login
            session()->put('url.intended', request()->url());
            
            return redirect()->route('login')
                ->with('error', 'You must login as a student to join this online class.');
        }

        $student = auth()->guard('student')->user();
        
        // Check if student's school is in the selected schools for this class
        $selectedSchoolIds = $onlineClass->school ?? [];
        
        if (!in_array($student->school_id, $selectedSchoolIds)) {
            return redirect()->route('student.subjects.index')
                ->with('error', 'You are not authorized to join this online class. Your school is not included in this session.');
        }

        // Check if student account is active
        if ($student->status !== 'active') {
            return redirect()->route('student.subjects.index')
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

        // All checks passed - redirect to the actual meeting URL
        return redirect()->away($onlineClass->url);
    }

    /**
     * Show join class page with student information
     */
    public function showJoinPage($classId)
    {
        $onlineClass = OnlineClass::find($classId);
        
        if (!$onlineClass) {
            return redirect()->route('login')
                ->with('error', 'Online class not found.');
        }

        // Check if class is active
        if ($onlineClass->status !== 'active') {
            return redirect()->route('login')
                ->with('error', 'This online class is not active.');
        }

        // If user is trying to access this page, store it as intended URL for login redirect
        if (!auth()->guard('student')->check()) {
            session()->put('url.intended', request()->url());
        }

        return view('student.online-class.join', compact('onlineClass'));
    }
} 