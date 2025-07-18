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

class QuizController extends Controller
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

    public function studentquizlist($subjectId)
    {
        $user = Auth::guard('student')->user();
        
        // Ensure session is set up for the subject
        $this->ensureSessionSetup($subjectId);
        
        $group = array();
        $chapter = array();

        $data = DB::table('tblclassquiz')->join('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
                ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
                ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
                ->where([
                    ['tblclassquiz.classid', $subjectId],
                    ['tblclassquiz.status', '!=', 3],
                    ['tblclassquiz.date_from','!=', null],
                    ['schools.id', $user->school_id],
                    ['tblclassquiz.Addby', Session::get('teach')->ic]
                ])->select('tblclassquiz.*', 'tblclassquizstatus.statusname', 'tblclassquiz_group.groupname', 'schools.name as schoolname')->get();

      
        foreach($data as $dt)
        {
            $group[] = DB::table('tblclassquiz_group')
                    ->join('teacher_subjects', 'tblclassquiz_group.groupid', 'teacher_subjects.id')
                    ->where('tblclassquiz_group.quizid', $dt->id)->get();

            $chapter[] = DB::table('tblclassquiz_chapter')
                    ->join('material_dir', 'tblclassquiz_chapter.chapterid', 'material_dir.DrID')
                    ->where('tblclassquiz_chapter.quizid', $dt->id)->get();
        }

        return view('student.subject_assessment.quiz', compact('data', 'chapter'));

    }

    public function studentquizstatus($subjectId, $quizId)
    {
        $user = Auth::guard('student')->user();
        
        // Ensure session is set up for the subject
        $this->ensureSessionSetup($subjectId);

        $group = School::all();
                
        $tsubject = DB::table('teacher_subjects')
                ->where('user_id', $user->id)
                ->where('subject_id', $subjectId)
                ->first();

        $quiz = DB::table('students')
                ->join('schools', 'students.school_id', 'schools.id')
                ->join('tblclassquiz_group', function($join){
                    $join->on('schools.id', 'tblclassquiz_group.groupname');
                })
                ->join('tblclassquiz', 'tblclassquiz_group.quizid', 'tblclassquiz.id')
                ->select( 'students.*', 'tblclassquiz.id AS clssid', 'tblclassquiz.total_mark', 'tblclassquiz.date_from', 'tblclassquiz.date_to', 'students.name', 'tblclassquiz.status')
                ->where([
                    ['tblclassquiz.classid', $subjectId],
                    ['tblclassquiz.id', $quizId],
                    ['students.ic', $user->ic]
                ])->get();

        $status = [];

        foreach($quiz as $key => $qz)
        {
            $status[$key] = DB::table('tblclassstudentquiz')
            ->where([
                ['quizid', $qz->clssid],
                ['userid', $qz->ic]
            ])->first();
        }

        //dd($status[$key]);

        return view('student.subject_assessment.quizstatus', compact('quiz', 'status'));
    }

    public function quizview(Request $request){

        $id = $request->quiz;

        if(DB::table('tblclassstudentquiz')
        ->where([
            ['userid', Auth::guard('student')->user()->ic],
            ['quizid', $id]
         ])->exists()) {

            $quiz = DB::table('tblclassquiz')
            ->leftjoin('tblclassstudentquiz', function($join) 
            {
                $join->on('tblclassquiz.id', '=', 'tblclassstudentquiz.quizid');
            })
            ->where('tblclassstudentquiz.userid',  '=', Auth::guard('student')->user()->ic);

         }else{


            $quiz = DB::table('tblclassquiz')
            ->leftjoin('tblclassstudentquiz', function($join) 
            {
                $join->on('tblclassquiz.id', '=', 'tblclassstudentquiz.quizid');
                $join->on('tblclassstudentquiz.userid',  '=', DB::raw('1234'));
            });

         }

         $quiz = $quiz->leftJoin('students', 'tblclassstudentquiz.userid', 'students.ic')
         ->leftJoin('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
         ->select('tblclassquiz.*', 'tblclassstudentquiz.userid', 'tblclassstudentquiz.quizid','students.name', 
             DB::raw('tblclassquiz.status as classquizstatus'),
             DB::raw('tblclassstudentquiz.status as studentquizstatus'), 'tblclassstudentquiz.endtime', 'tblclassstudentquiz.starttime' , 
             DB::raw('TIMESTAMPDIFF(SECOND, now(), endtime) as timeleft'),
             DB::raw('tblclassstudentquiz.content as studentquizcontent')
         )
         ->where('tblclassquiz.id', $id)
         ->get()->first();

        $quizformdata = json_decode($quiz->content)->formData;

        if(!empty($quiz->studentquizcontent)){
            $quizformdata = json_decode($quiz->studentquizcontent)->formData;
        }

        foreach($quizformdata as $index => $v){

            if(!empty($quizformdata[$index]->className) ){
                if ($v->type === 'file') {
                    $quizformdata[$index]->disabled = true;
                    $quizformdata[$index]->label = null;
                    $quizformdata[$index]->description = null;
                }

                if(str_contains($quizformdata[$index]->className, "collected-marks")){
                    $quizformdata[$index]->type = "paragraph";
                    $quizformdata[$index]->label = $quizformdata[$index]->values[0]->label;
                }

                if(str_contains($quizformdata[$index]->className, "correct-answer")){
                    $quizformdata[$index]->className = "correct-answer d-none";
                    unset($quizformdata[$index]->label);
                }

                if(str_contains($quizformdata[$index]->className, "feedback-text")){
                    $quizformdata[$index]->className = "feedback-text d-none";
                    unset($quizformdata[$index]->label);
                }

                if(str_contains($quizformdata[$index]->className, "inputmark")){
                    $quizformdata[$index]->className = "inputmark d-none";
                    unset($quizformdata[$index]->label);
                }
            }
        }

        if($quiz->classquizstatus == 2){
            if($quiz->studentquizstatus == 2 || $quiz->studentquizstatus == 3){
                //completed quiz
                return redirect('/student/quiz/'.$quiz->quizid.'/'. Auth::guard('student')->user()->ic. '/result');
            }else{
                $data['quiz'] = json_encode($quizformdata );
                $data['quizid'] = $quiz->id;
                $data['quiztitle'] = $quiz->title;
                $data['quizduration'] = $quiz->duration;
                $data['quizendduration'] = $quiz->date_to;
                $data['fullname'] = $quiz->name;
                $data['created_at'] = $quiz->created_at;
                $data['updated_at'] = $quiz->updated_at;
                $data['quizstarttime'] = $quiz->starttime;
                $data['quizendtime'] = $quiz->endtime;
                $data['quiztimeleft'] = $quiz->timeleft;
        
                return view('student.subject_assessment.quizanswer', compact('data'));
            }
        }else{
            return "Quiz is not published yet";
        }
    }

    public function startquiz(Request $request){

        $quiz = $request->quiz;
        $data = $request->data;
        
        $quizduration = DB::table('tblclassquiz')->select('duration')->where('id', $quiz)->first()->duration;
        
        try{
            DB::beginTransaction();
            $q =  DB::table('tblclassstudentquiz')->insert([
                "userid" =>  Auth::guard('student')->user()->ic,
                "quizid" => $quiz,
                "content" => $data,
                "starttime" =>  DB::raw('now()'),
                "endtime" => DB::raw('now() + INTERVAL '.$quizduration.' MINUTE'),
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

    public function savequiz(Request $request){

        $data = $request->data;
        $quizid = $request->quiz;


        $q = DB::table('tblclassstudentquiz')->where('status', 1)->where('quizid',$quizid)->where('userid', Auth::guard('student')->user()->ic)->update([
            "content" => $data
        ]);

        $q = ($q == 1) ? true : false;

        return $q;
     
    }

    public function submitquiz(Request $request){
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

        $quiz = DB::table('tblclassquiz')
            ->leftjoin('tblclassstudentquiz', function($join) 
            {
                $join->on('tblclassquiz.id', '=', 'tblclassstudentquiz.quizid');
                $join->on('tblclassstudentquiz.userid',  '=', DB::raw('12345'));
            })
            ->select('tblclassquiz.*', 'tblclassstudentquiz.userid', DB::raw('tblclassstudentquiz.status as studentquizstatus'),
             'tblclassstudentquiz.quizid')
            ->where('tblclassquiz.id', $id)
            ->get()->first();

        if($quiz->studentquizstatus == 2 || $quiz->studentquizstatus == 3){
            return ["status"=>false, "message" =>"Sorry, you have completed the quiz before."];
        }

        $q = DB::table('tblclassstudentquiz')->upsert([
            "userid" => Auth::guard('student')->user()->ic,
            "quizid" => $id,
            "submittime" => DB::raw('now()'),
            "content" => $data,
            "status" => 2
        ],['userid', 'quizid']);

        return ["status"=>true, "message" =>$data];
     
    }

    public function quizresultstd(Request $request){
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
                'tblclassquiz.duration','students.name')
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
    
        return view('student.subject_assessment.quizresult', compact('data'));
    }

    public function studentquiz2list($subjectId)
    {
        $user = Auth::guard('student')->user();
        
        // Ensure session is set up for the subject
        $this->ensureSessionSetup($subjectId);
        
        $group = array();
        $chapter = array();

        $data = DB::table('tblclassquiz')
                ->join('tblclassquiz_group', 'tblclassquiz.id', 'tblclassquiz_group.quizid')
                ->join('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
                ->join('schools', 'tblclassquiz_group.groupname', 'schools.id')
                ->where([
                    ['tblclassquiz.classid', $subjectId],
                    ['tblclassquiz.date_from', null],
                    ['tblclassquiz.status', '!=', 3],
                    ['schools.id', $user->school_id],
                    ['tblclassquiz.Addby', Session::get('teach')->ic]
                ])
                ->select('tblclassquiz.*', 'tblclassquizstatus.statusname', 'tblclassquiz_group.groupname', 'schools.name as schoolname')->get();

            $chapter = [];
            $marks = [];

            foreach($data as $dt)
            {
                $group[] = DB::table('tblclassquiz_group')
                        ->join('teacher_subjects', 'tblclassquiz_group.groupid', 'teacher_subjects.id')
                        ->where('tblclassquiz_group.quizid', $dt->id)->get();

                $chapter[] = DB::table('tblclassquiz_chapter')
                        ->join('material_dir', 'tblclassquiz_chapter.chapterid', 'material_dir.DrID')
                        ->where('tblclassquiz_chapter.quizid', $dt->id)->get();

                $marks[] = DB::table('tblclassstudentquiz')
                        ->where([
                          ['quizid', $dt->id],
                          ['userid', $user->ic]
                        ])->get();
            }

        return view('student.subject_assessment.quiz2', compact('data', 'chapter', 'marks'));

    }
    
}