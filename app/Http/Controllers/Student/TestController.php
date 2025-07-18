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
use Smalot\PdfParser\Parser;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MyCustomNotification;
use App\Models\UserStudent;
use Illuminate\Support\Facades\Artisan;
use App\Models\School;
use Illuminate\Database\QueryException;

class TestController extends Controller
{
    /**
     * Ensure session variables are set up for the subject
     */
    private function ensureSessionSetup($subjectId)
    {
        // Check if session already has the subject data
        if (!Session::has('subjects') || Session::get('subjects')->id != $subjectId) {
            // Find the teacher subject record for this subject
            $teacherSubject = \App\Models\TeacherSubject::with('teacher')
                ->where('subject_id', $subjectId)
                ->first();
            
            if ($teacherSubject) {
                Session::put('teachers', $teacherSubject);
                
                $teacher = DB::table('users')->where('id', $teacherSubject->user_id)->first();
                Session::put('teach', $teacher);
                
                $subject = \App\Models\Subject::findOrFail($subjectId);
                Session::put('subjects', $subject);
            }
        }
    }

    public function studenttestlist($subjectId)
    {
        $user = Auth::guard('student')->user();
        
        // Ensure session is set up for the subject
        $this->ensureSessionSetup($subjectId);
        
        $group = array();
        $chapter = array();

        $data = DB::table('tblclasstest')->join('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
                ->join('tblclasstest_group', 'tblclasstest.id', 'tblclasstest_group.testid')
                ->join('schools', 'tblclasstest_group.groupname', 'schools.id')
                ->where([
                    ['tblclasstest.classid', $subjectId],
                    ['tblclasstest.status', '!=', 3],
                    ['tblclasstest.date_from','!=', null],
                    ['schools.id', $user->school_id],
                    ['tblclasstest.Addby', Session::get('teach')->ic]
                ])->select('tblclasstest.*', 'tblclassteststatus.statusname', 'tblclasstest_group.groupname', 'schools.name as schoolname')->get();

      
        foreach($data as $dt)
        {
            $group[] = DB::table('tblclasstest_group')
                    ->join('teacher_subjects', 'tblclasstest_group.groupid', 'teacher_subjects.id')
                    ->where('tblclasstest_group.testid', $dt->id)->get();

            $chapter[] = DB::table('tblclasstest_chapter')
                    ->join('material_dir', 'tblclasstest_chapter.chapterid', 'material_dir.DrID')
                    ->where('tblclasstest_chapter.testid', $dt->id)->get();
        }

        return view('student.subject_assessment.test', compact('data', 'chapter'));

    }

    public function studentteststatus($subjectId, $testId)
    {
        $user = Auth::guard('student')->user();
        
        // Ensure session is set up for the subject
        $this->ensureSessionSetup($subjectId);

        $group = School::all();
                
        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', $subjectId)
                ->first();

        $test = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclasstest_group', function($join){
                    $join->on('schools.id', 'tblclasstest_group.groupname');
                })
                ->join('tblclasstest', 'tblclasstest_group.testid', 'tblclasstest.id')
                ->select( 'students.*', 'tblclasstest.id AS clssid', 'tblclasstest.total_mark', 'tblclasstest.date_from', 'tblclasstest.date_to', 'students.name', 'tblclasstest.status')
                ->where([
                    ['tblclasstest.classid', $subjectId],
                    ['tblclasstest.id', $testId],
                    ['students.ic', $user->ic]
                ])->get();

        $status = [];

        foreach($test as $key => $qz)
        {
            $status[$key] = DB::table('tblclassstudenttest')
            ->where([
                ['testid', $qz->clssid],
                ['userid', $qz->ic]
            ])->first();
        }

        //dd($status[$key]);

        return view('student.subject_assessment.teststatus', compact('test', 'status'));
    }

    public function testview(Request $request){

        $id = $request->test;

        if(DB::table('tblclassstudenttest')
        ->where([
            ['userid', Auth::guard('student')->user()->ic],
            ['testid', $id]
         ])->exists()) {

            $test = DB::table('tblclasstest')
            ->leftjoin('tblclassstudenttest', function($join) 
            {
                $join->on('tblclasstest.id', '=', 'tblclassstudenttest.testid');
            })
            ->where('tblclassstudenttest.userid',  '=', Auth::guard('student')->user()->ic);

         }else{


            $test = DB::table('tblclasstest')
            ->leftjoin('tblclassstudenttest', function($join) 
            {
                $join->on('tblclasstest.id', '=', 'tblclassstudenttest.testid');
                $join->on('tblclassstudenttest.userid',  '=', DB::raw('1234'));
            });

         }

         $test = $test->leftJoin('students', 'tblclassstudenttest.userid', 'students.ic')
         ->leftJoin('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
         ->select('tblclasstest.*', 'tblclassstudenttest.userid', 'tblclassstudenttest.testid','students.name', 
             DB::raw('tblclasstest.status as classteststatus'),
             DB::raw('tblclassstudenttest.status as studentteststatus'), 'tblclassstudenttest.endtime', 'tblclassstudenttest.starttime' , 
             DB::raw('TIMESTAMPDIFF(SECOND, now(), endtime) as timeleft'),
             DB::raw('tblclassstudenttest.content as studenttestcontent')
         )
         ->where('tblclasstest.id', $id)
         ->get()->first();

        $testformdata = json_decode($test->content)->formData;

        if(!empty($test->studenttestcontent)){
            $testformdata = json_decode($test->studenttestcontent)->formData;
        }

        foreach($testformdata as $index => $v){

            if(!empty($testformdata[$index]->className) ){
                if ($v->type === 'file') {
                    $testformdata[$index]->disabled = true;
                    $testformdata[$index]->label = null;
                    $testformdata[$index]->description = null;
                }

                if(str_contains($testformdata[$index]->className, "collected-marks")){
                    $testformdata[$index]->type = "paragraph";
                    $testformdata[$index]->label = $testformdata[$index]->values[0]->label;
                }

                if(str_contains($testformdata[$index]->className, "correct-answer")){
                    $testformdata[$index]->className = "correct-answer d-none";
                    unset($testformdata[$index]->label);
                }

                if(str_contains($testformdata[$index]->className, "feedback-text")){
                    $testformdata[$index]->className = "feedback-text d-none";
                    unset($testformdata[$index]->label);
                }

                if(str_contains($testformdata[$index]->className, "inputmark")){
                    $testformdata[$index]->className = "inputmark d-none";
                    unset($testformdata[$index]->label);
                }
            }
        }

        if($test->classteststatus == 2){
            if($test->studentteststatus == 2 || $test->studentteststatus == 3){
                //completed test
                return redirect('/student/test/'.$test->testid.'/'. Auth::guard('student')->user()->ic. '/result');
            }else{
                $data['test'] = json_encode($testformdata );
                $data['testid'] = $test->id;
                $data['testtitle'] = $test->title;
                $data['testduration'] = $test->duration;
                $data['testendduration'] = $test->date_to;
                $data['fullname'] = $test->name;
                $data['created_at'] = $test->created_at;
                $data['updated_at'] = $test->updated_at;
                $data['teststarttime'] = $test->starttime;
                $data['testendtime'] = $test->endtime;
                $data['testtimeleft'] = $test->timeleft;
        
                return view('student.subject_assessment.testanswer', compact('data'));
            }
        }else{
            return "Test is not published yet";
        }
    }

    public function starttest(Request $request){

        $test = $request->test;
        $data = $request->data;
        
        $testduration = DB::table('tblclasstest')->select('duration')->where('id', $test)->first()->duration;
        
        try{
            DB::beginTransaction();
            $q =  DB::table('tblclassstudenttest')->insert([
                "userid" =>  Auth::guard('student')->user()->ic,
                "testid" => $test,
                "content" => $data,
                "starttime" =>  DB::raw('now()'),
                "endtime" => DB::raw('now() + INTERVAL '.$testduration.' MINUTE'),
                "status" => 1
            ]);
            DB::commit();
        }catch(QueryException $ex){
            if($ex->getCode() == 23000){
            }else{
                Log::debug($ex);
            }
        }
    }

    public function savetest(Request $request){

        $data = $request->data;
        $testid = $request->test;


        $q = DB::table('tblclassstudenttest')->where('status', 1)->where('testid',$testid)->where('userid', Auth::guard('student')->user()->ic)->update([
            "content" => $data
        ]);

        $q = ($q == 1) ? true : false;

        return $q;
     
    }

    public function submittest(Request $request){
        $data = $request->data;
        $id = $request->id;

         // Decode the JSON data
        $decodedData = json_decode($data, true);

        // Iterate over formData and update checkbox groups
        foreach ($decodedData['formData'] as &$item) {
            if ($item['type'] == 'checkbox-group') {
                if (empty($item['userData']) || !isset($item['userData'])) {
                    $item['userData'] = [" "];
                }
            }
        }

        // Encode the data back to JSON
        $data = json_encode($decodedData);

        $test = DB::table('tblclasstest')
            ->leftjoin('tblclassstudenttest', function($join) 
            {
                $join->on('tblclasstest.id', '=', 'tblclassstudenttest.testid');
                $join->on('tblclassstudenttest.userid',  '=', DB::raw('12345'));
            })
            ->select('tblclasstest.*', 'tblclassstudenttest.userid', DB::raw('tblclassstudenttest.status as studentteststatus'),
             'tblclassstudenttest.testid')
            ->where('tblclasstest.id', $id)
            ->get()->first();

        if($test->studentteststatus == 2 || $test->studentteststatus == 3){
            return ["status"=>false, "message" =>"Sorry, you have completed the test before."];
        }

        $q = DB::table('tblclassstudenttest')->upsert([
            "userid" => Auth::guard('student')->user()->ic,
            "testid" => $id,
            "submittime" => DB::raw('now()'),
            "content" => $data,
            "status" => 2
        ],['userid', 'testid']);

        return ["status"=>true, "message" =>$data];
     
    }

    public function testresultstd(Request $request){
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
                'tblclasstest.duration','students.name')
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
    
        return view('student.subject_assessment.testresult', compact('data'));
    }

    public function studenttest2list($subjectId)
    {
        $user = Auth::guard('student')->user();
        
        // Ensure session is set up for the subject
        $this->ensureSessionSetup($subjectId);
        
        $group = array();
        $chapter = array();

        $data = DB::table('tblclasstest')
                ->join('tblclasstest_group', 'tblclasstest.id', 'tblclasstest_group.testid')
                ->join('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
                ->join('schools', 'tblclasstest_group.groupname', 'schools.id')
                ->where([
                    ['tblclasstest.classid', $subjectId],
                    ['tblclasstest.date_from', null],
                    ['tblclasstest.status', '!=', 3],
                    ['schools.id', $user->school_id],
                    ['tblclasstest.Addby', Session::get('teach')->ic]
                ])
                ->select('tblclasstest.*', 'tblclassteststatus.statusname', 'tblclasstest_group.groupname', 'schools.name as schoolname')->get();

            $chapter = [];
            $marks = [];

            foreach($data as $dt)
            {
                $group[] = DB::table('tblclasstest_group')
                        ->join('teacher_subjects', 'tblclasstest_group.groupid', 'teacher_subjects.id')
                        ->where('tblclasstest_group.testid', $dt->id)->get();

                $chapter[] = DB::table('tblclasstest_chapter')
                        ->join('material_dir', 'tblclasstest_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclasstest_chapter.testid', $dt->id)->get();

                $marks[] = DB::table('tblclassstudenttest')
                        ->where([
                          ['testid', $dt->id],
                          ['userid', $user->ic]
                        ])->get();
            }

        return view('student.subject_assessment.test2', compact('data', 'chapter', 'marks'));

    }
    
}