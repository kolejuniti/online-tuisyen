<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - eTuition Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/student-friendly.css') }}" rel="stylesheet">
    <style>
        /* Login Page Specific Styles */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .login-hero {
            padding: 2.5rem 0 2rem;
            text-align: center;
        }

        .login-hero-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 0 1rem 3rem;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: var(--sf-radius-2xl);
            box-shadow: var(--sf-shadow-lg);
            border: 3px solid var(--sf-sky-light);
            overflow: hidden;
            opacity: 0;
            animation: sf-cardPop 0.6s ease forwards 0.5s;
        }

        /* Partnership Header */
        .login-partnership {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, var(--sf-sky-light) 0%, rgba(189, 224, 254, 0.3) 100%);
            border-bottom: 2px dashed rgba(189, 224, 254, 0.5);
            text-align: center;
        }

        .brand-centered {
            font-size: 2.25rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .brand-centered .brand-e {
            color: var(--sf-ocean-bright);
        }

        .brand-centered .brand-tuition {
            background: linear-gradient(135deg, var(--sf-coral-warm), var(--sf-coral-bright));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .logo-img {
            height: 70px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.08));
            transition: var(--sf-transition-normal);
            opacity: 0.85;
        }

        .logo-img:hover {
            transform: scale(1.05);
            opacity: 1;
        }

        .logo-separator {
            color: var(--sf-text-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .partnership-label {
            font-size: 0.75rem;
            color: var(--sf-text-soft);
            font-weight: 600;
            letter-spacing: 0.03em;
            line-height: 1.4;
        }

        /* Tab Switcher */
        .login-tabs {
            display: flex;
            background: var(--sf-cream-bg);
            position: relative;
            border-bottom: 2px solid var(--sf-sky-light);
        }

        .login-tab {
            flex: 1;
            padding: 1.1rem 1rem;
            background: none;
            border: none;
            font-family: 'Nunito', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--sf-text-soft);
            cursor: pointer;
            transition: var(--sf-transition-normal);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-tab i {
            font-size: 1rem;
            transition: var(--sf-transition-normal);
        }

        .login-tab:hover {
            color: var(--sf-ocean-bright);
            background: rgba(189, 224, 254, 0.2);
        }

        .login-tab.active {
            color: var(--sf-ocean-bright);
            background: white;
        }

        .login-tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--sf-ocean-bright), var(--sf-ocean-soft));
            border-radius: 3px 3px 0 0;
        }

        .login-tab.active i {
            color: var(--sf-coral-warm);
        }

        /* Form Content */
        .login-form-wrapper {
            padding: 2rem;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: sf-fadeUp 0.4s ease forwards;
        }

        /* Welcome Message */
        .form-welcome {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .form-welcome-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--sf-sky-light), var(--sf-sky-medium));
            border-radius: var(--sf-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: sf-bounce-gentle 3s ease-in-out infinite;
        }

        .form-welcome-icon i {
            font-size: 1.5rem;
            color: var(--sf-ocean-bright);
        }

        .form-welcome-icon.teacher-icon {
            background: linear-gradient(135deg, rgba(255, 209, 102, 0.3), rgba(255, 140, 107, 0.2));
        }

        .form-welcome-icon.teacher-icon i {
            color: var(--sf-coral-warm);
        }

        .form-welcome h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 0.35rem;
        }

        .form-welcome p {
            font-size: 0.9rem;
            color: var(--sf-text-soft);
            font-weight: 500;
        }

        /* Form Groups */
        .sf-form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .sf-input-wrapper {
            position: relative;
        }

        .sf-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--sf-ocean-soft);
            font-size: 1rem;
            transition: var(--sf-transition-normal);
            z-index: 2;
        }

        .sf-form-control {
            padding-left: 2.75rem !important;
        }

        .sf-form-control:focus + .sf-input-icon,
        .sf-form-control:not(:placeholder-shown) + .sf-input-icon {
            color: var(--sf-ocean-bright);
        }

        .sf-toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--sf-text-muted);
            cursor: pointer;
            padding: 0.25rem;
            transition: var(--sf-transition-normal);
            z-index: 2;
        }

        .sf-toggle-password:hover {
            color: var(--sf-ocean-bright);
        }

        /* Error Messages */
        .sf-field-error {
            background: var(--sf-danger-soft);
            color: #c53030;
            padding: 0.65rem 0.9rem;
            border-radius: var(--sf-radius-sm);
            font-size: 0.8rem;
            margin-top: 0.5rem;
            border-left: 3px solid var(--sf-danger);
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-weight: 600;
            animation: sf-fadeUp 0.3s ease;
        }

        .sf-field-error i {
            margin-top: 0.1rem;
            flex-shrink: 0;
        }

        .sf-form-control.is-invalid {
            border-color: var(--sf-danger) !important;
            background: rgba(239, 107, 107, 0.05) !important;
        }

        /* Form Options Row */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .sf-checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: pointer;
        }

        .sf-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--sf-sky-medium);
            border-radius: var(--sf-radius-sm);
            background: white;
            cursor: pointer;
            position: relative;
            transition: var(--sf-transition-normal);
        }

        .sf-checkbox:checked {
            background: linear-gradient(135deg, var(--sf-ocean-bright), var(--sf-ocean-soft));
            border-color: var(--sf-ocean-bright);
        }

        .sf-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .sf-checkbox:hover {
            border-color: var(--sf-ocean-soft);
        }

        .sf-checkbox-label {
            font-size: 0.875rem;
            color: var(--sf-text-warm);
            font-weight: 600;
            cursor: pointer;
        }

        .sf-forgot-link {
            font-size: 0.875rem;
            color: var(--sf-ocean-bright);
            font-weight: 600;
            text-decoration: none;
            transition: var(--sf-transition-normal);
            position: relative;
        }

        .sf-forgot-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--sf-ocean-bright), var(--sf-coral-warm));
            transition: width 0.3s ease;
        }

        .sf-forgot-link:hover::after {
            width: 100%;
        }

        .sf-forgot-link:hover {
            color: var(--sf-coral-warm);
        }

        /* Submit Button */
        .sf-submit-btn {
            width: 100%;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: var(--sf-radius-lg);
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--sf-transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            position: relative;
            overflow: hidden;
        }

        .sf-submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .sf-submit-btn:hover::before {
            left: 100%;
        }

        .sf-submit-btn.teacher-btn {
            background: linear-gradient(135deg, var(--sf-coral-warm), var(--sf-coral-bright));
            color: white;
            box-shadow: 0 6px 20px rgba(255, 140, 107, 0.35);
        }

        .sf-submit-btn.teacher-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 140, 107, 0.45);
        }

        .sf-submit-btn.student-btn {
            background: linear-gradient(135deg, var(--sf-ocean-bright), var(--sf-ocean-soft));
            color: white;
            box-shadow: 0 6px 20px rgba(91, 164, 230, 0.35);
        }

        .sf-submit-btn.student-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(91, 164, 230, 0.45);
        }

        .sf-submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .sf-submit-btn i {
            transition: transform var(--sf-transition-normal);
        }

        .sf-submit-btn:hover i {
            transform: translateX(4px);
        }

        /* Loading Spinner */
        .sf-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: sf-spin 0.8s linear infinite;
        }

        @keyframes sf-spin {
            to { transform: rotate(360deg); }
        }

        /* Divider */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .login-divider-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--sf-sky-medium), transparent);
        }

        .login-divider-text {
            font-size: 0.8rem;
            color: var(--sf-text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Register Link */
        .register-prompt {
            text-align: center;
            padding-top: 0.5rem;
        }

        .register-prompt p {
            font-size: 0.9rem;
            color: var(--sf-text-soft);
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .sf-register-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.25rem;
            background: var(--sf-sky-light);
            color: var(--sf-ocean-bright);
            border-radius: var(--sf-radius-full);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: var(--sf-transition-normal);
            border: 2px solid transparent;
        }

        .sf-register-link:hover {
            background: white;
            border-color: var(--sf-ocean-soft);
            color: var(--sf-ocean-deep);
            transform: translateY(-2px);
            box-shadow: var(--sf-shadow-sm);
        }

        .sf-register-link i {
            transition: transform var(--sf-transition-normal);
        }

        .sf-register-link:hover i {
            transform: translateX(4px);
        }

        /* Footer */
        .login-footer {
            text-align: center;
            padding: 1.5rem 0 2.5rem;
        }

        .login-footer-emojis {
            font-size: 1.25rem;
            letter-spacing: 0.4rem;
            margin-bottom: 0.4rem;
        }

        .login-footer-text {
            font-size: 0.8rem;
            color: var(--sf-text-light);
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-hero {
                padding: 2rem 0 1.5rem;
            }

            .login-partnership {
                padding: 1.25rem 1.25rem;
            }

            .brand-centered {
                font-size: 1.85rem;
            }

            .logo-row {
                gap: 0.75rem;
            }

            .logo-img {
                height: 46px;
            }

            .login-form-wrapper {
                padding: 1.5rem;
            }

            .form-welcome-icon {
                width: 50px;
                height: 50px;
            }

            .form-welcome-icon i {
                font-size: 1.25rem;
            }

            .form-welcome h3 {
                font-size: 1.1rem;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .sf-forgot-link {
                align-self: flex-end;
            }

            .login-tab {
                font-size: 0.85rem;
                padding: 1rem 0.75rem;
            }
        }

        @media (max-width: 400px) {
            .brand-centered {
                font-size: 1.6rem;
            }

            .logo-img {
                height: 40px;
            }

            .logo-separator {
                font-size: 0.8rem;
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

    <div class="login-wrapper">
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

        <!-- Hero Section -->
        <section class="login-hero">
            <div class="login-hero-content">
                <p class="sf-hero-greeting" data-key="hero.greeting">Selamat Kembali!</p>
                <h1 class="sf-hero-title" data-key="hero.title">
                    <span class="sf-wave">👋</span> Log Masuk ke <span class="sf-highlight">eTuition</span>
                </h1>
                <p class="sf-hero-subtitle" data-key="hero.subtitle">
                    Teruskan perjalanan pembelajaran anda bersama kami!
                </p>
            </div>
        </section>

        <!-- Login Container -->
        <div class="login-container">
            <div class="login-card">
                <!-- Partnership Header -->
                <div class="login-partnership">
                    <div class="brand-centered">
                        <span class="brand-e">e</span><span class="brand-tuition">Tuition</span>
                    </div>
                    <div class="logo-row">
                        <img src="{{ asset('assets/images/logo/pkibs.png') }}" alt="PIBKS Logo" class="logo-img">
                        {{-- <span class="logo-separator">×</span> --}}
                        <img src="{{ asset('assets/images/logo/Kolej-UNITI.png') }}" alt="UNITI Logo" class="logo-img">
                    </div>
                    <p class="partnership-label" data-key="partnership.label">Program PIBKS & Kolej UNITI</p>
                </div>

                <!-- Tab Switcher -->
                <div class="login-tabs">
                    <button class="login-tab active" id="teacherTab" data-tab="teacher">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span data-key="tab.teacher">Guru</span>
                    </button>
                    <button class="login-tab" id="studentTab" data-tab="student">
                        <i class="fas fa-user-graduate"></i>
                        <span data-key="tab.student">Pelajar</span>
                    </button>
                </div>

                <!-- Form Content -->
                <div class="login-form-wrapper">
                    <!-- Teacher Login Form -->
                    <div class="tab-content active" id="teacherContent">
                        <div class="form-welcome">
                            <div class="form-welcome-icon teacher-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 data-key="teacher.welcome.title">Selamat Datang, Cikgu! 📖</h3>
                            <p data-key="teacher.welcome.subtitle">Log masuk untuk mengurus kelas anda</p>
                        </div>

                        <form action="{{ route('login') }}" method="post" id="teacherForm">
                            @csrf
                            <input type="hidden" name="login_type" value="user">

                            <div class="sf-form-group">
                                <label class="sf-form-label" data-key="form.email">
                                    <i class="fas fa-envelope"></i> E-mel
                                </label>
                                <div class="sf-input-wrapper">
                                    <input type="email" 
                                           name="email" 
                                           class="sf-form-control @error('email') is-invalid @enderror" 
                                           id="teacherEmail"
                                           placeholder="cikgu@example.com"
                                           required 
                                           value="{{ old('email') }}">
                                    <i class="fas fa-envelope sf-input-icon"></i>
                                </div>
                                @error('email')
                                <div class="sf-field-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="sf-form-group">
                                <label class="sf-form-label" data-key="form.password">
                                    <i class="fas fa-lock"></i> Kata Laluan
                                </label>
                                <div class="sf-input-wrapper">
                                    <input type="password" 
                                           name="password" 
                                           class="sf-form-control @error('password') is-invalid @enderror" 
                                           id="teacherPassword"
                                           placeholder="••••••••"
                                           required>
                                    <i class="fas fa-lock sf-input-icon"></i>
                                    <i class="fas fa-eye sf-toggle-password" id="teacherToggle"></i>
                                </div>
                                @error('password')
                                <div class="sf-field-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-options">
                                <label class="sf-checkbox-wrapper">
                                    <input type="checkbox" name="remember" class="sf-checkbox" id="teacherRemember">
                                    <span class="sf-checkbox-label" data-key="form.remember">Ingat saya</span>
                                </label>
                                <a href="javascript:void(0)" class="sf-forgot-link" id="teacherForgot" data-key="form.forgot">
                                    Lupa kata laluan?
                                </a>
                            </div>

                            <button type="submit" class="sf-submit-btn teacher-btn" id="teacherSubmit">
                                <span class="btn-text" data-key="form.submit.teacher">Log Masuk sebagai Guru</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Student Login Form -->
                    <div class="tab-content" id="studentContent">
                        <div class="form-welcome">
                            <div class="form-welcome-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h3 data-key="student.welcome.title">Hai, Pelajar! 🎒</h3>
                            <p data-key="student.welcome.subtitle">Log masuk untuk teruskan belajar</p>
                        </div>

                        <form action="{{ route('login') }}" method="post" id="studentForm">
                            @csrf
                            <input type="hidden" name="login_type" value="student">

                            <div class="sf-form-group">
                                <label class="sf-form-label" data-key="form.email">
                                    <i class="fas fa-envelope"></i> E-mel
                                </label>
                                <div class="sf-input-wrapper">
                                    <input type="email" 
                                           name="email" 
                                           class="sf-form-control @error('email') is-invalid @enderror" 
                                           id="studentEmail"
                                           placeholder="pelajar@example.com"
                                           required 
                                           value="{{ old('email') }}">
                                    <i class="fas fa-envelope sf-input-icon"></i>
                                </div>
                                @error('email')
                                <div class="sf-field-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="sf-form-group">
                                <label class="sf-form-label" data-key="form.password">
                                    <i class="fas fa-lock"></i> Kata Laluan
                                </label>
                                <div class="sf-input-wrapper">
                                    <input type="password" 
                                           name="password" 
                                           class="sf-form-control @error('password') is-invalid @enderror" 
                                           id="studentPassword"
                                           placeholder="••••••••"
                                           required>
                                    <i class="fas fa-lock sf-input-icon"></i>
                                    <i class="fas fa-eye sf-toggle-password" id="studentToggle"></i>
                                </div>
                                @error('password')
                                <div class="sf-field-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <div class="form-options">
                                <label class="sf-checkbox-wrapper">
                                    <input type="checkbox" name="remember" class="sf-checkbox" id="studentRemember">
                                    <span class="sf-checkbox-label" data-key="form.remember">Ingat saya</span>
                                </label>
                                <a href="javascript:void(0)" class="sf-forgot-link" id="studentForgot" data-key="form.forgot">
                                    Lupa kata laluan?
                                </a>
                            </div>

                            <button type="submit" class="sf-submit-btn student-btn" id="studentSubmit">
                                <span class="btn-text" data-key="form.submit.student">Log Masuk sebagai Pelajar</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Divider -->
                    <div class="login-divider">
                        <div class="login-divider-line"></div>
                        <span class="login-divider-text" data-key="divider.or">atau</span>
                        <div class="login-divider-line"></div>
                    </div>

                    <!-- Register Prompt -->
                    <div class="register-prompt">
                        <p data-key="register.prompt">Belum ada akaun?</p>
                        <a href="{{ route('register.choice') }}" class="sf-register-link">
                            <i class="fas fa-user-plus"></i>
                            <span data-key="register.button">Daftar Sekarang</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            <div class="login-footer-emojis">📚 ✨ 🎓</div>
            <p class="login-footer-text" data-key="footer.text">Belajar dengan seronok!</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Language translations
        let currentLanguage = 'ms';
        
        const translations = {
            ms: {
                'hero.greeting': 'Selamat Kembali!',
                'hero.title': '👋 Log Masuk ke eTuition',
                'hero.subtitle': 'Teruskan perjalanan pembelajaran anda bersama kami!',
                'partnership.label': 'Program PIBKS & Kolej UNITI',
                'tab.teacher': 'Guru',
                'tab.student': 'Pelajar',
                'teacher.welcome.title': 'Selamat Datang, Cikgu! 📖',
                'teacher.welcome.subtitle': 'Log masuk untuk mengurus kelas anda',
                'student.welcome.title': 'Hai, Pelajar! 🎒',
                'student.welcome.subtitle': 'Log masuk untuk teruskan belajar',
                'form.email': 'E-mel',
                'form.password': 'Kata Laluan',
                'form.remember': 'Ingat saya',
                'form.forgot': 'Lupa kata laluan?',
                'form.submit.teacher': 'Log Masuk sebagai Guru',
                'form.submit.student': 'Log Masuk sebagai Pelajar',
                'divider.or': 'atau',
                'register.prompt': 'Belum ada akaun?',
                'register.button': 'Daftar Sekarang',
                'footer.text': 'Belajar dengan seronok!'
            },
            en: {
                'hero.greeting': 'Welcome Back!',
                'hero.title': '👋 Sign In to eTuition',
                'hero.subtitle': 'Continue your learning journey with us!',
                'partnership.label': 'PIBKS & UNITI College Program',
                'tab.teacher': 'Teacher',
                'tab.student': 'Student',
                'teacher.welcome.title': 'Welcome, Teacher! 📖',
                'teacher.welcome.subtitle': 'Sign in to manage your classes',
                'student.welcome.title': 'Hi, Student! 🎒',
                'student.welcome.subtitle': 'Sign in to continue learning',
                'form.email': 'Email',
                'form.password': 'Password',
                'form.remember': 'Remember me',
                'form.forgot': 'Forgot password?',
                'form.submit.teacher': 'Sign In as Teacher',
                'form.submit.student': 'Sign In as Student',
                'divider.or': 'or',
                'register.prompt': "Don't have an account?",
                'register.button': 'Register Now',
                'footer.text': 'Learn with fun!'
            }
        };

        // Language switching
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
                    if (key === 'hero.title') {
                        if (lang === 'ms') {
                            element.innerHTML = '<span class="sf-wave">👋</span> Log Masuk ke <span class="sf-highlight">eTuition</span>';
                        } else {
                            element.innerHTML = '<span class="sf-wave">👋</span> Sign In to <span class="sf-highlight">eTuition</span>';
                        }
                    } else if (key === 'form.email') {
                        element.innerHTML = `<i class="fas fa-envelope"></i> ${translations[lang][key]}`;
                    } else if (key === 'form.password') {
                        element.innerHTML = `<i class="fas fa-lock"></i> ${translations[lang][key]}`;
                    } else {
                        element.textContent = translations[lang][key];
                    }
                }
            });
        }

        // Tab switching
        function switchTab(tabName) {
            const teacherTab = document.getElementById('teacherTab');
            const studentTab = document.getElementById('studentTab');
            const teacherContent = document.getElementById('teacherContent');
            const studentContent = document.getElementById('studentContent');

            if (tabName === 'teacher') {
                teacherTab.classList.add('active');
                studentTab.classList.remove('active');
                teacherContent.classList.add('active');
                studentContent.classList.remove('active');
            } else {
                studentTab.classList.add('active');
                teacherTab.classList.remove('active');
                studentContent.classList.add('active');
                teacherContent.classList.remove('active');
            }
        }

        // Toggle password visibility
        function setupPasswordToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            
            if (toggle && input) {
                toggle.addEventListener('click', () => {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    toggle.classList.toggle('fa-eye');
                    toggle.classList.toggle('fa-eye-slash');
                });
            }
        }

        // Form submission with loading state
        function setupFormSubmission(formId, buttonId) {
            const form = document.getElementById(formId);
            const button = document.getElementById(buttonId);
            
            if (form && button) {
                form.addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        this.reportValidity();
                        return;
                    }
                    
                    button.disabled = true;
                    const btnText = button.querySelector('.btn-text');
                    const originalText = btnText.textContent;
                    btnText.innerHTML = '<span class="sf-spinner"></span> ' + (currentLanguage === 'ms' ? 'Sedang log masuk...' : 'Signing in...');
                    button.querySelector('i.fa-arrow-right')?.remove();
                });
            }
        }

        // Remember me functionality
        function setupRememberMe() {
            const teacherRemember = document.getElementById('teacherRemember');
            const studentRemember = document.getElementById('studentRemember');
            const teacherEmail = document.getElementById('teacherEmail');
            const studentEmail = document.getElementById('studentEmail');

            // Restore saved state
            if (localStorage.getItem('remember_teacher') === 'true') {
                teacherRemember.checked = true;
                const savedEmail = localStorage.getItem('teacher_email');
                if (savedEmail && !teacherEmail.value) {
                    teacherEmail.value = savedEmail;
                }
            }

            if (localStorage.getItem('remember_student') === 'true') {
                studentRemember.checked = true;
                const savedEmail = localStorage.getItem('student_email');
                if (savedEmail && !studentEmail.value) {
                    studentEmail.value = savedEmail;
                }
            }

            // Save on change
            teacherRemember?.addEventListener('change', function() {
                localStorage.setItem('remember_teacher', this.checked);
                if (!this.checked) localStorage.removeItem('teacher_email');
            });

            studentRemember?.addEventListener('change', function() {
                localStorage.setItem('remember_student', this.checked);
                if (!this.checked) localStorage.removeItem('student_email');
            });

            // Save email on input
            teacherEmail?.addEventListener('input', function() {
                if (teacherRemember.checked) {
                    localStorage.setItem('teacher_email', this.value);
                }
            });

            studentEmail?.addEventListener('input', function() {
                if (studentRemember.checked) {
                    localStorage.setItem('student_email', this.value);
                }
            });

            // Save on form submit
            document.getElementById('teacherForm')?.addEventListener('submit', function() {
                if (teacherRemember.checked && teacherEmail.value) {
                    localStorage.setItem('teacher_email', teacherEmail.value);
                }
            });

            document.getElementById('studentForm')?.addEventListener('submit', function() {
                if (studentRemember.checked && studentEmail.value) {
                    localStorage.setItem('student_email', studentEmail.value);
                }
            });
        }

        // Forgot password handler
        function setupForgotPassword() {
            document.querySelectorAll('.sf-forgot-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('.tab-content').querySelector('form');
                    const email = form.querySelector('input[type="email"]').value;
                    
                    if (email) {
                        showNotification(currentLanguage === 'ms' 
                            ? 'Pautan reset kata laluan telah dihantar ke e-mel anda' 
                            : 'Password reset link has been sent to your email', 'success');
                    } else {
                        showNotification(currentLanguage === 'ms' 
                            ? 'Sila masukkan alamat e-mel anda dahulu' 
                            : 'Please enter your email address first', 'info');
                    }
                });
            });
        }

        // Show notification
        function showNotification(message, type = 'info') {
            let notification = document.getElementById('sf-notification');
            
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'sf-notification';
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 1rem 1.5rem;
                    border-radius: 12px;
                    font-family: 'Nunito', sans-serif;
                    font-weight: 600;
                    font-size: 0.9rem;
                    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
                    z-index: 9999;
                    opacity: 0;
                    transform: translateX(100%);
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    max-width: 320px;
                `;
                document.body.appendChild(notification);
            }
            
            const colors = {
                info: { bg: '#e8f4fc', color: '#3d8bd4', icon: 'fa-info-circle' },
                success: { bg: '#a7e8c8', color: '#2d7a5e', icon: 'fa-check-circle' },
                error: { bg: '#fde8e8', color: '#c53030', icon: 'fa-exclamation-circle' }
            };
            
            const style = colors[type] || colors.info;
            notification.style.background = style.bg;
            notification.style.color = style.color;
            notification.innerHTML = `<i class="fas ${style.icon}"></i> ${message}`;
            
            // Show
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            // Hide after 4 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
            }, 4000);
        }

        // Handle form errors - show correct tab
        function handleFormErrors() {
            const hasErrors = document.querySelector('.sf-field-error');
            if (hasErrors) {
                const oldLoginType = '{{ old("login_type") }}';
                if (oldLoginType === 'student') {
                    switchTab('student');
                }
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Language switcher
            document.querySelectorAll('.sf-language-option').forEach(option => {
                option.addEventListener('click', () => {
                    switchLanguage(option.dataset.lang);
                });
            });
            switchLanguage('ms');
            
            // Tab switcher
            document.getElementById('teacherTab')?.addEventListener('click', () => switchTab('teacher'));
            document.getElementById('studentTab')?.addEventListener('click', () => switchTab('student'));
            
            // Password toggles
            setupPasswordToggle('teacherToggle', 'teacherPassword');
            setupPasswordToggle('studentToggle', 'studentPassword');
            
            // Form submissions
            setupFormSubmission('teacherForm', 'teacherSubmit');
            setupFormSubmission('studentForm', 'studentSubmit');
            
            // Remember me
            setupRememberMe();
            
            // Forgot password
            setupForgotPassword();
            
            // Handle errors
            handleFormErrors();
        });
    </script>
</body>
</html>
