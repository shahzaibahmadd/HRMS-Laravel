@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">All Tasks</h2>
        @hasanyrole('Admin|HR|Manager')
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Assign New Task</a>
        @endhasanyrole

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Assigned By</th>
                <th>Assigned To</th>
                <th>Title</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->assignedBy->name }}</td>
                    <td>{{ $task->assignedTo->name }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->due_date ? $task->due_date->format('d M Y') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">View</a>
{{--                        @can('update', $task)--}}
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>


                        {{--                        @endcan--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
