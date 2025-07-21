@extends('layouts.app')

@section('admin')
    @include('layouts.admin')
@endsection

@section('content')
    <div class="container mt-4">
        <h3>List of HR Users</h3>
        <table class="table table-bordered table-striped mt-3">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($hrs as $user)
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
                        <a href="{{ route('payroll.hr.edit', $user->id) }}" class="btn btn-sm btn-dark">Edit Payroll</a>
                        <a href="{{ route('payroll.show', $user->id) }}" class="btn btn-sm btn-dark">View Payroll</a>
                        @role('Admin')

                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                            </form>
                        @endrole


                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No HRs found.</td></tr>
            @endforelse
            </tbody>
        </table>
        @role('Admin')

        @if($deletedHR->count())
            <h3 class="mt-5 text-danger">Deleted HR</h3>
            <table class="table table-bordered table-striped mt-3">
                <thead>
                <tr>
                    <th>Image</th><th>Name</th><th>Email</th><th>Phone</th><th>Deleted At</th><th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deletedHR as $user)
                    <tr>
                        <td><img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" width="50" height="50" class="rounded-circle"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->deleted_at->diffForHumans() }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.restore', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" onclick="return confirm('Restore this user?')">Undo Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
@endrole


    </div>
@endsection
