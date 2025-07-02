@extends('layouts.admin.admin')

@section('title', 'Edit School')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Edit School</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('admin.schools.update', $school->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- School Basic Information -->
                                <h5 class="mb-3"><i class="fa fa-school"></i> School Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">School Name <p style="color:red; display:inline-block;">*</p></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $school->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">School Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $school->email) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number <p style="color:red; display:inline-block;">*</p></label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $school->phone) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">School Type</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value="">Select Type</option>
                                                <option value="public" {{ old('type', $school->type) == 'public' ? 'selected' : '' }}>Public School</option>
                                                <option value="private" {{ old('type', $school->type) == 'private' ? 'selected' : '' }}>Private School</option>
                                                <option value="charter" {{ old('type', $school->type) == 'charter' ? 'selected' : '' }}>Charter School</option>
                                                <option value="international" {{ old('type', $school->type) == 'international' ? 'selected' : '' }}>International School</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="address">Address <p style="color:red; display:inline-block;">*</p></label>
                                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $school->address) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_students">Total Students (Approximate)</label>
                                            <input type="number" class="form-control" id="total_students" name="total_students" value="{{ old('total_students', $school->total_students) }}" min="0">
                                        </div>
                                    </div>
                                </div>

                                <!-- Teacher Coordinator Information -->
                                <hr>
                                <h5 class="mb-3"><i class="fa fa-user-tie"></i> Teacher Coordinator</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="teacher_name">Teacher Name</label>
                                            <input type="text" class="form-control" id="teacher_name" name="teacher_name" value="{{ old('teacher_name', $school->teacher_name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="teacher_email">Teacher Email</label>
                                            <input type="email" class="form-control" id="teacher_email" name="teacher_email" value="{{ old('teacher_email', $school->teacher_email) }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <hr>
                                <div class="form-group">
                                    <label for="status">Status <p style="color:red; display:inline-block;">*</p></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ old('status', $school->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $school->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-rounded">
                                        <i class="fa fa-save"></i> Update School
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
@endsection 