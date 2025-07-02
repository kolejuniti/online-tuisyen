<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolRegistrationController extends Controller
{
    /**
     * Display the school registration form
     */
    public function show()
    {
        // Get all active schools for the dropdown
        $schools = School::where('status', 'inactive')
                        ->orderBy('name')
                        ->get(['id', 'name']);
        
        return view('guest.school.register', compact('schools'));
    }

    /**
     * Handle the school registration form submission
     */
    public function submit(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'school_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'school_type' => 'required|in:public,private,charter,international',
            'address' => 'required|string',
            'total_students' => 'nullable|integer|min:1',
            'teacher_name' => 'required|string|max:255',
            'teacher_email' => 'required|email|max:255',
            'students_excel' => 'nullable|file|mimes:xlsx,xls|max:10240', // 10MB max
            'students' => 'nullable|array',
            'students.*.first_name' => 'required_with:students|string|max:255',
            'students.*.last_name' => 'required_with:students|string|max:255',
            'students.*.email' => 'nullable|email|max:255',
            'students.*.grade' => 'required_with:students|string|in:darjah1,darjah2,darjah3,darjah4,darjah5,darjah6,form1,form2,form3,form4,form5,form6',
        ]);

        // Process the registration data
        // TODO: Implement registration logic (save to database, send emails, etc.)
        
        return redirect()->back()->with('success', 'Registration submitted successfully! We will review your application and contact you soon.');
    }

    /**
     * Download the Excel template for student bulk upload
     */
    public function downloadTemplate()
    {
        // TODO: Generate and return actual Excel file
        return redirect()->route('school.student-template');
    }

    /**
     * AJAX endpoint to search schools
     */
    public function searchSchools(Request $request)
    {
        $search = $request->get('q');
        
        $schools = School::where('status', 'inactive')
                        ->where('name', 'LIKE', "%{$search}%")
                        ->orderBy('name')
                        ->limit(20)
                        ->get(['id', 'name']);
        
        return response()->json($schools);
    }
} 