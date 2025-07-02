<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Registration Type - Online Tuition Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
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
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-feature i {
            color: #ffd60a;
        }

        .main-container {
            margin: -3rem auto 3rem;
            max-width: 1200px;
            position: relative;
        }

        .registration-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
        }

        .registration-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: var(--shadow-heavy);
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .registration-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-heavy), 0 25px 50px rgba(99, 102, 241, 0.2);
            color: inherit;
            text-decoration: none;
        }

        .registration-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            pointer-events: none;
        }

        .card-header {
            padding: 3rem 2.5rem 2rem;
            text-align: center;
            position: relative;
        }

        .card-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 4px 8px rgba(99, 102, 241, 0.3));
        }

        .school-card .card-icon {
            background: linear-gradient(135deg, var(--success-color), #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 4px 8px rgba(6, 214, 160, 0.3));
        }

        .card-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-text);
        }

        .card-subtitle {
            font-size: 1.1rem;
            color: var(--gray-text);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .card-body {
            padding: 0 2.5rem 2rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            transition: all 0.3s ease;
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .features-list li:hover {
            transform: translateX(5px);
            color: var(--primary-color);
        }

        .features-list i {
            color: var(--primary-color);
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .school-card .features-list i {
            color: var(--success-color);
        }

        .card-footer {
            padding: 0 2.5rem 3rem;
        }

        .btn-card {
            width: 100%;
            padding: 1rem 2rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-card:hover::before {
            left: 100%;
        }

        .btn-individual {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-individual:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .btn-school {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(6, 214, 160, 0.3);
        }

        .btn-school:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(6, 214, 160, 0.4);
            color: white;
        }

        .additional-info {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin: 3rem 2rem 0;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.15);
        }

        .additional-info h4 {
            color: var(--dark-text);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .additional-info p {
            color: var(--gray-text);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--dark-text);
            font-weight: 600;
            background: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.5);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.1);
        }

        .contact-item i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        /* Floating animation for hero features */
        .hero-feature:nth-child(1) { animation: float 6s ease-in-out infinite; }
        .hero-feature:nth-child(2) { animation: float 6s ease-in-out infinite 1.5s; }
        .hero-feature:nth-child(3) { animation: float 6s ease-in-out infinite 3s; }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-features {
                flex-direction: column;
                gap: 1rem;
                max-width: 300px;
                margin: 2rem auto 0;
            }

            .registration-options {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 0 1rem;
            }

            .card-header {
                padding: 2rem 1.5rem 1.5rem;
            }

            .card-body {
                padding: 0 1.5rem 1.5rem;
            }

            .card-footer {
                padding: 0 1.5rem 2rem;
            }

            .card-icon {
                font-size: 3rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .additional-info {
                margin: 2rem 1rem 0;
                padding: 1.5rem;
            }

            .contact-info {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .registration-options {
                padding: 0 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title animate__animated animate__fadeInDown">Join Our Learning Platform</h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                    Choose your registration type and unlock access to comprehensive online learning resources, expert guidance, and academic excellence.
                </p>
                <div class="hero-features animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="hero-feature">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Expert Teachers</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-book"></i>
                        <span>Comprehensive Materials</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-chart-line"></i>
                        <span>Progress Tracking</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Options -->
    <div class="container">
        <div class="main-container">
            <div class="registration-options animate__animated animate__fadeInUp animate__delay-2s">
                <!-- Individual Student Registration Card -->
                <a href="{{ route('student.register') }}" class="registration-card animate__animated animate__fadeInLeft animate__delay-3s">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3 class="card-title">Individual Student</h3>
                        <p class="card-subtitle">Perfect for individual learners seeking personalized education</p>
                    </div>
                    <div class="card-body">
                        <ul class="features-list">
                            <li>
                                <i class="fas fa-user"></i>
                                <span>Personal account creation</span>
                            </li>
                            <li>
                                <i class="fas fa-school"></i>
                                <span>Select from registered schools</span>
                            </li>
                            <li>
                                <i class="fas fa-clock"></i>
                                <span>Flexible learning schedule</span>
                            </li>
                            <li>
                                <i class="fas fa-certificate"></i>
                                <span>Individual progress tracking</span>
                            </li>
                            <li>
                                <i class="fas fa-headset"></i>
                                <span>Direct student support</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="btn-card btn-individual">
                            <i class="fas fa-arrow-right"></i>
                            <span>Register as Student</span>
                        </div>
                    </div>
                </a>

                <!-- School Registration Card -->
                <a href="{{ route('school.register') }}" class="registration-card school-card animate__animated animate__fadeInRight animate__delay-3s">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-school"></i>
                        </div>
                        <h3 class="card-title">School Institution</h3>
                        <p class="card-subtitle">Ideal for schools wanting to register multiple students</p>
                    </div>
                    <div class="card-body">
                        <ul class="features-list">
                            <li>
                                <i class="fas fa-users"></i>
                                <span>Bulk student registration</span>
                            </li>
                            <li>
                                <i class="fas fa-file-excel"></i>
                                <span>Excel import functionality</span>
                            </li>
                            <li>
                                <i class="fas fa-user-tie"></i>
                                <span>Teacher coordinator account</span>
                            </li>
                            <li>
                                <i class="fas fa-chart-bar"></i>
                                <span>Institution-wide analytics</span>
                            </li>
                            <li>
                                <i class="fas fa-cogs"></i>
                                <span>Advanced management tools</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="btn-card btn-school">
                            <i class="fas fa-arrow-right"></i>
                            <span>Register as School</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Additional Information -->
            <div class="additional-info animate__animated animate__fadeInUp animate__delay-4s">
                <h4>Need Help Choosing?</h4>
                <p>
                    If you're unsure which registration type suits your needs, feel free to contact our support team. 
                    We're here to help you get started with the right account type for your learning journey.
                </p>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>support@onlinetuition.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+60 12-345 6789</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Support Available</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 