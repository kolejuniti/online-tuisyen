@extends('layouts.user.user')

@section('main')

<style>
    /* Specific styles for formBuilder */
    #fb-rendered-form {
        clear: both;
        display: none;
    }

    #fb-rendered-form button {
        float: right;
    }
</style>

<link rel="stylesheet" href="{{ asset('css/customCSS.css') }}">
<!-- jQuery UI CSS required for form-builder's sortable functionality -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->

        <div class="page-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title mb-1">{{ empty($data['quiz']->title) ? "Create Quiz" : $data['quiz']->title }}</h3>
                    <div class="d-inline-block align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Course</li>
                                <li class="breadcrumb-item">Assessment</li>
                                @if(empty($data['quiz']->title))
                                    <li class="breadcrumb-item active" aria-current="page">Create Quiz</li>
                                @else
                                    <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $data['quiz']->title }}</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-xl-12 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="header-setting row">
                                <div class="row col-md-12">
                                    <div class="col-md-2 mb-4">
                                        <label for="quiz-title" class="form-label "><strong>Quiz Title</strong></label>
                                        <input type="text" oninput="this.value = this.value.toUpperCase()"  id="quiz-title" class="form-control"
                                            value="{{ empty($data['quiz']->title) ? "" : $data['quiz']->title }}"  required>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <label for="from" class="form-label "><strong>Quiz Duration (From)</strong></label>
                                        <input type="datetime-local" id="from" class="form-control"
                                            value={{ empty($data['quiz']->date_from) ? '' : date('Y-m-d\TH:i:s', strtotime($data['quiz']->date_from)) }} required>
                                    </div>
                                    <div class="col-md-2 mb-4" id="time-to" hidden>
                                        <label for="to" class="form-label "><strong>Quiz Duration (To)</strong></label>
                                        <input type="datetime-local" oninput="this.value = this.value.toUpperCase()"  id="to" class="form-control"
                                            value={{ empty($data['quiz']->date_to) ? '' : date('Y-m-d\TH:i:s', strtotime($data['quiz']->date_to))  }} required>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <label for="quiz-duration" class="form-label "><strong>Quiz Duration (minutes)</strong></label>
                                        <input readonly type="number" oninput="this.value = this.value.toUpperCase()"  id="quiz-duration" class="form-control"
                                            value="">
                                    </div>
                                    <div class="col-md-2 mb-4" hidden>
                                        <label for="question-index" class="form-label "><strong>Question Index</strong></label>
                                        <input id="question-index" type="number" class="form-control"
                                            value={{ empty($data['quiz']->questionindex) ? 1 : $data['quiz']->questionindex }}>
                                    </div>
                                    <!--<div class="col-md-2 mb-4">
                                        <label for="date" class="form-label "><strong>Date</strong></label>
                                        <input type="date" id="date" class="form-control"
                                            value="">
                                    </div>-->
                                    <div class="col-md-2 mb-4">
                                        <div class="form-group">
                                          <label class="form-label" for="folder">Teacher Folder</label>
                                          <select class="form-select" id="folder" name="folder" required>
                                              <option value="" disabled selected>-</option>
                                              @foreach ($folder as $fold)
                                              <option value="{{ $fold->DrID }}" {{ empty($data['folder']->DrID) ? '' : (($fold->DrID == $data['folder']->DrID) ? 'selected' : '' )}}>{{ ($fold->newDrName == null) ? $fold->DrName : $fold->newDrName }}</option>
                                              @endforeach
                                          </select>
                                          <span class="text-danger">@error('folder')
                                            {{ $message }}
                                          @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <label for="total-marks" class="form-label "><strong>Total Marks</strong></label>
                                        <input type="number" id="total-marks" class="form-control"
                                            value="{{ empty($data['quiz']->total_mark) ? '' : $data['quiz']->total_mark }}" required>
                                    </div>
                                </div>
                                <!-- Group and Chapter Selection -->
                                <div class="row col-md-12">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label class="form-label"><strong>Group List</strong></label>
                                            <div class="table-responsive" style="width:99.7%">
                                                <table id="table_registerstudent" class="w-100 table text-fade table-bordered table-hover display nowrap margin-top-10 w-p100">
                                                    <thead class="thead-themed">
                                                    <th>Name</th>
                                                    {{-- <th>Course</th> --}}
                                                    <th></th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($group as $grp)
                                                        <tr>
                                                            <td>
                                                                <label>{{$grp->name}}</label>
                                                            </td>
                                                            {{-- <td>
                                                                <label>{{$grp->course_name}}</label>
                                                            </td> --}}
                                                            <td>
                                                                <div class="form-check pull-right">
                                                                    <input type="checkbox" id="chapter_checkbox_{{$grp->name}}"
                                                                        class="form-check-input" name="group[]" value="{{$tsubject->id}}|{{$grp->id}}">
                                                                    <label class="form-check-label" for="chapter_checkbox_{{$grp->name}}"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label class="form-label"><strong>Chapter List</strong></label>
                                            <div class="container mt-1" id="chapterlist">
                                                <!-- Chapters will be loaded here -->
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- AI Generate Quiz Card -->
                                    <div class="col-md-12">
                                        <div class="card ai-generate-card">
                                            <div class="card-header">
                                                <h5><i class="fa fa-magic me-2"></i> Generate Quiz from Document</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Tips Alert Section -->
                                                <div class="alert alert-info mb-4" role="alert">
                                                    <h6 class="alert-heading"><i class="fa fa-info-circle me-2"></i>Tips for Quiz Generation:</h6>
                                                    <ul class="mb-0 ps-3">
                                                        <li>For best results, keep the total number of questions under 20.</li>
                                                        <li>Larger documents may require more processing time.</li>
                                                        <li>If you encounter an error, please try again or reduce the number of requested questions.</li>
                                                        <li>Make sure your PDF document is text-based (not scanned) for optimal results.</li>
                                                    </ul>
                                                </div>
                                                
                                                <form id="aiQuizForm" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="form-group">
                                                                <label for="documentInput" class="form-label"><strong>Upload Document</strong></label>
                                                                <input type="file" class="form-control" id="documentInput" name="document" accept=".pdf" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <div class="form-group">
                                                                <label for="singleChoiceCount" class="form-label"><strong>Number of Single-Choice Questions</strong></label>
                                                                <input type="number" class="form-control" id="singleChoiceCount" name="single_choice_count" min="0" value="0">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 mb-3">
                                                            <div class="form-group">
                                                                <label for="multipleChoiceCount" class="form-label"><strong>Number of Multiple-Choice Questions</strong></label>
                                                                <input type="number" class="form-control" id="multipleChoiceCount" name="multiple_choice_count" min="0" value="0">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 mb-3">
                                                            <div class="form-group">
                                                                <label for="subjectiveCount" class="form-label"><strong>Number of Subjective Questions</strong></label>
                                                                <input type="number" class="form-control" id="subjectiveCount" name="subjective_count" min="0" value="0">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <div class="form-group">
                                                                <label for="languageSlider" class="form-label"><strong>Question Language</strong></label>
                                                                <div class="slider-container">
                                                                    <input type="range" class="form-range" id="languageSlider" min="0" max="2" step="1" value="0">
                                                                    <div class="slider-tooltip">English</div>
                                                                </div>
                                                                <div class="d-flex justify-content-between mt-1 slider-label-container">
                                                                    <span class="slider-label active" id="english-label">English</span>
                                                                    <span class="slider-label" id="malay-label">Malay</span>
                                                                    <span class="slider-label" id="mix-label">Mix</span>
                                                                </div>
                                                                <input type="hidden" id="language" name="language" value="english">
                                                            </div>
                                                        </div>
                                                                                                    
                                                        <div class="col-md-12 mt-2 text-right">
                                                            <button type="button" id="generateQuizAI" class="btn btn-primary ai-generate-btn">
                                                                <i class="fa fa-robot me-2"></i> AI Generate Quiz
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <style>
                                        .slider-container {
                                            position: relative;
                                            padding: 10px 0;
                                        }
                                        
                                        .slider-label {
                                            font-size: 0.85rem;
                                            cursor: pointer;
                                            transition: all 0.3s ease;
                                            position: relative;
                                            padding: 5px 10px;
                                            border-radius: 15px;
                                        }
                                        
                                        .slider-label.active {
                                            font-weight: bold;
                                            color: #ffffff;
                                            background-color: #6610f2;
                                            transform: scale(1.1);
                                            box-shadow: 0 2px 8px rgba(102, 16, 242, 0.5);
                                        }
                                        
                                        /* Animation for all labels when sliding */
                                        .slider-label-container.sliding .slider-label {
                                            animation: pulse 1s infinite alternate;
                                        }
                                        
                                        @keyframes pulse {
                                            0% {
                                                transform: scale(1);
                                            }
                                            100% {
                                                transform: scale(1.05);
                                            }
                                        }
                                        
                                        /* Custom slider styling */
                                        #languageSlider {
                                            -webkit-appearance: none;
                                            width: 100%;
                                            height: 8px;
                                            border-radius: 10px;
                                            background: linear-gradient(to right, #6610f2 0%, #9333ea 50%, #6610f2 100%);
                                            outline: none;
                                            opacity: 0.8;
                                            transition: opacity 0.3s, transform 0.3s;
                                        }
                                        
                                        #languageSlider:hover {
                                            opacity: 1;
                                            transform: scaleY(1.2);
                                        }
                                        
                                        #languageSlider:active {
                                            cursor: grabbing;
                                            transform: scaleY(1.4);
                                        }
                                        
                                        #languageSlider::-webkit-slider-thumb {
                                            -webkit-appearance: none;
                                            appearance: none;
                                            width: 25px;
                                            height: 25px;
                                            border-radius: 50%;
                                            background: #ffffff;
                                            border: 3px solid #6610f2;
                                            cursor: grab;
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
                                            transition: all 0.3s;
                                        }
                                        
                                        #languageSlider::-webkit-slider-thumb:hover {
                                            background: #e9ecef;
                                            transform: scale(1.1);
                                        }
                                        
                                        #languageSlider::-webkit-slider-thumb:active {
                                            background: #6610f2;
                                            border-color: #ffffff;
                                            transform: scale(1.2);
                                            cursor: grabbing;
                                        }
                                        
                                        #languageSlider::-moz-range-thumb {
                                            width: 25px;
                                            height: 25px;
                                            border-radius: 50%;
                                            background: #ffffff;
                                            border: 3px solid #6610f2;
                                            cursor: grab;
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
                                            transition: all 0.3s;
                                        }
                                        
                                        #languageSlider::-moz-range-thumb:hover {
                                            background: #e9ecef;
                                            transform: scale(1.1);
                                        }
                                        
                                        #languageSlider::-moz-range-thumb:active {
                                            background: #6610f2;
                                            border-color: #ffffff;
                                            transform: scale(1.2);
                                            cursor: grabbing;
                                        }
                                        
                                        .form-range::-webkit-slider-runnable-track {
                                            height: 8px;
                                            background: linear-gradient(to right, #6610f2 0%, #9333ea 50%, #6610f2 100%);
                                            border-radius: 10px;
                                            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3);
                                        }
                                        
                                        .form-range::-moz-range-track {
                                            height: 8px;
                                            background: linear-gradient(to right, #6610f2 0%, #9333ea 50%, #6610f2 100%);
                                            border-radius: 10px;
                                            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3);
                                        }

                                        /* Answer Options Modal Styles */
                                        .options-preview-list {
                                            max-height: 300px;
                                            overflow-y: auto;
                                        }

                                        .options-preview-list .form-check {
                                            padding: 8px 12px;
                                            border: 1px solid #e9ecef;
                                            border-radius: 6px;
                                            background-color: #fff;
                                            transition: all 0.2s ease;
                                        }

                                        .options-preview-list .form-check:hover {
                                            background-color: #f8f9fa;
                                            border-color: #6610f2;
                                            transform: translateX(2px);
                                        }

                                        .options-preview-list .form-check-label {
                                            cursor: default;
                                            width: 100%;
                                            margin-bottom: 0;
                                            color: #000000 !important;
                                            font-weight: 500;
                                        }

                                        .options-preview-list .form-check-input {
                                            margin-top: 0.25rem;
                                        }

                                        #pastedOptions {
                                            font-family: 'Courier New', monospace;
                                            resize: vertical;
                                            min-height: 150px;
                                        }

                                        #pastedOptions:focus {
                                            border-color: #6610f2;
                                            box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
                                        }

                                        #optionsPreview {
                                            border-radius: 8px;
                                            overflow: hidden;
                                        }

                                        #optionsPreview .text-muted {
                                            text-align: center;
                                            margin: 60px 0;
                                            font-style: italic;
                                        }

                                        .modal-header {
                                            background: linear-gradient(135deg, #6610f2 0%, #9333ea 100%);
                                            color: white;
                                            border-bottom: none;
                                        }

                                        .modal-header .btn-close {
                                            filter: invert(1);
                                        }

                                        .modal-title {
                                            font-weight: 600;
                                        }

                                        #answerOptionsModal .btn-primary {
                                            background: linear-gradient(135deg, #6610f2 0%, #9333ea 100%);
                                            border: none;
                                            transition: all 0.3s ease;
                                        }

                                        #answerOptionsModal .btn-primary:hover {
                                            transform: translateY(-2px);
                                            box-shadow: 0 4px 15px rgba(102, 16, 242, 0.4);
                                        }

                                        /* Animation for option count */
                                        #optionCount {
                                            font-weight: bold;
                                            color: #6610f2;
                                            transition: all 0.3s ease;
                                        }

                                        /* Scrollbar styling for preview area */
                                        .options-preview-list::-webkit-scrollbar {
                                            width: 6px;
                                        }

                                        .options-preview-list::-webkit-scrollbar-track {
                                            background: #f1f1f1;
                                            border-radius: 3px;
                                        }

                                        .options-preview-list::-webkit-scrollbar-thumb {
                                            background: #6610f2;
                                            border-radius: 3px;
                                        }

                                        .options-preview-list::-webkit-scrollbar-thumb:hover {
                                            background: #9333ea;
                                        }

                                        /* Correct Answer Selection Styles */
                                        .correct-answer-list {
                                            max-height: 180px;
                                            overflow-y: auto;
                                        }

                                        .correct-answer-list .form-check {
                                            padding: 8px 12px;
                                            border: 1px solid #e9ecef;
                                            border-radius: 6px;
                                            background-color: #fff;
                                            transition: all 0.3s ease;
                                            cursor: pointer;
                                        }

                                        .correct-answer-list .form-check:hover {
                                            background-color: #e8f5e8;
                                            border-color: #28a745;
                                            transform: translateX(2px);
                                        }

                                        .correct-answer-list .form-check-input:checked + .form-check-label {
                                            color: #28a745;
                                            font-weight: 600;
                                        }

                                        .correct-answer-list .form-check-input:checked ~ * {
                                            background-color: #d4edda;
                                            border-color: #28a745;
                                        }

                                        .correct-answer-list .form-check-label {
                                            cursor: pointer;
                                            width: 100%;
                                            margin-bottom: 0;
                                            color: #000000;
                                            transition: all 0.3s ease;
                                        }

                                        .correct-answer-list .form-check-input {
                                            margin-top: 0.25rem;
                                            accent-color: #28a745;
                                        }

                                        #selectedCorrectAnswers {
                                            font-weight: bold;
                                            color: #28a745;
                                            transition: all 0.3s ease;
                                        }

                                        #correctAnswerSection .alert-info {
                                            background-color: #e3f2fd;
                                            border-color: #bbdefb;
                                            color: #1976d2;
                                            border-radius: 8px;
                                        }

                                        /* Scrollbar for correct answer list */
                                        .correct-answer-list::-webkit-scrollbar {
                                            width: 6px;
                                        }

                                        .correct-answer-list::-webkit-scrollbar-track {
                                            background: #f1f1f1;
                                            border-radius: 3px;
                                        }

                                        .correct-answer-list::-webkit-scrollbar-thumb {
                                            background: #28a745;
                                            border-radius: 3px;
                                        }

                                        .correct-answer-list::-webkit-scrollbar-thumb:hover {
                                            background: #1e7e34;
                                        }
                                        
                                        /* Tooltip for slider */
                                        .slider-tooltip {
                                            position: absolute;
                                            top: -30px;
                                            left: 0;
                                            background-color: #6610f2;
                                            color: white;
                                            padding: 2px 8px;
                                            border-radius: 4px;
                                            font-size: 0.8rem;
                                            opacity: 0;
                                            transition: opacity 0.3s;
                                            pointer-events: none;
                                            transform: translateX(-50%);
                                            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                                        }

                                        /* Correct Answer Styling */
                                        .correct-answer {
                                            color: #000000 !important;
                                            font-weight: 600;
                                            background-color: #f8f9fa;
                                            padding: 8px 12px;
                                            border-radius: 6px;
                                            border-left: 4px solid #28a745;
                                            margin: 10px 0;
                                        }

                                        .correct-answer p {
                                            color: #000000 !important;
                                            margin: 0;
                                        }

                                        /* Fix text color in alert-info for correct answer selection */
                                        #correctAnswerSection .alert-info {
                                            color: #000000 !important;
                                        }

                                        #correctAnswerSection .alert-info small {
                                            color: #000000 !important;
                                        }
                                        
                                        .slider-tooltip::after {
                                            content: '';
                                            position: absolute;
                                            top: 100%;
                                            left: 50%;
                                            margin-left: -5px;
                                            border-width: 5px;
                                            border-style: solid;
                                            border-color: #6610f2 transparent transparent transparent;
                                        }
                                        
                                        #languageSlider:hover + .slider-tooltip,
                                        #languageSlider:active + .slider-tooltip {
                                            opacity: 1;
                                        }

                                        /* Enhanced Modal Styles */
                                        #answerOptionsModal .modal-xl {
                                            max-width: 1200px;
                                        }

                                        #answerOptionsModal .modal-body {
                                            max-height: 80vh;
                                            overflow-y: auto;
                                        }

                                        #answerOptionsModal .text-primary {
                                            color: #6610f2 !important;
                                        }

                                        #answerOptionsModal .form-label {
                                            font-weight: 600;
                                            margin-bottom: 0.5rem;
                                        }

                                        #answerOptionsModal .form-control {
                                            border-radius: 8px;
                                            border: 2px solid #e9ecef;
                                            transition: all 0.3s ease;
                                        }

                                        #answerOptionsModal .form-control:focus {
                                            border-color: #6610f2;
                                            box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
                                        }

                                        #imagePreview {
                                            border-radius: 8px;
                                            overflow: hidden;
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                        }

                                        #imagePreview img {
                                            transition: transform 0.3s ease;
                                        }

                                        #imagePreview:hover img {
                                            transform: scale(1.05);
                                        }

                                        /* Section headers styling */
                                        #answerOptionsModal h6 {
                                            border-bottom: 2px solid #6610f2;
                                            padding-bottom: 8px;
                                            margin-bottom: 15px;
                                            font-weight: 600;
                                        }

                                        /* Button styling */
                                        #answerOptionsModal .btn-primary {
                                            background: linear-gradient(135deg, #6610f2 0%, #9333ea 100%);
                                            border: none;
                                            border-radius: 8px;
                                            padding: 10px 25px;
                                            font-weight: 600;
                                            transition: all 0.3s ease;
                                        }

                                        #answerOptionsModal .btn-primary:hover {
                                            transform: translateY(-2px);
                                            box-shadow: 0 4px 15px rgba(102, 16, 242, 0.4);
                                        }

                                        #answerOptionsModal .btn-secondary {
                                            border-radius: 8px;
                                            padding: 10px 25px;
                                            font-weight: 600;
                                        }

                                        /* Alert styling */
                                        #answerOptionsModal .alert-info {
                                            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                                            border: none;
                                            border-radius: 8px;
                                            border-left: 4px solid #1976d2;
                                        }

                                        /* Uploaded image preview styling */
                                        .uploaded-image-preview {
                                            max-width: 300px;
                                            max-height: 200px;
                                            width: auto;
                                            height: auto;
                                            border: 2px solid #e9ecef;
                                            border-radius: 8px;
                                            margin-top: 10px;
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                            transition: transform 0.3s ease, box-shadow 0.3s ease;
                                        }

                                        .uploaded-image-preview:hover {
                                            transform: scale(1.05);
                                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                                        }

                                        /* Selected file name display */
                                        .selected-file-name {
                                            background-color: #d4edda;
                                            border: 1px solid #c3e6cb;
                                            border-radius: 6px;
                                            padding: 5px 10px;
                                            margin-top: 5px;
                                        }

                                        .selected-file-name small {
                                            margin: 0;
                                            font-weight: 500;
                                        }

                                        /* Subjective Question Modal Styles */
                                        #subjectiveQuestionModal .modal-header {
                                            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                                            color: white;
                                            border-bottom: none;
                                        }

                                        #subjectiveQuestionModal .modal-header .btn-close {
                                            filter: invert(1);
                                        }

                                        #subjectiveQuestionModal .modal-title {
                                            font-weight: 600;
                                        }

                                        #subjectiveQuestionModal .text-success {
                                            color: #28a745 !important;
                                        }

                                        #subjectiveQuestionModal h6 {
                                            border-bottom: 2px solid #28a745;
                                            padding-bottom: 8px;
                                            margin-bottom: 15px;
                                            font-weight: 600;
                                        }

                                        #subjectiveQuestionModal .btn-success {
                                            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                                            border: none;
                                            border-radius: 8px;
                                            padding: 10px 25px;
                                            font-weight: 600;
                                            transition: all 0.3s ease;
                                        }

                                        #subjectiveQuestionModal .btn-success:hover {
                                            transform: translateY(-2px);
                                            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
                                        }

                                        #subjectiveQuestionModal .form-control {
                                            border-radius: 8px;
                                            border: 2px solid #e9ecef;
                                            transition: all 0.3s ease;
                                        }

                                        #subjectiveQuestionModal .form-control:focus {
                                            border-color: #28a745;
                                            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
                                        }

                                        #subjectiveImagePreview {
                                            border-radius: 8px;
                                            overflow: hidden;
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                        }

                                        #subjectiveImagePreview img {
                                            transition: transform 0.3s ease;
                                        }

                                        #subjectiveImagePreview:hover img {
                                            transform: scale(1.05);
                                        }

                                        #subjectivePreviewTextarea {
                                            background-color: #f8f9fa;
                                            border: 2px dashed #28a745;
                                            color: #6c757d;
                                        }
                                    </style>

                                    <script>
                                        /**
                                         * Initializes the enhanced language slider functionality
                                         */
                                        function initializeLanguageSlider() {
                                            const languageSlider = document.getElementById('languageSlider');
                                            const languageInput = document.getElementById('language');
                                            const englishLabel = document.getElementById('english-label');
                                            const malayLabel = document.getElementById('malay-label');
                                            const mixLabel = document.getElementById('mix-label');
                                            const sliderTooltip = document.querySelector('.slider-tooltip');
                                            const labelContainer = document.querySelector('.slider-label-container');
                                            
                                            // Map slider values to language options
                                            const languageOptions = ['english', 'malay', 'mix'];
                                            const languageLabels = [englishLabel, malayLabel, mixLabel];
                                            const languageNames = ['English', 'Malay', 'Mix'];
                                            
                                            // Set initial active state
                                            updateActiveLabel(0);
                                            updateTooltipPosition(0);
                                            
                                            // Update language when slider changes
                                            if (languageSlider) {
                                                languageSlider.addEventListener('input', function() {
                                                    const value = parseInt(this.value);
                                                    languageInput.value = languageOptions[value];
                                                    updateActiveLabel(value);
                                                    updateTooltipPosition(value);
                                                    
                                                    // Add sliding class for animation
                                                    labelContainer.classList.add('sliding');
                                                });
                                                
                                                // When slider interaction ends
                                                languageSlider.addEventListener('change', function() {
                                                    // Remove sliding class to stop animation
                                                    labelContainer.classList.remove('sliding');
                                                    
                                                    // Add pulse animation to selected label only
                                                    const selectedLabel = document.querySelector('.slider-label.active');
                                                    selectedLabel.classList.add('pulse-once');
                                                    setTimeout(() => {
                                                        selectedLabel.classList.remove('pulse-once');
                                                    }, 500);
                                                });
                                                
                                                // Update tooltip content and position on mousemove
                                                languageSlider.addEventListener('mousemove', function(e) {
                                                    if (sliderTooltip) {
                                                        updateTooltipPosition(parseInt(this.value));
                                                    }
                                                });
                                                
                                                // Show tooltip on mouse over
                                                languageSlider.addEventListener('mouseenter', function() {
                                                    if (sliderTooltip) {
                                                        sliderTooltip.style.opacity = '1';
                                                    }
                                                });
                                                
                                                // Hide tooltip on mouse out
                                                languageSlider.addEventListener('mouseleave', function() {
                                                    if (sliderTooltip) {
                                                        sliderTooltip.style.opacity = '0';
                                                    }
                                                });
                                            }
                                            
                                            // Add click event to labels
                                            languageLabels.forEach((label, index) => {
                                                if (label) {
                                                    label.addEventListener('click', function() {
                                                        languageSlider.value = index;
                                                        languageInput.value = languageOptions[index];
                                                        updateActiveLabel(index);
                                                        updateTooltipPosition(index);
                                                        
                                                        // Add pulse animation to selected label
                                                        this.classList.add('pulse-once');
                                                        setTimeout(() => {
                                                            this.classList.remove('pulse-once');
                                                        }, 500);
                                                    });
                                                }
                                            });
                                            
                                            // Function to update active label styling
                                            function updateActiveLabel(activeIndex) {
                                                languageLabels.forEach((label, index) => {
                                                    if (label) {
                                                        if (index === activeIndex) {
                                                            label.classList.add('active');
                                                        } else {
                                                            label.classList.remove('active');
                                                        }
                                                    }
                                                });
                                            }
                                            
                                            // Function to update tooltip position and content
                                            function updateTooltipPosition(sliderValue) {
                                                if (sliderTooltip) {
                                                    // Update content
                                                    sliderTooltip.textContent = languageNames[sliderValue];
                                                    
                                                    // Update position
                                                    const sliderWidth = languageSlider.offsetWidth;
                                                    const thumbPosition = (sliderValue / 2) * sliderWidth;
                                                    sliderTooltip.style.left = thumbPosition + 'px';
                                                }
                                            }
                                            
                                            // Add drag effect
                                            let isDragging = false;
                                            
                                            languageSlider.addEventListener('mousedown', function() {
                                                isDragging = true;
                                                languageSlider.style.cursor = 'grabbing';
                                                
                                                // Add effect when dragging starts
                                                document.body.classList.add('slider-dragging');
                                                languageSlider.classList.add('dragging');
                                            });
                                            
                                            document.addEventListener('mouseup', function() {
                                                if (isDragging) {
                                                    isDragging = false;
                                                    languageSlider.style.cursor = 'grab';
                                                    
                                                    // Remove effect when dragging ends
                                                    document.body.classList.remove('slider-dragging');
                                                    languageSlider.classList.remove('dragging');
                                                }
                                            });
                                            
                                            document.addEventListener('mousemove', function(e) {
                                                if (isDragging) {
                                                    // Optional: add some additional drag effects if desired
                                                }
                                            });
                                        }

                                        // Add this to ensure it's called when the document is ready
                                        document.addEventListener('DOMContentLoaded', function() {
                                            initializeAIQuizGenerator();
                                            initializeLanguageSlider();
                                        });
                                    </script>

                                </div>
                                    
                                    
                                <script>
                                /**
                                 * AI Quiz Generator
                                 * 
                                 * This script handles the AI-powered quiz generation functionality.
                                 * It processes PDF documents and creates questions of different types
                                 * based on the document content.
                                 */

                                // Wait for DOM to be fully loaded before initializing
                                document.addEventListener('DOMContentLoaded', function() {
                                    initializeAIQuizGenerator();
                                });

                                /**
                                * Initializes the AI Quiz Generator functionality
                                */
                                function initializeAIQuizGenerator() {
                                    // Get reference to the generate button
                                    const generateButton = document.getElementById('generateQuizAI');
                                    
                                    // Add event listener to the generate button
                                    if (generateButton) {
                                        generateButton.addEventListener('click', handleGenerateQuiz);
                                        
                                        // Add a pulse animation to make the button more noticeable
                                        generateButton.classList.add('pulse-animation');
                                    }
                                    
                                    // Add file input listener to show filename when selected
                                    const documentInput = document.getElementById('documentInput');
                                    if (documentInput) {
                                        documentInput.addEventListener('change', function(e) {
                                            const fileName = e.target.files[0]?.name || 'No file selected';
                                            const fileLabel = document.querySelector('label[for="documentInput"]');
                                            if (fileLabel) {
                                                fileLabel.innerHTML = `<strong>Document selected:</strong> ${fileName}`;
                                            }
                                        });
                                    }
                                }

                                /**
                                * Handles the generate quiz button click
                                */
                                function handleGenerateQuiz() {
                                    // Create FormData from the form
                                    const formData = new FormData(document.getElementById('aiQuizForm'));
                                    
                                    // Validate inputs before proceeding
                                    if (!validateAIQuizForm()) {
                                        return;
                                    }
                                    
                                    // Show loading state
                                    Swal.fire({
                                        title: "Generating Quiz",
                                        html: "Please wait while our AI analyzes your document and creates questions...",
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                    
                                    // Send the request to the server
                                    fetch(`/user/quiz/${getCourseId()}/generate-ai-quiz`, {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        },
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(`HTTP error! Status: ${response.status}`);
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        // Close loading indicator
                                        Swal.close();
                                        
                                        // Handle the response
                                        if (data.success) {
                                            processQuizQuestions(data);
                                        } else {
                                            showErrorMessage(data.message || 'Failed to generate quiz.');
                                        }
                                    })
                                    .catch(error => {
                                        // Close loading indicator
                                        Swal.close();
                                        
                                        // Show error message
                                        console.error('Error:', error);
                                        showErrorMessage('An error occurred while generating the quiz. Please check the document and try again.');
                                    });
                                }

                                /**
                                * Gets the course ID from session
                                * @returns {string} The course ID
                                */
                                function getCourseId() {
                                    return '{{ Session::get('subjects')->id }}';
                                }

                                /**
                                * Validates the AI Quiz form
                                * @returns {boolean} Whether the form is valid
                                */
                                function validateAIQuizForm() {
                                    const documentFile = document.getElementById('documentInput').files[0];
                                    const singleChoiceCount = parseInt(document.getElementById('singleChoiceCount').value) || 0;
                                    const multipleChoiceCount = parseInt(document.getElementById('multipleChoiceCount').value) || 0;
                                    const subjectiveCount = parseInt(document.getElementById('subjectiveCount').value) || 0;
                                    
                                    // Check if a document is selected
                                    if (!documentFile) {
                                        showErrorMessage('Please select a PDF document.');
                                        return false;
                                    }
                                    
                                    // Check if the file is a PDF
                                    if (documentFile.type !== 'application/pdf') {
                                        showErrorMessage('Only PDF documents are supported.');
                                        return false;
                                    }
                                    
                                    // Check if any question count is negative
                                    if (singleChoiceCount < 0 || multipleChoiceCount < 0 || subjectiveCount < 0) {
                                        showErrorMessage('Question counts cannot be negative.');
                                        return false;
                                    }
                                    
                                    // Check if at least one question type has a count greater than zero
                                    const totalQuestions = singleChoiceCount + multipleChoiceCount + subjectiveCount;
                                    if (totalQuestions === 0) {
                                        showErrorMessage('Please specify at least one question to generate.');
                                        return false;
                                    }
                                    
                                    // Check if total questions is reasonable (not too many)
                                    if (totalQuestions > 50) {
                                        showErrorMessage('Please generate 50 or fewer questions at once.');
                                        return false;
                                    }
                                    
                                    return true;
                                }

                                /**
                                * Shows a success message using SweetAlert
                                */
                                function showSuccessMessage() {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Quiz questions have been generated successfully.",
                                        icon: "success",
                                        confirmButtonText: "Great!"
                                    });
                                }

                                /**
                                * Shows an error message using SweetAlert
                                * @param {string} message The error message to display
                                */
                                function showErrorMessage(message) {
                                    Swal.fire({
                                        title: "Error",
                                        text: message,
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    });
                                }

                                /**
                                * Shows a warning message using SweetAlert
                                * @param {string} message The warning message to display
                                */
                                function showWarningMessage(message) {
                                    Swal.fire({
                                        title: "Warning",
                                        text: message,
                                        icon: "warning",
                                        confirmButtonText: "Continue Anyway"
                                    });
                                }

                                /**
                                * Processes the quiz questions returned from the server
                                * @param {Object} data The response data from the server
                                */
                                function processQuizQuestions(data) {
    try {
        // Parse the JSON data
        let quizData;
        if (typeof data.formBuilderJSON === 'string') {
            quizData = JSON.parse(data.formBuilderJSON);
        } else {
            quizData = data.formBuilderJSON;
        }
        
        // If no questions were received, create empty questions array
        if (!quizData || !quizData.quiz || !quizData.quiz.questions || !Array.isArray(quizData.quiz.questions)) {
            console.error('Invalid quiz data structure received.');
            showErrorMessage('The AI generated an invalid quiz structure. Please try again.');
            return;
        }
        
        // Extract questions array
        const allQuestions = quizData.quiz.questions;
        
        // Get the requested counts from the form
        const requestedSingleChoice = parseInt(document.getElementById('singleChoiceCount').value) || 0;
        const requestedMultipleChoice = parseInt(document.getElementById('multipleChoiceCount').value) || 0;
        const requestedSubjective = parseInt(document.getElementById('subjectiveCount').value) || 0;
        
        // Sort questions by type
        const singleChoiceQuestions = allQuestions.filter(q => q.type === 'single-choice');
        const multipleChoiceQuestions = allQuestions.filter(q => q.type === 'multiple-choice');
        const subjectiveQuestions = allQuestions.filter(q => q.type === 'subjective');
        
        // Create the final list of questions in the order they are requested
        const finalQuestions = [
            ...singleChoiceQuestions.slice(0, requestedSingleChoice),
            ...multipleChoiceQuestions.slice(0, requestedMultipleChoice),
            ...subjectiveQuestions.slice(0, requestedSubjective)
        ];
        
        // Check if we have enough questions of each type
        const actualSingleChoice = Math.min(singleChoiceQuestions.length, requestedSingleChoice);
        const actualMultipleChoice = Math.min(multipleChoiceQuestions.length, requestedMultipleChoice);
        const actualSubjective = Math.min(subjectiveQuestions.length, requestedSubjective);
        
        // If we didn't get enough questions of any type, show a warning
        if (actualSingleChoice < requestedSingleChoice || 
            actualMultipleChoice < requestedMultipleChoice || 
            actualSubjective < requestedSubjective) {
            
            let message = "The AI couldn't generate enough questions of the requested types. Generated:";
            if (requestedSingleChoice > 0) {
                message += ` ${actualSingleChoice}/${requestedSingleChoice} single-choice questions.`;
            }
            if (requestedMultipleChoice > 0) {
                message += ` ${actualMultipleChoice}/${requestedMultipleChoice} multiple-choice questions.`;
            }
            if (requestedSubjective > 0) {
                message += ` ${actualSubjective}/${requestedSubjective} subjective questions.`;
            }
            
            showWarningMessage(message);
        } else {
            // Show success message only if we got all the questions we wanted
            showSuccessMessage();
        }
        
        // If we have no questions to display, show an error
        if (finalQuestions.length === 0) {
            showErrorMessage('No valid questions were generated. Please try again with a different document or question settings.');
            return;
        }
        
        // Get the current question index value before adding new questions
        const currentQuestionIndex = parseInt(document.getElementById('question-index').value) || 1;
        
        // Process each question
        finalQuestions.forEach((question, index) => {
            // Use the current question index + the index of this question in the batch
            const questionNumber = currentQuestionIndex + index;
            addQuestionToFormBuilder(question, questionNumber);
        });
        
        // Update question index value to reflect the new total
        updateQuestionIndex(finalQuestions.length);
    } catch (e) {
        console.error('Error processing quiz data:', e);
        showErrorMessage('Error processing the generated quiz data. Please try again.');
    }
}
                                /**
                                * Adds a question to the form builder
                                * @param {Object} question The question object
                                * @param {number} index The question index
                                */
                                function addQuestionToFormBuilder(question, questionNumber) {
    // Add header for the question with the correct number
    formBuilder.actions.addField({
        type: 'header',
        className: 'mt-4',
        label: `Question ${questionNumber}`,
    });

    // Add file upload field
    formBuilder.actions.addField({
        type: 'file',
        className: 'form-control',
        label: 'Upload Image',
        description: 'Drag and drop or click to select an image file.',
        name: `uploaded_image[]`,
    });

    // Add the question paragraph
    formBuilder.actions.addField({
        type: 'paragraph',
        label: question.question,
    });

    // Handle different question formats
    addQuestionByType(question, questionNumber);

    // Add correct answer field with proper formatting
    addCorrectAnswerField(question, questionNumber);

    // Add checkbox for marks
    formBuilder.actions.addField({
        type: 'checkbox-group',
        className: 'collected-marks pull-right chk-col-danger',
        label: '',
        values: [
            {
                label: '1 mark',
                value: '1',
                selected: false,
            },
        ],
    });

    // Add comment text field
    formBuilder.actions.addField({
        type: 'text',
        className: 'feedback-text form-control',
        placeholder: 'Comment',
    });
}
                                /**
                                * Adds a correct answer field to the form builder
                                * @param {Object} question The question object
                                * @param {number} index The question index
                                */
                                function addCorrectAnswerField(question, index) {
                                    if (!question.answer) {
                                        return;
                                    }

                                    let answerText = '';
                                    
                                    // Format the answer text based on question type
                                    if (question.type === 'single-choice') {
                                        answerText = question.answer;
                                    } else if (question.type === 'multiple-choice') {
                                        // Make sure multiple-choice answers are comma-separated
                                        answerText = Array.isArray(question.answer) 
                                            ? question.answer.join(',')
                                            : question.answer;
                                    } else if (question.type === 'subjective') {
                                        answerText = question.answer;
                                    }

                                    // Add the answer field as plain text
                                    formBuilder.actions.addField({
                                        type: 'paragraph',
                                        className: 'correct-answer',
                                        label: answerText
                                    });
                                }

                                /**
                                * Adds a question to the form builder based on its type
                                * @param {Object} question The question object
                                * @param {number} index The question index
                                */
                                function addQuestionByType(question, questionNumber) {
    if (question.type === 'single-choice') {
        // Add single-choice (radio button) question
        formBuilder.actions.addField({
            type: 'radio-group',
            className: 'with-gap radio-col-primary',
            label: '<label class="text-primary"><strong>Your Answer</strong></label>',
            name: `radio-question${questionNumber}`,
            values: question.options.map((option, optionIndex) => ({
                label: `${String.fromCharCode(97 + optionIndex)}) ${option}`,
                value: option,
            })),
        });
    } else if (question.type === 'multiple-choice') {
        // Add multiple-choice (checkbox) question
        formBuilder.actions.addField({
            type: 'checkbox-group',
            className: 'filled-in chk-col-warning',
            label: '<label class="text-primary"><strong>Your Answer</strong></label>',
            name: `checkbox-question${questionNumber}`,
            values: question.options.map((option, optionIndex) => ({
                label: `${String.fromCharCode(97 + optionIndex)}) ${option}`,
                value: option,
            })),
        });
    } else if (question.type === 'subjective') {
        // Add subjective (text area) question
        formBuilder.actions.addField({
            type: 'textarea',
            rows: 5,
            className: 'form-control',
            placeholder: 'Your Answer',
            name: `subjective-text${questionNumber}`,
        });
    }
}
                                /**
                                * Updates the question index after adding new questions
                                * @param {number} addedQuestionsCount Number of questions added
                                */
                                function updateQuestionIndex(addedQuestionsCount) {
    const questionIndexField = document.getElementById('question-index');
    if (questionIndexField) {
        const currentIndex = parseInt(questionIndexField.value) || 1;
        questionIndexField.value = currentIndex + addedQuestionsCount;
        // Update the global questionnum variable used by manual question addition
        questionnum = currentIndex + addedQuestionsCount;
    }
}

                                </script>
                                    
                                </div>

                                <div id="form-div" class="hide-published-element col-md-12 mb-3">
                                    <div class="addFieldWrap pull-left">
                                        <a id="appendfield3" class="appendfield3 waves-effect waves-light btn btn-app btn-danger-light " data-label="Question" type="button">
                                            <i class="fa fa-plus"></i> <b>Header</b></a>
                                        <a id="appendfield1" class="appendfield1 waves-effect waves-light btn btn-app btn-info-light " data-label="Question" type="button">
                                            <i class="fa fa-plus"></i> <b>Radio Question</b></a>
                                        <a id="appendfield2" class="appendfield2 waves-effect waves-light btn btn-app btn-warning-light " data-label="Question" type="button">
                                            <i class="fa fa-plus"></i> <b>Checkbox Question</b></a>
                                        <a id="appendfield2" class="appendfield4 waves-effect waves-light btn btn-app btn-success-light " data-label="Question" type="button">
                                            <i class="fa fa-plus"></i> <b>Subjective Question</b></a>
                                    </div>

                                    <!-- Enhanced Answer Options Modal -->
                                    <div class="modal fade" id="answerOptionsModal" tabindex="-1" role="dialog" aria-labelledby="answerOptionsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="answerOptionsModalLabel">Create Question</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Question Details Section -->
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <h6 class="text-primary"><i class="fa fa-edit me-2"></i>Question Details</h6>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <label for="questionParagraph" class="form-label"><strong>Question Paragraph</strong></label>
                                                                        <textarea id="questionParagraph" class="form-control" rows="4" placeholder="Enter your question here..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="questionMark" class="form-label"><strong>Mark</strong></label>
                                                                        <input type="number" id="questionMark" class="form-control" min="1" value="1" placeholder="Enter mark">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Image Upload Section -->
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <h6 class="text-primary"><i class="fa fa-image me-2"></i>Question Image (Optional)</h6>
                                                            <div class="form-group">
                                                                <input type="file" class="form-control" id="questionImage" accept="image/*">
                                                                <small class="text-muted">Upload an image to accompany your question (optional)</small>
                                                                <div id="imagePreview" class="mt-2" style="display: none;">
                                                                    <img id="previewImg" class="img-fluid border rounded" style="max-height: 200px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Answer Options Section -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary"><i class="fa fa-list me-2"></i>Answer Options</h6>
                                                            <div class="form-group">
                                                                <label for="pastedOptions" class="form-label"><strong>Paste Your Options (one per line):</strong></label>
                                                                <textarea id="pastedOptions" class="form-control" rows="8" placeholder="Option 1
Option 2
Option 3
Option 4

Tip: Copy from Google Docs, Word, or any text source - each line becomes an option!
You can paste from clipboard or type directly here."></textarea>
                                                                <div class="mt-2">
                                                                    <button type="button" class="btn btn-sm btn-secondary" id="clearOptions">Clear</button>
                                                                    <button type="button" class="btn btn-sm btn-info" id="addDefaultOptions">Add Default A-D</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary"><i class="fa fa-eye me-2"></i>Options Preview</h6>
                                                            <div id="optionsPreview" class="border p-3" style="min-height: 200px; background-color: #f8f9fa;">
                                                                <p class="text-muted">Options will appear here as you type...</p>
                                                            </div>
                                                            <div class="mt-2">
                                                                <small class="text-muted">Total options: <span id="optionCount">0</span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Correct Answer Selection Section -->
                                                    <div class="row mt-3" id="correctAnswerSection" style="display: none;">
                                                        <div class="col-md-12">
                                                            <h6 class="text-primary"><i class="fa fa-check-circle me-2"></i>Select Correct Answer(s)</h6>
                                                            <div class="alert alert-info">
                                                                <small><i class="fa fa-info-circle"></i> For <strong>Radio Questions</strong>: Select ONE correct answer</small><br>
                                                                <small><i class="fa fa-info-circle"></i> For <strong>Checkbox Questions</strong>: Select MULTIPLE correct answers</small>
                                                            </div>
                                                            <div id="correctAnswerOptions" class="border p-3" style="background-color: #f8f9fa; border-radius: 6px; max-height: 200px; overflow-y: auto;">
                                                                <p class="text-muted text-center">Add options above to select correct answers...</p>
                                                            </div>
                                                            <div class="mt-2">
                                                                <small class="text-success">Selected: <span id="selectedCorrectAnswers">None</span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="applyOptions">Create Question</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Subjective Question Modal -->
                                    <div class="modal fade" id="subjectiveQuestionModal" tabindex="-1" role="dialog" aria-labelledby="subjectiveQuestionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="subjectiveQuestionModalLabel">Create Subjective Question</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Question Details Section -->
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <h6 class="text-success"><i class="fa fa-edit me-2"></i>Question Details</h6>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <label for="subjectiveQuestionParagraph" class="form-label"><strong>Question Paragraph</strong></label>
                                                                        <textarea id="subjectiveQuestionParagraph" class="form-control" rows="4" placeholder="Enter your subjective question here..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="subjectiveQuestionMark" class="form-label"><strong>Mark</strong></label>
                                                                        <input type="number" id="subjectiveQuestionMark" class="form-control" min="1" value="5" placeholder="Enter mark">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Image Upload Section -->
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <h6 class="text-success"><i class="fa fa-image me-2"></i>Question Image (Optional)</h6>
                                                            <div class="form-group">
                                                                <input type="file" class="form-control" id="subjectiveQuestionImage" accept="image/*">
                                                                <small class="text-muted">Upload an image to accompany your question (optional)</small>
                                                                <div id="subjectiveImagePreview" class="mt-2" style="display: none;">
                                                                    <img id="subjectivePreviewImg" class="img-fluid border rounded" style="max-height: 200px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!-- Answer Area Settings -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="text-success"><i class="fa fa-cog me-2"></i>Answer Area Settings</h6>
                                                            <div class="form-group">
                                                                <label for="subjectiveAnswerRows" class="form-label"><strong>Answer Area Size (Rows)</strong></label>
                                                                <input type="number" id="subjectiveAnswerRows" class="form-control" min="3" max="20" value="5" placeholder="Number of rows">
                                                                <small class="text-muted">Number of visible rows in the answer textarea</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-success"><i class="fa fa-eye me-2"></i>Answer Area Preview</h6>
                                                            <div class="border p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                                                <label class="form-label"><strong>Your Answer</strong></label>
                                                                <textarea id="subjectivePreviewTextarea" class="form-control" rows="5" placeholder="This is how the answer area will appear to students..." disabled></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-success" id="createSubjectiveQuestion">Create Subjective Question</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right  badge badge-xl badge-success" style="font-size:1.2em">
                                        <label id="participant-mark"></label> 
                                        <input type="text" id="collectmark" name="collectmark" hidden>
                                        <!--/<label id="total_mark" ></label>-->
                                </div>
                                </div>

                                <div class="col-md-12">
                                    <div id="fb-editor"></div>
                                    <div id="build-wrap"></div>
                                </div>
                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-12">
                    <div class=" d-flex justify-content-center">
                        <div id="fb-rendered-form" class="card" style="width:800px">
                            <div class="card-body">
                                <form action="#" id="fb-render" class="mb-3"></form>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button onclick="history.back();" class="btn btn-secondary pull-left m-1"><i class="mdi mdi-keyboard-return"></i> Back</button>
                                    </div>
                                    <div class="col-md-9 hide-published-element">
                                        <button id="publish-quiz"  class="btn btn-info pull-right m-1"><i class="mdi mdi-publish"></i> Save & Publish</button>
                                        <button id="save-quiz"  class="btn btn-primary pull-right m-1"><i class="mdi mdi-content-save"></i> Save</button>
                                        <button class="btn btn-primary-light edit-form pull-right m-1"><i class="mdi mdi-edit"></i> Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
              
            </div>
        </section>
    </div>
</div>



<!-- jQuery UI required for form-builder's sortable functionality -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-builder.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-render.min.js"></script>

<script>
// Bootstrap 5 Modal Helper Functions
function showModal(modalId) {
    try {
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    } catch (error) {
        console.error('Bootstrap 5 not loaded or modal error:', error);
        // Fallback to jQuery if Bootstrap 5 is not available
        if (typeof $ !== 'undefined') {
            $('#' + modalId).modal('show');
        }
    }
}

function hideModal(modalId) {
    try {
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            } else {
                // Fallback if modal instance doesn't exist
                const newModal = new bootstrap.Modal(modalElement);
                newModal.hide();
            }
        }
    } catch (error) {
        console.error('Bootstrap 5 not loaded or modal error:', error);
        // Fallback to jQuery if Bootstrap 5 is not available
        if (typeof $ !== 'undefined') {
            $('#' + modalId).modal('hide');
        }
    }
}

var selected_from = '';
var selected_to = '';
var total_correct_mark = 0;

$(document).ready(function(){
    if('{{ $data['quizid'] }}' != '')
    {
        //alert('true');

        $('#time-to').removeAttr('hidden');
    
        selected_from = $('#from').val();

        selected_to = $('#to').val();

        getDuration(selected_from,selected_to);

    }
});

$(document).on('change', '#from', async function(e){

    $('#time-to').removeAttr('hidden');
    
    selected_from = $(e.target).val();

    if(selected_to != '')
    {
        await getDuration(selected_from,selected_to);
    }

});

$(document).on('change', '#to', async function(e){
    selected_to = $(e.target).val();

    await getDuration(selected_from,selected_to);
});

function getDuration(from,to)
{
    var x = new Date(from);
    var y = new Date(to);
    var z =  y - x;

    var minutes = Math.floor(z / 60000);
    //alert(z)

    $('#quiz-duration').val(minutes);

}

var intervalId = window.setInterval(function(){
    total_correct_mark = 0;
    renderMark();
}, 500);



function renderMark(){
    
   
    $('.collected-marks').each((i)=>{
        var checkbox = $($('.collected-marks')[i]);

        var mark = checkbox.val();
        mark = parseFloat(mark);

        
        total_correct_mark = total_correct_mark + mark;
        
    });

    $('#participant-mark').html(total_correct_mark + " Mark");
    $('#collectmark').val(total_correct_mark);
}
</script>

<script>
var selected_folder = "";

$(document).on('change', '#folder', async function(e){
    selected_folder = $(e.target).val();

    await getChapters(selected_folder);
});

$(document).ready(function(){
    if('{{ $data['quizid'] }}' != '')
    {
        selected_folder = $('#folder').val();

        getChapters(selected_folder);
    }
});

function getChapters(folder)
{

  return $.ajax({
        headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
        url      : "{{ url('user/quiz/getChapters') }}",
        method   : 'POST',
        data 	 : {folder: folder},
        error:function(err){
            alert("Error");
            console.log(err);
        },
        success  : function(data){
            
            //$('#lecturer-selection-div').removeAttr('hidden');
            //$('#lecturer').selectpicker('refresh');
  
            //$('#chapter').removeAttr('hidden');
                $('#chapterlist').html(data);
                //$('#chapter').selectpicker('refresh');
        }
    });

}
</script>

<script>

var questionnum     = $('#question-index').val();
var selected_class  = "{{ Session::get('subjects')->id }}";
var selected_quiz  = "{{ empty($data['quizid']) ? '' : $data['quizid'] }}";
var reuse  = "{{ empty($data['reuse']) ? '' : $data['reuse'] }}";
var quiz            = {!! empty($data['quiz']) ? "''" : json_encode($data['quiz']) !!};
var quiz_status  = {!! empty($data['quizstatus']) ? "''" : $data['quizstatus'] !!};
var quizFormData    = [];
var i = 0;
var imageDataUrls = {};
var currentImageDataUrl;

var formRenderInstance;

jQuery(function($) {

    var $fbEditor = $(document.getElementById('fb-editor'));
    $formContainer = $(document.getElementById('fb-rendered-form'));

    if(Object.keys(quiz).length > 0){
        quizFormData = quiz.content;
        quizFormData = JSON.parse(quizFormData).formData;
    }

    if(reuse == '')
    {
        if(quiz_status == 2){

            Swal.fire({
                title: "Quiz is already started!",
                text: "You are not allowed to edit anymore once published",
                confirmButtonText: "Ok"
            }).then(function(res){
                renderForm(quizFormData);
                $('#fb-rendered-form').show();
                $('.header-setting *').attr('disabled', 'disabled');
                $('.hide-published-element').hide();
            });

        }else{

            
            fbOptions = {
                formData: quizFormData,
                dataType: 'json',
                disableFields: [
                'autocomplete',
                'button',
                'checkbox-group',
                'date',
                'file',
                'header',
                'hidden',
                'number',
                'paragraph',
                'radio-group',
                'select',
                'text'
                ],
                onCloseFieldEdit: function(editPanel) {},
                onOpenFieldEdit: function(editPanel) {},
                onClearAll: function() {
                    $('#question-index').val(1);
                    questionnum = $('#question-index').val();
                    i = 1;
                },
                onSave: function() {
                    clearInterval(intervalId);
                    $fbEditor.toggle();
                    $formContainer.toggle();
                    $('#form-div').hide();
                    $('.addFieldWrap').hide();
                    $('#fb-render').formRender({formData: formBuilder.formData});

                    // Recreate the image previews
                    $('#fb-render').find('input[type="file"]').each(function(index, input) {
                        var imageDataUrl = imageDataUrls[index];

                        if (imageDataUrl) {
                        var previewImage = $('<img>').attr('src', imageDataUrl).addClass('uploaded-image-preview');
                        $(input).siblings('.uploaded-image-preview').remove(); // Remove old preview image
                        $(input).after(previewImage);
                        }
                    });


                    // Disable the file input fields
                    $('#fb-render').find('input[type="file"]').prop('disabled', true);
                }

            },

            formBuilder = $fbEditor.formBuilder(fbOptions);

        }
        
    }else{
        
        fbOptions = {
                formData: quizFormData,
                dataType: 'json',
                disableFields: [
                'autocomplete',
                'button',
                'checkbox-group',
                'date',
                'file',
                'header',
                'hidden',
                'number',
                'paragraph',
                'radio-group',
                'select',
                'text'
                ],
                onCloseFieldEdit: function(editPanel) {},
                onOpenFieldEdit: function(editPanel) {},
                onClearAll: function() {
                    $('#question-index').val(1);
                    questionnum = $('#question-index').val();
                    i = 1;
                },
                onSave: function() {
                    clearInterval(intervalId);
                    $fbEditor.toggle();
                    $formContainer.toggle();
                    $('#form-div').hide();
                    $('.addFieldWrap').hide();
                    $('#fb-render').formRender({formData: formBuilder.formData});

                    // Recreate the image previews
                    $('#fb-render').find('input[type="file"]').each(function(index, input) {
                        var imageDataUrl = imageDataUrls[index];

                        if (imageDataUrl) {
                        var previewImage = $('<img>').attr('src', imageDataUrl).addClass('uploaded-image-preview');
                        $(input).siblings('.uploaded-image-preview').remove(); // Remove old preview image
                        $(input).after(previewImage);
                        }
                    });

                    // Disable the file input fields
                    $('#fb-render').find('input[type="file"]').prop('disabled', true);
                }
            },

            formBuilder = $fbEditor.formBuilder(fbOptions);
    }

    var buttons = document.getElementsByClassName('appendfield1');
for (let j = 0; j < buttons.length; j++) {
    buttons[j].onclick = function() {
        // Store current question type and number for modal use
        window.currentQuestionType = 'radio';
        window.currentQuestionNum = questionnum;
        window.currentButtonIndex = this.dataset.index ? Number(this.dataset.index) : undefined;
        
        // Force clear modal data immediately - multiple times for safety
        clearModalData();
        setTimeout(clearModalData, 50);
        setTimeout(clearModalData, 100);
        
        // Show modal using Bootstrap 5 syntax
        showModal('answerOptionsModal');
    };
}

var buttons2 = document.getElementsByClassName('appendfield2');
for (let j = 0; j < buttons2.length; j++) {
    buttons2[j].onclick = function() {
        // Store current question type and number for modal use
        window.currentQuestionType = 'checkbox';
        window.currentQuestionNum = questionnum;
        window.currentButtonIndex = this.dataset.index ? Number(this.dataset.index) : undefined;
        
        // Force clear modal data immediately - multiple times for safety
        clearModalData();
        setTimeout(clearModalData, 50);
        setTimeout(clearModalData, 100);
        
        // Show modal using Bootstrap 5 syntax
        showModal('answerOptionsModal');
    };
}

    var buttons3 = document.getElementsByClassName('appendfield3');
    for (var i = 0; i < buttons3.length; i++) {
        buttons3[i].onclick = function() {
            var field = {
                type: 'header',
                className: 'd-flex justify-content-center bg-primary p-2',
                label: 'Header'
            };
            var index = this.dataset.index ? Number(this.dataset.index) : undefined;

            formBuilder.actions.addField(field, index);
            $('#question-index').val(questionnum);
        };
    }

    var buttons4 = document.getElementsByClassName('appendfield4');
for (let j = 0; j < buttons4.length; j++) {
    buttons4[j].onclick = function() {
        // Store current question type and number for modal use
        window.currentQuestionType = 'subjective';
        window.currentQuestionNum = questionnum;
        window.currentButtonIndex = this.dataset.index ? Number(this.dataset.index) : undefined;
        
        // Clear previous modal data completely
        clearSubjectiveModalData();
        
        // Show subjective modal using Bootstrap 5 syntax
        showModal('subjectiveQuestionModal');
    };
}

// Ensure the global questionnum variable is properly initialized from question-index
$(document).ready(function() {
    // Make sure questionnum is initialized from the question-index input
    questionnum = parseInt($('#question-index').val()) || 1;
    
    // Set up event listener to update questionnum when question-index changes
    $(document).on('change', '#question-index', function() {
        questionnum = parseInt($(this).val()) || 1;
    });
    
    // Initialize answer options modal functionality
    initializeAnswerOptionsModal();
    
    // Initialize subjective question modal functionality
    initializeSubjectiveQuestionModal();
});

/**
 * Nuclear clear - completely reset modal to pristine state
 */
function nuclearClearModal() {
    // Completely reset the file input section by rebuilding it
    const fileInputSection = $('#questionImage').closest('.form-group');
    if (fileInputSection.length > 0) {
        const newFileInputHTML = `
            <input type="file" class="form-control" id="questionImage" accept="image/*">
            <small class="text-muted">Upload an image to accompany your question (optional)</small>
            <div id="imagePreview" class="mt-2" style="display: none;">
                <img id="previewImg" class="img-fluid border rounded" style="max-height: 200px;">
            </div>
        `;
        fileInputSection.html(newFileInputHTML);
        
        // Re-attach the image preview functionality
        $('#questionImage').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').hide();
            }
        });
    }
    
    // Clear all other fields
    $('#questionParagraph').val('');
    $('#questionMark').val('1');
    $('#pastedOptions').val('');
    $('#optionsPreview').html('<p class="text-muted">Options will appear here as you type...</p>');
    $('#optionCount').text('0');
    $('#correctAnswerSection').hide();
    $('#selectedCorrectAnswers').text('None');
    $('#correctAnswerOptions').html('<p class="text-muted text-center">Add options above to select correct answers...</p>');
}

/**
 * Clear all modal data when opening for a new question
 */
function clearModalData() {
    // Use nuclear clear for complete reset
    nuclearClearModal();
}

/**
 * Nuclear clear for subjective modal
 */
function nuclearClearSubjectiveModal() {
    // Completely reset the file input section by rebuilding it
    const fileInputSection = $('#subjectiveQuestionImage').closest('.form-group');
    if (fileInputSection.length > 0) {
        const newFileInputHTML = `
            <input type="file" class="form-control" id="subjectiveQuestionImage" accept="image/*">
            <small class="text-muted">Upload an image to accompany your question (optional)</small>
            <div id="subjectiveImagePreview" class="mt-2" style="display: none;">
                <img id="subjectivePreviewImg" class="img-fluid border rounded" style="max-height: 200px;">
            </div>
        `;
        fileInputSection.html(newFileInputHTML);
        
        // Re-attach the image preview functionality
        $('#subjectiveQuestionImage').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#subjectivePreviewImg').attr('src', e.target.result);
                    $('#subjectiveImagePreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#subjectiveImagePreview').hide();
            }
        });
    }
    
    // Clear all other fields
    $('#subjectiveQuestionParagraph').val('');
    $('#subjectiveQuestionMark').val('5');
    $('#subjectiveAnswerRows').val('5');
    
    // Update preview textarea rows
    updateSubjectivePreview();
}

/**
 * Clear all subjective modal data
 */
function clearSubjectiveModalData() {
    nuclearClearSubjectiveModal();
}

/**
 * Update the subjective answer area preview
 */
function updateSubjectivePreview() {
    const rows = parseInt($('#subjectiveAnswerRows').val()) || 5;
    $('#subjectivePreviewTextarea').attr('rows', rows);
}

/**
 * Initialize the Subjective Question Modal functionality
 */
function initializeSubjectiveQuestionModal() {
    // Answer rows input change handler
    $('#subjectiveAnswerRows').on('input change', function() {
        updateSubjectivePreview();
    });
    
    // Image preview functionality
    $('#subjectiveQuestionImage').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#subjectivePreviewImg').attr('src', e.target.result);
                $('#subjectiveImagePreview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#subjectiveImagePreview').hide();
        }
    });
    
    // Create subjective question button
    $('#createSubjectiveQuestion').on('click', function() {
        // Validate question paragraph
        var questionParagraph = $('#subjectiveQuestionParagraph').val().trim();
        if (!questionParagraph) {
            alert('Please enter a question paragraph.');
            return;
        }
        
        // Validate mark
        var questionMark = parseInt($('#subjectiveQuestionMark').val()) || 0;
        if (questionMark <= 0) {
            alert('Please enter a valid mark (greater than 0).');
            return;
        }
        
        // Get other form values
        var answerRows = parseInt($('#subjectiveAnswerRows').val()) || 5;
        var imageFile = $('#subjectiveQuestionImage')[0].files[0];
        
        // Create the subjective question
        createSubjectiveQuestion(questionParagraph, questionMark, answerRows, imageFile);
        
        // Close modal
        hideModal('subjectiveQuestionModal');
        
        // Increment question number
        questionnum++;
        $('#question-index').val(questionnum);
    });
    
    // Close button handlers
    $(document).on('click', '#subjectiveQuestionModal .btn-close', function(e) {
        e.preventDefault();
        hideModal('subjectiveQuestionModal');
    });
    
    $(document).on('click', '#subjectiveQuestionModal [data-bs-dismiss="modal"], #subjectiveQuestionModal [data-dismiss="modal"]', function(e) {
        e.preventDefault();
        hideModal('subjectiveQuestionModal');
    });
    
    // ESC key handler
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#subjectiveQuestionModal').hasClass('show')) {
            hideModal('subjectiveQuestionModal');
        }
    });
    
    // Modal event handlers
    $('#subjectiveQuestionModal').on('show.bs.modal', function() {
        clearSubjectiveModalData();
    });
    
    $('#subjectiveQuestionModal').on('shown.bs.modal', function() {
        setTimeout(clearSubjectiveModalData, 100);
    });
}

/**
 * Initialize the Answer Options Modal functionality
 */
function initializeAnswerOptionsModal() {
    // Live preview as user types
    $('#pastedOptions').on('input', function() {
        updateOptionsPreview();
    });
    
    // Image preview functionality
    $('#questionImage').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });
    
    // Clear options button
    $('#clearOptions').on('click', function() {
        $('#pastedOptions').val('');
        updateOptionsPreview();
        $('#correctAnswerSection').hide();
        $('#selectedCorrectAnswers').text('None');
    });
    
    // Add default A-D options button
    $('#addDefaultOptions').on('click', function() {
        $('#pastedOptions').val('Option A\nOption B\nOption C\nOption D');
        updateOptionsPreview();
    });
    
    // Apply options button
    $('#applyOptions').on('click', function() {
        // Validate question paragraph
        var questionParagraph = $('#questionParagraph').val().trim();
        if (!questionParagraph) {
            alert('Please enter a question paragraph.');
            return;
        }
        
        // Validate mark
        var questionMark = parseInt($('#questionMark').val()) || 0;
        if (questionMark <= 0) {
            alert('Please enter a valid mark (greater than 0).');
            return;
        }
        
        var options = parseOptionsFromText($('#pastedOptions').val());
        if (options.length === 0) {
            alert('Please enter at least one option.');
            return;
        }
        
        // Validate correct answers are selected
        var selectedCorrectAnswers = getSelectedCorrectAnswers();
        if (selectedCorrectAnswers.length === 0) {
            alert('Please select at least one correct answer.');
            return;
        }
        
        // Get image file if selected
        var imageFile = $('#questionImage')[0].files[0];
        
        // Create the question with all the new fields
        createQuestionWithOptions(window.currentQuestionType, options, selectedCorrectAnswers, questionParagraph, questionMark, imageFile);
        
        // Close modal
        hideModal('answerOptionsModal');
        
        // Increment question number
        questionnum++;
        $('#question-index').val(questionnum);
    });
    
    // Close button handlers - Enhanced for better compatibility
    // Handle the X close button
    $(document).on('click', '#answerOptionsModal .btn-close', function(e) {
        e.preventDefault();
        hideModal('answerOptionsModal');
    });
    
    // Handle data-bs-dismiss and data-dismiss attributes
    $(document).on('click', '#answerOptionsModal [data-bs-dismiss="modal"], #answerOptionsModal [data-dismiss="modal"]', function(e) {
        e.preventDefault();
        hideModal('answerOptionsModal');
    });
    
    // Cancel button handler - more specific selector
    $(document).on('click', '#answerOptionsModal .modal-footer .btn-secondary', function(e) {
        e.preventDefault();
        hideModal('answerOptionsModal');
    });
    
    // ESC key handler
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#answerOptionsModal').hasClass('show')) {
            hideModal('answerOptionsModal');
        }
    });
    
    // Additional modal event handlers - clear data when modal starts to show
    $('#answerOptionsModal').on('show.bs.modal', function() {
        // Clear immediately when modal starts to show
        clearModalData();
    });
    
    // Also clear when modal is fully shown as backup
    $('#answerOptionsModal').on('shown.bs.modal', function() {
        // Force clear modal data every time it's opened to ensure clean state
        setTimeout(clearModalData, 100);
    });
}

/**
 * Update the options preview in real-time
 */
function updateOptionsPreview() {
    var options = parseOptionsFromText($('#pastedOptions').val());
    var preview = $('#optionsPreview');
    var questionType = window.currentQuestionType || 'radio';
    
    if (options.length === 0) {
        preview.html('<p class="text-muted">Options will appear here as you type...</p>');
        $('#optionCount').text('0');
        $('#correctAnswerSection').hide();
        return;
    }
    
    var previewHtml = '<div class="options-preview-list">';
    options.forEach(function(option, index) {
        var letter = String.fromCharCode(97 + index); // a, b, c, d...
        var inputType = questionType === 'radio' ? 'radio' : 'checkbox';
        var inputName = questionType === 'radio' ? 'preview-radio' : 'preview-checkbox-' + index;
        
        previewHtml += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="${inputType}" name="${inputName}" id="preview-${index}" disabled>
                <label class="form-check-label" for="preview-${index}">
                    <strong>${letter})</strong> ${option}
                </label>
            </div>
        `;
    });
    previewHtml += '</div>';
    
    preview.html(previewHtml);
    $('#optionCount').text(options.length);
    
    // Update correct answer selection
    updateCorrectAnswerSelection(options, questionType);
}

/**
 * Update the correct answer selection section
 */
function updateCorrectAnswerSelection(options, questionType) {
    var correctAnswerContainer = $('#correctAnswerOptions');
    
    if (options.length === 0) {
        $('#correctAnswerSection').hide();
        return;
    }
    
    $('#correctAnswerSection').show();
    
    var correctAnswerHtml = '<div class="correct-answer-list">';
    options.forEach(function(option, index) {
        var letter = String.fromCharCode(97 + index); // a, b, c, d...
        var inputType = questionType === 'radio' ? 'radio' : 'checkbox';
        var inputName = questionType === 'radio' ? 'correct-answer' : 'correct-answer-' + index;
        
        correctAnswerHtml += `
            <div class="form-check mb-2">
                <input class="form-check-input correct-answer-input" type="${inputType}" name="${inputName}" id="correct-${index}" value="${option}" data-letter="${letter}">
                <label class="form-check-label" for="correct-${index}">
                    <strong>${letter})</strong> ${option}
                </label>
            </div>
        `;
    });
    correctAnswerHtml += '</div>';
    
    correctAnswerContainer.html(correctAnswerHtml);
    
    // Add event listeners to update selected answers display
    $('.correct-answer-input').on('change', function() {
        updateSelectedCorrectAnswers(questionType);
    });
    
    // Clear previous selections
    $('#selectedCorrectAnswers').text('None');
}

/**
 * Update the display of selected correct answers
 */
function updateSelectedCorrectAnswers(questionType) {
    var selectedAnswers = [];
    
    if (questionType === 'radio') {
        var checkedInput = $('.correct-answer-input:checked');
        if (checkedInput.length > 0) {
            var letter = checkedInput.data('letter');
            var value = checkedInput.val();
            selectedAnswers.push(letter + ') ' + value);
        }
    } else {
        $('.correct-answer-input:checked').each(function() {
            var letter = $(this).data('letter');
            var value = $(this).val();
            selectedAnswers.push(letter + ') ' + value);
        });
    }
    
    var displayText = selectedAnswers.length > 0 ? selectedAnswers.join(', ') : 'None';
    $('#selectedCorrectAnswers').text(displayText);
}

/**
 * Parse options from textarea input
 */
function parseOptionsFromText(text) {
    if (!text.trim()) return [];
    
    return text.split('\n')
        .map(option => option.trim())
        .filter(option => option.length > 0);
}

/**
 * Get selected correct answers
 */
function getSelectedCorrectAnswers() {
    var selectedAnswers = [];
    $('.correct-answer-input:checked').each(function() {
        selectedAnswers.push($(this).val());
    });
    return selectedAnswers;
}

/**
 * Create a subjective question with specified parameters
 */
function createSubjectiveQuestion(questionParagraph, questionMark, answerRows, imageFile) {
    var questionNum = window.currentQuestionNum;
    var index = window.currentButtonIndex;
    
    // Create header
    var field = {
        type: 'header',
        className: 'mt-4',
        label: 'Question ' + questionNum
    };
    formBuilder.actions.addField(field, index);
    
    // Create file upload (only if image was selected)
    if (imageFile) {
        field = {
            type: 'file',
            className: 'form-control',
            label: 'Upload Image',
            name: 'uploaded_image[]',
            description: 'Drag and drop or click to select an image file.',
            attrs: {
                'data-subtype': 'file-' + questionNum
            }
        };
        formBuilder.actions.addField(field, index);
        
        // Store the image data URL and create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            setTimeout(function() {
                const fileInputs = $('#fb-editor input[type="file"]');
                const newFileInput = fileInputs.last()[0];
                
                if (newFileInput) {
                    const fileIndex = fileInputs.length - 1;
                    imageDataUrls[fileIndex] = e.target.result;
                    
                    try {
                        const dt = new DataTransfer();
                        dt.items.add(imageFile);
                        newFileInput.files = dt.files;
                    } catch (error) {
                        console.log('DataTransfer not supported, using alternative method');
                    }
                    
                    const previewImage = $('<img>').attr('src', e.target.result).addClass('uploaded-image-preview');
                    $(newFileInput).siblings('.uploaded-image-preview').remove();
                    $(newFileInput).after(previewImage);
                    
                    $(newFileInput).data('modalFile', imageFile);
                    $(newFileInput).data('modalImageDataUrl', e.target.result);
                    
                    const fileNameDisplay = $('<div class="selected-file-name mt-1"><small class="text-success"><i class="fa fa-check-circle"></i> ' + imageFile.name + '</small></div>');
                    $(newFileInput).siblings('.selected-file-name').remove();
                    $(newFileInput).after(fileNameDisplay);
                }
            }, 100);
        };
        reader.readAsDataURL(imageFile);
    }
    
    // Create question paragraph with actual content
    field = {
        type: 'paragraph',
        className: '',
        label: questionParagraph
    };
    formBuilder.actions.addField(field, index);
    
    // Create answer textarea with custom rows
    field = {
        type: 'textarea',
        rows: answerRows,
        className: 'form-control',
        placeholder: 'Your Answer',
        label: '<label class="mt-2 text-primary"><strong>Your Answer</strong></label>',
        name: 'subjective-text' + questionNum,
    };
    formBuilder.actions.addField(field, index);
    
    // Create marks checkbox for full marks
    field = {
        type: 'checkbox-group',
        className: 'collected-marks pull-right chk-col-danger',
        label: '',  
        values: [
            {
                "label": questionMark + " mark",
                "value": questionMark.toString(),
                "selected": false
            }
        ]
    };
    formBuilder.actions.addField(field, index);

    // Create number input for partial marks
    field = {
        type: 'number',
        className: 'inputmark form-control',
        placeholder: 'Mark',
        value: '0',
        min: '0',
        max: questionMark.toString(),
        label: '',
    };
    formBuilder.actions.addField(field, index);
    
    // Create comment field
    field = {
        type: 'text',
        className: 'feedback-text form-control',
        placeholder: 'Comment',
        label: '',
    };
    formBuilder.actions.addField(field, index);
}

/**
 * Create a question with the specified options and additional fields
 */
function createQuestionWithOptions(questionType, customOptions, correctAnswers, questionParagraph, questionMark, imageFile) {
    var questionNum = window.currentQuestionNum;
    var index = window.currentButtonIndex;
    
    // Create header
    var field = {
        type: 'header',
        className: 'mt-4',
        label: 'Question ' + questionNum
    };
    formBuilder.actions.addField(field, index);
    
    // Create file upload (only if image was selected)
    if (imageFile) {
        field = {
            type: 'file',
            className: 'form-control',
            label: 'Upload Image',
            name: 'uploaded_image[]',
            description: 'Drag and drop or click to select an image file.',
            attrs: {
                'data-subtype': 'file-' + questionNum
            }
        };
        formBuilder.actions.addField(field, index);
        
        // Store the image data URL and create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            // Wait a bit for the DOM to update, then find the newly created file input
            setTimeout(function() {
                const fileInputs = $('#fb-editor input[type="file"]');
                const newFileInput = fileInputs.last()[0];
                
                if (newFileInput) {
                    // Get the current index for this file input
                    const fileIndex = fileInputs.length - 1;
                    
                    // Store the image data URL
                    imageDataUrls[fileIndex] = e.target.result;
                    
                    // Try to set the file (browser compatibility may vary)
                    try {
                        const dt = new DataTransfer();
                        dt.items.add(imageFile);
                        newFileInput.files = dt.files;
                    } catch (error) {
                        console.log('DataTransfer not supported, using alternative method');
                    }
                    
                    // Create and show image preview immediately
                    const previewImage = $('<img>').attr('src', e.target.result).addClass('uploaded-image-preview');
                    $(newFileInput).siblings('.uploaded-image-preview').remove();
                    $(newFileInput).after(previewImage);
                    
                    // Store a reference to the original file for later use
                    $(newFileInput).data('modalFile', imageFile);
                    $(newFileInput).data('modalImageDataUrl', e.target.result);
                    
                    // Update the file input appearance to show file is selected
                    const fileNameDisplay = $('<div class="selected-file-name mt-1"><small class="text-success"><i class="fa fa-check-circle"></i> ' + imageFile.name + '</small></div>');
                    $(newFileInput).siblings('.selected-file-name').remove();
                    $(newFileInput).after(fileNameDisplay);
                }
            }, 100);
        };
        reader.readAsDataURL(imageFile);
    }
    
    // Create question paragraph with actual content
    field = {
        type: 'paragraph',
        className: '',
        label: questionParagraph
    };
    formBuilder.actions.addField(field, index);
    
    // Create answer options based on type
    var values = customOptions.map(function(option, optionIndex) {
        var letter = String.fromCharCode(97 + optionIndex); // a, b, c, d...
        return {
            "label": letter + ") " + option,
            "value": option,
            "selected": false
        };
    });
    
    if (questionType === 'radio') {
        field = {
            type: 'radio-group',
            className: 'with-gap radio-col-primary',
            label: '<label class="mt-2 text-primary"><strong>Your Answer</strong></label>',
            name: 'radio-question' + questionNum,
            values: values
        };
    } else if (questionType === 'checkbox') {
        field = {
            type: 'checkbox-group',
            className: 'filled-in chk-col-warning',
            label: '<label class="mt-2 text-primary"><strong>Your Answer</strong></label>',
            name: 'checkbox-question' + questionNum,
            values: values
        };
    }
    
    formBuilder.actions.addField(field, index);
    
    // Create correct answer field with selected answers
    var correctAnswerText = '';
    if (questionType === 'radio') {
        // For radio questions, show the single correct answer
        correctAnswerText = correctAnswers[0];
    } else if (questionType === 'checkbox') {
        // For checkbox questions, show all correct answers comma-separated
        correctAnswerText = correctAnswers.join(',');
    }
    
    field = {
        type: 'paragraph',
        className: 'correct-answer',
        label: correctAnswerText
    };
    formBuilder.actions.addField(field, index);
    
    // Create marks checkbox with custom mark value
    field = {
        type: 'checkbox-group',
        className: 'collected-marks pull-right chk-col-danger',
        label: '',  
        values: [
            {
                "label": questionMark + " mark",
                "value": questionMark.toString(),
                "selected": false
            }
        ]
    };
    formBuilder.actions.addField(field, index);
    
    // Create comment field
    field = {
        type: 'text',
        className: 'feedback-text form-control',
        placeholder: 'Comment',
        label: '',
    };
    formBuilder.actions.addField(field, index);
}

    /* On Clicks */
    $('.edit-form', $formContainer).click(function() {
        $fbEditor.toggle();
        $formContainer.toggle();

    });

    document.getElementById('publish-quiz').addEventListener('click', function() {
    
        Swal.fire({
			title: "Are you sure?",
			text: "Student will be able to start the quiz and you are not allow to edit anymore",
			showCancelButton: true,
			confirmButtonText: "Confirm"
		}).then(function(res){
			if (res.isConfirmed){
                saveForm(2);
			}
		});
  
    }, false);

    document.getElementById('save-quiz').addEventListener('click', function() {
        saveForm();
    }, false);
    
    $(document).on('click', '.edit-form', function(e){
        
        $('#fb-render').empty();
        $('#form-div').show();
        $('.addFieldWrap').show();
        
        intervalId = window.setInterval(function(){
            total_correct_mark = 0;
            renderMark();
        }, 500);
    });

    /* On Keyups */
    $(document).on('keyup', '#question-index', function(e){
        questionnum  = $('#question-index').val();
    });

    function saveForm(status = 1){

        if($('input[name="group[]"]').is(':checked') && $('input[name="chapter[]"]').is(':checked'))
        {
            
            var total = Number($("#total-marks").val()).toFixed(2);

            var collect = Number($("#collectmark").val()).toFixed(2);

            if(total == collect)
            {

                // Create a FormData object
                var formData = new FormData();

                // Append the form fields
                formData.append('class', selected_class);
                formData.append('quiz', selected_quiz);
                formData.append('reuse', reuse);
                formData.append('title', $("#quiz-title").val());
                formData.append('duration', $("#quiz-duration").val());
                formData.append('questionindex', $("#question-index").val());
                formData.append('from', $("#from").val());
                formData.append('to', $("#to").val());
                formData.append('marks', $("#total-marks").val());
                formData.append('group', JSON.stringify($('input[name="group[]"]:checked').map(function(){ return this.value; }).get()));
                formData.append('chapter', JSON.stringify($('input[name="chapter[]"]:checked').map(function(){ return this.value; }).get()));
                formData.append('status', status);
                formData.append('data', JSON.stringify({formData: $fbEditor.formRender("userData") }));

                var fileIndex = 0;
                $('#fb-editor').find('input[type="file"]').each(function(index, input) {
                    if (imageDataUrls[index]) {
                        if (input && input.files && input.files[0]) {
                            // Use the actual file from the input
                            formData.append('uploaded_image[' + fileIndex + ']', input.files[0]);
                            console.log('index:', index, 'input:', input.files[0]);
                            fileIndex++;
                        } else if ($(input).data('modalFile')) {
                            // Use the stored file from modal if input doesn't have files
                            formData.append('uploaded_image[' + fileIndex + ']', $(input).data('modalFile'));
                            console.log('index:', index, 'modalFile:', $(input).data('modalFile'));
                            fileIndex++;
                        }
                    }
                });


                //console.log(JSON.stringify({formData: $fbEditor.formRender("userData") }));

                // Perform the AJAX request
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ url('user/quiz/insert') }}",
                    type: 'POST',
                    data: formData,
                    processData: false, // Important: Do not process data
                    contentType: false, // Important: Do not set content type
                    error: function(err) {
                        console.log(err);
                    },
                    success: function(res) {
                        location.href= "/user/quiz/{{ Session::get('subjects')->id }}";
                    }
                });


            }else{

                alert('Please make sure that collected mark and input mark are the same!');

            }

        }else{

            alert('Please fill in the group and sub-chapter checkbox!');

        }
    }
});

$('.btn.btn-primary.save-template.save-template').html("Done");




function renderForm(formdata){
    jQuery(function($) {
        const fbRender = document.getElementById("fb-render");
        const originalFormData = formdata;

        var formRenderOptions = {
            datatype: 'json',
            formData: JSON.stringify(originalFormData)
        };

        $(fbRender).formRender(formRenderOptions );
    });
}

var imageDataUrls = [];

$(document).ready(function() {
  $('body').on('change', 'input[type="file"]', function() {
    var input = this;
    var index = $('#fb-editor input[type="file"]').index(input);

    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        imageDataUrls[index] = e.target.result;

        $(input).parent().find('.uploaded-image-preview').remove();
        $(input).siblings('.uploaded-image-preview').remove();
        $(input).siblings('.selected-file-name').remove();
        var previewImage = $('<img>').attr('src', e.target.result).addClass('uploaded-image-preview');
        $(input).after(previewImage);
        
        // Show filename
        const fileNameDisplay = $('<div class="selected-file-name mt-1"><small class="text-success"><i class="fa fa-check-circle"></i> ' + input.files[0].name + '</small></div>');
        $(input).after(fileNameDisplay);
        
        // Clear any stored modal file data since user selected new file
        $(input).removeData('modalFile');
        $(input).removeData('modalImageDataUrl');
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      // If no file selected, remove preview and filename display
      $(input).parent().find('.uploaded-image-preview').remove();
      $(input).siblings('.uploaded-image-preview').remove();
      $(input).siblings('.selected-file-name').remove();
      if (index >= 0) {
        delete imageDataUrls[index];
      }
    }
  });
});


</script>




@stop
