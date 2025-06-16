@extends('layouts.admin.admin')

@section('title', 'Subject Details')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Subject Details</h3>
                            <div class="pull-right">
                                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-info">Edit</a>
                                <a href="{{ route('admin.subjects.index') }}" class="btn btn-primary">Back to List</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">ID</th>
                                            <td>{{ $subject->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $subject->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $subject->created_at->format('F d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ $subject->updated_at->format('F d, Y h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    @if($subject->image)
                                        <div class="text-center">
                                            <h4>Subject Image</h4>
                                            <img src="{{ asset('storage/'.$subject->image) }}" alt="{{ $subject->name }}" class="img-fluid img-thumbnail" style="max-height: 300px;">
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <p>No image available for this subject.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
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