<!-- resources/views/layouts/partials/admin-navbar.blade.php -->

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">HRMS Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">All Users</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.create') }}">Add New User</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Performance Reminders</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link text-white">Welcome, {{ auth()->user()->name }}</span>
                </li>
            </ul>
        </div>
    </div>
</nav>
