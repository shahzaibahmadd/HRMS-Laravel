<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .active-status {
            color: green;
            font-weight: bold;
        }
        .inactive-status {
            color: red;
            font-weight: bold;
        }
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            ⬅️ Back to Dashboard
        </a>
    </div>

    <!-- Page Title -->
    <h1 class="mb-4 text-center">📢 Announcements</h1>

    <!-- Announcement Form -->
    <div class="card mb-5 shadow">
        <div class="card-header bg-primary text-white">
            Create New Announcement
        </div>
        <div class="card-body">
            <form id="announcementForm">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Enter Title" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="message" rows="3" placeholder="Enter Message" required></textarea>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="is_active" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">➕ Create Announcement</button>
            </form>
        </div>
    </div>

    <!-- Announcement List -->
    <h2 class="mb-3">📃 All Announcements</h2>
    <div id="announcementList" class="row gy-3">
        @foreach($announcements as $a)
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $a->title }}</h5>
                        <p class="card-text">{{ $a->message }}</p>
                        <span class="{{ $a->is_active ? 'active-status' : 'inactive-status' }}">
                            ({{ $a->is_active ? 'Active' : 'Inactive' }})
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Toast Notifications -->
<div class="toast-container"></div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Pusher + Echo (no build step) -->
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

<script>
    // --- Axios CSRF Setup ---
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // --- Pusher Debug (Disable in Production) ---
    Pusher.logToConsole = false;

    // --- Echo Initialization ---
    const pusherKey = "{{ config('broadcasting.connections.pusher.key') }}";
    const pusherCluster = "{{ config('broadcasting.connections.pusher.options.cluster') }}";

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: pusherKey,
        cluster: pusherCluster,
        forceTLS: true
    });

    // Connection Error Handling
    window.Echo.connector.pusher.connection.bind('error', (err) => {
        console.error('❌ Pusher connection error:', err);
    });

    // --- Toast Helper Function ---
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

    // --- Form Submission ---
    document.getElementById('announcementForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const payload = {
            title: this.title.value,
            message: this.message.value,
            is_active: this.is_active.value
        };

        axios.post("{{ route('announcements.store') }}", payload)
            .then(res => {
                if (res.data.success) {
                    showToast('Announcement Created', 'Your announcement has been broadcasted.');
                    e.target.reset();
                } else {
                    alert('❌ Failed to create announcement!');
                }
            })
            .catch(err => {
                console.error('Announcement create error:', err);
                alert('❌ Error creating announcement (check console).');
            });
    });

    // --- Real-time Listener ---
    Echo.channel('announcements')
        .listen('.announcement.created', (e) => {
            const a = e.announcement ?? e;

            const statusClass = a.is_active ? 'active-status' : 'inactive-status';
            const statusText  = a.is_active ? 'Active' : 'Inactive';

            const newCard = document.createElement('div');
            newCard.classList.add('col-md-6');
            newCard.innerHTML = `
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">${a.title}</h5>
                        <p class="card-text">${a.message}</p>
                        <span class="${statusClass}">(${statusText})</span>
                    </div>
                </div>
            `;

            const container = document.getElementById('announcementList');
            container.insertBefore(newCard, container.firstChild);

            // Show toast notification
            showToast(a.title, a.message);
        });
</script>

</body>
</html>

