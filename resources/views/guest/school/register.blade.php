<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Sekolah - Platform E-Tuisyen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('css/student-friendly.css') }}" rel="stylesheet">
    <style>
        /* Page-specific styles for school registration */
        .sf-progress-container {
            background: linear-gradient(135deg, var(--sf-sky-light), rgba(189, 224, 254, 0.3));
            padding: 2.5rem 1rem;
            border-bottom: 2px dashed var(--sf-sky-medium);
        }

        .sf-progress-container .sf-progress-steps {
            display: flex !important;
            justify-content: center !important;
            align-items: flex-start !important;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            gap: 0 !important;
        }

        /* Connecting line behind all steps */
        .sf-progress-container .sf-progress-steps::before {
            content: '';
            position: absolute;
            top: 28px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 2px;
            background: #d1d5db;
            z-index: 1;
        }

        .sf-progress-container .sf-progress-steps .sf-step {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            position: relative;
            flex: 1;
            z-index: 2;
            max-width: 180px;
            width: auto !important;
            height: auto !important;
            background: transparent !important;
            border-radius: 0 !important;
        }

        .sf-progress-container .sf-step-circle {
            width: 56px !important;
            height: 56px !important;
            border-radius: 50% !important;
            background: white !important;
            border: 2px solid #d1d5db !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 700 !important;
            font-size: 1.25rem !important;
            color: #9ca3af !important;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 10;
        }

        .sf-progress-container .sf-step.active .sf-step-circle {
            background: linear-gradient(135deg, #7c3aed, #6366f1) !important;
            color: white !important;
            border-color: #7c3aed !important;
            transform: scale(1.08);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.35);
        }

        .sf-progress-container .sf-step.completed .sf-step-circle {
            background: linear-gradient(135deg, #7c3aed, #6366f1) !important;
            color: white !important;
            border-color: #7c3aed !important;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .sf-progress-container .sf-step-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.875rem;
            text-align: center;
            transition: all 0.3s ease;
            line-height: 1.3;
        }

        .sf-progress-container .sf-step.active .sf-step-label {
            color: #7c3aed;
            font-weight: 700;
        }

        .sf-progress-container .sf-step.completed .sf-step-label {
            color: #7c3aed;
        }

        /* Form sections */
        .sf-form-section {
            display: none;
            opacity: 0;
        }

        .sf-form-section.active {
            display: block;
            opacity: 1;
            animation: sf-fadeUp 0.5s ease forwards;
        }

        /* Feature highlight boxes */
        .sf-feature-box {
            background: var(--sf-sky-light);
            border: 2px solid var(--sf-sky-medium);
            border-left: 5px solid var(--sf-ocean-bright);
            border-radius: var(--sf-radius-lg);
            padding: 1.75rem;
            margin-bottom: 2rem;
        }

        .sf-feature-box.sf-green {
            background: rgba(167, 232, 200, 0.15);
            border-color: var(--sf-mint-soft);
            border-left-color: var(--sf-mint-fresh);
        }

        .sf-feature-box-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 1rem;
        }

        .sf-feature-box-title i {
            font-size: 1.3rem;
        }

        .sf-feature-box.sf-green .sf-feature-box-title i {
            color: var(--sf-mint-fresh);
        }

        /* Upload area */
        .sf-upload-area {
            border: 3px dashed var(--sf-sky-medium);
            border-radius: var(--sf-radius-xl);
            padding: 3rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, rgba(232, 244, 252, 0.5), rgba(189, 224, 254, 0.2));
            transition: var(--sf-transition-smooth);
            cursor: pointer;
        }

        .sf-upload-area:hover {
            border-color: var(--sf-ocean-bright);
            background: linear-gradient(135deg, rgba(91, 164, 230, 0.08), rgba(189, 224, 254, 0.15));
            transform: translateY(-3px);
            box-shadow: var(--sf-shadow-md);
        }

        .sf-upload-area.dragover {
            border-color: var(--sf-mint-fresh);
            background: rgba(167, 232, 200, 0.15);
            transform: translateY(-5px) scale(1.01);
        }

        .sf-upload-icon {
            font-size: 3.5rem;
            color: var(--sf-ocean-bright);
            margin-bottom: 1rem;
        }

        .sf-upload-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--sf-text-dark);
            margin-bottom: 0.5rem;
        }

        /* Template download box */
        .sf-template-download {
            background: linear-gradient(135deg, var(--sf-mint-fresh), var(--sf-mint-deep));
            color: white;
            padding: 1.75rem;
            border-radius: var(--sf-radius-xl);
            margin-bottom: 1.5rem;
            text-align: center;
            box-shadow: 0 8px 30px rgba(107, 203, 158, 0.3);
        }

        .sf-template-download h5 {
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .sf-template-download p {
            opacity: 0.95;
            margin-bottom: 1rem;
        }

        /* Student card */
        .sf-student-card {
            background: white;
            border: 2px solid var(--sf-sky-medium);
            border-radius: var(--sf-radius-xl);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            box-shadow: var(--sf-shadow-sm);
            transition: var(--sf-transition-normal);
        }

        .sf-student-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--sf-ocean-bright), var(--sf-mint-fresh));
            border-radius: var(--sf-radius-xl) var(--sf-radius-xl) 0 0;
        }

        .sf-student-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--sf-shadow-md);
            border-color: var(--sf-ocean-soft);
        }

        .sf-student-card-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            color: var(--sf-text-dark);
            margin-bottom: 1.25rem;
        }

        .sf-student-card-title i {
            color: var(--sf-ocean-bright);
        }

        .sf-remove-student {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, var(--sf-danger), #dc4545);
            color: white;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--sf-transition-normal);
            box-shadow: 0 4px 10px rgba(239, 107, 107, 0.3);
        }

        .sf-remove-student:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 6px 15px rgba(239, 107, 107, 0.4);
        }

        /* Navigation buttons */
        .sf-nav-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: var(--sf-sky-light);
            border-top: 2px dashed var(--sf-sky-medium);
        }

        /* Excel data table */
        .sf-excel-table {
            background: white;
            border-radius: var(--sf-radius-lg);
            box-shadow: var(--sf-shadow-md);
            overflow: hidden;
            margin-top: 1rem;
        }

        .sf-excel-table .table {
            margin: 0;
        }

        .sf-excel-table .table thead th {
            background: linear-gradient(135deg, var(--sf-ocean-bright), var(--sf-ocean-soft));
            color: white;
            font-weight: 700;
            border: none;
            padding: 0.875rem 0.75rem;
            font-size: 0.85rem;
            text-align: center;
            white-space: nowrap;
        }

        .sf-excel-table .table tbody td {
            padding: 0.65rem 0.75rem;
            border-color: var(--sf-sky-light);
            font-size: 0.85rem;
            vertical-align: middle;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sf-excel-table .table tbody tr:nth-child(odd) {
            background: var(--sf-cream-soft);
        }

        .sf-excel-table .table tbody tr:hover {
            background: rgba(91, 164, 230, 0.08);
        }

        .sf-data-summary {
            background: linear-gradient(135deg, var(--sf-mint-fresh), var(--sf-mint-deep));
            color: white;
            padding: 1rem 1.25rem;
            border-radius: var(--sf-radius-md);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
        }

        /* Success section styles */
        .sf-success-container {
            text-align: center;
            padding: 3rem 2rem;
        }

        .sf-success-icon {
            font-size: 5rem;
            color: var(--sf-mint-fresh);
            margin-bottom: 1.5rem;
            animation: sf-bounce-gentle 2s ease-in-out infinite;
        }

        .sf-success-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 1rem;
        }

        .sf-success-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            max-width: 700px;
            margin: 2rem auto;
        }

        .sf-success-step {
            background: white;
            border-radius: var(--sf-radius-lg);
            padding: 1.5rem;
            box-shadow: var(--sf-shadow-sm);
            border: 2px solid var(--sf-sky-light);
            transition: var(--sf-transition-normal);
        }

        .sf-success-step:hover {
            transform: translateY(-3px);
            box-shadow: var(--sf-shadow-md);
        }

        .sf-success-step-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .sf-success-step:nth-child(1) .sf-success-step-icon { color: var(--sf-ocean-bright); }
        .sf-success-step:nth-child(2) .sf-success-step-icon { color: var(--sf-mint-fresh); }
        .sf-success-step:nth-child(3) .sf-success-step-icon { color: var(--sf-sunshine); }

        .sf-success-step h5 {
            font-weight: 700;
            color: var(--sf-text-dark);
            margin-bottom: 0.5rem;
        }

        .sf-success-step p {
            font-size: 0.9rem;
            color: var(--sf-text-soft);
            margin: 0;
        }

        .sf-next-steps {
            background: var(--sf-sky-light);
            border-radius: var(--sf-radius-lg);
            padding: 1.5rem;
            max-width: 600px;
            margin: 2rem auto;
            text-align: left;
            border: 2px solid var(--sf-sky-medium);
        }

        .sf-next-steps h4 {
            font-weight: 700;
            color: var(--sf-text-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sf-next-steps ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sf-next-steps li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            color: var(--sf-text-warm);
            font-weight: 500;
        }

        .sf-next-steps li i {
            width: 20px;
            text-align: center;
        }

        /* Loading overlay */
        .sf-loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .sf-loading-spinner {
            background: white;
            padding: 2.5rem;
            border-radius: var(--sf-radius-xl);
            text-align: center;
            box-shadow: var(--sf-shadow-xl);
        }

        .sf-loading-spinner .spinner-border {
            color: var(--sf-ocean-bright);
            width: 3rem;
            height: 3rem;
        }

        /* Verified badge */
        .sf-verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: var(--sf-mint-soft);
            color: var(--sf-mint-deep);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: var(--sf-radius-full);
            margin-left: 0.5rem;
        }

        .sf-readonly-input {
            background-color: var(--sf-sky-light) !important;
            color: var(--sf-ocean-deep) !important;
            font-weight: 600 !important;
        }

        /* Print styles */
        @media print {
            body { background: white !important; }
            .sf-bg-pattern, .sf-floating-shapes, .sf-hero, .sf-language-switcher, .sf-nav-buttons, .sf-loading-overlay { display: none !important; }
            .sf-main-container { box-shadow: none !important; border: 1px solid #ccc !important; margin: 0 !important; }
            .print-only { display: block !important; }
            .screen-only { display: none !important; }
        }

        .print-only { display: none; }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .sf-progress-container .sf-progress-steps {
                flex-direction: row !important;
                justify-content: center !important;
                gap: 0 !important;
                padding: 0 1rem;
            }

            .sf-progress-container .sf-progress-steps::before {
                width: 50%;
                top: 22px;
            }

            .sf-progress-container .sf-progress-steps .sf-step {
                max-width: 110px;
            }

            .sf-progress-container .sf-step-circle {
                width: 44px !important;
                height: 44px !important;
                font-size: 1rem !important;
            }

            .sf-progress-container .sf-step-label {
                font-size: 0.75rem;
            }

            .sf-nav-buttons {
                flex-direction: column;
                gap: 1rem;
                padding: 1.5rem;
            }

            .sf-success-steps {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .sf-progress-container .sf-progress-steps::before {
                width: 45%;
            }

            .sf-progress-container .sf-progress-steps .sf-step {
                max-width: 90px;
            }

            .sf-progress-container .sf-step-circle {
                width: 40px !important;
                height: 40px !important;
                font-size: 0.9rem !important;
            }

            .sf-progress-container .sf-step-label {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body class="sf-body">
    <!-- Background Pattern -->
    <div class="sf-bg-pattern"></div>
    
    <!-- Floating Shapes -->
    <div class="sf-floating-shapes">
        <div class="sf-shape sf-shape-1"></div>
        <div class="sf-shape sf-shape-2"></div>
        <div class="sf-shape sf-shape-3"></div>
    </div>

    <!-- Loading Overlay -->
    <div class="sf-loading-overlay" id="loadingOverlay">
        <div class="sf-loading-spinner">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 mb-0 fw-bold" style="color: var(--sf-text-dark);">Memproses pendaftaran anda...</p>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="sf-hero">
        <!-- Language Switcher -->
        <div class="sf-language-switcher">
            <div class="sf-language-selector">
                <div class="sf-language-option active" data-lang="ms">
                    <i class="fas fa-globe-asia"></i>
                    <span>BM</span>
                </div>
                <div class="sf-language-option" data-lang="en">
                    <i class="fas fa-globe"></i>
                    <span>EN</span>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="sf-hero-content">
                <div class="sf-logo-row" style="display: flex; align-items: center; justify-content: center; gap: 1.25rem; margin: 0 auto 1.5rem; animation: sf-bounce-vertical 3s ease-in-out infinite;">
                    <img src="{{ asset('assets/images/logo/pkibs.png') }}" alt="PIBKS Logo" style="height: 60px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));">
                    <img src="{{ asset('assets/images/logo/Kolej-UNITI.png') }}" alt="UNITI Logo" style="height: 60px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));">
                </div>
                <p class="sf-hero-greeting" data-key="hero.greeting">Pendaftaran Sekolah</p>
                <h1 class="sf-hero-title" data-key="hero.title">
                    Daftar Sekolah Anda 🏫
                </h1>
                <p class="sf-hero-subtitle" data-key="hero.subtitle">
                    Daftarkan sekolah dan pelajar anda dengan mudah. Nikmati platform pembelajaran dalam talian yang terbaik!
                </p>
                <div class="sf-hero-features">
                    <div class="sf-hero-feature">
                        <i class="fas fa-rocket"></i>
                        <span data-key="hero.features.setup">Persediaan Pantas</span>
                    </div>
                    <div class="sf-hero-feature">
                        <i class="fas fa-users"></i>
                        <span data-key="hero.features.import">Import Berkelompok</span>
                    </div>
                    <div class="sf-hero-feature">
                        <i class="fas fa-shield-alt"></i>
                        <span data-key="hero.features.secure">Selamat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Registration Container -->
    <div class="container" style="position: relative; z-index: 1; padding: 0 1rem 3rem;">
        @if(session('success'))
            <!-- Success State -->
            <div class="sf-main-container sf-fade-in">
                <div class="sf-success-container">
                    <div class="sf-success-icon screen-only">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    
                    <h2 class="sf-success-title" data-key="success.title">Pendaftaran Berjaya! 🎉</h2>

                    <div class="sf-alert sf-alert-success" style="max-width: 600px; margin: 0 auto 2rem;">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>

                    <div class="sf-success-steps">
                        <div class="sf-success-step">
                            <div class="sf-success-step-icon">
                                <i class="fas fa-school"></i>
                            </div>
                            <h5 data-key="success.step1.title">Sekolah Diaktifkan</h5>
                            <p data-key="success.step1.desc">Sekolah anda telah berjaya diaktifkan dalam sistem kami</p>
                        </div>
                        <div class="sf-success-step">
                            <div class="sf-success-step-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 data-key="success.step2.title">Pelajar Didaftarkan</h5>
                            <p data-key="success.step2.desc">Akaun pelajar telah dicipta dengan kata laluan default</p>
                        </div>
                        <div class="sf-success-step">
                            <div class="sf-success-step-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 data-key="success.step3.title">E-mel Pengesahan</h5>
                            <p data-key="success.step3.desc">Maklumat login akan dihantar ke e-mel anda</p>
                        </div>
                    </div>

                    <div class="sf-next-steps">
                        <h4><i class="fas fa-list-check"></i> <span data-key="success.next.title">Langkah Seterusnya:</span></h4>
                        <ul>
                            <li><i class="fas fa-clock" style="color: var(--sf-ocean-bright);"></i> <span data-key="success.next.step1">Tunggu e-mel pengesahan dalam masa 24-48 jam</span></li>
                            <li><i class="fas fa-key" style="color: var(--sf-mint-fresh);"></i> <span data-key="success.next.step2">Kongsikan maklumat login dengan pelajar</span></li>
                            <li><i class="fas fa-rocket" style="color: var(--sf-coral-warm);"></i> <span data-key="success.next.step3">Mula gunakan platform setelah kelulusan</span></li>
                        </ul>
                    </div>

                    <div class="sf-contact-info" style="max-width: 500px; margin: 0 auto;">
                        <div class="sf-contact-item">
                            <i class="fas fa-envelope"></i>
                            <span data-key="success.contact.email">etuition@uniti.edu.my</span>
                        </div>
                        <div class="sf-contact-item">
                            <i class="fas fa-phone"></i>
                            <span data-key="success.contact.phone">+60 12-317 3853</span>
                        </div>
                    </div>

                    <div class="mt-4 screen-only">
                        <a href="{{ url('/') }}" class="sf-btn sf-btn-primary">
                            <i class="fas fa-home"></i>
                            <span data-key="success.btn.home">Kembali ke Laman Utama</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Notification Messages -->
            @if(session('auth_success'))
                <div class="sf-alert sf-alert-success sf-fade-in mb-3">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('auth_success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="sf-alert sf-alert-danger sf-fade-in mb-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="sf-alert sf-alert-danger sf-fade-in mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Sila betulkan ralat berikut:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <div class="sf-main-container sf-fade-in">
                <!-- Progress Bar -->
                <div class="sf-progress-container">
                    <div class="sf-progress-steps">
                        <div class="sf-step active" data-step="1">
                            <div class="sf-step-circle">1</div>
                            <span class="sf-step-label" data-key="steps.school">Butiran Sekolah</span>
                        </div>
                        <div class="sf-step" data-step="2">
                            <div class="sf-step-circle">2</div>
                            <span class="sf-step-label" data-key="steps.students">Tambah Pelajar</span>
                        </div>
                        <div class="sf-step" data-step="3">
                            <div class="sf-step-circle">3</div>
                            <span class="sf-step-label" data-key="steps.review">Semak & Hantar</span>
                        </div>
                    </div>
                </div>

                <!-- Registration Form -->
                <form id="registrationForm" method="POST" action="{{ route('school.register.submit') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Step 1: School Details -->
                    <div class="sf-form-section active" id="step1">
                        <div class="sf-form-section-inner" style="padding: 2.5rem 2rem;">
                            <div class="sf-section-header">
                                <div class="sf-section-icon sf-blue">
                                    <i class="fas fa-school"></i>
                                </div>
                                <h2 class="sf-section-title" data-key="form.school.title">Maklumat Sekolah</h2>
                            </div>
                            <p class="sf-section-description" data-key="form.school.description">
                                Sila berikan maklumat asas sekolah anda untuk memulakan dengan platform kami.
                            </p>

                            <!-- School Information -->
                            <div class="sf-feature-box">
                                <div class="sf-feature-box-title">
                                    <i class="fas fa-building" style="color: var(--sf-ocean-bright);"></i>
                                    <span data-key="form.school.info_title">Maklumat Sekolah</span>
                                </div>
                                
                                <div class="row">
                                    @if(!isset($authenticatedCoordinator))
                                        <div class="col-md-6">
                                            <div class="sf-form-group">
                                                <label class="sf-form-label">
                                                    <span data-key="form.school.name">Nama Sekolah</span> 
                                                    <span class="sf-required">*</span>
                                                </label>
                                                <select name="school_id" id="schoolSelect" class="sf-form-control" required>
                                                    <option value="" data-key="form.school.name_placeholder">Pilih sekolah anda</option>
                                                    @foreach($schools as $school)
                                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="school_id" value="{{ $authenticatedCoordinator['school_id'] }}">
                                        <div class="col-md-6">
                                            <div class="sf-form-group">
                                                <label class="sf-form-label">
                                                    <span data-key="form.school.name">Nama Sekolah</span>
                                                    <span class="sf-verified-badge"><i class="fas fa-shield-alt"></i> Disahkan</span>
                                                </label>
                                                <input type="text" 
                                                       class="sf-form-control sf-readonly-input" 
                                                       value="{{ $authenticatedCoordinator['school_name'] }}"
                                                       readonly>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="sf-form-group">
                                            <label class="sf-form-label">
                                                <span data-key="form.school.phone">Telefon Hubungan</span> 
                                                <span class="sf-required">*</span>
                                            </label>
                                            <input type="tel" name="phone" class="sf-form-control" placeholder="+60 12-345 6789" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="sf-form-group">
                                            <label class="sf-form-label">
                                                <span data-key="form.school.email">Alamat E-mel Sekolah</span> 
                                                <span class="sf-required">*</span>
                                            </label>
                                            <input type="email" name="school_email" class="sf-form-control" placeholder="sekolah@contoh.com" value="{{ old('school_email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="sf-form-group">
                                            <label class="sf-form-label">
                                                <span data-key="form.school.type">Jenis Sekolah</span> 
                                                <span class="sf-required">*</span>
                                            </label>
                                            <select name="school_type" class="sf-form-control" id="schoolTypeSelect" required>
                                                <option value="" data-key="form.school.type_placeholder">Pilih jenis sekolah</option>
                                                <option value="public" data-key="form.school.types.public" {{ old('school_type') == 'public' ? 'selected' : '' }}>Sekolah Kerajaan</option>
                                                <option value="private" data-key="form.school.types.private" {{ old('school_type') == 'private' ? 'selected' : '' }}>Sekolah Swasta</option>
                                                <option value="charter" data-key="form.school.types.charter" {{ old('school_type') == 'charter' ? 'selected' : '' }}>Sekolah Piagam</option>
                                                <option value="international" data-key="form.school.types.international" {{ old('school_type') == 'international' ? 'selected' : '' }}>Sekolah Antarabangsa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="sf-form-group">
                                            <label class="sf-form-label">
                                                <span data-key="form.school.address">Alamat Sekolah</span> 
                                                <span class="sf-required">*</span>
                                            </label>
                                            <textarea name="address" class="sf-form-control" rows="3" placeholder="Masukkan alamat lengkap sekolah" required>{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sf-form-group">
                                            <label class="sf-form-label">
                                                <span data-key="form.school.total_students">Jumlah Pelajar</span>
                                            </label>
                                            <input type="number" name="total_students" class="sf-form-control" placeholder="cth: 500" min="1" value="{{ old('total_students') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Teacher Coordinator -->
                            <div class="sf-feature-box sf-green">
                                <div class="sf-feature-box-title">
                                    <i class="fas fa-user-tie"></i>
                                    <span data-key="form.teacher.title">Guru Pembimbing</span>
                                </div>
                                
                                @if(isset($authenticatedCoordinator))
                                    <div class="sf-alert sf-alert-success mb-3">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Maklumat penyelaras telah disahkan dan diisi secara automatik.</span>
                                    </div>
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="sf-form-group">
                                            <label class="sf-form-label">
                                                <span data-key="form.teacher.name">Nama Guru Pembimbing</span> 
                                                <span class="sf-required">*</span>
                                                @if(isset($authenticatedCoordinator))
                                                    <span class="sf-verified-badge"><i class="fas fa-shield-alt"></i> Disahkan</span>
                                                @endif
                                            </label>
                                            <input type="text" 
                                                   name="teacher_name" 
                                                   class="sf-form-control @if(isset($authenticatedCoordinator)) sf-readonly-input @endif" 
                                                   placeholder="Nama penuh guru pembimbing" 
                                                   value="{{ isset($authenticatedCoordinator) ? $authenticatedCoordinator['name'] : old('teacher_name') }}"
                                                   @if(isset($authenticatedCoordinator)) readonly @endif
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="sf-form-group">
                                            <label class="sf-form-label">
                                                <span data-key="form.teacher.email">E-mel Guru Pembimbing</span> 
                                                <span class="sf-required">*</span>
                                                @if(isset($authenticatedCoordinator))
                                                    <span class="sf-verified-badge"><i class="fas fa-shield-alt"></i> Disahkan</span>
                                                @endif
                                            </label>
                                            <input type="email" 
                                                   name="teacher_email" 
                                                   class="sf-form-control @if(isset($authenticatedCoordinator)) sf-readonly-input @endif" 
                                                   placeholder="guru@contoh.com" 
                                                   value="{{ isset($authenticatedCoordinator) ? $authenticatedCoordinator['email'] : old('teacher_email') }}"
                                                   @if(isset($authenticatedCoordinator)) readonly @endif
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Add Students -->
                    <div class="sf-form-section" id="step2">
                        <div class="sf-form-section-inner" style="padding: 2.5rem 2rem;">
                            <div class="sf-section-header">
                                <div class="sf-section-icon sf-green">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h2 class="sf-section-title" data-key="form.students.title">Pengurusan Pelajar</h2>
                            </div>
                            <p class="sf-section-description" data-key="form.students.description">
                                Tambah pelajar secara individu atau muat naik secara berkelompok menggunakan template Excel kami.
                            </p>

                            <!-- Bulk Upload Section -->
                            <div class="sf-feature-box">
                                <div class="sf-feature-box-title">
                                    <i class="fas fa-file-excel" style="color: var(--sf-mint-fresh);"></i>
                                    <span data-key="form.bulk.title">Muat Naik Pelajar Berkelompok</span>
                                </div>
                                <p class="text-muted mb-3" data-key="form.bulk.description">Jimat masa dengan memuat naik berbilang pelajar sekaligus menggunakan template Excel kami.</p>
                                
                                <div class="sf-template-download">
                                    <h5><i class="fas fa-download"></i> <span data-key="form.bulk.template_title">Muat Turun Template Excel</span></h5>
                                    <p data-key="form.bulk.template_description">Muat turun template Excel yang telah diformat untuk menambah maklumat pelajar anda</p>
                                    <button type="button" class="sf-btn" style="background: white; color: var(--sf-mint-deep);" id="downloadTemplate">
                                        <i class="fas fa-file-excel"></i> <span data-key="form.bulk.download_btn">Muat Turun Template</span>
                                    </button>
                                </div>

                                <div class="sf-upload-area" id="uploadArea">
                                    <div class="sf-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <h4 class="sf-upload-title" data-key="form.bulk.drag_title">Seret & Lepas Fail Excel Di Sini</h4>
                                    <p class="text-muted" data-key="form.bulk.browse_text">atau klik untuk cari fail</p>
                                    <p class="small text-muted" data-key="form.bulk.format_info">Format disokong: .xlsx, .xls (Saiz maksimum: 10MB)</p>
                                    <input type="file" name="students_excel" id="excelFile" accept=".xlsx,.xls" style="display: none;">
                                </div>

                                <div id="uploadProgress" class="mt-3" style="display: none;">
                                    <div class="progress" style="height: 8px; border-radius: 4px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%; background: var(--sf-ocean-bright);"></div>
                                    </div>
                                    <p class="mt-2 text-center fw-semibold" style="color: var(--sf-ocean-bright);" data-key="form.bulk.processing">Memproses fail Excel...</p>
                                </div>

                                <div id="uploadResults" class="mt-3" style="display: none;"></div>
                            </div>

                            <!-- Individual Student Addition -->
                            <div class="mt-4">
                                <div class="sf-feature-box-title">
                                    <i class="fas fa-user-plus" style="color: var(--sf-ocean-bright);"></i>
                                    <span data-key="form.individual.title">Tambah Pelajar Individu</span>
                                </div>
                                <p class="text-muted mb-3" data-key="form.individual.description">Tambah pelajar satu persatu menggunakan borang di bawah</p>
                                
                                <div id="studentsContainer">
                                    <!-- Individual student forms will be added here -->
                                </div>

                                <button type="button" class="sf-btn sf-btn-outline" id="addStudentBtn">
                                    <i class="fas fa-plus"></i> <span data-key="form.individual.add_btn">Tambah Pelajar</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Review & Submit -->
                    <div class="sf-form-section" id="step3">
                        <div class="sf-form-section-inner" style="padding: 2.5rem 2rem;">
                            <div class="sf-section-header">
                                <div class="sf-section-icon sf-coral">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h2 class="sf-section-title" data-key="form.review.title">Semak & Hantar</h2>
                            </div>
                            <p class="sf-section-description" data-key="form.review.description">
                                Sila semak semua maklumat sebelum menghantar pendaftaran anda.
                            </p>

                            <div id="reviewContent">
                                <!-- Review content will be populated by JavaScript -->
                            </div>

                            <div class="sf-info-box mt-4">
                                <div class="sf-info-box-header">
                                    <i class="fas fa-info-circle"></i>
                                    <span data-key="form.review.next_title">Apa yang berlaku seterusnya?</span>
                                </div>
                                <ul>
                                    <li data-key="form.review.next_1">Pasukan kami akan menyemak pendaftaran anda dalam masa 24-48 jam</li>
                                    <li data-key="form.review.next_2">Anda akan menerima e-mel pengesahan dengan butiran akaun anda</li>
                                    <li data-key="form.review.next_3">Pelajar akan mendapat maklumat log masuk individu</li>
                                    <li data-key="form.review.next_4">Anda boleh mula menggunakan platform selepas kelulusan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="sf-nav-buttons">
                        <button type="button" class="sf-btn sf-btn-outline" id="prevBtn" style="display: none;">
                            <i class="fas fa-arrow-left"></i> <span data-key="nav.previous">Sebelumnya</span>
                        </button>
                        <div></div>
                        <button type="button" class="sf-btn sf-btn-primary" id="nextBtn">
                            <span data-key="nav.next">Seterusnya</span> <i class="fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" class="sf-btn sf-btn-success sf-btn-lg" id="submitBtn" style="display: none;">
                            <i class="fas fa-paper-plane"></i> <span data-key="nav.submit">Hantar Pendaftaran</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="sf-footer">
        <div class="sf-footer-emojis">🏫 📚 ✨</div>
        <p class="sf-footer-text">Pendaftaran Sekolah - Kolej UNITI</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SheetJS for Excel reading -->
    <script src="https://unpkg.com/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    
    <script>
        // Language management
        let currentLanguage = 'ms';
        
        const translations = {
            ms: {
                'hero.greeting': 'Pendaftaran Sekolah',
                'hero.title': 'Daftar Sekolah Anda 🏫',
                'hero.subtitle': 'Daftarkan sekolah dan pelajar anda dengan mudah. Nikmati platform pembelajaran dalam talian yang terbaik!',
                'hero.features.setup': 'Persediaan Pantas',
                'hero.features.import': 'Import Berkelompok',
                'hero.features.secure': 'Selamat',
                'steps.school': 'Butiran Sekolah',
                'steps.students': 'Tambah Pelajar',
                'steps.review': 'Semak & Hantar',
                'form.school.title': 'Maklumat Sekolah',
                'form.school.description': 'Sila berikan maklumat asas sekolah anda untuk memulakan dengan platform kami.',
                'form.school.info_title': 'Maklumat Sekolah',
                'form.school.name': 'Nama Sekolah',
                'form.school.name_placeholder': 'Pilih sekolah anda',
                'form.school.phone': 'Telefon Hubungan',
                'form.school.email': 'Alamat E-mel Sekolah',
                'form.school.address': 'Alamat Sekolah',
                'form.school.type': 'Jenis Sekolah',
                'form.school.type_placeholder': 'Pilih jenis sekolah',
                'form.school.types.public': 'Sekolah Kerajaan',
                'form.school.types.private': 'Sekolah Swasta',
                'form.school.types.charter': 'Sekolah Piagam',
                'form.school.types.international': 'Sekolah Antarabangsa',
                'form.school.total_students': 'Jumlah Pelajar',
                'form.teacher.title': 'Guru Pembimbing',
                'form.teacher.name': 'Nama Guru Pembimbing',
                'form.teacher.email': 'E-mel Guru Pembimbing',
                'form.students.title': 'Pengurusan Pelajar',
                'form.students.description': 'Tambah pelajar secara individu atau muat naik secara berkelompok menggunakan template Excel kami.',
                'form.bulk.title': 'Muat Naik Pelajar Berkelompok',
                'form.bulk.description': 'Jimat masa dengan memuat naik berbilang pelajar sekaligus menggunakan template Excel kami.',
                'form.bulk.template_title': 'Muat Turun Template Excel',
                'form.bulk.template_description': 'Muat turun template Excel yang telah diformat untuk menambah maklumat pelajar anda',
                'form.bulk.download_btn': 'Muat Turun Template',
                'form.bulk.drag_title': 'Seret & Lepas Fail Excel Di Sini',
                'form.bulk.browse_text': 'atau klik untuk cari fail',
                'form.bulk.format_info': 'Format disokong: .xlsx, .xls (Saiz maksimum: 10MB)',
                'form.bulk.processing': 'Memproses fail Excel...',
                'form.bulk.file_processed': 'Berjaya memproses "{filename}" - Dijumpai {count} pelajar',
                'form.bulk.no_data': 'Fail Excel kosong atau tidak mempunyai data.',
                'form.bulk.no_students': 'Tiada data pelajar dijumpai dalam fail.',
                'form.individual.title': 'Tambah Pelajar Individu',
                'form.individual.description': 'Tambah pelajar satu persatu menggunakan borang di bawah',
                'form.individual.add_btn': 'Tambah Pelajar',
                'form.student.title': 'Pelajar',
                'form.student.name': 'Nama Pelajar',
                'form.student.ic': 'No. Kad Pengenalan',
                'form.student.email': 'E-mel',
                'form.student.phone': 'No. Telefon Pelajar',
                'form.student.grade': 'Tingkatan',
                'form.student.grade_placeholder': 'Pilih tingkatan',
                'form.student.grade.form5': 'Tingkatan 5',
                'form.review.title': 'Semak & Hantar',
                'form.review.description': 'Sila semak semua maklumat sebelum menghantar pendaftaran anda.',
                'form.review.next_title': 'Apa yang berlaku seterusnya?',
                'form.review.next_1': 'Pasukan kami akan menyemak pendaftaran anda dalam masa 24-48 jam',
                'form.review.next_2': 'Anda akan menerima e-mel pengesahan dengan butiran akaun anda',
                'form.review.next_3': 'Pelajar akan mendapat maklumat log masuk individu',
                'form.review.next_4': 'Anda boleh mula menggunakan platform selepas kelulusan',
                'nav.previous': 'Sebelumnya',
                'nav.next': 'Seterusnya',
                'nav.submit': 'Hantar Pendaftaran',
                'validation.students_required': 'Sila tambah pelajar sama ada secara individu atau muat naik fail Excel.',
                'validation.students_required_step': 'Sila tambah pelajar sama ada secara individu atau muat naik fail Excel sebelum meneruskan.',
                'validation.required_fields': 'Sila lengkapkan semua medan yang diperlukan sebelum meneruskan.',
                'success.title': 'Pendaftaran Berjaya! 🎉',
                'success.step1.title': 'Sekolah Diaktifkan',
                'success.step1.desc': 'Sekolah anda telah berjaya diaktifkan dalam sistem kami',
                'success.step2.title': 'Pelajar Didaftarkan',
                'success.step2.desc': 'Akaun pelajar telah dicipta dengan kata laluan default',
                'success.step3.title': 'E-mel Pengesahan',
                'success.step3.desc': 'Maklumat login akan dihantar ke e-mel anda',
                'success.next.title': 'Langkah Seterusnya:',
                'success.next.step1': 'Tunggu e-mel pengesahan dalam masa 24-48 jam',
                'success.next.step2': 'Kongsikan maklumat login dengan pelajar',
                'success.next.step3': 'Mula gunakan platform setelah kelulusan',
                'success.btn.home': 'Kembali ke Laman Utama'
            },
            en: {
                'hero.greeting': 'School Registration',
                'hero.title': 'Register Your School 🏫',
                'hero.subtitle': 'Register your school and students easily. Enjoy the best online learning platform!',
                'hero.features.setup': 'Quick Setup',
                'hero.features.import': 'Bulk Import',
                'hero.features.secure': 'Secure',
                'steps.school': 'School Details',
                'steps.students': 'Add Students',
                'steps.review': 'Review & Submit',
                'form.school.title': 'School Information',
                'form.school.description': 'Please provide your school\'s basic information to get started.',
                'form.school.info_title': 'School Information',
                'form.school.name': 'School Name',
                'form.school.name_placeholder': 'Select your school',
                'form.school.phone': 'Contact Phone',
                'form.school.email': 'School Email Address',
                'form.school.address': 'School Address',
                'form.school.type': 'School Type',
                'form.school.type_placeholder': 'Select school type',
                'form.school.types.public': 'Public School',
                'form.school.types.private': 'Private School',
                'form.school.types.charter': 'Charter School',
                'form.school.types.international': 'International School',
                'form.school.total_students': 'Total Students',
                'form.teacher.title': 'Teacher Coordinator',
                'form.teacher.name': 'Coordinator Name',
                'form.teacher.email': 'Coordinator Email',
                'form.students.title': 'Student Management',
                'form.students.description': 'Add students individually or upload them in bulk using our Excel template.',
                'form.bulk.title': 'Bulk Student Upload',
                'form.bulk.description': 'Save time by uploading multiple students at once using our Excel template.',
                'form.bulk.template_title': 'Download Excel Template',
                'form.bulk.template_description': 'Download our pre-formatted Excel template to add your students\' information',
                'form.bulk.download_btn': 'Download Template',
                'form.bulk.drag_title': 'Drag & Drop Excel File Here',
                'form.bulk.browse_text': 'or click to browse files',
                'form.bulk.format_info': 'Supported formats: .xlsx, .xls (Max size: 10MB)',
                'form.bulk.processing': 'Processing Excel file...',
                'form.bulk.file_processed': 'Successfully processed "{filename}" - Found {count} students',
                'form.bulk.no_data': 'Excel file is empty or contains no data.',
                'form.bulk.no_students': 'No student data found in the file.',
                'form.individual.title': 'Add Individual Students',
                'form.individual.description': 'Add students one by one using the form below',
                'form.individual.add_btn': 'Add Student',
                'form.student.title': 'Student',
                'form.student.name': 'Student Name',
                'form.student.ic': 'IC Number',
                'form.student.email': 'Email',
                'form.student.phone': 'Student Phone',
                'form.student.grade': 'Tingkatan',
                'form.student.grade_placeholder': 'Select tingkatan',
                'form.student.grade.form5': 'Tingkatan 5',
                'form.review.title': 'Review & Submit',
                'form.review.description': 'Please review all information before submitting your registration.',
                'form.review.next_title': 'What happens next?',
                'form.review.next_1': 'Our team will review your registration within 24-48 hours',
                'form.review.next_2': 'You\'ll receive an email confirmation with your account details',
                'form.review.next_3': 'Students will get individual login credentials',
                'form.review.next_4': 'You can start using the platform after approval',
                'nav.previous': 'Previous',
                'nav.next': 'Next',
                'nav.submit': 'Submit Registration',
                'validation.students_required': 'Please add students either individually or by uploading an Excel file.',
                'validation.students_required_step': 'Please add students either individually or by uploading an Excel file before proceeding.',
                'validation.required_fields': 'Please fill in all required fields before proceeding.',
                'success.title': 'Registration Successful! 🎉',
                'success.step1.title': 'School Activated',
                'success.step1.desc': 'Your school has been successfully activated in our system',
                'success.step2.title': 'Students Registered',
                'success.step2.desc': 'Student accounts have been created with default passwords',
                'success.step3.title': 'Confirmation Email',
                'success.step3.desc': 'Login information will be sent to your email',
                'success.next.title': 'Next Steps:',
                'success.next.step1': 'Wait for confirmation email within 24-48 hours',
                'success.next.step2': 'Share login information with students',
                'success.next.step3': 'Start using the platform after approval',
                'success.btn.home': 'Back to Home'
            }
        };

        function switchLanguage(lang) {
            currentLanguage = lang;
            
            document.querySelectorAll('.sf-language-option').forEach(option => {
                option.classList.remove('active');
                if (option.dataset.lang === lang) {
                    option.classList.add('active');
                }
            });
            
            document.querySelectorAll('[data-key]').forEach(element => {
                const key = element.dataset.key;
                if (translations[lang] && translations[lang][key]) {
                    element.textContent = translations[lang][key];
                }
            });
            
            document.querySelectorAll('#schoolTypeSelect option[data-key]').forEach(option => {
                const key = option.dataset.key;
                if (translations[lang] && translations[lang][key]) {
                    option.textContent = translations[lang][key];
                }
            });
            
            document.querySelectorAll('select[name*="[grade]"] option[data-key]').forEach(option => {
                const key = option.dataset.key;
                if (translations[lang] && translations[lang][key]) {
                    option.textContent = translations[lang][key];
                }
            });
            
            if (typeof initializeSchoolSelect === 'function' && $('#schoolSelect').length) {
                $('#schoolSelect').select2('destroy');
                initializeSchoolSelect();
            }
        }

        // Form step management
        let currentStep = 1;
        const totalSteps = 3;
        let students = [];
        let excelDataProcessed = false; // Track if Excel data was successfully processed
        let droppedExcelFile = null; // Store the dropped file for form submission

        // Old student data from failed validation
        const oldStudents = @json(old('students', []));
        
        // Check if there are validation errors for students
        const hasStudentErrors = {{ $errors->has('students.*') || $errors->has('students_excel') ? 'true' : 'false' }};
        
        document.addEventListener('DOMContentLoaded', function() {
            updateStepDisplay();
            setupEventListeners();
            switchLanguage('ms');
            
            // Restore old student data if validation failed
            if (oldStudents && Object.keys(oldStudents).length > 0) {
                restoreOldStudents();
                
                // If there are student errors, go to step 2
                if (hasStudentErrors) {
                    currentStep = 2;
                    updateStepDisplay();
                }
            }
        });
        
        function restoreOldStudents() {
            // Convert object to array if needed
            const studentsArray = Array.isArray(oldStudents) ? oldStudents : Object.values(oldStudents);
            
            studentsArray.forEach((studentData, index) => {
                if (studentData && (studentData.name || studentData.ic_number)) {
                    addStudentFormWithData(index, studentData);
                }
            });
        }
        
        function addStudentFormWithData(index, data) {
            const studentCard = document.createElement('div');
            studentCard.className = 'sf-student-card sf-fade-in';
            studentCard.innerHTML = `
                <button type="button" class="sf-remove-student" onclick="removeStudent(${index})">
                    <i class="fas fa-times"></i>
                </button>
                <div class="sf-student-card-title">
                    <i class="fas fa-user"></i>
                    <span data-key="form.student.title">Pelajar</span> ${index + 1}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.name">Nama Pelajar</span> <span class="sf-required">*</span></label>
                            <input type="text" name="students[${index}][name]" class="sf-form-control" placeholder="Nama penuh pelajar" value="${data.name || ''}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.ic">No. Kad Pengenalan</span> <span class="sf-required">*</span></label>
                            <input type="text" name="students[${index}][ic_number]" class="sf-form-control" placeholder="980123456789" value="${data.ic_number || ''}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.email">E-mel</span></label>
                            <input type="email" name="students[${index}][email]" class="sf-form-control" placeholder="e-mel@contoh.com" value="${data.email || ''}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.phone">No. Telefon</span></label>
                            <input type="tel" name="students[${index}][phone]" class="sf-form-control" placeholder="0123456789" value="${data.phone || ''}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.grade">Tingkatan</span> <span class="sf-required">*</span></label>
                            <select name="students[${index}][grade]" class="sf-form-control" required>
                                <option value="" data-key="form.student.grade_placeholder">Pilih tingkatan</option>
                                <option value="form5" data-key="form.student.grade.form5" ${data.grade === 'form5' ? 'selected' : ''}>Tingkatan 5</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('studentsContainer').appendChild(studentCard);
            students.push(data);
        }

        function initializeSchoolSelect() {
            const placeholder = currentLanguage === 'ms' ? 'Cari dan pilih sekolah anda...' : 'Search and select your school...';
            
            $('#schoolSelect').select2({
                placeholder: placeholder,
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '{{ route("school.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term, page: params.page };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.map(function(school) {
                                return { id: school.id, text: school.name };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            });
        }

        function setupEventListeners() {
            if ($('#schoolSelect').length) {
                initializeSchoolSelect();
            }
            
            document.querySelectorAll('.sf-language-option').forEach(option => {
                option.addEventListener('click', () => switchLanguage(option.dataset.lang));
            });
            
            document.getElementById('nextBtn')?.addEventListener('click', nextStep);
            document.getElementById('prevBtn')?.addEventListener('click', prevStep);
            document.getElementById('addStudentBtn')?.addEventListener('click', addStudentForm);
            
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('excelFile');
            
            if (uploadArea && fileInput) {
                uploadArea.addEventListener('click', () => fileInput.click());
                uploadArea.addEventListener('dragover', handleDragOver);
                uploadArea.addEventListener('dragleave', (e) => e.currentTarget.classList.remove('dragover'));
                uploadArea.addEventListener('drop', handleDrop);
                fileInput.addEventListener('change', handleFileSelect);
            }
            
            document.getElementById('downloadTemplate')?.addEventListener('click', downloadTemplate);
            document.getElementById('registrationForm')?.addEventListener('submit', handleSubmit);
        }

        function updateStepDisplay() {
            document.querySelectorAll('.sf-step').forEach((step, index) => {
                const stepNumber = index + 1;
                step.classList.remove('active', 'completed');
                
                if (stepNumber < currentStep) {
                    step.classList.add('completed');
                } else if (stepNumber === currentStep) {
                    step.classList.add('active');
                }
            });

            document.querySelectorAll('.sf-form-section').forEach((section, index) => {
                section.classList.remove('active');
                if (index + 1 === currentStep) {
                    section.classList.add('active');
                }
            });

            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');

            if (prevBtn) prevBtn.style.display = currentStep > 1 ? 'inline-flex' : 'none';
            
            if (currentStep === totalSteps) {
                if (nextBtn) nextBtn.style.display = 'none';
                if (submitBtn) submitBtn.style.display = 'inline-flex';
                populateReview();
            } else {
                if (nextBtn) nextBtn.style.display = 'inline-flex';
                if (submitBtn) submitBtn.style.display = 'none';
            }
        }

        function nextStep() {
            if (validateCurrentStep()) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStepDisplay();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStepDisplay();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function validateCurrentStep() {
            const currentSection = document.getElementById(`step${currentStep}`);
            if (!currentSection) return true;
            
            const requiredFields = currentSection.querySelectorAll('input[required], select[required], textarea[required]');
            
            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (currentStep === 2) {
                const hasIndividualStudents = document.querySelectorAll('.sf-student-card').length > 0;
                const hasExcelFile = document.getElementById('excelFile')?.files.length > 0 || excelDataProcessed;
                
                if (!hasIndividualStudents && !hasExcelFile) {
                    isValid = false;
                    alert(translations[currentLanguage]['validation.students_required_step']);
                }
            }

            if (!isValid && currentStep !== 2) {
                alert(translations[currentLanguage]['validation.required_fields']);
            }

            return isValid;
        }

        function addStudentForm() {
            const studentIndex = students.length;
            const studentCard = document.createElement('div');
            studentCard.className = 'sf-student-card sf-fade-in';
            studentCard.innerHTML = `
                <button type="button" class="sf-remove-student" onclick="removeStudent(${studentIndex})">
                    <i class="fas fa-times"></i>
                </button>
                <div class="sf-student-card-title">
                    <i class="fas fa-user"></i>
                    <span data-key="form.student.title">Pelajar</span> ${studentIndex + 1}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.name">Nama Pelajar</span> <span class="sf-required">*</span></label>
                            <input type="text" name="students[${studentIndex}][name]" class="sf-form-control" placeholder="Nama penuh pelajar" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.ic">No. Kad Pengenalan</span> <span class="sf-required">*</span></label>
                            <input type="text" name="students[${studentIndex}][ic_number]" class="sf-form-control" placeholder="980123456789" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.email">E-mel</span></label>
                            <input type="email" name="students[${studentIndex}][email]" class="sf-form-control" placeholder="e-mel@contoh.com">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.phone">No. Telefon</span></label>
                            <input type="tel" name="students[${studentIndex}][phone]" class="sf-form-control" placeholder="0123456789">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sf-form-group">
                            <label class="sf-form-label"><span data-key="form.student.grade">Tingkatan</span> <span class="sf-required">*</span></label>
                            <select name="students[${studentIndex}][grade]" class="sf-form-control" required>
                                <option value="" data-key="form.student.grade_placeholder">Pilih tingkatan</option>
                                <option value="form5" data-key="form.student.grade.form5">Tingkatan 5</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('studentsContainer').appendChild(studentCard);
            students.push({});
            setTimeout(() => switchLanguage(currentLanguage), 100);
        }

        function removeStudent(index) {
            const studentCards = document.querySelectorAll('.sf-student-card');
            if (studentCards[index]) {
                studentCards[index].remove();
                students.splice(index, 1);
                updateStudentIndexes();
            }
        }

        function updateStudentIndexes() {
            const studentCards = document.querySelectorAll('.sf-student-card');
            studentCards.forEach((card, index) => {
                const title = card.querySelector('.sf-student-card-title');
                if (title) {
                    title.innerHTML = `<i class="fas fa-user"></i> <span data-key="form.student.title">Pelajar</span> ${index + 1}`;
                }
                
                const inputs = card.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.name;
                    const newName = name.replace(/students\[\d+\]/, `students[${index}]`);
                    input.name = newName;
                });

                const removeBtn = card.querySelector('.sf-remove-student');
                if (removeBtn) removeBtn.setAttribute('onclick', `removeStudent(${index})`);
            });
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.currentTarget.classList.add('dragover');
        }

        function handleDrop(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                droppedExcelFile = files[0]; // Store the dropped file
                handleFile(files[0]);
            }
        }

        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                droppedExcelFile = null; // Clear any dropped file since we're using input
                handleFile(file);
            }
        }

        function handleFile(file) {
            if (!file.name.match(/\.(xlsx|xls)$/)) {
                alert('Sila pilih fail Excel yang sah (.xlsx atau .xls)');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('Saiz fail mestilah kurang daripada 10MB');
                return;
            }

            document.getElementById('uploadProgress').style.display = 'block';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const firstSheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheetName];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                    processExcelData(jsonData, file.name);
                } catch (error) {
                    excelDataProcessed = false;
                    droppedExcelFile = null;
                    document.getElementById('uploadProgress').style.display = 'none';
                    document.getElementById('uploadResults').style.display = 'block';
                    document.getElementById('uploadResults').innerHTML = `
                        <div class="sf-alert sf-alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Ralat membaca fail Excel: ${error.message}</span>
                        </div>
                    `;
                }
            };
            
            reader.readAsArrayBuffer(file);
        }

        function processExcelData(data, fileName) {
            document.getElementById('uploadProgress').style.display = 'none';
            document.getElementById('uploadResults').style.display = 'block';
            
            if (data.length < 2) {
                excelDataProcessed = false;
                droppedExcelFile = null;
                document.getElementById('uploadResults').innerHTML = `
                    <div class="sf-alert sf-alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>${translations[currentLanguage]['form.bulk.no_data']}</span>
                    </div>
                `;
                return;
            }
            
            const rows = data.slice(1).filter(row => row.some(cell => cell && cell.toString().trim()));
            
            if (rows.length === 0) {
                excelDataProcessed = false;
                droppedExcelFile = null;
                document.getElementById('uploadResults').innerHTML = `
                    <div class="sf-alert sf-alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>${translations[currentLanguage]['form.bulk.no_students']}</span>
                    </div>
                `;
                return;
            }
            
            // Mark that Excel data was successfully processed
            excelDataProcessed = true;
            
            let tableHTML = `
                <div class="sf-data-summary">
                    <i class="fas fa-check-circle"></i>
                    <span>${translations[currentLanguage]['form.bulk.file_processed'].replace('{filename}', fileName).replace('{count}', rows.length)}</span>
                </div>
                <div class="sf-excel-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Pelajar</th>
                                    <th>No. KP</th>
                                    <th>E-mel</th>
                                    <th>Tingkatan</th>
                                    <th>Telefon</th>
                                </tr>
                            </thead>
                            <tbody>`;
            
            rows.forEach((row) => {
                tableHTML += '<tr>';
                for (let i = 0; i < 5; i++) {
                    const cellValue = row[i] || '';
                    const displayValue = cellValue.toString().length > 25 ? 
                        cellValue.toString().substring(0, 25) + '...' : cellValue;
                    tableHTML += `<td title="${cellValue}">${displayValue}</td>`;
                }
                tableHTML += '</tr>';
            });
            
            tableHTML += `</tbody></table></div></div>`;
            
            document.getElementById('uploadResults').innerHTML = tableHTML;
        }

        function downloadTemplate() {
            window.location.href = '{{ route("school.download-template") }}';
        }

        function populateReview() {
            const form = document.getElementById('registrationForm');
            if (!form) return;
            
            const formData = new FormData(form);
            const selectedSchoolText = $('#schoolSelect option:selected').text() || 'Tidak dipilih';
            
            let reviewHTML = `
                <div class="row">
                    <div class="col-md-8">
                        <div class="sf-feature-box">
                            <div class="sf-feature-box-title">
                                <i class="fas fa-school" style="color: var(--sf-ocean-bright);"></i>
                                Maklumat Sekolah
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama Sekolah:</strong> ${selectedSchoolText}</p>
                                    <p><strong>E-mel:</strong> ${formData.get('school_email') || 'Tidak disediakan'}</p>
                                    <p><strong>Telefon:</strong> ${formData.get('phone') || 'Tidak disediakan'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Jenis:</strong> ${formData.get('school_type') || 'Tidak disediakan'}</p>
                                    <p><strong>Jumlah Pelajar:</strong> ${formData.get('total_students') || 'Tidak dinyatakan'}</p>
                                </div>
                            </div>
                            <p><strong>Alamat:</strong> ${formData.get('address') || 'Tidak disediakan'}</p>
                            
                            <hr style="border-color: var(--sf-sky-medium);">
                            <div class="sf-feature-box-title" style="margin-bottom: 0.5rem;">
                                <i class="fas fa-user-tie" style="color: var(--sf-mint-fresh);"></i>
                                Guru Pembimbing
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama:</strong> ${formData.get('teacher_name') || 'Tidak disediakan'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>E-mel:</strong> ${formData.get('teacher_email') || 'Tidak disediakan'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sf-feature-box sf-green">
                            <div class="sf-feature-box-title">
                                <i class="fas fa-users"></i>
                                Ringkasan Pelajar
                            </div>
                            <p><strong>Pelajar Individu:</strong> ${document.querySelectorAll('.sf-student-card').length}</p>
                            <p><strong>Muat Naik Excel:</strong> ${(document.getElementById('excelFile')?.files.length > 0 || excelDataProcessed) ? 'Fail dimuat naik ✅' : 'Tiada fail'}</p>
                        </div>
                    </div>
                </div>
            `;
            
            const reviewContent = document.getElementById('reviewContent');
            if (reviewContent) reviewContent.innerHTML = reviewHTML;
        }

        function handleSubmit(e) {
            document.getElementById('loadingOverlay').style.display = 'flex';
            
            const hasIndividualStudents = document.querySelectorAll('.sf-student-card').length > 0;
            const fileInputHasFile = document.getElementById('excelFile')?.files.length > 0;
            const hasExcelFile = fileInputHasFile || excelDataProcessed;
            
            if (!hasIndividualStudents && !hasExcelFile) {
                e.preventDefault();
                document.getElementById('loadingOverlay').style.display = 'none';
                alert(translations[currentLanguage]['validation.students_required']);
                return false;
            }
            
            // If file was dropped (not selected via input) and we have processed data, 
            // we need to manually submit with the dropped file
            if (!fileInputHasFile && droppedExcelFile && excelDataProcessed) {
                e.preventDefault();
                
                const form = document.getElementById('registrationForm');
                const formData = new FormData(form);
                
                // Add the dropped file to FormData
                formData.set('students_excel', droppedExcelFile);
                
                // Submit via fetch with redirect: 'manual' to prevent auto-following redirects
                // This preserves the flash session for the actual browser navigation
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    redirect: 'manual'
                })
                .then(response => {
                    // Check if it's a redirect response (type will be 'opaqueredirect' with manual mode)
                    if (response.type === 'opaqueredirect' || response.status === 302 || response.status === 301) {
                        // For manual redirect, we need to navigate to success page
                        // The flash session will be available for the browser navigation
                        window.location.href = '{{ route("school.register.success") }}';
                    } else if (response.ok) {
                        // Direct success without redirect
                        window.location.href = '{{ route("school.register.success") }}';
                    } else {
                        // Error response - reload to show errors
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loadingOverlay').style.display = 'none';
                    alert('Ralat semasa menghantar pendaftaran. Sila cuba lagi.');
                });
                
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>

