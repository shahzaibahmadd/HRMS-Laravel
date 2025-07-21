<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HR Management System</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .welcome-box {
            text-align: center;
            animation: fadeIn 2s ease-in-out;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
        }

        .welcome-box h1 {
            font-size: 2.5rem;
            font-weight: 600;
        }

        .welcome-box p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-login {
            font-size: 1rem;
            padding: 12px 30px;
            background-color: #ffffff;
            color: #2a5298;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            transition: 0.3s ease-in-out;
        }

        .btn-login:hover {
            background-color: #e2e6ea;
            color: #1e3c72;
        }

        @keyframes fadeIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<div class="welcome-box">
    <h1>Welcome to HR Management System</h1>
    <p>Manage Employees, Attendance, Payroll & More</p>
    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
</div>

</body>
</html>
