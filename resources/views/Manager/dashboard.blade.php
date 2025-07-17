<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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
    <h2 class="mb-3">Manager Dashboard</h2>
    <p>Welcome, Manager! You can oversee teams and approve relevant leaves.</p>

    <ul>
        <li>View your team’s performance</li>
        <li>Approve leave requests from your team</li>
        <li>Assign tasks and monitor deadlines</li>
    </ul>

    <!-- Live Announcements -->
    <div class="card mt-4 shadow">
        <div class="card-header bg-info text-white">
            Live Announcements
        </div>
        <div class="card-body">
            <ul id="announcementList" class="list-group">
                @forelse($announcements as $announcement)
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        data-announcement-id="{{ $announcement->id }}">
                        <div>
                            <strong>{{ $announcement->title }}</strong> - {{ $announcement->message }}
                        </div>
                        <span class="badge bg-{{ $announcement->is_active ? 'success' : 'danger' }}">
                            {{ $announcement->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted fst-italic" data-empty="true">
                        No announcements yet.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Toast container -->
<div class="toast-container"></div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Pusher & Laravel Echo -->
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

<script>
    console.log('Manager dashboard announcements listener starting...');

    // Disable Pusher noisy logging in production
    Pusher.logToConsole = false;

    // Echo Instance
    const pusherKey = "{{ config('broadcasting.connections.pusher.key') }}";
    const pusherCluster = "{{ config('broadcasting.connections.pusher.options.cluster') }}";

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: pusherKey,
        cluster: pusherCluster,
        forceTLS: true
    });

    // Connection error debug
    window.Echo.connector.pusher.connection.bind('error', (err) => {
        console.error('❌ Pusher connection error (Manager Dashboard):', err);
    });

    // Toast helper
    function showToast(title, message) {
        const container = document.querySelector('.toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-bg-info border-0 show';
        toast.role = 'alert';
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    📢 <strong>${title}</strong><br>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }

    const list = document.getElementById('announcementList');

    // Remove "No announcements yet." placeholder if present
    function clearEmptyPlaceholder() {
        const empty = list.querySelector('[data-empty="true"]');
        if (empty) empty.remove();
    }

    // Simple duplicate guard (in case of reconnect or multiple tabs)
    function hasAnnouncement(id) {
        return !!list.querySelector(`[data-announcement-id="${id}"]`);
    }

    // Listen for announcements
    Echo.channel('announcements')
        .listen('.announcement.created', (e) => {
            const a = e.announcement ?? e;

            // Guard: don't re-add the same announcement if it already exists
            if (a.id && hasAnnouncement(a.id)) {
                console.debug('Announcement already exists in list, skipping duplicate:', a.id);
                return;
            }

            clearEmptyPlaceholder();

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            if (a.id) li.dataset.announcementId = a.id;
            li.innerHTML = `
                <div>
                    <strong>${a.title}</strong> - ${a.message}
                </div>
                <span class="badge bg-${a.is_active ? 'success' : 'danger'}">
                    ${a.is_active ? 'Active' : 'Inactive'}
                </span>
            `;

            // Insert newest at top
            list.insertBefore(li, list.firstChild);

            // Toast
            showToast(a.title, a.message);
        });
</script>

</body>
</html>
