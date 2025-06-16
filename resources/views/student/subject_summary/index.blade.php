@extends('layouts.student.student')

@section('title', 'Subject Summary')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header -->
        <div class="page-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title mb-1">Subject Summary</h3>
                    <div class="d-inline-block align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('student.subjects.index') }}">Subjects</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ Session::get('subjects')->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Subject Overview -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Subject Overview</h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="d-flex align-items-center mb-30">
                                        <div class="me-15">
                                            @if(Session::get('subjects')->image)
                                                <img src="{{ asset('storage/'.Session::get('subjects')->image) }}" class="avatar avatar-xxl rounded10" alt="{{ Session::get('subjects')->name }}">
                                            @else
                                                <div class="avatar avatar-xxl bg-primary-light rounded10">
                                                    <span class="avatar-title fs-24">{{ substr(Session::get('subjects')->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="mb-0">{{ Session::get('subjects')->name }}</h4>
                                            <p class="text-mute mb-0">
                                                <span class="badge badge-sm badge-dot badge-primary me-10"></span>
                                                <span>Active</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8 col-12">
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="box bg-primary-light mb-md-0 mb-30">
                                                <div class="box-body">
                                                    <div class="text-center">
                                                        <i data-feather="users" class="text-primary fs-30 mb-10"></i>
                                                        <h3 class="fw-600 mb-0">24</h3>
                                                        <p class="mb-0 text-mute">Students</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="box bg-info-light mb-md-0 mb-30">
                                                <div class="box-body">
                                                    <div class="text-center">
                                                        <i data-feather="book" class="text-info fs-30 mb-10"></i>
                                                        <h3 class="fw-600 mb-0">18</h3>
                                                        <p class="mb-0 text-mute">Lessons</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="box bg-success-light mb-md-0">
                                                <div class="box-body">
                                                    <div class="text-center">
                                                        <i data-feather="clipboard" class="text-success fs-30 mb-10"></i>
                                                        <h3 class="fw-600 mb-0">12</h3>
                                                        <p class="mb-0 text-mute">Assignments</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="box bg-warning-light mb-0">
                                                <div class="box-body">
                                                    <div class="text-center">
                                                        <i data-feather="award" class="text-warning fs-30 mb-10"></i>
                                                        <h3 class="fw-600 mb-0">85%</h3>
                                                        <p class="mb-0 text-mute">Completion</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tabs for different sections -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#students" role="tab">
                                        <i data-feather="users" class="me-5"></i> Students
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#lessons" role="tab">
                                        <i data-feather="book" class="me-5"></i> Lessons
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#assignments" role="tab">
                                        <i data-feather="clipboard" class="me-5"></i> Assignments
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#schedule" role="tab">
                                        <i data-feather="calendar" class="me-5"></i> Schedule
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#resources" role="tab">
                                        <i data-feather="folder" class="me-5"></i> Resources
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- Students Tab -->
                                <div class="tab-pane active" id="students" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Students Enrolled</h4>
                                            <div class="d-flex">
                                                <div class="lookup lookup-circle lookup-right me-15">
                                                    <input type="text" name="s" placeholder="Search Students">
                                                </div>
                                                <button type="button" class="btn btn-primary-light">
                                                    <i data-feather="filter" class="me-5"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px">#</th>
                                                        <th>Student Name</th>
                                                        <th>Progress</th>
                                                        <th>Assignments</th>
                                                        <th>Attendance</th>
                                                        <th style="width: 100px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Sample student data - replace with real data -->
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('assets/images/avatar/avatar-1.png') }}" class="avatar avatar-sm me-10" alt="">
                                                                <div>
                                                                    <h5 class="mb-0 fs-16">John Smith</h5>
                                                                    <p class="mb-0 text-muted fs-12">ID: ST12345</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">85%</span>
                                                            </div>
                                                        </td>
                                                        <td>16/18 completed</td>
                                                        <td>92%</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Message">
                                                                    <i data-feather="message-circle"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('assets/images/avatar/avatar-2.png') }}" class="avatar avatar-sm me-10" alt="">
                                                                <div>
                                                                    <h5 class="mb-0 fs-16">Emily Johnson</h5>
                                                                    <p class="mb-0 text-muted fs-12">ID: ST12346</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">92%</span>
                                                            </div>
                                                        </td>
                                                        <td>18/18 completed</td>
                                                        <td>98%</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Message">
                                                                    <i data-feather="message-circle"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('assets/images/avatar/avatar-3.png') }}" class="avatar avatar-sm me-10" alt="">
                                                                <div>
                                                                    <h5 class="mb-0 fs-16">Michael Brown</h5>
                                                                    <p class="mb-0 text-muted fs-12">ID: ST12347</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">65%</span>
                                                            </div>
                                                        </td>
                                                        <td>12/18 completed</td>
                                                        <td>78%</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Message">
                                                                    <i data-feather="message-circle"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Lessons Tab -->
                                <div class="tab-pane" id="lessons" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Lesson Plan</h4>
                                            <button type="button" class="btn btn-primary">
                                                <i data-feather="plus" class="me-5"></i> Add Lesson
                                            </button>
                                        </div>
                                        
                                        <div class="box bg-light mb-20">
                                            <div class="box-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-15 bg-info rounded-circle h-50 w-50 l-h-50 text-center">
                                                            <span class="text-white fs-24">1</span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">Introduction to {{ Session::get('subjects')->name }}</h5>
                                                            <p class="mb-0 text-muted">Basic concepts and fundamentals</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-success-light">Completed</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="box bg-light mb-20">
                                            <div class="box-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-15 bg-info rounded-circle h-50 w-50 l-h-50 text-center">
                                                            <span class="text-white fs-24">2</span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">Core Principles</h5>
                                                            <p class="mb-0 text-muted">Understanding the key concepts</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-success-light">Completed</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="box bg-light mb-20">
                                            <div class="box-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-15 bg-info rounded-circle h-50 w-50 l-h-50 text-center">
                                                            <span class="text-white fs-24">3</span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">Advanced Techniques</h5>
                                                            <p class="mb-0 text-muted">Exploring complex concepts</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-primary-light">In Progress</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="box bg-light mb-20">
                                            <div class="box-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-15 bg-info rounded-circle h-50 w-50 l-h-50 text-center">
                                                            <span class="text-white fs-24">4</span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">Practical Applications</h5>
                                                            <p class="mb-0 text-muted">Real-world implementation</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-warning-light">Upcoming</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Assignments Tab -->
                                <div class="tab-pane" id="assignments" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Assignments</h4>
                                            <button type="button" class="btn btn-primary">
                                                <i data-feather="plus" class="me-5"></i> Add Assignment
                                            </button>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Submitted</th>
                                                        <th>Average Score</th>
                                                        <th style="width: 100px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Sample assignment data - replace with real data -->
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">Assignment 1: Fundamentals</h5>
                                                            <p class="mb-0 text-muted fs-12">Basic concepts review</p>
                                                        </td>
                                                        <td>{{ now()->subDays(10)->format('d M Y') }}</td>
                                                        <td><span class="badge badge-success">Completed</span></td>
                                                        <td>24/24 students</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 88%" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">88%</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Download">
                                                                    <i data-feather="download"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">Assignment 2: Core Principles</h5>
                                                            <p class="mb-0 text-muted fs-12">Application of key concepts</p>
                                                        </td>
                                                        <td>{{ now()->subDays(3)->format('d M Y') }}</td>
                                                        <td><span class="badge badge-primary">In Progress</span></td>
                                                        <td>18/24 students</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">75%</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Download">
                                                                    <i data-feather="download"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">Assignment 3: Advanced Topics</h5>
                                                            <p class="mb-0 text-muted fs-12">Complex problem solving</p>
                                                        </td>
                                                        <td>{{ now()->addDays(7)->format('d M Y') }}</td>
                                                        <td><span class="badge badge-warning">Upcoming</span></td>
                                                        <td>0/24 students</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">0%</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Download">
                                                                    <i data-feather="download"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Schedule Tab -->
                                <div class="tab-pane" id="schedule" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Class Schedule</h4>
                                            <button type="button" class="btn btn-primary">
                                                <i data-feather="plus" class="me-5"></i> Add Class
                                            </button>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th>Time</th>
                                                        <th>Monday</th>
                                                        <th>Tuesday</th>
                                                        <th>Wednesday</th>
                                                        <th>Thursday</th>
                                                        <th>Friday</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="bg-light fw-bold">09:00 - 10:30</td>
                                                        <td class="bg-primary-light">
                                                            <strong>{{ Session::get('subjects')->name }}</strong><br>
                                                            Room 101
                                                        </td>
                                                        <td></td>
                                                        <td class="bg-primary-light">
                                                            <strong>{{ Session::get('subjects')->name }}</strong><br>
                                                            Room 101
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold">11:00 - 12:30</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="bg-primary-light">
                                                            <strong>{{ Session::get('subjects')->name }}</strong><br>
                                                            Room 105
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-light fw-bold">13:30 - 15:00</td>
                                                        <td></td>
                                                        <td class="bg-primary-light">
                                                            <strong>{{ Session::get('subjects')->name }}</strong><br>
                                                            Lab 2B
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="bg-primary-light">
                                                            <strong>{{ Session::get('subjects')->name }}</strong><br>
                                                            Room 101
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Resources Tab -->
                                <div class="tab-pane" id="resources" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Teaching Resources</h4>
                                            <button type="button" class="btn btn-primary">
                                                <i data-feather="upload" class="me-5"></i> Upload Resource
                                            </button>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xl-3 col-md-4 col-6">
                                                <div class="box">
                                                    <div class="box-body text-center">
                                                        <div class="mb-10 mt-10">
                                                            <i data-feather="file-text" class="fs-40 text-primary"></i>
                                                        </div>
                                                        <h5 class="mb-0">Course Syllabus</h5>
                                                        <p class="text-muted mb-10 fs-12">PDF Document • 2.4 MB</p>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="#" class="btn btn-sm btn-primary-light me-5">
                                                                <i data-feather="download" class="me-5"></i> Download
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-info-light">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-3 col-md-4 col-6">
                                                <div class="box">
                                                    <div class="box-body text-center">
                                                        <div class="mb-10 mt-10">
                                                            <i data-feather="file-text" class="fs-40 text-danger"></i>
                                                        </div>
                                                        <h5 class="mb-0">Lecture Notes</h5>
                                                        <p class="text-muted mb-10 fs-12">PDF Document • 1.8 MB</p>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="#" class="btn btn-sm btn-primary-light me-5">
                                                                <i data-feather="download" class="me-5"></i> Download
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-info-light">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-3 col-md-4 col-6">
                                                <div class="box">
                                                    <div class="box-body text-center">
                                                        <div class="mb-10 mt-10">
                                                            <i data-feather="file-text" class="fs-40 text-success"></i>
                                                        </div>
                                                        <h5 class="mb-0">Assignment Guidelines</h5>
                                                        <p class="text-muted mb-10 fs-12">Word Document • 856 KB</p>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="#" class="btn btn-sm btn-primary-light me-5">
                                                                <i data-feather="download" class="me-5"></i> Download
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-info-light">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-3 col-md-4 col-6">
                                                <div class="box">
                                                    <div class="box-body text-center">
                                                        <div class="mb-10 mt-10">
                                                            <i data-feather="film" class="fs-40 text-warning"></i>
                                                        </div>
                                                        <h5 class="mb-0">Tutorial Video</h5>
                                                        <p class="text-muted mb-10 fs-12">MP4 Video • 128 MB</p>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="#" class="btn btn-sm btn-primary-light me-5">
                                                                <i data-feather="download" class="me-5"></i> Download
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-info-light">
                                                                <i data-feather="play"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

<script>
    $(document).ready(function() {
        // Initialize feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
