Hi {{ $name }},

Your password has been reset. Here are your login credentials:

Email: {{ $email }}
Password: {{ $password }}

Please login and change your password for security.

Best regards,
{{ config('app.name') }}
