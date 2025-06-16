@extends('layouts.admin.admin')

@section('title', 'Subjects')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Subjects</h3>
                            <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary pull-right">Add New Subject</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="subjects-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subjects as $subject)
                                        <tr>
                                            <td>{{ $subject->id }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>
                                                @if($subject->image)
                                                    <img src="{{ asset('storage/'.$subject->image) }}" alt="{{ $subject->name }}" width="50">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm delete-subject" 
                                                        data-id="{{ $subject->id }}"
                                                        data-name="{{ $subject->name }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $subject->id }}" 
                                                      action="{{ route('admin.subjects.destroy', $subject->id) }}" 
                                                      method="POST" 
                                                      style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

@section('content')
<script>
    $(document).ready(function() {
        $('#subjects-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        // Delete Subject Confirmation
        $('.delete-subject').click(function() {
            var subjectId = $(this).data('id');
            var subjectName = $(this).data('name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete " + subjectName + "? This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + subjectId).submit();
                }
            });
        });
    });
</script>
@endsection 