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
            // Log the start of download attempt
            Log::info('Guest template download started', [
                'memory_usage' => \memory_get_usage(true),
                'memory_limit' => \ini_get('memory_limit'),
                'max_execution_time' => \ini_get('max_execution_time')
            ]);

            // Check if the class exists
            if (!\class_exists('App\Exports\StudentsTemplateExport')) {
                Log::error('StudentsTemplateExport class does not exist');
                return $this->fallbackToHtmlTemplate('Export class not found');
            }

            // Check if maatwebsite/excel is properly installed
            if (!\class_exists('Maatwebsite\Excel\Facades\Excel')) {
                Log::error('Laravel Excel package not found');
                return $this->fallbackToHtmlTemplate('Excel package not available - please install maatwebsite/excel');
            }

            // Check required PHP extensions
            $missingExtensions = [];
            $requiredExtensions = ['zip', 'xml', 'mbstring'];
            foreach ($requiredExtensions as $ext) {
                if (!\extension_loaded($ext)) {
                    $missingExtensions[] = $ext;
                }
            }

            if (!empty($missingExtensions)) {
                Log::error('Missing PHP extensions: ' . \implode(', ', $missingExtensions));
                return $this->fallbackToHtmlTemplate('Missing PHP extensions: ' . \implode(', ', $missingExtensions));
            }

            // Try to create the export instance
            $export = new \App\Exports\StudentsTemplateExport();
            Log::info('Export instance created successfully');

            // Set memory limit temporarily for large exports
            $originalMemoryLimit = \ini_get('memory_limit');
            \ini_set('memory_limit', '1024M'); // Increased to 1GB
            
            // Set execution time limit
            \set_time_limit(300); // Increased to 5 minutes
            
            // Disable output buffering to prevent memory issues
            if (\ob_get_level()) {
                \ob_end_clean();
            }

            // Generate the download with proper error handling
            Log::info('Starting Excel download generation');
            
            $result = \Maatwebsite\Excel\Facades\Excel::download($export, 'student_template.xlsx');
            
            // Restore original memory limit
            \ini_set('memory_limit', $originalMemoryLimit);
            
            Log::info('Guest template download completed successfully');
            
            return $result;

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            Log::error('PhpSpreadsheet error in guest template download', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->fallbackToHtmlTemplate('Spreadsheet generation failed: ' . $e->getMessage());
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Log::error('Excel validation error in guest template download', [
                'error' => $e->getMessage(),
                'failures' => $e->failures()
            ]);
            
            return $this->fallbackToHtmlTemplate('Excel validation failed: ' . $e->getMessage());
            
        } catch (\Exception $e) {
            Log::error('General error in guest template download', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return $this->fallbackToHtmlTemplate('Template download failed: ' . $e->getMessage());
            
        } catch (\Throwable $e) {
            Log::error('Fatal error in guest template download', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
                'memory_usage' => \memory_get_usage(true),
                'memory_peak' => \memory_get_peak_usage(true)
            ]);
            
            // Also log to PHP error log for easier debugging
            \error_log('Excel Template Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            
            return $this->fallbackToHtmlTemplate('Fatal error: ' . $e->getMessage());
        }
    }

    /**
     * Fallback method when Excel generation fails
     */
    private function fallbackToHtmlTemplate($errorMessage = null)
    {
        Log::info('Falling back to HTML template view');
        
        // Add flash message about the issue
        $message = 'Excel template generation is currently unavailable. ';
        $message .= 'Please use the HTML template below or contact support. ';
        if ($errorMessage) {
            $message .= 'Technical details: ' . $errorMessage;
        }
        
        return redirect()->route('school.student-template')
                        ->with('warning', $message);
    }

    /**
     * Download CSV template as alternative
     */
    public function downloadCsvTemplate()
    {
        try {
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="students_template.csv"',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
                'Pragma' => 'public',
            ];

            // Create CSV content with proper formatting to preserve leading zeros
            $csvData = '';
            
            // Add BOM for UTF-8 encoding to ensure proper display in Excel
            $csvData .= "\xEF\xBB\xBF";
            
            // Add headers
            $csvData .= "Student Name,IC Number,Email,Tingkatan,Student's Phone Number,Date of Birth,Gender,Parent/Guardian Name,Parent/Guardian Phone,Address\n";
            
            // Add sample data
            $csvData .= "\"Ahmad Bin Hassan\",\"980123456789\",\"ahmad.hassan@email.com\",\"Tingkatan 5\",\"0123456789\",\"2008-05-15\",\"Male\",\"Hassan Bin Ali\",\"0123456790\",\"123 Jalan Utama, Kuala Lumpur 50000\"\n";
            $csvData .= "\"Siti Binti Abdullah\",\"010123456789\",\"siti.abdullah@email.com\",\"Tingkatan 5\",\"0187654321\",\"2009-03-22\",\"Female\",\"Fatimah Binti Omar\",\"0123456792\",\"456 Jalan Oak, Petaling Jaya 47300\"\n";

            return response($csvData, 200, $headers);

        } catch (\Exception $e) {
            Log::error('CSV template download failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('school.student-template')
                           ->with('error', 'CSV template download failed: ' . $e->getMessage());
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