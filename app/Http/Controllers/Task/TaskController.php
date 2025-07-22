<?php

namespace App\Http\Controllers\Task;

use App\DTOs\Task\TaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Services\ErrorLoggingService;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // 📋 List all tasks user can see
    public function index()
    {
        $user = Auth::user();

        // Admin sees all
        if ($user->hasRole('Admin')) {
            $tasks = Task::with(['assignedBy', 'assignedTo'])->latest()->get();
        }
        // HR sees tasks they created or assigned to them
        elseif ($user->hasRole('HR')) {
            $tasks = Task::with(['assignedBy', 'assignedTo'])
                ->where('assigned_by', $user->id)
                ->orWhere('assigned_to', $user->id)
                ->latest()->get();
        }
        // Manager sees their assigned and given tasks
        elseif ($user->hasRole('Manager')) {
            $tasks = Task::with(['assignedBy', 'assignedTo'])
                ->where('assigned_by', $user->id)
                ->orWhere('assigned_to', $user->id)
                ->latest()->get();
        }
        // Employee sees only tasks assigned to them
        else {
            $tasks = Task::with(['assignedBy', 'assignedTo'])
                ->where('assigned_to', $user->id)
                ->latest()->get();
        }

        return view('tasks.index', compact('tasks','user'));
    }

    // 📝 Show create form
    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $assignableUsers = User::role(['HR', 'Manager', 'Employee'])->get();
        } elseif ($user->hasRole('HR')) {
            $assignableUsers = User::role(['Manager', 'Employee'])->get();
        } elseif ($user->hasRole('Manager')) {
            $assignableUsers = User::role(['Employee'])->get();
        } else {
            abort(403, 'You are not allowed to assign tasks.');

        }

        return view('tasks.create', compact('assignableUsers'));
    }

    // 💾 Store task
    public function store(TaskRequest $request)
    {
        $dto = new TaskDTO(
            assigned_by: Auth::id(),
            assigned_to: $request->assigned_to,
            title: $request->title,
            description: $request->description,
            due_date: $request->due_date,
            status: 'pending'
        );

        $this->taskService->create($dto);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    // 📄 View task
    public function show(Task $task)
    {

        $user = Auth::user();

        return view('tasks.show', compact('task','user'));
    }

    // ✏️ Edit task form
    public function edit(Task $task)
    {
        $user = Auth::user();

        if ($user->id !== $task->assigned_by) {
            abort(403, 'You cannot edit this task.');
        }

        // Same logic to get assignable users
        if ($user->hasRole('Admin')) {
            $assignableUsers = User::role(['HR', 'Manager', 'Employee'])->get();
        } elseif ($user->hasRole('HR')) {
            $assignableUsers = User::role(['Manager', 'Employee'])->get();
        } elseif ($user->hasRole('Manager')) {
            $assignableUsers = User::role(['Employee'])->get();
        } else {
            abort(403);
        }

        return view('tasks.edit', compact('task', 'assignableUsers'));
    }

    // 🛠️ Update task
    public function update(TaskRequest $request, Task $task)
    {
        $user = Auth::user();

        // Only the assigner can update full task
        if ($user->id === $task->assigned_by || $user->hasRole('Admin')) {
            $dto = new TaskDTO(
                assigned_by: $task->assigned_by,
                assigned_to: $request->assigned_to,
                title: $request->title,
                description: $request->description,
                due_date: $request->due_date,
                status: $request->status
            );
        }
        // Assigned user can only update status
        elseif ($user->id === $task->assigned_to) {
            $dto = new TaskDTO(
                assigned_by: $task->assigned_by,
                assigned_to: $task->assigned_to,
                title: $task->title,
                description: $task->description,
                due_date: $task->due_date,
                status: $request->status
            );
        } else {
            abort(403);
        }

        $this->taskService->update($task, $dto);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // ❌ Delete task
    public function destroy(Task $task)
    {
        $user = Auth::user();
        if ($user->id !== $task->assigned_by && !($user->hasRole('Admin'))) {
            abort(403, 'Only the task assigner can delete it.');
        }

        $this->taskService->delete($task);

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
    public function markAsCompleted($id)
    {
        try {
            $task = Task::findOrFail($id);

            if (auth()->id() !== $task->assigned_to) {
                return redirect()->back()->with('error', 'You are not authorized to update this task.');
            }

            $task->status = 'completed';
            $task->save();

            return redirect()->route('tasks.show', $task->id)->with('success', 'Task marked as completed.');
        } catch (\Exception $e) {
            ErrorLoggingService::log($e); // Assuming you use a central error logging service
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }



}
