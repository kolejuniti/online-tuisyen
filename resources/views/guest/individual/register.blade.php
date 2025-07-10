<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Online Tuition Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --primary-color: #6366f1;
            --secondary-color: #4f46e5;
            --accent-color: #8b5cf6;
            --success-color: #06d6a0;
            --warning-color: #ffd60a;
            --danger-color: #ef476f;
            --light-bg: #fefefe;
            --dark-text: #0f172a;
            --gray-text: #64748b;
            --card-bg: rgba(255, 255, 255, 0.95);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --shadow-light: 0 8px 32px rgba(99, 102, 241, 0.1);
            --shadow-medium: 0 12px 40px rgba(99, 102, 241, 0.15);
            --shadow-heavy: 0 20px 60px rgba(99, 102, 241, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(99, 102, 241, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(139, 92, 246, 0.8));
            color: white;
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="50" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            opacity: 0.95;
            margin-bottom: 3rem;
            font-weight: 400;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .main-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin: -3rem auto 3rem;
            border-radius: 24px;
            box-shadow: var(--shadow-heavy);
            overflow: hidden;
            max-width: 1000px;
            position: relative;
        }

        .main-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            pointer-events: none;
        }

        .error-messages-container {
            margin-top: 2rem;
            z-index: 10;
            position: relative;
        }

        .alert {
            border-radius: 12px;
            margin-bottom: 1rem;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            z-index: 20;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-left: 4px solid #b91c1c;
        }

        .alert .btn-close {
            filter: invert(1);
        }

        .form-section {
            padding: 3rem 2.5rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02), rgba(248, 250, 252, 0.05));
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-description {
            color: var(--gray-text);
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
            line-height: 1.6;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            letter-spacing: 0.025em;
        }

        .required {
            color: var(--danger-color);
            font-weight: 700;
        }

        .form-control {
            border: 2px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 4px 20px rgba(99, 102, 241, 0.1);
            outline: none;
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }

        .form-control:hover:not(:focus) {
            border-color: rgba(99, 102, 241, 0.5);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .btn-custom {
            padding: 1rem 2.5rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.025em;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .submit-button-container {
            margin-top: 3rem !important;
            padding-top: 2rem !important;
        }



        .feature-highlight {
            background: linear-gradient(135deg, rgba(221, 214, 254, 0.8), rgba(224, 231, 255, 0.6));
            backdrop-filter: blur(10px);
            border: none;
            border-left: 6px solid var(--primary-color);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.1);
            position: relative;
            overflow: hidden;
        }

        .feature-highlight::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.03));
            pointer-events: none;
        }

        .feature-highlight h4 {
            color: var(--dark-text);
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .feature-highlight p {
            position: relative;
            z-index: 2;
        }

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            border: 2px solid rgba(226, 232, 240, 0.8) !important;
            border-radius: 12px !important;
            padding: 0.75rem 1rem !important;
            font-size: 1rem !important;
            height: auto !important;
            min-height: 56px !important;
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 4px 20px rgba(99, 102, 241, 0.1) !important;
            outline: none !important;
            background: rgba(255, 255, 255, 0.95) !important;
            transform: translateY(-1px);
        }

        .select2-container--default .select2-selection--single:hover:not(.select2-container--focus .select2-selection--single) {
            border-color: rgba(99, 102, 241, 0.5) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--dark-text) !important;
            line-height: 1.5 !important;
            padding: 8px 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--gray-text) !important;
        }

        .select2-dropdown {
            border: 2px solid rgba(99, 102, 241, 0.3) !important;
            border-radius: 12px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            box-shadow: 0 12px 40px rgba(99, 102, 241, 0.15) !important;
        }

        .select2-results__option {
            padding: 0.75rem 1rem !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .select2-results__option--highlighted {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color)) !important;
            color: white !important;
        }

        .select2-search--dropdown .select2-search__field {
            border: 2px solid rgba(226, 232, 240, 0.8) !important;
            border-radius: 8px !important;
            padding: 0.5rem !important;
            margin: 0.5rem !important;
            width: calc(100% - 1rem) !important;
        }

        .select2-search--dropdown .select2-search__field:focus {
            border-color: var(--primary-color) !important;
            outline: none !important;
        }

        .select2-container--default .select2-selection__arrow {
            height: 54px !important;
        }

        /* Enhanced animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Language Switcher Styles */
        .language-switcher {
            position: absolute;
            top: 2rem;
            right: 2rem;
            z-index: 100;
        }

        .language-selector {
            display: flex;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .language-option {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .language-option.active {
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .language-option:hover:not(.active) {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Mobile responsiveness */
        @media (max-width: 1024px) {
            .main-container {
                margin: -2rem 1rem 2rem;
            }
            
            .form-section {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
                line-height: 1.2;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .language-switcher {
                top: 1rem;
                right: 1rem;
            }

            .language-selector {
                padding: 0.25rem;
            }

            .language-option {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
            }

            .form-section {
                padding: 2rem 1rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .main-container {
                margin: -2rem 0.5rem 2rem;
                border-radius: 20px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .btn-custom {
                padding: 0.875rem 2rem;
                font-size: 0.9rem;
            }

            .form-section {
                padding: 1.5rem 0.75rem;
            }

            .feature-highlight {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Language Switcher -->
        <div class="language-switcher">
            <div class="language-selector">
                <div class="language-option active" data-lang="ms">
                    <i class="fas fa-globe"></i>
                    <span>Bahasa Malaysia</span>
                </div>
                <div class="language-option" data-lang="en">
                    <i class="fas fa-globe"></i>
                    <span>English</span>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title animate__animated animate__fadeInDown" data-key="hero.title">Pendaftaran Pelajar</h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s" data-key="hero.subtitle">
                    Sertai platform pembelajaran dalam talian kami dan buka potensi anda dengan bimbingan pakar dan sumber komprehensif.
                </p>
            </div>
        </div>
    </section>

    <!-- Registration Form -->
    <div class="container">
        <!-- Error Messages Container -->
        <div class="error-messages-container" style="margin-bottom: 2rem;">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert" style="margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert" style="margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="main-container animate__animated animate__fadeInUp" style="margin-top: 2rem;">
                <div class="text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle" style="font-size: 4rem; color: var(--success-color);"></i>
                    </div>
                    <h2 class="mb-3" style="color: var(--dark-text);">Registration Successful!</h2>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    <div class="feature-highlight">
                        <h5>What happens next?</h5>
                        <ul class="text-start">
                            <li>Your registration will be reviewed by our team within 24-48 hours</li>
                            <li>You'll receive an email confirmation with your login credentials</li>
                            <li>Once approved, you can start accessing learning materials immediately</li>
                        </ul>
                    </div>
                    <a href="{{ url('/') }}" class="btn btn-custom btn-primary-custom">
                        <i class="fas fa-home"></i> <span data-key="success.back_home">Kembali ke Laman Utama</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Registration Form -->
            <div class="main-container animate__animated animate__fadeInUp" style="margin-top: 1rem; clear: both;">
                <form method="POST" action="{{ route('student.register.submit') }}">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-user text-primary"></i>
                            <span data-key="form.personal.title">Maklumat Peribadi</span>
                        </h2>
                        <p class="section-description" data-key="form.personal.description">
                            Sila berikan butiran peribadi anda untuk mencipta akaun pelajar dan menyertai platform pembelajaran dalam talian kami.
                        </p>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        Full Name <span class="required">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter your full name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Email Address <span class="required">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter your email address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        IC Number <span class="required">*</span>
                                    </label>
                                    <input type="text" name="ic" class="form-control" value="{{ old('ic') }}" placeholder="e.g., 010101101234" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="e.g., 0123456789">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tingkatan</label>
                                    <input type="text" name="tingkatan" class="form-control" value="{{ old('tingkatan') }}" placeholder="e.g., Tingkatan 5">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Enter your full address">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <!-- Parent/Guardian Information -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-users text-success"></i>
                            <span data-key="form.parent.title">Maklumat Ibu Bapa/Penjaga</span>
                        </h2>
                        <p class="section-description" data-key="form.parent.description">
                            Sila berikan maklumat hubungan ibu bapa atau penjaga anda untuk komunikasi kecemasan dan pengesahan akaun.
                        </p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Parent/Guardian Name</label>
                                    <input type="text" name="parent_guardian_name" class="form-control" value="{{ old('parent_guardian_name') }}" placeholder="Enter parent/guardian name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Parent/Guardian Phone</label>
                                    <input type="text" name="parent_guardian_phone" class="form-control" value="{{ old('parent_guardian_phone') }}" placeholder="e.g., 0123456789">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- School & Account Information -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-school text-warning"></i>
                            <span data-key="form.school.title">Maklumat Sekolah & Akaun</span>
                        </h2>
                        <p class="section-description" data-key="form.school.description">
                            Pilih sekolah anda dan cipta kata laluan yang selamat untuk akaun anda. Akaun anda akan diaktifkan selepas kelulusan.
                        </p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        School <span class="required">*</span>
                                    </label>
                                    <select name="school_id" id="schoolSelect" class="form-control" required>
                                        <option value="">Search and select your school...</option>
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
                                    <label class="form-label">
                                        Password <span class="required">*</span>
                                    </label>
                                    <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Confirm Password <span class="required">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden status field set to inactive -->
                        <input type="hidden" name="status" value="inactive">
                    </div>

                    <!-- Information Notice -->
                    <div class="feature-highlight">
                        <h5><i class="fas fa-info-circle text-primary"></i> Registration Notice</h5>
                        <p class="mb-0">Your account will be set to <strong>inactive</strong> status and requires approval from our team before you can access the platform. You'll receive an email notification once your account is approved.</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center submit-button-container mb-4">
                        <button type="submit" class="btn btn-custom btn-primary-custom">
                            <i class="fas fa-paper-plane"></i> <span data-key="form.submit">Hantar Pendaftaran</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        // Language management
        let currentLanguage = 'ms'; // Default to Malay
        
        const translations = {
            ms: {
                // Hero section
                'hero.title': 'Pendaftaran Pelajar',
                'hero.subtitle': 'Sertai platform pembelajaran dalam talian kami dan buka potensi anda dengan bimbingan pakar dan sumber komprehensif.',
                
                // Form sections
                'form.personal.title': 'Maklumat Peribadi',
                'form.personal.description': 'Sila berikan butiran peribadi anda untuk mencipta akaun pelajar dan menyertai platform pembelajaran dalam talian kami.',
                'form.parent.title': 'Maklumat Ibu Bapa/Penjaga',
                'form.parent.description': 'Sila berikan maklumat hubungan ibu bapa atau penjaga anda untuk komunikasi kecemasan dan pengesahan akaun.',
                'form.school.title': 'Maklumat Sekolah & Akaun',
                'form.school.description': 'Pilih sekolah anda dan cipta kata laluan yang selamat untuk akaun anda. Akaun anda akan diaktifkan selepas kelulusan.',
                'form.submit': 'Hantar Pendaftaran',
                'success.back_home': 'Kembali ke Laman Utama',
            },
            en: {
                // Hero section
                'hero.title': 'Student Registration',
                'hero.subtitle': 'Join our online learning platform and unlock your potential with expert guidance and comprehensive resources.',
                
                // Form sections
                'form.personal.title': 'Personal Information',
                'form.personal.description': 'Please provide your personal details to create your student account and join our online learning platform.',
                'form.parent.title': 'Parent/Guardian Information',
                'form.parent.description': 'Please provide your parent or guardian\'s contact information for emergency communication and account verification.',
                'form.school.title': 'School & Account Information',
                'form.school.description': 'Select your school and create a secure password for your account. Your account will be activated after approval.',
                'form.submit': 'Submit Registration',
                'success.back_home': 'Back to Home',
            }
        };

        function switchLanguage(lang) {
            currentLanguage = lang;
            
            // Update active language option
            document.querySelectorAll('.language-option').forEach(option => {
                option.classList.remove('active');
                if (option.dataset.lang === lang) {
                    option.classList.add('active');
                }
            });
            
            // Update all text content
            document.querySelectorAll('[data-key]').forEach(element => {
                const key = element.dataset.key;
                if (translations[lang] && translations[lang][key]) {
                    element.textContent = translations[lang][key];
                }
            });
            
            // Update Select2 placeholder
            const placeholder = lang === 'ms' ? 'Cari dan pilih sekolah anda...' : 'Search and select your school...';
            $('#schoolSelect').attr('data-placeholder', placeholder);
            if ($('#schoolSelect').hasClass('select2-hidden-accessible')) {
                $('#schoolSelect').select2('destroy');
                initializeSchoolSelect();
            }
        }

        function initializeSchoolSelect() {
            const placeholder = currentLanguage === 'ms' ? 'Cari dan pilih sekolah anda...' : 'Search and select your school...';
            
            $('#schoolSelect').select2({
                placeholder: placeholder,
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '{{ route("student.search-schools") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.map(function(school) {
                                return {
                                    id: school.id,
                                    text: school.name
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            });
        }

        $(document).ready(function() {
            // Initialize Select2 for school selection with AJAX search
            initializeSchoolSelect();
            
            // Language switcher
            document.querySelectorAll('.language-option').forEach(option => {
                option.addEventListener('click', () => {
                    switchLanguage(option.dataset.lang);
                });
            });
            
            // Initialize with Malay as default
            switchLanguage('ms');
        });
    </script>
</body>
</html> 