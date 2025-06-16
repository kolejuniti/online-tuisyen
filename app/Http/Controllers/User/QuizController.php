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
use Smalot\PdfParser\Parser;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyCustomNotification;
use App\Models\UserStudent;
use Illuminate\Support\Facades\Artisan;
use App\Models\School;

class QuizController extends Controller
{
    
    public function quizlist()
    {

        $user = Auth::user();
        $group = array();

        $chapter = array();

        $data = DB::table('tblclassquiz')->join('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
                ->where([
                    ['tblclassquiz.classid', Session::get('subjects')->id],
                    ['tblclassquiz.addby', $user->ic],
                    ['tblclassquiz.status', '!=', 3],
                    ['tblclassquiz.date_from','!=', null]
                ])->select('tblclassquiz.*', 'tblclassquizstatus.statusname')->get();

      
            foreach($data as $dt)
            {
                $group[] = DB::table('tblclassquiz_group')
                        ->join('teacher_subjects', 'tblclassquiz_group.groupid', 'teacher_subjects.id')
                        ->where('tblclassquiz_group.quizid', $dt->id)->get();

                $chapter[] = DB::table('tblclassquiz_chapter')
                        ->join('material_dir', 'tblclassquiz_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclassquiz_chapter.quizid', $dt->id)->get();
            }
      

        return view('user.subject_assessment.quiz', compact('data', 'group', 'chapter'));
    }

    public function getExtendQuiz(Request $request)
    {

        $data['quiz'] = DB::table('tblclassquiz')->where('id', $request->id)->first();

        return view('user.subject_assessment.quizGetExtend', compact('data'));

    }

    public function updateExtendQuiz(Request $request)
    {

        DB::table('tblclassquiz')->where('id', $request->id)->update([
            'date_from' => $request->from,
            'date_to' => $request->to,
            'duration' => $request->duration
        ]);

        return back()->with('message', 'Success!');

    }

    public function deletequiz(Request $request)
    {

        try {

            $quiz = DB::table('tblclassquiz')->where('id', $request->id)->first();

            if($quiz->status != 3)
            {
            DB::table('tblclassquiz')->where('id', $request->id)->update([
                'status' => 3
            ]);

            return true;

            }else{

                die;

            }
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }
    }

    public function quizcreate()
    {
        $user = Auth::user();

        $data['quizid'] = null;

        $data['reuse'] = null;

        $courseid = Session::get('subjects')->id;

        $group = School::all();

        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', $courseid)
                ->first();

        $folder = DB::table('lecturer_dir')
                  ->join('subjects', 'lecturer_dir.CourseID','subjects.id')
                  ->where('subjects.id', $courseid)
                  ->where('Addby', $user->ic)->get();

        if(isset(request()->quizid))
        {

            $quizid = request()->quizid;
 
            $data['quizid'] = $quizid;

            $data['quiz'] = DB::table('tblclassquiz')->select('tblclassquiz.*')
            ->where([
                ['id', $quizid]
            ])->get()->first();

            $data['quizstatus'] = $data['quiz']->status;

            if(isset(request()->REUSE))
            {
                $data['reuse'] = request()->REUSE;
            }

        }

        return view('user.subject_assessment.quizcreate', compact(['group', 'folder', 'data', 'tsubject']));
    }

    public function getChapters(Request $request)
    {

        $subchapter = DB::table('material_dir')->where('LecturerDirID', $request->folder)->get();

        $content = "";
        $content .= '
        <div class="table-responsive" style="width:99.7%">
        <table id="table_registerstudent" class="w-100 table text-fade table-bordered table-hover display nowrap margin-top-10 w-p100">
            <thead class="thead-themed">
            <th>Sub Chapter</th>
            <th>Name</th>
            <th></th>
            </thead>
            <tbody>
        ';
        foreach($subchapter as $sub){
            //$registered = ($student->status == 'ACTIVE') ? 'checked' : '';
            $content .= '
            <tr>
                <td >
                    <label>'.$sub->ChapterNo.'</label>
                </td>
                <td >
                    <label>'. (($sub->newDrName != null) ? $sub->newDrName : $sub->DrName) .'</label>
                </td>
                <td >
                    <div class="pull-right" >
                        <input type="checkbox" id="chapter_checkbox_'.$sub->DrID.'"
                            class="filled-in" name="chapter[]" value="'.$sub->DrID.'" 
                        >
                        <label for="chapter_checkbox_'.$sub->DrID.'"> </label>
                    </div>
                </td>
            </tr>
            ';
            }
            $content .= '</tbody></table>';

            return $content;

    }

    public function getStatus(Request $request)
    {

        $user = Auth::user();
            
        //dd($group);

        $quiz = DB::table('student_subjek')
                ->join('tblclassquiz_group', 'student_subjek.group_id', 'tblclassquiz_group.groupid')
                ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
                ->join('students', 'student_subjek.ic', 'students.ic')
                ->select('student_subjek.*', 'tblclassquiz.id AS clssid', 'tblclassquiz.total_mark', 'students.no_matric', 'students.name')
                ->where([
                    ['tblclassquiz.classid', Session::get('subjects')->id],
                    ['tblclassquiz.sessionid', Session::get('SessionIDS')],
                    ['tblclassquiz.id', $request->quiz],
                    ['tblclassquiz.addby', $user->ic],
                    ['tblclassquiz_group.groupid', $request->group]
                ])->get();
        
        //dd($quiz);

        foreach($quiz as $qz)
        {
            $statu[] = DB::table('tblclassstudentquiz')
            ->where([
                ['quizid', $qz->clssid],
                ['userid', $qz->ic]
            ])->get();
        }

        //dd($quiz);

        return view('user.subject_assessment.getstatusquiz', compact('quiz', 'status'));

    }


    public function insertquiz(Request $request){
        $data = $request->data;
        $classid = Session::get('subjects')->id;
        $duration = $request->duration;
        $title = $request->title;
        $from = $request->from;
        $to = $request->to;
        $questionindex = $request->questionindex;
        $status = $request->status;
        $marks = $request->marks;

        $user = Auth::user();
            
        $quizid = empty($request->quiz) ? '' : $request->quiz;

        $statusReuse = empty($request->reuse) ? '' : $request->reuse;

        $groupJSON = $request->input('group');
        $chapterJSON = $request->input('chapter');

        // Decode the JSON strings into PHP arrays
        $group = json_decode($groupJSON, true);
        $chapter = json_decode($chapterJSON, true);

        if( !empty($statusReuse))
        {
            $q = DB::table('tblclassquiz')->insertGetId([
                "classid" => $classid,
                "title" => $title,
                "date_from" => $from,
                "date_to" => $to,
                "content" => $data,
                "duration" => $duration,
                "questionindex" => $questionindex,
                "total_mark" => $marks,
                "addby" => $user->ic,
                "status" => $status
            ]);

            foreach($group as $grp)
            {
                $gp = explode('|', $grp);
                
                DB::table('tblclassquiz_group')->insert([
                    "groupid" => $gp[0],
                    "groupname" => $gp[1],
                    "quizid" => $q
                ]);
            }

            foreach($chapter as $chp)
            {
                DB::table('tblclassquiz_chapter')->insert([
                    "chapterid" => $chp,
                    "quizid" => $q
                ]);
            }
            
        }else{
            if( !empty($quizid) ){
                $q = DB::table('tblclassquiz')->where('id', $quizid)->update([
                    "title" => $title,
                    "date_from" => $from,
                    "date_to" => $to,
                    "content" => $data,
                    "duration" => $duration,
                    "questionindex" => $questionindex,
                    "total_mark" => $marks,
                    "addby" => $user->ic,
                    "status" => $status
                ]);

                DB::table('tblclassquiz_group')->where('quizid',$quizid)->delete();

                foreach($group as $grp)
                {
                    $gp = explode('|', $grp);
                    
                    DB::table('tblclassquiz_group')->insert([
                        "groupid" => $gp[0],
                        "groupname" => $gp[1],
                        "quizid" => $quizid
                    ]);
                }

                DB::table('tblclassquiz_chapter')->where('quizid',$quizid)->delete();

                foreach($chapter as $chp)
                {
                    DB::table('tblclassquiz_chapter')->insert([
                        "chapterid" => $chp,
                        "quizid" => $quizid
                    ]);
                }

            }else{
                $q = DB::table('tblclassquiz')->insertGetId([
                    "classid" => $classid,

                    "title" => $title,
                    "date_from" => $from,
                    "date_to" => $to,
                    "content" => $data,
                    "duration" => $duration,
                    "questionindex" => $questionindex,
                    "total_mark" => $marks,
                    "addby" => $user->ic,
                    "status" => $status
                ]);

                foreach($group as $grp)
                {
                    $gp = explode('|', $grp);
                    
                    DB::table('tblclassquiz_group')->insert([
                        "groupid" => $gp[0],
                        "groupname" => $gp[1],
                        "quizid" => $q
                    ]);
                }

                foreach($chapter as $chp)
                {
                    DB::table('tblclassquiz_chapter')->insert([
                        "chapterid" => $chp,
                        "quizid" => $q
                    ]);
                }
            }
        }

        // Set the directory path
        $dir = "classquiz/" . Session::get('subjects')->id . "/" . "quizimage" . "/" . $q . "/";

        $newNames = [];

        // Set the directory path (STAGING)
        // $dir = "classquiz/" . Session::get('subjects')->id . "/" . "quizimage" . "/";

        // Access the uploaded files
        foreach ($_FILES as $inputSubtype => $fileData) {
            // Loop through the array of files
            for ($i = 0; $i < count($fileData['name']); $i++) {
                $uploadedFile = $request->file($inputSubtype . '.' . $i);

                $file_name = $uploadedFile->getClientOriginalName();
                $file_ext = $uploadedFile->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;

                // Store the new name in the $newNames array, indexed by the "uploaded_image" key and file index
                $originalName = 'uploaded_image[' . $i . ']';
                $newNames[$originalName] = $newname;

                // Check if the file is present
                if ($uploadedFile) {
                    // Validate the file (add your own validation rules)
                    $validatedData = $request->validate([
                        $inputSubtype . '.' . $i => 'mimes:jpg,jpeg,png|max:2048', // For example: images only, max size 2MB
                    ]);

                    // Check if the directory exists in Linode Object Storage
                    if (!Storage::disk('linode')->exists($dir)) {
                        // If the directory doesn't exist, create it
                        Storage::disk('linode')->makeDirectory($dir);
                    }

                    // Store the file in Linode Object Storage with the specified path
                    $filePath = Storage::disk('linode')->putFileAs(
                        $dir,
                        $uploadedFile,
                        $newname,
                        'public'
                    );

                    // Store the file path in the database or another location as per your requirements
                    // For example, you could store the paths in a separate table, or add a column to an existing table
                    // The implementation depends on your application structure

                    // Create an img tag with the uploaded image
                    $imgTag = "<img src='" . env('LINODE_ENDPOINT') . "/" . env('LINODE_BUCKET') . "/" . $dir . $newname . "' />";

                    // Replace the corresponding image input with the img tag in the quiz content
                    $data = str_replace($inputSubtype . '_' . $i, $imgTag, $data);
                }
            }
        }

        
        
        // Decode the JSON content of the quiz into a PHP array
        $quiz_content = json_decode($data, true);

        // Define the Linode Object Storage base URL
        $linode_base_url = rtrim(env('LINODE_ENDPOINT'), '/') . '/' . env('LINODE_BUCKET') . '/' . $dir; // Replace this with your Linode Object Storage base URL

        // Iterate through the "formData" array and update the image URLs
        // Iterate through the "formData" array and update the image URLs
        $fileIndex = 0; // Initialize the file index
        foreach ($quiz_content['formData'] as $index => $item) {
            if ($item['type'] === 'file' && isset($item['name'])) {
                // Construct the original name using the file index
                $originalName2 = 'uploaded_image[' . $fileIndex . ']';

                // Check if a new name exists for this file in the $newNames array
                if (isset($newNames[$originalName2])) {
                    // Prepend the Linode Object Storage base URL to the new name
                    $quiz_content['formData'][$index]['name'] = $linode_base_url . $newNames[$originalName2];
                }

                $fileIndex++; // Increment the file index
            }
        }

        // Re-encode the quiz content to JSON format
        $updated_content = json_encode($quiz_content);

        // Update the content field in the database with the updated content
        DB::table('tblclassquiz')->where('id', $q)->update([
            "content" => $updated_content
        ]);

        // $allUsers = collect();

        //     foreach($group as $grp) {
        //         $gp = explode('|', $grp);

        //         $users = UserStudent::join('student_subjek', 'students.ic', '=', 'student_subjek.ic')
        //             ->where([
        //                 ['student_subjek.group_id', $gp[0]],
        //                 ['student_subjek.group_name', $gp[1]]
        //             ])
        //             ->select('students.*')
        //             ->get();

        //         $allUsers = $allUsers->merge($users);
        //     }

        // $message = "A new online quiz titled " . $title . " has been created.";
        // $url = url('/student/quiz/' . $classid . '?session=' . $sessionid);
        // $icon = "fa-puzzle-piece fa-lg";
        // $iconColor = "#8803a0"; // Example: set to a bright orange
        
        return true;

    }

    public function lecturerquizstatus()
    {
        $user = Auth::user();

        $group = School::all();
                
        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', Session::get('subjects')->id)
                ->first();

        $quiz = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclassquiz_group', function($join){
                    $join->on('schools.id', 'tblclassquiz_group.groupname');
                })
                ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
                ->select( 'students.*', 'tblclassquiz.id AS clssid', 'tblclassquiz.total_mark', 'tblclassquiz.date_from', 'tblclassquiz.date_to', 'students.name')
                ->where([
                    ['tblclassquiz.classid', Session::get('subjects')->id],
                    ['tblclassquiz.id', request()->quiz],
                    ['tblclassquiz.addby', $user->ic]
                ])->get();

        $status = [];

        foreach($quiz as $qz)
        {
            $status[] = DB::table('tblclassstudentquiz')
            ->where([
                ['quizid', $qz->clssid],
                ['userid', $qz->ic]
            ])->get();
        }

        //dd($quiz);

        return view('user.subject_assessment.quizstatus', compact('quiz', 'status', 'group', 'tsubject' ));

    }

    public function quizGetGroup(Request $request)
    {

        $user = Auth::user();

        $gp = explode('|', $request->group);

        $quiz = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclassquiz_group', function($join){
                    $join->on('schools.id', 'tblclassquiz_group.groupname');
                })
                ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
                ->select( 'students.*', 'tblclassquiz.id AS clssid', 'tblclassquiz.total_mark', 'tblclassquiz.date_from', 'tblclassquiz.date_to', 'students.name')
                ->where([
                    ['tblclassquiz.classid', Session::get('subjects')->id],
                    ['tblclassquiz.id', request()->quiz],
                    ['tblclassquiz.addby', $user->ic],
                    ['tblclassquiz_group.groupid', $gp[0]],
                    ['tblclassquiz_group.groupname', $gp[1]]
                ])->get();
        
        foreach($quiz as $qz)
        {
            $status[] = DB::table('tblclassstudentquiz')
            ->where([
                ['quizid', $qz->clssid],
                ['userid', $qz->ic]
            ])->get();
        }

        $content = "";
        $content .= '<thead>
                        <tr>
                            <th style="width: 1%">No.</th>
                            <th style="width: 15%">Name</th>
                            <th style="width: 20%">Submission Date</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 5%">Marks</th>
                            <th style="width: 20%"></th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($quiz as $key => $qz) {
            $alert = (count($status[$key]) > 0) ? 'badge bg-success' : 'badge bg-danger';

            $content .= '
                <tr>
                    <td style="width: 1%">' . ($key + 1) . '</td>
                    <td style="width: 15%">
                        <span class="' . $alert . '">' . $qz->name . '</span>
                    </td>';
            
            if (count($status[$key]) > 0) {
                foreach ($status[$key] as $keys => $sts) {
                    $content .= '
                        <td style="width: 20%">' . (empty($sts) ? '-' : $sts->submittime) . '</td>
                        <td>' . (empty($sts) ? '-' : $sts->status) . '</td>
                        <td>' . (empty($sts) ? '-' : $sts->final_mark) . ' / ' . $qz->total_mark . '</td>
                        <td class="project-actions text-center">
                            <a class="btn btn-success btn-sm mr-2" href="/user/quiz/' . request()->quiz . '/' . $sts->userid . '/result">
                                <i class="ti-pencil-alt"></i> Answer
                            </a>';
                    if (date('Y-m-d H:i:s') >= $qz->date_from && date('Y-m-d H:i:s') <= $qz->date_to) {
                        $content .= '
                            <a class="btn btn-danger btn-sm mr-2" onclick="deleteStdQuiz(\'' . $sts->id . '\')">
                                <i class="ti-trash"></i> Delete
                            </a>';
                    }
                    $content .= '
                        </td>';
                }
            } else {
                $content .= '
                    <td style="width: 20%">-</td>
                    <td>-</td>
                    <td>-</td>
                    <td></td>';
            }

            $content .= '
                </tr>';
        }

        $content .= '</tbody>';


        return response()->json(['message' => 'success', 'content' => $content]);


    }

    public function deletequizstatus(Request $request)
    {

        DB::table('tblclassstudentquiz')->where('id', $request->id)->delete();

        return true;
        
    }

    public function quizresult(Request $request){
        
        $id = $request->quizid;
        $userid = $request->userid;
        $count = 1;
    
        $quiz = DB::table('tblclassstudentquiz')
            ->join('tblclassquiz', 'tblclassstudentquiz.quizid', 'tblclassquiz.id')
            ->leftJoin('students', 'tblclassstudentquiz.userid', 'students.ic')
            ->select('tblclassstudentquiz.*', 'tblclassstudentquiz.quizid', 'tblclassquiz.title',  
                DB::raw('tblclassquiz.content as original_content'), 
                'tblclassquiz.questionindex',
                'tblclassstudentquiz.userid',
                'tblclassstudentquiz.submittime',
                DB::raw('tblclassstudentquiz.status as studentquizstatus'),
                'tblclassquiz.duration','students.name',
                'tblclassquiz.total_mark')
            ->where('tblclassstudentquiz.quizid', $id)
            ->where('tblclassstudentquiz.userid', $userid)->get()->first();
       
        $quizformdata = json_decode($quiz->content)->formData;
        $original_quizformdata = json_decode($quiz->original_content)->formData;
        
        $gain_mark = false;
        $correct_label = " <i style='font-size:1.5em' class='fa fa-check text-success'></i>";
        $incorrect_label = " <i style='font-size:1.5em' class='fa fa-close text-danger'></i>";
    
        foreach($original_quizformdata as $index => $q){
            if(!empty($original_quizformdata[$index]->name)){
                // Handle radio questions
                if(preg_match('/^radio-question(\d+)$/', $original_quizformdata[$index]->name, $matches)){
                    $question_number = $matches[1];
                    $i = 0;
                    
                    // Get and process correct answer(s)
                    $correct_answer_raw = $original_quizformdata[$index + 1]->label;
                    $correct_answers = explode(",", $correct_answer_raw);
                    
                    // Trim whitespace from each correct answer
                    $correct_answers = array_map('trim', $correct_answers);
                    
                    foreach($quizformdata[$index]->values as $v){
                        $value_trimmed = trim($v->value);
                        
                        if(in_array($value_trimmed, $correct_answers)){
                            $quizformdata[$index]->values[$i]->label = $original_quizformdata[$index]->values[$i]->label . $correct_label;
                        } else {
                            $quizformdata[$index]->values[$i]->label = $original_quizformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }
    
                    $userData = !empty($quizformdata[$index]->userData[0]) ? trim($quizformdata[$index]->userData[0]) : null;
    
                    if($userData && in_array($userData, $correct_answers)){
                        $gain_mark = true;
                    }
                    
                    if($question_number == $count) {
                        $count++;
                    }
                }
                
                // Handle checkbox questions
                if(preg_match('/^checkbox-question(\d+)$/', $original_quizformdata[$index]->name, $matches)){
                    $question_number = $matches[1];
                    $i = 0;
                    
                    // Get and process correct answer(s)
                    $correct_answer_raw = $original_quizformdata[$index + 1]->label;
                    $correct_answers = explode(",", $correct_answer_raw);
                    
                    // Trim whitespace from each correct answer
                    $correct_answers = array_map('trim', $correct_answers);
                    
                    foreach($quizformdata[$index]->values as $v){
                        $value_trimmed = trim($v->value);
                        
                        if(in_array($value_trimmed, $correct_answers)){
                            $quizformdata[$index]->values[$i]->label = $original_quizformdata[$index]->values[$i]->label . $correct_label;
                        } else {
                            $quizformdata[$index]->values[$i]->label = $original_quizformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }
                    
                    $userData = !empty($quizformdata[$index]->userData) ? $quizformdata[$index]->userData : [];
                    
                    // Trim whitespace from user data
                    $userData = array_map('trim', $userData);
                    
                    // Sort both arrays to ensure consistent comparison
                    sort($userData);
                    sort($correct_answers);
                    
                    // Compare arrays (case-insensitive)
                    $userData_lower = array_map('strtolower', $userData);
                    $correct_answers_lower = array_map('strtolower', $correct_answers);
                    
                    if($userData_lower == $correct_answers_lower){
                        $gain_mark = true;
                    }
                    
                    if($question_number == $count) {
                        $count++;
                    }
                }
            }
    
            if(!empty($original_quizformdata[$index]->className)){
                
                if(str_contains($original_quizformdata[$index]->className, "feedback-text")){
                    $quizformdata[$index] = $q;
                  
                    $quizformdata[$index]->type = "paragraph";
    
                    if(!empty($q->userData[0])){
                        $quizformdata[$index]->label = $q->userData[0];
                    }else{
                        $quizformdata[$index]->label = " ";
                    }
                    $quizformdata[$index]->className = "bg-red mb-4 text-danger";
                }
    
                if(str_contains($original_quizformdata[$index]->className, "inputmark")){
                    $quizformdata[$index]->type = "number";
    
                    if(!empty($q->userData[0])){
                        $quizformdata[$index]->label = $q->userData[0];
                    }else{
                        $quizformdata[$index]->label = " ";
                    }
    
                    $quizformdata[$index]->className = "inputmark form-control";
                }
    
                if(str_contains($original_quizformdata[$index]->className, "collected-marks")){
    
                    $mark_label = $original_quizformdata[$index]->values[0]->label;
                    $mark = $original_quizformdata[$index]->values[0]->value;
                    
                    //if result is published then use graded data
                    if($quiz->studentquizstatus == 3){
                        $graded_data = empty($quizformdata[$index]->userData[0]) ? "" : $quizformdata[$index]->userData[0];
    
                        if($graded_data == $mark){
                            $quizformdata[$index]->values[0]->selected = true;
                        }else{
                            $quizformdata[$index]->values[0]->selected = false;
                        }
                    }else{
                        //auto correct answer on mcq by matching user answer with original answer
                        $quizformdata[$index] = $original_quizformdata[$index];
    
                        if($gain_mark){
                            $quizformdata[$index]->values[0]->selected = true;
                        }else{
                            $quizformdata[$index]->values[0]->selected = false;
                        }
                        
                        $gain_mark = false;
                    }
                }
            }
        }
       
        $data['quiz'] = $quizformdata;
        $data['comments'] = $quiz->comments;
        $data['totalmark'] = $quiz->total_mark;
        $data['quizid'] = $quiz->quizid;
        $data['quiztitle'] = $quiz->title;
        $data['quizduration'] = $quiz->duration;
        $data['quizuserid'] = $quiz->userid;
        $data['fullname'] = $quiz->name;
        $data['created_at'] = $quiz->created_at;
        $data['updated_at'] = $quiz->updated_at;
        $data['submittime'] = $quiz->submittime;
        $data['questionindex'] = $quiz->questionindex;
        $data['studentquizstatus'] = $quiz->studentquizstatus;
    
        return view('user.subject_assessment.quizresult', compact('data'));
    }

    public function updatequizresult(Request $request){
        $quiz = $request->quiz;
        $participant = $request->participant;
        $final_mark = (int) str_replace(' Mark', '', $request->final_mark);
        $comments = $request->comments;
        //$total_mark = $request->total_mark;
        $data = $request->data;
      
        DB::table('tblclassstudentquiz')
            ->where('quizid', $quiz)
            ->where("userid", $participant)
            ->update([
                "content" => $data,
                "final_mark" => $final_mark,
                //"total_mark" => $total_mark,
                "comments" => $comments,
                "status" => 3
            ]);

        $message = "Lecturer has marked your quiz.";
        $url = url('/student/quiz/' . $quiz . '/' . $participant . '/result');
        $icon = "fa-check fa-lg";
        $iconColor = "#2b74f3"; // Example: set to a bright orange

        $participant = UserStudent::where('ic', $participant)->first();

        
        return true;
    }

    public function generateAIQuiz(Request $request) {
        try {
            // Clear Laravel cache
            $this->clearApplicationCache();
            
            // Step 1: Validate the inputs
            $request->validate([
                'document' => 'required|file|mimes:pdf|max:5000',
                'single_choice_count' => 'nullable|integer|min:0',
                'multiple_choice_count' => 'nullable|integer|min:0',
                'subjective_count' => 'nullable|integer|min:0',
                'language' => 'required|string|in:english,malay,mix',
            ]);
            
            // Step 2: Direct file handling approach
            $file = $request->file('document');
            if (!$file) {
                Log::error("No file was uploaded");
                return response()->json([
                    'success' => false,
                    'message' => 'No file was uploaded',
                ], 400);
            }
            
            // Ensure the documents directory exists
            $documentsPath = storage_path('app/documents');
            if (!file_exists($documentsPath)) {
                mkdir($documentsPath, 0777, true);
                Log::info("Created documents directory at: " . $documentsPath);
            }
            
            // Get the original filename and sanitize it
            $originalName = $file->getClientOriginalName();
            $safeFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
            
            // Set the destination path
            $destinationPath = $documentsPath . DIRECTORY_SEPARATOR . $safeFileName;
            
            // Directly move the uploaded file to the destination
            if (!$file->move($documentsPath, $safeFileName)) {
                Log::error("Failed to move uploaded file to: " . $destinationPath);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save uploaded file',
                ], 500);
            }
            
            // Check if the file exists after moving
            if (!file_exists($destinationPath)) {
                Log::error("File was moved but doesn't exist at: " . $destinationPath);
                return response()->json([
                    'success' => false,
                    'message' => 'File saved but not found in destination',
                ], 500);
            }
            
            // Log success and list files in the directory for debugging
            Log::info("Successfully saved file to: " . $destinationPath);
            if (is_dir($documentsPath)) {
                $files = scandir($documentsPath);
                Log::info("Files in documents directory: " . json_encode($files));
            }
            
            // Parse the PDF file
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($destinationPath);
                $text = $pdf->getText();
                
                if (empty($text)) {
                    Log::warning("PDF parsing successful but returned empty text");
                }
            } catch (\Exception $e) {
                Log::error("PDF parsing error: " . $e->getMessage());
                return response()->json([
                    'success' => false, 
                    'message' => 'Error parsing PDF: ' . $e->getMessage()
                ], 500);
            }
            
            // Step 3: Generate quiz JSON
            $singleChoiceCount = $request->input('single_choice_count', 0);
            $multipleChoiceCount = $request->input('multiple_choice_count', 0);
            $subjectiveCount = $request->input('subjective_count', 0);
            $language = $request->input('language', 'english');
            
            // Ensure we have at least one question
            $totalQuestions = $singleChoiceCount + $multipleChoiceCount + $subjectiveCount;
            if ($totalQuestions <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please specify at least one question to generate.',
                ], 400);
            }
            
            $quizJSON = $this->generateFormBuilderJSON($text, $singleChoiceCount, $multipleChoiceCount, $subjectiveCount, $language);
            
            // Step 4: Return the quiz JSON
            return response()->json([
                'success' => true,
                'formBuilderJSON' => $quizJSON,
            ]);
            
        } catch (\Exception $e) {
            // Handle errors gracefully
            Log::error('Error generating quiz: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating quiz: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Clears various Laravel caches
     * 
     * This method clears application cache, route cache, config cache, and view cache
     * to ensure fresh data on each quiz generation
     */
    private function clearApplicationCache()
    {
        try {
            // Clear application cache
            Artisan::call('cache:clear');
            Log::info('Application cache cleared');
            
            // Clear route cache
            Artisan::call('route:clear');
            Log::info('Route cache cleared');
            
            // Clear config cache
            Artisan::call('config:clear');
            Log::info('Config cache cleared');
            
            // Clear view cache
            Artisan::call('view:clear');
            Log::info('View cache cleared');
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error clearing cache: ' . $e->getMessage());
            // Continue with the application even if cache clearing fails
            return false;
        }
    }
    
    private function generateFormBuilderJSON($text, $singleChoiceCount, $multipleChoiceCount, $subjectiveCount, $language) {
        $apiKey = env('OPENAI_API_KEY');
        $client = new Client();
        
        try {
            // Build the AI prompt with explicit instructions for question types
            $prompt = "Create a quiz JSON structure based on the following text. The quiz should include:\n";
            
            if ($singleChoiceCount > 0) {
                $prompt .= "- $singleChoiceCount single-choice questions\n";
            } else {
                $prompt .= "- No single-choice questions\n";
            }
            
            if ($multipleChoiceCount > 0) {
                $prompt .= "- $multipleChoiceCount multiple-choice questions\n";
            } else {
                $prompt .= "- No multiple-choice questions\n";
            }
            
            if ($subjectiveCount > 0) {
                $prompt .= "- $subjectiveCount subjective questions\n";
            } else {
                $prompt .= "- No subjective questions\n";
            }
            
            // Add language instruction
            $prompt .= "\nLANGUAGE REQUIREMENT:\n";
            switch ($language) {
                case 'malay':
                    $prompt .= "- Generate all questions and answers in Malay (Bahasa Malaysia) only.\n";
                    break;
                case 'mix':
                    $prompt .= "- Generate a mix of questions in both English and Malay (Bahasa Malaysia).\n";
                    $prompt .= "- Approximately half of the questions should be in English and half in Malay.\n";
                    break;
                default: // english
                    $prompt .= "- Generate all questions and answers in English only.\n";
                    break;
            }
            
            // Add specific formatting instructions for answers
            $prompt .= "\nANSWER FORMAT REQUIREMENTS:\n";
            $prompt .= "1. For single-choice questions, provide the correct answer as a single string without any prefixes or labels.\n";
            $prompt .= "2. For multiple-choice questions, provide the correct answers as a comma-separated string without spaces (e.g., 'Option1,Option3,Option4').\n";
            $prompt .= "3. For subjective questions, provide a concise sample answer.\n\n";
            
            // Example JSON structure to guide the AI
            $prompt .= "Example JSON structure:\n";
            $prompt .= '{"quiz":{"questions":[';
            
            if ($singleChoiceCount > 0) {
                if ($language === 'malay') {
                    $prompt .= '{"type":"single-choice","question":"Negeri manakah yang dikenali sebagai Negeri Bersejarah?","options":["Melaka","Pahang","Johor","Kedah"],"answer":"Melaka"}';
                } else {
                    $prompt .= '{"type":"single-choice","question":"Which state is known as the Historic State?","options":["Melaka","Pahang","Johor","Kedah"],"answer":"Melaka"}';
                }
                if ($multipleChoiceCount > 0 || $subjectiveCount > 0) {
                    $prompt .= ',';
                }
            }
            
            if ($multipleChoiceCount > 0) {
                if ($language === 'malay') {
                    $prompt .= '{"type":"multiple-choice","question":"Manakah antara berikut adalah negeri di Malaysia?","options":["Melaka","Singapura","Pahang","Selangor"],"answer":"Melaka,Pahang,Selangor"}';
                } else {
                    $prompt .= '{"type":"multiple-choice","question":"Which of the following are states in Malaysia?","options":["Melaka","Singapore","Pahang","Selangor"],"answer":"Melaka,Pahang,Selangor"}';
                }
                if ($subjectiveCount > 0) {
                    $prompt .= ',';
                }
            }
            
            if ($subjectiveCount > 0) {
                if ($language === 'malay') {
                    $prompt .= '{"type":"subjective","question":"Terangkan kepentingan Melaka dalam sejarah Malaysia.","answer":"Melaka merupakan pelabuhan perdagangan penting..."}';
                } else {
                    $prompt .= '{"type":"subjective","question":"Explain the importance of Melaka in Malaysian history.","answer":"Melaka was an important trading port..."}';
                }
            }
            
            $prompt .= ']}}'."\n\n";
            
            $prompt .= "Here is the text to generate questions from:\n\n" . $text;
            
            // Send the request to OpenAI API
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo-1106', 
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a system designed to generate quiz questions for FormBuilder. Follow the format requirements exactly.' . 
                                        ($language === 'malay' ? ' You are fluent in Malay (Bahasa Malaysia).' : '') .
                                        ($language === 'mix' ? ' You are bilingual in English and Malay (Bahasa Malaysia).' : ''),
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'max_tokens' => 2000,
                    'temperature' => 0.7,
                ],
            ]);
            
            // Parse the response
            $responseBody = json_decode($response->getBody(), true);
            
            if (isset($responseBody['choices'][0]['message']['content'])) {
                // Extract the JSON content from the response
                $jsonContent = $responseBody['choices'][0]['message']['content'];
                
                // Try to decode the JSON
                $decodedJson = json_decode($jsonContent, true);
                
                // Check if the JSON structure is valid
                if (!$decodedJson || !isset($decodedJson['quiz']) || !isset($decodedJson['quiz']['questions'])) {
                    // If the structure isn't valid, create a simple one with the requested counts
                    Log::warning('AI response did not contain valid quiz JSON structure. Creating default structure.');
                    
                    $defaultQuiz = ['quiz' => ['questions' => []]];
                    
                    // Return the default structure as JSON
                    return json_encode($defaultQuiz);
                }
                
                // Log the actual question counts vs requested
                $questions = $decodedJson['quiz']['questions'];
                $actualSingleChoice = 0;
                $actualMultipleChoice = 0;
                $actualSubjective = 0;
                
                foreach ($questions as $question) {
                    if (!isset($question['type'])) continue;
                    
                    if ($question['type'] === 'single-choice') $actualSingleChoice++;
                    elseif ($question['type'] === 'multiple-choice') $actualMultipleChoice++;
                    elseif ($question['type'] === 'subjective') $actualSubjective++;
                }
                
                Log::info("Question counts - Requested: $singleChoiceCount single, $multipleChoiceCount multiple, $subjectiveCount subjective. Received: $actualSingleChoice single, $actualMultipleChoice multiple, $actualSubjective subjective.");
                Log::info("Language requested: $language");
                
                // Return the JSON string as is - let the frontend handle filtering
                return $jsonContent;
            } else {
                throw new \Exception('Invalid AI response. No content found.');
            }
        } catch (\Exception $e) {
            Log::error('Error communicating with OpenAI: ' . $e->getMessage());
            throw new \Exception('Error communicating with AI: ' . $e->getMessage());
        }
    }

    //THIS IS QUIZ PART 2


    public function quiz2list()
    {

        $user = Auth::user();
        $group = array();

        $chapter = array();

        $data = DB::table('tblclassquiz')
                ->join('users', 'tblclassquiz.addby', 'users.ic')
                ->join('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
                ->where([
                    ['tblclassquiz.classid', Session::get('subjects')->id],
                    ['tblclassquiz.addby', $user->ic],
                    ['tblclassquiz.date_from', null],
                    ['tblclassquiz.status', '!=', 3]
                ])
                ->select('tblclassquiz.*', 'users.name AS addby', 'tblclassquizstatus.statusname')->get();

            foreach($data as $dt)
            {
                $group[] = DB::table('tblclassquiz_group')
                        ->join('teacher_subjects', 'tblclassquiz_group.groupid', 'teacher_subjects.id')
                        ->where('tblclassquiz_group.quizid', $dt->id)->get();

                $chapter[] = DB::table('tblclassquiz_chapter')
                        ->join('material_dir', 'tblclassquiz_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclassquiz_chapter.quizid', $dt->id)->get();
            }
      

        return view('user.subject_assessment.quiz2', compact('data', 'group', 'chapter'));
    }

    public function quiz2create()
    {
        $user = Auth::user();

        $data['quiz'] = null;

        $data['folder'] = null;

        $data['chapter'] = null;

        $courseid = Session::get('subjects')->id;

        $group = School::all();

        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', $courseid)
                ->first();

        $folder = DB::table('lecturer_dir')
                  ->join('subjects', 'lecturer_dir.CourseID','subjects.id')
                  ->where('subjects.id', $courseid)
                  ->where('Addby', $user->ic)->get();

        if(isset(request()->quizid))
        {

            $data['quiz'] = DB::table('tblclassquiz')->where('id', request()->quizid)->first();
            
        }

        return view('user.subject_assessment.quiz2create', compact(['group', 'folder', 'data', 'tsubject']));
    }


    public function insertquiz2(Request $request){

        $classid = Session::get('subjects')->id;
        $title = $request->title;
        $group = $request->group;
        $chapter = $request->chapter;
        $marks = $request->marks;
        
        // dd($request->all());

        $data = $request->validate([
            'myPdf' => 'required', 'mimes:pdf'
        ]);

        $user = Auth::user();

        $dir = "eTutor/classquiz2/" .  $classid . "/" . $user->name . "/" . $title;
        $classquiz2  = Storage::disk('linode')->makeDirectory($dir);
        $file = $request->file('myPdf');
            
        $quizid = empty($request->quiz) ? '' : $request->quiz;

        if($group != null && $chapter != null)
        {
        
            if( !empty($quizid) ){
                
                $quiz = DB::table('tblclassquiz')->where('id', $quizid)->first();

                Storage::disk('linode')->delete($quiz->content);

                DB::table('tblclassquiz_group')->where('quizid', $quizid)->delete();

                DB::table('tblclassquiz_chapter')->where('quizid', $quizid)->delete();

                $file_name = $file->getClientOriginalName();
                $file_ext = $file->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;
                $newpath = "eTutor/classquiz2/" .  $classid . "/" . $user->name . "/" . $title . "/" . $newname;

                if(!file_exists($newname)){
                    Storage::disk('linode')->putFileAs(
                        $dir,
                        $file,
                        $newname,
                        'public'
                    );

                    $q = DB::table('tblclassquiz')->where('id', $quizid)->update([
                        "title" => $title,
                        'content' => $newpath,
                        "total_mark" => $marks,
                        "status" => 2
                    ]);

                    foreach($request->group as $grp)
                    {
                        $gp = explode('|', $grp);

                        DB::table('tblclassquiz_group')->insert([
                            "groupid" => $gp[0],
                            "groupname" => $gp[1],
                            "quizid" => $quizid
                        ]);
                    }

                    foreach($request->chapter as $chp)
                    {
                        DB::table('tblclassquiz_chapter')->insert([
                            "chapterid" => $chp,
                            "quizid" => $quizid
                        ]);
                    }

                }

            }else{
                $file_name = $file->getClientOriginalName();
                $file_ext = $file->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;
                $newpath = "eTutor/classquiz2/" .  $classid . "/" . $user->name . "/" . $title . "/" . $newname;

                if(!file_exists($newname)){
                    Storage::disk('linode')->putFileAs(
                        $dir,
                        $file,
                        $newname,
                        'public'
                    );

                    $q = DB::table('tblclassquiz')->insertGetId([
                        "classid" => $classid,
                        "title" => $title,
                        'content' => $newpath,
                        "total_mark" => $marks,
                        "addby" => $user->ic,
                        "status" => 2
                    ]);

                    foreach($request->group as $grp)
                    {
                        $gp = explode('|', $grp);

                        DB::table('tblclassquiz_group')->insert([
                            "groupid" => $gp[0],
                            "groupname" => $gp[1],
                            "quizid" => $q
                        ]);
                    }

                    foreach($request->chapter as $chp)
                    {
                        DB::table('tblclassquiz_chapter')->insert([
                            "chapterid" => $chp,
                            "quizid" => $q
                        ]);
                    }

                }

            }

            // $allUsers = collect();

            // foreach($request->group as $grp) {
            //     $gp = explode('|', $grp);

            //     $users = UserStudent::join('student_subjek', 'students.ic', '=', 'student_subjek.ic')
            //         ->where([
            //             ['student_subjek.group_id', $gp[0]],
            //             ['student_subjek.group_name', $gp[1]]
            //         ])
            //         ->select('students.*')
            //         ->get();

            //     $allUsers = $allUsers->merge($users);
            // }

            // //dd($allUsers);

            // $message = "A new offline quiz titled " . $title . " has been created.";
            // $url = url('/student/quiz2/' . $classid . '?session=' . $sessionid);
            // $icon = "fa-puzzle-piece fa-lg";
            // $iconColor = "#8803a0"; // Example: set to a bright orange

            // Notification::send($allUsers, new MyCustomNotification($message, $url, $icon, $iconColor));

        }else{

            return redirect()->back()->withErrors(['Please fill in the group and sub-chapter checkbox !']);

        }
        
        
        return redirect(route('user.quiz2', ['id' => $classid]));
    }

    public function lecturerquiz2status()
    {
        $user = Auth::user();

        $group = School::all();
                
        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', Session::get('subjects')->id)
                ->first();
        
        $quiz = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclassquiz_group', function($join){
                    $join->on('schools.id', 'tblclassquiz_group.groupname');
                })
                ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
                ->select( 'students.*', 'tblclassquiz.id AS clssid', 'tblclassquiz.total_mark', 'students.name')
                ->where([
                    ['tblclassquiz.classid', Session::get('subjects')->id],
                    ['tblclassquiz.id', request()->quiz],
                    ['tblclassquiz.addby', $user->ic]
                ])->get();

        foreach($quiz as $qz)
        {

           if(!DB::table('tblclassstudentquiz')->where([['quizid', $qz->clssid],['userid', $qz->ic]])->exists()){

                DB::table('tblclassstudentquiz')->insert([
                    'quizid' => $qz->clssid,
                    'userid' => $qz->ic,
                    'total_mark' => $qz->total_mark
                ]);

           }

            $status[] = DB::table('tblclassstudentquiz')
            ->where([
                ['quizid', $qz->clssid],
                ['userid', $qz->ic]
            ])->first();
        }

        return view('user.subject_assessment.quiz2status', compact('quiz', 'status', 'group', 'tsubject'));

    }

    public function quiz2GetGroup(Request $request)
    {

        $user = Auth::user();

        $gp = explode('|', $request->group);

        $quiz = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclassquiz_group', function($join){
                    $join->on('schools.id', 'tblclassquiz_group.groupname');
                })
                ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
                ->select( 'students.*', 'tblclassquiz.id AS clssid', 'tblclassquiz.total_mark', 'tblclassquiz.date_from', 'tblclassquiz.date_to', 'students.name')
                ->where([
                    ['tblclassquiz.classid', Session::get('subjects')->id],
                    ['tblclassquiz.id', request()->quiz],
                    ['tblclassquiz.addby', $user->ic],
                    ['tblclassquiz_group.groupid', $gp[0]],
                    ['tblclassquiz_group.groupname', $gp[1]]
                ])->get();

        foreach($quiz as $qz)
        {

           if(!DB::table('tblclassstudentquiz')->where([['quizid', $qz->clssid],['userid', $qz->ic]])->exists()){

                DB::table('tblclassstudentquiz')->insert([
                    'quizid' => $qz->clssid,
                    'userid' => $qz->ic
                ]);

           }

            $status[] = DB::table('tblclassstudentquiz')
            ->where([
                ['quizid', $qz->clssid],
                ['userid', $qz->ic]
            ])->first();
        }

        $content = "";
        $content .= '<thead>
                        <tr>
                            <th style="width: 1%">
                                No.
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Submission Date
                            </th>
                            <th>
                                Marks
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table">';
                            
        foreach ($quiz as $key => $qz) {
            $alert = ($status[$key]->final_mark != 0) ? 'badge bg-success' : 'badge bg-danger';

            $content .= '
                <tr>
                    <td style="width: 1%">
                        ' . ($key + 1) . '
                    </td>
                    <td>
                        <span class="' . $alert . '">' . $qz->name . '</span>
                    </td>';
            
            if ($status[$key]->final_mark != 0) {
                $content .= '
                    <td>
                        ' . $status[$key]->submittime . '
                    </td>';
            } else {
                $content .= '
                    <td>
                        -
                    </td>';
            }
            
            $content .= '
                    <td>
                        <div class="form-inline col-md-6 d-flex">
                            <input type="number" class="form-control" name="marks[]" max="' . $qz->total_mark . '" value="' . $status[$key]->final_mark . '">
                            <input type="text" name="ic[]" value="' . $qz->ic . '" hidden>
                            <span>' . $status[$key]->final_mark . ' / ' . $qz->total_mark . '</span>
                        </div>
                    </td>
                </tr>';
        }

        $content .= '</tbody>';

        return response()->json(['message' => 'success', 'content' => $content]);


    }

    public function updatequiz2(Request $request)
    {
        $user = Auth::user();

        $marks = json_decode($request->marks);

        $ics = json_decode($request->ics);

        $quizid = json_decode($request->quizid);

        $limitpercen = DB::table('tblclassquiz')->where('id', $quizid)->first();

        foreach($marks as $key => $mrk)
        {

            if($mrk > $limitpercen->total_mark)
            {
                return ["message"=>"Field Error", "id" => $ics];
            }

        }

       
        $upsert = [];
        foreach($marks as $key => $mrk){
            $existingMark = DB::table('tblclassstudentquiz')
            ->where('userid', $ics[$key])
            ->where('quizid', $quizid)
            ->value('final_mark');

            array_push($upsert, [
            'userid' => $ics[$key],
            'quizid' => $quizid,
            'submittime' => date("Y-m-d H:i:s"),
            'final_mark' => ($mrk != '') ? $mrk : 0,
            'status' => 1
            ]);

            // if ($mrk != 0 && $mrk != $existingMark) {
            // $message = "Lecturer has marked your offline quiz.";
            // $url = url('/student/quiz2/' . $limitpercen->classid . '?session=' . $limitpercen->sessionid);
            // $icon = "fa-check fa-lg";
            // $iconColor = "#2b74f3"; // Example: set to a bright orange

            // $participant = UserStudent::where('ic', $ics[$key])->first();

            // Notification::send($participant, new MyCustomNotification($message, $url, $icon, $iconColor));
            // }
        }

        DB::table('tblclassstudentquiz')->upsert($upsert, ['userid', 'quizid']);

        return ["message"=>"Success", "id" => $ics];

    }
}