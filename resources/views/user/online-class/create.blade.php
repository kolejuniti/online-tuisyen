@extends('layouts.user.user')

@section('title', 'Create Online Class')

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Create Online Class</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $course->name ?? 'Course' }}</li>
                                <li class="breadcrumb-item"><a href="{{ route('user.online-class.index', $course->id ?? Session::get('subjects')->id) }}">Online Classes</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                            <h3 class="box-title">Create New Online Class</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('user.online-class.index', $course->id ?? Session::get('subjects')->id) }}" 
                                   class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        
                        <div class="box-body">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.online-class.store', $course->id ?? Session::get('subjects')->id) }}" 
                                  method="POST" id="createClassForm">
                                @csrf
                                
                                <div class="row">
                                    <!-- Class Details Section -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Class Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Class Name <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('name') is-invalid @enderror" 
                                                           id="name" 
                                                           name="name" 
                                                           value="{{ old('name') }}" 
                                                           placeholder="Enter class name"
                                                           required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="url" class="form-label">Meeting URL <span class="text-danger">*</span></label>
                                                    <input type="url" 
                                                           class="form-control @error('url') is-invalid @enderror" 
                                                           id="url" 
                                                           name="url" 
                                                           value="{{ old('url') }}" 
                                                           placeholder="https://meet.google.com/xxx-xxxx-xxx"
                                                           required>
                                                    @error('url')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        Enter the meeting URL (e.g., Google Meet, Zoom, Teams, etc.)<br>
                                                        <strong>Note:</strong> Students will access this through a secure gateway that requires authentication and authorization.
                                                    </small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="datetime" class="form-label">Date & Time <span class="text-danger">*</span></label>
                                                    <input type="datetime-local" 
                                                           class="form-control @error('datetime') is-invalid @enderror" 
                                                           id="datetime" 
                                                           name="datetime" 
                                                           value="{{ old('datetime') }}" 
                                                           min="{{ now()->format('Y-m-d\TH:i') }}"
                                                           required>
                                                    @error('datetime')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- School Selection Section -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Select Schools <span class="text-danger">*</span></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label">Schools</label>
                                                    <div class="school-selection-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                                                        @foreach($schools as $school)
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input school-checkbox" 
                                                                       type="checkbox" 
                                                                       value="{{ $school->id }}" 
                                                                       id="school_{{ $school->id }}"
                                                                       name="schools[]"
                                                                       {{ in_array($school->id, old('schools', [])) ? 'checked' : '' }}
                                                                       onchange="updateStudentList()">
                                                                <label class="form-check-label" for="school_{{ $school->id }}">
                                                                    <strong>{{ $school->name }}</strong>
                                                                    <br>
                                                                    <small class="text-muted">
                                                                        {{ $school->students->where('status', 'active')->count() }} active students
                                                                    </small>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @error('schools')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Students Preview Section -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Students in Selected Schools</h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="studentsList">
                                                    <p class="text-muted">Select schools above to see students who will have access to this online class.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Create Online Class
                                            </button>
                                            <a href="{{ route('user.online-class.index', $course->id ?? Session::get('subjects')->id) }}" 
                                               class="btn btn-secondary">
                                                <i class="fa fa-times"></i> Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
// Student data for each school
const schoolStudents = {
    @foreach($schools as $school)
        {{ $school->id }}: [
            @foreach($school->students->where('status', 'active') as $student)
                {
                    id: {{ $student->id }},
                    name: "{{ addslashes($student->name) }}",
                    email: "{{ addslashes($student->email) }}",
                    ic: "{{ addslashes($student->ic) }}"
                }@if(!$loop->last),@endif
            @endforeach
        ]@if(!$loop->last),@endif
    @endforeach
};

function updateStudentList() {
    const selectedSchools = [];
    const checkboxes = document.querySelectorAll('.school-checkbox:checked');
    
    checkboxes.forEach(checkbox => {
        selectedSchools.push(parseInt(checkbox.value));
    });

    const studentsListContainer = document.getElementById('studentsList');
    
    if (selectedSchools.length === 0) {
        studentsListContainer.innerHTML = '<p class="text-muted">Select schools above to see students who will have access to this online class.</p>';
        return;
    }

    let allStudents = [];
    selectedSchools.forEach(schoolId => {
        if (schoolStudents[schoolId]) {
            allStudents.push(...schoolStudents[schoolId]);
        }
    });

    if (allStudents.length === 0) {
        studentsListContainer.innerHTML = '<p class="text-muted">No active students found in selected schools.</p>';
        return;
    }

    // Group students by school
    let html = '<div class="row">';
    const schoolData = {
        @foreach($schools as $school)
            {{ $school->id }}: {
                id: {{ $school->id }},
                name: "{{ addslashes($school->name) }}"
            }@if(!$loop->last),@endif
        @endforeach
    };
    
    selectedSchools.forEach(schoolId => {
        const school = schoolData[schoolId];
        const students = schoolStudents[schoolId] || [];
        
        if (students.length > 0) {
            html += `
                <div class="col-md-6 mb-3">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">${school.name}</h6>
                            <small>${students.length} student(s)</small>
                        </div>
                        <div class="card-body">
                            <div class="student-list" style="max-height: 200px; overflow-y: auto;">
            `;
            
            students.forEach(student => {
                html += `
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <strong>${student.name}</strong><br>
                            <small class="text-muted">${student.email}</small>
                        </div>
                        <small class="text-muted">${student.ic}</small>
                    </div>
                `;
            });
            
            html += `
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    });
    html += '</div>';
    
    // Add summary
    html += `
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> 
            <strong>Summary:</strong> ${allStudents.length} total students from ${selectedSchools.length} school(s) will have access to this online class.
        </div>
    `;

    studentsListContainer.innerHTML = html;
}

// Initialize on page load if there are old values
document.addEventListener('DOMContentLoaded', function() {
    updateStudentList();
});

// Form validation
document.getElementById('createClassForm').addEventListener('submit', function(e) {
    const selectedSchools = document.querySelectorAll('.school-checkbox:checked');
    
    if (selectedSchools.length === 0) {
        e.preventDefault();
        alert('Please select at least one school for this online class.');
        return false;
    }
    
    // Show loading state
    const submitBtn = document.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Creating...';
    submitBtn.disabled = true;
});
</script>
@endsection 