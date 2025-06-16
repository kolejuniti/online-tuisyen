<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TeacherSubject;
class SubjectController extends Controller
{
    /**
     * Display a listing of the User's Subjects
     */
    public function index()
    {
        $user = Auth::guard('student')->user();

        $subjects = TeacherSubject::with([
            'subject:id,name,image',
            'teacher:id,name'
        ])->get();
        
        return view('student.subjects.index', compact('subjects'));
    }

    public function getCourseList(Request $request)
    {
        if(isset($request->search)) {
            $data = TeacherSubject::with([
                'subject' => function($query) use ($request) {
                    $query->select('id', 'name', 'image')
                         ->where('name', 'LIKE', '%'.$request->search.'%');
                },
                'teacher:id,name'
            ])
            ->whereHas('subject', function($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->search.'%');
            })
            ->get();
        } else {
            $data = TeacherSubject::with([
                'subject:id,name,image',
                'teacher:id,name'
            ])
            ->whereHas('subject')
            ->get();
        }

        return view('student.subjects.getCourse', compact('data'));
    }

}
