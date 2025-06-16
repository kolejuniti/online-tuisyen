@extends('layouts.admin.admin')

@section('title', 'Add Subject')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add New Subject</h3>
                            <a href="{{ route('admin.subjects.index') }}" class="btn btn-primary pull-right">Back to List</a>
                        </div>
                        <!-- /.box-header -->
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

                            <form action="{{ route('admin.subjects.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Subject Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Subject Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <small class="text-muted">Upload an image for the subject (optional). Supported formats: jpeg, png, jpg, gif (max: 2MB)</small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</div>
@endsection 