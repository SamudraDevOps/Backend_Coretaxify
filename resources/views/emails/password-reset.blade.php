<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - {{ config('app.name') }}</title>
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
            border-bottom: 2px solid #dc3545;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #dc3545;
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
            color: #dc3545;
            font-family: monospace;
            background-color: #e9ecef;
            padding: 5px 8px;
            border-radius: 3px;
            display: inline-block;
            margin-left: 10px;
        }
        .warning {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .success-notice {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
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
            background-color: #dc3545;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .security-checklist {
            background-color: #e2e3e5;
            border: 1px solid #d6d8db;
            color: #383d41;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <p>Password Reset Notification</p>
        </div>

        <div style="text-align: center;">
            <div class="icon">🔑</div>
            <h2 style="color: #dc3545;">Password Successfully Reset</h2>
        </div>

        <p>Hi {{ $name }},</p>

        <div class="success-notice">
            <strong>✅ Password Reset Complete</strong><br>
            Your password has been successfully reset as requested.
        </div>

        <p>Your account password has been reset and a new temporary password has been generated. Here are your updated login credentials:</p>

        <div class="credentials-box">
            <div class="credential-item">
                <span class="credential-label">Email:</span>
                <span class="credential-value">{{ $email }}</span>
            </div>
            <div class="credential-item">
                <span class="credential-label">New Password:</span>
                <span class="credential-value">{{ $password }}</span>
            </div>
        </div>

        <div class="warning">
            <strong>🚨 Immediate Action Required:</strong><br>
            For your security, please log in immediately and change this temporary password to a strong, unique password of your choice.
        </div>

        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/login" class="button">Login Now</a>
        </div>

        <div class="security-checklist">
            <strong>🛡️ Security Recommendations:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Use a strong password with at least 8 characters</li>
                <li>Include uppercase, lowercase, numbers, and special characters</li>
                <li>Don't reuse passwords from other accounts</li>
                <li>Consider using a password manager</li>
                <li>Enable two-factor authentication if available</li>
            </ul>
        </div>

        <p>If you did not request this password reset, please contact our support team immediately as your account may be compromised.</p>

        <p>If you have any questions or need assistance, our support team is here to help.</p>

        <div class="footer">
            <p>Best regards,<br>
            <strong>The {{ config('app.name') }} Team</strong></p>
            <p style="font-size: 12px; color: #adb5bd;">
                This email was sent to {{ $email }}. If you didn't request a password reset, please contact support immediately.
            </p>
            <p style="font-size: 12px; color: #adb5bd;">
                For security reasons, this email contains sensitive information. Please delete it after use.
            </p>
        </div>
    </div>
</body>
</html>
