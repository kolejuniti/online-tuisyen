@extends('layouts.admin.admin')

@section('title', 'Edit Student')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Edit Student: {{ $student->name }}</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fa fa-list"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
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
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $student->name) }}" placeholder="Enter full name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="email">Email Address <p style="color:red; display:inline-block;">*</p></label>
                                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $student->email) }}" placeholder="Enter email address" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="ic">IC Number <p style="color:red; display:inline-block;">*</p></label>
                                                    <input type="text" name="ic" class="form-control" id="ic" value="{{ old('ic', $student->ic) }}" placeholder="Enter IC number (e.g., 010101101234)" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="phone_number">Phone Number</label>
                                                    <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number', $student->phone_number) }}" placeholder="Enter phone number (e.g., 0123456789)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="tingkatan">Tingkatan</label>
                                                    <input type="text" name="tingkatan" class="form-control" id="tingkatan" value="{{ old('tingkatan', $student->tingkatan) }}" placeholder="Enter tingkatan (e.g., Tingkatan 5)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="date_of_birth">Date of Birth</label>
                                                    <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="gender">Gender</label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="parent_guardian_name">Parent/Guardian Name</label>
                                                    <input type="text" name="parent_guardian_name" class="form-control" id="parent_guardian_name" value="{{ old('parent_guardian_name', $student->parent_guardian_name) }}" placeholder="Enter parent/guardian name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="parent_guardian_phone">Parent/Guardian Phone</label>
                                                    <input type="text" name="parent_guardian_phone" class="form-control" id="parent_guardian_phone" value="{{ old('parent_guardian_phone', $student->parent_guardian_phone) }}" placeholder="Enter parent/guardian phone (e.g., 0123456789)">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="address">Address</label>
                                                    <textarea name="address" class="form-control" id="address" rows="3" placeholder="Enter full address">{{ old('address', $student->address) }}</textarea>
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
                                                    <label class="form-label" for="password">Password (Leave blank to keep current)</label>
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter new password">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm new password">
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
                                                            <option value="{{ $school->id }}" {{ old('school_id', $student->school_id) == $school->id ? 'selected' : '' }}>
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
                                                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                    <i class="fa fa-save"></i> Update Student
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