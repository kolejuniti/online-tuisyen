<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentRegistrationController extends Controller
{
    /**
     * Display the student registration form
     */
    public function show()
    {
        // Get all active schools for the dropdown
        $schools = School::where('status', 'inactive')
                        ->orderBy('name')
                        ->get(['id', 'name']);
        
        return view('guest.individual.register', compact('schools'));
    }

    /**
     * Handle the student registration form submission
     */
    public function submit(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email|max:255',
            'ic' => 'required|string|max:12|unique:students,ic',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'tingkatan' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'parent_guardian_name' => 'nullable|string|max:255',
            'parent_guardian_phone' => 'nullable|string|max:20',
            'school_id' => 'required|exists:schools,id',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:inactive', // Force status to be inactive
        ]);

        try {
            DB::beginTransaction();

            // Create the student record with inactive status
            $student = Student::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'ic' => $validatedData['ic'],
                'phone_number' => $validatedData['phone_number'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'gender' => $validatedData['gender'],
                'tingkatan' => $validatedData['tingkatan'],
                'address' => $validatedData['address'],
                'parent_guardian_name' => $validatedData['parent_guardian_name'],
                'parent_guardian_phone' => $validatedData['parent_guardian_phone'],
                'school_id' => $validatedData['school_id'],
                'password' => Hash::make($validatedData['password']),
                'status' => 'inactive', // Set to inactive for approval
            ]);

            Log::info("Created student registration for approval: {$student->id}");

            DB::commit();

            $message = "Registration submitted successfully! Your account has been created with inactive status and is pending approval. You will receive an email notification once your account is approved and you can start accessing the platform.";

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Student registration failed: " . $e->getMessage());
            
            return redirect()->back()
                   ->withErrors(['error' => 'Registration failed. Please try again or contact support.'])
                   ->withInput();
        }
    }

    /**
     * AJAX endpoint to search schools (optional)
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