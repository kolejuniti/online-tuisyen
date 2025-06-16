@extends('layouts.admin.admin')

@section('title', 'Manage Subjects for ' . $teacher->name)

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->

        <div class="page-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title mb-1">Manage Subjects for {{ $teacher->name }}</h3>
                    <div class="d-inline-block align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.teacher-subjects.index') }}">Teacher Subjects</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $teacher->name }}</li>
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
                            <h4 class="box-title">Teacher Information</h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <p><strong>{{ $teacher->name }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <p><strong>{{ $teacher->email }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Assign New Subject</h4>
                        </div>
                        <div class="box-body">
                            <form id="assign-subject-form">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $teacher->id }}">
                                <div class="form-group">
                                    <label>Select Subject</label>
                                    <select class="form-control select" name="subject_id" id="subject-select" style="width: 100%;">
                                        <option value="">Select a subject</option>
                                        @foreach($allSubjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Assign Subject</button>
                                </div>
                            </form>
                            <div id="assign-alert" class="mt-3"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Assigned Subjects</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject Name</th>
                                            <th>Assigned Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assigned-subjects-table">
                                        @foreach($assignedSubjects as $subject)
                                        <tr id="subject-row-{{ $subject->id }}">
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->pivot->created_at->format('d M Y') }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm remove-subject" 
                                                        data-user-id="{{ $teacher->id }}" 
                                                        data-subject-id="{{ $subject->id }}">
                                                    <i class="fa fa-trash"></i> Remove
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div id="no-subjects-message" class="{{ count($assignedSubjects) > 0 ? 'd-none' : '' }}">
                                    <p class="text-center">No subjects assigned yet.</p>
                                </div>
                            </div>
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
        // Initialize Select2
        $('.select2').select2();
        
        // Assign Subject Form Submit
        $('#assign-subject-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            var subjectId = $('#subject-select').val();
            
            if (!subjectId) {
                showAlert('error', 'Please select a subject to assign.');
                return;
            }
            
            $.ajax({
                url: "{{ route('admin.teacher-subjects.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        
                        // Add the new subject to the table
                        var newRow = '<tr id="subject-row-' + response.data.subject_id + '">' +
                            '<td>' + response.data.subject_name + '</td>' +
                            '<td>' + new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + '</td>' +
                            '<td>' +
                            '<button class="btn btn-danger btn-sm remove-subject" ' +
                            'data-user-id="{{ $teacher->id }}" ' +
                            'data-subject-id="' + response.data.subject_id + '">' +
                            '<i class="fa fa-trash"></i> Remove' +
                            '</button>' +
                            '</td>' +
                            '</tr>';
                        
                        $('#assigned-subjects-table').append(newRow);
                        $('#no-subjects-message').addClass('d-none');
                        
                        // Reset the form
                        $('#subject-select').val('').trigger('change');
                    }
                },
                error: function(xhr) {
                    var message = 'An error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showAlert('error', message);
                }
            });
        });
        
        // Remove Subject
        $(document).on('click', '.remove-subject', function() {
            var userId = $(this).data('user-id');
            var subjectId = $(this).data('subject-id');
            var row = $(this).closest('tr');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to remove this subject assignment.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.teacher-subjects.destroy') }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: userId,
                            subject_id: subjectId
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Removed!',
                                    response.message,
                                    'success'
                                );
                                
                                // Remove the row from the table
                                row.remove();
                                
                                // Show the "no subjects" message if the table is empty
                                if ($('#assigned-subjects-table tr').length === 0) {
                                    $('#no-subjects-message').removeClass('d-none');
                                }
                            }
                        },
                        error: function(xhr) {
                            var message = 'An error occurred. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            Swal.fire(
                                'Error!',
                                message,
                                'error'
                            );
                        }
                    });
                }
            });
        });
        
        // Helper function to show alerts
        function showAlert(type, message) {
            var alertClass = 'alert-info';
            if (type === 'success') alertClass = 'alert-success';
            if (type === 'error') alertClass = 'alert-danger';
            
            $('#assign-alert').html(
                '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>'
            );
            
            // Auto-hide the alert after 5 seconds
            setTimeout(function() {
                $('#assign-alert .alert').alert('close');
            }, 5000);
        }
    });
</script>
@endsection