<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Session;

class SummaryController extends Controller
{
    /**
     * Direct to the summary page
     */
    public function index($id)
    {

        $subjects = Subject::findOrFail($id);

        Session::put('subjects', $subjects);

        return view('user.subject_summary.index');
    }
}
