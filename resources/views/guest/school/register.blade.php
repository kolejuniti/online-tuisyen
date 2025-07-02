<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Registration - Online Tuition Platform</title>
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
            max-width: 600px;
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
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin: -3rem auto 3rem;
            border-radius: 24px;
            box-shadow: var(--shadow-heavy);
            overflow: hidden;
            max-width: 1200px;
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

        .progress-bar-container {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 2rem 1rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            position: relative;
        }

        .progress-bar-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.3), transparent);
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
            z-index: 2;
        }

        .step-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 0.75rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 3px solid white;
            font-size: 1.1rem;
            position: relative;
            z-index: 10;
        }

        .step.active .step-circle {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            transform: scale(1.15);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            z-index: 15;
        }

        .step.completed .step-circle {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(6, 214, 160, 0.3);
            z-index: 15;
        }

        .step-label {
            font-weight: 600;
            color: var(--gray-text);
            font-size: 0.9rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 700;
        }

        .step.completed .step-label {
            color: var(--success-color);
            font-weight: 700;
        }

        .step-line {
            position: absolute;
            top: 30px;
            left: calc(50% + 30px);
            width: calc(100% - 60px);
            height: 3px;
            background: linear-gradient(90deg, #e2e8f0, #cbd5e1);
            z-index: 1;
            border-radius: 3px;
        }

        .step.completed .step-line {
            background: linear-gradient(90deg, var(--success-color), #059669);
            z-index: 1;
        }

        .step:last-child .step-line {
            display: none;
        }

        .form-section {
            padding: 3rem 2.5rem;
            display: none;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02), rgba(248, 250, 252, 0.05));
        }

        .form-section.active {
            display: block;
            animation: fadeInUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
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

        .btn-outline-custom {
            background: rgba(255, 255, 255, 0.1);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            backdrop-filter: blur(10px);
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        }

        .upload-area {
            border: 3px dashed rgba(203, 213, 225, 0.8);
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8), rgba(241, 245, 249, 0.6));
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .upload-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .upload-area:hover {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(139, 92, 246, 0.05));
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15);
        }

        .upload-area:hover::before {
            opacity: 1;
        }

        .upload-area.dragover {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.08));
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 40px rgba(99, 102, 241, 0.2);
        }

        .upload-icon {
            font-size: 4rem;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .student-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 250, 252, 0.8));
            backdrop-filter: blur(15px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .student-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 20px 20px 0 0;
        }

        .student-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .student-card h5 {
            color: var(--dark-text);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-card h5 i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .remove-student {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(239, 71, 111, 0.3);
        }

        .remove-student:hover {
            transform: scale(1.1) rotate(90deg);
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 6px 20px rgba(239, 71, 111, 0.4);
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .template-download {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(6, 214, 160, 0.3);
        }

        .template-download::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            pointer-events: none;
        }

        .template-download h5 {
            position: relative;
            z-index: 2;
            margin-bottom: 0.75rem;
            font-weight: 700;
        }

        .template-download p {
            position: relative;
            z-index: 2;
            opacity: 0.9;
        }

        .template-download .btn {
            position: relative;
            z-index: 2;
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

        /* Floating animation for hero features */
        .hero-feature:nth-child(1) { animation: float 6s ease-in-out infinite; }
        .hero-feature:nth-child(2) { animation: float 6s ease-in-out infinite 1.5s; }
        .hero-feature:nth-child(3) { animation: float 6s ease-in-out infinite 3s; }
        .hero-feature:nth-child(4) { animation: float 6s ease-in-out infinite 4.5s; }

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

            .hero-features {
                flex-direction: column;
                gap: 1rem;
                max-width: 300px;
                margin: 2rem auto 0;
            }

            .hero-feature {
                justify-content: center;
                padding: 1rem 1.5rem;
            }
            
            .progress-steps {
                flex-direction: column;
                gap: 1.5rem;
            }
            
            .step-line {
                display: none;
            }

            .step-circle {
                width: 50px;
                height: 50px;
            }
            
            .navigation-buttons {
                flex-direction: column;
                gap: 1rem;
                padding: 1.5rem;
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

            .student-card {
                padding: 1.5rem;
            }

            .upload-area {
                padding: 3rem 1rem;
            }

            .upload-icon {
                font-size: 3rem;
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

            .template-download,
            .feature-highlight {
                padding: 1.5rem;
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
        }

        /* Alert messages styling */
        .alert {
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-left: 4px solid #047857;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-left: 4px solid #b91c1c;
        }

        .alert .btn-close {
            filter: invert(1);
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

        @media (max-width: 768px) {
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
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 mb-0">Processing your registration...</p>
        </div>
    </div>

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
                <h1 class="hero-title animate__animated animate__fadeInDown" data-key="hero.title">Transformasi Pendidikan dengan Platform Kami</h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s" data-key="hero.subtitle">
                    Sertai ribuan sekolah di seluruh dunia dalam merevolusi pendidikan dalam talian. Daftarkan institusi anda dan buka kunci alat berkuasa untuk pengurusan pelajar, penyampaian kandungan, dan kecemerlangan akademik.
                </p>
                <div class="hero-features animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="hero-feature">
                        <i class="fas fa-rocket"></i>
                        <span data-key="hero.features.setup">Persediaan Pantas</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-users"></i>
                        <span data-key="hero.features.import">Import Pelajar Berkelompok</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-shield-alt"></i>
                        <span data-key="hero.features.secure">Selamat & Boleh Dipercayai</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-chart-line"></i>
                        <span data-key="hero.features.analytics">Analisis Canggih</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Registration Container -->
    <div class="container">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="main-container animate__animated animate__fadeInUp animate__delay-2s">
            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-steps">
                    <div class="step active" data-step="1">
                        <div class="step-circle">1</div>
                        <span class="step-label" data-key="steps.school">Butiran Sekolah</span>
                        <div class="step-line"></div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-circle">2</div>
                        <span class="step-label" data-key="steps.students">Tambah Pelajar</span>
                        <div class="step-line"></div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-circle">3</div>
                        <span class="step-label" data-key="steps.review">Semak & Hantar</span>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <form id="registrationForm" method="POST" action="{{ route('school.register.submit') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Step 1: School Details -->
                <div class="form-section active" id="step1">
                    <h2 class="section-title">
                        <i class="fas fa-school text-primary"></i>
                        <span data-key="form.school.title">Maklumat Sekolah</span>
                    </h2>
                    <p class="section-description" data-key="form.school.description">
                        Sila berikan maklumat asas sekolah anda untuk memulakan dengan platform kami.
                    </p>

                    <!-- School Information Section -->
                    <div class="feature-highlight mb-4">
                        <h4><i class="fas fa-building text-primary"></i> <span data-key="form.school.info_title">Maklumat Sekolah</span></h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.school.name">Nama Sekolah</span> <span class="required">*</span>
                                    </label>
                                    <input type="text" name="school_name" class="form-control" data-placeholder-key="form.school.name_placeholder" placeholder="Masukkan nama sekolah anda" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.school.phone">Telefon Hubungan</span> <span class="required">*</span>
                                    </label>
                                    <input type="tel" name="phone" class="form-control" data-placeholder-key="form.school.phone_placeholder" placeholder="+60 12-345 6789" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.school.email">Alamat E-mel Sekolah</span> <span class="required">*</span>
                                    </label>
                                    <input type="email" name="school_email" class="form-control" data-placeholder-key="form.school.email_placeholder" placeholder="sekolah@contoh.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.school.type">Jenis Sekolah</span> <span class="required">*</span>
                                    </label>
                                    <select name="school_type" class="form-control" id="schoolTypeSelect" required>
                                        <option value="" data-key="form.school.type_placeholder">Pilih jenis sekolah</option>
                                        <option value="public" data-key="form.school.types.public">Sekolah Kerajaan</option>
                                        <option value="private" data-key="form.school.types.private">Sekolah Swasta</option>
                                        <option value="charter" data-key="form.school.types.charter">Sekolah Piagam</option>
                                        <option value="international" data-key="form.school.types.international">Sekolah Antarabangsa</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.school.address">Alamat Sekolah</span> <span class="required">*</span>
                                    </label>
                                    <textarea name="address" class="form-control" rows="3" data-placeholder-key="form.school.address_placeholder" placeholder="Masukkan alamat lengkap sekolah" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.school.total_students">Jumlah Pelajar (Anggaran)</span>
                                    </label>
                                    <input type="number" name="total_students" class="form-control" data-placeholder-key="form.school.total_placeholder" placeholder="cth: 500" min="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guru Pembimbing Section -->
                    <div class="feature-highlight">
                        <h4><i class="fas fa-user-tie text-success"></i> <span data-key="form.teacher.title">Guru Pembimbing</span></h4>
                        <p class="text-muted mb-3" data-key="form.teacher.description">Maklumat guru atau pentadbir yang akan bertanggungjawab menguruskan platform ini.</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.teacher.name">Nama Guru Pembimbing</span> <span class="required">*</span>
                                    </label>
                                    <input type="text" name="teacher_name" class="form-control" data-placeholder-key="form.teacher.name_placeholder" placeholder="Nama penuh guru pembimbing" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.teacher.email">E-mel Guru Pembimbing</span> <span class="required">*</span>
                                    </label>
                                    <input type="email" name="teacher_email" class="form-control" data-placeholder-key="form.teacher.email_placeholder" placeholder="guru@contoh.com" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Add Students -->
                <div class="form-section" id="step2">
                    <h2 class="section-title">
                        <i class="fas fa-users text-primary"></i>
                        <span data-key="form.students.title">Pengurusan Pelajar</span>
                    </h2>
                    <p class="section-description" data-key="form.students.description">
                        Tambah pelajar secara individu atau muat naik secara berkelompok menggunakan template Excel kami.
                    </p>

                    <!-- Bulk Upload Section -->
                    <div class="feature-highlight">
                        <h4><i class="fas fa-file-excel text-success"></i> <span data-key="form.bulk.title">Muat Naik Pelajar Berkelompok</span></h4>
                        <p class="mb-3" data-key="form.bulk.description">Jimat masa dengan memuat naik berbilang pelajar sekaligus menggunakan template Excel kami.</p>
                        
                        <div class="template-download">
                            <h5><i class="fas fa-download"></i> <span data-key="form.bulk.template_title">Muat Turun Template Excel</span></h5>
                            <p class="mb-3" data-key="form.bulk.template_description">Muat turun template Excel yang telah diformat untuk menambah maklumat pelajar anda</p>
                            <button type="button" class="btn btn-light btn-custom" id="downloadTemplate">
                                <i class="fas fa-file-excel"></i> <span data-key="form.bulk.download_btn">Muat Turun Template</span>
                            </button>
                        </div>

                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h4 data-key="form.bulk.drag_title">Seret & Lepas Fail Excel Di Sini</h4>
                            <p class="text-muted" data-key="form.bulk.browse_text">atau klik untuk cari fail</p>
                            <p class="small text-muted" data-key="form.bulk.format_info">Format disokong: .xlsx, .xls (Saiz maksimum: 10MB)</p>
                            <input type="file" name="students_excel" id="excelFile" accept=".xlsx,.xls" style="display: none;">
                        </div>

                        <div id="uploadProgress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                            </div>
                            <p class="mt-2 text-center" data-key="form.bulk.processing">Memproses fail Excel...</p>
                        </div>

                        <div id="uploadResults" class="mt-3" style="display: none;"></div>
                    </div>

                    <!-- Individual Student Addition -->
                    <div class="mt-4">
                        <h4><i class="fas fa-user-plus text-primary"></i> <span data-key="form.individual.title">Tambah Pelajar Individu</span></h4>
                        <p class="text-muted mb-3" data-key="form.individual.description">Tambah pelajar satu persatu menggunakan borang di bawah</p>
                        
                        <div id="studentsContainer">
                            <!-- Individual student forms will be added here -->
                        </div>

                        <button type="button" class="btn btn-outline-custom" id="addStudentBtn">
                            <i class="fas fa-plus"></i> <span data-key="form.individual.add_btn">Tambah Pelajar</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Review & Submit -->
                <div class="form-section" id="step3">
                    <h2 class="section-title">
                        <i class="fas fa-check-circle text-success"></i>
                        <span data-key="form.review.title">Semak & Hantar</span>
                    </h2>
                    <p class="section-description" data-key="form.review.description">
                        Sila semak semua maklumat sebelum menghantar pendaftaran anda.
                    </p>

                    <div id="reviewContent">
                        <!-- Review content will be populated by JavaScript -->
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong data-key="form.review.next_title">Apa yang berlaku seterusnya?</strong>
                        <ul class="mb-0 mt-2">
                            <li data-key="form.review.next_1">Pasukan kami akan menyemak pendaftaran anda dalam masa 24-48 jam</li>
                            <li data-key="form.review.next_2">Anda akan menerima e-mel pengesahan dengan butiran akaun anda</li>
                            <li data-key="form.review.next_3">Pelajar akan mendapat maklumat log masuk individu</li>
                            <li data-key="form.review.next_4">Anda boleh mula menggunakan platform selepas kelulusan</li>
                        </ul>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="navigation-buttons">
                    <button type="button" class="btn btn-outline-custom" id="prevBtn" style="display: none;">
                        <i class="fas fa-arrow-left"></i> <span data-key="nav.previous">Sebelumnya</span>
                    </button>
                    <div></div>
                    <button type="button" class="btn btn-primary-custom" id="nextBtn">
                        <span data-key="nav.next">Seterusnya</span> <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-primary-custom" id="submitBtn" style="display: none;">
                        <i class="fas fa-paper-plane"></i> <span data-key="nav.submit">Hantar Pendaftaran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Language management
        let currentLanguage = 'ms';
        
        const translations = {
            ms: {
                // Hero section
                'hero.title': 'Transformasi Pendidikan dengan Platform Kami',
                'hero.subtitle': 'Sertai ribuan sekolah di seluruh dunia dalam merevolusi pendidikan dalam talian. Daftarkan institusi anda dan buka kunci alat berkuasa untuk pengurusan pelajar, penyampaian kandungan, dan kecemerlangan akademik.',
                'hero.features.setup': 'Persediaan Pantas',
                'hero.features.import': 'Import Pelajar Berkelompok',
                'hero.features.secure': 'Selamat & Boleh Dipercayai',
                'hero.features.analytics': 'Analisis Canggih',
                
                // Steps
                'steps.school': 'Butiran Sekolah',
                'steps.students': 'Tambah Pelajar',
                'steps.review': 'Semak & Hantar',
                
                // Form - School
                'form.school.title': 'Maklumat Sekolah',
                'form.school.description': 'Sila berikan maklumat asas sekolah anda untuk memulakan dengan platform kami.',
                'form.school.info_title': 'Maklumat Sekolah',
                'form.school.name': 'Nama Sekolah',
                'form.school.name_placeholder': 'Masukkan nama sekolah anda',
                'form.school.phone': 'No. Telefon Sekolah',
                'form.school.phone_placeholder': '+60 12-345 6789',
                'form.school.email': 'Alamat E-mel Sekolah',
                'form.school.email_placeholder': 'sekolah@contoh.com',
                'form.school.address': 'Alamat Sekolah',
                'form.school.address_placeholder': 'Masukkan alamat lengkap sekolah',
                'form.school.type': 'Jenis Sekolah',
                'form.school.type_placeholder': 'Pilih jenis sekolah',
                'form.school.types.public': 'Sekolah Kerajaan',
                'form.school.types.private': 'Sekolah Swasta',
                'form.school.types.charter': 'Sekolah Piagam',
                'form.school.types.international': 'Sekolah Antarabangsa',
                'form.school.total_students': 'Jumlah Pelajar (Anggaran)',
                'form.school.total_placeholder': 'cth: 500',
                
                // Form - Teacher/Mentor
                'form.teacher.title': 'Guru Pembimbing',
                'form.teacher.description': 'Maklumat guru atau pentadbir yang akan bertanggungjawab menguruskan platform ini.',
                'form.teacher.name': 'Nama Guru Pembimbing',
                'form.teacher.name_placeholder': 'Nama penuh guru pembimbing',
                'form.teacher.email': 'E-mel Guru Pembimbing',
                'form.teacher.email_placeholder': 'guru@contoh.com',
                
                // Form - Students
                'form.students.title': 'Pengurusan Pelajar',
                'form.students.description': 'Tambah pelajar secara individu atau muat naik secara berkelompok menggunakan template Excel kami.',
                
                // Form - Bulk Upload
                'form.bulk.title': 'Muat Naik Pelajar Berkelompok',
                'form.bulk.description': 'Jimat masa dengan memuat naik berbilang pelajar sekaligus menggunakan template Excel kami.',
                'form.bulk.template_title': 'Muat Turun Template Excel',
                'form.bulk.template_description': 'Muat turun template Excel yang telah diformat untuk menambah maklumat pelajar anda',
                'form.bulk.download_btn': 'Muat Turun Template',
                'form.bulk.drag_title': 'Seret & Lepas Fail Excel Di Sini',
                'form.bulk.browse_text': 'atau klik untuk cari fail',
                'form.bulk.format_info': 'Format disokong: .xlsx, .xls (Saiz maksimum: 10MB)',
                'form.bulk.processing': 'Memproses fail Excel...',
                
                // Form - Individual
                'form.individual.title': 'Tambah Pelajar Individu',
                'form.individual.description': 'Tambah pelajar satu persatu menggunakan borang di bawah',
                'form.individual.add_btn': 'Tambah Pelajar',
                
                // Form - Student Details
                'form.student.title': 'Pelajar',
                'form.student.first_name': 'Nama Pertama',
                'form.student.first_name_placeholder': 'Nama pertama pelajar',
                'form.student.last_name': 'Nama Akhir',
                'form.student.last_name_placeholder': 'Nama akhir pelajar',
                'form.student.email': 'E-mel',
                'form.student.email_placeholder': 'e-mel@contoh.com',
                'form.student.grade': 'Tingkatan/Darjah',
                'form.student.grade_placeholder': 'Pilih tingkatan/darjah',
                'form.student.grades.darjah1': 'Darjah 1',
                'form.student.grades.darjah2': 'Darjah 2',
                'form.student.grades.darjah3': 'Darjah 3',
                'form.student.grades.darjah4': 'Darjah 4',
                'form.student.grades.darjah5': 'Darjah 5',
                'form.student.grades.darjah6': 'Darjah 6',
                'form.student.grades.form1': 'Tingkatan 1',
                'form.student.grades.form2': 'Tingkatan 2',
                'form.student.grades.form3': 'Tingkatan 3',
                'form.student.grades.form4': 'Tingkatan 4',
                'form.student.grades.form5': 'Tingkatan 5',
                'form.student.grades.form6': 'Tingkatan 6',
                
                // Form - Review
                'form.review.title': 'Semak & Hantar',
                'form.review.description': 'Sila semak semua maklumat sebelum menghantar pendaftaran anda.',
                'form.review.next_title': 'Apa yang berlaku seterusnya?',
                'form.review.next_1': 'Pasukan kami akan menyemak pendaftaran anda dalam masa 24-48 jam',
                'form.review.next_2': 'Anda akan menerima e-mel pengesahan dengan butiran akaun anda',
                'form.review.next_3': 'Pelajar akan mendapat maklumat log masuk individu',
                'form.review.next_4': 'Anda boleh mula menggunakan platform selepas kelulusan',
                
                // Navigation
                'nav.previous': 'Sebelumnya',
                'nav.next': 'Seterusnya',
                'nav.submit': 'Hantar Pendaftaran'
            },
            en: {
                // Hero section
                'hero.title': 'Transform Education with Our Platform',
                'hero.subtitle': 'Join thousands of schools worldwide in revolutionizing online education. Register your institution and unlock powerful tools for student management, content delivery, and academic excellence.',
                'hero.features.setup': 'Quick Setup',
                'hero.features.import': 'Bulk Student Import',
                'hero.features.secure': 'Secure & Reliable',
                'hero.features.analytics': 'Advanced Analytics',
                
                // Steps
                'steps.school': 'School Details',
                'steps.students': 'Add Students',
                'steps.review': 'Review & Submit',
                
                // Form - School
                'form.school.title': 'School Information',
                'form.school.description': 'Please provide your school\'s basic information to get started with our platform.',
                'form.school.info_title': 'School Information',
                'form.school.name': 'School Name',
                'form.school.name_placeholder': 'Enter your school name',
                'form.school.phone': 'School Phone Number',
                'form.school.phone_placeholder': '+1 (555) 123-4567',
                'form.school.email': 'School Email Address',
                'form.school.email_placeholder': 'school@example.com',
                'form.school.address': 'School Address',
                'form.school.address_placeholder': 'Enter complete school address',
                'form.school.type': 'School Type',
                'form.school.type_placeholder': 'Select school type',
                'form.school.types.public': 'Public School',
                'form.school.types.private': 'Private School',
                'form.school.types.charter': 'Charter School',
                'form.school.types.international': 'International School',
                'form.school.total_students': 'Total Students (Approximate)',
                'form.school.total_placeholder': 'e.g., 500',
                
                // Form - Teacher/Mentor
                'form.teacher.title': 'Teacher Coordinator',
                'form.teacher.description': 'Information of teacher or administrator who will be responsible for managing this platform.',
                'form.teacher.name': 'Teacher Coordinator Name',
                'form.teacher.name_placeholder': 'Teacher coordinator\'s full name',
                'form.teacher.email': 'Teacher Coordinator Email',
                'form.teacher.email_placeholder': 'teacher@example.com',
                
                // Form - Students
                'form.students.title': 'Student Management',
                'form.students.description': 'Add students individually or upload them in bulk using our Excel template.',
                
                // Form - Bulk Upload
                'form.bulk.title': 'Bulk Student Upload',
                'form.bulk.description': 'Save time by uploading multiple students at once using our Excel template.',
                'form.bulk.template_title': 'Download Excel Template',
                'form.bulk.template_description': 'Download our pre-formatted Excel template to add your students\' information',
                'form.bulk.download_btn': 'Download Template',
                'form.bulk.drag_title': 'Drag & Drop Excel File Here',
                'form.bulk.browse_text': 'or click to browse files',
                'form.bulk.format_info': 'Supported formats: .xlsx, .xls (Max size: 10MB)',
                'form.bulk.processing': 'Processing Excel file...',
                
                // Form - Individual
                'form.individual.title': 'Add Individual Students',
                'form.individual.description': 'Add students one by one using the form below',
                'form.individual.add_btn': 'Add Student',
                
                // Form - Student Details
                'form.student.title': 'Student',
                'form.student.first_name': 'First Name',
                'form.student.first_name_placeholder': 'Student\'s first name',
                'form.student.last_name': 'Last Name',
                'form.student.last_name_placeholder': 'Student\'s last name',
                'form.student.email': 'Email',
                'form.student.email_placeholder': 'email@example.com',
                'form.student.grade': 'Form/Standard',
                'form.student.grade_placeholder': 'Select form/standard',
                'form.student.grades.darjah1': 'Standard 1',
                'form.student.grades.darjah2': 'Standard 2',
                'form.student.grades.darjah3': 'Standard 3',
                'form.student.grades.darjah4': 'Standard 4',
                'form.student.grades.darjah5': 'Standard 5',
                'form.student.grades.darjah6': 'Standard 6',
                'form.student.grades.form1': 'Form 1',
                'form.student.grades.form2': 'Form 2',
                'form.student.grades.form3': 'Form 3',
                'form.student.grades.form4': 'Form 4',
                'form.student.grades.form5': 'Form 5',
                'form.student.grades.form6': 'Form 6',
                
                // Form - Review
                'form.review.title': 'Review & Submit',
                'form.review.description': 'Please review all the information before submitting your registration.',
                'form.review.next_title': 'What happens next?',
                'form.review.next_1': 'Our team will review your registration within 24-48 hours',
                'form.review.next_2': 'You\'ll receive an email confirmation with your account details',
                'form.review.next_3': 'Students will get individual login credentials',
                'form.review.next_4': 'You can start using the platform immediately after approval',
                
                // Navigation
                'nav.previous': 'Previous',
                'nav.next': 'Next',
                'nav.submit': 'Submit Registration'
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
            
            // Update placeholders
            document.querySelectorAll('[data-placeholder-key]').forEach(element => {
                const key = element.dataset.placeholderKey;
                if (translations[lang] && translations[lang][key]) {
                    element.placeholder = translations[lang][key];
                }
            });
            
            // Update select options
            document.querySelectorAll('#schoolTypeSelect option[data-key]').forEach(option => {
                const key = option.dataset.key;
                if (translations[lang] && translations[lang][key]) {
                    option.textContent = translations[lang][key];
                }
            });
            
            // Update student form select options (dynamically created)
            document.querySelectorAll('select[name*="[grade]"] option[data-key]').forEach(option => {
                const key = option.dataset.key;
                if (translations[lang] && translations[lang][key]) {
                    option.textContent = translations[lang][key];
                }
            });
        }

        // Form step management
        let currentStep = 1;
        const totalSteps = 3;
        let students = [];

        // Initialize the form
        document.addEventListener('DOMContentLoaded', function() {
            updateStepDisplay();
            setupEventListeners();
            // Initialize with Malay as default
            switchLanguage('ms');
        });

        function setupEventListeners() {
            // Language switcher
            document.querySelectorAll('.language-option').forEach(option => {
                option.addEventListener('click', () => {
                    switchLanguage(option.dataset.lang);
                });
            });
            
            // Navigation buttons
            document.getElementById('nextBtn').addEventListener('click', nextStep);
            document.getElementById('prevBtn').addEventListener('click', prevStep);
            
            // Add student button
            document.getElementById('addStudentBtn').addEventListener('click', addStudentForm);
            
            // File upload
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('excelFile');
            
            uploadArea.addEventListener('click', () => fileInput.click());
            uploadArea.addEventListener('dragover', handleDragOver);
            uploadArea.addEventListener('drop', handleDrop);
            fileInput.addEventListener('change', handleFileSelect);
            
            // Download template
            document.getElementById('downloadTemplate').addEventListener('click', downloadTemplate);
            
            // Form submission
            document.getElementById('registrationForm').addEventListener('submit', handleSubmit);
        }

        function updateStepDisplay() {
            // Update progress indicators
            document.querySelectorAll('.step').forEach((step, index) => {
                const stepNumber = index + 1;
                step.classList.remove('active', 'completed');
                
                if (stepNumber < currentStep) {
                    step.classList.add('completed');
                } else if (stepNumber === currentStep) {
                    step.classList.add('active');
                }
            });

            // Show/hide form sections
            document.querySelectorAll('.form-section').forEach((section, index) => {
                section.classList.remove('active');
                if (index + 1 === currentStep) {
                    section.classList.add('active');
                }
            });

            // Update navigation buttons
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');

            prevBtn.style.display = currentStep > 1 ? 'block' : 'none';
            
            if (currentStep === totalSteps) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'block';
                populateReview();
            } else {
                nextBtn.style.display = 'block';
                submitBtn.style.display = 'none';
            }
        }

        function nextStep() {
            if (validateCurrentStep()) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStepDisplay();
                }
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStepDisplay();
            }
        }

        function validateCurrentStep() {
            const currentSection = document.getElementById(`step${currentStep}`);
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

            if (!isValid) {
                alert('Please fill in all required fields before proceeding.');
            }

            return isValid;
        }

        function addStudentForm() {
            const studentIndex = students.length;
            const studentCard = document.createElement('div');
            studentCard.className = 'student-card animate__animated animate__fadeInUp';
            studentCard.innerHTML = `
                <button type="button" class="remove-student" onclick="removeStudent(${studentIndex})">
                    <i class="fas fa-times"></i>
                </button>
                <h5><i class="fas fa-user"></i> <span data-key="form.student.title">Pelajar</span> ${studentIndex + 1}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.first_name">Nama Pertama</span> <span class="required">*</span></label>
                            <input type="text" name="students[${studentIndex}][first_name]" class="form-control" data-placeholder-key="form.student.first_name_placeholder" placeholder="Nama pertama pelajar" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.last_name">Nama Akhir</span> <span class="required">*</span></label>
                            <input type="text" name="students[${studentIndex}][last_name]" class="form-control" data-placeholder-key="form.student.last_name_placeholder" placeholder="Nama akhir pelajar" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.email">E-mel</span></label>
                            <input type="email" name="students[${studentIndex}][email]" class="form-control" data-placeholder-key="form.student.email_placeholder" placeholder="e-mel@contoh.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.grade">Tingkatan/Darjah</span> <span class="required">*</span></label>
                            <select name="students[${studentIndex}][grade]" class="form-control" required>
                                <option value="" data-key="form.student.grade_placeholder">Pilih tingkatan/darjah</option>
                                <option value="darjah1" data-key="form.student.grades.darjah1">Darjah 1</option>
                                <option value="darjah2" data-key="form.student.grades.darjah2">Darjah 2</option>
                                <option value="darjah3" data-key="form.student.grades.darjah3">Darjah 3</option>
                                <option value="darjah4" data-key="form.student.grades.darjah4">Darjah 4</option>
                                <option value="darjah5" data-key="form.student.grades.darjah5">Darjah 5</option>
                                <option value="darjah6" data-key="form.student.grades.darjah6">Darjah 6</option>
                                <option value="form1" data-key="form.student.grades.form1">Tingkatan 1</option>
                                <option value="form2" data-key="form.student.grades.form2">Tingkatan 2</option>
                                <option value="form3" data-key="form.student.grades.form3">Tingkatan 3</option>
                                <option value="form4" data-key="form.student.grades.form4">Tingkatan 4</option>
                                <option value="form5" data-key="form.student.grades.form5">Tingkatan 5</option>
                                <option value="form6" data-key="form.student.grades.form6">Tingkatan 6</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('studentsContainer').appendChild(studentCard);
            students.push({});
            
            // Apply current language translations to newly added student form
            setTimeout(() => switchLanguage(currentLanguage), 100);
        }

        function removeStudent(index) {
            const studentCards = document.querySelectorAll('.student-card');
            if (studentCards[index]) {
                studentCards[index].remove();
                students.splice(index, 1);
                updateStudentIndexes();
            }
        }

        function updateStudentIndexes() {
            const studentCards = document.querySelectorAll('.student-card');
            studentCards.forEach((card, index) => {
                const title = card.querySelector('h5');
                title.innerHTML = `<i class="fas fa-user"></i> Student ${index + 1}`;
                
                const inputs = card.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.name;
                    const newName = name.replace(/students\[\d+\]/, `students[${index}]`);
                    input.name = newName;
                });

                const removeBtn = card.querySelector('.remove-student');
                removeBtn.setAttribute('onclick', `removeStudent(${index})`);
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
                handleFile(files[0]);
            }
        }

        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                handleFile(file);
            }
        }

        function handleFile(file) {
            if (!file.name.match(/\.(xlsx|xls)$/)) {
                alert('Please select a valid Excel file (.xlsx or .xls)');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB');
                return;
            }

            // Show upload progress
            document.getElementById('uploadProgress').style.display = 'block';
            
            // Simulate file processing (replace with actual upload logic)
            setTimeout(() => {
                document.getElementById('uploadProgress').style.display = 'none';
                document.getElementById('uploadResults').style.display = 'block';
                document.getElementById('uploadResults').innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        Successfully processed "${file.name}" - Found 25 students
                    </div>
                `;
            }, 2000);
        }

        function downloadTemplate() {
            // Open the Excel template page in a new window/tab
            window.open('{{ route("school.student-template") }}', '_blank');
            
            // Optionally, you can also trigger a direct download link
            // window.location.href = '{{ route("school.download-template") }}';
        }

        function populateReview() {
            const form = document.getElementById('registrationForm');
            const formData = new FormData(form);
            
            let reviewHTML = '<div class="row">';
            
            // School Information Review
            reviewHTML += `
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-school"></i> School Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>School Name:</strong> ${formData.get('school_name') || 'Not provided'}</p>
                                    <p><strong>School Email:</strong> ${formData.get('school_email') || 'Not provided'}</p>
                                    <p><strong>Phone:</strong> ${formData.get('phone') || 'Not provided'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Type:</strong> ${formData.get('school_type') || 'Not provided'}</p>
                                    <p><strong>Total Students:</strong> ${formData.get('total_students') || 'Not specified'}</p>
                                </div>
                            </div>
                            <p><strong>Address:</strong> ${formData.get('address') || 'Not provided'}</p>
                            
                            <hr>
                            <h6 class="text-success"><i class="fas fa-user-tie"></i> Teacher Coordinator</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> ${formData.get('teacher_name') || 'Not provided'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> ${formData.get('teacher_email') || 'Not provided'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Students Review
            const studentCount = document.querySelectorAll('.student-card').length;
            reviewHTML += `
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-users"></i> Students Summary</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Individual Students:</strong> ${studentCount}</p>
                            <p><strong>Bulk Upload:</strong> ${document.getElementById('excelFile').files.length > 0 ? 'File uploaded' : 'No file'}</p>
                        </div>
                    </div>
                </div>
            `;

            reviewHTML += '</div>';
            
            document.getElementById('reviewContent').innerHTML = reviewHTML;
        }

        function handleSubmit(e) {
            e.preventDefault();
            
            // Show loading overlay
            document.getElementById('loadingOverlay').style.display = 'flex';
            
            // Simulate form submission (replace with actual submission logic)
            setTimeout(() => {
                document.getElementById('loadingOverlay').style.display = 'none';
                alert('Registration submitted successfully! You will receive a confirmation email shortly.');
                // Redirect or reset form as needed
            }, 3000);
        }
    </script>
</body>
</html> 