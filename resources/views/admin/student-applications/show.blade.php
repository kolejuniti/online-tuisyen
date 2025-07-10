@extends('layouts.admin.admin')

@section('title', 'Student Application Details')

@section('main')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <i class="fa fa-user-circle-o me-15"></i>
                                Student Application Details
                            </h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('admin.student-applications.index') }}" class="btn btn-secondary btn-rounded me-5">
                                    <i class="fa fa-arrow-left"></i> Back to Applications
                                </a>
                                <button type="button" 
                                        class="btn btn-success btn-rounded me-5 approve-application" 
                                        data-id="{{ $application->id }}"
                                        data-name="{{ $application->name }}">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                                <button type="button" 
                                        class="btn btn-danger btn-rounded reject-application" 
                                        data-id="{{ $application->id }}"
                                        data-name="{{ $application->name }}">
                                    <i class="fa fa-times"></i> Reject
                                </button>
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

                            <div class="row">
                                <!-- Application Status -->
                                <div class="col-12 mb-20">
                                    <div class="box bg-primary-light">
                                        <div class="box-body text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="me-20">
                                                    <i class="fa fa-clock-o fs-40 text-primary"></i>
                                                </div>
                                                <div>
                                                    <h3 class="text-primary mb-0">Pending Approval</h3>
                                                    <p class="text-fade mb-0">
                                                        Applied {{ $application->created_at->diffForHumans() }} 
                                                        ({{ $application->created_at->format('M d, Y \a\t H:i') }})
                                                    </p>
                                                                                        @php
                                        $daysPending = \Carbon\Carbon::parse($application->created_at)->diffInDays(now());
                                        $daysPending = (int) $daysPending; // Ensure integer value
                                    @endphp
                                    <span class="badge badge-{{ $daysPending > 7 ? 'danger' : ($daysPending > 3 ? 'warning' : 'secondary') }} fs-14">
                                        {{ $daysPending }} {{ $daysPending == 1 ? 'day' : 'days' }} pending
                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Information -->
                                <div class="col-md-6">
                                    <div class="box">
                                        <div class="box-header">
                                            <h4 class="box-title">
                                                <i class="fa fa-user text-primary"></i> Personal Information
                                            </h4>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th width="40%" class="text-muted">Full Name:</th>
                                                    <td><strong>{{ $application->name }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Email:</th>
                                                    <td>
                                                        <a href="mailto:{{ $application->email }}">{{ $application->email }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">IC Number:</th>
                                                    <td><code>{{ $application->ic }}</code></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Phone Number:</th>
                                                    <td>
                                                        @if($application->phone_number)
                                                            <a href="tel:{{ $application->phone_number }}">{{ $application->phone_number }}</a>
                                                        @else
                                                            <span class="text-muted">Not provided</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Date of Birth:</th>
                                                    <td>
                                                        @if($application->date_of_birth)
                                                            {{ $application->date_of_birth->format('M d, Y') }}
                                                            <small class="text-muted">({{ $application->date_of_birth->age }} years old)</small>
                                                        @else
                                                            <span class="text-muted">Not provided</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Gender:</th>
                                                    <td>{{ $application->gender ?? 'Not specified' }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Tingkatan:</th>
                                                    <td>
                                                        @if($application->tingkatan)
                                                            <span class="badge badge-info">{{ $application->tingkatan }}</span>
                                                        @else
                                                            <span class="text-muted">Not specified</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- School & Contact Information -->
                                <div class="col-md-6">
                                    <div class="box">
                                        <div class="box-header">
                                            <h4 class="box-title">
                                                <i class="fa fa-school text-info"></i> School & Contact Information
                                            </h4>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th width="40%" class="text-muted">School:</th>
                                                    <td><strong>{{ $application->school->name ?? 'Unknown School' }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Parent/Guardian:</th>
                                                    <td>
                                                        @if($application->parent_guardian_name)
                                                            {{ $application->parent_guardian_name }}
                                                        @else
                                                            <span class="text-muted">Not provided</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Parent/Guardian Phone:</th>
                                                    <td>
                                                        @if($application->parent_guardian_phone)
                                                            <a href="tel:{{ $application->parent_guardian_phone }}">{{ $application->parent_guardian_phone }}</a>
                                                        @else
                                                            <span class="text-muted">Not provided</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Address:</th>
                                                    <td>
                                                        @if($application->address)
                                                            {{ $application->address }}
                                                        @else
                                                            <span class="text-muted">Not provided</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Application Timeline -->
                                <div class="col-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h4 class="box-title">
                                                <i class="fa fa-history text-warning"></i> Application Timeline
                                            </h4>
                                        </div>
                                        <div class="box-body">
                                            <div class="timeline">
                                                <div class="timeline-item">
                                                    <div class="timeline-marker bg-primary"></div>
                                                    <div class="timeline-content">
                                                        <h6 class="timeline-title">Application Submitted</h6>
                                                        <p class="text-muted mb-0">
                                                            {{ $application->created_at->format('M d, Y \a\t H:i') }}
                                                            ({{ $application->created_at->diffForHumans() }})
                                                        </p>
                                                        <small class="text-fade">
                                                            Student registered through the online platform
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="timeline-marker bg-warning"></div>
                                                    <div class="timeline-content">
                                                        <h6 class="timeline-title">Pending Review</h6>
                                                        <p class="text-muted mb-0">Current Status</p>
                                                        <small class="text-fade">
                                                            Waiting for admin approval to activate account
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons (Bottom) -->
                                <div class="col-12">
                                    <div class="box bg-light">
                                        <div class="box-body text-center">
                                            <h5 class="mb-20">Ready to process this application?</h5>
                                            <button type="button" 
                                                    class="btn btn-success btn-lg me-10 approve-application" 
                                                    data-id="{{ $application->id }}"
                                                    data-name="{{ $application->name }}">
                                                <i class="fa fa-check-circle"></i> Approve Application
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger btn-lg reject-application" 
                                                    data-id="{{ $application->id }}"
                                                    data-name="{{ $application->name }}">
                                                <i class="fa fa-times-circle"></i> Reject Application
                                            </button>
                                        </div>
                                    </div>
                                </div>
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

<!-- Hidden forms for actions -->
<form id="approve-form" action="" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="reject-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('content')
<style>
    .timeline {
        position: relative;
        padding: 40px 0 60px 0;
        margin: 0 auto;
        max-width: 800px;
        min-height: 300px;
    }
    
    /* Central timeline line */
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(to bottom, #dee2e6, #dee2e6);
        transform: translateX(-50%);
        z-index: 1;
    }
    
    .timeline-item {
        position: relative;
        width: 50%;
        margin-bottom: 60px;
        clear: both;
    }
    
    /* Alternate timeline items */
    .timeline-item:nth-child(odd) {
        float: left;
        padding-right: 50px;
        text-align: right;
    }
    
    .timeline-item:nth-child(even) {
        float: right;
        padding-left: 50px;
        text-align: left;
    }
    
    .timeline-marker {
        position: absolute;
        top: 20px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 0 0 3px currentColor;
        z-index: 2;
        background: #fff;
    }
    
    /* Position markers on the central line */
    .timeline-item:nth-child(odd) .timeline-marker {
        right: 25px;
        transform: translateX(50%);
    }
    
    .timeline-item:nth-child(even) .timeline-marker {
        left: 25px;
        transform: translateX(-50%);
    }
    
    .timeline-marker.bg-primary {
        color: var(--primary-color, #4361ee);
    }
    
    .timeline-marker.bg-warning {
        color: var(--warning-color, #ffbe0b);
    }
    
    .timeline-content {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        position: relative;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
    }
    
    /* Push even card content further right to avoid marker overlap */
    .timeline-item:nth-child(even) .timeline-content {
        margin-left: 25px;
    }
    
    /* Content arrows pointing to timeline */
    .timeline-content::before {
        content: '';
        position: absolute;
        top: 20px;
        width: 0;
        height: 0;
        border-style: solid;
    }
    
    /* Left side content - arrow points right */
    .timeline-item:nth-child(odd) .timeline-content::before {
        right: -15px;
        border: 15px solid transparent;
        border-left: 15px solid #f8f9fa;
    }
    
    /* Right side content - arrow points left */
    .timeline-item:nth-child(even) .timeline-content::before {
        left: -45px;
        border: 15px solid transparent;
        border-right: 15px solid #f8f9fa;
    }
    
    .timeline-content h6 {
        margin-bottom: 10px;
        font-weight: 600;
        color: #333;
        font-size: 16px;
    }
    
    .timeline-content p {
        margin-bottom: 8px;
        font-weight: 500;
    }
    
    .timeline-content small {
        line-height: 1.4;
        opacity: 0.8;
    }
    
    /* Clearfix for timeline container */
    .timeline::after {
        content: '';
        display: table;
        clear: both;
    }
    
    /* Timeline animations */
    .timeline-item {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }
    
    .timeline-item:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive timeline */
    @media (max-width: 768px) {
        .timeline {
            margin: 0 20px;
            max-width: none;
        }
        
        .timeline::before {
            left: 30px;
            transform: none;
        }
        
        .timeline-item {
            width: 100%;
            float: none;
            padding-left: 70px;
            padding-right: 0;
            text-align: left;
            margin-bottom: 40px;
        }
        
        .timeline-item:nth-child(odd),
        .timeline-item:nth-child(even) {
            float: none;
            padding-left: 70px;
            padding-right: 0;
            text-align: left;
        }
        
        .timeline-marker {
            left: 20px !important;
            right: auto !important;
            width: 18px;
            height: 18px;
        }
        
        .timeline-content {
            padding: 20px;
        }
        
        .timeline-content::before {
            left: -15px !important;
            right: auto !important;
            border: 15px solid transparent;
            border-right: 15px solid #f8f9fa;
            border-left: none !important;
        }
    }
</style>

<script>
    $(document).ready(function() {
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
                confirmButtonText: 'Yes, approve it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
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
                confirmButtonText: 'Yes, reject it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    $('#reject-form').attr('action', '{{ route("admin.student-applications.reject", ":id") }}'.replace(':id', applicationId));
                    $('#reject-form').submit();
                }
            });
        });
    });
</script>
@endsection 