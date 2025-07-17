<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token (needed for JS fetch/axios posts) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- If you're using Vite for app JS (Echo, Pusher, etc.), include it here --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head') {{-- optional: child views can push extra <head> stuff --}}
</head>
<body>
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">HR Management System</a>

    <div class="ms-auto d-flex align-items-center">
        @guest
            <a class="btn btn-outline-light" href="{{ route('login') }}">Login</a>
        @else
            <ul class="navbar-nav me-3 align-items-center">

                @role('Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                </li>

                {{-- ✅ Show Announcements button ONLY when viewing the Admin Dashboard route --}}
                @if (Route::is('admin.dashboard'))
                    <li class="nav-item ms-2">
                        <a class="btn btn-warning text-dark" href="{{ route('admin.announcements.page') }}">
                            Manage Announcements
                        </a>
                    </li>
                @endif

                <li class="nav-item"><a class="nav-link" href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('manager.dashboard') }}">Manager Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('employee.dashboard') }}">Employee Dashboard</a></li>
                @elserole('HR')
                <li class="nav-item"><a class="nav-link" href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
                @elserole('Manager')
                <li class="nav-item"><a class="nav-link" href="{{ route('manager.dashboard') }}">Manager Dashboard</a></li>
                @elserole('Employee')
                <li class="nav-item"><a class="nav-link" href="{{ route('employee.dashboard') }}">Employee Dashboard</a></li>
                @endrole
            </ul>

            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button class="btn btn-outline-light" type="submit">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<!-- Main Content -->
<main class="container mt-4">
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts') {{-- child views can push scripts --}}
</body>
</html>
