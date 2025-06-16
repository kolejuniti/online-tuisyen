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
                    <h3 class="page-title mb-1">{{ empty($data['test']->title) ? "Create test" : $data['test']->title }}</h3>
                    <div class="d-inline-block align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item">Course</li>
                                <li class="breadcrumb-item">Assessment</li>
                                @if(empty($data['test']->title))
                                    <li class="breadcrumb-item active" aria-current="page">Create test</li>
                                @else
                                    <li class="breadcrumb-item active" aria-current="page">test</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $data['test']->title }}</li>
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
                                        <label for="test-title" class="form-label "><strong>test Title</strong></label>
                                        <input type="text" oninput="this.value = this.value.toUpperCase()"  id="test-title" class="form-control"
                                            value="{{ empty($data['test']->title) ? "" : $data['test']->title }}"  required>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <label for="from" class="form-label "><strong>test Duration (From)</strong></label>
                                        <input type="datetime-local" id="from" class="form-control"
                                            value={{ empty($data['test']->date_from) ? '' : date('Y-m-d\TH:i:s', strtotime($data['test']->date_from)) }} required>
                                    </div>
                                    <div class="col-md-2 mb-4" id="time-to" hidden>
                                        <label for="to" class="form-label "><strong>test Duration (To)</strong></label>
                                        <input type="datetime-local" oninput="this.value = this.value.toUpperCase()"  id="to" class="form-control"
                                            value={{ empty($data['test']->date_to) ? '' : date('Y-m-d\TH:i:s', strtotime($data['test']->date_to))  }} required>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <label for="test-duration" class="form-label "><strong>test Duration (minutes)</strong></label>
                                        <input readonly type="number" oninput="this.value = this.value.toUpperCase()"  id="test-duration" class="form-control"
                                            value="">
                                    </div>
                                    <div class="col-md-2 mb-4" hidden>
                                        <label for="question-index" class="form-label "><strong>Question Index</strong></label>
                                        <input id="question-index" type="number" class="form-control"
                                            value={{ empty($data['test']->questionindex) ? 1 : $data['test']->questionindex }}>
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
                                            value="{{ empty($data['test']->total_mark) ? '' : $data['test']->total_mark }}" required>
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
                                    
                                    <!-- AI Generate test Card -->
                                    <div class="col-md-12">
                                        <div class="card ai-generate-card">
                                            <div class="card-header">
                                                <h5><i class="fa fa-magic me-2"></i> Generate test from Document</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Tips Alert Section -->
                                                <div class="alert alert-info mb-4" role="alert">
                                                    <h6 class="alert-heading"><i class="fa fa-info-circle me-2"></i>Tips for test Generation:</h6>
                                                    <ul class="mb-0 ps-3">
                                                        <li>For best results, keep the total number of questions under 20.</li>
                                                        <li>Larger documents may require more processing time.</li>
                                                        <li>If you encounter an error, please try again or reduce the number of requested questions.</li>
                                                        <li>Make sure your PDF document is text-based (not scanned) for optimal results.</li>
                                                    </ul>
                                                </div>
                                                
                                                <form id="aitestForm" enctype="multipart/form-data">
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
                                                            <button type="button" id="generatetestAI" class="btn btn-primary ai-generate-btn">
                                                                <i class="fa fa-robot me-2"></i> AI Generate test
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
                                            initializeAItestGenerator();
                                            initializeLanguageSlider();
                                        });
                                    </script>

                                </div>
                                    
                                    
                                <script>
                                /**
                                 * AI test Generator
                                 * 
                                 * This script handles the AI-powered test generation functionality.
                                 * It processes PDF documents and creates questions of different types
                                 * based on the document content.
                                 */

                                // Wait for DOM to be fully loaded before initializing
                                document.addEventListener('DOMContentLoaded', function() {
                                    initializeAItestGenerator();
                                });

                                /**
                                * Initializes the AI test Generator functionality
                                */
                                function initializeAItestGenerator() {
                                    // Get reference to the generate button
                                    const generateButton = document.getElementById('generatetestAI');
                                    
                                    // Add event listener to the generate button
                                    if (generateButton) {
                                        generateButton.addEventListener('click', handleGeneratetest);
                                        
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
                                * Handles the generate test button click
                                */
                                function handleGeneratetest() {
                                    // Create FormData from the form
                                    const formData = new FormData(document.getElementById('aitestForm'));
                                    
                                    // Validate inputs before proceeding
                                    if (!validateAItestForm()) {
                                        return;
                                    }
                                    
                                    // Show loading state
                                    Swal.fire({
                                        title: "Generating test",
                                        html: "Please wait while our AI analyzes your document and creates questions...",
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                    
                                    // Send the request to the server
                                    fetch(`/user/test/${getCourseId()}/generate-ai-test`, {
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
                                            processtestQuestions(data);
                                        } else {
                                            showErrorMessage(data.message || 'Failed to generate test.');
                                        }
                                    })
                                    .catch(error => {
                                        // Close loading indicator
                                        Swal.close();
                                        
                                        // Show error message
                                        console.error('Error:', error);
                                        showErrorMessage('An error occurred while generating the test. Please check the document and try again.');
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
                                * Validates the AI test form
                                * @returns {boolean} Whether the form is valid
                                */
                                function validateAItestForm() {
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
                                        text: "test questions have been generated successfully.",
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
                                * Processes the test questions returned from the server
                                * @param {Object} data The response data from the server
                                */
                                function processtestQuestions(data) {
    try {
        // Parse the JSON data
        let testData;
        if (typeof data.formBuilderJSON === 'string') {
            testData = JSON.parse(data.formBuilderJSON);
        } else {
            testData = data.formBuilderJSON;
        }
        
        // If no questions were received, create empty questions array
        if (!testData || !testData.test || !testData.test.questions || !Array.isArray(testData.test.questions)) {
            console.error('Invalid test data structure received.');
            showErrorMessage('The AI generated an invalid test structure. Please try again.');
            return;
        }
        
        // Extract questions array
        const allQuestions = testData.test.questions;
        
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
        console.error('Error processing test data:', e);
        showErrorMessage('Error processing the generated test data. Please try again.');
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
                                        <button id="publish-test"  class="btn btn-info pull-right m-1"><i class="mdi mdi-publish"></i> Save & Publish</button>
                                        <button id="save-test"  class="btn btn-primary pull-right m-1"><i class="mdi mdi-content-save"></i> Save</button>
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
var selected_from = '';
var selected_to = '';
var total_correct_mark = 0;

$(document).ready(function(){
    if('{{ $data['testid'] }}' != '')
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

    $('#test-duration').val(minutes);

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
    if('{{ $data['testid'] }}' != '')
    {
        selected_folder = $('#folder').val();

        getChapters(selected_folder);
    }
});

function getChapters(folder)
{

  return $.ajax({
        headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
        url      : "{{ url('user/test/getChapters') }}",
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
var selected_test  = "{{ empty($data['testid']) ? '' : $data['testid'] }}";
var reuse  = "{{ empty($data['reuse']) ? '' : $data['reuse'] }}";
var test            = {!! empty($data['test']) ? "''" : json_encode($data['test']) !!};
var test_status  = {!! empty($data['teststatus']) ? "''" : $data['teststatus'] !!};
var testFormData    = [];
var i = 0;
var imageDataUrls = {};
var currentImageDataUrl;

var formRenderInstance;

jQuery(function($) {

    var $fbEditor = $(document.getElementById('fb-editor'));
    $formContainer = $(document.getElementById('fb-rendered-form'));

    if(Object.keys(test).length > 0){
        testFormData = test.content;
        testFormData = JSON.parse(testFormData).formData;
    }

    if(reuse == '')
    {
        if(test_status == 2){

            Swal.fire({
                title: "test is already started!",
                text: "You are not allowed to edit anymore once published",
                confirmButtonText: "Ok"
            }).then(function(res){
                renderForm(testFormData);
                $('#fb-rendered-form').show();
                $('.header-setting *').attr('disabled', 'disabled');
                $('.hide-published-element').hide();
            });

        }else{

            
            fbOptions = {
                formData: testFormData,
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
                formData: testFormData,
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
        // Use the current value of questionnum for the question number
        var field = {
            type: 'header',
            className: 'mt-4',
            label: this.dataset.label + ' ' + questionnum
        };
        var index = this.dataset.index ? Number(this.dataset.index) : undefined;
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'file',
            className: 'form-control',
            label: 'Upload Image',
            name: 'uploaded_image[]',
            description: 'Drag and drop or click to select an image file.',
            attrs: {
                'data-subtype': 'file-' + questionnum
            }
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'paragraph',
            className: '',
            label: 'Sample of the question paragraph...'
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'radio-group',
            className: 'with-gap radio-col-primary',
            label: '<label class="mt-2 text-primary"><strong>Your Answer</strong></label>',
            name: 'radio-question' + questionnum,
            values: [
                {
                    "label": "a) ",
                    "value": "a",
                    "selected": false
                },
                {
                    "label": "b)",
                    "value": "b",
                    "selected": false
                },
                {
                    "label": "c)",
                    "value": "c",
                    "selected": false
                },
                {
                    "label": "d)",
                    "value": "d",
                    "selected": false
                },
            ]
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'paragraph',
            className: 'correct-answer',
            label: 'a'
        };

        formBuilder.actions.addField(field, index);

        field = {
            type: 'checkbox-group',
            className: 'collected-marks pull-right chk-col-danger',
            label: '',  
            values: [
                {
                    "label": "1 mark",
                    "value": "1",
                    "selected": false
                }
            ]
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'text',
            className: 'feedback-text form-control',
            placeholder: 'Comment',
            label: '',
        };
        
        formBuilder.actions.addField(field, index);
        
        // Only increment questionnum after adding the question
        questionnum++;
        $('#question-index').val(questionnum);
    };
}

var buttons2 = document.getElementsByClassName('appendfield2');
for (let j = 0; j < buttons2.length; j++) {
    buttons2[j].onclick = function() {
        var field = {
            type: 'header',
            className: 'mt-4',
            label: this.dataset.label + ' ' + questionnum
        };
        var index = this.dataset.index ? Number(this.dataset.index) : undefined;

        formBuilder.actions.addField(field, index);

        field = {
            type: 'file',
            className: 'form-control',
            label: 'Upload Image',
            name: 'uploaded_image[]',
            description: 'Drag and drop or click to select an image file.',
            attrs: {
                'data-subtype': 'file-' + questionnum
            }
        };

        formBuilder.actions.addField(field, index);

        field = {
            type: 'paragraph',
            className: '',
            label: 'Sample of the question paragraph...'
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'checkbox-group',
            className: 'filled-in chk-col-warning',
            label: '<label class="mt-2 text-primary"><strong>Your Answer</strong></label>',
            name: 'checkbox-question' + questionnum,
            values: [
                {
                    "label": "a)",
                    "value": "a",
                    "selected": false
                },
                {
                    "label": "b)",
                    "value": "b",
                    "selected": false
                },
                {
                    "label": "c)",
                    "value": "c",
                    "selected": false
                },
                {
                    "label": "d)",
                    "value": "d",
                    "selected": false
                },
            ]
        };

        formBuilder.actions.addField(field, index);

        field = {
            type: 'paragraph',
            className: 'correct-answer',
            label: 'a'
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'checkbox-group',
            className: 'collected-marks pull-right chk-col-danger',
            label: '',  
            values: [
                {
                    "label": "1 mark",
                    "value": "1",
                    "selected": false
                }
            ]
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'text',
            className: 'feedback-text form-control',
            placeholder: 'Comment',
            label: '',
        };
        
        formBuilder.actions.addField(field, index);
        
        // Increment after adding
        questionnum++;
        $('#question-index').val(questionnum);
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
        var field = {
            type: 'header',
            className: 'mt-4',
            label: this.dataset.label + ' ' + questionnum
        };
        var index = this.dataset.index ? Number(this.dataset.index) : undefined;

        formBuilder.actions.addField(field, index);

        field = {
            type: 'file',
            className: 'form-control',
            label: 'Upload Image',
            name: 'uploaded_image[]',
            description: 'Drag and drop or click to select an image file.',
            attrs: {
                'data-subtype': 'file-' + questionnum
            }
        };

        formBuilder.actions.addField(field, index);

        field = {
            type: 'paragraph',
            className: '',
            label: 'Sample of the question paragraph...'
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'textarea',
            rows: 10,
            className: 'form-control',
            placeholder: 'Your Answer',
            label: '',
            name: 'subjective-text' + questionnum,
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'checkbox-group',
            className: 'collected-marks pull-right chk-col-danger',
            label: '',  
            values: [
                {
                    "label": "1 mark",
                    "value": "1",
                    "selected": false
                }
            ]
        };

        formBuilder.actions.addField(field, index);

        field = {
            type: 'number',
            className: 'inputmark form-control',
            placeholder: 'Mark',
            value: '0',
            min: '0',
            label: '',
        };
        
        formBuilder.actions.addField(field, index);

        field = {
            type: 'text',
            className: 'feedback-text form-control',
            placeholder: 'Comment',
            label: '',
        };
        
        formBuilder.actions.addField(field, index);
        
        // Increment after adding
        questionnum++;
        $('#question-index').val(questionnum);
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
});

    /* On Clicks */
    $('.edit-form', $formContainer).click(function() {
        $fbEditor.toggle();
        $formContainer.toggle();

    });

    document.getElementById('publish-test').addEventListener('click', function() {
    
        Swal.fire({
			title: "Are you sure?",
			text: "Student will be able to start the test and you are not allow to edit anymore",
			showCancelButton: true,
			confirmButtonText: "Confirm"
		}).then(function(res){
			if (res.isConfirmed){
                saveForm(2);
			}
		});
  
    }, false);

    document.getElementById('save-test').addEventListener('click', function() {
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
                formData.append('test', selected_test);
                formData.append('reuse', reuse);
                formData.append('title', $("#test-title").val());
                formData.append('duration', $("#test-duration").val());
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
                        formData.append('uploaded_image[' + fileIndex + ']', input.files[0]);
                        console.log('index:', index, 'input:', input.files[0]);
                        fileIndex++;
                        }
                    }
                });


                //console.log(JSON.stringify({formData: $fbEditor.formRender("userData") }));

                // Perform the AJAX request
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ url('user/test/insert') }}",
                    type: 'POST',
                    data: formData,
                    processData: false, // Important: Do not process data
                    contentType: false, // Important: Do not set content type
                    error: function(err) {
                        console.log(err);
                    },
                    success: function(res) {
                        location.href= "/user/test/{{ Session::get('subjects')->id }}";
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
    var index = $('.form-builder input[type="file"]').index(input);

    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        imageDataUrls[index] = e.target.result;

        $(input).parent().find('.uploaded-image-preview').remove();
        var previewImage = $('<img>').attr('src', e.target.result).addClass('uploaded-image-preview');
        $(input).after(previewImage);
      };
      reader.readAsDataURL(input.files[0]);
    }
  });
});


</script>




@stop
