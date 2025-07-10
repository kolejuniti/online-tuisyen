@extends('layouts.admin.admin')

@section('title', 'Student Applications')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <!-- Statistics Cards -->
                    <div class="row mb-20">
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-primary-light h-50 w-50 l-h-50 rounded text-center">
                                            <i class="fa fa-clock-o text-primary fs-24"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $applications->count() }}</h5>
                                            <p class="text-fade mb-0">Pending Applications</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-success-light h-50 w-50 l-h-50 rounded text-center">
                                            <i class="fa fa-check-circle text-success fs-24"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $applications->where('created_at', '>=', now()->startOfWeek())->count() }}</h5>
                                            <p class="text-fade mb-0">This Week</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-warning-light h-50 w-50 l-h-50 rounded text-center">
                                            <i class="fa fa-users text-warning fs-24"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $applications->groupBy('school_id')->count() }}</h5>
                                            <p class="text-fade mb-0">Schools Involved</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-15 bg-danger-light h-50 w-50 l-h-50 rounded text-center">
                                            <i class="fa fa-calendar text-danger fs-24"></i>
                                        </div>
                                        <div>
                                            @php
                                                $olderThan7Days = $applications->filter(function($app) {
                                                    return \Carbon\Carbon::parse($app->created_at)->diffInDays(now()) > 7;
                                                })->count();
                                            @endphp
                                            <h5 class="mb-0">{{ $olderThan7Days }}</h5>
                                            <p class="text-fade mb-0">Older than 7 days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Applications Table -->
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h4 class="box-title mb-0">Student Applications</h4>
                                @if($applications->count() > 0)
                                <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
                                    <small class="text-muted" id="checkbox-debug" style="font-size: 12px;">
                                        Select applications to enable bulk actions
                                    </small>
                                    <div class="btn-group">
                                        <button type="button" id="bulk-approve-btn" class="btn btn-success btn-sm" disabled>
                                            <i class="fa fa-check"></i> Bulk Approve
                                        </button>
                                        <button type="button" id="bulk-reject-btn" class="btn btn-danger btn-sm" disabled>
                                            <i class="fa fa-times"></i> Bulk Reject
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="fa fa-check-circle"></i> {{ session('success') }}
                            </div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                            </div>
                            @endif

                            @if($applications->count() > 0)
                            <div class="table-responsive">
                                <table id="applications-table" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">
                                                <div class="form-group mb-0">
                                                    <input type="checkbox" id="select-all" class="filled-in">
                                                    <label for="select-all"></label>
                                                </div>
                                            </th>
                                            <th width="5%">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>IC Number</th>
                                            <th>Tingkatan</th>
                                            <th>School</th>
                                            <th>Applied On</th>
                                            <th>Days Pending</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $application)
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-group mb-0">
                                                    <input type="checkbox" id="app-{{ $application->id }}" class="application-checkbox filled-in" value="{{ $application->id }}">
                                                    <label for="app-{{ $application->id }}"></label>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <strong>{{ $application->name }}</strong>
                                                @if($application->parent_guardian_name)
                                                    <br><small class="text-muted">Parent: {{ $application->parent_guardian_name }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $application->email }}</td>
                                            <td>{{ $application->ic }}</td>
                                            <td>{{ $application->tingkatan ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $application->school->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @php
                                                    $daysPending = \Carbon\Carbon::parse($application->created_at)->diffInDays(now());
                                                    $daysPending = (int) $daysPending; // Ensure integer value
                                                @endphp
                                                <span class="badge badge-{{ $daysPending > 7 ? 'danger' : ($daysPending > 3 ? 'warning' : 'secondary') }}">
                                                    {{ $daysPending }} {{ $daysPending == 1 ? 'day' : 'days' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.student-applications.show', $application->id) }}" 
                                                   class="btn btn-info btn-sm" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-success btn-sm approve-application" 
                                                        data-id="{{ $application->id }}"
                                                        data-name="{{ $application->name }}"
                                                        title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm reject-application" 
                                                        data-id="{{ $application->id }}"
                                                        data-name="{{ $application->name }}"
                                                        title="Reject">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-50">
                                <i class="fa fa-inbox fs-48 text-muted"></i>
                                <h5 class="mt-20 text-muted">No pending applications</h5>
                                <p class="text-fade">All student applications have been processed.</p>
                            </div>
                            @endif
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

<!-- Hidden forms for actions -->
<form id="approve-form" action="" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="reject-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="bulk-approve-form" action="{{ route('admin.student-applications.bulk-approve') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="application_ids" id="bulk-approve-ids">
</form>

<form id="bulk-reject-form" action="{{ route('admin.student-applications.bulk-reject') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="application_ids" id="bulk-reject-ids">
</form>

@endsection

@section('content')
<style>
    /* Force checkbox column to be visible */
    table.dataTable th:first-child,
    table.dataTable td:first-child,
    .checkbox-column {
        width: 50px !important;
        min-width: 50px !important;
        max-width: 50px !important;
        text-align: center !important;
        vertical-align: middle !important;
        display: table-cell !important;
        visibility: visible !important;
    }
    
    /* Ensure checkboxes are visible and properly styled */
    .application-checkbox, #select-all {
        width: 20px !important;
        height: 20px !important;
        cursor: pointer !important;
        opacity: 1 !important;
        visibility: visible !important;
        display: inline-block !important;
        position: relative !important;
        z-index: 999 !important;
        margin: 0 auto !important;
        transform: scale(1.3) !important;
    }
    
    /* Fix for DataTables checkbox column */
    .dataTables_wrapper .application-checkbox,
    .dataTables_wrapper #select-all {
        margin: 5px auto !important;
        padding: 0 !important;
    }
    
    /* Force DataTables to show first column */
    .dataTables_wrapper table.dataTable thead th:first-child,
    .dataTables_wrapper table.dataTable tbody td:first-child {
        display: table-cell !important;
        visibility: visible !important;
    }
    
    /* Bulk action buttons styling */
    #bulk-approve-btn.disabled,
    #bulk-reject-btn.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    /* Override any hiding of first column */
    table#applications-table th:nth-child(1),
    table#applications-table td:nth-child(1) {
        display: table-cell !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

        body.dark-skin .main-header .logo {
            background: var(--dark-primary);
        }

        /* Ensure checkbox column is properly sized and centered */
        #applications-table th:first-child,
        #applications-table td:first-child {
            width: 60px !important;
            min-width: 60px !important;
            max-width: 60px !important;
            text-align: center !important;
            vertical-align: middle !important;
            padding: 10px !important;
        }

        /* Style the form-group container for checkboxes */
        #applications-table .form-group {
            margin-bottom: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        /* Ensure filled-in checkboxes are visible and functional */
        #applications-table input.filled-in[type="checkbox"] {
            opacity: 1 !important;
            position: relative !important;
            visibility: visible !important;
            z-index: 1 !important;
        }

        /* Style the labels for filled-in checkboxes */
        #applications-table .filled-in + label {
            cursor: pointer !important;
            user-select: none !important;
        }

        /* Improved bulk action buttons layout */
        .box-header {
            padding: 20px !important;
        }

        .btn-group .btn {
            margin: 0 !important;
            border-radius: 4px !important;
        }

        .btn-group .btn:first-child {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .btn-group .btn:last-child {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        /* Gap utility for older browsers */
        .gap-3 > * + * {
            margin-left: 1rem !important;
        }

        /* Spacing adjustments */
        .box-header .text-muted {
            margin-right: 15px !important;
            white-space: nowrap !important;
        }

        .box-header .btn-group {
            white-space: nowrap !important;
        }

        /* Responsive bulk actions */
        @media (max-width: 768px) {
            .box-header .d-flex {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .box-header .btn-group {
                margin-top: 10px !important;
                width: 100% !important;
            }

            .box-header .btn-group .btn {
                flex: 1 !important;
            }

            .gap-3 > * + * {
                margin-left: 0 !important;
                margin-top: 10px !important;
            }
        }
</style>
<script>
    $(document).ready(function() {
        console.log('Initializing Student Applications page...');
        
        // Initialize DataTable if table exists
        if ($('#applications-table').length) {
            console.log('DataTable found, initializing...');
            
            // Pre-check: Verify checkboxes exist before DataTables init
            var preInitCheckboxes = $('#applications-table .application-checkbox').length;
            var preInitSelectAll = $('#applications-table #select-all').length;
            console.log('Before DataTables - Checkboxes:', preInitCheckboxes, 'Select All:', preInitSelectAll);
            
            var table = $('#applications-table').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: '<"row"<"col-sm-12 col-md-2"l><"col-sm-12 col-md-4"B><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                processing: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[7, 'desc']], // Order by application date (Applied On column)
                columnDefs: [
                    {
                        targets: 0, // Checkbox column
                        orderable: false,
                        searchable: false,
                        className: "text-center checkbox-column"
                    },
                    {
                        targets: 1, // Auto-number column
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        targets: -1, // Last column (Actions)
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ],
                drawCallback: function() {
                    console.log('DataTable redrawn, rebinding events...');
                    // Re-bind events after table redraw
                    bindCheckboxEvents();
                    // Ensure initial state
                    toggleBulkButtons();
                }
            });
            
            console.log('DataTable initialized successfully');
        }

        // Bind checkbox events
        function bindCheckboxEvents() {
            // Select all checkbox
            $('#select-all').off('change').on('change', function() {
                console.log('Select all clicked, checked:', this.checked);
                $('.application-checkbox').prop('checked', this.checked);
                toggleBulkButtons();
            });

            // Individual checkboxes
            $('.application-checkbox').off('change').on('change', function() {
                console.log('Individual checkbox changed');
                var total = $('.application-checkbox').length;
                var checked = $('.application-checkbox:checked').length;
                
                console.log('Total checkboxes:', total, 'Checked:', checked);
                
                $('#select-all').prop('indeterminate', checked > 0 && checked < total);
                $('#select-all').prop('checked', checked === total);
                
                toggleBulkButtons();
            });
        }

        // Initial bind
        bindCheckboxEvents();

        // Toggle bulk action buttons
        function toggleBulkButtons() {
            var checkedCount = $('.application-checkbox:checked').length;
            var totalCount = $('.application-checkbox').length;
            console.log('Toggling bulk buttons, checked count:', checkedCount);
            
            if (checkedCount === 0) {
                $('#bulk-approve-btn, #bulk-reject-btn').prop('disabled', true).addClass('disabled');
                $('#checkbox-debug').text('Select applications to enable bulk actions').removeClass('text-success').addClass('text-muted');
                console.log('Bulk buttons disabled');
            } else {
                $('#bulk-approve-btn, #bulk-reject-btn').prop('disabled', false).removeClass('disabled');
                $('#checkbox-debug').text(checkedCount + ' application(s) selected').removeClass('text-muted').addClass('text-success');
                console.log('Bulk buttons enabled');
            }
        }

        // Initial state - ensure buttons are disabled
        toggleBulkButtons();
        
        // Debug: Check if checkboxes exist
        setTimeout(function() {
            var checkboxCount = $('.application-checkbox').length;
            var selectAllExists = $('#select-all').length;
            var tableColumns = $('#applications-table thead th').length;
            var firstColumnContent = $('#applications-table thead th:first-child').html();
            
            console.log('=== CHECKBOX DEBUG INFO ===');
            console.log('Application checkboxes found:', checkboxCount);
            console.log('Select all checkbox exists:', selectAllExists);
            console.log('Table columns:', tableColumns);
            console.log('First column content:', firstColumnContent);
            console.log('First column visible:', $('#applications-table thead th:first-child').is(':visible'));
            
            if (checkboxCount === 0) {
                console.error('❌ NO CHECKBOXES FOUND! Check HTML structure.');
                // Try to add debugging info to the page
                $('#checkbox-debug').text('ERROR: No checkboxes found - check console').css('color', 'red');
            } else {
                console.log('✅ Checkboxes found successfully');
            }
        }, 1000);

        // Individual approve
        $('.approve-application').click(function() {
            var applicationId = $(this).data('id');
            var applicationName = $(this).data('name');
            
            Swal.fire({
                title: 'Approve Application?',
                text: "Approve " + applicationName + "'s registration? They will gain access to the platform.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#approve-form').attr('action', '{{ route("admin.student-applications.approve", ":id") }}'.replace(':id', applicationId));
                    $('#approve-form').submit();
                }
            });
        });

        // Individual reject
        $('.reject-application').click(function() {
            var applicationId = $(this).data('id');
            var applicationName = $(this).data('name');
            
            Swal.fire({
                title: 'Reject Application?',
                text: "Reject " + applicationName + "'s registration? This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#reject-form').attr('action', '{{ route("admin.student-applications.reject", ":id") }}'.replace(':id', applicationId));
                    $('#reject-form').submit();
                }
            });
        });

        // Bulk approve
        $('#bulk-approve-btn').click(function() {
            var checkedIds = $('.application-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (checkedIds.length === 0) return;

            Swal.fire({
                title: 'Bulk Approve Applications?',
                text: "Approve " + checkedIds.length + " selected application(s)? They will gain access to the platform.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, approve them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#bulk-approve-ids').val(JSON.stringify(checkedIds));
                    $('#bulk-approve-form').submit();
                }
            });
        });

        // Bulk reject
        $('#bulk-reject-btn').click(function() {
            var checkedIds = $('.application-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (checkedIds.length === 0) return;

            Swal.fire({
                title: 'Bulk Reject Applications?',
                text: "Reject " + checkedIds.length + " selected application(s)? This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#bulk-reject-ids').val(JSON.stringify(checkedIds));
                    $('#bulk-reject-form').submit();
                }
            });
        });

        // Auto-refresh disabled - was causing disruption
        // setInterval(function() {
        //     // Only refresh if no checkboxes are selected to avoid disrupting user
        //     if ($('.application-checkbox:checked').length === 0) {
        //         location.reload();
        //     }
        // }, 30000);
    });
</script>
@endsection 