<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Custom Styling -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            min-height: 100vh;
        }

        nav.navbar {
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        main {
            padding-top: 30px;
            animation: fadeIn 1s ease-in-out;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-4">
    <a class="navbar-brand" href="/">HR Management System</a>

    <div class="ms-auto d-flex align-items-center">
        @guest
            <a class="btn btn-outline-light" href="{{ route('login') }}">Login</a>
        @else
            <ul class="navbar-nav me-3 align-items-center">
                @role('Admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.announcements.page') }}">Announcements</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.hr') }}">HRs</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.manager') }}">Managers</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.employee') }}">Employees</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('performance.index') }}">Performance Reviews</a></li>


                @elserole('HR')
                <li class="nav-item"><a class="nav-link" href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.manager') }}">Managers</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.employee') }}">Employees</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('payroll.show', $user->id) }}" >View My Payroll</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('performance.index') }}">Performance Reviews</a></li>



                @elserole('Manager')
                <li class="nav-item"><a class="nav-link" href="{{ route('manager.dashboard') }}">Manager Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.employee') }}">Employees</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('payroll.show', $user->id) }}" >View My Payroll</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('performance.index') }}">Performance Reviews</a></li>



                @elserole('Employee')
                <li class="nav-item"><a class="nav-link" href="{{ route('employee.dashboard') }}">Employee Dashboard</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('payroll.show', $user->id) }}" >View My Payroll</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('performance.index') }}">Performance Reviews</a></li>



                @endrole
            </ul>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light" type="submit">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<!-- Content -->
<main class="container fade-in">
    @hasSection('admin')
        <div class="bg-light border-bottom mb-3">
            @yield('admin')
        </div>
    @endif

    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
