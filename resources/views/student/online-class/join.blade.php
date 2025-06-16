<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">
    <title>Join Online Class - {{ $onlineClass->name }}</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('assets/src/css/vendors_css.css') }}">
    
    <!-- Style-->  
    <link rel="stylesheet" href="{{ asset('assets/src/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/css/skin_color.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/customCSS.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customLayoutCSS.css') }}">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        
        .join-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 500px;
            width: 90%;
            margin: 20px;
        }
        
        .join-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .join-body {
            padding: 40px 30px;
        }
        
        .class-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-upcoming {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .status-today {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .status-past {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        
        .join-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }
        
        .join-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: white;
            text-decoration: none;
        }
        
        .login-prompt {
            background: #fff8e1;
            border: 1px solid #ffcc02;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .login-btn {
            background: #ff6b6b;
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        
        .login-btn:hover {
            background: #ee5a5a;
            color: white;
            text-decoration: none;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .info-item i {
            margin-right: 10px;
            width: 20px;
            color: #667eea;
        }
    </style>
</head>

<body>
    <div class="join-container">
        <div class="join-header">
            <h2 class="mb-2">{{ $onlineClass->name }}</h2>
            <div class="status-badge 
                @if($onlineClass->isPast()) status-past 
                @elseif($onlineClass->isToday()) status-today 
                @else status-upcoming 
                @endif">
                @if($onlineClass->isPast()) 
                    Past Class
                @elseif($onlineClass->isToday()) 
                    Today's Class
                @else 
                    Upcoming Class
                @endif
            </div>
        </div>
        
        <div class="join-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    <strong>Error:</strong> {{ session('error') }}
                </div>
            @endif

            <div class="class-info">
                <div class="info-item">
                    <i class="fa fa-calendar"></i>
                    <span><strong>Date:</strong> {{ $onlineClass->datetime->format('l, d F Y') }}</span>
                </div>
                <div class="info-item">
                    <i class="fa fa-clock-o"></i>
                    <span><strong>Time:</strong> {{ $onlineClass->datetime->format('h:i A') }}</span>
                </div>
                <div class="info-item">
                    <i class="fa fa-graduation-cap"></i>
                    <span><strong>Status:</strong> {{ ucfirst($onlineClass->status) }}</span>
                </div>
            </div>

            @if($onlineClass->status !== 'active')
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i>
                    This online class is currently inactive.
                </div>
            @elseif(!auth()->guard('student')->check())
                <div class="login-prompt">
                    <h5><i class="fa fa-lock"></i> Authentication Required</h5>
                    <p>You must be logged in as a student to join this online class.</p>
                    <a href="{{ route('login') }}" class="login-btn">
                        <i class="fa fa-sign-in"></i> Login as Student
                    </a>
                </div>
            @else
                @php
                    $student = auth()->guard('student')->user();
                    $selectedSchoolIds = $onlineClass->school ?? [];
                    $isAuthorized = in_array($student->school_id, $selectedSchoolIds);
                @endphp
                
                @if(!$isAuthorized)
                    <div class="alert alert-danger">
                        <h5><i class="fa fa-times-circle"></i> Access Denied</h5>
                        <p>Your school is not included in this online class session.</p>
                        <small>School: {{ $student->school->name ?? 'Unknown' }}</small>
                    </div>
                @elseif($student->status !== 'active')
                    <div class="alert alert-warning">
                        <h5><i class="fa fa-user-times"></i> Account Inactive</h5>
                        <p>Your student account is not active. Please contact the administrator.</p>
                    </div>
                @else
                    <div class="text-center">
                        <p class="mb-3">
                            <i class="fa fa-check-circle text-success"></i> 
                            You are authorized to join this class
                        </p>
                        <p class="text-muted mb-4">
                            <strong>Welcome, {{ $student->name }}!</strong><br>
                            School: {{ $student->school->name ?? 'Unknown' }}
                        </p>
                        
                        <a href="{{ route('online-class.join', $onlineClass->id) }}" class="join-btn">
                            <i class="fa fa-video"></i> Join Online Class
                        </a>
                        
                        <p class="text-muted mt-3">
                            <small>You will be redirected to the meeting platform</small>
                        </p>
                    </div>
                @endif
            @endif
            
            <div class="text-center mt-4">
                @if(auth()->guard('student')->check())
                    <a href="{{ route('student.subjects.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Subjects
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-home"></i> Student Portal
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/src/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/assets/icons/feather-icons/feather.min.js') }}"></script>
    
    <script>
        // Auto-refresh page every 30 seconds for real-time updates
        setTimeout(function() {
            window.location.reload();
        }, 30000);
        
        // Show countdown if class is starting soon  
        @if($onlineClass->datetime->diffInMinutes(now()) <= 720 && $onlineClass->datetime->isFuture())
            // Create date object in Malaysia timezone
            const startTime = new Date('{{ $onlineClass->datetime->format('Y-m-d\TH:i:s') }}+08:00');
            
            function updateCountdown() {
                const now = new Date();
                const diff = startTime - now;
                
                if (diff > 0) {
                    const totalMinutes = Math.floor(diff / 60000);
                    const seconds = Math.floor((diff % 60000) / 1000);
                    
                    // Format time display
                    let timeDisplay = '';
                    if (totalMinutes >= 60) {
                        const hours = Math.floor(totalMinutes / 60);
                        const minutes = totalMinutes % 60;
                        timeDisplay = `${hours}h ${minutes}m ${seconds}s`;
                    } else {
                        timeDisplay = `${totalMinutes}m ${seconds}s`;
                    }
                    
                    // Create or update countdown display
                    let countdown = document.getElementById('countdown');
                    if (!countdown) {
                        countdown = document.createElement('div');
                        countdown.id = 'countdown';
                        countdown.className = 'alert alert-info text-center mt-3';
                        countdown.innerHTML = '<strong><i class="fa fa-clock-o"></i> Class starts in: <span id="time"></span></strong>';
                        document.querySelector('.class-info').appendChild(countdown);
                    }
                    
                    document.getElementById('time').textContent = timeDisplay;
                } else {
                    // Class has started, reload page
                    window.location.reload();
                }
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        @endif
    </script>
</body>
</html> 