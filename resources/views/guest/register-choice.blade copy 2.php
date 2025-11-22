<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Registration Type - Online Tuition Platform</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Italiana&family=Manrope:wght@300;400;500;600&display=swap');
        
        :root {
            --bg-root: #050807;
            --bg-surface: #0f1614;
            --bg-card: #141d1a;
            
            --gold-primary: #c5a059;
            --gold-hover: #dcc185;
            --gold-dim: rgba(197, 160, 89, 0.1);
            
            --text-main: #ececec;
            --text-muted: #8d9a96;
            
            --border-light: rgba(255, 255, 255, 0.08);
            --border-accent: rgba(197, 160, 89, 0.3);
            
            --font-display: 'Italiana', serif;
            --font-body: 'Manrope', sans-serif;
            
            --ease-out: cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-root);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Ambient Background */
        .ambient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 15% 50%, rgba(10, 50, 40, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 85% 30%, rgba(40, 30, 10, 0.3) 0%, transparent 60%);
            filter: contrast(120%) brightness(0.8);
        }

        .noise-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
            z-index: -1;
            opacity: 0.5;
            pointer-events: none;
        }

        /* Layout */
        .page-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        /* Header / Hero */
        .header-section {
            margin-top: 4vh;
            margin-bottom: 4rem;
            text-align: center;
            position: relative;
        }

        .brand-line {
            width: 1px;
            height: 60px;
            background: linear-gradient(to bottom, transparent, var(--gold-primary));
            margin: 0 auto 1.5rem;
            opacity: 0;
            animation: slideDown 1s var(--ease-out) forwards;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 400;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            background: linear-gradient(to bottom, #fff 30%, #aaaaaa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0;
            animation: fadeInUp 1s var(--ease-out) 0.2s forwards;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 1.2vw, 1.2rem);
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
            opacity: 0;
            animation: fadeInUp 1s var(--ease-out) 0.4s forwards;
        }

        /* Features Row */
        .hero-features {
            display: inline-flex;
            gap: 3rem;
            margin-top: 2.5rem;
            border-top: 1px solid var(--border-light);
            padding-top: 2rem;
            opacity: 0;
            animation: fadeInUp 1s var(--ease-out) 0.6s forwards;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: var(--text-main);
            font-weight: 500;
        }

        .hero-feature i {
            color: var(--gold-primary);
        }

        /* Cards Container */
        .choice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
            perspective: 1000px;
        }

        /* Card Styles */
        .choice-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            padding: 3rem 2.5rem;
            text-decoration: none;
            color: inherit;
            position: relative;
            transition: transform 0.4s var(--ease-out), border-color 0.3s ease, box-shadow 0.4s ease;
            display: flex;
            flex-direction: column;
            opacity: 0;
            overflow: hidden;
        }

        .choice-card:nth-child(1) {
            animation: fadeInUp 1s var(--ease-out) 0.8s forwards;
        }
        
        .choice-card:nth-child(2) {
            animation: fadeInUp 1s var(--ease-out) 1.0s forwards;
        }

        .choice-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--mouse-x) var(--mouse-y), rgba(255, 255, 255, 0.03), transparent 40%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .choice-card:hover::before {
            opacity: 1;
        }

        .choice-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-accent);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5);
        }

        .card-header-icon {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: var(--gold-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gold-dim);
            border: 1px solid rgba(197, 160, 89, 0.2);
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 2rem;
            margin-bottom: 0.75rem;
            color: var(--text-main);
        }

        .card-desc {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2.5rem;
            min-height: 3.2em;
        }

        .feature-list {
            list-style: none;
            margin-bottom: 3rem;
            flex-grow: 1;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-list i {
            color: var(--gold-primary);
            font-size: 0.8rem;
        }

        .card-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            background: transparent;
            border: 1px solid var(--text-main);
            color: var(--text-main);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .card-btn i {
            transition: transform 0.3s ease;
        }

        .choice-card:hover .card-btn {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
            color: var(--bg-root);
        }

        .choice-card:hover .card-btn i {
            transform: translateX(5px);
        }

        /* Footer / Help */
        .help-section {
            text-align: center;
            padding: 3rem;
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            max-width: 800px;
            margin: 0 auto;
            opacity: 0;
            animation: fadeInUp 1s var(--ease-out) 1.2s forwards;
        }

        .help-title {
            font-family: var(--font-display);
            font-size: 1.75rem;
            margin-bottom: 1rem;
            color: var(--gold-primary);
        }

        .help-text {
            color: var(--text-muted);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .contact-row {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            font-size: 0.9rem;
        }

        .contact-pill {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-light);
            border-radius: 50px;
            color: var(--text-main);
            transition: border-color 0.3s ease;
        }

        .contact-pill:hover {
            border-color: var(--gold-primary);
        }

        .contact-pill i {
            color: var(--gold-primary);
        }

        /* Language Switcher */
        .lang-switch {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            gap: 0.5rem;
            background: var(--bg-surface);
            padding: 0.5rem;
            border: 1px solid var(--border-light);
            border-radius: 4px;
            z-index: 10;
        }

        .lang-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .lang-btn:hover {
            color: var(--text-main);
        }

        .lang-btn.active {
            background: var(--border-light);
            color: var(--gold-primary);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: scaleY(0);
                transform-origin: top;
            }
            to {
                opacity: 1;
                transform: scaleY(1);
                transform-origin: top;
            }
        }

        @media (max-width: 768px) {
            .hero-features {
                flex-direction: column;
                gap: 1rem;
                align-items: center;
            }
            
            .choice-grid {
                grid-template-columns: 1fr;
            }
            
            .lang-switch {
                top: 1rem;
                right: 1rem;
            }
            
            .header-section {
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="ambient-bg"></div>
    <div class="noise-overlay"></div>

    <!-- Language Switcher -->
    <div class="lang-switch">
        <button class="lang-btn active" data-lang="ms" onclick="switchLanguage('ms')">BM</button>
        <button class="lang-btn" data-lang="en" onclick="switchLanguage('en')">EN</button>
    </div>

    <div class="page-wrapper">
        <!-- Header -->
        <header class="header-section">
            <div class="brand-line"></div>
            <h1 class="hero-title" data-key="hero.title">Sertai Platform Pembelajaran Kami</h1>
            <p class="hero-subtitle" data-key="hero.subtitle">
                Pilih jenis pendaftaran anda dan buka akses kepada sumber pembelajaran dalam talian yang komprehensif, bimbingan pakar, dan kecemerlangan akademik.
            </p>
            
            <div class="hero-features">
                <div class="hero-feature">
                    <i class="fa fa-check-circle"></i>
                    <span data-key="hero.features.teachers">Guru Pakar</span>
                </div>
                <div class="hero-feature">
                    <i class="fa fa-check-circle"></i>
                    <span data-key="hero.features.materials">Bahan Komprehensif</span>
                </div>
                <div class="hero-feature">
                    <i class="fa fa-check-circle"></i>
                    <span data-key="hero.features.tracking">Penjejakan Kemajuan</span>
                </div>
            </div>
        </header>

        <!-- Choices -->
        <div class="choice-grid" id="cards-container">
            <!-- Student Card -->
            <a href="{{ route('student.register') }}" class="choice-card">
                <div class="card-header-icon">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <h2 class="card-title" data-key="individual.title">Pelajar Individu</h2>
                <p class="card-desc" data-key="individual.subtitle">Sesuai untuk pelajar individu yang mencari pendidikan peribadi</p>
                
                <ul class="feature-list">
                    <li><i class="fa fa-check"></i><span data-key="individual.feature1">Pembuatan akaun peribadi</span></li>
                    <li><i class="fa fa-check"></i><span data-key="individual.feature2">Pilih dari sekolah berdaftar</span></li>
                    <li><i class="fa fa-check"></i><span data-key="individual.feature3">Jadual pembelajaran fleksibel</span></li>
                    <li><i class="fa fa-check"></i><span data-key="individual.feature4">Penjejakan kemajuan individu</span></li>
                    <li><i class="fa fa-check"></i><span data-key="individual.feature5">Sokongan pelajar langsung</span></li>
                </ul>

                <div class="card-btn">
                    <span data-key="individual.button">Daftar sebagai Pelajar</span>
                    <i class="fa fa-arrow-right"></i>
                </div>
            </a>

            <!-- School Card -->
            <a href="{{ route('school.auth') }}" class="choice-card">
                <div class="card-header-icon">
                    <i class="fa fa-university"></i>
                </div>
                <h2 class="card-title" data-key="school.title">Institusi Sekolah</h2>
                <p class="card-desc" data-key="school.subtitle">Ideal untuk sekolah yang ingin mendaftarkan pelbagai pelajar</p>
                
                <ul class="feature-list">
                    <li><i class="fa fa-check"></i><span data-key="school.feature1">Pendaftaran pelajar berkelompok</span></li>
                    <li><i class="fa fa-check"></i><span data-key="school.feature2">Fungsi import Excel</span></li>
                    <li><i class="fa fa-check"></i><span data-key="school.feature3">Akaun koordinator guru</span></li>
                    <li><i class="fa fa-check"></i><span data-key="school.feature4">Analisis seluruh institusi</span></li>
                    <li><i class="fa fa-check"></i><span data-key="school.feature5">Alat pengurusan canggih</span></li>
                </ul>

                <div class="card-btn">
                    <span data-key="school.button">Daftar sebagai Sekolah</span>
                    <i class="fa fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Footer Help -->
        <div class="help-section">
            <h3 class="help-title" data-key="help.title">Perlu Bantuan Memilih?</h3>
            <p class="help-text" data-key="help.description">
                Jika anda tidak pasti jenis pendaftaran mana yang sesuai dengan keperluan anda, jangan ragu untuk menghubungi pasukan sokongan kami. 
                Kami di sini untuk membantu anda memulakan dengan jenis akaun yang betul untuk perjalanan pembelajaran anda.
            </p>
            
            <div class="contact-row">
                <div class="contact-pill">
                    <i class="fa fa-envelope"></i>
                    <span data-key="contact.email">etuition@uniti.edu.my</span>
                </div>
                <div class="contact-pill">
                    <i class="fa fa-phone"></i>
                    <span data-key="contact.phone">+60 12-317 3853</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Logic -->
    <script>
        // Mouse tracking for hover effect
        const cardsContainer = document.getElementById('cards-container');
        const cards = document.querySelectorAll('.choice-card');

        cardsContainer.onmousemove = e => {
            for(const card of cards) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            }
        };

        // Language management
        const translations = {
            ms: {
                'hero.title': 'Sertai Platform Pembelajaran Kami',
                'hero.subtitle': 'Pilih jenis pendaftaran anda dan buka akses kepada sumber pembelajaran dalam talian yang komprehensif, bimbingan pakar, dan kecemerlangan akademik.',
                'hero.features.teachers': 'Guru Pakar',
                'hero.features.materials': 'Bahan Komprehensif',
                'hero.features.tracking': 'Penjejakan Kemajuan',
                'individual.title': 'Pelajar Individu',
                'individual.subtitle': 'Sesuai untuk pelajar individu yang mencari pendidikan peribadi',
                'individual.feature1': 'Pembuatan akaun peribadi',
                'individual.feature2': 'Pilih dari sekolah berdaftar',
                'individual.feature3': 'Jadual pembelajaran fleksibel',
                'individual.feature4': 'Penjejakan kemajuan individu',
                'individual.feature5': 'Sokongan pelajar langsung',
                'individual.button': 'Daftar sebagai Pelajar',
                'school.title': 'Institusi Sekolah',
                'school.subtitle': 'Ideal untuk sekolah yang ingin mendaftarkan pelbagai pelajar',
                'school.feature1': 'Pendaftaran pelajar berkelompok',
                'school.feature2': 'Fungsi import Excel',
                'school.feature3': 'Akaun koordinator guru',
                'school.feature4': 'Analisis seluruh institusi',
                'school.feature5': 'Alat pengurusan canggih',
                'school.button': 'Daftar sebagai Sekolah',
                'help.title': 'Perlu Bantuan Memilih?',
                'help.description': 'Jika anda tidak pasti jenis pendaftaran mana yang sesuai dengan keperluan anda, jangan ragu untuk menghubungi pasukan sokongan kami. Kami di sini untuk membantu anda memulakan dengan jenis akaun yang betul untuk perjalanan pembelajaran anda.',
                'contact.email': 'etuition@uniti.edu.my',
                'contact.phone': '+60 12-317 3853'
            },
            en: {
                'hero.title': 'Join Our Learning Platform',
                'hero.subtitle': 'Choose your registration type and unlock access to comprehensive online learning resources, expert guidance, and academic excellence.',
                'hero.features.teachers': 'Expert Teachers',
                'hero.features.materials': 'Comprehensive Materials',
                'hero.features.tracking': 'Progress Tracking',
                'individual.title': 'Individual Student',
                'individual.subtitle': 'Perfect for individual learners seeking personalized education',
                'individual.feature1': 'Personal account creation',
                'individual.feature2': 'Select from registered schools',
                'individual.feature3': 'Flexible learning schedule',
                'individual.feature4': 'Individual progress tracking',
                'individual.feature5': 'Direct student support',
                'individual.button': 'Register as Student',
                'school.title': 'School Institution',
                'school.subtitle': 'Ideal for schools wanting to register multiple students',
                'school.feature1': 'Bulk student registration',
                'school.feature2': 'Excel import functionality',
                'school.feature3': 'Teacher coordinator account',
                'school.feature4': 'Institution-wide analytics',
                'school.feature5': 'Advanced management tools',
                'school.button': 'Register as School',
                'help.title': 'Need Help Choosing?',
                'help.description': 'If you\'re unsure which registration type suits your needs, feel free to contact our support team. We\'re here to help you get started with the right account type for your learning journey.',
                'contact.email': 'etuition@uniti.edu.my',
                'contact.phone': '+60 12-317 3853'
            }
        };

        function switchLanguage(lang) {
            // Update buttons
            document.querySelectorAll('.lang-btn').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.lang === lang);
            });
            
            // Update content
            document.querySelectorAll('[data-key]').forEach(element => {
                const key = element.dataset.key;
                if (translations[lang] && translations[lang][key]) {
                    element.textContent = translations[lang][key];
                }
            });
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            switchLanguage('ms');
        });
    </script>
</body>
</html>