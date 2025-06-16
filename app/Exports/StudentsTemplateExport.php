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
        // Return a sample row to show expected format
        return collect([
            [
                'full_name' => 'Student Name',
                'email_address' => 'student@example.com',
                'ic_number' => '980123456789',  // Sample IC number
                'phone_number' => '0123456789', // Sample phone with leading zero
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
            'full_name',      // Use lowercase_with_underscores consistent with import validation
            'email_address',
            'ic_number',
            'phone_number',   // Added phone number column
        ];
    }
    
    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT, // ic_number column as text
            'D' => NumberFormat::FORMAT_TEXT, // phone_number column as text
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
                
                // Apply explicit DataType::TYPE_STRING to IC and phone number columns in the example row
                $sheet->getCell('C2')->setValueExplicit('980123456789', DataType::TYPE_STRING);
                $sheet->getCell('D2')->setValueExplicit('0123456789', DataType::TYPE_STRING);
                
                // Add data validation to ensure data entered is treated as text
                // Apply to IC column (column C) and phone column (column D)
                $icColumn = $sheet->getColumnDimension('C');
                $phoneColumn = $sheet->getColumnDimension('D');
                
                // Format the columns differently
                $sheet->getStyle('C:C')->getNumberFormat()->setFormatCode('@');
                $sheet->getStyle('D:D')->getNumberFormat()->setFormatCode('@');
                
                // Add a note explaining the format (optional)
                $sheet->getComment('C1')->getText()->createTextRun('Important: IC numbers must be entered as text to preserve all digits');
                $sheet->getComment('D1')->getText()->createTextRun('Important: Phone numbers must be entered as text to preserve leading zeros');
            },
        ];
    }
} 