@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Task Details</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>Title:</strong> {{ $task->title }}</p>
                <p><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
                <p><strong>Due Date:</strong> {{ $task->due_date ? $task->due_date->format('d M Y') : 'N/A' }}</p>
                <p><strong>Assigned By:</strong> {{ $task->assignedBy->name }}</p>
                <p><strong>Assigned To:</strong> {{ $task->assignedTo->name }}</p>

                <div class="mt-3">
                    @if (auth()->id() === $task->assigned_to && $task->status !== 'completed')
                        <form action="{{ route('tasks.markAsCompleted', $task->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success mt-3">Mark as Completed</button>
                        </form>
                    @endif


                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary mt-2">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
