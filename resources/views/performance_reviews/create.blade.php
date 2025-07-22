@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Performance Review</h2>

        <form method="POST" action="{{ route('performance.store') }}">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Select Employee</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Select --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->getRoleNames()->first() }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="review_date" class="form-label">Review Date</label>
                <input type="date" name="review_date" id="review_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="feedback" class="form-label">Feedback (optional)</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Create Review</button>
            <a href="{{ route('performance.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
