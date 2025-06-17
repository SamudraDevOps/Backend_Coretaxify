<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - {{ config('app.name') }}</title>
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
            border-bottom: 2px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }
        .otp-box {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            margin: 30px 0;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 8px;
            font-family: monospace;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .timer-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .security-note {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">{{ config('app.name', 'Coretaxify') }}</div>
            <p>Email Verification Required</p>
        </div>

        <div style="text-align: center;">
            <div class="icon">🔐</div>
            <h2 style="color: #28a745;">Verify Your Email Address</h2>
        </div>

        <p>Hi there!</p>

        <p>Thank you for signing up with <strong>{{ config('app.name', 'Coretaxify') }}</strong>. To complete your registration and secure your account, please verify your email address using the verification code below:</p>

        <div class="otp-box">
            <p style="margin: 0; font-size: 18px;">Your Verification Code</p>
            <div class="otp-code">{{ $otp }}</div>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Enter this code to verify your email</p>
        </div>

        <div class="timer-info">
            <strong>⏰ Time Sensitive:</strong><br>
            This verification code will expire in <strong>10 minutes</strong> for your security.
        </div>

        <div class="security-note">
            <strong>🛡️ Security Tips:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Never share this code with anyone</li>
                <li>We will never ask for this code via phone or email</li>
                <li>If you didn't request this code, please ignore this email</li>
            </ul>
        </div>

        <p>If you're having trouble with the verification process, please contact our support team for assistance.</p>

        <div class="footer">
            <p>Best regards,<br>
            <strong>The {{ config('app.name', 'Coretaxify') }} Team</strong></p>
            <p style="font-size: 12px; color: #adb5bd;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
