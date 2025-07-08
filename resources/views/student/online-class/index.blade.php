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
                    <div class="box" style="border: 2px solid #ffc107; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <div class="box-header with-border" style="background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%); color: white;">
                            <h3 class="box-title text-white">
                                <i class="fa fa-calendar-day"></i> Today's Classes
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                @foreach($todayClasses as $class)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="card" style="border: 2px solid #ffc107; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-bottom: 20px;">
                                        <div class="card-header" style="background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%); border-bottom: 2px solid #e0a800;">
                                            <h5 class="card-title text-white mb-0" style="font-weight: 600;">{{ $class->name }}</h5>
                                        </div>
                                        <div class="card-body" style="background-color: #fff; padding: 20px;">
                                            <p class="card-text" style="color: #333; font-size: 14px; margin-bottom: 10px;">
                                                <strong style="color: #495057;"><i class="fa fa-clock-o text-warning"></i> Time:</strong> 
                                                <span style="color: #007bff; font-weight: 500;">{{ $class->datetime->format('h:i A') }}</span>
                                            </p>
                                            <p class="card-text" style="color: #333; font-size: 14px; margin-bottom: 15px;">
                                                <strong style="color: #495057;"><i class="fa fa-school text-info"></i> Schools:</strong> 
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
                                                   class="btn btn-info btn-sm" style="background: #17a2b8; border-color: #17a2b8; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                                    <i class="fa fa-eye"></i> View Details
                                                </a>
                                                <a href="{{ route('student.online-class.join', [$course->id, $class->id]) }}" 
                                                   class="btn btn-success btn-sm" style="background: #28a745; border-color: #28a745; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.2); animation: pulse 2s infinite;">
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
                    <div class="box" style="border: 2px solid #007bff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <div class="box-header with-border" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white;">
                            <h3 class="box-title text-white">
                                <i class="fa fa-calendar-plus"></i> Upcoming Classes
                            </h3>
                        </div>
                        <div class="box-body" style="background-color: #fff; padding: 20px;">
                            <div class="table-responsive">
                                <table class="table table-striped" style="border: 1px solid #dee2e6; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                        <tr>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #007bff;">Class Name</th>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #007bff;">Date & Time</th>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #007bff;">Schools</th>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #007bff;">Actions</th>
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
                                                   class="btn btn-info btn-sm me-2" title="View Details" 
                                                   style="background: #17a2b8; border-color: #17a2b8; color: white; font-weight: 500;">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('student.online-class.join', [$course->id, $class->id]) }}" 
                                                   class="btn btn-success btn-sm" title="Join Class"
                                                   style="background: #28a745; border-color: #28a745; color: white; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                                    <i class="fa fa-video"></i> Join
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
                    <div class="box collapsed-box" style="border: 2px solid #6c757d; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <div class="box-header with-border" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white;">
                            <h3 class="box-title text-white">
                                <i class="fa fa-history"></i> Previous Classes
                            </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool text-white" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="background-color: #fff; padding: 20px;">
                            <div class="table-responsive">
                                <table class="table table-striped" style="border: 1px solid #dee2e6; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                        <tr>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #6c757d;">Class Name</th>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #6c757d;">Date & Time</th>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #6c757d;">Schools</th>
                                            <th style="color: #495057; font-weight: 600; border-bottom: 2px solid #6c757d;">Actions</th>
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
                                                   class="btn btn-info btn-sm" title="View Details"
                                                   style="background: #17a2b8; border-color: #17a2b8; color: white; font-weight: 500;">
                                                    <i class="fa fa-eye"></i> View
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
                    <div class="box" style="border: 2px solid #17a2b8; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color: #f8f9fa;">
                        <div class="box-header with-border" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white;">
                            <h3 class="box-title text-white">
                                <i class="fa fa-info-circle"></i> Online Classes
                            </h3>
                        </div>
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
<style>
@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
}

/* Enhanced table row styling */
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0,123,255,.05) !important;
}

.table-striped tbody tr:hover {
    background-color: rgba(0,123,255,.1) !important;
    transition: background-color 0.2s ease;
}

/* Enhanced badge styling */
.badge {
    font-weight: 600 !important;
    padding: 6px 12px !important;
    border-radius: 20px !important;
}

/* Enhanced button styling */
.btn {
    border-radius: 6px !important;
    font-weight: 500 !important;
    text-decoration: none !important;
    display: inline-block !important;
    text-align: center !important;
    white-space: nowrap !important;
    vertical-align: middle !important;
    user-select: none !important;
    border: 1px solid transparent !important;
    padding: 0.375rem 0.75rem !important;
    font-size: 0.875rem !important;
    line-height: 1.5 !important;
    transition: all 0.15s ease-in-out !important;
}

.btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
}

.btn-sm {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.75rem !important;
}

.me-2 {
    margin-right: 0.5rem !important;
}

/* Table action buttons */
td .btn {
    margin: 2px !important;
}
</style>

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