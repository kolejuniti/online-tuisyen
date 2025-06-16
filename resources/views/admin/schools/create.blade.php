@extends('layouts.admin.admin')

@section('title', 'Add School')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Add New School</h4>
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

                            <form action="{{ route('admin.schools.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">School Name <p style="color:red; display:inline-block;">*</p></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number <p style="color:red; display:inline-block;">*</p></label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address <p style="color:red; display:inline-block;">*</p></label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <p style="color:red; display:inline-block;">*</p></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-rounded">
                                        <i class="fa fa-save"></i> Save School
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