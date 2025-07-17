@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container mt-4">
        <h4>User Profile</h4>
        <div class="card">
            <div class="card-body">
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image"
                         class="rounded-circle" width="100" height="100">
                </div>
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
            </div>
        </div>
    </div>
@endsection
