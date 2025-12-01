<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Online Tuition Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('css/student-friendly.css') }}" rel="stylesheet">
    <style>
        /* Page-specific styles */
        .sf-hero-compact {
            padding: 2.5rem 0 3rem;
        }

        .sf-hero-compact .sf-hero-icon {
            width: 70px;
            height: 70px;
            margin-bottom: 1rem;
        }

        .sf-hero-compact .sf-hero-icon i {
            font-size: 1.75rem;
        }

        .sf-hero-compact .sf-hero-title {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            margin-bottom: 0.75rem;
        }

        .sf-hero-compact .sf-hero-subtitle {
            font-size: 1rem;
            margin-bottom: 0;
        }

        .sf-main-container {
            margin-top: -2rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Success state styling */
        .success-container {
            padding: 3rem 2rem;
            text-align: center;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--sf-mint-fresh), var(--sf-mint-deep));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: sf-bounce-gentle 2s ease-in-out infinite;
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        .success-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 1rem;
        }

        .success-message {
            font-size: 1rem;
            color: var(--sf-text-soft);
            max-width: 500px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        /* Alert styling */
        .sf-alert-dismissible {
            position: relative;
            padding-right: 3rem;
        }

        .sf-alert-dismissible .btn-close {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            padding: 0.5rem;
            opacity: 0.7;
        }

        .sf-alert-dismissible .btn-close:hover {
            opacity: 1;
        }

        .sf-alert ul {
            margin: 0.5rem 0 0 0;
            padding-left: 1.25rem;
        }

        .sf-alert li {
            margin-bottom: 0.25rem;
        }

        /* Form row spacing */
        .row {
            margin-bottom: 0;
        }

        .row > [class*="col-"] {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .sf-main-container {
                margin-left: 0.75rem;
                margin-right: 0.75rem;
            }

            .sf-form-section {
                padding: 1.75rem 1.25rem;
            }

            .success-container {
                padding: 2rem 1.5rem;
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

    <!-- Hero Section -->
    <section class="sf-hero sf-hero-compact">
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
                <!-- Back Link -->
                <a href="{{ route('register.choice') }}" class="sf-back-link sf-fade-in">
                    <i class="fas fa-arrow-left"></i>
                    <span data-key="back">Kembali</span>
                </a>
                
                <div class="sf-fade-in sf-fade-in-delay-1 sf-logo-row" style="display: flex; align-items: center; justify-content: center; gap: 1.25rem; margin: 0 auto 1rem; animation: sf-bounce-vertical 3s ease-in-out infinite;">
                    <img src="{{ asset('assets/images/logo/pkibs.png') }}" alt="PIBKS Logo" style="height: 55px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));">
                    <img src="{{ asset('assets/images/logo/Kolej-UNITI.png') }}" alt="UNITI Logo" style="height: 55px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));">
                </div>
                <h1 class="sf-hero-title" data-key="hero.title">
                    <span class="sf-wave">✏️</span> Daftar sebagai <span class="sf-highlight">Pelajar</span>
                </h1>
                <p class="sf-hero-subtitle" data-key="hero.subtitle">
                    Isi maklumat di bawah untuk mula belajar bersama kami!
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container position-relative" style="z-index: 1; padding-bottom: 3rem;">
        <!-- Error Messages -->
        @if(session('error'))
            <div class="sf-alert sf-alert-danger sf-alert-dismissible sf-fade-in" role="alert" style="max-width: 900px; margin: 0 auto 1.5rem;">
                <i class="fas fa-exclamation-circle"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="sf-alert sf-alert-danger sf-alert-dismissible sf-fade-in" role="alert" style="max-width: 900px; margin: 0 auto 1.5rem;">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong data-key="error.title">Sila betulkan ralat berikut:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <!-- Success Message -->
            <div class="sf-main-container sf-fade-in">
                <div class="success-container">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2 class="success-title" data-key="success.title">Pendaftaran Berjaya! 🎉</h2>
                    <p class="success-message">{{ session('success') }}</p>
                    
                    <div class="sf-info-box sf-text-left" style="max-width: 500px; margin: 0 auto 2rem;">
                        <div class="sf-info-box-header">
                            <i class="fas fa-info-circle"></i>
                            <span data-key="success.next_title">Apa seterusnya?</span>
                        </div>
                        <ul>
                            <li data-key="success.step1">Pendaftaran anda akan disemak dalam 24-48 jam</li>
                            <li data-key="success.step2">Anda akan menerima e-mel dengan maklumat log masuk</li>
                            <li data-key="success.step3">Selepas diluluskan, anda boleh mula belajar!</li>
                        </ul>
                    </div>
                    
                    <a href="{{ url('/') }}" class="sf-btn sf-btn-primary sf-btn-lg">
                        <i class="fas fa-home"></i>
                        <span data-key="success.back_home">Kembali ke Laman Utama</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Registration Form -->
            <div class="sf-main-container sf-fade-in sf-fade-in-delay-2">
                <form method="POST" action="{{ route('student.register.submit') }}">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="sf-form-section">
                        <div class="sf-section-header">
                            <div class="sf-section-icon sf-blue">
                                <i class="fas fa-user"></i>
                            </div>
                            <h2 class="sf-section-title" data-key="form.personal.title">Maklumat Peribadi</h2>
                        </div>
                        <p class="sf-section-description" data-key="form.personal.description">
                            Isi butiran peribadi anda untuk membuat akaun pelajar.
                        </p>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="sf-form-group">
                                    <label class="sf-form-label">
                                        <span data-key="form.name">Nama Penuh</span> <span class="sf-required">*</span>
                                    </label>
                                    <input type="text" name="name" class="sf-form-control" value="{{ old('name') }}" placeholder="Masukkan nama penuh anda" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label">
                                        <span data-key="form.email">Alamat E-mel</span> <span class="sf-required">*</span>
                                    </label>
                                    <input type="email" name="email" class="sf-form-control" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label">
                                        <span data-key="form.ic">Nombor IC</span> <span class="sf-required">*</span>
                                    </label>
                                    <input type="text" name="ic" class="sf-form-control" value="{{ old('ic') }}" placeholder="Contoh: 010101101234" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label" data-key="form.phone">Nombor Telefon</label>
                                    <input type="text" name="phone_number" class="sf-form-control" value="{{ old('phone_number') }}" placeholder="Contoh: 0123456789">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label" data-key="form.dob">Tarikh Lahir</label>
                                    <input type="date" name="date_of_birth" class="sf-form-control" value="{{ old('date_of_birth') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label" data-key="form.gender">Jantina</label>
                                    <select name="gender" class="sf-form-control">
                                        <option value="" data-key="form.gender.select">Pilih Jantina</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }} data-key="form.gender.male">Lelaki</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }} data-key="form.gender.female">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label" data-key="form.tingkatan">Tingkatan</label>
                                    <input type="text" name="tingkatan" class="sf-form-control" value="{{ old('tingkatan') }}" placeholder="Contoh: Tingkatan 5">
                                </div>
                            </div>
                        </div>

                        <div class="sf-form-group">
                            <label class="sf-form-label" data-key="form.address">Alamat</label>
                            <textarea name="address" class="sf-form-control" rows="3" placeholder="Masukkan alamat penuh anda">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <!-- Parent/Guardian Information -->
                    <div class="sf-form-section">
                        <div class="sf-section-header">
                            <div class="sf-section-icon sf-green">
                                <i class="fas fa-users"></i>
                            </div>
                            <h2 class="sf-section-title" data-key="form.parent.title">Maklumat Ibu Bapa/Penjaga</h2>
                        </div>
                        <p class="sf-section-description" data-key="form.parent.description">
                            Maklumat untuk dihubungi jika perlu.
                        </p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label" data-key="form.parent_name">Nama Ibu Bapa/Penjaga</label>
                                    <input type="text" name="parent_guardian_name" class="sf-form-control" value="{{ old('parent_guardian_name') }}" placeholder="Masukkan nama ibu bapa/penjaga">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sf-form-group">
                                    <label class="sf-form-label" data-key="form.parent_phone">Telefon Ibu Bapa/Penjaga</label>
                                    <input type="text" name="parent_guardian_phone" class="sf-form-control" value="{{ old('parent_guardian_phone') }}" placeholder="Contoh: 0123456789">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- School Information -->
                    <div class="sf-form-section">
                        <div class="sf-section-header">
                            <div class="sf-section-icon sf-coral">
                                <i class="fas fa-school"></i>
                            </div>
                            <h2 class="sf-section-title" data-key="form.school.title">Maklumat Sekolah</h2>
                        </div>
                        <p class="sf-section-description" data-key="form.school.description">
                            Pilih sekolah anda untuk disambungkan ke platform.
                        </p>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="sf-form-group">
                                    <label class="sf-form-label">
                                        <span data-key="form.school_select">Sekolah</span> <span class="sf-required">*</span>
                                    </label>
                                    <select name="school_id" id="schoolSelect" class="sf-form-control" required>
                                        <option value="">Cari dan pilih sekolah anda...</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                                {{ $school->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden status field set to inactive -->
                        <input type="hidden" name="status" value="inactive">
                    </div>

                    <!-- Information Notice -->
                    <div class="sf-form-section" style="padding-top: 0; border-bottom: none;">
                        <div class="sf-info-box">
                            <div class="sf-info-box-header">
                                <i class="fas fa-info-circle"></i>
                                <span data-key="notice.title">Pemberitahuan Pendaftaran</span>
                            </div>
                            <p data-key="notice.description">
                                Akaun anda akan ditetapkan sebagai <strong>tidak aktif</strong> dan memerlukan kelulusan sebelum anda boleh mengakses platform. Anda akan menerima e-mel dengan kata laluan lalai (<strong>12345678</strong>) selepas akaun anda diluluskan.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="sf-text-center sf-mt-4">
                            <button type="submit" class="sf-btn sf-btn-primary sf-btn-lg">
                                <i class="fas fa-paper-plane"></i>
                                <span data-key="form.submit">Hantar Pendaftaran</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="sf-footer">
        <div class="sf-footer-emojis">📚 ✨ 🎓</div>
        <p class="sf-footer-text" data-key="footer.text">Selamat belajar!</p>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        let currentLanguage = 'ms';
        
        const translations = {
            ms: {
                'back': 'Kembali',
                'hero.title': '✏️ Daftar sebagai Pelajar',
                'hero.subtitle': 'Isi maklumat di bawah untuk mula belajar bersama kami!',
                'error.title': 'Sila betulkan ralat berikut:',
                'form.personal.title': 'Maklumat Peribadi',
                'form.personal.description': 'Isi butiran peribadi anda untuk membuat akaun pelajar.',
                'form.name': 'Nama Penuh',
                'form.email': 'Alamat E-mel',
                'form.ic': 'Nombor IC',
                'form.phone': 'Nombor Telefon',
                'form.dob': 'Tarikh Lahir',
                'form.gender': 'Jantina',
                'form.gender.select': 'Pilih Jantina',
                'form.gender.male': 'Lelaki',
                'form.gender.female': 'Perempuan',
                'form.tingkatan': 'Tingkatan',
                'form.address': 'Alamat',
                'form.parent.title': 'Maklumat Ibu Bapa/Penjaga',
                'form.parent.description': 'Maklumat untuk dihubungi jika perlu.',
                'form.parent_name': 'Nama Ibu Bapa/Penjaga',
                'form.parent_phone': 'Telefon Ibu Bapa/Penjaga',
                'form.school.title': 'Maklumat Sekolah',
                'form.school.description': 'Pilih sekolah anda untuk disambungkan ke platform.',
                'form.school_select': 'Sekolah',
                'notice.title': 'Pemberitahuan Pendaftaran',
                'notice.description': 'Akaun anda akan ditetapkan sebagai tidak aktif dan memerlukan kelulusan sebelum anda boleh mengakses platform. Anda akan menerima e-mel dengan kata laluan lalai (12345678) selepas akaun anda diluluskan.',
                'form.submit': 'Hantar Pendaftaran',
                'success.title': 'Pendaftaran Berjaya! 🎉',
                'success.next_title': 'Apa seterusnya?',
                'success.step1': 'Pendaftaran anda akan disemak dalam 24-48 jam',
                'success.step2': 'Anda akan menerima e-mel dengan maklumat log masuk',
                'success.step3': 'Selepas diluluskan, anda boleh mula belajar!',
                'success.back_home': 'Kembali ke Laman Utama',
                'footer.text': 'Selamat belajar!'
            },
            en: {
                'back': 'Back',
                'hero.title': '✏️ Register as Student',
                'hero.subtitle': 'Fill in the details below to start learning with us!',
                'error.title': 'Please fix the following errors:',
                'form.personal.title': 'Personal Information',
                'form.personal.description': 'Fill in your personal details to create your student account.',
                'form.name': 'Full Name',
                'form.email': 'Email Address',
                'form.ic': 'IC Number',
                'form.phone': 'Phone Number',
                'form.dob': 'Date of Birth',
                'form.gender': 'Gender',
                'form.gender.select': 'Select Gender',
                'form.gender.male': 'Male',
                'form.gender.female': 'Female',
                'form.tingkatan': 'Form/Grade',
                'form.address': 'Address',
                'form.parent.title': 'Parent/Guardian Information',
                'form.parent.description': 'Contact information if needed.',
                'form.parent_name': 'Parent/Guardian Name',
                'form.parent_phone': 'Parent/Guardian Phone',
                'form.school.title': 'School Information',
                'form.school.description': 'Select your school to connect to the platform.',
                'form.school_select': 'School',
                'notice.title': 'Registration Notice',
                'notice.description': 'Your account will be set to inactive and requires approval before you can access the platform. You will receive an email with default password (12345678) once your account is approved.',
                'form.submit': 'Submit Registration',
                'success.title': 'Registration Successful! 🎉',
                'success.next_title': 'What happens next?',
                'success.step1': 'Your registration will be reviewed within 24-48 hours',
                'success.step2': 'You will receive an email with login information',
                'success.step3': 'Once approved, you can start learning!',
                'success.back_home': 'Back to Home',
                'footer.text': 'Happy learning!'
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
                    if (key === 'hero.title') {
                        if (lang === 'ms') {
                            element.innerHTML = '<span class="sf-wave">✏️</span> Daftar sebagai <span class="sf-highlight">Pelajar</span>';
                        } else {
                            element.innerHTML = '<span class="sf-wave">✏️</span> Register as <span class="sf-highlight">Student</span>';
                        }
                    } else if (key === 'notice.description') {
                        if (lang === 'ms') {
                            element.innerHTML = 'Akaun anda akan ditetapkan sebagai <strong>tidak aktif</strong> dan memerlukan kelulusan sebelum anda boleh mengakses platform. Anda akan menerima e-mel dengan kata laluan lalai (<strong>12345678</strong>) selepas akaun anda diluluskan.';
                        } else {
                            element.innerHTML = 'Your account will be set to <strong>inactive</strong> and requires approval before you can access the platform. You will receive an email with default password (<strong>12345678</strong>) once your account is approved.';
                        }
                    } else {
                        element.textContent = translations[lang][key];
                    }
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
                            q: params.term,
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
            initializeSchoolSelect();
            
            document.querySelectorAll('.sf-language-option').forEach(option => {
                option.addEventListener('click', () => {
                    switchLanguage(option.dataset.lang);
                });
            });
            
            switchLanguage('ms');
        });
    </script>
</body>
</html>
