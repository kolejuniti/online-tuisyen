<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StudentApplicationController extends Controller
{
    /**
     * Display a listing of pending student applications.
     */
    public function index()
    {
        $applications = Student::with('school')
                              ->where('status', 'inactive')
                              ->orderBy('created_at', 'desc')
                              ->get();
        
        return view('admin.student-applications.index', compact('applications'));
    }

    /**
     * Show the specified student application.
     */
    public function show(Student $application)
    {
        // Only show inactive (pending) applications
        if ($application->status !== 'inactive') {
            return redirect()->route('admin.student-applications.index')
                           ->with('error', 'Application not found or already processed.');
        }

        $application->load('school');
        return view('admin.student-applications.show', compact('application'));
    }

    /**
     * Approve a single student application.
     */
    public function approve(Student $application)
    {
        if ($application->status !== 'inactive') {
            return redirect()->route('admin.student-applications.index')
                           ->with('error', 'Application is already processed.');
        }

        try {
            DB::beginTransaction();

            $application->update(['status' => 'active']);

            // TODO: Send approval email to student
            // $this->sendApprovalEmail($application);

            DB::commit();

            Log::info("Student application approved: {$application->id}");

            return redirect()->route('admin.student-applications.index')
                           ->with('success', "Application for {$application->name} has been approved successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to approve student application {$application->id}: " . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Failed to approve application. Please try again.');
        }
    }

    /**
     * Reject a single student application.
     */
    public function reject(Student $application)
    {
        if ($application->status !== 'inactive') {
            return redirect()->route('admin.student-applications.index')
                           ->with('error', 'Application is already processed.');
        }

        try {
            DB::beginTransaction();

            // TODO: Send rejection email before deleting
            // $this->sendRejectionEmail($application);

            $application->delete();

            DB::commit();

            Log::info("Student application rejected and deleted: {$application->id}");

            return redirect()->route('admin.student-applications.index')
                           ->with('success', "Application for {$application->name} has been rejected.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to reject student application {$application->id}: " . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Failed to reject application. Please try again.');
        }
    }

    /**
     * Handle bulk approval of student applications.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'exists:students,id',
        ]);

        try {
            DB::beginTransaction();

            $applications = Student::whereIn('id', $request->application_ids)
                                  ->where('status', 'inactive')
                                  ->get();

            if ($applications->isEmpty()) {
                return redirect()->back()
                               ->with('error', 'No valid pending applications selected.');
            }

            $approvedCount = 0;
            foreach ($applications as $application) {
                $application->update(['status' => 'active']);
                
                // TODO: Send approval email
                // $this->sendApprovalEmail($application);
                
                $approvedCount++;
            }

            DB::commit();

            Log::info("Bulk approved {$approvedCount} student applications");

            return redirect()->route('admin.student-applications.index')
                           ->with('success', "Successfully approved {$approvedCount} student applications!");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Bulk approval failed: " . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Bulk approval failed. Please try again.');
        }
    }

    /**
     * Handle bulk rejection of student applications.
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'exists:students,id',
        ]);

        try {
            DB::beginTransaction();

            $applications = Student::whereIn('id', $request->application_ids)
                                  ->where('status', 'inactive')
                                  ->get();

            if ($applications->isEmpty()) {
                return redirect()->back()
                               ->with('error', 'No valid pending applications selected.');
            }

            $rejectedCount = 0;
            foreach ($applications as $application) {
                // TODO: Send rejection email before deleting
                // $this->sendRejectionEmail($application);
                
                $application->delete();
                $rejectedCount++;
            }

            DB::commit();

            Log::info("Bulk rejected {$rejectedCount} student applications");

            return redirect()->route('admin.student-applications.index')
                           ->with('success', "Successfully rejected {$rejectedCount} student applications.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Bulk rejection failed: " . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Bulk rejection failed. Please try again.');
        }
    }

    /**
     * Get statistics for pending applications.
     */
    public function getStats()
    {
        $stats = [
            'total_pending' => Student::where('status', 'inactive')->count(),
            'total_approved' => Student::where('status', 'active')->count(),
            'pending_this_week' => Student::where('status', 'inactive')
                                         ->where('created_at', '>=', now()->startOfWeek())
                                         ->count(),
            'pending_by_school' => Student::where('status', 'inactive')
                                         ->with('school')
                                         ->get()
                                         ->groupBy('school.name')
                                         ->map->count()
        ];

        return response()->json($stats);
    }

    /**
     * Send approval email to student (placeholder for future implementation).
     */
    private function sendApprovalEmail(Student $student)
    {
        // TODO: Implement email sending
        // Example:
        // Mail::to($student->email)->send(new StudentApprovalMail($student));
    }

    /**
     * Send rejection email to student (placeholder for future implementation).
     */
    private function sendRejectionEmail(Student $student)
    {
        // TODO: Implement email sending
        // Example:
        // Mail::to($student->email)->send(new StudentRejectionMail($student));
    }
} 