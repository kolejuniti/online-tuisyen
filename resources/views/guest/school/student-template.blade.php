<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Upload Template</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .sample-row {
            background-color: #f9f9f9;
            color: #666;
            font-style: italic;
        }
        .instructions {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .required {
            color: red;
            font-weight: bold;
        }
        .optional {
            color: #888;
        }
    </style>
</head>
<body>
    <div class="instructions">
        <h2>📋 Student Upload Template Instructions</h2>
        <p><strong>How to use this template:</strong></p>
        <ol>
            <li>Fill in student information in the rows below the header</li>
            <li>Fields marked with <span class="required">*</span> are required</li>
            <li>Use the exact date format shown in the examples (YYYY-MM-DD)</li>
            <li>Tingkatan/Darjah should use Malaysian education levels (Darjah 1-6, Tingkatan 1-6)</li>
            <li>Delete the sample rows before uploading</li>
            <li>Save as Excel format (.xlsx) when complete</li>
        </ol>
        <p><strong>⚠️ Important:</strong> Do not change the column headers or order</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>First Name <span class="required">*</span></th>
                <th>Last Name <span class="required">*</span></th>
                <th>Email <span class="optional">(Optional)</span></th>
                <th>Tingkatan/Darjah <span class="required">*</span></th>
                <th>Phone <span class="optional">(Optional)</span></th>
                <th>Date of Birth <span class="optional">(Optional)</span></th>
                <th>Gender <span class="optional">(Optional)</span></th>
                <th>Parent/Guardian Name <span class="optional">(Optional)</span></th>
                <th>Parent/Guardian Phone <span class="optional">(Optional)</span></th>
                <th>Address <span class="optional">(Optional)</span></th>
            </tr>
        </thead>
        <tbody>
            <!-- Sample Data Rows -->
            <tr class="sample-row">
                <td>Ahmad</td>
                <td>Bin Hassan</td>
                <td>ahmad.hassan@email.com</td>
                <td>Tingkatan 4</td>
                <td>012-345-6789</td>
                <td>2008-05-15</td>
                <td>Male</td>
                <td>Hassan Bin Ali</td>
                <td>012-345-6790</td>
                <td>123 Jalan Utama, Kuala Lumpur 50000</td>
            </tr>
            <tr class="sample-row">
                <td>Siti</td>
                <td>Binti Abdullah</td>
                <td>siti.abdullah@email.com</td>
                <td>Darjah 5</td>
                <td>012-345-6791</td>
                <td>2009-03-22</td>
                <td>Female</td>
                <td>Fatimah Binti Omar</td>
                <td>012-345-6792</td>
                <td>456 Jalan Oak, Petaling Jaya 47300</td>
            </tr>
            <tr class="sample-row">
                <td>Raj</td>
                <td>A/L Kumar</td>
                <td>raj.kumar@email.com</td>
                <td>Tingkatan 5</td>
                <td>012-345-6793</td>
                <td>2007-08-10</td>
                <td>Male</td>
                <td>Kumar A/L Raman</td>
                <td>012-345-6794</td>
                <td>789 Jalan Pine, Subang Jaya 47500</td>
            </tr>
            <!-- Empty rows for schools to fill -->
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!-- Add more empty rows as needed -->
        </tbody>
    </table>

    <div class="instructions" style="margin-top: 20px;">
        <h3>📝 Field Descriptions:</h3>
        <ul>
            <li><strong>First Name & Last Name:</strong> Student's full name</li>
            <li><strong>Email:</strong> Student's email address (if available)</li>
            <li><strong>Tingkatan/Darjah:</strong> Malaysian education levels - Darjah 1-6 (Primary), Tingkatan 1-6 (Secondary)</li>
            <li><strong>Phone:</strong> Student's contact number</li>
            <li><strong>Date of Birth:</strong> Format: YYYY-MM-DD (e.g., 2008-05-15)</li>
            <li><strong>Gender:</strong> Male, Female, or Other</li>
            <li><strong>Parent/Guardian Name:</strong> Primary contact person</li>
            <li><strong>Parent/Guardian Phone:</strong> Emergency contact number</li>
            <li><strong>Address:</strong> Complete home address</li>
        </ul>
        
        <h3>✅ Validation Rules:</h3>
        <ul>
            <li>First Name and Last Name are required</li>
            <li>Tingkatan/Darjah must be valid Malaysian education level (Darjah 1-6 or Tingkatan 1-6)</li>
            <li>Email must be in valid format (if provided)</li>
            <li>Phone numbers should include country/area codes</li>
            <li>Date of Birth must be in YYYY-MM-DD format</li>
        </ul>
    </div>

    <script>
        // This script can be used to automatically download the template as Excel
        function downloadAsExcel() {
            const table = document.querySelector('table');
            const workbook = XLSX.utils.table_to_book(table);
            XLSX.writeFile(workbook, 'student_upload_template.xlsx');
        }
    </script>
</body>
</html> 