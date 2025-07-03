<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsTemplateExport;
use App\Imports\StudentsImport;
use Exception;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('school')->get(); // Eager load school relationship
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::orderBy('name')->get();
        return view('admin.students.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email',
            'ic' => 'required|string|max:20|unique:students,ic',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'school_id' => 'required|exists:schools,id',
            'status' => 'required|in:active,inactive',
            'tingkatan' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'parent_guardian_name' => 'nullable|string|max:255',
            'parent_guardian_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // Create Student
            $student = new Student();
            $student->name= $request->name;
            $student->email= $request->email;
            $student->password= Hash::make($request->password);
            $student->school_id = $request->school_id;
            $student->ic = $request->ic;
            $student->phone_number = $request->phone_number;
            $student->status = $request->status;
            $student->tingkatan = $request->tingkatan;
            $student->date_of_birth = $request->date_of_birth;
            $student->gender = $request->gender;
            $student->parent_guardian_name = $request->parent_guardian_name;
            $student->parent_guardian_phone = $request->parent_guardian_phone;
            $student->address = $request->address;
            $student->save();

            DB::commit();

            return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            // Log the error message
            Log::error('Student creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Student creation failed. Please try again. Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $schools = School::where('status', 'active')->get();
        return view('admin.students.edit', compact('student', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
            'ic' => 'required|string|max:20|unique:students,ic,' . $student->id,
            'phone_number' => 'nullable|string|max:20',
            'school_id' => 'required|exists:schools,id',
            'status' => 'required|in:active,inactive',
            'tingkatan' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'parent_guardian_name' => 'nullable|string|max:255',
            'parent_guardian_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Prepare data for update, excluding password if not provided
        $updateData = $validatedData;
        if (empty($validatedData['password'])) {
            unset($updateData['password']); // Don't update password if empty
        } else {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        // Manually set phone number since it's in $fillable
        // $updateData['phone_number'] = $request->phone_number; // No, $validatedData includes it already

        $student->update($updateData);

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return redirect()->route('admin.students.index')
                             ->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            // Handle potential errors, e.g., foreign key constraints
            return redirect()->route('admin.students.index')
                             ->with('error', 'Could not delete student. It might be associated with other records.');
        }
    }

    /**
     * Display the bulk student creation form.
     */
    public function bulkCreate()
    {
        $schools = School::orderBy('name')->get();
        // We'll create this view next
        return view('admin.students.bulk-create', compact('schools'));
    }

    /**
     * Handle the bulk student upload.
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'student_file' => 'required|file|mimes:xlsx,xls,csv', // Validate file type
        ]);

        $schoolId = $request->input('school_id');
        $file = $request->file('student_file');

        Log::info('Starting bulk student import', [
            'school_id' => $schoolId,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType()
        ]);

        // Get count before import
        $countBefore = Student::count();
        Log::info("Student count before import: {$countBefore}");

        try {
            // We need to create this Import class
            // It will handle validation and creation within the import process
            Excel::import(new StudentsImport($schoolId), $file);

            // Get count after import
            $countAfter = Student::count();
            $studentsAdded = $countAfter - $countBefore;
            Log::info("Student count after import: {$countAfter}, Students added: {$studentsAdded}");

            return redirect()->route('admin.students.index')->with('success', "Students imported successfully. {$studentsAdded} students were added.");

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             Log::error('Import validation failed', ['failures' => $failures]);
             // Handle validation failures, e.g., return them back to the view
             // You might want to format these errors nicely
             $errorMessages = [];
             foreach ($failures as $failure) {
                 $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
             }
             return redirect()->back()->with('error', 'Import failed. Please check the following errors: <br>' . implode('<br>', $errorMessages))->withInput();
        } catch (Exception $e) {
            Log::error('Bulk student import failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'An unexpected error occurred during import. Please check the file format and data. Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Download the Excel template for bulk student upload.
     */
    public function downloadTemplate()
    {
        try {
            // Log the start of download attempt
            Log::info('Template download started', [
                'user_id' => Auth::id(),
                'memory_usage' => \memory_get_usage(true),
                'memory_limit' => \ini_get('memory_limit'),
                'max_execution_time' => \ini_get('max_execution_time')
            ]);

            // Check if the class exists
            if (!\class_exists('App\Exports\StudentsTemplateExport')) {
                Log::error('StudentsTemplateExport class does not exist');
                return response()->json(['error' => 'Export class not found'], 500);
            }

            // Check if maatwebsite/excel is properly installed
            if (!\class_exists('Maatwebsite\Excel\Facades\Excel')) {
                Log::error('Laravel Excel package not found');
                return response()->json(['error' => 'Excel package not available'], 500);
            }

            // Try to create the export instance
            $export = new StudentsTemplateExport();
            Log::info('Export instance created successfully');

            // Set memory limit temporarily for large exports
            $originalMemoryLimit = \ini_get('memory_limit');
            \ini_set('memory_limit', '512M');
            
            // Set execution time limit
            \set_time_limit(120);

            // Generate the download with proper error handling
            Log::info('Starting Excel download generation');
            
            $result = Excel::download($export, 'students_template.xlsx');
            
            // Restore original memory limit
            \ini_set('memory_limit', $originalMemoryLimit);
            
            Log::info('Template download completed successfully');
            
            return $result;

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            Log::error('PhpSpreadsheet error in template download', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Spreadsheet generation failed: ' . $e->getMessage()
            ], 500);
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Log::error('Excel validation error in template download', [
                'error' => $e->getMessage(),
                'failures' => $e->failures()
            ]);
            
            return response()->json([
                'error' => 'Excel validation failed: ' . $e->getMessage()
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('General error in template download', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'error' => 'Template download failed: ' . $e->getMessage()
            ], 500);
            
        } catch (\Throwable $e) {
            Log::error('Fatal error in template download', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Fatal error occurred during template download'
            ], 500);
        }
    }

    /**
     * Download a simple CSV template as fallback
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
            
            // Add sample data - IC numbers and phone numbers as regular text
            // Important: Users should format IC Number and phone number columns as 'Text' in Excel to preserve leading zeros
            $csvData .= "\"Ahmad Bin Hassan\",\"980123456789\",\"ahmad.hassan@email.com\",\"Tingkatan 5\",\"0123456789\",\"2008-05-15\",\"Male\",\"Hassan Bin Ali\",\"0123456790\",\"123 Jalan Utama, Kuala Lumpur 50000\"\n";
            
            // Add additional examples to show different formats
            $csvData .= "\"Siti Binti Abdullah\",\"010123456789\",\"siti.abdullah@email.com\",\"Tingkatan 5\",\"0187654321\",\"2009-03-22\",\"Female\",\"Fatimah Binti Omar\",\"0123456792\",\"456 Jalan Oak, Petaling Jaya 47300\"\n";

            return response($csvData, 200, $headers);

        } catch (\Exception $e) {
            Log::error('CSV template download failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'CSV template download failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
