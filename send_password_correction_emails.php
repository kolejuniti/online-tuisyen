<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Mail\StudentPasswordCorrectionMail;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

// Bootstrap Laravel
$kernel->bootstrap();

// Simple CLI guard
if (php_sapi_name() !== 'cli') {
    echo "This script must be run from the command line." . PHP_EOL;
    exit(1);
}

echo "Starting password correction email dispatch..." . PHP_EOL;

$query = Student::with('school')->where('status', 'active');
$total = $query->count();

if ($total === 0) {
    echo "No active students found. Nothing to send." . PHP_EOL;
    exit(0);
}

echo "Found {$total} active students. Sending emails..." . PHP_EOL;

$sent = 0;
$failed = 0;

$query->chunk(200, function ($students) use (&$sent, &$failed) {
    foreach ($students as $student) {
        try {
            Mail::to($student->email)->send(new StudentPasswordCorrectionMail($student));
            $sent++;
            echo "[SENT] {$student->email}\n";
        } catch (\Throwable $e) {
            $failed++;
            echo "[FAIL] {$student->email} => " . $e->getMessage() . "\n";
        }
    }
});

echo PHP_EOL . "Done. Sent: {$sent}, Failed: {$failed}" . PHP_EOL;

exit(0);


