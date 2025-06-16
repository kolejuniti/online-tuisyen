@extends('layouts.admin.admin')

@section('title', 'Add New User')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Add New User</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fa fa-list"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
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
                                        </div>
                                    </div>
                                </div>

                                <!-- User Image Card -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <b>Profile Image</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="image">User Image</label>
                                                    <input type="file" name="image" class="form-control" id="image">
                                                    <small class="text-muted">Upload user profile image (JPG, PNG, GIF, max 2MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Information Card -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <b>Status Information</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
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
                                    <i class="fa fa-save"></i> Save User
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-rounded">
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