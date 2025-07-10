<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Session;
Route::get('/', function () {
    return view('welcome');
});

// Registration Choice Page (for selecting between student and school registration)
Route::get('/register', function () {
    return view('guest.register-choice');
})->name('register.choice');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public School Registration Routes (no authentication required)
Route::prefix('school')->name('school.')->group(function () {
    // School registration landing page
    Route::get('/register', [App\Http\Controllers\Guest\SchoolRegistrationController::class, 'show'])->name('register');
    
    // Handle school registration form submission
    Route::post('/register', [App\Http\Controllers\Guest\SchoolRegistrationController::class, 'submit'])->name('register.submit');
    
    // AJAX endpoint for school search
    Route::get('/search', [App\Http\Controllers\Guest\SchoolRegistrationController::class, 'searchSchools'])->name('search');
    
    // Excel template download
    Route::get('/student-template', function () {
        return view('guest.school.student-template');
    })->name('student-template');
    
    // Download Excel template file
    Route::get('/download-template', [App\Http\Controllers\Guest\SchoolRegistrationController::class, 'downloadTemplate'])->name('download-template');
    
    // Download CSV template as alternative
    Route::get('/download-csv-template', [App\Http\Controllers\Guest\SchoolRegistrationController::class, 'downloadCsvTemplate'])->name('download-csv-template');
    
    // Diagnostic route for template download issues
    Route::get('/template-diagnostic', function () {
        $diagnostics = [
            'php_version' => PHP_VERSION,
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'extensions' => [
                'zip' => extension_loaded('zip'),
                'xml' => extension_loaded('xml'),
                'gd' => extension_loaded('gd'),
                'mbstring' => extension_loaded('mbstring'),
                'simplexml' => extension_loaded('simplexml'),
                'xmlreader' => extension_loaded('xmlreader'),
                'xmlwriter' => extension_loaded('xmlwriter'),
            ],
            'classes' => [
                'StudentsTemplateExport' => class_exists('App\Exports\StudentsTemplateExport'),
                'Excel' => class_exists('Maatwebsite\Excel\Facades\Excel'),
                'PhpSpreadsheet' => class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet'),
                'ZipArchive' => class_exists('ZipArchive'),
            ],
            'storage_paths' => [
                'temp_dir' => sys_get_temp_dir(),
                'temp_writable' => is_writable(sys_get_temp_dir()),
                'storage_app' => storage_path('app'),
                'storage_writable' => is_writable(storage_path('app')),
            ],
            'composer_packages' => [
                'maatwebsite_excel_installed' => class_exists('Maatwebsite\Excel\Excel'),
                'phpoffice_phpspreadsheet_installed' => class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet'),
            ]
        ];
        return response()->json($diagnostics, 200, [], JSON_PRETTY_PRINT);
    })->name('template-diagnostic');
});

// Public Student Registration Routes (no authentication required)
Route::prefix('student')->name('student.')->group(function () {
    // Student registration landing page
    Route::get('/register', [App\Http\Controllers\Guest\StudentRegistrationController::class, 'show'])->name('register');
    
    // Handle student registration form submission
    Route::post('/register', [App\Http\Controllers\Guest\StudentRegistrationController::class, 'submit'])->name('register.submit');
    
    // AJAX endpoint for school search (optional)
    Route::get('/search-schools', [App\Http\Controllers\Guest\StudentRegistrationController::class, 'searchSchools'])->name('search-schools');
});

// User Routes
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('user')->name('user.')->group(function(){
        Route::get('/dashboard', function () {
            Session::forget(['subjects']);
            return view('dashboard');
        })->name('dashboard');

        Route::get('/subjects', [App\Http\Controllers\User\TeacherSubjectController::class, 'index'])->name('subjects.index');

        Route::get('/summary/{id}', [App\Http\Controllers\User\SummaryController::class, 'index'])->name('summary.index');

        Route::delete('/content/delete', [App\Http\Controllers\User\ContentController::class, 'deleteContent']);
        Route::post('/content/rename', [App\Http\Controllers\User\ContentController::class, 'renameContent']);
        Route::delete('/content/folder/delete', [App\Http\Controllers\User\ContentController::class, 'deleteFolder']);
        Route::post('/content/folder/rename', [App\Http\Controllers\User\ContentController::class, 'renameFolder']);
        Route::delete('/content/folder/subfolder/delete', [App\Http\Controllers\User\ContentController::class, 'deleteSubfolder']);
        Route::delete('/content/folder/subfolder/deletefile', [App\Http\Controllers\User\ContentController::class, 'deleteSubfolderFile']);
        Route::post('/content/folder/subfolder/rename', [App\Http\Controllers\User\ContentController::class, 'renameSubfolder']);
        Route::post('/content/folder/subfolder/renameFile', [App\Http\Controllers\User\ContentController::class, 'renameFileSubfolder']);
        Route::delete('/content/folder/subfolder/material/delete', [App\Http\Controllers\User\ContentController::class, 'deleteMaterial']);
        Route::delete('/content/folder/subfolder/material/url/delete', [App\Http\Controllers\User\ContentController::class, 'deleteUrl']);
        Route::post('/content/folder/subfolder/material/renameFile', [App\Http\Controllers\User\ContentController::class, 'renameMaterial']);
        Route::get('/content/{id}', [App\Http\Controllers\User\ContentController::class, 'courseContent'])->name('content');
        Route::get('/content/{id}/create', [App\Http\Controllers\User\ContentController::class, 'createContent']);
        Route::post('/content/{id}/store', [App\Http\Controllers\User\ContentController::class, 'storeContent']);
        Route::get('/content/material/{dir}', [App\Http\Controllers\User\ContentController::class, 'courseDirectory'])->name('directory');
        Route::get('/content/material/prev/{dir}', [App\Http\Controllers\User\ContentController::class, 'prevcourseDirectory'])->name('directory.prev');
        Route::get('/content/material/create/{dir}', [App\Http\Controllers\User\ContentController::class, 'createDirectory']);
        Route::post('/content/material/store/{dir}', [App\Http\Controllers\User\ContentController::class, 'storeDirectory']);
        Route::post('/content/material/password/{dir}', [App\Http\Controllers\User\ContentController::class, 'passwordDirectory']);
        Route::get('/content/material/sub/{dir}', [App\Http\Controllers\User\ContentController::class, 'courseSubDirectory'])->name('subdirectory');
        Route::get('/content/material/sub/prev/{dir}', [App\Http\Controllers\User\ContentController::class, 'prevcourseSubDirectory'])->name('subdirectory.prev');
        Route::get('/content/material/sub/create/{dir}', [App\Http\Controllers\User\ContentController::class, 'createSubDirectory']);
        Route::post('/content/material/sub/store/{dir}', [App\Http\Controllers\User\ContentController::class, 'storeSubDirectory']);
        Route::post('/content/material/sub/storefile/{dir}', [App\Http\Controllers\User\ContentController::class, 'storefileSubDirectory']);
        Route::post('/content/material/sub/password/{dir}', [App\Http\Controllers\User\ContentController::class, 'passwordSubDirectory']);
        Route::get('/content/material/sub/content/{dir}', [App\Http\Controllers\User\ContentController::class, 'DirectoryContent'])->name('directory.content');
        Route::get('/content/material/sub/content/prev/{dir}', [App\Http\Controllers\User\ContentController::class, 'prevDirectoryContent'])->name('directory.content.prev');
        Route::post('/content/material/sub/content/upload/{id}', [App\Http\Controllers\User\ContentController::class, 'uploadMaterial']);
        Route::post('/content/material/sub/content/password/{dir}', [App\Http\Controllers\User\ContentController::class, 'passwordContent']);

        Route::get('/quiz/{id}', [App\Http\Controllers\User\QuizController::class, 'quizlist'])->name('quiz');
        Route::post('/quiz/getextend', [App\Http\Controllers\User\QuizController::class, 'getExtendQuiz']);
        Route::post('/quiz/updateExtend', [App\Http\Controllers\User\QuizController::class, 'updateExtendQuiz']);
        Route::get('/quiz/{id}/create', [App\Http\Controllers\User\QuizController::class, 'quizcreate'])->name('quiz.create');
        Route::post('/quiz/{id}/generate-ai-quiz', [App\Http\Controllers\User\QuizController::class, 'generateAIQuiz'])->name('quiz.generate-ai-quiz');
        Route::post('/quiz/insert', [App\Http\Controllers\User\QuizController::class, 'insertquiz']);
        Route::post('/quiz/getStatus', [App\Http\Controllers\User\QuizController::class, 'getStatus']);
        Route::post('/quiz/updatequizresult', [App\Http\Controllers\User\QuizController::class, 'updatequizresult']);
        Route::get('/quiz/{id}/{quiz}', [App\Http\Controllers\User\QuizController::class, 'lecturerquizstatus'])->name('quiz.status');
        Route::post('/quiz/{id}/{quiz}/getGroup', [App\Http\Controllers\User\QuizController::class, 'quizGetGroup']);
        Route::delete('/quiz/status/delete', [App\Http\Controllers\User\QuizController::class, 'deletequizstatus']);
        Route::get('/quiz/{quizid}/{userid}/result', [App\Http\Controllers\User\QuizController::class, 'quizresult']);
        Route::post('/quiz/getChapters', [App\Http\Controllers\User\QuizController::class, 'getChapters']);
        Route::post('/quiz/deletequiz', [App\Http\Controllers\User\QuizController::class, 'deletequiz']);
        Route::get('/quiz2/{id}', [App\Http\Controllers\User\QuizController::class, 'quiz2list'])->name('quiz2');
        Route::get('/quiz2/{id}/create', [App\Http\Controllers\User\QuizController::class, 'quiz2create'])->name('quiz2.create');
        Route::post('/quiz2/insert', [App\Http\Controllers\User\QuizController::class, 'insertquiz2']);
        Route::post('/quiz2/update', [App\Http\Controllers\User\QuizController::class, 'updatequiz2']);
        Route::post('/quiz2/getStatus', [App\Http\Controllers\User\QuizController::class, 'getStatus']);
        Route::post('/quiz2/updatequiz2result', [App\Http\Controllers\User\QuizController::class, 'updatequiz2result']);
        Route::get('/quiz2/{id}/{quiz}', [App\Http\Controllers\User\QuizController::class, 'lecturerquiz2status'])->name('quiz2.status');
        Route::post('/quiz2/{id}/{quiz}/getGroup', [App\Http\Controllers\User\QuizController::class, 'quiz2GetGroup']);
        Route::get('/quiz2/{quizid}/{userid}/result', [App\Http\Controllers\User\QuizController::class, 'quiz2result']);
        Route::post('/quiz2/getChapters', [App\Http\Controllers\User\QuizController::class, 'getChapters']);

        Route::get('/test/{id}', [App\Http\Controllers\User\TestController::class, 'testlist'])->name('test');
        Route::post('/test/getextend', [App\Http\Controllers\User\TestController::class, 'getExtendTest']);
        Route::post('/test/updateExtend', [App\Http\Controllers\User\TestController::class, 'updateExtendTest']);
        Route::get('/test/{id}/create', [App\Http\Controllers\User\TestController::class, 'testcreate'])->name('test.create');
        Route::post('/test/{id}/generate-ai-test', [App\Http\Controllers\User\TestController::class, 'generateAITest'])->name('test.generate-ai-test');
        Route::post('/test/insert', [App\Http\Controllers\User\TestController::class, 'inserttest']);
        Route::post('/test/getStatus', [App\Http\Controllers\User\TestController::class, 'getStatus']);
        Route::post('/test/updatetestresult', [App\Http\Controllers\User\TestController::class, 'updatetestresult']);
        Route::get('/test/{id}/{test}', [App\Http\Controllers\User\TestController::class, 'lecturerteststatus'])->name('test.status');
        Route::post('/test/{id}/{test}/getGroup', [App\Http\Controllers\User\TestController::class, 'testGetGroup']);
        Route::delete('/test/status/delete', [App\Http\Controllers\User\TestController::class, 'deleteteststatus']);
        Route::get('/test/{testid}/{userid}/result', [App\Http\Controllers\User\TestController::class, 'testresult']);
        Route::post('/test/getChapters', [App\Http\Controllers\User\TestController::class, 'getChapters']);
        Route::post('/test/deletetest', [App\Http\Controllers\User\TestController::class, 'deletetest']);
        Route::get('/test2/{id}', [App\Http\Controllers\User\TestController::class, 'test2list'])->name('test2');
        Route::get('/test2/{id}/create', [App\Http\Controllers\User\TestController::class, 'test2create'])->name('test2.create');
        Route::post('/test2/insert', [App\Http\Controllers\User\TestController::class, 'inserttest2']);
        Route::post('/test2/update', [App\Http\Controllers\User\TestController::class, 'updatetest2']);
        Route::post('/test2/getStatus', [App\Http\Controllers\User\TestController::class, 'getStatus']);
        Route::post('/test2/updatetest2result', [App\Http\Controllers\User\TestController::class, 'updatetest2result']);
        Route::get('/test2/{id}/{test}', [App\Http\Controllers\User\TestController::class, 'lecturertest2status'])->name('test2.status');
        Route::post('/test2/{id}/{test}/getGroup', [App\Http\Controllers\User\TestController::class, 'test2GetGroup']);
        Route::get('/test2/{testid}/{userid}/result', [App\Http\Controllers\User\TestController::class, 'test2result']);
        Route::post('/test2/getChapters', [App\Http\Controllers\User\TestController::class, 'getChapters']);

        Route::get('/forum/{id}', [App\Http\Controllers\User\ForumController::class, 'lectForum'])->name('forum');
        Route::post('/forum/{id}/insert', [App\Http\Controllers\User\ForumController::class, 'insertTopic']);
        Route::post('/forum/{id}/topic/insert', [App\Http\Controllers\User\ForumController::class, 'insertForum']);
        Route::post('/forum/{id}/topic/delete', [App\Http\Controllers\User\ForumController::class, 'deleteMessage'])->name('forum.deleteMessage');

        Route::get('/library/{id}', [App\Http\Controllers\User\LibraryController::class, 'libraryIndex'])->name('library');
        Route::post('/library/getFolder', [App\Http\Controllers\User\LibraryController::class, 'getContent'])->name('library.content');
        Route::post('/library/getSubfolder', [App\Http\Controllers\User\LibraryController::class, 'getSubFolder']);
        Route::post('/library/getSubfolder/getSubfolder2', [App\Http\Controllers\User\LibraryController::class, 'getSubFolder2']);
        Route::post('/library/getSubfolder/getSubfolder2/getMaterial', [App\Http\Controllers\User\LibraryController::class, 'getMaterial']);
        Route::post('/library/getQuiz', [App\Http\Controllers\User\LibraryController::class, 'getQuiz'])->name('library.quiz');
        Route::post('/library/getTest', [App\Http\Controllers\User\LibraryController::class, 'getTest'])->name('library.test');

        Route::get('/online-class/{id}', [App\Http\Controllers\User\OnlineClassController::class, 'index'])->name('online-class.index');
        Route::get('/online-class/{id}/create', [App\Http\Controllers\User\OnlineClassController::class, 'create'])->name('online-class.create');
        Route::post('/online-class/{id}/store', [App\Http\Controllers\User\OnlineClassController::class, 'store'])->name('online-class.store');
        Route::get('/online-class/{id}/{classId}', [App\Http\Controllers\User\OnlineClassController::class, 'show'])->name('online-class.show');
        Route::get('/online-class/{id}/{classId}/edit', [App\Http\Controllers\User\OnlineClassController::class, 'edit'])->name('online-class.edit');
        Route::put('/online-class/{id}/{classId}', [App\Http\Controllers\User\OnlineClassController::class, 'update'])->name('online-class.update');
        Route::delete('/online-class/{id}/{classId}', [App\Http\Controllers\User\OnlineClassController::class, 'destroy'])->name('online-class.destroy');
        Route::post('/online-class/get-students', [App\Http\Controllers\User\OnlineClassController::class, 'getStudents'])->name('online-class.get-students');
    });
    
    // Admin Only Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', function () {
            return 'Admin Dashboard - Only admins can access this page';
        })->name('admin.dashboard');
    });
});

// Student Routes
Route::middleware(['auth:student'])->group(function () {
    Route::get('/student/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');

    Route::get('/student/subjects', [App\Http\Controllers\Student\SubjectController::class, 'index'])->name('student.subjects.index');
    Route::post('/student/subjects/filter', [App\Http\Controllers\Student\SubjectController::class, 'getCourseList']);

    Route::get('/student/{id}', [App\Http\Controllers\Student\SummaryController::class, 'show'])->name('student.subjects.show');

    Route::get('/student/content/{id}', [App\Http\Controllers\Student\ContentController::class, 'courseContent'])->name('student.content');
    Route::get('/student/content/material/{dir}', [App\Http\Controllers\Student\ContentController::class, 'courseDirectory'])->name('student.directory');
    Route::post('/student/content/password/{dir}', [App\Http\Controllers\Student\ContentController::class, 'passwordDirectory']);
    Route::get('/student/content/material/prev/{dir}', [App\Http\Controllers\Student\ContentController::class, 'prevcourseDirectory'])->name('student.directory.prev');
    Route::get('/student/content/material/sub/{dir}', [App\Http\Controllers\Student\ContentController::class, 'courseSubDirectory'])->name('student.subdirectory');
    Route::get('/student/content/material/sub/prev/{dir}', [App\Http\Controllers\Student\ContentController::class, 'prevcourseSubDirectory'])->name('student.subdirectory.prev');
    Route::post('/student/content/material/sub/password/{dir}', [App\Http\Controllers\Student\ContentController::class, 'passwordSubDirectory']);
    Route::get('/student/content/material/sub/content/{dir}', [App\Http\Controllers\Student\ContentController::class, 'DirectoryContent'])->name('student.directory.content');
    Route::post('/student/content/material/sub/content/password/{dir}', [App\Http\Controllers\Student\ContentController::class, 'passwordContent']);

    Route::get('/student/quiz/{id}', [App\Http\Controllers\Student\QuizController::class, 'studentquizlist'])->name('student.quiz');
    Route::get('/student/quiz/{id}/{quiz}', [App\Http\Controllers\Student\QuizController::class, 'studentquizstatus'])->name('student.quiz.status');
    Route::get('/student/quiz/{id}/{quiz}/view', [App\Http\Controllers\Student\QuizController::class, 'quizview']);
    Route::get('/student/quiz/{quizid}/{userid}/result', [App\Http\Controllers\Student\QuizController::class, 'quizresultstd']);
    Route::post('/student/quiz/startquiz', [App\Http\Controllers\Student\QuizController::class, 'startquiz']);
    Route::post('/student/quiz/savequiz', [App\Http\Controllers\Student\QuizController::class, 'savequiz']);
    Route::post('/student/quiz/submitquiz', [App\Http\Controllers\Student\QuizController::class, 'submitquiz']);

    Route::get('/student/quiz2/{id}', [App\Http\Controllers\Student\QuizController::class, 'studentquiz2list'])->name('student.quiz2');

    Route::get('/student/test/{id}', [App\Http\Controllers\Student\TestController::class, 'studenttestlist'])->name('student.test');
    Route::get('/student/test/{id}/{test}', [App\Http\Controllers\Student\TestController::class, 'studentteststatus'])->name('student.test.status');
    Route::get('/student/test/{id}/{test}/view', [App\Http\Controllers\Student\TestController::class, 'testview']);
    Route::get('/student/test/{testid}/{userid}/result', [App\Http\Controllers\Student\TestController::class, 'testresultstd']);
    Route::post('/student/test/starttest', [App\Http\Controllers\Student\TestController::class, 'starttest']);
    Route::post('/student/test/savetest', [App\Http\Controllers\Student\TestController::class, 'savetest']);
    Route::post('/student/test/submittest', [App\Http\Controllers\Student\TestController::class, 'submittest']);

    Route::get('/student/test2/{id}', [App\Http\Controllers\Student\TestController::class, 'studenttest2list'])->name('student.test2');

    Route::get('/student/forum/{id}', [App\Http\Controllers\Student\ForumController::class, 'studForum'])->name('student.forum');
    Route::post('/student/forum/{id}/insert', [App\Http\Controllers\Student\ForumController::class, 'studinsertTopic']);
    Route::post('/student/forum/{id}/topic/insert', [App\Http\Controllers\Student\ForumController::class, 'studinsertForum']);

    // Student Online Class Routes
    Route::get('/student/online-class/{id}', [App\Http\Controllers\Student\OnlineClassController::class, 'index'])->name('student.online-class.index');
    Route::get('/student/online-class/{id}/{classId}', [App\Http\Controllers\Student\OnlineClassController::class, 'show'])->name('student.online-class.show');
    Route::get('/student/online-class/{id}/{classId}/join', [App\Http\Controllers\Student\OnlineClassController::class, 'join'])->name('student.online-class.join');

    // Student Online Class Gateway Routes (legacy - keeping for backward compatibility)
    Route::get('/student/online-class/{classId}/join-page', [App\Http\Controllers\User\OnlineClassController::class, 'showJoinPage'])->name('student.online-class.join-page');
    Route::get('/student/online-class/{classId}/join', [App\Http\Controllers\User\OnlineClassController::class, 'joinClass'])->name('student.online-class.legacy-join');

});

// Public Online Class Gateway Routes (no authentication required for join page)
Route::get('/online-class/{classId}/join-page', [App\Http\Controllers\User\OnlineClassController::class, 'showJoinPage'])->name('online-class.join-page');
Route::get('/online-class/{classId}/join', [App\Http\Controllers\User\OnlineClassController::class, 'joinClass'])->name('online-class.join');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // School routes
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class);

    // Bulk Student Upload Routes (MUST BE BEFORE THE RESOURCE ROUTE)
    Route::get('students/bulk-create', [App\Http\Controllers\Admin\StudentController::class, 'bulkCreate'])->name('students.bulkCreate');
    Route::post('students/bulk-store', [App\Http\Controllers\Admin\StudentController::class, 'bulkStore'])->name('students.bulkStore');
    Route::get('students/download-template', [App\Http\Controllers\Admin\StudentController::class, 'downloadTemplate'])->name('students.downloadTemplate');
    Route::get('students/download-csv-template', [App\Http\Controllers\Admin\StudentController::class, 'downloadCsvTemplate'])->name('students.downloadCsvTemplate');
    // Diagnostic route for template download issues
    Route::get('students/template-diagnostic', function () {
        $diagnostics = [
            'php_version' => PHP_VERSION,
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'extensions' => [
                'zip' => extension_loaded('zip'),
                'xml' => extension_loaded('xml'),
                'gd' => extension_loaded('gd'),
                'mbstring' => extension_loaded('mbstring'),
            ],
            'classes' => [
                'StudentsTemplateExport' => class_exists('App\Exports\StudentsTemplateExport'),
                'Excel' => class_exists('Maatwebsite\Excel\Facades\Excel'),
                'PhpSpreadsheet' => class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet'),
            ],
            'storage_paths' => [
                'temp_dir' => sys_get_temp_dir(),
                'temp_writable' => is_writable(sys_get_temp_dir()),
                'storage_app' => storage_path('app'),
                'storage_writable' => is_writable(storage_path('app')),
            ]
        ];
        return response()->json($diagnostics);
    })->name('students.templateDiagnostic');

    // Student resource routes (MUST BE AFTER CUSTOM ROUTES)
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
    
    // Subject routes
    Route::resource('subjects', App\Http\Controllers\Admin\SubjectController::class);

    // User routes
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // Teacher Subject routes
    Route::get('teacher-subjects', [App\Http\Controllers\Admin\TeacherSubjectController::class, 'index'])->name('teacher-subjects.index');
    Route::get('teacher-subjects/{id}', [App\Http\Controllers\Admin\TeacherSubjectController::class, 'show'])->name('teacher-subjects.show');
    Route::post('teacher-subjects', [App\Http\Controllers\Admin\TeacherSubjectController::class, 'store'])->name('teacher-subjects.store');
    Route::delete('teacher-subjects', [App\Http\Controllers\Admin\TeacherSubjectController::class, 'destroy'])->name('teacher-subjects.destroy');
    
    // Student Application routes
    Route::get('student-applications', [App\Http\Controllers\Admin\StudentApplicationController::class, 'index'])->name('student-applications.index');
    Route::get('student-applications/{application}', [App\Http\Controllers\Admin\StudentApplicationController::class, 'show'])->name('student-applications.show');
    Route::patch('student-applications/{application}/approve', [App\Http\Controllers\Admin\StudentApplicationController::class, 'approve'])->name('student-applications.approve');
    Route::delete('student-applications/{application}/reject', [App\Http\Controllers\Admin\StudentApplicationController::class, 'reject'])->name('student-applications.reject');
    Route::post('student-applications/bulk-approve', [App\Http\Controllers\Admin\StudentApplicationController::class, 'bulkApprove'])->name('student-applications.bulk-approve');
    Route::post('student-applications/bulk-reject', [App\Http\Controllers\Admin\StudentApplicationController::class, 'bulkReject'])->name('student-applications.bulk-reject');
    Route::get('student-applications/stats/data', [App\Http\Controllers\Admin\StudentApplicationController::class, 'getStats'])->name('student-applications.stats');
});
