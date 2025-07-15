<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }
        .credential-item {
            margin: 10px 0;
            font-size: 16px;
        }
        .credential-label {
            font-weight: bold;
            color: #495057;
        }
        .credential-value {
            color: #007bff;
            font-family: monospace;
            background-color: #e9ecef;
            padding: 5px 8px;
            border-radius: 3px;
            display: inline-block;
            margin-left: 10px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <p>Welcome to Your Tax Management Solution</p>
        </div>

        <h2 style="color: #007bff;">Welcome, {{ $name }}!</h2>

        <p>Thank you for signing up with <strong>{{ config('app.name') }}</strong>. We're excited to have you on board!</p>

        <p>Your account has been successfully created. Here are your login credentials:</p>

        <div class="credentials-box">
            <div class="credential-item">
                <span class="credential-label">Email:</span>
                <span class="credential-value">{{ $email }}</span>
            </div>
            <div class="credential-item">
                <span class="credential-label">Password:</span>
                <span class="credential-value">{{ $password }}</span>
            </div>
        </div>

        <div class="warning">
            <strong>⚠️ Important Security Notice:</strong><br>
            For your security, please log in and change your password immediately after your first login.
        </div>

        <div style="text-align: center;">
            <a href="https://coretaxify.com/login" class="button">Login to Your Account</a>
        </div>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

        <div class="footer">
            <p>Best regards,<br>
            <strong>The {{ config('app.name') }} Team</strong></p>
            <p style="font-size: 12px; color: #adb5bd;">
                This email was sent to {{ $email }}. If you didn't create an account, please ignore this email.
            </p>
        </div>
    </div>
</body>
</html>
