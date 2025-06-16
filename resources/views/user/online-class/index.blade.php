@extends('layouts.user.user')

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
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
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
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Manage Online Classes</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('user.online-class.create', $course->id ?? Session::get('subjects')->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Create New Class
                                </a>
                            </div>
                        </div>
                        
                        <div class="box-body">
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

                            <div class="table-responsive">
                                <table id="onlineClassTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Date & Time</th>
                                            <th>Schools Involved</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($onlineClasses as $class)
                                            <tr>
                                                <td>
                                                    <strong>{{ $class->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fa fa-link"></i> 
                                                        <a href="{{ route('online-class.join-page', $class->id) }}" target="_blank">Secure Join Link</a>
                                                    </small>
                                                </td>
                                                <td>
                                                    {{ $class->datetime->format('d M Y, h:i A') }}
                                                    <br>
                                                    <small class="text-muted">
                                                        <span class="badge badge-{{ $class->time_badge_class }}">{{ $class->time_badge_text }}</span>
                                                    </small>
                                                </td>
                                                <td>
                                                    @php
                                                        $schools = $class->schools();
                                                    @endphp
                                                    
                                                    @if($schools->count() > 0)
                                                        @foreach($schools as $index => $school)
                                                            <span class="badge badge-primary">{{ $school->name }}</span>
                                                            @if($index < $schools->count() - 1) <br> @endif
                                                        @endforeach
                                                        <br>
                                                        <small class="text-muted">{{ $schools->count() }} school(s)</small>
                                                    @else
                                                        <span class="text-muted">No schools selected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $class->status_badge_class }}">
                                                        {{ ucfirst($class->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('user.online-class.show', [$course->id ?? Session::get('subjects')->id, $class->id]) }}" 
                                                           class="btn btn-info btn-sm" title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('user.online-class.edit', [$course->id ?? Session::get('subjects')->id, $class->id]) }}" 
                                                           class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                onclick="confirmDelete({{ $class->id }})" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <div class="py-4">
                                                        <i class="fa fa-video fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">No Online Classes Found</h5>
                                                        <p class="text-muted">Get started by creating your first online class.</p>
                                                        <a href="{{ route('user.online-class.create', $course->id ?? Session::get('subjects')->id) }}" 
                                                           class="btn btn-primary">
                                                            <i class="fa fa-plus"></i> Create New Class
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this online class? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#onlineClassTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "searching": true,
        "order": [[ 1, "desc" ]], // Sort by date/time column descending
        "columnDefs": [
            { "orderable": false, "targets": 4 } // Disable sorting for Actions column
        ]
    });
});

function confirmDelete(classId) {
    const deleteForm = document.getElementById('deleteForm');
    const courseId = {{ $course->id ?? Session::get('subjects')->id }};
    deleteForm.action = `/user/online-class/${courseId}/${classId}`;
    
    // Show the modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endsection 