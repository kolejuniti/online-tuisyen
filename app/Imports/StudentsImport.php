<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;
use Throwable;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithStartRow
{
    use SkipsFailures;

    private $schoolId;
    private $defaultStatus = 'active'; // Default status for imported students
    private $defaultPassword = 'password'; // Default password
    private $rowCount = 0;
    private $headersLogged = false;

    public function __construct(int $schoolId)
    {
        $this->schoolId = $schoolId;
        Log::info("StudentsImport initialized with school_id: {$schoolId}");
    }

    public function startRow(): int
    {
        return 2; // Start from row 2 (after headers)
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->rowCount++;

        // Log headers on first row to see exact mapping
        if (!$this->headersLogged) {
            Log::info("CSV Headers received: " . json_encode(array_keys($row)));
            $this->headersLogged = true;
        }

        Log::info("Processing row {$this->rowCount}: " . json_encode($row));

        // Check if row is empty
        if (empty(array_filter($row))) {
            Log::info("Skipping empty row {$this->rowCount}");
            return null;
        }

        try {
            // Map spreadsheet headings (lowercase, underscores) to row data
            $name = $row['student_name'] ?? null;
            $email = $row['email'] ?? null;
            
            Log::info("Extracted data - Name: {$name}, Email: {$email}");
            
            if (empty($name) || empty($email)) {
                Log::warning("Missing required fields - Name: {$name}, Email: {$email}");
                return null;
            }
            
            // Handle IC number - convert from scientific notation if needed and remove Excel formula formatting
            $ic = $row['ic_number'] ?? null;
            if ($ic) {
                // Remove Excel formula formatting if present (="value")
                if (is_string($ic) && str_starts_with($ic, '="') && str_ends_with($ic, '"')) {
                    $ic = substr($ic, 2, -1); // Remove =" from start and " from end
                }
                
                // Check if it's in scientific notation (contains 'E' or 'e')
                if (is_numeric($ic) && (strpos((string)$ic, 'E') !== false || strpos((string)$ic, 'e') !== false)) {
                    // Convert scientific notation to a full number string
                    $ic = number_format($ic, 0, '', '');
                } else {
                    // Ensure it's a string
                    $ic = (string)$ic;
                }
            }
            
            Log::info("Processed IC: {$ic}");
            
            // Handle new fields
            $tingkatan = $row['tingkatan'] ?? null;
            $dateOfBirth = $row['date_of_birth'] ?? null;
            $gender = $row['gender'] ?? null;
            $parentGuardianName = $row['parentguardian_name'] ?? $row['parent_guardian_name'] ?? null;
            $address = $row['address'] ?? null;
            
            // Ensure phone number is treated as a string and handle leading zeros
            $phoneNumber = null;
            if (isset($row['students_phone_number']) && !empty($row['students_phone_number'])) {
                $phoneNumber = $row['students_phone_number'];
                
                // Remove Excel formula formatting if present (="value")
                if (is_string($phoneNumber) && str_starts_with($phoneNumber, '="') && str_ends_with($phoneNumber, '"')) {
                    $phoneNumber = substr($phoneNumber, 2, -1); // Remove =" from start and " from end
                }
                
                // Check if phone number is in scientific notation
                if (is_numeric($phoneNumber) && (strpos((string)$phoneNumber, 'E') !== false || strpos((string)$phoneNumber, 'e') !== false)) {
                    // Convert scientific notation to a full number string
                    $phoneNumber = number_format($phoneNumber, 0, '', '');
                } else {
                    // Ensure it's a string
                    $phoneNumber = (string)$phoneNumber;
                }
                
                // Add leading zero if missing and not empty
                if (!empty($phoneNumber) && !str_starts_with($phoneNumber, '0')) {
                    $phoneNumber = '0' . $phoneNumber;
                }
            }
            
            // Handle parent/guardian phone number
            $parentGuardianPhone = null;
            if ((isset($row['parentguardian_phone']) && !empty($row['parentguardian_phone'])) || (isset($row['parent_guardian_phone']) && !empty($row['parent_guardian_phone']))) {
                $parentGuardianPhone = $row['parentguardian_phone'] ?? $row['parent_guardian_phone'];
                
                // Remove Excel formula formatting if present (="value")
                if (is_string($parentGuardianPhone) && str_starts_with($parentGuardianPhone, '="') && str_ends_with($parentGuardianPhone, '"')) {
                    $parentGuardianPhone = substr($parentGuardianPhone, 2, -1); // Remove =" from start and " from end
                }
                
                // Check if phone number is in scientific notation
                if (is_numeric($parentGuardianPhone) && (strpos((string)$parentGuardianPhone, 'E') !== false || strpos((string)$parentGuardianPhone, 'e') !== false)) {
                    // Convert scientific notation to a full number string
                    $parentGuardianPhone = number_format($parentGuardianPhone, 0, '', '');
                } else {
                    // Ensure it's a string
                    $parentGuardianPhone = (string)$parentGuardianPhone;
                }
                
                // Add leading zero if missing and not empty
                if (!empty($parentGuardianPhone) && !str_starts_with($parentGuardianPhone, '0')) {
                    $parentGuardianPhone = '0' . $parentGuardianPhone;
                }
            }

            $studentData = [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($this->defaultPassword),
                'school_id' => $this->schoolId,
                'ic' => $ic,
                'phone_number' => $phoneNumber,
                'status' => $this->defaultStatus,
                'tingkatan' => $tingkatan,
                'date_of_birth' => $dateOfBirth,
                'gender' => $gender,
                'parent_guardian_name' => $parentGuardianName,
                'parent_guardian_phone' => $parentGuardianPhone,
                'address' => $address,
            ];

            Log::info("Attempting to create student with data: " . json_encode($studentData));

            // Create Student directly - no separate User model
            $student = Student::create($studentData);

            Log::info("Successfully created student with ID: {$student->id} for email: {$email}");
            return $student; // Return the created student model

        } catch (Throwable $e) {
            Log::error("Failed to import student row {$this->rowCount}: " . json_encode($row) . " Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            // Re-throw the exception so it's properly handled by Laravel Excel
            // This will cause the entire import to fail if any row fails
            throw $e;
        }
    }

    /**
     * Define validation rules for each row.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            // Use lowercase and underscores for heading keys (Excel headers will be converted to lowercase with underscores)
            'student_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email',
            'ic_number' => 'required|string|max:20|unique:students,ic',
            'tingkatan' => 'required|string|max:255',
            'students_phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'parentguardian_name' => 'required|string|max:255',
            'parentguardian_phone' => 'nullable|string|max:20',
            'address' => 'required|string',
        ];

        Log::info("Validation rules: " . json_encode($rules));
        return $rules;
    }

    /**
     * Custom validation messages.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'email.unique' => 'The email address has already been taken.',
            'ic_number.unique' => 'The IC number has already been taken.',
        ];
    }
} 