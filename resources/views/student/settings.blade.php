@extends('layouts.student')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Account Settings</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('student.dashboard') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fa fa-home"></i> Dashboard
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('student.settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="card mb-3">
                                    <div class="card-header"><b>Personal Information</b></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="name">Full Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="phone_number">Phone Number</label>
                                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="tingkatan">Tingkatan</label>
                                                    <input type="text" class="form-control" id="tingkatan" name="tingkatan" value="{{ old('tingkatan', $student->tingkatan) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="date_of_birth">Date of Birth</label>
                                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="gender">Gender</label>
                                                    <select class="form-control" id="gender" name="gender">
                                                        <option value="">-- Select --</option>
                                                        <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="ic">IC Number</label>
                                                    <input type="text" class="form-control" id="ic" value="{{ $student->ic }}" disabled>
                                                    <small class="text-muted">IC is not editable</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="parent_guardian_name">Parent/Guardian Name</label>
                                                    <input type="text" class="form-control" id="parent_guardian_name" name="parent_guardian_name" value="{{ old('parent_guardian_name', $student->parent_guardian_name) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="parent_guardian_phone">Parent/Guardian Phone</label>
                                                    <input type="text" class="form-control" id="parent_guardian_phone" name="parent_guardian_phone" value="{{ old('parent_guardian_phone', $student->parent_guardian_phone) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="address">Address</label>
                                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header"><b>Password</b></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password">New Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password to change">
                                                    <small class="text-muted">Leave blank to keep current password</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-rounded">
                                    <i class="fa fa-save"></i> Save Changes
                                </button>
                                <a href="{{ route('student.dashboard') }}" class="btn btn-secondary btn-rounded">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
  </div>
@endsection








