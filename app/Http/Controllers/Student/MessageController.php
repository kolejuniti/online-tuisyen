<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display the messaging interface for students
     */
    public function index()
    {
        return view('student.messages.index');
    }

    /**
     * Search for students to message
     */
    public function searchStudents(Request $request)
    {
        $currentStudentIc = Auth::guard('student')->user()->ic;
        
        $students = DB::table('students')
            ->join('tblprogramme', 'students.program', 'tblprogramme.id')
            ->join('sessions AS a', 'students.intake', 'a.SessionID')
            ->join('sessions AS b', 'students.session', 'b.SessionID')
            ->select('students.ic', 'students.name', 'students.no_matric', 'tblprogramme.progname', 
                     'a.SessionName AS intake', 'b.SessionName AS session', 'students.semester')
            ->where('students.ic', '!=', $currentStudentIc)
            ->where(function($query) use ($request) {
                $query->where('students.name', 'LIKE', "%".$request->search."%")
                      ->orWhere('students.ic', 'LIKE', "%".$request->search."%")
                      ->orWhere('students.no_matric', 'LIKE', "%".$request->search."%");
            })
            ->limit(10)
            ->get();

        return response()->json($students);
    }

    /**
     * Send message to another student
     */
    public function sendToStudent(Request $request)
    {
        // This will be handled by the TextBox component via the general messaging routes
        return redirect()->route('all.student.send');
    }

    /**
     * Get messages with another student
     */
    public function getStudentMessages(Request $request)
    {
        // This will be handled by the TextBox component via the general messaging routes
        return redirect()->route('all.student.get');
    }

    /**
     * Send message to user/department
     */
    public function sendToUser(Request $request)
    {
        // This will be handled by the TextBox component via the general messaging routes
        return redirect()->route('all.user.send');
    }

    /**
     * Get messages with user/department
     */
    public function getUserMessages(Request $request)
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
        return redirect()->route('all.student.count');
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
     * Get all conversations for the current student
     */
    public function getConversations()
    {
        $currentStudentIc = Auth::guard('student')->user()->ic;

        // Get all conversations where current student is involved
        $conversations = DB::table('tblmessage')
            ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
            ->where('tblmessage.user_type', 'STUDENT_CONVERSATION')
            ->where('tblmessage.recipient', 'LIKE', '%' . $currentStudentIc . '%')
            ->select('tblmessage.recipient as conversation_id', DB::raw('MAX(tblmessage_dtl.id) as last_message_id'))
            ->groupBy('tblmessage.recipient')
            ->get();

        $conversationList = [];

        foreach ($conversations as $conversation) {
            // Extract the other student's IC from conversation ID
            $parts = explode('_', $conversation->conversation_id);
            $otherStudentIc = ($parts[0] == $currentStudentIc) ? $parts[1] : $parts[0];

            // Get other student details
            $otherStudent = DB::table('students')
                ->where('ic', $otherStudentIc)
                ->select('ic', 'name', 'no_matric')
                ->first();

            if ($otherStudent) {
                // Get last message
                $lastMessage = DB::table('tblmessage_dtl')
                    ->where('id', $conversation->last_message_id)
                    ->first();

                // Count unread messages
                $unreadCount = DB::table('tblmessage')
                    ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                    ->where('tblmessage.user_type', 'STUDENT_CONVERSATION')
                    ->where('tblmessage.recipient', $conversation->conversation_id)
                    ->where('tblmessage_dtl.sender', '!=', $currentStudentIc)
                    ->where('tblmessage_dtl.status', 'NEW')
                    ->count();

                $conversationList[] = [
                    'student' => $otherStudent,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'conversation_id' => $conversation->conversation_id
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