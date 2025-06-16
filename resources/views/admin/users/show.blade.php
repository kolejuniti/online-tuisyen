@extends('layouts.admin.admin')

@section('title', 'User Details')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">User Details</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fa fa-list"></i> Back to List
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-rounded">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            @if($user->image)
                                                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="img-fluid rounded-circle mb-3" style="max-height: 200px; max-width: 200px;">
                                            @else
                                                <img src="{{ asset('assets/images/avatar/avatar-1.png') }}" alt="{{ $user->name }}" class="img-fluid rounded-circle mb-3" style="max-height: 200px; max-width: 200px;">
                                            @endif
                                            <h4>{{ $user->name }}</h4>
                                            <p class="text-muted">{{ ucfirst($user->user_type) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Personal Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%">Full Name</th>
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email Address</th>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>IC Number</th>
                                                    <td>{{ $user->ic ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>User Type</th>
                                                    <td>{{ ucfirst($user->user_type) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                                            {{ ucfirst($user->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created On</th>
                                                    <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Last Updated</th>
                                                    <td>{{ $user->updated_at->format('d M Y, h:i A') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-rounded">
                                        <i class="fa fa-edit"></i> Edit User
                                    </a>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-rounded">
                                        <i class="fa fa-list"></i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
@endsection 