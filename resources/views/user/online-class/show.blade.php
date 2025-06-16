@extends('layouts.user.user')

@section('title', 'Online Class Details')

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Online Class Details</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $course->name ?? 'Course' }}</li>
                                <li class="breadcrumb-item"><a href="{{ route('user.online-class.index', $course->id ?? Session::get('subjects')->id) }}">Online Classes</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $onlineClass->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Class Details Card -->
                <div class="col-lg-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ $onlineClass->name }}</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('user.online-class.edit', [$course->id ?? Session::get('subjects')->id, $onlineClass->id]) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('user.online-class.index', $course->id ?? Session::get('subjects')->id) }}" 
                                   class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box bg-primary">
                                        <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Date & Time</span>
                                            <span class="info-box-number">{{ $onlineClass->datetime->format('d M Y') }}</span>
                                            <span class="progress-description">{{ $onlineClass->datetime->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-box bg-{{ $onlineClass->status == 'active' ? 'success' : 'danger' }}">
                                        <span class="info-box-icon"><i class="fa fa-info-circle"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Status</span>
                                            <span class="info-box-number">{{ ucfirst($onlineClass->status) }}</span>
                                            <span class="progress-description">
                                                @if($onlineClass->isPast())
                                                    Completed
                                                @elseif($onlineClass->isToday())
                                                    Today
                                                @else
                                                    Upcoming
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="callout callout-info">
                                <h5><i class="fa fa-link"></i> Meeting Links</h5>
                                <p>
                                    <a href="{{ route('online-class.join-page', $onlineClass->id) }}" target="_blank" class="btn btn-primary">
                                        <i class="fa fa-shield"></i> Secure Student Link
                                    </a>
                                    <a href="{{ $onlineClass->url }}" target="_blank" class="btn btn-success ml-2">
                                        <i class="fa fa-external-link"></i> Direct Teacher Link
                                    </a>
                                </p>
                                <div style="font-weight: bold; color: #000;">
                                    <strong>Student Link:</strong> <span style="font-weight: 600;">{{ route('online-class.join-page', $onlineClass->id) }}</span><br>
                                    <strong>Original URL:</strong> <span style="font-weight: 600;">{{ $onlineClass->url }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h5><i class="fa fa-school"></i> Participating Schools</h5>
                                    <div class="row">
                                        @foreach($schools as $school)
                                            <div class="col-md-6 mb-3">
                                                <div class="card border-primary">
                                                    <div class="card-header bg-primary text-white">
                                                        <h6 class="mb-0">{{ $school->name }}</h6>
                                                        <small>{{ $school->students->count() }} student(s)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="col-lg-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Class Summary</h4>
                        </div>
                        <div class="box-body">
                            <div class="text-center">
                                <div class="d-flex justify-content-around">
                                    <div class="text-center">
                                        <h3 class="text-primary">{{ $schools->count() }}</h3>
                                        <p class="text-muted">Schools</p>
                                    </div>
                                    <div class="text-center">
                                        <h3 class="text-success">{{ $schools->sum(function($school) { return $school->students->count(); }) }}</h3>
                                        <p class="text-muted">Students</p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="timeline">
                                <div class="time-label">
                                    <span class="bg-info">Class Timeline</span>
                                </div>
                                
                                <div class="timeline-item">
                                    <i class="fa fa-calendar bg-blue"></i>
                                    <div class="timeline-content">
                                        <span class="time"><i class="fa fa-clock-o"></i> {{ $onlineClass->created_at->diffForHumans() }}</span>
                                        <h3 class="timeline-header">Class Created</h3>
                                        <div class="timeline-body">
                                            <small class="text-muted">{{ $onlineClass->created_at->format('M d, Y h:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($onlineClass->updated_at != $onlineClass->created_at)
                                <div class="timeline-item">
                                    <i class="fa fa-edit bg-yellow"></i>
                                    <div class="timeline-content">
                                        <span class="time"><i class="fa fa-clock-o"></i> {{ $onlineClass->updated_at->diffForHumans() }}</span>
                                        <h3 class="timeline-header">Last Updated</h3>
                                        <div class="timeline-body">
                                            <small class="text-muted">{{ $onlineClass->updated_at->format('M d, Y h:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="timeline-item">
                                    <i class="fa fa-video bg-green"></i>
                                    <div class="timeline-content">
                                        <span class="time">
                                            <i class="fa fa-clock-o"></i> 
                                            @if($onlineClass->isPast())
                                                Completed
                                            @elseif($onlineClass->isToday())
                                                Today
                                            @else
                                                {{ $onlineClass->datetime->diffForHumans() }}
                                            @endif
                                        </span>
                                        <h3 class="timeline-header">Scheduled Class</h3>
                                        <div class="timeline-body">
                                            <small class="text-muted">{{ $onlineClass->datetime->format('M d, Y h:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="timeline-end">
                                    <i class="fa fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students List -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Students Enrolled</h3>
                        </div>
                        
                        <div class="box-body">
                            @if($schools->sum(function($school) { return $school->students->count(); }) > 0)
                                <div class="table-responsive">
                                    <table id="studentsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Email</th>
                                                <th>IC Number</th>
                                                <th>School</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($schools as $school)
                                                @foreach($school->students as $student)
                                                    <tr>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->email }}</td>
                                                        <td>{{ $student->ic }}</td>
                                                        <td>
                                                            <span class="badge badge-primary">{{ $school->name }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $student->status == 'active' ? 'success' : 'danger' }}">
                                                                {{ ucfirst($student->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fa fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Students Enrolled</h5>
                                    <p class="text-muted">There are no active students in the selected schools.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('content')
<script>
$(document).ready(function() {
    // Initialize DataTable for students
    $('#studentsTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "searching": true,
        "order": [[ 0, "asc" ]], // Sort by student name
        "columnDefs": [
            { "orderable": false, "targets": 4 } // Disable sorting for Status column
        ]
    });
});
</script>
@endsection 