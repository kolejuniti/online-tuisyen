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

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(139, 92, 246, 0.8));
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.95;
            margin-bottom: 2rem;
        }

        .main-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin: 1rem auto 3rem;
            border-radius: 24px;
            box-shadow: var(--shadow-heavy);
            max-width: 800px;
            padding: 3rem;
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
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
            display: block;
        }

        .required {
            color: var(--danger-color);
        }

        .form-control {
            border: 2px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }



        .feature-highlight {
            background: linear-gradient(135deg, rgba(221, 214, 254, 0.8), rgba(224, 231, 255, 0.6));
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
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
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title animate__animated animate__fadeInDown">Student Registration</h1>
            <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                Join our online learning platform and unlock your potential with expert guidance and comprehensive resources.
            </p>
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
                    <a href="{{ url('/') }}" class="btn btn-primary-custom">
                        <i class="fas fa-home"></i> Back to Home
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
                            Personal Information
                        </h2>
                        
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
                            Parent/Guardian Information
                        </h2>

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
                            School & Account Information
                        </h2>

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
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-paper-plane"></i> Submit Registration
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
        $(document).ready(function() {
            // Initialize Select2 for school selection with AJAX search
            $('#schoolSelect').select2({
                placeholder: 'Search and select your school...',
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
        });
    </script>
</body>
</html> 