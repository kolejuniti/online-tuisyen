<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Upload Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .download-options {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-download {
            margin: 0 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-download:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Error/Warning Messages -->
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Warning:</strong> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Error:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Download Options -->
        <div class="download-options">
            <h3 style="margin-bottom: 15px;">📥 Download Student Template</h3>
            <p style="margin-bottom: 20px;">Choose your preferred format to download the student upload template</p>
            
            <a href="{{ route('school.download-template') }}" class="btn-download">
                <i class="fas fa-file-excel"></i> Excel Template (Recommended)
            </a>
            
            <a href="{{ route('school.download-csv-template') }}" class="btn-download">
                <i class="fas fa-file-csv"></i> CSV Template (Alternative)
            </a>
            
            <div style="margin-top: 15px; font-size: 0.9rem; opacity: 0.9;">
                💡 If Excel download fails, use the CSV alternative or copy the table below
            </div>
        </div>

        <div class="instructions">
            <h2>📋 Student Upload Template Instructions</h2>
            <p><strong>How to use this template:</strong></p>
            <ol>
                <li>Fill in student information in the rows below the header</li>
                <li>Fields marked with <span class="required">*</span> are required</li>
                <li>Use the exact date format shown in the examples (YYYY-MM-DD)</li>
                <li>Tingkatan should be "Tingkatan 5" only</li>
                <li>Delete the sample rows before uploading</li>
                <li>Save as Excel format (.xlsx) when complete</li>
            </ol>
            <p><strong>⚠️ Important:</strong> Do not change the column headers or order</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Student Name <span class="required">*</span></th>
                    <th>IC Number <span class="required">*</span></th>
                    <th>Email <span class="optional">(Optional)</span></th>
                    <th>Tingkatan <span class="required">*</span></th>
                    <th>Student's Phone Number <span class="optional">(Optional)</span></th>
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
                    <td>Ahmad Bin Hassan</td>
                    <td>980123456789</td>
                    <td>ahmad.hassan@email.com</td>
                    <td>Tingkatan 5</td>
                    <td>012-345-6789</td>
                    <td>2008-05-15</td>
                    <td>Male</td>
                    <td>Hassan Bin Ali</td>
                    <td>012-345-6790</td>
                    <td>123 Jalan Utama, Kuala Lumpur 50000</td>
                </tr>
                <tr class="sample-row">
                    <td>Siti Binti Abdullah</td>
                    <td>010123456789</td>
                    <td>siti.abdullah@email.com</td>
                    <td>Tingkatan 5</td>
                    <td>012-345-6791</td>
                    <td>2009-03-22</td>
                    <td>Female</td>
                    <td>Fatimah Binti Omar</td>
                    <td>012-345-6792</td>
                    <td>456 Jalan Oak, Petaling Jaya 47300</td>
                </tr>
                <tr class="sample-row">
                    <td>Raj A/L Kumar</td>
                    <td>070810123456</td>
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
                <li><strong>Student Name:</strong> Student's full name (combine first and last name)</li>
                <li><strong>IC Number:</strong> Malaysian identity card number (12 digits)</li>
                <li><strong>Email:</strong> Student's email address (if available)</li>
                <li><strong>Tingkatan:</strong> Must be "Tingkatan 5" only</li>
                <li><strong>Student's Phone Number:</strong> Student's contact number</li>
                <li><strong>Date of Birth:</strong> Format: YYYY-MM-DD (e.g., 2008-05-15)</li>
                <li><strong>Gender:</strong> Male, Female, or Other</li>
                <li><strong>Parent/Guardian Name:</strong> Primary contact person</li>
                <li><strong>Parent/Guardian Phone:</strong> Emergency contact number</li>
                <li><strong>Address:</strong> Complete home address</li>
            </ul>
            
            <h3>✅ Validation Rules:</h3>
            <ul>
                <li>Student Name and IC Number are required</li>
                <li>IC Number must be 12 digits (format as text to preserve leading zeros)</li>
                <li>Tingkatan must be exactly "Tingkatan 5"</li>
                <li>Email must be in valid format (if provided)</li>
                <li>Phone numbers should include area codes and be formatted as text</li>
                <li>Date of Birth must be in YYYY-MM-DD format</li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
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