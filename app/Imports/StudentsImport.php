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
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;
use Throwable;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    private $schoolId;
    private $defaultStatus = 'active'; // Default status for imported students
    private $defaultPassword = 'password'; // Default password

    public function __construct(int $schoolId)
    {
        $this->schoolId = $schoolId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Note: Validation rules below handle missing/invalid data before this point.
        // This runs inside a DB transaction handled by the controller.

        try {
            DB::beginTransaction();

            // Map spreadsheet headings (lowercase, underscores) to row data
            $name = $row['full_name'];
            $email = $row['email_address'];
            
            // Handle IC number - convert from scientific notation if needed
            $ic = $row['ic_number'];
            // Check if it's in scientific notation (contains 'E' or 'e')
            if (is_numeric($ic) && (strpos((string)$ic, 'E') !== false || strpos((string)$ic, 'e') !== false)) {
                // Convert scientific notation to a full number string
                $ic = number_format($ic, 0, '', '');
            } else {
                // Ensure it's a string
                $ic = (string)$ic;
            }
            
            // Ensure phone number is treated as a string and handle leading zeros
            $phoneNumber = null;
            if (isset($row['phone_number']) && !empty($row['phone_number'])) {
                $phoneNumber = $row['phone_number'];
                
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

            // Create Student directly - no separate User model
            $student = Student::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($this->defaultPassword),
                'school_id' => $this->schoolId,
                'ic' => $ic,
                'phone_number' => $phoneNumber,
                'status' => $this->defaultStatus,
            ]);

            DB::commit();
            Log::info("Successfully imported student: {$email}");
            return $student; // Return the created student model

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Failed to import student row: " . json_encode($row) . " Error: " . $e->getMessage());
            // Create a Failure object to report the error
            $failure = new Failure(
                count($this->failures) + 1, // Approximate row number
                'database_error', // Attribute
                ['Could not save student data: ' . $e->getMessage()], // Error message
                $row // Original row data
            );
            $this->failures[] = $failure;
            return null; // Skip this model creation
        }
    }

    /**
     * Define validation rules for each row.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // Use lowercase and underscores for heading keys
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:students,email',
            'ic_number' => 'required|string|max:20|unique:students,ic',
            'phone_number' => 'nullable|string|max:20', // Added phone number validation
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'email_address.unique' => 'The email address has already been taken.',
            'ic_number.unique' => 'The IC number has already been taken.',
        ];
    }
} 