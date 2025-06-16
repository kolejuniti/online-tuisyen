<div id="test-library" class="container-fluid">
    <div class="row g-4">
        @foreach ($test as $ts)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                <div class="test-card h-100 position-relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                        <span class="badge {{ $ts->date_from != null ? 'bg-warning text-dark' : 'bg-secondary text-white' }} px-3 py-2 rounded-pill shadow">
                            {{ $ts->statusname }}
                        </span>
                    </div>

                    <!-- Card Header -->
                    <div class="test-card-header p-4 text-center">
                        <div class="test-icon mb-3">
                            @if ($ts->date_from != null)
                                <i class="fa fa-question-circle text-warning" style="font-size: 4rem;"></i>
                            @else
                                <i class="fa fa-download text-secondary" style="font-size: 4rem;"></i>
                            @endif
                        </div>
                        <h4 class="test-title fw-bold text-dark mb-3 line-clamp-2">
                            {{ $ts->title }}
                        </h4>
                    </div>

                    <!-- Card Body -->
                    <div class="test-card-body px-4 py-4">
                        @if ($ts->date_from != null)
                            <!-- Online Test Info -->
                            <div class="test-info mb-4">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <i class="fa fa-clock text-muted me-2"></i>
                                    <span class="text-muted fw-medium">
                                        {{ sprintf("%0d hour %02d minute", floor($ts->duration / 60), $ts->duration % 60) }}
                                    </span>
                                </div>
                                <div class="test-type-badge text-center">
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                        <i class="fa fa-wifi me-1"></i>ONLINE TEST
                                    </span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="text-center">
                                <a href="/user/test/{{ Session::get('subjects')->id }}/create?testid={{ $ts->id }}&REUSE=1" 
                                   class="btn btn-warning btn-lg px-4 py-3 rounded-pill shadow hover-lift text-dark fw-bold" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   title="Start Test"
                                   style="text-decoration: none; border: none; background: linear-gradient(45deg, #ffc107, #e0a800);">
                                    <i class="fa fa-edit me-2"></i>Start Test
                                </a>
                            </div>
                        @else
                            <!-- Offline Test Info -->
                            <div class="test-info mb-4">
                                <div class="test-type-badge text-center mb-3">
                                    <span class="badge bg-secondary text-white px-3 py-2 rounded-pill">
                                        <i class="fa fa-download me-1"></i>OFFLINE TEST
                                    </span>
                                </div>
                                <p class="text-muted text-center mb-0">
                                    Download and complete offline
                                </p>
                            </div>

                            <!-- Action Button -->
                            <div class="text-center">
                                <a href="{{ Storage::disk('linode')->url($ts->content) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-warning btn-lg px-4 py-3 rounded-pill shadow hover-lift fw-bold" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   title="Download Test"
                                   style="text-decoration: none; border: 2px solid #ffc107; color: #e0a800;">
                                    <i class="fa fa-download me-2"></i>Download
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Card Hover Effect -->
                    <div class="test-card-overlay"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.test-card {
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    min-height: 420px;
    display: flex;
    flex-direction: column;
}

.test-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-color: #ffc107;
}

.test-card-header {
    background: linear-gradient(135deg, #fffef7 0%, #ffffff 100%);
    border-bottom: 1px solid #e9ecef;
    border-radius: 20px 20px 0 0;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.test-card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 200px;
}

.test-title {
    font-size: 1.2rem;
    line-height: 1.4;
    color: #2d3748;
    font-weight: 700 !important;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 3rem;
}

.hover-lift {
    transition: all 0.3s ease !important;
}

.hover-lift:hover {
    transform: translateY(-3px) !important;
}

.btn-warning.hover-lift:hover {
    box-shadow: 0 15px 30px rgba(255, 193, 7, 0.5) !important;
}

.btn-outline-warning.hover-lift:hover {
    box-shadow: 0 15px 30px rgba(255, 193, 7, 0.4) !important;
}

.test-icon {
    transition: transform 0.3s ease;
}

.test-card:hover .test-icon {
    transform: scale(1.15);
}

.test-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.05) 0%, rgba(255, 193, 7, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 20px;
    pointer-events: none;
}

.test-card:hover .test-card-overlay {
    opacity: 1;
}

/* Button enhancements */
.btn {
    font-weight: 600 !important;
    letter-spacing: 0.5px;
    transition: all 0.3s ease !important;
}

.btn-warning {
    background: linear-gradient(45deg, #ffc107, #e0a800) !important;
    border: none !important;
    color: #212529 !important;
}

.btn-warning:hover {
    background: linear-gradient(45deg, #e0a800, #d39e00) !important;
    color: #212529 !important;
    transform: translateY(-2px);
}

.btn-outline-warning {
    border: 2px solid #ffc107 !important;
    color: #e0a800 !important;
    background: transparent !important;
}

.btn-outline-warning:hover {
    background: #ffc107 !important;
    color: #212529 !important;
    border-color: #ffc107 !important;
    transform: translateY(-2px);
}

/* Badge improvements */
.badge {
    font-weight: 600 !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.5px;
}

@media (max-width: 576px) {
    .test-card {
        margin-bottom: 1.5rem;
    }
    
    .test-title {
        font-size: 1.1rem;
    }
    
    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1rem;
    }
    
    .test-icon i {
        font-size: 3rem !important;
    }
}

/* Fix for button visibility */
.btn-lg {
    padding: 12px 30px !important;
    font-size: 1.1rem !important;
    min-height: 50px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}
</style>