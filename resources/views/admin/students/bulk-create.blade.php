@extends('layouts.admin.admin')

@section('title', 'Bulk Upload Students')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Bulk Upload Students</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fa fa-list"></i> Back to List
                                </a>
                                <a href="{{ route('admin.students.downloadTemplate') }}" class="btn btn-info btn-rounded" style="margin-right: 8px;">
                                    <i class="fa fa-download"></i> Download Template
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <form action="{{ route('admin.students.bulkStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <b>Please fix the following errors:</b>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{!! $error !!}</li> {{-- Use {!! !!} to render potential HTML in error messages --}}
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                     <div class="alert alert-danger">
                                         {!! session('error') !!} {{-- Use {!! !!} to render potential HTML in error messages --}}
                                     </div>
                                @endif


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="school_id">School <p style="color:red; display:inline-block;">*</p></label>
                                            <select name="school_id" id="school_id" class="form-control" style="width: 100%;" required>
                                                <option value="">Select School</option>
                                                @foreach($schools as $school)
                                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                                        {{ $school->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="student_file">Student Data File (.xlsx, .xls) <p style="color:red; display:inline-block;">*</p></label>
                                            <input type="file" name="student_file" class="form-control" id="student_file" accept=".xlsx, .xls" required>
                                            <small class="form-text text-muted">Download the template file first. Columns: full_name, email_address, ic_number, phone_number (optional). <strong>Important:</strong> Format 'ic_number' and 'phone_number' columns as 'Text' in your spreadsheet before entering data. Phone numbers should include the leading '0'.</small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-rounded">
                                    <i class="fa fa-upload"></i> Upload Students
                                </button>
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-rounded">
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
{{-- Add any specific JS for this page if needed --}}
<script>
    $(document).ready(function() {
        // Initialize Select2 if you are using it for the school dropdown
        if ($.fn.select2) {
            $('.select2').select2();
        }
    });
</script>
@endsection 