@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">HR Dashboard - Viewing {{ $user->name }}</h2>

        <div class="row">
            <!-- Profile Info -->
            <div class="col-md-5 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        @if ($user->profile_image)
                            <img src="{{ asset('storage/user_images/' . $user->profile_image) }}" alt="Profile Image" class="rounded-circle mb-3" width="150">
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" class="rounded-circle mb-3" width="150">
                        @endif

                        <h4>{{ $user->name }}</h4>
                        <p>Email: {{ $user->email }}</p>
                        <p>Phone: {{ $user->phone }}</p>
                        <p>Status:
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        </p>
                        <p>Role: <strong>{{ ucfirst($user->roles->first()->name ?? 'N/A') }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Announcements -->
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">Live Announcements</div>
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
        </div>
    </div>

    <!-- Toast container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

    <script>
        console.log('HR dashboard announcements listener starting...');

        Pusher.logToConsole = false;

        const pusherKey = "{{ config('broadcasting.connections.pusher.key') }}";
        const pusherCluster = "{{ config('broadcasting.connections.pusher.options.cluster') }}";

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: pusherKey,
            cluster: pusherCluster,
            forceTLS: true
        });

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

        function clearEmptyPlaceholder() {
            const empty = list.querySelector('[data-empty="true"]');
            if (empty) empty.remove();
        }

        function hasAnnouncement(id) {
            return !!list.querySelector(`[data-announcement-id="${id}"]`);
        }

        Echo.channel('announcements')
            .listen('.announcement.created', (e) => {
                const a = e.announcement ?? e;

                if (a.id && hasAnnouncement(a.id)) return;

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
                list.insertBefore(li, list.firstChild);
                showToast(a.title, a.message);
            });
    </script>
@endpush
