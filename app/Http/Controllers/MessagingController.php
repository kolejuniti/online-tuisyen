<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Student;

class MessagingController extends Controller
{
    /**
     * Send message from student to another student
     */
    public function sendStudentMessage(Request $request)
    {
        try {
            // Handle image upload if present
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $imageUrl = $this->uploadMessageImage($request->file('image'), $request->recipient_ic, 'STUDENT_TO_STUDENT');
            }

            $currentStudentIc = Auth::guard('student')->user()->ic;
            $recipientIc = $request->recipient_ic;

            // Create a unique conversation ID by sorting the ICs
            $conversationId = ($currentStudentIc < $recipientIc) 
                ? $currentStudentIc . '_' . $recipientIc 
                : $recipientIc . '_' . $currentStudentIc;

            // Check if conversation exists
            if (!DB::table('tblmessage')->where([
                ['user_type', 'STUDENT_CONVERSATION'],
                ['recipient', $conversationId]
            ])->exists()) {
                $id = DB::table('tblmessage')->insertGetId([
                    'sender' => null,
                    'user_type' => 'STUDENT_CONVERSATION',
                    'recipient' => $conversationId
                ]);
            } else {
                $id = DB::table('tblmessage')->where([
                    ['user_type', 'STUDENT_CONVERSATION'],
                    ['recipient', $conversationId]
                ])->value('id');
            }

            DB::table('tblmessage_dtl')->insert([
                'message_id' => $id,
                'sender' => $currentStudentIc,
                'user_type' => 'STUDENT_TO_STUDENT',
                'message' => $request->message ?? '',
                'image_url' => $imageUrl,
                'status' => 'NEW'
            ]);

            return response()->json([
                'message' => $request->message ?? '',
                'image_url' => $imageUrl,
                'conversation_id' => $conversationId
            ]);
        } catch (\Exception $e) {
            Log::error('Send student message failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }

    /**
     * Get messages for student-to-student conversation
     */
    public function getStudentMessages(Request $request)
    {
        try {
            $currentStudentIc = Auth::guard('student')->user()->ic;
            $recipientIc = $request->recipient_ic;

            // Create conversation ID
            $conversationId = ($currentStudentIc < $recipientIc) 
                ? $currentStudentIc . '_' . $recipientIc 
                : $recipientIc . '_' . $currentStudentIc;

            // Mark messages as read (only messages from the other student)
            DB::table('tblmessage')
                ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                ->where('tblmessage.user_type', 'STUDENT_CONVERSATION')
                ->where('tblmessage.recipient', $conversationId)
                ->where('tblmessage_dtl.sender', '!=', $currentStudentIc)
                ->where('tblmessage_dtl.status', 'NEW')
                ->update(['tblmessage_dtl.status' => 'READ']);

            // Fetch messages
            $messages = DB::table('tblmessage')
                ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                ->join('students', 'tblmessage_dtl.sender', '=', 'students.ic')
                ->where('tblmessage.user_type', 'STUDENT_CONVERSATION')
                ->where('tblmessage.recipient', $conversationId)
                ->where('tblmessage_dtl.status', '!=', 'DELETED')
                ->select('tblmessage_dtl.*', 'students.name as sender_name', 'tblmessage.datetime as message_datetime')
                ->orderBy('tblmessage_dtl.id', 'asc')
                ->get();

            return response()->json($messages);
        } catch (\Exception $e) {
            Log::error('Get student messages failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch messages'], 500);
        }
    }

    /**
     * Send message from student to user/department
     */
    public function sendUserMessage(Request $request)
    {
        try {
            // Handle image upload if present
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $imageUrl = $this->uploadMessageImage($request->file('image'), $request->ic, $request->type);
            }

            // Determine if this is from student or user
            $isFromStudent = Auth::guard('student')->check();
            $isFromUser = Auth::guard('web')->check();

            if ($isFromStudent) {
                // Student sending to user/department
                $currentIc = Auth::guard('student')->user()->ic;
                $userType = $request->type; // The department type (FN, RGS, HEP, etc.)
                
                if (!DB::table('tblmessage')->where([
                    ['user_type', $userType], 
                    ['recipient', $currentIc]
                ])->exists()) {
                    $id = DB::table('tblmessage')->insertGetId([
                        'sender' => null,
                        'user_type' => $userType,
                        'recipient' => $currentIc
                    ]);
                } else {
                    $id = DB::table('tblmessage')->where([
                        ['user_type', $userType], 
                        ['recipient', $currentIc]
                    ])->value('id');
                }

                DB::table('tblmessage_dtl')->insert([
                    'message_id' => $id,
                    'sender' => $currentIc,
                    'user_type' => 'STUDENT',
                    'message' => $request->message ?? '',
                    'image_url' => $imageUrl,
                    'status' => 'NEW'
                ]);

            } elseif ($isFromUser) {
                // User sending to student
                $currentIc = Auth::user()->ic;
                $studentIc = $request->ic;
                $userType = Auth::user()->user_type;

                if (!DB::table('tblmessage')->where([
                    ['user_type', $userType], 
                    ['recipient', $studentIc]
                ])->exists()) {
                    $id = DB::table('tblmessage')->insertGetId([
                        'sender' => $currentIc,
                        'user_type' => $userType,
                        'recipient' => $studentIc
                    ]);
                } else {
                    $id = DB::table('tblmessage')->where([
                        ['user_type', $userType], 
                        ['recipient' => $studentIc]
                    ])->value('id');
                }

                DB::table('tblmessage_dtl')->insert([
                    'message_id' => $id,
                    'sender' => $currentIc,
                    'user_type' => $userType,
                    'message' => $request->message ?? '',
                    'image_url' => $imageUrl,
                    'status' => 'NEW'
                ]);
            }

            return response()->json([
                'message' => $request->message ?? '',
                'image_url' => $imageUrl
            ]);
        } catch (\Exception $e) {
            Log::error('Send user message failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }

    /**
     * Get messages for user-student conversation
     */
    public function getUserMessages(Request $request)
    {
        try {
            $isFromStudent = Auth::guard('student')->check();
            $isFromUser = Auth::guard('web')->check();

            if ($isFromStudent) {
                // Student getting messages with department
                $currentIc = Auth::guard('student')->user()->ic;
                $messageType = $request->type;

                // Mark messages as read
                DB::table('tblmessage')
                    ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                    ->where('tblmessage.user_type', $messageType)
                    ->where('tblmessage.recipient', $currentIc)
                    ->where('tblmessage_dtl.sender', '!=', $currentIc)
                    ->where('tblmessage_dtl.status', 'NEW')
                    ->update(['tblmessage_dtl.status' => 'READ']);

                // Fetch messages
                $messages = DB::table('tblmessage')
                    ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                    ->where('tblmessage.user_type', $messageType)
                    ->where('tblmessage.recipient', $currentIc)
                    ->where('tblmessage_dtl.status', '!=', 'DELETED')
                    ->select('tblmessage_dtl.*', 'tblmessage.datetime as message_datetime')
                    ->orderBy('tblmessage_dtl.id', 'asc')
                    ->get();

            } elseif ($isFromUser) {
                // User getting messages with student
                $currentIc = Auth::user()->ic;
                $studentIc = $request->ic;
                $userType = Auth::user()->user_type;

                // Mark messages as read
                DB::table('tblmessage')
                    ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                    ->where('tblmessage.user_type', $userType)
                    ->where('tblmessage.recipient', $studentIc)
                    ->where('tblmessage_dtl.sender', '!=', $currentIc)
                    ->where('tblmessage_dtl.status', 'NEW')
                    ->update(['tblmessage_dtl.status' => 'READ']);

                // Fetch messages
                $messages = DB::table('tblmessage')
                    ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                    ->where('tblmessage.user_type', $userType)
                    ->where('tblmessage.recipient', $studentIc)
                    ->where('tblmessage_dtl.status', '!=', 'DELETED')
                    ->select('tblmessage_dtl.*', 'tblmessage.datetime as message_datetime')
                    ->orderBy('tblmessage_dtl.id', 'asc')
                    ->get();
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json($messages);
        } catch (\Exception $e) {
            Log::error('Get user messages failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch messages'], 500);
        }
    }

    /**
     * Search students for messaging (works for both student and user guards)
     */
    public function searchStudents(Request $request)
    {
        try {
            // Handle both student and user searches
            $currentUserIc = null;
            if (Auth::guard('student')->check()) {
                $currentUserIc = Auth::guard('student')->user()->ic;
            } elseif (Auth::check()) {
                $currentUserIc = Auth::user()->ic;
            }

            $query = DB::table('students')
            ->where(function($query) use ($request) {
                $query->where('students.name', 'LIKE', "%".$request->search."%")
                      ->orWhere('students.ic', 'LIKE', "%".$request->search."%")
                      ->orWhere('students.email', 'LIKE', "%".$request->search."%");
            });

            // Exclude current student if searching from student guard
            if ($currentUserIc && Auth::guard('student')->check()) {
                $query->where('students.ic', '!=', $currentUserIc);
            }

            $students = $query->limit(10)->get();

            return response()->json($students);
        } catch (\Exception $e) {
            Log::error('Search students failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search students'], 500);
        }
    }

    /**
     * Count unread messages for student
     */
    public function countStudentMessages(Request $request)
    {
        try {
            $currentStudentIc = Auth::guard('student')->user()->ic;
            $recipientIc = $request->recipient_ic;

            // Create conversation ID
            $conversationId = ($currentStudentIc < $recipientIc) 
                ? $currentStudentIc . '_' . $recipientIc 
                : $recipientIc . '_' . $currentStudentIc;

            $count = DB::table('tblmessage')
                        ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                        ->where('tblmessage.user_type', 'STUDENT_CONVERSATION')
                        ->where('tblmessage.recipient', $conversationId)
                        ->where('tblmessage_dtl.sender', '!=', $currentStudentIc)
                        ->where('tblmessage_dtl.status', 'NEW')
                        ->count();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Count student messages failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to count messages'], 500);
        }
    }

    /**
     * Count unread messages for user
     */
    public function countUserMessages(Request $request)
    {
        try {
            $isFromStudent = Auth::guard('student')->check();
            $isFromUser = Auth::guard('web')->check();

            if ($isFromStudent) {
                $currentIc = Auth::guard('student')->user()->ic;
                $messageType = $request->type;

                $count = DB::table('tblmessage')
                            ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                            ->where('tblmessage.user_type', $messageType)
                            ->where('tblmessage.recipient', $currentIc)
                            ->where('tblmessage_dtl.sender', '!=', $currentIc)
                            ->where('tblmessage_dtl.status', 'NEW')
                            ->count();

            } elseif ($isFromUser) {
                $userType = Auth::user()->user_type;

                $count = DB::table('tblmessage')
                    ->where('user_type', $userType)
                    ->whereExists(function ($query) use ($userType) {
                        $query->select(DB::raw(1))
                            ->from('tblmessage_dtl')
                            ->whereColumn('tblmessage_dtl.message_id', 'tblmessage.id')
                            ->where('tblmessage_dtl.status', 'NEW')
                            ->where('tblmessage_dtl.user_type', '!=', $userType);
                    })
                    ->count();
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Count user messages failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to count messages'], 500);
        }
    }

    /**
     * Delete a message
     */
    public function deleteMessage(Request $request)
    {
        try {
            $updated = DB::table('tblmessage_dtl')
                ->where('id', $request->message_id)
                ->update(['status' => 'DELETED']);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message deleted successfully'
                ]);
            } else {
                return response()->json(['error' => 'Message not found or already deleted'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Delete message failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete message'], 500);
        }
    }

    /**
     * Get staff list for messaging
     */
    public function getStaffList(Request $request)
    {
        try {
            $staffs = DB::table('users')
                ->where('name', 'LIKE', "%".$request->search."%")
                ->orwhere('ic', 'LIKE', "%".$request->search."%")
                ->orwhere('no_staf', 'LIKE', "%".$request->search."%")
                ->get();

            $content = "";
            $content .= "<option value='0' selected disabled>-</option>";
            
            foreach($staffs as $stf){
                $content .= "<option data-style=\"btn-inverse\"
                data-content=\"<div class='row'>
                    <div class='col-md-2'>
                    <div class='d-flex justify-content-center'>
                        <img src='' 
                            height='auto' width='70%' class='bg-light ms-0 me-2 rounded-circle'>
                            </div>
                    </div>
                    <div class='col-md-10 align-self-center lh-lg'>
                        <span><strong>". $stf->name ."</strong></span><br>
                        <span>". $stf->email ." | <strong class='text-fade'>". $stf->ic ."</strong></span><br>
                        <span class='text-fade'></span>
                    </div>
                </div>\" value='". $stf->ic ."' ></option>";
            }
            
            return $content;
        } catch (\Exception $e) {
            Log::error('Get staff list failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get staff list'], 500);
        }
    }

    /**
     * Get student list for messaging
     */
    public function getStudentList(Request $request)
    {
        try {
            $students = DB::table('students')
                ->where('students.name', 'LIKE', "%".$request->search."%")
                ->orwhere('students.ic', 'LIKE', "%".$request->search."%")
                ->get();

            return response()->json($students);
        } catch (\Exception $e) {
            Log::error('Get student list failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get student list'], 500);
        }
    }

    /**
     * Upload message image to storage (based on provided example)
     */
    private function uploadMessageImage($image, $ic, $type)
    {
        try {
            // Validate image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!in_array($image->getMimeType(), $allowedTypes)) {
                throw new \Exception('Invalid image type. Only JPEG, PNG, JPG, GIF, and WebP are allowed.');
            }

            // Check file size (max 5MB)
            if ($image->getSize() > 5 * 1024 * 1024) {
                throw new \Exception('Image size must be less than 5MB.');
            }

            // Generate unique filename
            $extension = $image->getClientOriginalExtension();
            $filename = 'msg_' . $ic . '_' . $type . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Create directory path
            $directory = 'messages/' . date('Y') . '/' . date('m');
            
            // Check if directory exists, if not create it
            if (!Storage::disk('linode')->exists($directory)) {
                Storage::disk('linode')->makeDirectory($directory);
            }
            
            // Upload to Linode storage using the same pattern as existing code
            $path = $image->storeAs($directory, $filename, [
                'disk' => 'linode',
                'visibility' => 'public'
            ]);

            // Return the full URL using environment variables like other controllers
            return env('LINODE_ENDPOINT') . '/' . env('LINODE_BUCKET') . '/' . $path;

        } catch (\Exception $e) {
            Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send message (updated for student-to-teacher messaging)
     */
    public function sendMassage(Request $request)
    {
        // Handle image upload if present
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadMessageImage($request->file('image'), $request->ic, $request->type);
        }

        if($request->type != 'STUDENT')
        {
            // User/Teacher sending message to student
            if(!DB::table('tblmessage')->where([
                ['sender', Auth::user()->ic], 
                ['recipient', $request->ic]
            ])->exists())
            {
                $id = DB::table('tblmessage')->insertGetId([
                        'sender' => Auth::user()->ic,
                        'user_type' => Auth::user()->user_type,
                        'recipient' => $request->ic
                    ]);
            } else {
                $id = DB::table('tblmessage')->where([
                    ['sender', Auth::user()->ic], 
                    ['recipient', $request->ic]
                ])->value('id');
            }

            DB::table('tblmessage_dtl')->insert([
                'message_id' => $id,
                'sender' => Auth::user()->ic,
                'user_type' => $request->type,
                'message' => $request->message ?? '',
                'image_url' => $imageUrl,
                'status' => 'NEW'
            ]);
        } else {
            // Student sending message to teacher - use teacher's IC as sender in tblmessage to differentiate sessions
            if(!DB::table('tblmessage')->where([
                ['sender', $request->ic], 
                ['recipient', Auth::guard('student')->user()->ic]
            ])->exists())
            {
                $id = DB::table('tblmessage')->insertGetId([
                        'sender' => $request->ic, // Teacher IC as sender to differentiate chat sessions
                        'user_type' => 'STUDENT_TO_TEACHER',
                        'recipient' => Auth::guard('student')->user()->ic
                    ]);
            } else {
                $id = DB::table('tblmessage')->where([
                    ['sender', $request->ic], 
                    ['recipient', Auth::guard('student')->user()->ic]
                ])->value('id');
            }

            DB::table('tblmessage_dtl')->insert([
                'message_id' => $id,
                'sender' => Auth::guard('student')->user()->ic,
                'user_type' => $request->type,
                'message' => $request->message ?? '',
                'image_url' => $imageUrl,
                'status' => 'NEW'
            ]);
        }

        return response()->json([
            'message' => $request->message ?? '',
            'image_url' => $imageUrl
        ]);
    }

    /**
     * Get messages (updated for student-to-teacher messaging)
     */
    public function getMassage(Request $request)
    {
        if($request->type != 'STUDENT')
        {
            // User/Teacher getting messages with student
            DB::table('tblmessage')
                ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                ->where('tblmessage.sender', Auth::user()->ic)
                ->where('tblmessage.recipient', $request->ic)
                ->where('tblmessage_dtl.sender', '!=', Auth::user()->ic)
                ->where('tblmessage_dtl.status', 'NEW') // Only update NEW messages
                ->update([
                    'status' => 'READ'
                ]);

            $messages = DB::table('tblmessage')
            ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
            ->where('tblmessage.sender', Auth::user()->ic)
            ->where('tblmessage.recipient', $request->ic)
            ->select('tblmessage_dtl.*', 'tblmessage_dtl.user_type', 'tblmessage.recipient', 'tblmessage.datetime as message_datetime')
            ->orderBy('tblmessage_dtl.id')
            ->get();
        } else {
            // Student getting messages with teacher
            DB::table('tblmessage')
                ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                ->where('tblmessage.sender', $request->ic) // Teacher IC is stored as sender
                ->where('tblmessage.recipient', Auth::guard('student')->user()->ic)
                ->where('tblmessage_dtl.sender', '!=', Auth::guard('student')->user()->ic)
                ->where('tblmessage_dtl.status', 'NEW') // Only update NEW messages
                ->update([
                    'status' => 'READ'
                ]);

            // Fetch messages and their details
            $messages = DB::table('tblmessage')
                ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                ->where('tblmessage.sender', $request->ic) // Teacher IC is stored as sender
                ->where('tblmessage.recipient', Auth::guard('student')->user()->ic)
                ->select('tblmessage_dtl.*', 'tblmessage_dtl.user_type', 'tblmessage.recipient', 'tblmessage.datetime as message_datetime')
                ->orderBy('tblmessage_dtl.id')
                ->get();
        }

        return response()->json($messages);
    }

    /**
     * Delete message (based on provided example)
     */
    public function deleteMassage(Request $request)
    {
        try {
            // Validate the request
            if (!$request->message_id || !$request->ic || !$request->type) {
                return response()->json(['error' => 'Missing required parameters'], 400);
            }

            // Update the message status to 'DELETED' instead of actually deleting it
            $updated = DB::table('tblmessage_dtl')
                ->where('id', $request->message_id)
                ->update(['status' => 'DELETED']);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message deleted successfully'
                ]);
            } else {
                return response()->json(['error' => 'Message not found or already deleted'], 404);
            }

        } catch (\Exception $e) {
            Log::error('Delete message failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete message'], 500);
        }
    }

    /**
     * Count messages (updated for student-to-teacher messaging)
     */
    public function countMessage(Request $request)
    {
        if (Auth::guard('student')->check()) {
            // Student counting messages from a specific teacher
            $count = DB::table('tblmessage')
                        ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                        ->where('tblmessage.sender', $request->type) // Teacher IC stored as sender
                        ->where('tblmessage.recipient', Auth::guard('student')->user()->ic)
                        ->where('tblmessage_dtl.sender', '!=', Auth::guard('student')->user()->ic)
                        ->where('tblmessage_dtl.status', 'NEW')
                        ->count();
        } else {
            // User counting messages from a specific student
            $count = DB::table('tblmessage')
                        ->join('tblmessage_dtl', 'tblmessage.id', '=', 'tblmessage_dtl.message_id')
                        ->where('tblmessage.sender', Auth::user()->ic)
                        ->where('tblmessage.recipient', $request->ic ?? $request->type)
                        ->where('tblmessage_dtl.sender', '!=', Auth::user()->ic)
                        ->where('tblmessage_dtl.status', 'NEW')
                        ->count();
        }

        return response()->json(['count' => $count]);
    }

    /**
     * Count admin messages (based on provided example)
     */
    public function countMassageAdmin(Request $request)
    {
        $count = DB::table('tblmessage')
        ->where('user_type', Auth::user()->user_type)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('tblmessage_dtl')
                ->whereColumn('tblmessage_dtl.message_id', 'tblmessage.id')
                ->where('tblmessage_dtl.status', 'NEW')
                ->where('tblmessage_dtl.user_type', '!=', Auth::user()->user_type);
        })
        ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get student conversations for messaging panel (updated to match working pattern)
     */
    public function getStudentConversations(Request $request)
    {
        try {
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
                    ->select('ic', 'name', 'email')
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
        } catch (\Exception $e) {
            Log::error('Get student conversations failed: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Get user conversations for messaging
     */
    public function getUserConversations(Request $request)
    {
        try {
            $currentUserIc = Auth::user()->ic;
            $currentUserType = Auth::user()->user_type;

            // Get conversations where current user is the sender (teacher to student conversations)
            $conversations = DB::table('tblmessage')
                ->where('sender', $currentUserIc)
                ->whereIn('user_type', [$currentUserType, 'STUDENT_TO_TEACHER'])
                ->get()
                ->map(function ($conversation) use ($currentUserIc) {
                    // Get the student details
                    $student = DB::table('students')->where('ic', $conversation->recipient)->first();
                    
                    if (!$student) {
                        return null;
                    }
                    
                    // Get the last message
                    $lastMessage = DB::table('tblmessage_dtl')
                        ->where('message_id', $conversation->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    
                    // Count unread messages (messages from the student)
                    $unreadCount = DB::table('tblmessage_dtl')
                        ->where('message_id', $conversation->id)
                        ->where('sender', '!=', $currentUserIc)
                        ->where('status', 'NEW')
                        ->count();
                    
                    return [
                        'conversation_id' => $conversation->id,
                        'student' => [
                            'ic' => $student->ic,
                            'name' => $student->name,
                            'email' => $student->email
                        ],
                        'last_message' => $lastMessage,
                        'unread_count' => $unreadCount
                    ];
                })
                ->filter() // Remove null values
                ->sortByDesc(function ($conversation) {
                    return $conversation['last_message']->id ?? 0;
                })
                ->values();

            return response()->json($conversations);
        } catch (\Exception $e) {
            Log::error('Get user conversations failed: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Get teachers list for student messaging
     */
    public function getTeachersList(Request $request)
    {
        try {
            $teachers = DB::table('users')
                ->where('user_type', 'Teacher')
                ->select('ic', 'name', 'email', 'user_type')
                ->orderBy('name')
                ->get();

            return response()->json($teachers);
        } catch (\Exception $e) {
            Log::error('Get teachers list failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get teachers list'], 500);
        }
    }
}