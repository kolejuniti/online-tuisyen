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

class LibraryController extends Controller
{
    public function libraryIndex()
    {

        $lecturer = DB::table('users')
                    ->join('teacher_subjects', 'users.id', 'teacher_subjects.user_id')
                    ->join('subjects', 'teacher_subjects.subject_id', 'subjects.id')
                    ->where([
                        ['subjects.id', Session::get('subjects')->id]
                    ])->select('users.name', 'users.ic', 'subjects.id')->get();

        //dd($lecturer);

        return view('user.library.library', compact('lecturer'));

    }

    public function getContent(Request $request)
    {

        $folder = DB::table('lecturer_dir')
                   ->where([
                    ['Addby', $request->ic]
                    ])->where('CourseID', Session::get('subjects')->id)->get();

        return view('user.library.getSubfolder', compact('folder'));

    }

    public function getSubFolder(Request $request)
    {

        $subfolder = DB::table('material_dir')->where('LecturerDirID', $request->id)->get();

        $prev0 = $folder = DB::table('lecturer_dir')->where('DrID', $request->id)->first();

        return view('user.library.getSubfolder', compact('subfolder','prev0'));

    }

    public function getSubFolder2(Request $request)
    {

        $directory = DB::table('lecturer_dir')
        ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
        ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'material_dir.*', 'lecturer_dir.CourseID')
        ->where('material_dir.DrID', $request->id)->first();

        $subfolder2 = DB::table('materialsub_dir')->where('MaterialDirID', $request->id)->get();

        $dir = "eTutor/SubjectContent/" . $directory->CourseID . "/" . $directory->A . "/" . $directory->B;

        //this is to get file in the specific folder, unlike AllFiles to get everything from all folder
        $classmaterial  = Storage::disk('linode')->files($dir);

        $prev = $directory->LecturerDirID;

        return view('user.library.getSubfolder', compact('subfolder2', 'classmaterial','prev'));

    }

    public function getMaterial(Request $request)
    {

        $directory = DB::table('lecturer_dir')
        ->join('material_dir', 'lecturer_dir.DrID', 'material_dir.LecturerDirID')
        ->join('materialsub_dir', 'material_dir.DrID', 'materialsub_dir.MaterialDirID')
        ->select('lecturer_dir.DrName as A', 'material_dir.DrName as B', 'materialsub_dir.DrName as C', 'materialsub_dir.Password', 'materialsub_dir.MaterialDirID', 'materialsub_dir.DrID', 'lecturer_dir.CourseID')
        ->where('materialsub_dir.DrID', $request->id)->first();

        $dir = "eTutor/SubjectContent/" . $directory->CourseID . "/" . $directory->A . "/" . $directory->B . "/" . $directory->C;

        $classmaterial  = Storage::disk('linode')->allFiles($dir);

        $prev2 = $directory->MaterialDirID;

        return view('user.library.getSubfolder', compact('classmaterial','prev2'));
    }

    public function getQuiz(Request $request)
    {

        $quiz = DB::table('tblclassquiz')
                ->join('tblclassquizstatus', 'tblclassquiz.status', 'tblclassquizstatus.id')
                ->where([
                    ['tblclassquiz.addby', $request->ic],
                    ['tblclassquiz.classid', Session::get('subjects')->id]
                ])
                ->select('tblclassquiz.*', 'tblclassquizstatus.statusname')->get();


        return view('user.library.getQuiz', compact('quiz'));

    }

    public function getTest(Request $request)
    {

        $test = DB::table('tblclasstest')
                ->join('tblclassteststatus', 'tblclasstest.status', 'tblclassteststatus.id')
                ->where([
                    ['tblclasstest.addby', $request->ic],
                    ['tblclasstest.classid', Session::get('subjects')->id]
                ])
                ->select('tblclasstest.*', 'tblclassteststatus.statusname')->get();


        return view('user.library.getTest', compact('test'));

    }
}
