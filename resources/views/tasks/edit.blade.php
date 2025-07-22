@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Task / Update Status</h2>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')


                <div class="mb-3">
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                </div>

                <div class="mb-3">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" rows="4">{{ $task->description }}</textarea>
                </div>
            <div class="mb-3">
                <label for="assigned_to">Assign To:</label>
                <select name="assigned_to" class="form-control" required>
                    @foreach ($assignableUsers as $user)
                        <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->getRoleNames()->first() }})
                        </option>
                    @endforeach
                </select>
            </div>

                <div class="mb-3">
                    <label for="due_date">Due Date:</label>
                    <input type="date" name="due_date" class="form-control" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                </div>

            <div class="mb-3">
                <label for="status">Status:</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
@endsection
