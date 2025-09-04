<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Correction - Online Tuition Platform</title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .header { background: linear-gradient(135deg, #17a2b8, #0d6efd); color: white; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; }
        .content { padding: 30px; }
        .notice { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin-bottom: 25px; border-radius: 4px; }
        .credentials-box { background-color: #f8f9fa; border: 2px solid #dee2e6; border-radius: 8px; padding: 20px; margin: 25px 0; }
        .credentials-box h3 { margin-top: 0; color: #495057; text-align: center; }
        .credential-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #dee2e6; }
        .credential-item:last-child { border-bottom: none; }
        .credential-label { font-weight: bold; color: #6c757d; }
        .credential-value { background-color: #e9ecef; padding: 8px 12px; border-radius: 4px; font-family: 'Courier New', monospace; font-weight: bold; color: #495057; }
        .login-button { display: inline-block; background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; margin: 20px 0; transition: all 0.3s ease; }
        .login-button:hover { background: linear-gradient(135deg, #0056b3, #004085); transform: translateY(-2px); }
        .footer { background-color: #6c757d; color: white; text-align: center; padding: 20px; font-size: 14px; }
        @media (max-width: 600px) { .container { margin: 10px; border-radius: 0; } .content { padding: 20px; } .credential-item { flex-direction: column; align-items: flex-start; gap: 8px; } .credential-value { word-break: break-all; } }
    </style>
    </head>
<body>
    <div class="container">
        <div class="header">
            <h1>Important: Password Correction</h1>
            <p>Online Tuition Platform</p>
        </div>
        <div class="content">
            <p>Dear {{ $studentName }},</p>
            <div class="notice">
                We apologize for the inconvenience. The approval email you received contained an incorrect password value. Please use the corrected password below to log in.
            </div>

            <div class="credentials-box">
                <h3>Your Login Details</h3>
                <div class="credential-item">
                    <span class="credential-label">Username:</span>
                    <span class="credential-value">{{ $username }}</span>
                </div>
                <div class="credential-item">
                    <span class="credential-label">Correct Password:</span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>

            <p>For your security, please change your password after your first login.</p>

            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="login-button">Login to Your Account</a>
            </div>

            <p style="margin-top: 20px;">If you have any questions, please contact your school administrator or our support team. Thank you for your understanding.</p>
            <p style="margin-top: 10px;">School: <strong>{{ $schoolName }}</strong></p>
        </div>
        <div class="footer">
            <p>This is an automated message. Please do not reply.</p>
            <p style="font-size: 12px; margin-top: 10px;">© {{ date('Y') }} Online Tuition Platform. All rights reserved.</p>
        </div>
    </div>
</body>
</html>


