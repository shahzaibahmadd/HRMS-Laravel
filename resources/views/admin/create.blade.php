@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container mt-4">

        {{-- Bootstrap Toast for Success --}}
        @if(session('success'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
                <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Bootstrap Toast for Error --}}
        @if(session('error'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
                <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

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
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Profile Image -->
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control">
                        @error('profile_image') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Skills -->
                    <div class="mb-3">
                        <label class="form-label">Skills</label>
                        <input type="text" name="skills" class="form-control" placeholder="e.g., PHP, Laravel, Vue.js" value="{{ old('skills') }}">
                        @error('skills') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Documents -->
                    <div class="mb-3">
                        <label class="form-label">Other Documents</label>
                        <input type="file" name="documents" class="form-control">
                        @error('documents') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Resume -->
                    <div class="mb-3">
                        <label class="form-label">Resume</label>
                        <input type="file" name="resume" class="form-control">
                        @error('resume') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Contract -->
                    <div class="mb-3">
                        <label class="form-label">Contract</label>
                        <input type="file" name="contract" class="form-control">
                        @error('contract') <span class="text-danger">{{ $message }}</span> @enderror
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
                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-success">Add User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
