@extends('layouts.admin.admin')

@section('title', 'Manage Users')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Users</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-rounded">
                                    <i class="fa fa-plus-circle"></i> Add New User
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ session('success') }}
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table id="users-table" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>IC Number</th>
                                            <th>Status</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                        <tr>
                                            <td></td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->ic }}</td>
                                            <td>
                                                <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                   class="btn btn-info btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm delete-user" 
                                                        data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $user->id }}" 
                                                      action="{{ route('admin.users.destroy', $user->id) }}" 
                                                      method="POST" 
                                                      style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No users found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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

@section('content')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#users-table').DataTable({
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-4"B><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            processing: true,
            order: [[1, 'asc']],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: -1,
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Delete User Confirmation
        $('.delete-user').click(function() {
            var userId = $(this).data('id');
            var userName = $(this).data('name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete " + userName + "? This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        });
    });
</script>
@endsection 