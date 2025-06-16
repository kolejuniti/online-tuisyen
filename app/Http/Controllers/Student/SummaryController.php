<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Session;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\DB;
class SummaryController extends Controller
{
    /**
     * Direct to the summary page
     */
    public function show($id)
    {

        $teacher = TeacherSubject::with('teacher')->where('id', $id)
                    ->first();

        Session::put('teachers', $teacher);

        $teach = DB::table('users')->where('id', $teacher->user_id)->first();

        Session::put('teach', $teach);

        $subjects = Subject::findOrFail($teacher->subject_id);

        Session::put('subjects', $subjects);

        return view('student.subject_summary.index');
    }
}
