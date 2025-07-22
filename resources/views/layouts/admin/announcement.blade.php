@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container py-4">
        <!-- Back to Dashboard Button -->
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary mb-4">
            ⬅️ Back to Dashboard
        </a>

        <!-- Page Title -->
        <h2 class="mb-3 text-white">📢 Announcements</h2>

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
                    <button type="submit" class="btn btn-success">➕ Create Announcement</button>
                </form>
            </div>
        </div>

        <!-- Announcement List -->
        <h4 class="mb-3 text-white">📃 All Announcements</h4>
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

    <!-- Toast Notifications -->
    <div class="toast-container"></div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>
    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] =
            document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
            toast.className = 'toast align-items-center text-bg-primary border-0 show';
            toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    🔔 <strong>${title}</strong><br>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>`;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }

        document.getElementById('announcementForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const payload = { title: this.title.value, message: this.message.value };

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
                </div>`;
                const container = document.getElementById('announcementList');
                container.insertBefore(newCard, container.firstChild);
                showToast(a.title, a.message);
            });
    </script>
@endpush
