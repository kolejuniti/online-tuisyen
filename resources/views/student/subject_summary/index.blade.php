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
                                                        <h3 class="fw-600 mb-0">{{ $stats['classmates'] }}</h3>
                                                        <p class="mb-0 text-mute">Classmates</p>
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
                                                        <h3 class="fw-600 mb-0">{{ $stats['my_progress'] }}%</h3>
                                                        <p class="mb-0 text-mute">My Progress</p>
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
                                    <a class="nav-link active" data-bs-toggle="tab" href="#my_progress" role="tab">
                                        <i data-feather="trending-up" class="me-5"></i> My Progress
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
                                    <a class="nav-link" data-bs-toggle="tab" href="#classmates" role="tab">
                                        <i data-feather="users" class="me-5"></i> Classmates
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#resources" role="tab">
                                        <i data-feather="folder" class="me-5"></i> Resources
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- My Progress Tab -->
                                <div class="tab-pane active" id="my_progress" role="tabpanel">
                                    <div class="p-15">
                                        <div class="row">
                                            <!-- Overall Progress Card -->
                                            <div class="col-md-6 col-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h4 class="box-title">Overall Progress</h4>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="text-center mb-20">
                                                            <div class="progress mx-auto" style="width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(#007bff 0deg {{ ($myProgress['overall'] * 3.6) }}deg, #e9ecef {{ ($myProgress['overall'] * 3.6) }}deg 360deg);">
                                                                <div class="d-flex align-items-center justify-content-center h-100">
                                                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                                                        <h2 class="mb-0">{{ $myProgress['overall'] }}%</h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row text-center">
                                                            <div class="col-6">
                                                                <h4 class="mb-0">{{ $myProgress['completed_lessons'] }}/{{ $myProgress['total_lessons'] }}</h4>
                                                                <p class="text-muted mb-0">Lessons</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <h4 class="mb-0">{{ $myProgress['completed_assignments'] }}/{{ $myProgress['total_assignments'] }}</h4>
                                                                <p class="text-muted mb-0">Assignments</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Recent Activity -->
                                            <div class="col-md-6 col-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h4 class="box-title">Recent Activity</h4>
                                                    </div>
                                                    <div class="box-body">
                                                        @forelse($myProgress['recent_activities'] as $activity)
                                                        <div class="d-flex align-items-center mb-15">
                                                            <div class="me-15">
                                                                <div class="avatar avatar-sm 
                                                                    @if($activity['type'] === 'lesson') bg-info-light
                                                                    @elseif($activity['type'] === 'quiz') bg-primary-light
                                                                    @elseif($activity['type'] === 'test') bg-success-light
                                                                    @else bg-warning-light
                                                                    @endif
                                                                ">
                                                                    <span class="avatar-title">
                                                                        @if($activity['type'] === 'lesson')
                                                                            <i data-feather="book" class="fs-16"></i>
                                                                        @elseif($activity['type'] === 'quiz')
                                                                            <i data-feather="help-circle" class="fs-16"></i>
                                                                        @elseif($activity['type'] === 'test')
                                                                            <i data-feather="clipboard" class="fs-16"></i>
                                                                        @else
                                                                            <i data-feather="activity" class="fs-16"></i>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">{{ $activity['title'] }}</h6>
                                                                <small class="text-muted">{{ $activity['description'] }}</small>
                                                                @if($activity['score'])
                                                                    <small class="text-success d-block">Score: {{ $activity['score'] }}</small>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">{{ \Carbon\Carbon::parse($activity['date'])->format('M j') }}</small>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        <p class="text-muted text-center">No recent activity</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Performance Chart -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h4 class="box-title">Assignment Performance</h4>
                                                    </div>
                                                    <div class="box-body">
                                                        @if(count($myProgress['assignment_scores']) > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Assignment</th>
                                                                        <th>Type</th>
                                                                        <th>Score</th>
                                                                        <th>Submission Date</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($myProgress['assignment_scores'] as $score)
                                                                    <tr>
                                                                        <td>{{ $score['title'] }}</td>
                                                                        <td>
                                                                            <span class="badge 
                                                                                @if($score['type'] === 'quiz') badge-primary
                                                                                @else badge-success
                                                                                @endif
                                                                            ">{{ ucfirst($score['type']) }}</span>
                                                                        </td>
                                                                        <td>
                                                                            @if($score['score'] !== null)
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="me-10">{{ $score['score'] }}/{{ $score['total'] }}</span>
                                                                                    <span class="badge 
                                                                                        @if($score['percentage'] >= 80) badge-success
                                                                                        @elseif($score['percentage'] >= 60) badge-primary
                                                                                        @else badge-warning
                                                                                        @endif
                                                                                    ">{{ $score['percentage'] }}%</span>
                                                                                </div>
                                                                            @else
                                                                                <span class="text-muted">Not submitted</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            {{ $score['submission_date'] ? \Carbon\Carbon::parse($score['submission_date'])->format('d M Y H:i') : '-' }}
                                                                        </td>
                                                                        <td>
                                                                            @if($score['submitted'])
                                                                                <span class="badge badge-success">Submitted</span>
                                                                            @else
                                                                                <span class="badge badge-warning">Pending</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @else
                                                        <p class="text-muted text-center">No assignments completed yet</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Lessons Tab -->
                                <div class="tab-pane" id="lessons" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Lesson Plan</h4>
                                            <a href="{{ route('student.content', Session::get('subjects')->id) }}" class="btn btn-primary">
                                                <i data-feather="external-link" class="me-5"></i> View Content
                                            </a>
                                        </div>
                                        
                                        @forelse($lessons as $index => $lesson)
                                        <div class="box bg-light mb-20">
                                            <div class="box-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-15 
                                                            @if($lesson->is_completed) bg-success
                                                            @elseif($lesson->is_current) bg-primary
                                                            @else bg-secondary
                                                            @endif
                                                            rounded-circle h-50 w-50 l-h-50 text-center">
                                                            <span class="text-white fs-24">{{ $lesson->ChapterNo ?: ($index + 1) }}</span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">{{ $lesson->display_name }}</h5>
                                                            <p class="mb-0 text-muted">{{ $lesson->main_folder }}</p>
                                                            @if($lesson->is_completed)
                                                                <small class="text-success">Completed on {{ \Carbon\Carbon::parse($lesson->completed_at)->format('d M Y') }}</small>
                                                            @elseif($lesson->is_current)
                                                                <small class="text-primary">Currently studying</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="badge 
                                                            @if($lesson->is_completed) badge-success-light
                                                            @elseif($lesson->is_current) badge-primary-light
                                                            @else badge-secondary-light
                                                            @endif
                                                        ">
                                                            @if($lesson->is_completed) Completed
                                                            @elseif($lesson->is_current) In Progress
                                                            @else Upcoming
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center">
                                            <p class="text-muted">No lessons available yet.</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                
                                <!-- Assignments Tab -->
                                <div class="tab-pane" id="assignments" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">My Assignments</h4>
                                            <div class="d-flex gap-2">
                                                <select class="form-select" style="width: auto;">
                                                    <option value="all">All Assignments</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="submitted">Submitted</option>
                                                    <option value="graded">Graded</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Assignment</th>
                                                        <th>Type</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Score</th>
                                                        <th>Submission</th>
                                                        <th style="width: 100px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($assignments as $assignment)
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{ $assignment->title }}</h5>
                                                            <p class="mb-0 text-muted fs-12">{{ $assignment->description ?? 'No description' }}</p>
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
                                                                @if(\Carbon\Carbon::parse($assignment->date_to)->isPast() && !$assignment->is_submitted)
                                                                    <br><small class="text-danger">Overdue</small>
                                                                @elseif(\Carbon\Carbon::parse($assignment->date_to)->diffInDays() <= 3 && !$assignment->is_submitted)
                                                                    <br><small class="text-warning">Due soon</small>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">No deadline</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($assignment->is_submitted)
                                                                @if($assignment->is_graded)
                                                                    <span class="badge badge-success">Graded</span>
                                                                @else
                                                                    <span class="badge badge-info">Under Review</span>
                                                                @endif
                                                            @elseif($assignment->statusname === 'PUBLISHED')
                                                                <span class="badge badge-warning">Pending</span>
                                                            @else
                                                                <span class="badge badge-secondary">Not Available</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($assignment->my_score !== null && $assignment->total_marks > 0)
                                                                <div class="d-flex align-items-center">
                                                                    <span class="me-10">{{ $assignment->my_score }}/{{ $assignment->total_marks }}</span>
                                                                    <span class="badge 
                                                                        @if($assignment->percentage >= 80) badge-success
                                                                        @elseif($assignment->percentage >= 60) badge-primary
                                                                        @else badge-warning
                                                                        @endif
                                                                    ">{{ $assignment->percentage }}%</span>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($assignment->submitted_at)
                                                                <small>{{ \Carbon\Carbon::parse($assignment->submitted_at)->format('d M Y') }}</small>
                                                                <br>
                                                                <small class="text-muted">{{ \Carbon\Carbon::parse($assignment->submitted_at)->format('H:i') }}</small>
                                                            @else
                                                                <span class="text-muted">Not submitted</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @if($assignment->statusname === 'PUBLISHED')
                                                                    @if($assignment->type === 'quiz')
                                                                        <a href="{{ route('student.quiz.take', ['id' => Session::get('subjects')->id, 'quiz' => $assignment->id]) }}" class="btn btn-sm btn-icon 
                                                                            @if($assignment->is_submitted) btn-success-light @else btn-primary @endif me-5" data-bs-toggle="tooltip" title="
                                                                            @if($assignment->is_submitted) View Results @else Take Quiz @endif">
                                                                            <i data-feather="@if($assignment->is_submitted) eye @else play @endif"></i>
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('student.test.take', ['id' => Session::get('subjects')->id, 'test' => $assignment->id]) }}" class="btn btn-sm btn-icon 
                                                                            @if($assignment->is_submitted) btn-success-light @else btn-primary @endif me-5" data-bs-toggle="tooltip" title="
                                                                            @if($assignment->is_submitted) View Results @else Take Test @endif">
                                                                            <i data-feather="@if($assignment->is_submitted) eye @else play @endif"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <a href="#" class="btn btn-sm btn-icon btn-info-light" data-bs-toggle="tooltip" title="Details">
                                                                    <i data-feather="info"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <p class="text-muted">No assignments available yet.</p>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Classmates Tab -->
                                <div class="tab-pane" id="classmates" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">My Classmates</h4>
                                            <div class="d-flex">
                                                <div class="lookup lookup-circle lookup-right me-15">
                                                    <input type="text" name="s" placeholder="Search Classmates" id="classmateSearch">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" id="classmatesTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px">#</th>
                                                        <th>Student Name</th>
                                                        <th>School</th>
                                                        <th>Progress</th>
                                                        <th>Last Activity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($classmates as $index => $classmate)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm me-10 bg-primary-light">
                                                                    <span class="avatar-title">{{ substr($classmate->name, 0, 2) }}</span>
                                                                </div>
                                                                <div>
                                                                    <h5 class="mb-0 fs-16">{{ $classmate->name }}</h5>
                                                                    <p class="mb-0 text-muted fs-12">IC: {{ $classmate->ic }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $classmate->school_name }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                                    <div class="progress-bar 
                                                                        @if($classmate->progress >= 80) bg-success
                                                                        @elseif($classmate->progress >= 60) bg-primary
                                                                        @else bg-warning
                                                                        @endif
                                                                    " role="progressbar" style="width: {{ $classmate->progress }}%" aria-valuenow="{{ $classmate->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="ms-10">{{ $classmate->progress }}%</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($classmate->last_activity)
                                                                <small>{{ \Carbon\Carbon::parse($classmate->last_activity)->format('d M Y') }}</small>
                                                            @else
                                                                <small class="text-muted">No activity</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <p class="text-muted">No classmates found.</p>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Resources Tab -->
                                <div class="tab-pane" id="resources" role="tabpanel">
                                    <div class="p-15">
                                        <div class="d-flex justify-content-between align-items-center mb-20">
                                            <h4 class="mb-0">Learning Resources</h4>
                                            <a href="{{ route('student.content', Session::get('subjects')->id) }}" class="btn btn-primary">
                                                <i data-feather="external-link" class="me-5"></i> View All Resources
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
                                                            <a href="{{ route('student.content', Session::get('subjects')->id) }}" class="btn btn-sm btn-primary-light me-5">
                                                                <i data-feather="external-link" class="me-5"></i> Open
                                                            </a>
                                                            @if($resource['type'] !== 'folder')
                                                            <a href="#" class="btn btn-sm btn-info-light">
                                                                <i data-feather="download"></i>
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <p class="text-muted">No learning resources available yet.</p>
                                                    <a href="{{ route('student.content', Session::get('subjects')->id) }}" class="btn btn-primary">
                                                        <i data-feather="external-link" class="me-5"></i> Explore Content
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
        
        // Classmate search functionality
        $('#classmateSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#classmatesTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Assignment filter functionality
        $('select[name="assignment_filter"]').on('change', function() {
            var filter = $(this).val();
            $('#assignmentsTable tbody tr').each(function() {
                var status = $(this).find('.badge').text().toLowerCase();
                if (filter === 'all' || status.includes(filter)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endsection
