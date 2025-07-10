@extends('layouts.admin.admin')

@section('title', 'View Teacher Coordinator')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Teacher Coordinator Details</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.teacher-coordinators.index') }}">Teacher Coordinators</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.teacher-coordinators.edit', $teacherCoordinator) }}" class="btn btn-warning me-2">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.teacher-coordinators.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Coordinator Information -->
                <div class="col-lg-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <i class="fa fa-user-tie text-primary"></i> 
                                {{ $teacherCoordinator->name }}
                            </h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="35%" class="fw-bold">Full Name:</td>
                                            <td>{{ $teacherCoordinator->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Email Address:</td>
                                            <td>
                                                <a href="mailto:{{ $teacherCoordinator->email }}" class="text-primary">
                                                    {{ $teacherCoordinator->email }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Secret Code:</td>
                                            <td>
                                                <code class="text-success fs-16">{{ $teacherCoordinator->secret_code }}</code>
                                                <br>
                                                <small class="text-muted">Used for authentication and access control</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="35%" class="fw-bold">Created On:</td>
                                            <td>{{ $teacherCoordinator->created_at->format('F d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Created At:</td>
                                            <td>{{ $teacherCoordinator->created_at->format('g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Last Updated:</td>
                                            <td>{{ $teacherCoordinator->updated_at->format('F d, Y g:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- School Information -->
                <div class="col-lg-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <i class="fa fa-school text-success"></i> 
                                Assigned School
                            </h4>
                        </div>
                        <div class="box-body">
                            <div class="text-center mb-3">
                                <i class="fa fa-building fa-3x text-muted mb-2"></i>
                                <h5 class="mb-1">{{ $teacherCoordinator->school->name }}</h5>
                                <span class="badge bg-primary">{{ ucfirst($teacherCoordinator->school->type) }}</span>
                            </div>
                            
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>
                                        @if($teacherCoordinator->school->email)
                                            <a href="mailto:{{ $teacherCoordinator->school->email }}" class="text-primary">
                                                {{ $teacherCoordinator->school->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Phone:</td>
                                    <td>
                                        @if($teacherCoordinator->school->phone)
                                            {{ $teacherCoordinator->school->phone }}
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Students:</td>
                                    <td>
                                        @if($teacherCoordinator->school->total_students)
                                            ~{{ $teacherCoordinator->school->total_students }} students
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            @if($teacherCoordinator->school->address)
                                <div class="mt-3">
                                    <strong>Address:</strong><br>
                                    <small class="text-muted">{{ $teacherCoordinator->school->address }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Cards -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <i class="fa fa-cog text-warning"></i> 
                                Quick Actions
                            </h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-light-primary">
                                        <div class="card-body text-center">
                                            <i class="fa fa-edit fa-2x text-primary mb-2"></i>
                                            <h6>Edit Details</h6>
                                            <p class="small text-muted">Update coordinator information</p>
                                            <a href="{{ route('admin.teacher-coordinators.edit', $teacherCoordinator) }}" class="btn btn-primary btn-sm">
                                                Edit Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light-warning">
                                        <div class="card-body text-center">
                                            <i class="fa fa-refresh fa-2x text-warning mb-2"></i>
                                            <h6>New Secret Code</h6>
                                            <p class="small text-muted">Generate a new authentication code</p>
                                            <a href="{{ route('admin.teacher-coordinators.generate-code', $teacherCoordinator) }}" 
                                               class="btn btn-warning btn-sm"
                                               onclick="return confirm('Are you sure you want to generate a new secret code? The old one will no longer work.')">
                                                Generate
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light-info">
                                        <div class="card-body text-center">
                                            <i class="fa fa-envelope fa-2x text-info mb-2"></i>
                                            <h6>Send Email</h6>
                                            <p class="small text-muted">Contact the coordinator directly</p>
                                            <a href="mailto:{{ $teacherCoordinator->email }}" class="btn btn-info btn-sm">
                                                Send Email
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light-danger">
                                        <div class="card-body text-center">
                                            <i class="fa fa-trash fa-2x text-danger mb-2"></i>
                                            <h6>Delete</h6>
                                            <p class="small text-muted">Remove this coordinator</p>
                                            <form action="{{ route('admin.teacher-coordinators.destroy', $teacherCoordinator) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this teacher coordinator? This action cannot be undone.')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection 