<?php

// Test Student Approval Email
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\StudentApprovalMail;
use App\Models\Student;

echo "Testing Student Approval Email...\n";
echo "=================================\n";

try {
    // Find a student to test with (or create a mock one)
    $student = Student::first();
    
    if (!$student) {
        echo "❌ No student found in database. Please create a test student first.\n";
        exit;
    }
    
    echo "📚 Testing with student: {$student->name} ({$student->email})\n";
    echo "🏫 School: " . ($student->school->name ?? 'N/A') . "\n";
    echo "📧 Sending approval email to: hafiyyaimann1998@gmail.com\n\n";
    
    // Send the actual approval email
    Mail::to('hafiyyaimann1998@gmail.com')->send(new StudentApprovalMail($student));
    
    echo "✅ SUCCESS: Student approval email sent successfully!\n";
    echo "📧 Check inbox for: 'Welcome! Your Student Account Has Been Approved'\n";
    echo "🔐 Email contains login credentials:\n";
    echo "   Username: {$student->email}\n";
    echo "   Password: password\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: Failed to send approval email\n";
    echo "Error message: " . $e->getMessage() . "\n";
}

echo "\n✅ Test completed!\n"; 