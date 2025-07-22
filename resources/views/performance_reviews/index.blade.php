@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Performance Reviews</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @role('Admin|HR|Manager')
        <a href="{{ route('performance.create') }}" class="btn btn-primary mb-3">Create New Review</a>
        @endrole

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>Employee</th>
                    <th>Rating</th>
                    <th>Feedback</th>
                    <th>Review Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($reviews as $review)
                    <tr>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->rating }}</td>
                        <td>{{ $review->feedback ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($review->review_date)->format('d M Y') }}</td>
                        <td>
                            @role('Admin|HR|Manager')
                            <a href="{{ route('performance.edit', $review->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('performance.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this review?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @endrole
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No reviews found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
