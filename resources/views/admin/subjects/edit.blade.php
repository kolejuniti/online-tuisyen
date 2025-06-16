@extends('layouts.admin.admin')

@section('title', 'Edit Subject')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Subject</h3>
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

                            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Subject Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $subject->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Subject Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <small class="text-muted">Upload a new image for the subject (optional). Supported formats: jpeg, png, jpg, gif (max: 2MB)</small>
                                    
                                    @if($subject->image)
                                        <div class="mt-3">
                                            <p>Current Image:</p>
                                            <img src="{{ asset('storage/'.$subject->image) }}" alt="{{ $subject->name }}" width="150" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
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