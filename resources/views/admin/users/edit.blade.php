@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user->id }}">

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select">
                    <option value="HR" {{ $user->hasRole('HR') ? 'selected' : '' }}>HR</option>
                    <option value="Manager" {{ $user->hasRole('Manager') ? 'selected' : '' }}>Manager</option>
                    <option value="Employee" {{ $user->hasRole('Employee') ? 'selected' : '' }}>Employee</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Profile Image</label><br>
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" width="80" height="80" class="rounded-circle mb-2">
                @endif
                <input type="file" name="profile_image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update User</button>
        </form>
    </div>
@endsection
