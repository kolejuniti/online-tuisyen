<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KOLEJ UNITI - Online Tuition System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    <style>
        /* Base styles */
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --primary-light: #3B82F6;
            --secondary: #0EA5E9;
            --accent: #8B5CF6;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --dark: #1E293B;
            --light: #F8FAFC;
            --gray: #64748B;
            --gray-light: #CBD5E1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background-color: var(--light);
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Header & Navigation */
        header {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 45px;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.3s ease;
            padding: 0.5rem 0;
            position: relative;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary-light);
            color: white;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8rem 2rem 6rem;
            position: relative;
            overflow: hidden;
        }

        .hero-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: var(--dark);
        }

        .hero-title span {
            color: var(--primary);
            position: relative;
        }

        .hero-title span::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 6px;
            background-color: var(--accent);
            bottom: 5px;
            left: 0;
            z-index: -1;
            opacity: 0.5;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            color: var(--gray);
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .hero-image {
            flex: 1;
            position: relative;
        }

        .hero-image img {
            width: 100%;
            max-width: 600px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .features {
            display: flex;
            gap: 1.5rem;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            color: var(--primary);
        }

        /* Stats Section */
        .stats {
            background-color: var(--primary);
            padding: 5rem 2rem;
            color: white;
        }

        .stats-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-10px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.25rem;
            opacity: 0.9;
        }

        /* Courses Section */
        .courses {
            padding: 5rem 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
        }

        .courses-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .course-card {
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .course-image {
            height: 200px;
            overflow: hidden;
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover .course-image img {
            transform: scale(1.05);
        }

        .course-content {
            padding: 1.5rem;
        }

        .course-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: var(--primary-light);
            color: white;
            border-radius: 20px;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .course-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .course-desc {
            margin-bottom: 1.5rem;
            color: var(--gray);
        }

        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--gray-light);
            padding-top: 1rem;
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--warning);
        }

        .course-price {
            font-weight: 700;
            color: var(--primary);
        }

        /* Testimonials */
        .testimonials {
            background-color: #f8f9fa;
            padding: 5rem 2rem;
        }

        .testimonials-container {
            max-width: 1280px;
            margin: 0 auto;
            position: relative;
        }

        .testimonial-item {
            background-color: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .testimonial-quote {
            font-size: 1.25rem;
            font-style: italic;
            margin-bottom: 2rem;
            position: relative;
        }

        .testimonial-quote::before,
        .testimonial-quote::after {
            content: '"';
            font-size: 3rem;
            font-family: serif;
            color: var(--primary);
            opacity: 0.5;
            position: absolute;
        }

        .testimonial-quote::before {
            top: -20px;
            left: -20px;
        }

        .testimonial-quote::after {
            bottom: -40px;
            right: -20px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info {
            text-align: left;
        }

        .author-name {
            font-weight: 600;
            color: var(--dark);
        }

        .author-title {
            color: var(--gray);
            font-size: 0.875rem;
        }

        /* CTA Section */
        .cta-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            text-align: center;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-desc {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .btn-light {
            background-color: white;
            color: var(--primary);
        }

        .btn-light:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        .btn-outline-light {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 5rem 2rem 2rem;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-col h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
        }

        .footer-col p {
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: white;
            opacity: 0.8;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 1;
            color: var(--primary-light);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: var(--primary);
            transform: translateY(-5px);
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 0.875rem;
        }

        /* Animation classes */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile menu */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
        }

        .mobile-menu-toggle span {
            display: block;
            height: 3px;
            width: 100%;
            background-color: var(--dark);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 1rem;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .nav-menu {
                position: fixed;
                top: 80px;
                left: 0;
                width: 100%;
                background-color: white;
                padding: 2rem;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
                flex-direction: column;
                gap: 1.5rem;
                transform: translateY(-150%);
                transition: transform 0.3s ease;
                z-index: 90;
            }
            
            .nav-menu.active {
                transform: translateY(0);
            }
            
            .hero-container {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-content, .hero-image {
                max-width: 100%;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-cta {
                justify-content: center;
            }
            
            .features {
                justify-content: center;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .hero-cta {
                flex-direction: column;
            }
            
            .features {
                flex-direction: column;
                align-items: center;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .stat-label {
                font-size: 1rem;
            }
        }

        /* Shape Dividers */
        .shape-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .shape-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }

        .shape-divider .shape-fill {
            fill: #2563EB;
        }
        
        /* Floating Elements Animation */
        .floating-element {
            position: absolute;
            width: 100px;
            height: 100px;
            background-color: var(--primary);
            opacity: 0.1;
            border-radius: 50%;
            z-index: -1;
        }
        
        .floating-1 {
            top: 20%;
            left: 10%;
            width: 80px;
            height: 80px;
            animation: float-animation 10s ease-in-out infinite;
        }
        
        .floating-2 {
            top: 60%;
            right: 10%;
            width: 150px;
            height: 150px;
            background-color: var(--accent);
            animation: float-animation 15s ease-in-out infinite;
            animation-delay: 2s;
        }
        
        .floating-3 {
            bottom: 15%;
            left: 20%;
            width: 50px;
            height: 50px;
            background-color: var(--success);
            animation: float-animation 8s ease-in-out infinite;
            animation-delay: 1s;
        }
        
        @keyframes float-animation {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(20px, -20px) rotate(90deg);
            }
            50% {
                transform: translate(0, 30px) rotate(180deg);
            }
            75% {
                transform: translate(-20px, -10px) rotate(270deg);
            }
            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="nav-container">
            <div class="logo">
                <img src="/api/placeholder/100/100" alt="KOLEJ UNITI Logo" />
                <div class="logo-text">KOLEJ UNITI</div>
            </div>
            
            <div class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="#">Home</a></li>
                    <li><a href="#courses">Courses</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            
            <div class="auth-buttons">
                <a href="#" class="btn btn-outline">Log In</a>
                <a href="#" class="btn btn-primary">Register</a>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="floating-element floating-1"></div>
        <div class="floating-element floating-2"></div>
        <div class="floating-element floating-3"></div>
        
        <div class="hero-container">
            <div class="hero-content fade-in">
                <h1 class="hero-title">Transform Your Learning Journey with <span>KOLEJ UNITI</span></h1>
                <p class="hero-subtitle">Access quality education anytime, anywhere with our comprehensive online tuition system.</p>
                
                <div class="hero-cta">
                    <a href="#" class="btn btn-primary">Get Started</a>
                    <a href="#" class="btn btn-outline">Explore Courses</a>
                </div>
                
                <div class="features">
                    <div class="feature">
                        <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Expert Tutors</span>
                    </div>
                    
                    <div class="feature">
                        <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Flexible Hours</span>
                    </div>
                    
                    <div class="feature">
                        <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Interactive Learning</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-image fade-in">
                <img src="/api/placeholder/600/450" alt="Online Learning" />
            </div>
        </div>
        
        <div class="shape-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item fade-in">
                <div class="stat-number" id="student-count">0</div>
                <div class="stat-label">Students</div>
            </div>
            
            <div class="stat-item fade-in">
                <div class="stat-number" id="course-count">0</div>
                <div class="stat-label">Courses</div>
            </div>
            
            <div class="stat-item fade-in">
                <div class="stat-number" id="tutor-count">0</div>
                <div class="stat-label">Expert Tutors</div>
            </div>
            
            <div class="stat-item fade-in">
                <div class="stat-number" id="success-rate">0%</div>
                <div class="stat-label">Pass Rate</div>
            </div>
        </div>
    </section>
    
    <!-- Courses Section -->
    <section class="courses" id="courses">
        <div class="section-header fade-in">
            <h2 class="section-title">Featured Courses</h2>
            <p class="section-subtitle">Explore our wide range of courses designed to help you excel in your studies</p>
        </div>
        
        <div class="courses-container">
            <div class="course-card fade-in">
                <div class="course-image">
                    <img src="/api/placeholder/400/300" alt="Mathematics" />
                </div>
                <div class="course-content">
                    <span class="course-tag">Mathematics</span>
                    <h3 class="course-title">Advanced Mathematics</h3>
                    <p class="course-desc">Master complex mathematical concepts with our structured curriculum and expert guidance.</p>
                    <div class="course-meta">
                        <div class="course-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            4.8
                        </div>
                        <div class="course-price">RM 220</div>
                    </div>
                </div>
            </div>
            
            <div class="course-card fade-in">
                <div class="course-image">
                    <img src="/api/placeholder/400/300" alt="Science" />
                </div>
                <div class="course-content">
                    <span class="course-tag">Science</span>
                    <h3 class="course-title">Physics Fundamentals</h3>
                    <p class="course-desc">Build a strong foundation in physics with interactive lessons and practical experiments.</p>
                    <div class="course-meta">
                        <div class="course-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            4.7
                        </div>
                        <div class="course-price">RM 250</div>
                    </div>
                </div>
            </div>
            
            <div class="course-card fade-in">
                <div class="course-image">
                    <img src="/api/placeholder/400/300" alt="Language" />
                </div>
                <div class="course-content">
                    <span class="course-tag">Language</span>
                    <h3 class="course-title">English Proficiency</h3>
                    <p class="course-desc">Enhance your English language skills through interactive lessons focusing on speaking, writing, and comprehension.</p>
                    <div class="course-meta">
                        <div class="course-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            4.9
                        </div>
                        <div class="course-price">RM 200</div>
                    </div>
                </div>
            </div>
            
            <div class="course-card fade-in">
                <div class="course-image">
                    <img src="/api/placeholder/400/300" alt="Computer Science" />
                </div>
                <div class="course-content">
                    <span class="course-tag">Technology</span>
                    <h3 class="course-title">Introduction to Programming</h3>
                    <p class="course-desc">Learn the basics of programming with hands-on projects and interactive coding exercises.</p>
                    <div class="course-meta">
                        <div class="course-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            4.6
                        </div>
                        <div class="course-price">RM 280</div>
                    </div>
                </div>
            </div>
            
            <div class="course-card fade-in">
                <div class="course-image">
                    <img src="/api/placeholder/400/300" alt="History" />
                </div>
                <div class="course-content">
                    <span class="course-tag">History</span>
                    <h3 class="course-title">Malaysian History</h3>
                    <p class="course-desc">Explore the rich history of Malaysia through engaging lessons and comprehensive study materials.</p>
                    <div class="course-meta">
                        <div class="course-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            4.5
                        </div>
                        <div class="course-price">RM 180</div>
                    </div>
                </div>
            </div>
            
            <div class="course-card fade-in">
                <div class="course-image">
                    <img src="/api/placeholder/400/300" alt="Chemistry" />
                </div>
                <div class="course-content">
                    <span class="course-tag">Science</span>
                    <h3 class="course-title">Chemistry Mastery</h3>
                    <p class="course-desc">Develop your understanding of chemical principles through virtual labs and expert instruction.</p>
                    <div class="course-meta">
                        <div class="course-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            4.8
                        </div>
                        <div class="course-price">RM 250</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center fade-in" style="margin-top: 3rem; text-align: center;">
            <a href="#" class="btn btn-primary">View All Courses</a>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="about-section" id="about" style="padding: 5rem 2rem; background-color: #f8f9fa;">
        <div style="max-width: 1280px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; gap: 3rem;">
            <div class="fade-in" style="flex: 1; min-width: 300px;">
                <img src="/api/placeholder/600/400" alt="About KOLEJ UNITI" style="width: 100%; border-radius: 16px; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);" />
            </div>
            
            <div class="fade-in" style="flex: 1; min-width: 300px;">
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--dark);">About KOLEJ UNITI</h2>
                <p style="margin-bottom: 1.5rem; color: var(--gray); font-size: 1.1rem; line-height: 1.6;">KOLEJ UNITI Sdn Bhd is a premier educational institution committed to providing high-quality education and training to students across Malaysia. With our new online tuition system, we're extending our reach beyond physical classrooms to offer accessible education to all.</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem; background-color: white; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="var(--primary)" viewBox="0 0 16 16" style="margin-bottom: 1rem;">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                        </svg>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Our Mission</h3>
                        <p style="color: var(--gray); font-size: 0.9rem;">To provide accessible, quality education that empowers students to reach their full potential.</p>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem; background-color: white; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="var(--primary)" viewBox="0 0 16 16" style="margin-bottom: 1rem;">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM6.5 5A1.5 1.5 0 0 1 8 6.5V8a.5.5 0 0 1-1 0V6.5A.5.5 0 0 0 6.5 6a.5.5 0 0 1 0-1zM8 9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 8 9z"/>
                        </svg>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Our Vision</h3>
                        <p style="color: var(--gray); font-size: 0.9rem;">To be the leading online education provider in Malaysia and beyond.</p>
                    </div>
                </div>
                
                <a href="#" class="btn btn-primary">Learn More About Us</a>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="section-header fade-in">
            <h2 class="section-title">What Our Students Say</h2>
            <p class="section-subtitle">Hear from our students about their experience with our online tuition system</p>
        </div>
        
        <div class="testimonials-container">
            <div class="testimonial-item fade-in">
                <div class="testimonial-quote">
                    "KOLEJ UNITI's online tuition program has been a game-changer for me. The flexible schedule allows me to balance my studies with other commitments, and the tutors are incredibly knowledgeable and supportive. My grades have improved significantly since joining!"
                </div>
                
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="/api/placeholder/60/60" alt="Student Avatar" />
                    </div>
                    <div class="author-info">
                        <div class="author-name">Sarah Abdullah</div>
                        <div class="author-title">Mathematics Student</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- How It Works Section -->
    <section style="padding: 5rem 2rem;">
        <div class="section-header fade-in">
            <h2 class="section-title">How Our Online Tuition Works</h2>
            <p class="section-subtitle">Get started with our simple and effective learning process</p>
        </div>
        
        <div style="max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div class="fade-in" style="text-align: center; padding: 2rem; position: relative;">
                <div style="width: 80px; height: 80px; background-color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 2rem; font-weight: 700;">1</div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: var(--dark);">Register Online</h3>
                <p style="color: var(--gray);">Create your account and complete your profile to get started with our online tuition system.</p>
                
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="30" viewBox="0 0 100 30" style="position: absolute; right: -50px; top: 50%; transform: translateY(-50%); display: none;">
                    <path d="M0 15 L90 15 L80 5 M90 15 L80 25" stroke="var(--primary)" stroke-width="2" fill="none" />
                </svg>
            </div>
            
            <div class="fade-in" style="text-align: center; padding: 2rem; position: relative;">
                <div style="width: 80px; height: 80px; background-color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 2rem; font-weight: 700;">2</div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: var(--dark);">Choose Your Courses</h3>
                <p style="color: var(--gray);">Browse through our wide range of courses and select the ones that match your educational needs.</p>
                
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="30" viewBox="0 0 100 30" style="position: absolute; right: -50px; top: 50%; transform: translateY(-50%); display: none;">
                    <path d="M0 15 L90 15 L80 5 M90 15 L80 25" stroke="var(--primary)" stroke-width="2" fill="none" />
                </svg>
            </div>
            
            <div class="fade-in" style="text-align: center; padding: 2rem; position: relative;">
                <div style="width: 80px; height: 80px; background-color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 2rem; font-weight: 700;">3</div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: var(--dark);">Start Learning</h3>
                <p style="color: var(--gray);">Access your courses, interact with tutors, and begin your learning journey with our comprehensive resources.</p>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container fade-in">
            <h2 class="cta-title">Ready to Start Your Learning Journey?</h2>
            <p class="cta-desc">Join thousands of students who have transformed their education experience with KOLEJ UNITI's online tuition system.</p>
            
            <div class="cta-buttons">
                <a href="#" class="btn btn-light">Get Started Now</a>
                <a href="#" class="btn btn-outline-light">Contact Us</a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer id="contact">
        <div class="footer-container">
            <div class="footer-col">
                <h3>About Us</h3>
                <p>KOLEJ UNITI is a leading educational institution committed to providing quality education through innovative online learning solutions.</p>
                
                <div class="social-links">
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#courses">Courses</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Courses</h3>
                <ul class="footer-links">
                    <li><a href="#">Mathematics</a></li>
                    <li><a href="#">Science</a></li>
                    <li><a href="#">Languages</a></li>
                    <li><a href="#">History</a></li>
                    <li><a href="#">Computer Science</a></li>
                    <li><a href="#">View All Courses</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Contact Us</h3>
                <ul class="footer-links">
                    <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        123 Education Street, Kuala Lumpur, Malaysia
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        +60 3-1234 5678
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                        </svg>
                        info@kolejuniti.edu.my
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                        </svg>
                        Monday - Friday: 9:00 AM - 6:00 PM
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            &copy; 2025 KOLEJ UNITI Sdn Bhd. All Rights Reserved.
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const navMenu = document.querySelector('.nav-menu');
        
        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                
                // Animate hamburger to X
                const spans = menuToggle.querySelectorAll('span');
                spans.forEach(span => span.classList.toggle('active'));
            });
        }
        
        // Intersection Observer for fade-in animations
        const fadeElements = document.querySelectorAll('.fade-in');
        
        const fadeInObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    fadeInObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        fadeElements.forEach(element => {
            fadeInObserver.observe(element);
        });
        
        // Counter animation for stats
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16); // Update every 16ms
            
            function updateCounter() {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            }
            
            updateCounter();
        }
        
        // Start counter animations when stats section is in view
        const statsSection = document.querySelector('.stats');
        const studentCount = document.getElementById('student-count');
        const courseCount = document.getElementById('course-count');
        const tutorCount = document.getElementById('tutor-count');
        const successRate = document.getElementById('success-rate');
        
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (studentCount) animateCounter(studentCount, 5000);
                    if (courseCount) animateCounter(courseCount, 120);
                    if (tutorCount) animateCounter(tutorCount, 80);
                    if (successRate) animateCounter(successRate, 98);
                    
                    // Add % sign after counter animation completes
                    setTimeout(() => {
                        if (successRate) successRate.textContent += '%';
                    }, 2000);
                    
                    statsObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });
        
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
        
        // Show arrows between process steps on larger screens
        function updateProcessArrows() {
            const processArrows = document.querySelectorAll('.how-it-works svg');
            if (window.innerWidth > 768) {
                processArrows.forEach(arrow => {
                    arrow.style.display = 'block';
                });
            } else {
                processArrows.forEach(arrow => {
                    arrow.style.display = 'none';
                });
            }
        }
        
        // Update on page load and resize
        window.addEventListener('load', updateProcessArrows);
        window.addEventListener('resize', updateProcessArrows);
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Close mobile menu if open
                    if (navMenu && navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                    }
                    
                    window.scrollTo({
                        top: targetElement.offsetTop - 80, // Account for fixed header
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Dynamic header background on scroll
        const header = document.querySelector('header');
        
        function updateHeaderBackground() {
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.05)';
            }
        }
        
        window.addEventListener('scroll', updateHeaderBackground);
        updateHeaderBackground(); // Initial check
        
        // Testimonial slider functionality (if multiple testimonials)
        // This is a simplified version - for production, consider using a proper slider library
        const testimonials = [
            {
                quote: "KOLEJ UNITI's online tuition program has been a game-changer for me. The flexible schedule allows me to balance my studies with other commitments, and the tutors are incredibly knowledgeable and supportive. My grades have improved significantly since joining!",
                name: "Sarah Abdullah",
                title: "Mathematics Student"
            },
            {
                quote: "As a working professional looking to further my education, KOLEJ UNITI's online platform has been perfect. The courses are well-structured, and the interactive learning tools make complex subjects easy to understand. The 24/7 access to study materials is extremely convenient.",
                name: "Ahmad Rizal",
                title: "Computer Science Student"
            },
            {
                quote: "The personalized attention from tutors at KOLEJ UNITI is what sets them apart. They identified my weak areas and created a customized study plan that helped me excel in my exams. The online discussion forums also provide a great way to connect with other students.",
                name: "Lee Wei Ming",
                title: "Physics Student"
            }
        ];
        
        let currentTestimonialIndex = 0;
        const testimonialItem = document.querySelector('.testimonial-item');
        const testimonialQuote = document.querySelector('.testimonial-quote');
        const authorName = document.querySelector('.author-name');
        const authorTitle = document.querySelector('.author-title');
        
        function changeTestimonial() {
            // Fade out
            testimonialItem.style.opacity = 0;
            
            setTimeout(() => {
                // Update content
                currentTestimonialIndex = (currentTestimonialIndex + 1) % testimonials.length;
                const current = testimonials[currentTestimonialIndex];
                
                testimonialQuote.textContent = current.quote;
                authorName.textContent = current.name;
                authorTitle.textContent = current.title;
                
                // Fade in
                testimonialItem.style.opacity = 1;
            }, 500);
        }
        
        // Change testimonial every 5 seconds
        if (testimonialItem && testimonialQuote && authorName && authorTitle) {
            testimonialItem.style.transition = 'opacity 0.5s ease';
            setInterval(changeTestimonial, 5000);
        }
    </script>
    
    <!-- Additional CSS for Animations -->
    <style>
        /* Mobile menu toggle animation */
        .mobile-menu-toggle span {
            transition: all 0.3s ease;
        }
        
        .mobile-menu-toggle span.active:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }
        
        .mobile-menu-toggle span.active:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-toggle span.active:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }
        
        /* Staggered fade-in animation for course cards */
        .course-card:nth-child(1) {
            transition-delay: 0.1s;
        }
        
        .course-card:nth-child(2) {
            transition-delay: 0.2s;
        }
        
        .course-card:nth-child(3) {
            transition-delay: 0.3s;
        }
        
        .course-card:nth-child(4) {
            transition-delay: 0.4s;
        }
        
        .course-card:nth-child(5) {
            transition-delay: 0.5s;
        }
        
        .course-card:nth-child(6) {
            transition-delay: 0.6s;
        }
        
        /* Stat item hover animation */
        .stat-item:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        /* Pulse animation for CTA buttons */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }
        
        .cta-buttons .btn-light {
            animation: pulse 2s infinite;
        }
        
        /* Glow effect for primary color elements */
        .btn-primary:hover, .stat-item:hover {
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.5);
        }
        
        /* Rotating logo animation */
        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Wave animation for the divider */
        @keyframes wave {
            0% {
                transform: translateX(0) translateZ(0) scaleY(1);
            }
            50% {
                transform: translateX(-25%) translateZ(0) scaleY(0.95);
            }
            100% {
                transform: translateX(-50%) translateZ(0) scaleY(1);
            }
        }
        
        .shape-divider svg {
            animation: wave 15s linear infinite;
            width: calc(200% + 1.3px);
        }
        
        /* Scrollbar customization */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        
        /* Loading animation (can be used for course content loading) */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite linear;
        }
    </style>
</body>
</html>