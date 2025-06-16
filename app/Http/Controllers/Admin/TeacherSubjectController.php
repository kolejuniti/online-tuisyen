<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Validator;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of all teachers.
     */
    public function index()
    {
        $teachers = User::teachers()->get();
        return view('admin.teacher_subjects.index', compact('teachers'));
    }

    /**
     * Display the specified teacher's subjects.
     */
    public function show($id)
    {
        $teacher = User::teachers()->findOrFail($id);
        $assignedSubjects = $teacher->subjects;
        $allSubjects = Subject::all();
        
        return view('admin.teacher_subjects.show', compact('teacher', 'assignedSubjects', 'allSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the assignment already exists
        $exists = TeacherSubject::where('user_id', $request->user_id)
                                 ->where('subject_id', $request->subject_id)
                                 ->exists();
        
        if ($exists) {
            return response()->json(['message' => 'This subject is already assigned to the teacher.'], 422);
        }

        $teacherSubject = TeacherSubject::create([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
        ]);

        $subject = Subject::find($request->subject_id);

        return response()->json([
            'success' => true,
            'message' => 'Subject assigned successfully.',
            'data' => [
                'id' => $teacherSubject->id,
                'subject_id' => $subject->id,
                'subject_name' => $subject->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $deleted = TeacherSubject::where('user_id', $request->user_id)
                                 ->where('subject_id', $request->subject_id)
                                 ->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Assignment not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subject assignment removed successfully.'
        ]);
    }
}
