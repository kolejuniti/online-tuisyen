<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class StudentsTemplateExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Return sample rows to show expected format
        return collect([
            [
                'student_name' => 'Ahmad Bin Hassan',
                'ic_number' => '980123456789',  // Sample IC number
                'email' => 'ahmad.hassan@email.com',
                'tingkatan' => 'Tingkatan 5',
                'students_phone_number' => '0123456789', // Sample phone with leading zero
                'date_of_birth' => '2008-05-15',
                'gender' => 'Male',
                'parent_guardian_name' => 'Hassan Bin Ali',
                'parent_guardian_phone' => '0123456790',
                'address' => '123 Jalan Utama, Kuala Lumpur 50000',
            ],
            [
                'student_name' => 'Siti Binti Abdullah',
                'ic_number' => '010123456789',
                'email' => 'siti.abdullah@email.com',
                'tingkatan' => 'Tingkatan 5',
                'students_phone_number' => '0187654321',
                'date_of_birth' => '2009-03-22',
                'gender' => 'Female',
                'parent_guardian_name' => 'Fatimah Binti Omar',
                'parent_guardian_phone' => '0123456792',
                'address' => '456 Jalan Oak, Petaling Jaya 47300',
            ]
        ]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Define the column headers required for student import
        return [
            'Student Name',      
            'IC Number',
            'Email',
            'Tingkatan',
            'Student\'s Phone Number',
            'Date of Birth',
            'Gender',
            'Parent/Guardian Name',
            'Parent/Guardian Phone',
            'Address',
        ];
    }
    
    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // ic_number column as text
            'E' => NumberFormat::FORMAT_TEXT, // student_phone_number column as text
            'I' => NumberFormat::FORMAT_TEXT, // parent_guardian_phone column as text
        ];
    }
    
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Get worksheet
                $sheet = $event->sheet->getDelegate();
                
                // Apply explicit DataType::TYPE_STRING to IC and phone number columns in the example rows
                $sheet->getCell('B2')->setValueExplicit('980123456789', DataType::TYPE_STRING);
                $sheet->getCell('E2')->setValueExplicit('0123456789', DataType::TYPE_STRING);
                $sheet->getCell('I2')->setValueExplicit('0123456790', DataType::TYPE_STRING);
                
                $sheet->getCell('B3')->setValueExplicit('010123456789', DataType::TYPE_STRING);
                $sheet->getCell('E3')->setValueExplicit('0187654321', DataType::TYPE_STRING);
                $sheet->getCell('I3')->setValueExplicit('0123456792', DataType::TYPE_STRING);
                
                // Format the columns as text
                $sheet->getStyle('B:B')->getNumberFormat()->setFormatCode('@'); // IC Number
                $sheet->getStyle('E:E')->getNumberFormat()->setFormatCode('@'); // Student's Phone Number
                $sheet->getStyle('I:I')->getNumberFormat()->setFormatCode('@'); // Parent/Guardian Phone
                
                // Add comments explaining the format
                $sheet->getComment('B1')->getText()->createTextRun('Important: IC numbers must be entered as text to preserve all digits');
                $sheet->getComment('E1')->getText()->createTextRun('Important: Phone numbers must be entered as text to preserve leading zeros');
                $sheet->getComment('I1')->getText()->createTextRun('Important: Phone numbers must be entered as text to preserve leading zeros');
            },
        ];
    }
} 