<?php

namespace App\Http\Controllers\User;

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
    public function lectForum(Request $request)
    {
        $TopicID = '';

        if(isset($request->TopicID))
        {
            $TopicID = $request->TopicID;
        }

        $course = DB::table('subjects')->where('id', Session::get('subjects')->id)->first();

        $topic = DB::table('tblforum_topic')->where([
            ['CourseID', Session::get('subjects')->id],
            ['Addby', Auth::user()->ic]
        ])->get();


        return view('user.forum.forum', compact('topic'))->with('course', $course)->with('TopicID', $TopicID);

    }

    public function insertTopic(Request $request){

        $user = Auth::user();

        //dd($user);

        DB::table('tblforum_topic')->insert([
            'TopicName' => $request->inputTitle,
            'CourseID' => $request->id,
            'Addby' => $user->ic
        ]);

        return redirect('/user/forum/'. $request->id);

    }

    public function insertForum(Request $request)
    {
        $user = Auth::user();

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

        //dd($request->id);

        return redirect('/user/forum/'. $request->id .'?TopicID='. $request->tpcID);

    }

    public function deleteMessage(Request $request)
    {
        $user = Auth::user();

        DB::table('tblforum')->where('ForumID', $request->id)->delete();

        return redirect()->back()->with('success', 'Message deleted successfully');
    }

    
}
