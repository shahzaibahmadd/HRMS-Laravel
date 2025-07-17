<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">HR Management System</a>

    <div class="ms-auto d-flex">
        @guest
            <a class="btn btn-outline-light" href="{{ route('login') }}">Login</a>
        @else
            <ul class="navbar-nav me-3">
                @role('Admin')
{{--                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" href="{{ route('manager.dashboard') }}">Manager Dashboard</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" href="{{ route('employee.dashboard') }}">Employee Dashboard</a></li>--}}
{{--                --}}
                <li class="nav-item" ><a class="nav-link" href="{{ route('admin.users.hr') }}">HRs</a></li>
                <li class="nav-item" ><a class="nav-link" href="{{ route('admin.users.manager') }}">Managers</a></li>
                <li class="nav-item" ><a class="nav-link" href="{{ route('admin.users.employee') }}">Employees</a></li>





                @elserole('HR')
                <li class="nav-item"><a class="nav-link" href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
                @elserole('Manager')
                <li class="nav-item"><a class="nav-link" href="{{ route('manager.dashboard') }}">Manager Dashboard</a></li>
                @elserole('Employee')
                <li class="nav-item"><a class="nav-link" href="{{ route('employee.dashboard') }}">Employee Dashboard</a></li>
                @endrole
            </ul>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light" type="submit">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<!-- Main Content -->
<main class="container mt-4">
    <!-- Admin Navbar if defined -->
    @hasSection('admin')
        <div class="bg-light border-bottom mb-3">
            @yield('admin')
        </div>
    @endif
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
