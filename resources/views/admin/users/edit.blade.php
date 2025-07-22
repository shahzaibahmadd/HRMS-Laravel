@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user->id }}">

            <!-- Name -->
            <div class="mb-3">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label>New Password (optional)</label>
                <input type="password" name="password" class="form-control">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label>Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="HR" {{ old('role', $user->hasRole('HR') ? 'HR' : '') == 'HR' ? 'selected' : '' }}>HR</option>
                    <option value="Manager" {{ old('role', $user->hasRole('Manager') ? 'Manager' : '') == 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="Employee" {{ old('role', $user->hasRole('Employee') ? 'Employee' : '') == 'Employee' ? 'selected' : '' }}>Employee</option>
                </select>
                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Profile Image -->
            <div class="mb-3">
                <label>Profile Image</label><br>
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" width="80" height="80" class="rounded-circle mb-2">
                @endif
                <input type="file" name="profile_image" class="form-control">
                @error('profile_image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Skills -->
            <div class="mb-3">
                <label>Skills</label>
                <textarea name="skills" class="form-control" rows="3">{{ old('skills', $user->skills) }}</textarea>
                @error('skills') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Resume -->
            <div class="mb-3">
                <label>Resume</label><br>
                @if($user->resume)
                    <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="btn btn-sm btn-info mb-2">View Current Resume</a>
                @endif
                <input type="file" name="resume" class="form-control">
                @error('resume') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Contract -->
            <div class="mb-3">
                <label>Contract</label><br>
                @if($user->contract)
                    <a href="{{ asset('storage/' . $user->contract) }}" target="_blank" class="btn btn-sm btn-info mb-2">View Current Contract</a>
                @endif
                <input type="file" name="contract" class="form-control">
                @error('contract') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Documents -->
            <div class="mb-3">
                <label>Additional Documents</label><br>
                @if($user->documents)
                    <a href="{{ asset('storage/' . $user->documents) }}" target="_blank" class="btn btn-sm btn-info mb-2">View Current Documents</a>
                @endif
                <input type="file" name="documents" class="form-control">
                @error('documents') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-success">Update User</button>
        </form>
    </div>
@endsection
