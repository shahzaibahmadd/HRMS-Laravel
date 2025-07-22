@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user->id }}">

            <!-- Name -->
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label>New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label>Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select">
                    <option value="HR" {{ $user->hasRole('HR') ? 'selected' : '' }}>HR</option>
                    <option value="Manager" {{ $user->hasRole('Manager') ? 'selected' : '' }}>Manager</option>
                    <option value="Employee" {{ $user->hasRole('Employee') ? 'selected' : '' }}>Employee</option>
                </select>
            </div>

            <!-- Profile Image -->
            <div class="mb-3">
                <label>Profile Image</label><br>
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" width="80" height="80" class="rounded-circle mb-2">
                @endif
                <input type="file" name="profile_image" class="form-control">
            </div>

            <!-- Skills -->
            <div class="mb-3">
                <label>Skills</label>
                <textarea name="skills" class="form-control" rows="3">{{ old('skills', $user->skills) }}</textarea>
            </div>

            <!-- Resume -->
            <div class="mb-3">
                <label>Resume</label><br>
                @if($user->resume)
                    <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="btn btn-sm btn-info mb-2">View Current Resume</a>
                @endif
                <input type="file" name="resume" class="form-control">
            </div>

            <!-- Contract -->
            <div class="mb-3">
                <label>Contract</label><br>
                @if($user->contract)
                    <a href="{{ asset('storage/' . $user->contract) }}" target="_blank" class="btn btn-sm btn-info mb-2">View Current Contract</a>
                @endif
                <input type="file" name="contract" class="form-control">
            </div>

            <!-- Documents -->
            <div class="mb-3">
                <label>Additional Documents</label><br>
                @if($user->documents)
                    <a href="{{ asset('storage/' . $user->documents) }}" target="_blank" class="btn btn-sm btn-info mb-2">View Current Documents</a>
                @endif
                <input type="file" name="documents" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update User</button>
        </form>
    </div>
@endsection
