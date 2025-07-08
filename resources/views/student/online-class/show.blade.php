@extends('layouts.student.student')

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
                                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('student.online-class.index', $course->id) }}">Online Classes</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $onlineClass->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <!-- Class Information -->
                <div class="col-lg-8 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ $onlineClass->name }}</h3>
                            <div class="box-tools pull-right">
                                <span class="badge badge-{{ $onlineClass->status_badge_class }}">
                                    {{ ucfirst($onlineClass->status) }}
                                </span>
                                <span class="badge badge-{{ $onlineClass->time_badge_class }}">
                                    {{ $onlineClass->time_badge_text }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-primary"><i class="fa fa-calendar"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Date</span>
                                            <span class="info-box-number">{{ $onlineClass->datetime->format('l, d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-warning"><i class="fa fa-clock-o"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Time</span>
                                            <span class="info-box-number">{{ $onlineClass->datetime->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="callout callout-info">
                                        <h5><i class="fa fa-info-circle"></i> Class Information</h5>
                                        <p><strong>Subject:</strong> {{ $course->name }}</p>
                                        <p><strong>Duration:</strong> 
                                            @if($onlineClass->isPast())
                                                Ended {{ $onlineClass->datetime->diffForHumans() }}
                                            @elseif($onlineClass->isToday())
                                                Today at {{ $onlineClass->datetime->format('h:i A') }}
                                            @else
                                                Starts {{ $onlineClass->datetime->diffForHumans() }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Join Class Section -->
                            @if($onlineClass->status === 'active')
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="text-center">
                                            @if($onlineClass->isPast())
                                                <div class="alert alert-secondary">
                                                    <i class="fa fa-info-circle"></i>
                                                    This class has already ended.
                                                </div>
                                            @else
                                                <a href="{{ route('student.online-class.join', [$course->id, $onlineClass->id]) }}" 
                                                   class="btn btn-success btn-lg">
                                                    <i class="fa fa-video"></i> Join Online Class
                                                </a>
                                                <p class="text-muted mt-2">
                                                    <small>Click the button above to join the online class</small>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    This online class is currently inactive.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Participating Schools -->
                <div class="col-lg-4 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Participating Schools</h3>
                        </div>
                        <div class="box-body">
                            @php
                                $schools = $onlineClass->schools();
                            @endphp
                            
                            @if($schools->count() > 0)
                                @foreach($schools as $school)
                                <div class="media mb-3">
                                    <div class="media-object">
                                        <span class="avatar avatar-lg bg-primary">
                                            {{ substr($school->name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="media-heading">{{ $school->name }}</h6>
                                        <p class="text-muted">
                                            {{ $school->students->where('status', 'active')->count() }} student(s)
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted">No schools selected for this class.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Class Students -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Class Participants</h3>
                        </div>
                        <div class="box-body">
                            @if($classStudents->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($classStudents->take(10) as $student)
                                    <div class="list-group-item d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-info me-3">
                                            {{ substr($student->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $student->name }}</h6>
                                            <small class="text-muted">{{ $student->school->name ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    @if($classStudents->count() > 10)
                                    <div class="list-group-item text-center">
                                        <small class="text-muted">
                                            and {{ $classStudents->count() - 10 }} more students...
                                        </small>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-muted">No students found for this class.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('student.online-class.index', $course->id) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Online Classes
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('content')
<script>
$(document).ready(function() {
    // Auto-refresh if class is today and active
    @if($onlineClass->isToday() && $onlineClass->status === 'active')
    setInterval(function() {
        // Refresh every 30 seconds for today's classes
        location.reload();
    }, 30000);
    @endif
});
</script>
@endsection 