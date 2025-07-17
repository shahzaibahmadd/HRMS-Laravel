@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white">
                <h4>Add New User</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <!-- Profile Image -->
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control">
                    </div>

                    <!-- Is Active -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="HR" {{ old('role') == 'HR' ? 'selected' : '' }}>HR</option>
                            <option value="Manager" {{ old('role') == 'Manager' ? 'selected' : '' }}>Manager</option>
                            <option value="Employee" {{ old('role') == 'Employee' ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-success">Add User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
