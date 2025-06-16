<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\subject;
use App\Models\student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;
use Mail;

class ForumController extends Controller
{

    public function studForum(Request $request)
    {
        $TopicID = '';

        if(isset($request->TopicID))
        {
            $TopicID = $request->TopicID;
        }


        $course = DB::table('subjects')->where('id', Session::get('subjects')->id)->first();

        $topic = DB::table('tblforum_topic')->where([
            ['CourseID', Session::get('subjects')->id],
            ['Addby', Session::get('teach')->ic]
        ])->get();


        return view('student.forum.forum', compact('topic'))->with('course', $course)->with('TopicID', $TopicID);

    }

    public function studinsertForum(Request $request)
    {
        $user = Auth::guard('student')->user();

        $data = $request->validate([
            'upforum' => ['required','string']
        ]);

        DB::table('tblforum')->insert([
            'TopicID' => $request->tpcID,
            'Content' => $data['upforum'],
            'CourseID' => $request->id,
            'DateTime' => date('Y-m-d H:i:s'), 
            'UpdatedBy' => $user->ic
        ]);

        return redirect('/student/forum/'. $request->id .'?TopicID='. $request->tpcID);

    }
    
}
