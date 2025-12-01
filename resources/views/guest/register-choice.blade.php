<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Registration Type - Online Tuition Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/student-friendly.css') }}" rel="stylesheet">
    <style>
        /* Page-specific styles */
        .registration-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .registration-card {
            position: relative;
            background: white;
            border-radius: var(--sf-radius-xl);
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--sf-shadow-md);
            border: 3px solid transparent;
            transition: var(--sf-transition-smooth);
            opacity: 0;
            animation: sf-cardPop 0.6s ease forwards;
        }

        .registration-card:nth-child(1) { animation-delay: 0.6s; }
        .registration-card:nth-child(2) { animation-delay: 0.75s; }

        .registration-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--sf-shadow-xl);
            text-decoration: none;
            color: inherit;
        }

        .registration-card.student-card {
            border-color: rgba(91, 164, 230, 0.2);
        }

        .registration-card.student-card:hover {
            border-color: var(--sf-ocean-bright);
        }

        .registration-card.school-card {
            border-color: rgba(107, 203, 158, 0.2);
        }

        .registration-card.school-card:hover {
            border-color: var(--sf-mint-fresh);
        }

        .card-header {
            padding: 2rem 1.75rem 1.5rem;
            text-align: center;
            position: relative;
        }

        .card-icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--sf-radius-xl);
            position: relative;
            transition: var(--sf-transition-smooth);
        }

        .student-card .card-icon-wrapper {
            background: linear-gradient(135deg, var(--sf-sky-light), var(--sf-sky-medium));
        }

        .school-card .card-icon-wrapper {
            background: linear-gradient(135deg, var(--sf-mint-soft), rgba(107, 203, 158, 0.3));
        }

        .registration-card:hover .card-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .card-icon {
            font-size: 2rem;
        }

        .student-card .card-icon {
            color: var(--sf-ocean-bright);
        }

        .school-card .card-icon {
            color: var(--sf-mint-fresh);
        }

        .card-badge {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.4rem 0.85rem;
            border-radius: var(--sf-radius-full);
        }

        .student-card .card-badge {
            background: var(--sf-sky-light);
            color: var(--sf-ocean-bright);
        }

        .school-card .card-badge {
            background: rgba(167, 232, 200, 0.4);
            color: #3d9970;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            font-size: 0.95rem;
            color: var(--sf-text-soft);
            line-height: 1.5;
            font-weight: 500;
        }

        .card-body {
            padding: 0 1.75rem 1rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.75rem 0;
            border-bottom: 2px dashed rgba(143, 163, 179, 0.15);
            transition: var(--sf-transition-normal);
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .registration-card:hover .features-list li {
            transform: translateX(5px);
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--sf-radius-sm);
            flex-shrink: 0;
        }

        .student-card .feature-icon {
            background: var(--sf-sky-light);
        }

        .school-card .feature-icon {
            background: rgba(167, 232, 200, 0.3);
        }

        .feature-icon i {
            font-size: 0.9rem;
        }

        .student-card .feature-icon i {
            color: var(--sf-ocean-bright);
        }

        .school-card .feature-icon i {
            color: var(--sf-mint-fresh);
        }

        .feature-text {
            font-size: 0.9rem;
            color: var(--sf-text-warm);
            font-weight: 600;
        }

        .card-footer {
            padding: 0.5rem 1.75rem 2rem;
        }

        .additional-info {
            max-width: 700px;
            margin: 2.5rem auto 0;
            padding: 2rem;
            background: white;
            border-radius: var(--sf-radius-xl);
            text-align: center;
            box-shadow: var(--sf-shadow-sm);
            border: 2px solid rgba(189, 224, 254, 0.3);
            opacity: 0;
            animation: sf-fadeUp 0.6s ease forwards 0.9s;
        }

        .additional-info h4 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--sf-text-dark);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .additional-info h4 i {
            color: var(--sf-sunshine);
        }

        .additional-info p {
            color: var(--sf-text-soft);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .registration-options {
                grid-template-columns: 1fr;
                max-width: 400px;
            }

            .card-header {
                padding: 1.75rem 1.5rem 1.25rem;
            }

            .card-body {
                padding: 0 1.5rem 0.75rem;
            }

            .card-footer {
                padding: 0.5rem 1.5rem 1.75rem;
            }

            .additional-info {
                margin: 2rem 0 0;
                padding: 1.75rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .registration-options {
                grid-template-columns: 1fr;
                padding: 0;
            }

            .card-badge {
                position: static;
                display: inline-block;
                margin-bottom: 0.75rem;
            }

            .card-icon-wrapper {
                width: 70px;
                height: 70px;
            }

            .card-icon {
                font-size: 1.75rem;
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
                <p class="sf-hero-greeting" data-key="hero.greeting">Selamat Datang!</p>
                <h1 class="sf-hero-title" data-key="hero.title">
                    <span class="sf-wave">👋</span> Mari Mula <span class="sf-highlight">Belajar!</span>
                </h1>
                <p class="sf-hero-subtitle" data-key="hero.subtitle">
                    Pilih cara daftar anda dan mulakan perjalanan pembelajaran yang menyeronokkan bersama kami!
                </p>
                <div class="sf-hero-features">
                    <div class="sf-hero-feature">
                        <i class="fas fa-star"></i>
                        <span data-key="hero.features.teachers">Guru Terbaik</span>
                    </div>
                    <div class="sf-hero-feature">
                        <i class="fas fa-book-open"></i>
                        <span data-key="hero.features.materials">Nota Lengkap</span>
                    </div>
                    <div class="sf-hero-feature">
                        <i class="fas fa-trophy"></i>
                        <span data-key="hero.features.tracking">Jejak Kemajuan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cards Section -->
    <section class="py-0 position-relative" style="z-index: 1; padding: 0 1rem 3rem;">
        <div class="container">
            <div class="registration-options">
                <!-- Individual Student Registration Card -->
                <a href="{{ route('student.register') }}" class="registration-card student-card">
                    <div class="card-header">
                        <span class="card-badge" data-key="individual.badge">Pelajar</span>
                        <div class="card-icon-wrapper">
                            <i class="fas fa-user-graduate card-icon"></i>
                        </div>
                        <h3 class="card-title" data-key="individual.title">Saya Pelajar 📚</h3>
                        <p class="card-subtitle" data-key="individual.subtitle">Daftar sendiri dan mula belajar dengan cara anda!</p>
                    </div>
                    <div class="card-body">
                        <ul class="features-list">
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="feature-text" data-key="individual.feature1">Akaun peribadi anda sendiri</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-school"></i>
                                </div>
                                <span class="feature-text" data-key="individual.feature2">Pilih sekolah yang anda suka</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <span class="feature-text" data-key="individual.feature3">Belajar bila-bila masa</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <span class="feature-text" data-key="individual.feature4">Lihat kemajuan anda</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <span class="feature-text" data-key="individual.feature5">Sokongan bila diperlukan</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="sf-btn sf-btn-primary sf-btn-block">
                            <span data-key="individual.button">Daftar Sekarang!</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>

                <!-- School Registration Card -->
                <a href="{{ route('school.auth') }}" class="registration-card school-card">
                    <div class="card-header">
                        <span class="card-badge" data-key="school.badge">Sekolah</span>
                        <div class="card-icon-wrapper">
                            <i class="fas fa-building card-icon"></i>
                        </div>
                        <h3 class="card-title" data-key="school.title">Kami dari Sekolah 🏫</h3>
                        <p class="card-subtitle" data-key="school.subtitle">Daftarkan ramai pelajar sekaligus!</p>
                    </div>
                    <div class="card-body">
                        <ul class="features-list">
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="feature-text" data-key="school.feature1">Daftar ramai pelajar sekali gus</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-file-excel"></i>
                                </div>
                                <span class="feature-text" data-key="school.feature2">Import guna fail Excel</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <span class="feature-text" data-key="school.feature3">Akaun untuk guru penyelaras</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <span class="feature-text" data-key="school.feature4">Pantau semua pelajar</span>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <span class="feature-text" data-key="school.feature5">Alatan pengurusan mudah</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="sf-btn sf-btn-success sf-btn-block">
                            <span data-key="school.button">Daftar Sekolah</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Additional Information -->
            <div class="additional-info">
                <h4>
                    <i class="fas fa-lightbulb"></i>
                    <span data-key="help.title">Perlukan Bantuan?</span>
                </h4>
                <p data-key="help.description">
                    Tak pasti nak pilih yang mana? Jangan risau, hubungi kami dan kami akan bantu anda!
                </p>
                <div class="sf-contact-info">
                    <div class="sf-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span data-key="contact.email">etuition@uniti.edu.my</span>
                    </div>
                    <div class="sf-contact-item">
                        <i class="fas fa-phone"></i>
                        <span data-key="contact.phone">+60 12-317 3853</span>
                    </div>
                    <div class="sf-contact-item">
                        <i class="fas fa-clock"></i>
                        <span data-key="contact.support">Isnin - Jumaat (9pg - 5ptg)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fun Footer -->
    <div class="sf-footer">
        <div class="sf-footer-emojis">📖 ✨ 🎓</div>
        <p class="sf-footer-text" data-key="footer.text">Jom mula belajar hari ini!</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Language Management Script -->
    <script>
        let currentLanguage = 'ms';
        
        const translations = {
            ms: {
                'hero.greeting': 'Selamat Datang!',
                'hero.title': '👋 Mari Mula Belajar!',
                'hero.subtitle': 'Pilih cara daftar anda dan mulakan perjalanan pembelajaran yang menyeronokkan bersama kami!',
                'hero.features.teachers': 'Guru Terbaik',
                'hero.features.materials': 'Nota Lengkap',
                'hero.features.tracking': 'Jejak Kemajuan',
                'individual.badge': 'Pelajar',
                'individual.title': 'Saya Pelajar 📚',
                'individual.subtitle': 'Daftar sendiri dan mula belajar dengan cara anda!',
                'individual.feature1': 'Akaun peribadi anda sendiri',
                'individual.feature2': 'Pilih sekolah yang anda suka',
                'individual.feature3': 'Belajar bila-bila masa',
                'individual.feature4': 'Lihat kemajuan anda',
                'individual.feature5': 'Sokongan bila diperlukan',
                'individual.button': 'Daftar Sekarang!',
                'school.badge': 'Sekolah',
                'school.title': 'Kami dari Sekolah 🏫',
                'school.subtitle': 'Daftarkan ramai pelajar sekaligus!',
                'school.feature1': 'Daftar ramai pelajar sekali gus',
                'school.feature2': 'Import guna fail Excel',
                'school.feature3': 'Akaun untuk guru penyelaras',
                'school.feature4': 'Pantau semua pelajar',
                'school.feature5': 'Alatan pengurusan mudah',
                'school.button': 'Daftar Sekolah',
                'help.title': 'Perlukan Bantuan?',
                'help.description': 'Tak pasti nak pilih yang mana? Jangan risau, hubungi kami dan kami akan bantu anda!',
                'contact.email': 'etuition@uniti.edu.my',
                'contact.phone': '+60 12-317 3853',
                'contact.support': 'Isnin - Jumaat (9pg - 5ptg)',
                'footer.text': 'Jom mula belajar hari ini!'
            },
            en: {
                'hero.greeting': 'Welcome!',
                'hero.title': "👋 Let's Start Learning!",
                'hero.subtitle': 'Choose how to register and begin your fun learning journey with us!',
                'hero.features.teachers': 'Best Teachers',
                'hero.features.materials': 'Complete Notes',
                'hero.features.tracking': 'Track Progress',
                'individual.badge': 'Student',
                'individual.title': "I'm a Student 📚",
                'individual.subtitle': 'Register yourself and start learning your way!',
                'individual.feature1': 'Your own personal account',
                'individual.feature2': 'Choose a school you like',
                'individual.feature3': 'Learn anytime you want',
                'individual.feature4': 'See your progress',
                'individual.feature5': 'Support when you need it',
                'individual.button': 'Register Now!',
                'school.badge': 'School',
                'school.title': "We're from a School 🏫",
                'school.subtitle': 'Register many students at once!',
                'school.feature1': 'Register many students together',
                'school.feature2': 'Import using Excel file',
                'school.feature3': 'Account for teacher coordinator',
                'school.feature4': 'Monitor all students',
                'school.feature5': 'Easy management tools',
                'school.button': 'Register School',
                'help.title': 'Need Help?',
                'help.description': "Not sure which to pick? Don't worry, contact us and we'll help you!",
                'contact.email': 'etuition@uniti.edu.my',
                'contact.phone': '+60 12-317 3853',
                'contact.support': 'Monday - Friday (9am - 5pm)',
                'footer.text': "Let's start learning today!"
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
                            element.innerHTML = '<span class="sf-wave">👋</span> Mari Mula <span class="sf-highlight">Belajar!</span>';
                        } else {
                            element.innerHTML = '<span class="sf-wave">👋</span> Let\'s Start <span class="sf-highlight">Learning!</span>';
                        }
                    } else {
                        element.textContent = translations[lang][key];
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
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
