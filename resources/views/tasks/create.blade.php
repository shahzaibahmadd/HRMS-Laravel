@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Assign Task</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="assigned_to">Assign To:</label>
                <select name="assigned_to" id="assigned_to" class="form-control" required>
                    @foreach($assignableUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->getRoleNames()->first() }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Assign Task</button>
        </form>
    </div>
@endsection
