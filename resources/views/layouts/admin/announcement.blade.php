<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #1f407a;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #111;
        }

        .navbar .nav-link {
            color: white !important;
            margin-right: 15px;
        }

        .navbar .btn-logout {
            border: 1px solid white;
            color: white;
        }

        .top-banner {
            background-color: #666;
            padding: 15px;
            margin-bottom: 2rem;
            border-radius: 3px;
        }

        .top-banner h5 {
            display: inline-block;
            color: #fff;
            margin-right: 20px;
        }

        .top-banner .nav-link {
            color: #ddd;
            display: inline-block;
            margin-right: 15px;
        }

        .card {
            background-color: #2c4c8b;
            color: white;
        }

        .form-control, .form-select {
            background-color: #f8f9fa;
        }

        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
        <a class="navbar-brand text-white fw-bold" href="#">HR Management System</a>
        <div class="d-flex">
            <a class="nav-link" href="#">Admin Dashboard</a>
            <a class="nav-link" href="#">Announcements</a>
            <a class="nav-link" href="#">HRs</a>
            <a class="nav-link" href="#">Managers</a>
            <a class="nav-link" href="#">Employees</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline-block ms-2">
                @csrf
                <button class="btn btn-logout btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container py-5">
    <!-- Top Banner -->
    <div class="top-banner">
        <h5 class="fw-bold">📢 Announcements Panel</h5>
        <a class="nav-link d-inline" href="#">All Announcements</a>
        <a class="nav-link d-inline" href="#">Add New</a>
        <span class="float-end text-light">Welcome, Admin</span>
    </div>

    <!-- Form -->
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white">Create New Announcement</div>
        <div class="card-body">
            <form id="announcementForm">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Enter Title" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="message" rows="3" placeholder="Enter Message" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">➕ Create Announcement</button>
            </form>
        </div>
    </div>

    <!-- Announcement List -->
    <h3 class="mb-3">📃 Recent Announcements</h3>
    <div id="announcementList" class="row gy-3">
        @foreach($announcements as $a)
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $a->title }}</h5>
                        <p class="card-text">{{ $a->message }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container"></div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const pusherKey = "{{ config('broadcasting.connections.pusher.key') }}";
    const pusherCluster = "{{ config('broadcasting.connections.pusher.options.cluster') }}";

    Pusher.logToConsole = false;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: pusherKey,
        cluster: pusherCluster,
        forceTLS: true
    });

    window.Echo.connector.pusher.connection.bind('error', (err) => {
        console.error('❌ Pusher connection error:', err);
    });

    function showToast(title, message) {
        const container = document.querySelector('.toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-bg-primary border-0 show';
        toast.role = 'alert';
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    🔔 <strong>${title}</strong><br>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }

    document.getElementById('announcementForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const payload = {
            title: this.title.value,
            message: this.message.value
        };
        axios.post("{{ route('announcements.store') }}", payload)
            .then(res => {
                if (res.data.success) {
                    showToast('Announcement Created', 'Your announcement has been broadcasted.');
                    this.reset();
                } else {
                    alert('❌ Failed to create announcement!');
                }
            })
            .catch(err => {
                console.error('Announcement create error:', err);
                alert('❌ Error creating announcement (check console).');
            });
    });

    Echo.channel('announcements')
        .listen('.announcement.created', (e) => {
            const a = e.announcement ?? e;
            const newCard = document.createElement('div');
            newCard.classList.add('col-md-6');
            newCard.innerHTML = `
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">${a.title}</h5>
                        <p class="card-text">${a.message}</p>
                    </div>
                </div>
            `;
            const container = document.getElementById('announcementList');
            container.insertBefore(newCard, container.firstChild);
            showToast(a.title, a.message);
        });
</script>

</body>
</html>
