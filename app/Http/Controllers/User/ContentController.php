<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Subject;
class ContentController extends Controller
{
    public function deleteContent(Request $request)
    {

        $directory = DB::table('lecturer_dir')
                ->select('lecturer_dir.DrName as A')
                ->where('lecturer_dir.DrID', $request->dir)->first();

        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A;

        Storage::disk('linode')->deleteDirectory($dir);

        DB::table('lecturer_dir')->where('DrID', $request->dir)->delete();

        return true;

    }

    public function renameContent(Request $request)
    {

        if($request->name != null)
        {
        $directory = DB::table('lecturer_dir')->where('lecturer_dir.DrID', $request->dir)->update([
            'newDrName' => $request->name
        ]);

        //THIS IS TO RENAME USING HELPER STORAGE
        //$olddir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A;
        //$newdir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $request->name;
        //Storage::disk('linode')->move($olddir, $newdir);
        //DB::table('lecturer_dir')->where('lecturer_dir.DrID', $request->dir)->update([
            //'DrName' => $request->name
        //]);

        return true;

        }else{
            return false;
        }

    }

    public function deleteFolder(Request $request)
    {

        $directory = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B')
                ->where('material_dir.DrID', $request->dir)->first();

        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B;

        Storage::disk('linode')->deleteDirectory($dir);

        DB::table('material_dir')->where('DrID', $request->dir)->delete();

        return true;

    }

    public function renameFolder(Request $request)
    {

        if($request->name != null)
        {
            $directory = DB::table('lecturer_dir')
            ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
            ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B')
            ->where('material_dir.DrID', $request->dir)->update([
                'material_dir.newDrName' => $request->name
            ]);

        //$olddir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B;
        //$newdir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $request->name;
        //Storage::disk('linode')->move($olddir, $newdir);
        //DB::table('material_dir')->where('material_dir.DrID', $request->dir)->update([
        //    'DrName' => $request->name
        //]);

        return true;

        }else{
            return false;
        }

    }

    public function deleteSubfolder(Request $request)
    {

        $directory = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->join('materialsub_dir', 'material_dir.DrID', 'materialsub_dir.MaterialDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'materialsub_dir.DrName as C', 'materialsub_dir.Password', 'materialsub_dir.MaterialDirID', 'materialsub_dir.DrID')
                ->where('materialsub_dir.DrID', $request->dir)->first();

        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" . $directory->C;

        Storage::disk('linode')->deleteDirectory($dir);

        DB::table('materialsub_dir')->where('DrID', $request->dir)->delete();

        return true;
    }

    public function deleteSubfolderFile(Request $request)
    {

        Storage::disk('linode')->delete($request->mats);

        return true;

    }

    public function deleteMaterial(Request $request)
    {

        Storage::disk('linode')->delete($request->mats);

        return true;

    }
    
    public function deleteUrl(Request $request)
    {

        DB::table('materialsub_url')->where('DrID', $request->id)->delete();

        return true;

    }

    public function renameSubfolder(Request $request)
    {

        if($request->name != null)
        {
            DB::table('materialsub_dir')->where('DrID', $request->dir)->update([
                'newDrName' => $request->name
            ]);

        return true;

        }else{
            return false;
        }

    }

    public function renameFileSubfolder(Request $request)
    {

        if($request->name != null)
        {
        $directory = DB::table('lecturer_dir')
        ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
        ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B')
        ->where('material_dir.DrID', $request->dir)->first();

        $olddir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" . $request->file;
        $newdir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" . $request->name . "." . $request->ext;
        Storage::disk('linode')->move($olddir, $newdir);

        return true;

        }else{
            return false;
        }

    }

    public function renameMaterial(Request $request)
    {

        if($request->name != null)
        {

        $directory = DB::table('lecturer_dir')
        ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
        ->join('materialsub_dir', 'material_dir.DrID', 'materialsub_dir.MaterialDirID')
        ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'materialsub_dir.DrName as C')
        ->where('materialsub_dir.DrID', $request->dir)->first();

        $olddir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" . $directory->C . "/" . $request->file;
        $newdir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" . $directory->C . "/" . $request->name . "." . $request->ext;
        Storage::disk('linode')->move($olddir, $newdir);

        return true;

        }else{
            return false;
        }

    }

    public function coursecontent($id)
    {
        $user = Auth::user();

        $folder = DB::table('lecturer_dir')
                  ->where([
                    ['Addby', $user->ic], 
                    ['CourseID', $id]
                    ])->get();

        $course = Subject::findOrFail($id);

        //$test = Session::get('SessionID');

        //dd($folder);
        
        return view('user.subject_content.index', compact('folder', 'course'))->with('course_id', request()->id);
    }

    public function createContent()
    {
        return view('user.subject_content.createfolder')->with('course_id', request()->id);
    }

    public function storeContent(Request $request)
    {
        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $request->name;

        if(DB::table('lecturer_dir')->where([['DrName', $request->name],['CourseID', Session::get('subjects')->id]])->exists())
        {

            return redirect()->back() ->with('alert', 'Folder already exists! Please try again with a different name.');

        }else{

            $data = $request->validate([
                'name' => ['required','string'],
                'pass' => ['max:10'],
                'conpass' => ['max:10','same:pass']
            ],[
                'conpass.same' => 'The Confirm Password and Password must match!'
            ]);

            $classmaterial  = Storage::disk('linode')->makeDirectory($dir);

            $user = Auth::user()->ic;

            //dd($session);

            $pass = ($data['pass'] != null) ? Hash::make($data['pass']) : null;

            DB::table('lecturer_dir')->insert([
                'DrName' => $data['name'],
                'Password' => $pass,
                'CourseID' => $request->id,
                'Addby' => $user,
            ]);

            return redirect(route('user.content', ['id' => $request->id]));

        }
        
    }

    public function courseDirectory(Request $request)
    {
        $directory = DB::table('lecturer_dir')->where('DrID', $request->dir)->first();

        if(!empty($directory->Password))
        {
            return view('user.subject_content.passwordfolder')->with('dir', $request->dir)->with('course_id', $request->id);

        }else{

            $mat_directory = DB::table('material_dir')->where('LecturerDirID', $directory->DrID)->get();

            $course = Subject::findOrFail(Session::get('subjects')->id);

            return view('user.subject_content.materialdirectory', compact('mat_directory', 'course'))->with('dirid', $directory->DrID);
        }
    }

    public function passwordDirectory(Request $request)
    {                                           
        $password = DB::table('lecturer_dir')->where('DrID', request()->dir)->first();

        if(Hash::check($request->pass, $password->Password))
        {
            //$dir = 'eTutor/SubjectContent/'. $password->DrName;

            $mat_directory = DB::table('material_dir')->where('LecturerDirID', $password->DrID)->get();

            $course = Subject::findOrFail(Session::get('subjects')->id);

            //$classmaterial  = Storage::disk('linode')->allFiles( $dir );

            return view('user.subject_content.materialdirectory', compact('mat_directory', 'course'))->with('dirid', $password->DrID);

        }else{

            return redirect()->back() ->with('alert', 'Wrong Password! Please try again.');

        }
    }

    public function createDirectory()
    {
        return view('user.subject_content.createfoldermaterial')->with('dirid', request()->dirid);
    }

    public function storeDirectory(Request $request)
    {
        $lectdir = DB::table('lecturer_dir')->where('DrID', $request->dir)->first();

        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $lectdir->DrName . "/" . $request->name;

        //dd($dir);

        if(DB::table('material_dir')->where('DrName', $request->name)->where('LecturerDirID', $lectdir->DrID)->exists())
        {

            return redirect()->back() ->with('alert', 'Folder already exists! Please try again with a different name.');

        }else{

            $data = $request->validate([
                'chapter' => ['required'],
                'name' => ['required','string'],
                'pass' => ['max:10'],
                'conpass' => ['max:10','same:pass']
            ],[
                'conpass.same' => 'The Confirm Password and Password must match!'
            ]);

            $classmaterial  = Storage::disk('linode')->makeDirectory($dir);

            $user = Auth::user()->ic;

            //return dd($user);

            //$session = DB::table('sessions')->orderBy('SessionID', 'DESC')->first();

            //dd($session);

            $pass = ($data['pass'] != null) ? Hash::make($data['pass']) : null;

            DB::table('material_dir')->insert([
                'ChapterNo' => $data['chapter'],
                'DrName' => $data['name'],
                'Password' => $pass,
                'LecturerDirID' => $request->dir,
                'Addby' => $user,
            ]);

            return redirect(route('user.directory.prev', ['dir' => $request->dir]));

        }
        
    }

    public function prevcourseDirectory(Request $request)
    {
        $directory = DB::table('lecturer_dir')->where('DrID', $request->dir)->first();

        $mat_directory = DB::table('material_dir')->where('LecturerDirID', $directory->DrID)->get();

        $course = Subject::findOrFail(Session::get('subjects')->id);

        return view('user.subject_content.materialdirectory', compact('mat_directory', 'course'))->with('dirid', $directory->DrID);

    }

    public function courseSubDirectory(Request $request)
    {
        $directory = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'material_dir.*')
                ->where('material_dir.DrID', $request->dir)->first();

        if(!empty($directory->Password))
        {
            return view('user.subject_content.passwordsubfolder')->with('dir', $request->dir);

        }else{

            $mat_directory = DB::table('materialsub_dir')->where('MaterialDirID', $directory->DrID)->get();

            $url = DB::table('materialsub_url')->where('MaterialDirID', $directory->DrID)->get();

            $course = Subject::findOrFail(Session::get('subjects')->id);

            $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B;

            //this is to get file in the specific folder, unlike AllFiles to get everything from all folder
            $classmaterial  = Storage::disk('linode')->files($dir);

            return view('user.subject_content.materialsubdirectory', compact('mat_directory', 'url', 'course', 'classmaterial'))->with('dirid', $directory->DrID)->with('prev', $directory->LecturerDirID);
        }
    }

    public function createSubDirectory()
    {
        $chapter = DB::table('material_dir')->where('DrID', request()->dir)->first();

        //dd(request()->dir);
        
        return view('user.subject_content.createfoldersubmaterial', compact('chapter'))->with('dirid', request()->dir);
    }

    public function storeSubDirectory(Request $request)
    {
        $lectdir = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'lecturer_dir.DrID', 'lecturer_dir.CourseID')
                ->where('material_dir.DrID', $request->dir)->first();

        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $lectdir->A . "/" . $lectdir->B . "/" . $request->name;

        //dd($dir);

        if(DB::table('materialsub_dir')->where('DrName', $request->name)->where('MaterialDirID', $lectdir->DrID)->exists())
        {

            return redirect()->back() ->with('alert', 'Folder already exists! Please try again with a different name.');

        }else{

            $data = $request->validate([
                'chapter' => ['required'],
                'name' => ['required','string'],
                'pass' => ['max:10'],
                'conpass' => ['max:10','same:pass']
            ],[
                'conpass.same' => 'The Confirm Password and Password must match!'
            ]);

            $mat = DB::table('materialsub_dir')->where('MaterialDirID', $request->dir);

            $max = $mat->max('SubChapterNo');

            $check = $mat->get();

            if(count($check) > 0)
            {
                $data['chapter'] = $max + 0.1;
            }

            //dd($data['chapter']);

            $classmaterial  = Storage::disk('linode')->makeDirectory($dir);

            $user = Auth::user()->ic;

            //return dd($user);

            //$session = DB::table('sessions')->orderBy('SessionID', 'DESC')->first();

            //dd($session);

            $pass = ($data['pass'] != null) ? Hash::make($data['pass']) : null;

            DB::table('materialsub_dir')->insert([
                'SubChapterNo' => $data['chapter'],
                'DrName' => $data['name'],
                'Password' => $pass,
                'MaterialDirID' => $request->dir,
                'Addby' => $user,
            ]);

            return redirect(route('user.subdirectory.prev', ['dir' => $request->dir]));

        }
    }

    public function storefileSubDirectory(Request $request)
    {

        if (isset($request->fileUpload)) {

            $directory = DB::table('lecturer_dir')
                    ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                    ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'material_dir.*', 'lecturer_dir.CourseID')
                    ->where('material_dir.DrID', $request->dir)->first();

            //dd($dirName);

            $file = $request->file('fileUpload');

            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $fileInfo = pathinfo($file_name);
            $filename = $fileInfo['filename'];
            $newname = $filename . "." . $file_ext;

            // List of common video MIME types
            $videoMIMETypes = [
                'video/mp4',
                'video/quicktime',
                'video/x-msvideo',
                'video/x-ms-wmv',
                'video/x-flv',
                'video/webm',
                'video/3gpp',
                'video/3gpp2',
                'video/ogg'
            ];

            $fileMimeType = $file->getMimeType();

            if (in_array($fileMimeType, $videoMIMETypes)) {
                
                return back()->with('alert', 'The uploaded file must not be a video');
            }            

            //dd($file_name);

            $classmaterial = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B;

            $dirpath = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" .$newname;

            if (! file_exists($newname)) {
                Storage::disk('linode')->putFileAs(
                    $classmaterial,
                    $file,
                    $newname,
                    'public'
                );

                return redirect(route('user.subdirectory.prev', ['dir' =>  $request->dir]));
            }

        }elseif(isset($request->url))
        {
            $user = Auth::user()->ic;

            DB::table('materialsub_url')->insert([
                'url' => $request->url,
                'description' => $request->description,
                'MaterialDirID' => $request->dir,
                'Addby' => $user,
            ]);

            return redirect(route('user.subdirectory.prev', ['dir' =>  $request->dir]));

        }

    }

    public function prevcourseSubDirectory(Request $request)
    {

        $directory = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'material_dir.*')
                ->where('material_dir.DrID', $request->dir)->first();

        $mat_directory = DB::table('materialsub_dir')->where('MaterialDirID', $directory->DrID)->get();

        $url = DB::table('materialsub_url')->where('MaterialDirID', $directory->DrID)->get();

        $course = Subject::findOrFail(Session::get('subjects')->id);

        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B;

        //this is to get file in the specific folder, unlike AllFiles to get everything from all folder
        $classmaterial  = Storage::disk('linode')->files($dir);

        return view('user.subject_content.materialsubdirectory', compact('mat_directory', 'url', 'course', 'classmaterial'))->with('dirid', $directory->DrID)->with('prev', $directory->LecturerDirID);

    }

    public function passwordSubDirectory(Request $request)
    {

        $password = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'material_dir.*')
                ->where('material_dir.DrID', $request->dir)->first();

        if(Hash::check($request->pass, $password->Password))
        {
            //$dir = 'eTutor/SubjectContent/'. $password->DrName;

            $mat_directory = DB::table('materialsub_dir')->where('MaterialDirID', $password->DrID)->get();

            $url = DB::table('materialsub_url')->where('MaterialDirID', $password->DrID)->get();

            $course = Subject::findOrFail(Session::get('subjects')->id);

            $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $password->A . "/" . $password->B;

            //this is to get file in the specific folder, unlike AllFiles to get everything from all folder
            $classmaterial  = Storage::disk('linode')->files($dir);

            return view('user.subject_content.materialsubdirectory', compact('mat_directory', 'url', 'course', 'classmaterial'))->with('dirid', $password->DrID)->with('prev', $password->LecturerDirID);
        }else{

            return redirect()->back() ->with('alert', 'Wrong Password! Please try again.');

        }
    }

    public function DirectoryContent(Request $request)
    {
        $directory = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->join('materialsub_dir', 'material_dir.DrID', 'materialsub_dir.MaterialDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'materialsub_dir.DrName as C', 'materialsub_dir.Password', 'materialsub_dir.MaterialDirID', 'materialsub_dir.DrID')
                ->where('materialsub_dir.DrID', $request->dir)->first();

        //dd($directory);

        if(!empty($directory->Password))
        {
            return view('user.subject_content.passwordcontent')->with('dir', $request->dir);

        }else{

            $course = Subject::findOrFail(Session::get('subjects')->id);
            
            $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" . $directory->C;

            $classmaterial  = Storage::disk('linode')->allFiles($dir);

            $url = DB::table('materialsub_url')->where('MaterialSubDirID', $directory->DrID)->get();

            return view('user.subject_content.coursematerial', compact('classmaterial', 'course', 'url'))->with('dirid', $directory->DrID)->with('prev', $directory->MaterialDirID);
        }
    }

    public function uploadMaterial(Request $request)
    {
        $dirName = DB::table('lecturer_dir')
                ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
                ->join('materialsub_dir', 'material_dir.DrID', 'materialsub_dir.MaterialDirID')
                ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'materialsub_dir.DrName as C', 'materialsub_dir.Password', 'materialsub_dir.MaterialDirID', 'lecturer_dir.CourseID')
                ->where('materialsub_dir.DrID', $request->id)->first();
        
        //dd($dirName);

        if(isset($request->fileUpload))
        {

            $file = $request->file('fileUpload');

            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $fileInfo = pathinfo($file_name);
            $filename = $fileInfo['filename'];
            $newname = $filename . "." . $file_ext;

            // List of common video MIME types
            $videoMIMETypes = [
                'video/mp4',
                'video/quicktime',
                'video/x-msvideo',
                'video/x-ms-wmv',
                'video/x-flv',
                'video/webm',
                'video/3gpp',
                'video/3gpp2',
                'video/ogg'
            ];

            $fileMimeType = $file->getMimeType();

            if (in_array($fileMimeType, $videoMIMETypes)) {
                
                return back()->with('alert', 'The uploaded file must not be a video');
            }   

            //dd($file_name);

            $classmaterial = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $dirName->A . "/" . $dirName->B . "/" . $dirName->C;

            $dirpath = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $dirName->A . "/" . $dirName->B . "/" . $dirName->C . "/" .$newname;

            

            if(! file_exists($newname)){
                Storage::disk('linode')->putFileAs(
                    $classmaterial,
                    $file,
                    $newname,
                    'public'
                );

                return redirect(route('user.directory.content.prev', ['dir' =>  $request->id]));
            }

        }elseif(isset($request->url))
        {

            $user = Auth::user()->ic;

            DB::table('materialsub_url')->insert([
                'url' => $request->url,
                'description' => $request->description,
                'MaterialSubDirID' => $request->id,
                'Addby' => $user,
            ]);

            return redirect(route('user.directory.content.prev', ['dir' =>  $request->id]));

        }
    }

    public function prevDirectoryContent(Request $request)
    {

        $directory = DB::table('lecturer_dir')
        ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
        ->join('materialsub_dir', 'material_dir.DrID', 'materialsub_dir.MaterialDirID')
        ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'materialsub_dir.DrName as C', 'materialsub_dir.Password', 'materialsub_dir.MaterialDirID', 'materialsub_dir.DrID', 'lecturer_dir.CourseID')
        ->where('materialsub_dir.DrID', $request->dir)->first();

        $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/" . $directory->A . "/" . $directory->B . "/" . $directory->C;

        $classmaterial  = Storage::disk('linode')->allFiles( $dir );

        $course = Subject::findOrFail(Session::get('subjects')->id);

        $url = DB::table('materialsub_url')->where('MaterialSubDirID', $directory->DrID)->get();

        return view('user.subject_content.coursematerial', compact('classmaterial', 'course', 'url'))->with('dirid', $directory->DrID)->with('prev', $directory->MaterialDirID);

    }

    public function passwordContent(Request $request)
    {
        
        $password = DB::table('lecturer_dir')
        ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
        ->join('materialsub_dir', 'material_dir.DrID', 'materialsub_dir.MaterialDirID')
        ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'materialsub_dir.DrName as C', 'materialsub_dir.Password', 'materialsub_dir.MaterialDirID', 'materialsub_dir.DrID', 'lecturer_dir.CourseID')
        ->where('materialsub_dir.DrID', $request->dir)->first();


        if(Hash::check($request->pass, $password->Password))
        {
            //$dir = 'eTutor/SubjectContent/'. $password->DrName;

            $dir = "eTutor/SubjectContent/" . Session::get('subjects')->id . "/". $password->A . "/" . $password->B . "/" . $password->C;

            $classmaterial  = Storage::disk('linode')->allFiles( $dir );

            $course = Subject::findOrFail(Session::get('subjects')->id);

            $url = DB::table('materialsub_url')->where('MaterialSubDirID', $password->DrID)->get();

            return view('user.subject_content.coursematerial', compact('classmaterial', 'course', 'url'))->with('dirid', $password->DrID)->with('prev', $password->MaterialDirID);

        }else{

            return redirect()->back() ->with('alert', 'Wrong Password! Please try again.');

        }
    }
}
