<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .header img {
            max-height: 80px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .content p {
            color: #555555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff !important;
            padding: 12px 20px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888888;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <img src="{{ $logo }}" alt="HRMS Logo">
    </div>
    <div class="content">
        <h1>Welcome to HRMS, {{ $name }}!</h1>
        <p>Your account has been successfully created. Use your registered email to log in:</p>
        <p><strong>{{ $email }}</strong></p>
        <a href="{{ url('/login') }}" class="btn">Login to Dashboard</a>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} HRMS – Developers Studio. All rights reserved.</p>
    </div>
</div>
</body>
</html>
