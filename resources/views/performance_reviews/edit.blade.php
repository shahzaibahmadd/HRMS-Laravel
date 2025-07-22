@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Performance Review</h2>

        <form method="POST" action="{{ route('performance.update', $performanceReview->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Employee</label>
                <input type="text" class="form-control" value="{{ $performanceReview->user->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="review_date" class="form-label">Review Date</label>
                <input type="date" name="review_date" id="review_date" class="form-control" value="{{ $performanceReview->review_date->format('Y-m-d') }}" required>
            </div>

            <div class="mb-3">
                <label for="feedback" class="form-label">Feedback</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="3">{{ $performanceReview->feedback }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Review</button>
            <a href="{{ route('performance_reviews.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
