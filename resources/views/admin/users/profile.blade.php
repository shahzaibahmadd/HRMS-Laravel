@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container mt-4">
        <h4>User Profile</h4>
        <div class="card shadow">
            <div class="card-body">
                <!-- Profile Image -->
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/' . $user->profile_image) }}"
                         alt="Profile Image"
                         class="rounded-circle border border-3"
                         width="100" height="100">
                </div>

                <!-- Basic Info -->
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->roles->pluck('name')->first()) }}</p>
                <p><strong>Status:</strong>
                    @if($user->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </p>

                <!-- Skills -->
                <p><strong>Skills:</strong>
                    {{ $user->skills ?? 'No skills specified' }}
                </p>

                <!-- View Files -->
                <div class="mt-3">
                    @if($user->contract)
                        <a href="{{ asset('storage/' . $user->contract) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            View Contract
                        </a>
                    @endif

                    @if($user->resume)
                        <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="btn btn-outline-success btn-sm">
                            View Resume
                        </a>
                    @endif

                    @if($user->documents)
                        <a href="{{ asset('storage/' . $user->documents) }}" target="_blank" class="btn btn-outline-info btn-sm">
                            View Documents
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
