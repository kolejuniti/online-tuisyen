<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengesahan Guru Penyelaras - Platform E-Tuisyen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/student-friendly.css') }}" rel="stylesheet">
    <style>
        /* Page-specific styles for auth card */
        .sf-auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
        }

        .sf-auth-card {
            background: white;
            border-radius: var(--sf-radius-2xl);
            box-shadow: var(--sf-shadow-xl);
            overflow: hidden;
            max-width: 520px;
            width: 100%;
            border: 3px solid var(--sf-mint-soft);
            opacity: 0;
            animation: sf-cardPop 0.6s ease forwards 0.2s;
        }

        .sf-auth-header {
            background: linear-gradient(135deg, var(--sf-mint-fresh), var(--sf-mint-deep));
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .sf-auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .sf-auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 0 auto 1.25rem;
            animation: sf-bounce-gentle 3s ease-in-out infinite;
        }

        .sf-auth-logo img {
            height: 55px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(255, 255, 255, 0.3));
        }

        .sf-auth-title {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .sf-auth-subtitle {
            font-size: 0.95rem;
            opacity: 0.95;
            font-weight: 500;
            position: relative;
            z-index: 2;
            line-height: 1.5;
        }

        .sf-auth-body {
            padding: 2rem;
        }

        .sf-auth-info {
            background: var(--sf-sky-light);
            border: 2px solid var(--sf-sky-medium);
            border-radius: var(--sf-radius-lg);
            padding: 1.25rem;
            margin-bottom: 1.75rem;
            border-left: 4px solid var(--sf-ocean-bright);
        }

        .sf-auth-info-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: var(--sf-ocean-deep);
            margin-bottom: 0.5rem;
        }

        .sf-auth-info-header i {
            color: var(--sf-ocean-bright);
        }

        .sf-auth-info p {
            color: var(--sf-text-soft);
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .sf-input-group {
            position: relative;
        }

        .sf-input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--sf-text-muted);
            z-index: 10;
            transition: var(--sf-transition-normal);
        }

        .sf-input-group .sf-form-control {
            padding-left: 2.75rem;
        }

        .sf-input-group:focus-within i {
            color: var(--sf-mint-fresh);
        }

        .sf-form-hint {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: var(--sf-text-muted);
        }

        .sf-form-hint i {
            color: var(--sf-text-light);
            font-size: 0.8rem;
        }

        .sf-auth-divider {
            text-align: center;
            margin-top: 1.75rem;
            padding-top: 1.75rem;
            border-top: 2px dashed var(--sf-sky-medium);
        }

        .sf-back-to-choice {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--sf-text-soft);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.6rem 1.2rem;
            border-radius: var(--sf-radius-full);
            transition: var(--sf-transition-normal);
        }

        .sf-back-to-choice:hover {
            color: var(--sf-ocean-bright);
            background: var(--sf-sky-light);
        }

        .sf-back-to-choice i {
            transition: transform var(--sf-transition-normal);
        }

        .sf-back-to-choice:hover i {
            transform: translateX(-4px);
        }

        @media (max-width: 576px) {
            .sf-auth-container {
                padding: 1rem 0.5rem;
            }

            .sf-auth-header {
                padding: 2rem 1.5rem;
            }

            .sf-auth-title {
                font-size: 1.4rem;
            }

            .sf-auth-body {
                padding: 1.5rem;
            }

            .sf-auth-logo {
                width: 70px;
                height: 70px;
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

    <div class="sf-auth-container">
        <div class="sf-auth-card">
            <div class="sf-auth-header">
                <div class="sf-auth-logo">
                    <img src="{{ asset('assets/images/logo/pkibs.png') }}" alt="PIBKS Logo">
                    <img src="{{ asset('assets/images/logo/Kolej-UNITI.png') }}" alt="UNITI Logo">
                </div>
                <h1 class="sf-auth-title">Pengesahan Guru Penyelaras 🔐</h1>
                <p class="sf-auth-subtitle">Sila sahkan kelayakan anda untuk meneruskan pendaftaran sekolah</p>
            </div>

            <div class="sf-auth-body">
                @if(session('error'))
                    <div class="sf-alert sf-alert-danger sf-fade-in">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="sf-alert sf-alert-success sf-fade-in">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="sf-alert sf-alert-danger sf-fade-in">
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

                <div class="sf-auth-info">
                    <div class="sf-auth-info-header">
                        <i class="fas fa-info-circle"></i>
                        <span>Pengesahan Diperlukan</span>
                    </div>
                    <p>Untuk keselamatan, hanya guru penyelaras yang berdaftar boleh mengakses borang pendaftaran sekolah. Sila masukkan butiran yang diberikan oleh pentadbir sistem.</p>
                </div>

                <form method="POST" action="{{ route('school.auth.submit') }}" id="authForm">
                    @csrf
                    
                    <div class="sf-form-group">
                        <label class="sf-form-label">
                            <i class="fas fa-user"></i>
                            Nama Penyelaras <span class="sf-required">*</span>
                        </label>
                        <div class="sf-input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" 
                                   name="name" 
                                   class="sf-form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama penuh seperti yang didaftarkan"
                                   required>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sf-form-group">
                        <label class="sf-form-label">
                            <i class="fas fa-envelope"></i>
                            Alamat E-mel <span class="sf-required">*</span>
                        </label>
                        <div class="sf-input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" 
                                   name="email" 
                                   class="sf-form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="Masukkan e-mel berdaftar anda"
                                   required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sf-form-group">
                        <label class="sf-form-label">
                            <i class="fas fa-key"></i>
                            Kod Rahsia <span class="sf-required">*</span>
                        </label>
                        <div class="sf-input-group">
                            <i class="fas fa-key"></i>
                            <input type="text" 
                                   name="secret_code" 
                                   class="sf-form-control @error('secret_code') is-invalid @enderror" 
                                   value="{{ old('secret_code') }}" 
                                   placeholder="Masukkan kod rahsia anda"
                                   required>
                        </div>
                        @error('secret_code')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="sf-form-hint">
                            <i class="fas fa-shield-alt"></i>
                            <span>Kod unik yang diberikan semasa akaun penyelaras anda didaftarkan.</span>
                        </div>
                    </div>

                    <button type="submit" class="sf-btn sf-btn-success sf-btn-block sf-btn-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Sahkan & Teruskan</span>
                    </button>
                </form>

                <div class="sf-auth-divider">
                    <a href="{{ route('register.choice') }}" class="sf-back-to-choice">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Pilihan Pendaftaran</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('authForm');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                const requiredFields = form.querySelectorAll('input[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    const alertHtml = `
                        <div class="sf-alert sf-alert-danger sf-fade-in">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Sila lengkapkan semua ruangan yang diperlukan.</span>
                        </div>
                    `;
                    
                    const existingAlerts = document.querySelectorAll('.sf-alert');
                    existingAlerts.forEach(alert => alert.remove());
                    
                    const authBody = document.querySelector('.sf-auth-body');
                    authBody.insertAdjacentHTML('afterbegin', alertHtml);
                }
            });
            
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
</body>
</html>
