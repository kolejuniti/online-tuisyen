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
use App\Notifications\AssignmentNotification;
use App\Models\UserStudent;
use Illuminate\Support\Facades\Artisan;
use App\Models\School;

class TestController extends Controller
{
    /**
     * Send notification to students affected by a test action
     */
    private function sendTestNotificationToStudents($testId, $subjectId, $title, $message, $actionType)
    {
        // Get all students who are affected by this test
        $students = DB::table('students')
            ->join('schools', 'students.school_id', 'schools.id')
            ->join('tblclasstest_group', 'schools.id', 'tblclasstest_group.groupname')
            ->where('tblclasstest_group.testid', $testId)
            ->where('students.status', 'active')
            ->select('students.*')
            ->distinct('students.ic')
            ->get();

        if ($students->count() > 0) {
            // Determine the appropriate URL based on test type
            $test = DB::table('tblclasstest')->where('id', $testId)->first();
            $testUrl = empty($test->date_from) ? route('student.test2', $subjectId) : route('student.test', $subjectId);
            
            $notificationData = [
                'type' => 'test',
                'test_id' => $testId,
                'subject_id' => $subjectId,
                'title' => $title,
                'action_type' => $actionType,
                'url' => $testUrl
            ];

            foreach($students as $studentData) {
                $student = student::where('ic', $studentData->ic)->first();
                if ($student) {
                    $student->notify(new AssignmentNotification($message, $notificationData));
                }
            }
        }
    }
    
    public function testlist()
    {

        $user = Auth::user();
        $group = array();

        $chapter = array();

        $data = DB::table('tblclasstest')->join('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
                ->where([
                    ['tblclasstest.classid', Session::get('subjects')->id],
                    ['tblclasstest.addby', $user->ic],
                    ['tblclasstest.status', '!=', 3],
                    ['tblclasstest.date_from','!=', null]
                ])->select('tblclasstest.*', 'tblclassteststatus.statusname')->get();

      
            foreach($data as $dt)
            {
                $group[] = DB::table('tblclasstest_group')
                        ->join('teacher_subjects', 'tblclasstest_group.groupid', 'teacher_subjects.id')
                        ->where('tblclasstest_group.testid', $dt->id)->get();

                $chapter[] = DB::table('tblclasstest_chapter')
                        ->join('material_dir', 'tblclasstest_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclasstest_chapter.testid', $dt->id)->get();
            }
      

        return view('user.subject_assessment.test', compact('data', 'group', 'chapter'));
    }

    public function getExtendTest(Request $request)
    {

        $data['test'] = DB::table('tblclasstest')->where('id', $request->id)->first();

        return view('user.subject_assessment.testGetExtend', compact('data'));

    }

    public function updateExtendTest(Request $request)
    {
        $testId = $request->id;
        
        // Get test details before updating
        $test = DB::table('tblclasstest')->where('id', $testId)->first();
        
        DB::table('tblclasstest')->where('id', $testId)->update([
            'date_from' => $request->from,
            'date_to' => $request->to,
            'duration' => $request->duration
        ]);

        // Send notification to students about the extension
        $this->sendTestNotificationToStudents($testId, $test->classid, $test->title, 
            "Test '{$test->title}' deadline has been extended to " . date('M j, Y g:i A', strtotime($request->to)) . ".",
            'test_extended'
        );

        return back()->with('message', 'Success!');

    }

    public function deletetest(Request $request)
    {
        try {
            $testId = $request->id;
            $test = DB::table('tblclasstest')->where('id', $testId)->first();

            if($test->status != 3)
            {
                DB::table('tblclasstest')->where('id', $testId)->update([
                    'status' => 3
                ]);

                // Send notification to students about the deletion
                $this->sendTestNotificationToStudents($testId, $test->classid, $test->title, 
                    "Test '{$test->title}' has been cancelled by your teacher.",
                    'test_deleted'
                );

                return true;
            }else{
                die;
            }
          
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function testcreate()
    {
        $user = Auth::user();

        $data['testid'] = null;

        $data['reuse'] = null;

        $courseid = Session::get('subjects')->id;

        $group = School::where('status', 'active')->get();

        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', $courseid)
                ->first();

        $folder = DB::table('lecturer_dir')
                  ->join('subjects', 'lecturer_dir.CourseID','subjects.id')
                  ->where('subjects.id', $courseid)
                  ->where('Addby', $user->ic)->get();

        if(isset(request()->testid))
        {

            $testid = request()->testid;
 
            $data['testid'] = $testid;

            $data['test'] = DB::table('tblclasstest')->select('tblclasstest.*')
            ->where([
                ['id', $testid]
            ])->get()->first();

            $data['teststatus'] = $data['test']->status;

            if(isset(request()->REUSE))
            {
                $data['reuse'] = request()->REUSE;
            }

        }

        return view('user.subject_assessment.testcreate', compact(['group', 'folder', 'data', 'tsubject']));
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

        $test = DB::table('student_subjek')
                ->join('tblclasstest_group', 'student_subjek.group_id', 'tblclasstest_group.groupid')
                ->join('tblclasstest', 'tblclasstest_group.testid', 'tblclasstest.id')
                ->join('students', 'student_subjek.ic', 'students.ic')
                ->select('student_subjek.*', 'tblclasstest.id AS clssid', 'tblclasstest.total_mark', 'students.no_matric', 'students.name')
                ->where([
                    ['tblclasstest.classid', Session::get('subjects')->id],
                    ['tblclasstest.sessionid', Session::get('SessionIDS')],
                    ['tblclasstest.id', $request->test],
                    ['tblclasstest.addby', $user->ic],
                    ['tblclasstest_group.groupid', $request->group]
                ])->get();
        
        //dd($test);

        foreach($test as $qz)
        {
            $statu[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->ic]
            ])->get();
        }

        //dd($test);

        return view('user.subject_assessment.getstatustest', compact('test', 'status'));

    }


    public function inserttest(Request $request){
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
            
        $testid = empty($request->test) ? '' : $request->test;

        $statusReuse = empty($request->reuse) ? '' : $request->reuse;

        $groupJSON = $request->input('group');
        $chapterJSON = $request->input('chapter');

        // Decode the JSON strings into PHP arrays
        $group = json_decode($groupJSON, true);
        $chapter = json_decode($chapterJSON, true);

        if( !empty($statusReuse))
        {
            $q = DB::table('tblclasstest')->insertGetId([
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
                
                DB::table('tblclasstest_group')->insert([
                    "groupid" => $gp[0],
                    "groupname" => $gp[1],
                    "testid" => $q
                ]);
            }

            foreach($chapter as $chp)
            {
                DB::table('tblclasstest_chapter')->insert([
                    "chapterid" => $chp,
                    "testid" => $q
                ]);
            }
            
        }else{
            if( !empty($testid) ){
                $q = DB::table('tblclasstest')->where('id', $testid)->update([
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

                DB::table('tblclasstest_group')->where('testid',$testid)->delete();

                foreach($group as $grp)
                {
                    $gp = explode('|', $grp);
                    
                    DB::table('tblclasstest_group')->insert([
                        "groupid" => $gp[0],
                        "groupname" => $gp[1],
                        "testid" => $testid
                    ]);
                }

                DB::table('tblclasstest_chapter')->where('testid',$testid)->delete();

                foreach($chapter as $chp)
                {
                    DB::table('tblclasstest_chapter')->insert([
                        "chapterid" => $chp,
                        "testid" => $testid
                    ]);
                }

            }else{
                $q = DB::table('tblclasstest')->insertGetId([
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
                    
                    DB::table('tblclasstest_group')->insert([
                        "groupid" => $gp[0],
                        "groupname" => $gp[1],
                        "testid" => $q
                    ]);
                }

                foreach($chapter as $chp)
                {
                    DB::table('tblclasstest_chapter')->insert([
                        "chapterid" => $chp,
                        "testid" => $q
                    ]);
                }
            }
        }

        // Set the directory path
        $dir = "classtest/" . Session::get('subjects')->id . "/" . "testimage" . "/" . $q . "/";

        $newNames = [];

        // Set the directory path (STAGING)
        // $dir = "classtest/" . Session::get('subjects')->id . "/" . "testimage" . "/";

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

                    // Replace the corresponding image input with the img tag in the test content
                    $data = str_replace($inputSubtype . '_' . $i, $imgTag, $data);
                }
            }
        }

        
        
        // Decode the JSON content of the test into a PHP array
        $test_content = json_decode($data, true);

        // Define the Linode Object Storage base URL
        $linode_base_url = rtrim(env('LINODE_ENDPOINT'), '/') . '/' . env('LINODE_BUCKET') . '/' . $dir; // Replace this with your Linode Object Storage base URL

        // Iterate through the "formData" array and update the image URLs
        // Iterate through the "formData" array and update the image URLs
        $fileIndex = 0; // Initialize the file index
        foreach ($test_content['formData'] as $index => $item) {
            if ($item['type'] === 'file' && isset($item['name'])) {
                // Construct the original name using the file index
                $originalName2 = 'uploaded_image[' . $fileIndex . ']';

                // Check if a new name exists for this file in the $newNames array
                if (isset($newNames[$originalName2])) {
                    // Prepend the Linode Object Storage base URL to the new name
                    $test_content['formData'][$index]['name'] = $linode_base_url . $newNames[$originalName2];
                }

                $fileIndex++; // Increment the file index
            }
        }

        // Re-encode the test content to JSON format
        $updated_content = json_encode($test_content);

        // Update the content field in the database with the updated content
        DB::table('tblclasstest')->where('id', $q)->update([
            "content" => $updated_content
        ]);

        // Send notifications to students
        if (!empty($group)) {
            $allStudents = collect();

            foreach($group as $grp) {
                $gp = explode('|', $grp);
                $schoolId = $gp[1]; // groupname contains school ID
                
                // Get all students from this school
                $students = student::where('school_id', $schoolId)
                    ->where('status', 'active')
                    ->get();

                $allStudents = $allStudents->merge($students);
            }

            // Remove duplicates
            $allStudents = $allStudents->unique('id');

            if ($allStudents->count() > 0) {
                $testType = empty($from) ? 'offline test' : 'online test';
                $message = "A new {$testType} titled '{$title}' has been created.";
                
                $testUrl = empty($from) ? route('student.test2', $classid) : route('student.test', $classid);
                
                $notificationData = [
                    'type' => 'test',
                    'test_id' => $q,
                    'subject_id' => $classid,
                    'title' => $title,
                    'test_type' => $testType,
                    'date_from' => $from,
                    'date_to' => $to,
                    'url' => $testUrl
                ];

                foreach($allStudents as $student) {
                    $student->notify(new AssignmentNotification($message, $notificationData));
                }
            }
        }
        
        return true;

    }

    public function lecturerteststatus()
    {
        $user = Auth::user();

        $group = School::all();
                
        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', Session::get('subjects')->id)
                ->first();

        $test = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclasstest_group', function($join){
                    $join->on('schools.id', 'tblclasstest_group.groupname');
                })
                ->join('tblclasstest', 'tblclasstest_group.testid', 'tblclasstest.id')
                ->select( 'students.*', 'tblclasstest.id AS clssid', 'tblclasstest.total_mark', 'tblclasstest.date_from', 'tblclasstest.date_to', 'students.name')
                ->where([
                    ['tblclasstest.classid', Session::get('subjects')->id],
                    ['tblclasstest.id', request()->test],
                    ['tblclasstest.addby', $user->ic]
                ])->get();

        $status = [];

        foreach($test as $qz)
        {
            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->ic]
            ])->get();
        }

        //dd($test);

        return view('user.subject_assessment.teststatus', compact('test', 'status', 'group', 'tsubject' ));

    }

    public function testGetGroup(Request $request)
    {

        $user = Auth::user();

        $gp = explode('|', $request->group);

        $test = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclasstest_group', function($join){
                    $join->on('schools.id', 'tblclasstest_group.groupname');
                })
                ->join('tblclasstest', 'tblclasstest_group.testid', 'tblclasstest.id')
                ->select( 'students.*', 'tblclasstest.id AS clssid', 'tblclasstest.total_mark', 'tblclasstest.date_from', 'tblclasstest.date_to', 'students.name')
                ->where([
                    ['tblclasstest.classid', Session::get('subjects')->id],
                    ['tblclasstest.id', request()->test],
                    ['tblclasstest.addby', $user->ic],
                    ['tblclasstest_group.groupid', $gp[0]],
                    ['tblclasstest_group.groupname', $gp[1]]
                ])->get();
        
        foreach($test as $qz)
        {
            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
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

        foreach ($test as $key => $qz) {
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
                            <a class="btn btn-success btn-sm mr-2" href="/user/test/' . request()->test . '/' . $sts->userid . '/result">
                                <i class="ti-pencil-alt"></i> Answer
                            </a>';
                    if (date('Y-m-d H:i:s') >= $qz->date_from && date('Y-m-d H:i:s') <= $qz->date_to) {
                        $content .= '
                            <a class="btn btn-danger btn-sm mr-2" onclick="deleteStdTest(\'' . $sts->id . '\')">
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

    public function deleteteststatus(Request $request)
    {

        DB::table('tblclassstudenttest')->where('id', $request->id)->delete();

        return true;
        
    }

    public function testresult(Request $request){
        
        $id = $request->testid;
        $userid = $request->userid;
        $count = 1;
    
        $test = DB::table('tblclassstudenttest')
            ->join('tblclasstest', 'tblclassstudenttest.testid', 'tblclasstest.id')
            ->leftJoin('students', 'tblclassstudenttest.userid', 'students.ic')
            ->select('tblclassstudenttest.*', 'tblclassstudenttest.testid', 'tblclasstest.title',  
                DB::raw('tblclasstest.content as original_content'), 
                'tblclasstest.questionindex',
                'tblclassstudenttest.userid',
                'tblclassstudenttest.submittime',
                DB::raw('tblclassstudenttest.status as studentteststatus'),
                'tblclasstest.duration','students.name',
                'tblclasstest.total_mark')
            ->where('tblclassstudenttest.testid', $id)
            ->where('tblclassstudenttest.userid', $userid)->get()->first();
       
        $testformdata = json_decode($test->content)->formData;
        $original_testformdata = json_decode($test->original_content)->formData;
        
        $gain_mark = false;
        $correct_label = " <i style='font-size:1.5em' class='fa fa-check text-success'></i>";
        $incorrect_label = " <i style='font-size:1.5em' class='fa fa-close text-danger'></i>";
    
        foreach($original_testformdata as $index => $q){
            if(!empty($original_testformdata[$index]->name)){
                // Handle radio questions
                if(preg_match('/^radio-question(\d+)$/', $original_testformdata[$index]->name, $matches)){
                    $question_number = $matches[1];
                    $i = 0;
                    
                    // Get and process correct answer(s)
                    $correct_answer_raw = $original_testformdata[$index + 1]->label;
                    $correct_answers = explode(",", $correct_answer_raw);
                    
                    // Trim whitespace from each correct answer
                    $correct_answers = array_map('trim', $correct_answers);
                    
                    foreach($testformdata[$index]->values as $v){
                        $value_trimmed = trim($v->value);
                        
                        if(in_array($value_trimmed, $correct_answers)){
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $correct_label;
                        } else {
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }
    
                    $userData = !empty($testformdata[$index]->userData[0]) ? trim($testformdata[$index]->userData[0]) : null;
    
                    if($userData && in_array($userData, $correct_answers)){
                        $gain_mark = true;
                    }
                    
                    if($question_number == $count) {
                        $count++;
                    }
                }
                
                // Handle checkbox questions
                if(preg_match('/^checkbox-question(\d+)$/', $original_testformdata[$index]->name, $matches)){
                    $question_number = $matches[1];
                    $i = 0;
                    
                    // Get and process correct answer(s)
                    $correct_answer_raw = $original_testformdata[$index + 1]->label;
                    $correct_answers = explode(",", $correct_answer_raw);
                    
                    // Trim whitespace from each correct answer
                    $correct_answers = array_map('trim', $correct_answers);
                    
                    foreach($testformdata[$index]->values as $v){
                        $value_trimmed = trim($v->value);
                        
                        if(in_array($value_trimmed, $correct_answers)){
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $correct_label;
                        } else {
                            $testformdata[$index]->values[$i]->label = $original_testformdata[$index]->values[$i]->label . $incorrect_label;
                        }
                        $i++;
                    }
                    
                    $userData = !empty($testformdata[$index]->userData) ? $testformdata[$index]->userData : [];
                    
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
    
            if(!empty($original_testformdata[$index]->className)){
                
                if(str_contains($original_testformdata[$index]->className, "feedback-text")){
                    $testformdata[$index] = $q;
                  
                    $testformdata[$index]->type = "paragraph";
    
                    if(!empty($q->userData[0])){
                        $testformdata[$index]->label = $q->userData[0];
                    }else{
                        $testformdata[$index]->label = " ";
                    }
                    $testformdata[$index]->className = "bg-red mb-4 text-danger";
                }
    
                if(str_contains($original_testformdata[$index]->className, "inputmark")){
                    $testformdata[$index]->type = "number";
    
                    if(!empty($q->userData[0])){
                        $testformdata[$index]->label = $q->userData[0];
                    }else{
                        $testformdata[$index]->label = " ";
                    }
    
                    $testformdata[$index]->className = "inputmark form-control";
                }
    
                if(str_contains($original_testformdata[$index]->className, "collected-marks")){
    
                    $mark_label = $original_testformdata[$index]->values[0]->label;
                    $mark = $original_testformdata[$index]->values[0]->value;
                    
                    //if result is published then use graded data
                    if($test->studentteststatus == 3){
                        $graded_data = empty($testformdata[$index]->userData[0]) ? "" : $testformdata[$index]->userData[0];
    
                        if($graded_data == $mark){
                            $testformdata[$index]->values[0]->selected = true;
                        }else{
                            $testformdata[$index]->values[0]->selected = false;
                        }
                    }else{
                        //auto correct answer on mcq by matching user answer with original answer
                        $testformdata[$index] = $original_testformdata[$index];
    
                        if($gain_mark){
                            $testformdata[$index]->values[0]->selected = true;
                        }else{
                            $testformdata[$index]->values[0]->selected = false;
                        }
                        
                        $gain_mark = false;
                    }
                }
            }
        }
       
        $data['test'] = $testformdata;
        $data['comments'] = $test->comments;
        $data['totalmark'] = $test->total_mark;
        $data['testid'] = $test->testid;
        $data['testtitle'] = $test->title;
        $data['testduration'] = $test->duration;
        $data['testuserid'] = $test->userid;
        $data['fullname'] = $test->name;
        $data['created_at'] = $test->created_at;
        $data['updated_at'] = $test->updated_at;
        $data['submittime'] = $test->submittime;
        $data['questionindex'] = $test->questionindex;
        $data['studentteststatus'] = $test->studentteststatus;
    
        return view('user.subject_assessment.testresult', compact('data'));
    }

    public function updatetestresult(Request $request){
        $testId = $request->test;
        $participantIc = $request->participant;
        $final_mark = (int) str_replace(' Mark', '', $request->final_mark);
        $comments = $request->comments;
        $data = $request->data;
      
        DB::table('tblclassstudenttest')
            ->where('testid', $testId)
            ->where("userid", $participantIc)
            ->update([
                "content" => $data,
                "final_mark" => $final_mark,
                "comments" => $comments,
                "status" => 3
            ]);

        // Get test details and send notification to the specific student
        $test = DB::table('tblclasstest')->where('id', $testId)->first();
        $student = student::where('ic', $participantIc)->first();
        
        if ($student && $test) {
            $testUrl = empty($test->date_from) ? route('student.test2', $test->classid) : route('student.test', $test->classid);
            
            $message = "Your test '{$test->title}' has been graded. Score: {$final_mark}/{$test->total_mark}";
            
            $notificationData = [
                'type' => 'test',
                'test_id' => $testId,
                'subject_id' => $test->classid,
                'title' => $test->title,
                'action_type' => 'test_graded',
                'score' => $final_mark,
                'total_marks' => $test->total_mark,
                'url' => $testUrl
            ];

            $student->notify(new AssignmentNotification($message, $notificationData));
        }
        
        return true;
    }

    public function generateAITest(Request $request) {
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
            
            // Step 3: Generate test JSON
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
            
            $testJSON = $this->generateFormBuilderJSON($text, $singleChoiceCount, $multipleChoiceCount, $subjectiveCount, $language);
            
            // Step 4: Return the test JSON
            return response()->json([
                'success' => true,
                'formBuilderJSON' => $testJSON,
            ]);
            
        } catch (\Exception $e) {
            // Handle errors gracefully
            Log::error('Error generating test: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating test: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Clears various Laravel caches
     * 
     * This method clears application cache, route cache, config cache, and view cache
     * to ensure fresh data on each test generation
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
            $prompt = "Create a test JSON structure based on the following text. The test should include:\n";
            
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
            $prompt .= '{"test":{"questions":[';
            
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
                            'content' => 'You are a system designed to generate test questions for FormBuilder. Follow the format requirements exactly.' . 
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
                if (!$decodedJson || !isset($decodedJson['test']) || !isset($decodedJson['test']['questions'])) {
                    // If the structure isn't valid, create a simple one with the requested counts
                    Log::warning('AI response did not contain valid test JSON structure. Creating default structure.');
                    
                    $defaultTest = ['test' => ['questions' => []]];
                    
                    // Return the default structure as JSON
                    return json_encode($defaultTest);
                }
                
                // Log the actual question counts vs requested
                $questions = $decodedJson['test']['questions'];
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


    public function test2list()
    {

        $user = Auth::user();
        $group = array();

        $chapter = array();

        $data = DB::table('tblclasstest')
                ->join('users', 'tblclasstest.addby', 'users.ic')
                ->join('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
                ->where([
                    ['tblclasstest.classid', Session::get('subjects')->id],
                    ['tblclasstest.addby', $user->ic],
                    ['tblclasstest.date_from', null],
                    ['tblclasstest.status', '!=', 3]
                ])
                ->select('tblclasstest.*', 'users.name AS addby', 'tblclassteststatus.statusname')->get();

            foreach($data as $dt)
            {
                $group[] = DB::table('tblclasstest_group')
                        ->join('teacher_subjects', 'tblclasstest_group.groupid', 'teacher_subjects.id')
                        ->where('tblclasstest_group.testid', $dt->id)->get();

                $chapter[] = DB::table('tblclasstest_chapter')
                        ->join('material_dir', 'tblclasstest_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclasstest_chapter.testid', $dt->id)->get();
            }
      

        return view('user.subject_assessment.test2', compact('data', 'group', 'chapter'));
    }

    public function test2create()
    {
        $user = Auth::user();

        $data['test'] = null;

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

        if(isset(request()->testid))
        {

            $data['test'] = DB::table('tblclasstest')->where('id', request()->testid)->first();
            
        }

        return view('user.subject_assessment.test2create', compact(['group', 'folder', 'data', 'tsubject']));
    }


    public function inserttest2(Request $request){

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

        $dir = "eTutor/classtest2/" .  $classid . "/" . $user->name . "/" . $title;
        $classtest2  = Storage::disk('linode')->makeDirectory($dir);
        $file = $request->file('myPdf');
            
        $testid = empty($request->test) ? '' : $request->test;

        if($group != null && $chapter != null)
        {
        
            if( !empty($testid) ){
                
                $test = DB::table('tblclasstest')->where('id', $testid)->first();

                Storage::disk('linode')->delete($test->content);

                DB::table('tblclasstest_group')->where('testid', $testid)->delete();

                DB::table('tblclasstest_chapter')->where('testid', $testid)->delete();

                $file_name = $file->getClientOriginalName();
                $file_ext = $file->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;
                $newpath = "eTutor/classtest2/" .  $classid . "/" . $user->name . "/" . $title . "/" . $newname;

                if(!file_exists($newname)){
                    Storage::disk('linode')->putFileAs(
                        $dir,
                        $file,
                        $newname,
                        'public'
                    );

                    $q = DB::table('tblclasstest')->where('id', $testid)->update([
                        "title" => $title,
                        'content' => $newpath,
                        "total_mark" => $marks,
                        "status" => 2
                    ]);

                    foreach($request->group as $grp)
                    {
                        $gp = explode('|', $grp);

                        DB::table('tblclasstest_group')->insert([
                            "groupid" => $gp[0],
                            "groupname" => $gp[1],
                            "testid" => $testid
                        ]);
                    }

                    foreach($request->chapter as $chp)
                    {
                        DB::table('tblclasstest_chapter')->insert([
                            "chapterid" => $chp,
                            "testid" => $testid
                        ]);
                    }

                }

            }else{
                $file_name = $file->getClientOriginalName();
                $file_ext = $file->getClientOriginalExtension();
                $fileInfo = pathinfo($file_name);
                $filename = $fileInfo['filename'];
                $newname = $filename . "." . $file_ext;
                $newpath = "eTutor/classtest2/" .  $classid . "/" . $user->name . "/" . $title . "/" . $newname;

                if(!file_exists($newname)){
                    Storage::disk('linode')->putFileAs(
                        $dir,
                        $file,
                        $newname,
                        'public'
                    );

                    $q = DB::table('tblclasstest')->insertGetId([
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

                        DB::table('tblclasstest_group')->insert([
                            "groupid" => $gp[0],
                            "groupname" => $gp[1],
                            "testid" => $q
                        ]);
                    }

                    foreach($request->chapter as $chp)
                    {
                        DB::table('tblclasstest_chapter')->insert([
                            "chapterid" => $chp,
                            "testid" => $q
                        ]);
                    }

                }

            }

            // Send notifications to students
            $allStudents = collect();

            foreach($request->group as $grp) {
                $gp = explode('|', $grp);
                $schoolId = $gp[1]; // groupname contains school ID
                
                // Get all students from this school
                $students = student::where('school_id', $schoolId)
                    ->where('status', 'active')
                    ->get();

                $allStudents = $allStudents->merge($students);
            }

            // Remove duplicates
            $allStudents = $allStudents->unique('id');

            if ($allStudents->count() > 0) {
                $message = "A new offline test titled '{$title}' has been created.";
                
                $notificationData = [
                    'type' => 'test',
                    'test_id' => $q,
                    'subject_id' => $classid,
                    'title' => $title,
                    'test_type' => 'offline test',
                    'url' => route('student.test2', $classid)
                ];

                foreach($allStudents as $student) {
                    $student->notify(new AssignmentNotification($message, $notificationData));
                }
            }

        }else{

            return redirect()->back()->withErrors(['Please fill in the group and sub-chapter checkbox !']);

        }
        
        
        return redirect(route('user.test2', ['id' => $classid]));
    }

    public function lecturertest2status()
    {
        $user = Auth::user();

        $group = School::all();
                
        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', Session::get('subjects')->id)
                ->first();
        
        $test = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclasstest_group', function($join){
                    $join->on('schools.id', 'tblclasstest_group.groupname');
                })
                ->join('tblclasstest', 'tblclasstest_group.testid', 'tblclasstest.id')
                ->select( 'students.*', 'tblclasstest.id AS clssid', 'tblclasstest.total_mark', 'students.name')
                ->where([
                    ['tblclasstest.classid', Session::get('subjects')->id],
                    ['tblclasstest.id', request()->test],
                    ['tblclasstest.addby', $user->ic]
                ])->get();

        foreach($test as $qz)
        {

           if(!DB::table('tblclassstudenttest')->where([['testid', $qz->clssid],['userid', $qz->ic]])->exists()){

                DB::table('tblclassstudenttest')->insert([
                    'testid' => $qz->clssid,
                    'userid' => $qz->ic,
                    'total_mark' => $qz->total_mark
                ]);

           }

            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->ic]
            ])->first();
        }

        return view('user.subject_assessment.test2status', compact('test', 'status', 'group', 'tsubject'));

    }

    public function test2GetGroup(Request $request)
    {

        $user = Auth::user();

        $gp = explode('|', $request->group);

        $test = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclasstest_group', function($join){
                    $join->on('schools.id', 'tblclasstest_group.groupname');
                })
                ->join('tblclasstest', 'tblclasstest_group.testid', 'tblclasstest.id')
                ->select( 'students.*', 'tblclasstest.id AS clssid', 'tblclasstest.total_mark', 'tblclasstest.date_from', 'tblclasstest.date_to', 'students.name')
                ->where([
                    ['tblclasstest.classid', Session::get('subjects')->id],
                    ['tblclasstest.id', request()->test],
                    ['tblclasstest.addby', $user->ic],
                    ['tblclasstest_group.groupid', $gp[0]],
                    ['tblclasstest_group.groupname', $gp[1]]
                ])->get();

        foreach($test as $qz)
        {

           if(!DB::table('tblclassstudenttest')->where([['testid', $qz->clssid],['userid', $qz->ic]])->exists()){

                DB::table('tblclassstudenttest')->insert([
                    'testid' => $qz->clssid,
                    'userid' => $qz->ic
                ]);

           }

            $status[] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
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
                            
        foreach ($test as $key => $qz) {
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

    public function updatetest2(Request $request)
    {
        $user = Auth::user();

        $marks = json_decode($request->marks);

        $ics = json_decode($request->ics);

        $testid = json_decode($request->testid);

        $limitpercen = DB::table('tblclasstest')->where('id', $testid)->first();

        foreach($marks as $key => $mrk)
        {

            if($mrk > $limitpercen->total_mark)
            {
                return ["message"=>"Field Error", "id" => $ics];
            }

        }

       
        $upsert = [];
        foreach($marks as $key => $mrk){
            $existingMark = DB::table('tblclassstudenttest')
            ->where('userid', $ics[$key])
            ->where('testid', $testid)
            ->value('final_mark');

            array_push($upsert, [
            'userid' => $ics[$key],
            'testid' => $testid,
            'submittime' => date("Y-m-d H:i:s"),
            'final_mark' => ($mrk != '') ? $mrk : 0,
            'status' => 1
            ]);

            // Send notification if mark has changed
            if ($mrk != 0 && $mrk != $existingMark) {
                $student = student::where('ic', $ics[$key])->first();
                
                if ($student) {
                    $message = "Your offline test '{$limitpercen->title}' has been graded. Score: {$mrk}/{$limitpercen->total_mark}";
                    
                    $notificationData = [
                        'type' => 'test',
                        'test_id' => $testid,
                        'subject_id' => $limitpercen->classid,
                        'title' => $limitpercen->title,
                        'action_type' => 'test_graded',
                        'score' => $mrk,
                        'total_marks' => $limitpercen->total_mark,
                        'url' => route('student.test2', $limitpercen->classid)
                    ];

                    $student->notify(new AssignmentNotification($message, $notificationData));
                }
            }
        }

        DB::table('tblclassstudenttest')->upsert($upsert, ['userid', 'testid']);

        return ["message"=>"Success", "id" => $ics];

    }
}