<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SchoolRegistrationController extends Controller
{
    /**
     * Display the school registration form
     */
    public function show()
    {
        // Get all inactive schools for the dropdown
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
            'students.*.name' => 'required_with:students|string|max:255',
            'students.*.ic_number' => 'required_with:students|string|max:12',
            'students.*.email' => 'nullable|email|max:255',
            'students.*.phone' => 'nullable|string|max:20',
            'students.*.grade' => 'required_with:students|string|in:form5',
        ]);

        // Additional validation: Ensure at least one method of adding students is provided
        if (empty($validatedData['students']) && !$request->hasFile('students_excel')) {
            return redirect()->back()
                   ->withErrors(['error' => 'Please add students either individually or by uploading an Excel file.'])
                   ->withInput();
        }

        try {
            DB::beginTransaction();

            // Find and update the school
            $school = School::findOrFail($validatedData['school_id']);
            
            // Update school details
            $school->update([
                'email' => $validatedData['school_email'],
                'phone' => $validatedData['phone'],
                'type' => $validatedData['school_type'],
                'address' => $validatedData['address'],
                'total_students' => $validatedData['total_students'],
                'teacher_name' => $validatedData['teacher_name'],
                'teacher_email' => $validatedData['teacher_email'],
                'status' => 'active', // Change status from inactive to active
            ]);

            Log::info("Updated school {$school->id} to active status");

            $studentsCreated = 0;

            // Process individual students from form
            if (!empty($validatedData['students'])) {
                foreach ($validatedData['students'] as $studentData) {
                    $this->createStudent($studentData, $school->id);
                    $studentsCreated++;
                }
                Log::info("Created {$studentsCreated} individual students for school {$school->id}");
            }

            // Process Excel file if uploaded
            if ($request->hasFile('students_excel')) {
                try {
                    $import = new StudentsImport($school->id);
                    Excel::import($import, $request->file('students_excel'));
                    
                    // Get the number of students created from Excel
                    $excelStudentsCount = Student::where('school_id', $school->id)
                                                ->where('created_at', '>=', now()->subMinutes(5))
                                                ->count() - $studentsCreated;
                    
                    Log::info("Successfully imported {$excelStudentsCount} students from Excel for school {$school->id}");
                    $studentsCreated += $excelStudentsCount;
                } catch (\Exception $e) {
                    Log::error("Excel import failed for school {$school->id}: " . $e->getMessage());
                    throw $e;
                }
            }

            DB::commit();

            $message = "Registration submitted successfully! School has been activated";
            if ($studentsCreated > 0) {
                $message .= " and {$studentsCreated} students have been added";
            }
            $message .= ". You will receive a confirmation email shortly.";

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("School registration failed: " . $e->getMessage());
            
            return redirect()->back()
                   ->withErrors(['error' => 'Registration failed. Please try again or contact support.'])
                   ->withInput();
        }
    }

    /**
     * Create a new student record
     */
    private function createStudent(array $studentData, int $schoolId)
    {
        // Generate a default password (you can customize this)
        $defaultPassword = 'student123'; // You might want to generate a random password

        $student = Student::create([
            'name' => $studentData['name'],
            'ic' => $studentData['ic_number'],
            'email' => $studentData['email'] ?? null,
            'phone_number' => $studentData['phone'] ?? null,
            'tingkatan' => $studentData['grade'],
            'school_id' => $schoolId,
            'password' => Hash::make($defaultPassword),
            'status' => 'active',
        ]);

        Log::info("Created student {$student->id} for school {$schoolId}");
        return $student;
    }

    /**
     * Download the Excel template for student bulk upload
     */
    public function downloadTemplate()
    {
        try {
            // Use the same export class as admin
            $export = new \App\Exports\StudentsTemplateExport();
            
            return \Maatwebsite\Excel\Facades\Excel::download($export, 'student_template.xlsx');
        } catch (\Exception $e) {
            // Fallback to template view if Excel generation fails
            return redirect()->route('school.student-template');
        }
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