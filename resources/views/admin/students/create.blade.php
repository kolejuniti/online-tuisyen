@extends('layouts.admin.admin')

@section('title', 'Add New Student')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Add New Student</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fa fa-list"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <form action="{{ route('admin.students.store') }}" method="POST">
                            @csrf
                            <div class="box-body">
                                {{-- Display general errors from session --}}
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                {{-- Display validation errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Personal Information Card -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <b>Personal Information</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="name">Full Name <p style="color:red; display:inline-block;">*</p></label>
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="email">Email Address <p style="color:red; display:inline-block;">*</p></label>
                                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="ic">IC Number <p style="color:red; display:inline-block;">*</p></label>
                                                    <input type="text" name="ic" class="form-control" id="ic" value="{{ old('ic') }}" placeholder="Enter IC number (e.g., 010101101234)" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="phone_number">Phone Number</label>
                                                    <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number') }}" placeholder="Enter phone number (e.g., 0123456789)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Information Card -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <b>Account Information</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password">Password <p style="color:red; display:inline-block;">*</p></label>
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password_confirmation">Confirm Password <p style="color:red; display:inline-block;">*</p></label>
                                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm password" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- School Information Card -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <b>School & Status Information</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="school_id">School <p style="color:red; display:inline-block;">*</p></label>
                                                    <select name="school_id" id="school_id" class="form-control" style="width: 100%;" required>
                                                        <option value="">Select School</option>
                                                        @foreach($schools as $school)
                                                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                                                {{ $school->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="status">Status <p style="color:red; display:inline-block;">*</p></label>
                                                    <select name="status" id="status" class="form-control" required>
                                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-rounded">
                                    <i class="fa fa-save"></i> Save Student
                                </button>
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-rounded">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
@endsection

@section('content')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection 