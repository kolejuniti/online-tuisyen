@extends('layouts.admin.admin')

@section('title', 'Teacher Coordinators')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Teacher Coordinators</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Teacher Coordinators</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.teacher-coordinators.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Add Teacher Coordinator
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">All Teacher Coordinators</h4>
                            <div class="box-tools">
                                <div class="text-muted">Total: {{ $coordinators->total() }} coordinators</div>
                            </div>
                        </div>
                        <div class="box-body">
                            @if($coordinators->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover" id="coordinatorsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="25%">School Name</th>
                                                <th width="20%">Coordinator Name</th>
                                                <th width="20%">Email</th>
                                                <th width="15%">Secret Code</th>
                                                <th width="10%">Created</th>
                                                <th width="15%" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($coordinators as $index => $coordinator)
                                                <tr>
                                                    <td>{{ $coordinators->firstItem() + $index }}</td>
                                                    <td>
                                                        <strong>{{ $coordinator->school->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $coordinator->school->type }}</small>
                                                    </td>
                                                    <td>{{ $coordinator->name }}</td>
                                                    <td>
                                                        <a href="mailto:{{ $coordinator->email }}" class="text-primary">
                                                            {{ $coordinator->email }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <code class="text-success">{{ $coordinator->secret_code }}</code>
                                                        <br>
                                                        <small>
                                                            <a href="{{ route('admin.teacher-coordinators.generate-code', $coordinator) }}" 
                                                               class="text-warning" 
                                                               onclick="return confirm('Are you sure you want to generate a new secret code? The old one will no longer work.')">
                                                                <i class="fa fa-refresh"></i> Generate New
                                                            </a>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small>{{ $coordinator->created_at->format('M d, Y') }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.teacher-coordinators.show', $coordinator) }}" 
                                                               class="btn btn-info btn-sm" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.teacher-coordinators.edit', $coordinator) }}" 
                                                               class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.teacher-coordinators.destroy', $coordinator) }}" 
                                                                  method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                                        title="Delete"
                                                                        onclick="return confirm('Are you sure you want to delete this teacher coordinator?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if($coordinators->hasPages())
                                    <div class="row mt-3">
                                        <div class="col-12 d-flex justify-content-center">
                                            {{ $coordinators->links() }}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <i class="fa fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Teacher Coordinators Found</h5>
                                    <p class="text-muted">Get started by adding your first teacher coordinator.</p>
                                    <a href="{{ route('admin.teacher-coordinators.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Teacher Coordinator
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable if there are records
    @if($coordinators->count() > 0)
        $('#coordinatorsTable').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "order": [[5, "desc"]], // Sort by created date
            "columnDefs": [
                { "orderable": false, "targets": [6] } // Disable sorting for actions column
            ]
        });
    @endif
});
</script>
@endsection 