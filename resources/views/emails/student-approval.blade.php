<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved - Online Tuition Platform</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .welcome-message {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .credentials-box h3 {
            margin-top: 0;
            color: #495057;
            text-align: center;
        }
        .credential-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .credential-item:last-child {
            border-bottom: none;
        }
        .credential-label {
            font-weight: bold;
            color: #6c757d;
        }
        .credential-value {
            background-color: #e9ecef;
            padding: 8px 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #495057;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .login-button:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-2px);
        }
        .important-note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .footer {
            background-color: #6c757d;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .school-info {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 0;
            }
            .content {
                padding: 20px;
            }
            .credential-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .credential-value {
                word-break: break-all;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="icon">🎉</div>
            <h1>Welcome to Online Tuition!</h1>
            <p>Your account has been approved</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Welcome Message -->
            <div class="welcome-message">
                <strong>Congratulations, {{ $studentName }}!</strong> 
                Your student registration has been approved by our administrators. You now have full access to our online tuition platform.
            </div>

            <!-- School Information -->
            <div class="school-info">
                <strong>📚 School:</strong> {{ $schoolName }}
            </div>

            <!-- Login Credentials -->
            <div class="credentials-box">
                <h3>🔐 Your Login Credentials</h3>
                <div class="credential-item">
                    <span class="credential-label">Username:</span>
                    <span class="credential-value">{{ $username }}</span>
                </div>
                <div class="credential-item">
                    <span class="credential-label">Password:</span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>

            <!-- Important Security Note -->
            <div class="important-note">
                <strong>⚠️ Important Security Notice:</strong>
                <br>For your security, we strongly recommend changing your password after your first login. You can do this from your account settings.
            </div>

            <!-- Login Button -->
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="login-button">
                    🚀 Login to Your Account
                </a>
            </div>

            <!-- Platform Features -->
            <div style="margin-top: 30px;">
                <h3>🌟 What you can do now:</h3>
                <ul style="line-height: 1.8;">
                    <li>📖 Access subject content and materials</li>
                    <li>📝 Take assessments and quizzes</li>
                    <li>🎥 Join online classes and live sessions</li>
                    <li>💬 Participate in discussion forums</li>
                    <li>📊 Track your learning progress</li>
                    <li>📚 Access the digital library</li>
                </ul>
            </div>

            <!-- Support Information -->
            <div style="margin-top: 25px; padding: 15px; background-color: #f1f3f4; border-radius: 5px;">
                <strong>🆘 Need Help?</strong>
                <p style="margin: 10px 0 0 0;">
                    If you have any questions or need assistance, please don't hesitate to contact our support team or your school administrator.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Online Tuition Platform</strong></p>
            <p>This is an automated message. Please do not reply to this email.</p>
            <p style="font-size: 12px; margin-top: 10px;">
                © {{ date('Y') }} Online Tuition Platform. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html> 