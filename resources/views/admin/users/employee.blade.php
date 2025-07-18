@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container mt-4">
        <h3>List of Employee Users</h3>
        <table class="table table-bordered table-striped mt-3">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($employees as $user)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image"
                             width="50" height="50" class="rounded-circle">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.profile', $user->id) }}" class="btn btn-sm btn-info">View Profile</a>
                        <a href="{{ route('admin.users.dashboard', ['user' => $user->id]) }}" class="btn btn-sm btn-primary">Dashboard</a>

                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No employees found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
