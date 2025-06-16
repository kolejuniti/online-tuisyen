<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the User's Subjects
     */
    public function index()
    {
        $user = Auth::user();
        $subjects = $user->subjects;
        return view('user.teacher_subjects.index', compact('subjects'));
    }

}
