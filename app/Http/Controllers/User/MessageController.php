<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display the messaging interface for users
     */
    public function index()
    {
        return view('user.messages.index');
    }

    /**
     * Search for students to message
     */
    public function searchStudents(Request $request)
    {
        $students = DB::table('students')
            ->join('tblprogramme', 'students.program', 'tblprogramme.id')
            ->join('sessions AS a', 'students.intake', 'a.SessionID')
            ->join('sessions AS b', 'students.session', 'b.SessionID')
            ->join('tblstudent_status', 'students.status', 'tblstudent_status.id')
            ->select('students.*', 'tblprogramme.progname', 'a.SessionName AS intake', 
                     'b.SessionName AS session', 'tblstudent_status.name AS status')
            ->where('students.name', 'LIKE', "%".$request->search."%")
            ->orwhere('students.ic', 'LIKE', "%".$request->search."%")
            ->orwhere('students.no_matric', 'LIKE', "%".$request->search."%")
            ->limit(20)
            ->get();

        return response()->json($students);
    }

    /**
     * Send message to student
     */
    public function sendToStudent(Request $request)
    {
        // This will be handled by the TextBox component via the general messaging routes
        return redirect()->route('all.user.send');
    }

    /**
     * Get messages with student
     */
    public function getStudentMessages(Request $request)
    {
        // This will be handled by the TextBox component via the general messaging routes
        return redirect()->route('all.user.get');
    }

    /**
     * Count unread messages
     */
    public function countMessages(Request $request)
    {
        // This will be handled by the TextBox component via the general messaging routes
        return redirect()->route('all.user.count');
    }

    /**
     * Delete a message
     */
    public function deleteMessage(Request $request)
    {
        // This will be handled by the TextBox component via the general messaging routes
        return redirect()->route('all.message.delete');
    }

    /**
     * Get all conversations for the current user
     */
    public function getConversations()
    {
        $userType = Auth::user()->user_type;

        // Get all conversations where current user's department is involved
        $conversations = DB::table('tblmessage')
            ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
            ->where('tblmessage.user_type', $userType)
            ->whereExists(function ($query) use ($userType) {
                $query->select(DB::raw(1))
                    ->from('tblmessage_dtl as dtl2')
                    ->whereColumn('dtl2.message_id', 'tblmessage.id')
                    ->where('dtl2.user_type', '!=', $userType);
            })
            ->select('tblmessage.recipient as student_ic', DB::raw('MAX(tblmessage_dtl.id) as last_message_id'))
            ->groupBy('tblmessage.recipient')
            ->get();

        $conversationList = [];

        foreach ($conversations as $conversation) {
            // Get student details
            $student = DB::table('students')
                ->join('tblprogramme', 'students.program', 'tblprogramme.id')
                ->where('students.ic', $conversation->student_ic)
                ->select('students.ic', 'students.name', 'students.no_matric', 'tblprogramme.progname')
                ->first();

            if ($student) {
                // Get last message
                $lastMessage = DB::table('tblmessage_dtl')
                    ->where('id', $conversation->last_message_id)
                    ->first();

                // Count unread messages (messages from student to this department)
                $unreadCount = DB::table('tblmessage')
                    ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                    ->where('tblmessage.user_type', $userType)
                    ->where('tblmessage.recipient', $conversation->student_ic)
                    ->where('tblmessage_dtl.user_type', 'STUDENT')
                    ->where('tblmessage_dtl.status', 'NEW')
                    ->count();

                $conversationList[] = [
                    'student' => $student,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount
                ];
            }
        }

        // Sort by last message time
        usort($conversationList, function($a, $b) {
            return strtotime($b['last_message']->datetime ?? '1970-01-01') - strtotime($a['last_message']->datetime ?? '1970-01-01');
        });

        return response()->json($conversationList);
    }
}