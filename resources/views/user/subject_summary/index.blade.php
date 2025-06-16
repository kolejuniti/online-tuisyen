@extends('layouts.user.user')

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
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('user.subjects.index') }}">Subjects</a></li>
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
                                                        <h3 class="fw-600 mb-0">{{ $stats['students'] }}</h3>
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
                                                        <h3 class="fw-600 mb-0">{{ $stats['lessons'] }}</h3>
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
                                                        <h3 class="fw-600 mb-0">{{ $stats['assignments'] }}</h3>
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
                                                        <h3 class="fw-600 mb-0">{{ $stats['completion'] }}%</h3>
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
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#schedule" role="tab">
                                        <i data-feather="calendar" class="me-5"></i> Schedule
                                    </a>
                                </li> --}}
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
                                                    <input type="text" name="s" placeholder="Search Students" id="studentSearch">
                                                </div>
                                                <button type="button" class="btn btn-primary-light">
                                                    <i data-feather="filter" class="me-5"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" id="studentsTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px">#</th>
                                                        <th>Student Name</th>
                                                        <th>Progress</th>
                                                        <th>Assignments</th>
                                                        <th>Average Score</th>
                                                        <th>Last Activity</th>
                                                        <th style="width: 100px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($students as $index => $student)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm me-10 bg-primary-light">
                                                                    <span class="avatar-title">{{ substr($student->name, 0, 2) }}</span>
                                                                </div>
                                                                <div>
                                                                    <h5 class="mb-0 fs-16">{{ $student->name }}</h5>
                                                                    <p class="mb-0 text-muted fs-12">IC: {{ $student->ic }}</p>
                                                                    <p class="mb-0 text-muted fs-11">{{ $student->school_name }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                                    <div class="progress-bar 
                                                                        @if($student->progress >= 80) bg-success
                                                                        @elseif($student->progress >= 60) bg-primary
                                                                        @else bg-warning
                                                                        @endif
                                                                    " role="progressbar" style="width: {{ $student->progress }}%" aria-valuenow="{{ $student->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">{{ $student->progress }}%</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fw-bold">{{ $student->completed_assignments }}/{{ $student->total_assignments }}</span> completed
                                                            @if(count($student->assignment_details) > 0)
                                                                <br>
                                                                <small class="text-muted">
                                                                    @php
                                                                        $pendingCount = collect($student->assignment_details)->where('submitted', false)->count();
                                                                    @endphp
                                                                    @if($pendingCount > 0)
                                                                        <span class="text-warning">{{ $pendingCount }} pending</span>
                                                                    @else
                                                                        <span class="text-success">All submitted</span>
                                                                    @endif
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                                                    <div class="progress-bar 
                                                                        @if($student->average_score >= 80) bg-success
                                                                        @elseif($student->average_score >= 60) bg-primary
                                                                        @else bg-warning
                                                                        @endif
                                                                    " role="progressbar" style="width: {{ $student->average_score }}%" aria-valuenow="{{ $student->average_score }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">{{ $student->average_score }}%</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($student->last_activity)
                                                                <small>{{ \Carbon\Carbon::parse($student->last_activity)->format('d M Y') }}</small>
                                                                <br>
                                                                <small class="text-muted">{{ \Carbon\Carbon::parse($student->last_activity)->format('H:i') }}</small>
                                                            @else
                                                                <small class="text-muted">No activity</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="modal" data-bs-target="#studentDetailModal{{ $student->ic }}" title="View Details">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Message">
                                                                    <i data-feather="message-circle"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <p class="text-muted">No students enrolled yet.</p>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Student Detail Modals --}}
                                        @foreach($students as $student)
                                        <div class="modal fade" id="studentDetailModal{{ $student->ic }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $student->name }} - Assignment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>IC:</strong> {{ $student->ic }}<br>
                                                                <strong>School:</strong> {{ $student->school_name }}<br>
                                                                <strong>Overall Progress:</strong> {{ $student->progress }}%
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Assignments Completed:</strong> {{ $student->completed_assignments }}/{{ $student->total_assignments }}<br>
                                                                <strong>Average Score:</strong> {{ $student->average_score }}%<br>
                                                                <strong>Last Activity:</strong> {{ $student->last_activity ? \Carbon\Carbon::parse($student->last_activity)->format('d M Y H:i') : 'No activity' }}
                                                            </div>
                                                        </div>
                                                        
                                                        <h6>Assignment History:</h6>
                                                        @if(count($student->assignment_details) > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Type</th>
                                                                        <th>Title</th>
                                                                        <th>Status</th>
                                                                        <th>Submission Date</th>
                                                                        <th>Score</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($student->assignment_details as $assignment)
                                                                    <tr>
                                                                        <td>
                                                                            <span class="badge 
                                                                                @if($assignment['type'] === 'Quiz') badge-primary
                                                                                @else badge-success
                                                                                @endif
                                                                            ">{{ $assignment['type'] }}</span>
                                                                        </td>
                                                                        <td>{{ $assignment['title'] }}</td>
                                                                        <td>
                                                                            @if($assignment['submitted'])
                                                                                <span class="badge badge-success">Submitted</span>
                                                                            @else
                                                                                <span class="badge badge-warning">Pending</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            {{ $assignment['submission_date'] ? \Carbon\Carbon::parse($assignment['submission_date'])->format('d M Y H:i') : '-' }}
                                                                        </td>
                                                                        <td>
                                                                            @if($assignment['score'] !== null && $assignment['total'] > 0)
                                                                                {{ $assignment['score'] }}/{{ $assignment['total'] }}
                                                                                ({{ round(($assignment['score'] / $assignment['total']) * 100, 1) }}%)
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @else
                                                        <p class="text-muted">No assignments attempted yet.</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Lessons Tab -->
                                <div class="tab-pane" id="lessons" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Lesson Plan</h4>
                                            <a href="/user/content/{{ Session::get('subjects')->id }}/create" class="btn btn-primary">
                                                <i data-feather="plus" class="me-5"></i> Add Lesson
                                            </a>
                                        </div>
                                        
                                        @forelse($lessons as $index => $lesson)
                                        <div class="box bg-light mb-20">
                                            <div class="box-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-15 bg-info rounded-circle h-50 w-50 l-h-50 text-center">
                                                            <span class="text-white fs-24">{{ $lesson->ChapterNo ?: ($index + 1) }}</span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">{{ $lesson->display_name }}</h5>
                                                            <p class="mb-0 text-muted">{{ $lesson->main_folder }}</p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="badge 
                                                            @if($lesson->status === 'completed') badge-success-light
                                                            @elseif($lesson->status === 'in_progress') badge-primary-light
                                                            @else badge-warning-light
                                                            @endif
                                                        ">{{ ucfirst(str_replace('_', ' ', $lesson->status)) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center">
                                            <p class="text-muted">No lessons created yet.</p>
                                            <a href="/user/content/{{ Session::get('subjects')->id }}/create" class="btn btn-primary">
                                                <i data-feather="plus" class="me-5"></i> Create Your First Lesson
                                            </a>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                
                                <!-- Assignments Tab -->
                                <div class="tab-pane" id="assignments" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Assignments</h4>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('user.quiz.create', Session::get('subjects')->id) }}" class="btn btn-primary">
                                                    <i data-feather="plus" class="me-5"></i> Add Quiz
                                                </a>
                                                <a href="{{ route('user.test.create', Session::get('subjects')->id) }}" class="btn btn-success">
                                                    <i data-feather="plus" class="me-5"></i> Add Test
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Type</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Submitted</th>
                                                        <th>Average Score</th>
                                                        <th style="width: 100px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($assignments as $assignment)
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{ $assignment->title }}</h5>
                                                            <p class="mb-0 text-muted fs-12">{{ ucfirst($assignment->type) }}</p>
                                                        </td>
                                                        <td>
                                                            <span class="badge 
                                                                @if($assignment->type === 'quiz') badge-primary
                                                                @else badge-success
                                                                @endif
                                                            ">{{ ucfirst($assignment->type) }}</span>
                                                        </td>
                                                        <td>
                                                            @if($assignment->date_to)
                                                                {{ \Carbon\Carbon::parse($assignment->date_to)->format('d M Y') }}
                                                            @else
                                                                <span class="text-muted">No deadline</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge 
                                                                @if($assignment->statusname === 'PUBLISHED') badge-success
                                                                @elseif($assignment->statusname === 'DRAFT') badge-warning
                                                                @else badge-primary
                                                                @endif
                                                            ">{{ $assignment->statusname }}</span>
                                                        </td>
                                                        <td>{{ $assignment->submissions }}/{{ $assignment->total_students }} students</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                                                    <div class="progress-bar 
                                                                        @if($assignment->average_score >= 80) bg-success
                                                                        @elseif($assignment->average_score >= 60) bg-primary
                                                                        @else bg-warning
                                                                        @endif
                                                                    " role="progressbar" style="width: {{ $assignment->average_score }}%" aria-valuenow="{{ $assignment->average_score }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">{{ $assignment->average_score }}%</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @if($assignment->type === 'quiz')
                                                                    <a href="{{ route('user.quiz.status', ['id' => Session::get('subjects')->id, 'quiz' => $assignment->id]) }}" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                        <i data-feather="eye"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('user.test.status', ['id' => Session::get('subjects')->id, 'test' => $assignment->id]) }}" class="btn btn-sm btn-icon btn-primary-light me-5" data-bs-toggle="tooltip" title="View Details">
                                                                        <i data-feather="eye"></i>
                                                                    </a>
                                                                @endif
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Download">
                                                                    <i data-feather="download"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <p class="text-muted">No assignments created yet.</p>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- <!-- Schedule Tab -->
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
                                </div> --}}
                                
                                <!-- Resources Tab -->
                                <div class="tab-pane" id="resources" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Teaching Resources</h4>
                                            <a href="{{ route('user.content', Session::get('subjects')->id) }}" class="btn btn-primary">
                                                <i data-feather="upload" class="me-5"></i> Manage Resources
                                            </a>
                                        </div>
                                        
                                        <div class="row">
                                            @forelse($resources as $resource)
                                            <div class="col-xl-3 col-md-4 col-6">
                                                <div class="box">
                                                    <div class="box-body text-center">
                                                        <div class="mb-10 mt-10">
                                                            @if($resource['type'] === 'folder')
                                                                <i data-feather="folder" class="fs-40 text-primary"></i>
                                                            @elseif(str_contains($resource['name'], '.pdf'))
                                                                <i data-feather="file-text" class="fs-40 text-danger"></i>
                                                            @elseif(str_contains($resource['name'], '.mp4'))
                                                                <i data-feather="film" class="fs-40 text-warning"></i>
                                                            @else
                                                                <i data-feather="file" class="fs-40 text-success"></i>
                                                            @endif
                                                        </div>
                                                        <h5 class="mb-0">{{ $resource['name'] }}</h5>
                                                        <p class="text-muted mb-10 fs-12">
                                                            {{ ucfirst($resource['type']) }}
                                                            @if($resource['size'])
                                                                • {{ $resource['size'] }}
                                                            @endif
                                                        </p>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('user.content', Session::get('subjects')->id) }}" class="btn btn-sm btn-primary-light me-5">
                                                                <i data-feather="external-link" class="me-5"></i> Open
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-info-light">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <p class="text-muted">No resources uploaded yet.</p>
                                                    <a href="{{ route('user.content', Session::get('subjects')->id) }}" class="btn btn-primary">
                                                        <i data-feather="upload" class="me-5"></i> Upload Your First Resource
                                                    </a>
                                                </div>
                                            </div>
                                            @endforelse
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
        
        // Student search functionality
        $('#studentSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#studentsTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>
@endsection
