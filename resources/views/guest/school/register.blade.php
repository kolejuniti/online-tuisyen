<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Registration - Online Tuition Platform</title>
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

        .notification-container {
            max-width: 1200px;
            margin: -1rem auto 0;
            padding: 0 1rem;
            position: relative;
            z-index: 10;
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
            
            .notification-container {
                margin: -0.5rem auto 0;
                padding: 0 1rem;
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
            
            .notification-container {
                margin: 0 auto 0;
                padding: 0 0.5rem;
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

            .excel-data-table .table thead th {
                padding: 0.5rem 0.25rem;
                font-size: 0.75rem;
            }

            .excel-data-table .table tbody td {
                padding: 0.5rem 0.25rem;
                font-size: 0.75rem;
                max-width: 80px;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
                font-family: Arial, sans-serif !important;
                font-size: 12pt !important;
                line-height: 1.4 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            body::before {
                display: none !important;
            }

            .hero-section,
            .language-switcher,
            .action-buttons,
            .loading-overlay {
                display: none !important;
            }

            .container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 20pt !important;
            }

            .main-container {
                background: white !important;
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                border-radius: 0 !important;
                margin: 0 !important;
                padding: 20pt !important;
            }

            .success-container {
                padding: 0 !important;
            }

            .success-icon i {
                color: #28a745 !important;
                font-size: 48pt !important;
            }

            .success-title {
                color: black !important;
                font-size: 24pt !important;
                margin: 20pt 0 !important;
                text-align: center !important;
            }

            .alert {
                background: #f8f9fa !important;
                border: 1px solid #28a745 !important;
                color: black !important;
                padding: 15pt !important;
                margin: 15pt 0 !important;
                border-radius: 0 !important;
            }

            .success-details .row {
                display: block !important;
            }

            .success-details .col-md-4 {
                width: 100% !important;
                margin-bottom: 15pt !important;
                page-break-inside: avoid !important;
            }

            .success-step {
                border: 1px solid #dee2e6 !important;
                padding: 15pt !important;
                margin-bottom: 10pt !important;
            }

            .success-step .step-icon i {
                font-size: 18pt !important;
                color: black !important;
            }

            .success-step h5 {
                color: black !important;
                font-size: 14pt !important;
                margin: 10pt 0 5pt 0 !important;
            }

            .success-step p {
                color: #666 !important;
                font-size: 10pt !important;
                margin: 0 !important;
            }

            .next-steps {
                background: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
                padding: 15pt !important;
                margin: 20pt 0 !important;
                page-break-inside: avoid !important;
            }

            .next-steps h4 {
                color: black !important;
                font-size: 16pt !important;
                margin-bottom: 10pt !important;
            }

            .next-steps ul {
                margin: 0 !important;
                padding-left: 20pt !important;
            }

            .next-steps li {
                margin-bottom: 8pt !important;
                font-size: 11pt !important;
            }

            .next-steps i {
                color: black !important;
            }

            .contact-info {
                background: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
                padding: 15pt !important;
                margin: 15pt 0 !important;
                page-break-inside: avoid !important;
            }

            .contact-info h6 {
                color: black !important;
                font-size: 14pt !important;
                margin-bottom: 10pt !important;
            }

            .contact-info p {
                color: black !important;
                font-size: 11pt !important;
                margin: 5pt 0 !important;
            }

            .print-header {
                display: block !important;
                text-align: center !important;
                margin-bottom: 30pt !important;
                padding-bottom: 15pt !important;
                border-bottom: 2px solid #333 !important;
            }

            .print-date {
                display: block !important;
                text-align: right !important;
                font-size: 10pt !important;
                color: #666 !important;
                margin-bottom: 20pt !important;
            }

            .print-section {
                margin-bottom: 25pt !important;
                page-break-inside: avoid-page !important;
                break-inside: avoid !important;
            }

            .print-section-title {
                color: black !important;
                font-size: 16pt !important;
                font-weight: bold !important;
                margin-bottom: 10pt !important;
                padding-bottom: 5pt !important;
                border-bottom: 1px solid #ccc !important;
                page-break-after: avoid !important;
                break-after: avoid !important;
            }

            /* Page break rules */
            .page-break-before {
                page-break-before: always !important;
                break-before: page !important;
            }

            .page-break-after {
                page-break-after: always !important;
                break-after: page !important;
            }

            .no-page-break {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Table page break handling */
            table {
                page-break-inside: auto !important;
                break-inside: auto !important;
            }

            thead {
                display: table-header-group !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            tbody {
                display: table-row-group !important;
            }

            tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            th, td {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Specific section breaks */
            .registration-details-section {
                page-break-after: avoid !important;
                break-after: avoid !important;
            }

            .student-section {
                page-break-before: auto !important;
                break-before: auto !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .student-table-container {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                margin-bottom: 20pt !important;
            }

            .notes-section {
                page-break-before: auto !important;
                break-before: auto !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .submission-details {
                display: block !important;
            }

            .detail-row {
                display: flex !important;
                justify-content: space-between !important;
                margin-bottom: 8pt !important;
                font-size: 11pt !important;
            }

            .detail-label {
                font-weight: bold !important;
                color: black !important;
            }

            .detail-value {
                color: #333 !important;
            }

            /* Hide screen-only elements */
            .screen-only {
                display: none !important;
            }

            /* Show print-only elements */
            .print-only {
                display: block !important;
            }
        }

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            border: 2px solid rgba(226, 232, 240, 0.8) !important;
            border-radius: 12px !important;
            padding: 1rem 1.25rem !important;
            font-size: 1rem !important;
            height: auto !important;
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
            padding: 0 !important;
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

        /* Excel Data Table Styles */
        .excel-data-table {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.15);
            overflow: hidden;
            margin-top: 1rem;
        }

        .excel-data-table .table {
            margin: 0;
        }

        .excel-data-table .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem 0.75rem;
            font-size: 0.9rem;
            text-align: center;
            white-space: nowrap;
        }

        .excel-data-table .table tbody td {
            padding: 0.75rem;
            border-color: rgba(226, 232, 240, 0.5);
            font-size: 0.85rem;
            vertical-align: middle;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .excel-data-table .table tbody tr:nth-child(odd) {
            background-color: rgba(248, 250, 252, 0.8);
        }

        .excel-data-table .table tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.08);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .data-summary {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .data-summary i {
            font-size: 1.2rem;
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
        @if(session('success'))
            <!-- Success State - Hide form and show success message -->
            <div class="main-container animate__animated animate__fadeInUp">
                <!-- Print Header (Print Only) -->
                <div class="print-only print-header" style="display: none;">
                    <h1 style="margin: 0; font-size: 24pt; color: #333;">School Registration Confirmation</h1>
                    <p style="margin: 5pt 0 0 0; font-size: 14pt; color: #666;">Online Tuition Platform</p>
                </div>
                
                <!-- Print Date (Print Only) -->
                <div class="print-only print-date" style="display: none;">
                    Registration Date: <span id="printDate"></span>
                </div>

                <div class="success-container text-center" style="padding: 4rem 2rem;">
                    <div class="success-icon mb-4 screen-only">
                        <i class="fas fa-check-circle" style="font-size: 5rem; color: var(--success-color);"></i>
                    </div>
                    
                    <h2 class="success-title mb-3" style="color: var(--dark-text); font-weight: 700;">
                        <span data-key="success.title">Pendaftaran Berjaya!</span>
                    </h2>

                    <!-- Print-Only Submission Details -->
                    <div class="print-only print-section registration-details-section no-page-break" style="display: none;">
                        <h3 class="print-section-title">Registration Details</h3>
                        <div id="printSubmissionDetails">
                            <!-- Details will be populated by JavaScript -->
                        </div>
                    </div>
                    
                    <div class="alert alert-success border-0" style="background: linear-gradient(135deg, #10b981, #059669); max-width: 600px; margin: 0 auto 2rem;">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>

                    <div class="success-details" style="max-width: 700px; margin: 0 auto;">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="success-step">
                                    <div class="step-icon mb-2">
                                        <i class="fas fa-school" style="font-size: 2rem; color: var(--primary-color);"></i>
                                    </div>
                                    <h5 data-key="success.step1.title">Sekolah Diaktifkan</h5>
                                    <p class="text-muted small" data-key="success.step1.desc">Sekolah anda telah berjaya diaktifkan dalam sistem kami</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="success-step">
                                    <div class="step-icon mb-2">
                                        <i class="fas fa-users" style="font-size: 2rem; color: var(--accent-color);"></i>
                                    </div>
                                    <h5 data-key="success.step2.title">Pelajar Didaftarkan</h5>
                                    <p class="text-muted small" data-key="success.step2.desc">Akaun pelajar telah dicipta dengan kata laluan default</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="success-step">
                                    <div class="step-icon mb-2">
                                        <i class="fas fa-envelope" style="font-size: 2rem; color: var(--warning-color);"></i>
                                    </div>
                                    <h5 data-key="success.step3.title">E-mel Pengesahan</h5>
                                    <p class="text-muted small" data-key="success.step3.desc">Maklumat login akan dihantar ke e-mel anda</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="next-steps mt-4 p-4" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.03)); border-radius: 15px; max-width: 600px; margin: 2rem auto;">
                        <h4 class="mb-3" data-key="success.next.title">Langkah Seterusnya:</h4>
                        <ul class="list-unstyled text-left" style="max-width: 500px; margin: 0 auto;">
                            <li class="mb-2" data-key="success.next.step1"><i class="fas fa-clock text-primary me-2"></i>Tunggu e-mel pengesahan dalam masa 24-48 jam</li>
                            <li class="mb-2" data-key="success.next.step2"><i class="fas fa-key text-success me-2"></i>Kongsikan maklumat login dengan pelajar</li>
                            <li class="mb-2" data-key="success.next.step3"><i class="fas fa-rocket text-warning me-2"></i>Mula gunakan platform setelah kelulusan</li>
                            
                        </ul>
                    </div>

                    <div class="contact-info mt-4 p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; max-width: 500px; margin: 2rem auto;">
                        <h6 class="mb-2" data-key="success.contact.title">Butuh Bantuan?</h6>
                        <p class="mb-2 small">
                            <i class="fas fa-envelope me-2"></i>
                            <span data-key="success.contact.email">E-mel: etuition@uniti.edu.my</span>
                        </p>
                        <p class="mb-0 small">
                            <i class="fas fa-phone me-2"></i>
                            <span data-key="success.contact.phone">Telefon: +60 12-345 6789</span>
                        </p>
                    </div>

                    <!-- Print-Only Student Information -->
                    <div class="print-only print-section student-section" style="display: none;">
                        <h3 class="print-section-title">Student Information</h3>
                        <div id="printStudentDetails">
                            <!-- Student details will be populated by JavaScript -->
                        </div>
                    </div>

                    <!-- Print-Only Important Notes -->
                    <div class="print-only print-section notes-section no-page-break" style="display: none;">
                        <h3 class="print-section-title">Important Notes</h3>
                        <ul style="margin: 0; padding-left: 20pt; font-size: 11pt;">
                            <li style="margin-bottom: 8pt;">Default student passwords have been set to "student123" for individual entries</li>
                            <li style="margin-bottom: 8pt;">Students imported via Excel have default password "password"</li>
                            <li style="margin-bottom: 8pt;">Please ensure students change their passwords after first login</li>
                            <li style="margin-bottom: 8pt;">Login credentials will be sent via email within 24-48 hours</li>
                            <li style="margin-bottom: 8pt;">Keep this document for your records</li>
                        </ul>
                    </div>

                    <div class="action-buttons mt-4 screen-only">
                        <a href="{{ url('/') }}" class="btn btn-primary-custom me-3">
                            <i class="fas fa-home"></i> <span data-key="success.btn.home">Kembali ke Laman Utama</span>
                        </a>
                        <button onclick="printRegistrationDetails()" class="btn btn-outline-custom">
                            <i class="fas fa-print"></i> <span data-key="success.btn.print">Cetak Maklumat</span>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <!-- Error Messages -->
        <!-- Notification Messages -->
        <div class="notification-container" style="margin-bottom: 2rem;">
            @if(session('auth_success'))
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert" style="margin-bottom: 1.5rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('auth_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert" style="margin-bottom: 1.5rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert" style="margin-bottom: 1.5rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);">
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
        </div>

            <!-- Registration Form -->
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
                            @if(!isset($authenticatedCoordinator))
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <span data-key="form.school.name">Nama Sekolah</span> <span class="required">*</span>
                                        </label>
                                        <select name="school_id" id="schoolSelect" class="form-control" data-placeholder-key="form.school.name_placeholder" required>
                                            <option value="" data-key="form.school.name_placeholder">Pilih sekolah anda</option>
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <!-- Hidden input for authenticated coordinator's school -->
                                <input type="hidden" name="school_id" value="{{ $authenticatedCoordinator['school_id'] }}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <span data-key="form.school.name">Nama Sekolah</span>
                                            <span class="badge bg-success ms-2"><i class="fas fa-shield-alt"></i> Pre-selected</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control border-success" 
                                               value="{{ $authenticatedCoordinator['school_name'] }}"
                                               readonly 
                                               style="background-color: #f0f9ff; color: #1e40af; font-weight: 600;">
                                        <small class="text-success mt-1 d-block">
                                            <i class="fas fa-info-circle"></i> School automatically selected based on your coordinator assignment.
                                        </small>
                                    </div>
                                </div>
                            @endif
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
                        @if(isset($authenticatedCoordinator))
                            <div class="alert alert-success border-0 mb-3" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Authenticated Coordinator:</strong> The coordinator information below has been verified and pre-filled based on your authentication.
                            </div>
                            <p class="text-muted mb-3">
                                <span data-key="form.teacher.description">Maklumat guru atau pentadbir yang akan bertanggungjawab menguruskan platform ini.</span>
                                <br><small class="text-success"><i class="fas fa-lock"></i> These fields are automatically filled and protected based on your authentication.</small>
                            </p>
                        @else
                            <p class="text-muted mb-3" data-key="form.teacher.description">Maklumat guru atau pentadbir yang akan bertanggungjawab menguruskan platform ini.</p>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.teacher.name">Nama Guru Pembimbing</span> <span class="required">*</span>
                                        @if(isset($authenticatedCoordinator))
                                            <span class="badge bg-success ms-2"><i class="fas fa-shield-alt"></i> Verified</span>
                                        @endif
                                    </label>
                                    <input type="text" 
                                           name="teacher_name" 
                                           class="form-control @if(isset($authenticatedCoordinator)) border-success @endif" 
                                           data-placeholder-key="form.teacher.name_placeholder" 
                                           placeholder="Nama penuh guru pembimbing" 
                                           value="{{ isset($authenticatedCoordinator) ? $authenticatedCoordinator['name'] : old('teacher_name') }}"
                                           @if(isset($authenticatedCoordinator)) readonly style="background-color: #f8f9fa; color: #495057;" @endif
                                           required>
                                    @if(isset($authenticatedCoordinator))
                                        <small class="text-success mt-1 d-block">
                                            <i class="fas fa-info-circle"></i> This information is automatically filled from your verified coordinator account.
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span data-key="form.teacher.email">E-mel Guru Pembimbing</span> <span class="required">*</span>
                                        @if(isset($authenticatedCoordinator))
                                            <span class="badge bg-success ms-2"><i class="fas fa-shield-alt"></i> Verified</span>
                                        @endif
                                    </label>
                                    <input type="email" 
                                           name="teacher_email" 
                                           class="form-control @if(isset($authenticatedCoordinator)) border-success @endif" 
                                           data-placeholder-key="form.teacher.email_placeholder" 
                                           placeholder="guru@contoh.com" 
                                           value="{{ isset($authenticatedCoordinator) ? $authenticatedCoordinator['email'] : old('teacher_email') }}"
                                           @if(isset($authenticatedCoordinator)) readonly style="background-color: #f8f9fa; color: #495057;" @endif
                                           required>
                                    @if(isset($authenticatedCoordinator))
                                        <small class="text-success mt-1 d-block">
                                            <i class="fas fa-info-circle"></i> This information is automatically filled from your verified coordinator account.
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if(isset($authenticatedCoordinator))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <span>Assigned School</span>
                                            <span class="badge bg-primary ms-2"><i class="fas fa-school"></i> Pre-selected</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control border-primary" 
                                               value="{{ $authenticatedCoordinator['school_name'] }}"
                                               readonly 
                                               style="background-color: #e3f2fd; color: #1976d2; font-weight: 600;">
                                        <small class="text-primary mt-1 d-block">
                                            <i class="fas fa-info-circle"></i> This is the school you are assigned to coordinate. School selection is automatically handled.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
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
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SheetJS for Excel reading -->
    <script src="https://unpkg.com/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    
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
                'form.school.name_placeholder': 'Pilih sekolah anda',
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
                'form.bulk.file_selected': 'Fail "{filename}" dipilih dengan jayanya. Data pelajar akan diproses apabila anda menghantar borang pendaftaran.',
                'form.bulk.file_processed': 'Berjaya memproses "{filename}" - Dijumpai {count} pelajar',
                'form.bulk.no_data': 'Fail Excel kosong atau tidak mempunyai data.',
                'form.bulk.no_students': 'Tiada data pelajar dijumpai dalam fail.',
                'form.bulk.headers.student_name': 'Nama Pelajar',
                'form.bulk.headers.ic_number': 'No. Kad Pengenalan',
                'form.bulk.headers.email': 'E-mel',
                'form.bulk.headers.tingkatan': 'Tingkatan',
                'form.bulk.headers.phone': 'No. Telefon Pelajar',
                'form.bulk.headers.dob': 'Tarikh Lahir',
                'form.bulk.headers.gender': 'Jantina',
                'form.bulk.headers.parent_name': 'Nama Ibu Bapa/Penjaga',
                'form.bulk.headers.parent_phone': 'Telefon Ibu Bapa/Penjaga',
                'form.bulk.headers.address': 'Alamat',
                
                // Form - Individual
                'form.individual.title': 'Tambah Pelajar Individu',
                'form.individual.description': 'Tambah pelajar satu persatu menggunakan borang di bawah',
                'form.individual.add_btn': 'Tambah Pelajar',
                
                // Form - Student Details
                'form.student.title': 'Pelajar',
                'form.student.name': 'Nama Pelajar',
                'form.student.name_placeholder': 'Nama penuh pelajar',
                'form.student.ic': 'No. Kad Pengenalan',
                'form.student.ic_placeholder': '980123456789',
                'form.student.email': 'E-mel',
                'form.student.email_placeholder': 'e-mel@contoh.com',
                'form.student.phone': 'No. Telefon Pelajar',
                'form.student.phone_placeholder': '0123456789',
                'form.student.grade': 'Tingkatan',
                'form.student.grade_placeholder': 'Pilih tingkatan',
                'form.student.grade.form5': 'Tingkatan 5',
                
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
                'nav.submit': 'Hantar Pendaftaran',
                
                // Validation messages
                'validation.students_required': 'Sila tambah pelajar sama ada secara individu atau muat naik fail Excel.',
                'validation.students_required_step': 'Sila tambah pelajar sama ada secara individu atau muat naik fail Excel sebelum meneruskan.',
                'validation.required_fields': 'Sila lengkapkan semua medan yang diperlukan sebelum meneruskan.',
                
                // Success page
                'success.title': 'Pendaftaran Berjaya!',
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
                'success.next.step4': 'Hubungi sokongan jika ada pertanyaan',
                'success.contact.title': 'Butuh Bantuan?',
                'success.contact.email': 'E-mel: etuition@uniti.edu.my',
                'success.contact.phone': 'Telefon: +60 12-345 6789',
                'success.btn.home': 'Kembali ke Laman Utama',
                'success.btn.print': 'Cetak Maklumat'
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
                'form.school.name_placeholder': 'Select your school',
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
                'form.bulk.file_selected': 'File "{filename}" selected successfully. Student data will be processed when you submit the registration form.',
                'form.bulk.file_processed': 'Successfully processed "{filename}" - Found {count} students',
                'form.bulk.no_data': 'Excel file is empty or contains no data.',
                'form.bulk.no_students': 'No student data found in the file.',
                'form.bulk.headers.student_name': 'Student Name',
                'form.bulk.headers.ic_number': 'IC Number',
                'form.bulk.headers.email': 'Email',
                'form.bulk.headers.tingkatan': 'Tingkatan',
                'form.bulk.headers.phone': 'Student\'s Phone Number',
                'form.bulk.headers.dob': 'Date of Birth',
                'form.bulk.headers.gender': 'Gender',
                'form.bulk.headers.parent_name': 'Parent/Guardian Name',
                'form.bulk.headers.parent_phone': 'Parent/Guardian Phone',
                'form.bulk.headers.address': 'Address',
                
                // Form - Individual
                'form.individual.title': 'Add Individual Students',
                'form.individual.description': 'Add students one by one using the form below',
                'form.individual.add_btn': 'Add Student',
                
                // Form - Student Details
                'form.student.title': 'Student',
                'form.student.name': 'Student Name',
                'form.student.name_placeholder': 'Full student name',
                'form.student.ic': 'IC Number',
                'form.student.ic_placeholder': '980123456789',
                'form.student.email': 'Email',
                'form.student.email_placeholder': 'email@example.com',
                'form.student.phone': 'Student\'s Phone Number',
                'form.student.phone_placeholder': '0123456789',
                'form.student.grade': 'Tingkatan',
                'form.student.grade_placeholder': 'Select tingkatan',
                'form.student.grade.form5': 'Tingkatan 5',
                
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
                'nav.submit': 'Submit Registration',
                
                // Validation messages
                'validation.students_required': 'Please add students either individually or by uploading an Excel file.',
                'validation.students_required_step': 'Please add students either individually or by uploading an Excel file before proceeding.',
                'validation.required_fields': 'Please fill in all required fields before proceeding.',
                
                // Success page
                'success.title': 'Registration Successful!',
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
                'success.next.step4': 'Contact support if you have questions',
                'success.contact.title': 'Need Help?',
                'success.contact.email': 'Email: etuition@uniti.edu.my',
                'success.contact.phone': 'Phone: +60 12-345 6789',
                'success.btn.home': 'Back to Home',
                'success.btn.print': 'Print Information'
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
            
            // Reinitialize Select2 with new language
            if (typeof initializeSchoolSelect === 'function') {
                $('#schoolSelect').select2('destroy');
                initializeSchoolSelect();
            }
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

        function setupEventListeners() {
            // Initialize Select2 for school selection
            initializeSchoolSelect();
            
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

            // For step 2 (students), validate that at least one method of adding students is used
            if (currentStep === 2) {
                const hasIndividualStudents = document.querySelectorAll('.student-card').length > 0;
                const hasExcelFile = document.getElementById('excelFile').files.length > 0;
                
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
            studentCard.className = 'student-card animate__animated animate__fadeInUp';
            studentCard.innerHTML = `
                <button type="button" class="remove-student" onclick="removeStudent(${studentIndex})">
                    <i class="fas fa-times"></i>
                </button>
                <h5><i class="fas fa-user"></i> <span data-key="form.student.title">Pelajar</span> ${studentIndex + 1}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.name">Nama Pelajar</span> <span class="required">*</span></label>
                            <input type="text" name="students[${studentIndex}][name]" class="form-control" data-placeholder-key="form.student.name_placeholder" placeholder="Nama penuh pelajar" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.ic">No. Kad Pengenalan</span> <span class="required">*</span></label>
                            <input type="text" name="students[${studentIndex}][ic_number]" class="form-control" data-placeholder-key="form.student.ic_placeholder" placeholder="980123456789" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.email">E-mel</span></label>
                            <input type="email" name="students[${studentIndex}][email]" class="form-control" data-placeholder-key="form.student.email_placeholder" placeholder="e-mel@contoh.com">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.phone">No. Telefon Pelajar</span></label>
                            <input type="tel" name="students[${studentIndex}][phone]" class="form-control" data-placeholder-key="form.student.phone_placeholder" placeholder="0123456789">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><span data-key="form.student.grade">Tingkatan</span> <span class="required">*</span></label>
                            <select name="students[${studentIndex}][grade]" class="form-control" required>
                                <option value="" data-key="form.student.grade_placeholder">Pilih tingkatan</option>
                                <option value="form5" data-key="form.student.grade.form5">Tingkatan 5</option>
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
            
            // Read and process the Excel file
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    
                    // Get the first worksheet
                    const firstSheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheetName];
                    
                    // Convert to JSON
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                    
                    // Process the data
                    processExcelData(jsonData, file.name);
                    
                } catch (error) {
                    document.getElementById('uploadProgress').style.display = 'none';
                    document.getElementById('uploadResults').style.display = 'block';
                    document.getElementById('uploadResults').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            Error reading Excel file: ${error.message}
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
                document.getElementById('uploadResults').innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        ${translations[currentLanguage]['form.bulk.no_data']}
                    </div>
                `;
                return;
            }
            
            // Get headers and data rows
            const headers = data[0];
            const rows = data.slice(1).filter(row => row.some(cell => cell && cell.toString().trim()));
            
            if (rows.length === 0) {
                document.getElementById('uploadResults').innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        ${translations[currentLanguage]['form.bulk.no_students']}
                    </div>
                `;
                return;
            }
            
            // Create table HTML with improved styling
            let tableHTML = `
                <div class="data-summary">
                    <i class="fas fa-check-circle"></i>
                    <span>${translations[currentLanguage]['form.bulk.file_processed'].replace('{filename}', fileName).replace('{count}', rows.length)}</span>
                </div>
                <div class="excel-data-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>`;
            
            // Add headers
            const expectedHeaders = [
                translations[currentLanguage]['form.bulk.headers.student_name'] || 'Student Name',
                translations[currentLanguage]['form.bulk.headers.ic_number'] || 'IC Number', 
                translations[currentLanguage]['form.bulk.headers.email'] || 'Email',
                translations[currentLanguage]['form.bulk.headers.tingkatan'] || 'Tingkatan',
                translations[currentLanguage]['form.bulk.headers.phone'] || 'Student\'s Phone Number',
                translations[currentLanguage]['form.bulk.headers.dob'] || 'Date of Birth',
                translations[currentLanguage]['form.bulk.headers.gender'] || 'Gender',
                translations[currentLanguage]['form.bulk.headers.parent_name'] || 'Parent/Guardian Name',
                translations[currentLanguage]['form.bulk.headers.parent_phone'] || 'Parent/Guardian Phone',
                translations[currentLanguage]['form.bulk.headers.address'] || 'Address'
            ];
            
            expectedHeaders.forEach(header => {
                tableHTML += `<th>${header}</th>`;
            });
            
            tableHTML += `</tr></thead><tbody>`;
            
            // Add data rows
            rows.forEach((row, index) => {
                tableHTML += '<tr>';
                for (let i = 0; i < 10; i++) { // Ensure we show all 10 columns
                    const cellValue = row[i] || '';
                    const displayValue = cellValue.toString().length > 30 ? 
                        cellValue.toString().substring(0, 30) + '...' : cellValue;
                    tableHTML += `<td title="${cellValue}">${displayValue}</td>`;
                }
                tableHTML += '</tr>';
            });
            
            tableHTML += `</tbody></table></div></div>`;
            
            document.getElementById('uploadResults').innerHTML = tableHTML;
        }

        function downloadTemplate() {
            // Trigger direct download of Excel template
            window.location.href = '{{ route("school.download-template") }}';
            
            // Optionally, also open the template view in a new tab for reference
            // window.open('{{ route("school.student-template") }}', '_blank');
        }

        function populateReview() {
            const form = document.getElementById('registrationForm');
            const formData = new FormData(form);
            
            // Get selected school name from Select2
            const selectedSchoolText = $('#schoolSelect option:selected').text() || 'Not selected';
            
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
                                    <p><strong>School Name:</strong> ${selectedSchoolText}</p>
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
            // Show loading overlay first
            document.getElementById('loadingOverlay').style.display = 'flex';
            
            // Check if students have been added
            const hasIndividualStudents = document.querySelectorAll('.student-card').length > 0;
            const hasExcelFile = document.getElementById('excelFile').files.length > 0;
            
            if (!hasIndividualStudents && !hasExcelFile) {
                e.preventDefault();
                // Hide loading overlay since we're not submitting
                document.getElementById('loadingOverlay').style.display = 'none';
                alert(translations[currentLanguage]['validation.students_required']);
                return false;
            }
            
            // Store form data for printing
            storeFormDataForPrint();
            
            // Form will now submit to the server
            return true;
        }

        function storeFormDataForPrint() {
            const form = document.getElementById('registrationForm');
            const formData = new FormData(form);
            
            // Get selected school name
            const selectedSchoolText = $('#schoolSelect option:selected').text() || 'Not selected';
            
            // Collect individual students data
            const individualStudents = [];
            document.querySelectorAll('.student-card').forEach((card, index) => {
                const nameInput = card.querySelector('input[name*="[name]"]');
                const icInput = card.querySelector('input[name*="[ic_number]"]');
                const emailInput = card.querySelector('input[name*="[email]"]');
                const phoneInput = card.querySelector('input[name*="[phone]"]');
                const gradeSelect = card.querySelector('select[name*="[grade]"]');
                
                if (nameInput && nameInput.value) {
                    individualStudents.push({
                        name: nameInput.value,
                        ic: icInput ? icInput.value : '',
                        email: emailInput ? emailInput.value : '',
                        phone: phoneInput ? phoneInput.value : '',
                        grade: gradeSelect ? gradeSelect.options[gradeSelect.selectedIndex].text : ''
                    });
                }
            });
            
            // Get Excel file info
            const excelFile = document.getElementById('excelFile').files[0];
            const hasExcelFile = excelFile ? true : false;
            const excelFileName = excelFile ? excelFile.name : null;
            
            // Store data in localStorage
            const printData = {
                schoolName: selectedSchoolText,
                schoolEmail: formData.get('school_email') || '',
                phone: formData.get('phone') || '',
                schoolType: formData.get('school_type') || '',
                address: formData.get('address') || '',
                totalStudents: formData.get('total_students') || '',
                teacherName: formData.get('teacher_name') || '',
                teacherEmail: formData.get('teacher_email') || '',
                individualStudents: individualStudents,
                hasExcelFile: hasExcelFile,
                excelFileName: excelFileName,
                submissionDate: new Date().toLocaleString()
            };
            
            localStorage.setItem('registrationPrintData', JSON.stringify(printData));
        }

        function printRegistrationDetails() {
            // Populate print sections with stored data
            populatePrintDetails();
            
            // Set print date
            document.getElementById('printDate').textContent = new Date().toLocaleString();
            
            // Trigger print
            window.print();
        }

        function generateStudentTable(students, startIndex, title) {
            let tableHTML = `
                <div class="student-table-container" style="margin-bottom: 20pt; page-break-inside: avoid;">
                    <h4 style="color: black; font-size: 14pt; margin-bottom: 10pt; page-break-after: avoid;">${title} (${students.length} ${students.length === 1 ? 'student' : 'students'})</h4>
                    <table style="width: 100%; border-collapse: collapse; font-size: 10pt;">
                        <thead style="display: table-header-group;">
                            <tr style="background: #f8f9fa; page-break-inside: avoid; break-inside: avoid;">
                                <th style="border: 1px solid #ccc; padding: 8pt; text-align: left; width: 8%;">#</th>
                                <th style="border: 1px solid #ccc; padding: 8pt; text-align: left; width: 30%;">Name</th>
                                <th style="border: 1px solid #ccc; padding: 8pt; text-align: left; width: 20%;">IC Number</th>
                                <th style="border: 1px solid #ccc; padding: 8pt; text-align: left; width: 27%;">Email</th>
                                <th style="border: 1px solid #ccc; padding: 8pt; text-align: left; width: 15%;">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            students.forEach((student, index) => {
                tableHTML += `
                    <tr style="page-break-inside: avoid; break-inside: avoid;">
                        <td style="border: 1px solid #ccc; padding: 8pt;">${startIndex + index + 1}</td>
                        <td style="border: 1px solid #ccc; padding: 8pt;">${student.name || ''}</td>
                        <td style="border: 1px solid #ccc; padding: 8pt;">${student.ic || ''}</td>
                        <td style="border: 1px solid #ccc; padding: 8pt; word-break: break-all;">${student.email || ''}</td>
                        <td style="border: 1px solid #ccc; padding: 8pt;">${student.grade || ''}</td>
                    </tr>
                `;
            });
            
            tableHTML += `
                        </tbody>
                    </table>
                </div>
            `;
            
            return tableHTML;
        }

        function populatePrintDetails() {
            const printData = JSON.parse(localStorage.getItem('registrationPrintData') || '{}');
            
            // Calculate if we need page breaks based on content size
            const studentCount = (printData.individualStudents?.length || 0);
            const hasExcelFile = printData.hasExcelFile;
            const needsStudentPageBreak = studentCount > 15; // If more than 15 students, start on new page
            
            // Populate submission details
            const submissionDetails = document.getElementById('printSubmissionDetails');
            if (submissionDetails) {
                submissionDetails.innerHTML = `
                    <div class="detail-row">
                        <span class="detail-label">School Name:</span>
                        <span class="detail-value">${printData.schoolName || 'N/A'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">School Email:</span>
                        <span class="detail-value">${printData.schoolEmail || 'N/A'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Phone Number:</span>
                        <span class="detail-value">${printData.phone || 'N/A'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">School Type:</span>
                        <span class="detail-value">${getSchoolTypeText(printData.schoolType)}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Address:</span>
                        <span class="detail-value">${printData.address || 'N/A'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Estimated Total Students:</span>
                        <span class="detail-value">${printData.totalStudents || 'Not specified'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Teacher Coordinator:</span>
                        <span class="detail-value">${printData.teacherName || 'N/A'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Teacher Email:</span>
                        <span class="detail-value">${printData.teacherEmail || 'N/A'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Submission Date:</span>
                        <span class="detail-value">${printData.submissionDate || 'N/A'}</span>
                    </div>
                `;
            }
            
                        // Populate student details
            const studentDetails = document.getElementById('printStudentDetails');
            if (studentDetails) {
                let studentHTML = '';
                
                // Add page break before student section if needed
                if (needsStudentPageBreak) {
                    studentHTML += '<div class="page-break-before"></div>';
                }
                
                                // Individual students
                if (printData.individualStudents && printData.individualStudents.length > 0) {
                    const students = printData.individualStudents;
                    const studentsPerPage = 25; // Maximum students per table page
                    
                    if (students.length <= studentsPerPage) {
                        // Single table for smaller lists
                        studentHTML += generateStudentTable(students, 0, 'Individual Students');
                    } else {
                        // Split into multiple tables for large lists
                        for (let i = 0; i < students.length; i += studentsPerPage) {
                            const chunk = students.slice(i, i + studentsPerPage);
                            const tableTitle = `Individual Students (Page ${Math.floor(i / studentsPerPage) + 1})`;
                            const isFirstTable = i === 0;
                            
                            if (!isFirstTable) {
                                studentHTML += '<div class="page-break-before"></div>';
                            }
                            
                            studentHTML += generateStudentTable(chunk, i, tableTitle);
                        }
                    }
                }
                
                                 // Excel file info
                 if (printData.hasExcelFile) {
                     studentHTML += `
                         <div class="no-page-break" style="margin-bottom: 15pt; page-break-inside: avoid;">
                             <h4 style="color: black; font-size: 14pt; margin-bottom: 10pt; page-break-after: avoid;">Bulk Upload</h4>
                             <div class="detail-row">
                                 <span class="detail-label">Excel File:</span>
                                 <span class="detail-value">${printData.excelFileName}</span>
                             </div>
                             <p style="font-size: 10pt; color: #666; margin: 5pt 0;">
                                 Students from Excel file will be processed and added to the system.
                             </p>
                         </div>
                     `;
                 }
                
                if (!printData.individualStudents?.length && !printData.hasExcelFile) {
                    studentHTML = '<p style="font-size: 11pt; color: #666;">No student information available for printing.</p>';
                }
                
                studentDetails.innerHTML = studentHTML;
            }
            
            // Ensure notes section has proper page break handling
            const notesSection = document.querySelector('.notes-section');
            if (notesSection && needsStudentPageBreak) {
                notesSection.style.pageBreakBefore = 'auto';
                notesSection.style.breakBefore = 'auto';
            }
        }

        function getSchoolTypeText(type) {
            const types = {
                'public': currentLanguage === 'ms' ? 'Sekolah Kerajaan' : 'Public School',
                'private': currentLanguage === 'ms' ? 'Sekolah Swasta' : 'Private School',
                'charter': currentLanguage === 'ms' ? 'Sekolah Piagam' : 'Charter School',
                'international': currentLanguage === 'ms' ? 'Sekolah Antarabangsa' : 'International School'
            };
            return types[type] || type || 'N/A';
        }

        // Initialize print details if we're on the success page
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('.success-container')) {
                populatePrintDetails();
                // Set print date
                const printDateElement = document.getElementById('printDate');
                if (printDateElement) {
                    printDateElement.textContent = new Date().toLocaleString();
                }
            }
        });
    </script>
</body>
</html> 