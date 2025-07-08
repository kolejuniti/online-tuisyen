@extends('layouts.student.student')

@section('title', 'Online Classes')

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Online Classes</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $course->name ?? 'Course' }}</li>
                                <li class="breadcrumb-item active" aria-current="page">Online Classes</li>
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

            <!-- Today's Classes -->
            @if($todayClasses->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border bg-warning">
                            <h3 class="box-title text-white">
                                <i class="fa fa-calendar-day"></i> Today's Classes
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                @foreach($todayClasses as $class)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header bg-warning">
                                            <h5 class="card-title text-white mb-0">{{ $class->name }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <strong><i class="fa fa-clock-o"></i> Time:</strong> 
                                                {{ $class->datetime->format('h:i A') }}
                                            </p>
                                            <p class="card-text">
                                                <strong><i class="fa fa-school"></i> Schools:</strong> 
                                                @php
                                                    $schools = $class->schools();
                                                @endphp
                                                @if($schools->count() > 0)
                                                    {{ $schools->count() }} school(s)
                                                @else
                                                    No schools selected
                                                @endif
                                            </p>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('student.online-class.show', [$course->id, $class->id]) }}" 
                                                   class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> View Details
                                                </a>
                                                <a href="{{ route('student.online-class.join', [$course->id, $class->id]) }}" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fa fa-video"></i> Join Class
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Upcoming Classes -->
            @if($upcomingClasses->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border bg-info">
                            <h3 class="box-title text-white">
                                <i class="fa fa-calendar-plus"></i> Upcoming Classes
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Date & Time</th>
                                            <th>Schools</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcomingClasses as $class)
                                        <tr>
                                            <td>
                                                <strong>{{ $class->name }}</strong>
                                                <br>
                                                <span class="badge badge-info">Upcoming</span>
                                            </td>
                                            <td>
                                                {{ $class->datetime->format('d M Y, h:i A') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $class->datetime->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td>
                                                @php
                                                    $schools = $class->schools();
                                                @endphp
                                                @if($schools->count() > 0)
                                                    {{ $schools->count() }} school(s)
                                                @else
                                                    No schools
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('student.online-class.show', [$course->id, $class->id]) }}" 
                                                   class="btn btn-info btn-sm" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('student.online-class.join', [$course->id, $class->id]) }}" 
                                                   class="btn btn-outline-success btn-sm" title="Join Class">
                                                    <i class="fa fa-video"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Previous Classes -->
            @if($previousClasses->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="box collapsed-box">
                        <div class="box-header with-border bg-secondary">
                            <h3 class="box-title text-white">
                                <i class="fa fa-history"></i> Previous Classes
                            </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool text-white" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Date & Time</th>
                                            <th>Schools</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($previousClasses as $class)
                                        <tr>
                                            <td>
                                                <strong>{{ $class->name }}</strong>
                                                <br>
                                                <span class="badge badge-secondary">Past</span>
                                            </td>
                                            <td>
                                                {{ $class->datetime->format('d M Y, h:i A') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $class->datetime->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td>
                                                @php
                                                    $schools = $class->schools();
                                                @endphp
                                                @if($schools->count() > 0)
                                                    {{ $schools->count() }} school(s)
                                                @else
                                                    No schools
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('student.online-class.show', [$course->id, $class->id]) }}" 
                                                   class="btn btn-info btn-sm" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- No Classes Found -->
            @if($onlineClasses->count() == 0)
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center py-4">
                                <i class="fa fa-video fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Online Classes Available</h5>
                                <p class="text-muted">There are no online classes scheduled for your school at the moment.</p>
                                <p class="text-muted">Please check back later or contact your teacher for more information.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </div>
</div>
@endsection

@section('content')
<script>
$(document).ready(function() {
    // Initialize any DataTables if needed
    $('table').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": false,
        "searching": false,
        "order": [[ 1, "asc" ]], // Sort by date/time column ascending for upcoming, descending for previous
    });
});
</script>
@endsection 