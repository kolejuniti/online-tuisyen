@extends('layouts.admin.admin')

@section('title', 'Edit Teacher Coordinator')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Edit Teacher Coordinator</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.teacher-coordinators.index') }}">Teacher Coordinators</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.teacher-coordinators.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Update Teacher Coordinator Information</h4>
                            <p class="text-muted">Edit the details for <strong>{{ $teacherCoordinator->name }}</strong></p>
                        </div>
                        <div class="box-body">
                            <form action="{{ route('admin.teacher-coordinators.update', $teacherCoordinator) }}" method="POST" id="coordinatorForm">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">School <span class="text-danger">*</span></label>
                                            <select name="school_id" class="form-control select2" required style="width: 100%;">
                                                <option value="">Select a school...</option>
                                                @foreach($schools as $school)
                                                    <option value="{{ $school->id }}" 
                                                            {{ (old('school_id', $teacherCoordinator->school_id) == $school->id) ? 'selected' : '' }}>
                                                        {{ $school->name }} ({{ ucfirst($school->type) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Current school: <strong>{{ $teacherCoordinator->school->name }}</strong></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Coordinator Name <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="name" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $teacherCoordinator->name) }}" 
                                                   placeholder="Enter coordinator's full name"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" 
                                                   name="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   value="{{ old('email', $teacherCoordinator->email) }}" 
                                                   placeholder="coordinator@school.com"
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Secret Code</label>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control" 
                                                       value="{{ $teacherCoordinator->secret_code }}" 
                                                       readonly>
                                                <div class="input-group-append">
                                                    <a href="{{ route('admin.teacher-coordinators.generate-code', $teacherCoordinator) }}" 
                                                       class="btn btn-warning"
                                                       onclick="return confirm('Are you sure you want to generate a new secret code? The old one will no longer work.')">
                                                        <i class="fa fa-refresh"></i> Generate New
                                                    </a>
                                                </div>
                                            </div>
                                            <small class="text-muted">This code is used for authentication. Click "Generate New" to create a new code.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Created On</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   value="{{ $teacherCoordinator->created_at->format('F d, Y \a\t g:i A') }}" 
                                                   readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    <strong>Note:</strong> The secret code will remain unchanged unless you specifically generate a new one.
                                </div>

                                <div class="form-group text-end">
                                    <a href="{{ route('admin.teacher-coordinators.index') }}" class="btn btn-secondary me-2">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Update Coordinator
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
$(document).ready(function() {
    // Check if Select2 is loaded
    if (typeof $.fn.select2 === 'undefined') {
        console.error('Select2 is not loaded!');
        return;
    }
    
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: "Select a school...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('.box-body') // Ensure dropdown appears correctly
    });
    
    console.log('Select2 initialized successfully');
    
    // Form validation
    $('#coordinatorForm').on('submit', function(e) {
        let isValid = true;
        
        // Check if school is selected
        if (!$('select[name="school_id"]').val()) {
            isValid = false;
            $('select[name="school_id"]').addClass('is-invalid');
        } else {
            $('select[name="school_id"]').removeClass('is-invalid');
        }
        
        // Check if name is filled
        if (!$('input[name="name"]').val().trim()) {
            isValid = false;
            $('input[name="name"]').addClass('is-invalid');
        } else {
            $('input[name="name"]').removeClass('is-invalid');
        }
        
        // Check if email is filled and valid
        const email = $('input[name="email"]').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email || !emailRegex.test(email)) {
            isValid = false;
            $('input[name="email"]').addClass('is-invalid');
        } else {
            $('input[name="email"]').removeClass('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields correctly.',
                confirmButtonColor: '#3085d6'
            });
        }
    });
});
</script>
@endsection 