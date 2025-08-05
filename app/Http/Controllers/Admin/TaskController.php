<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignedTo', 'assignedBy']);

        // Role-based filtering: non-admin users can only see their own assigned tasks
        if (!Auth::user()->hasRole('admin')) {
            $query->where('assigned_to', Auth::id());
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('assignedTo', function ($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->where('completed', true);
            } elseif ($request->status === 'pending') {
                $query->where('completed', false);
            } elseif ($request->status === 'overdue') {
                $query->where('due_date', '<', now())
                      ->where('completed', false);
            }
        }

        // User filter (only for admin users)
        if ($request->filled('user') && Auth::user()->hasRole('admin')) {
            $query->where('assigned_to', $request->user);
        }

        // Date range filter
        if ($request->filled('due_date_from')) {
            $query->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->filled('due_date_to')) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Preserve query parameters in pagination
        $tasks->appends($request->query());

        // Get users for filter dropdown (only for admin)
        $users = Auth::user()->hasRole('admin') ? User::orderBy('name')->get() : collect();

        return view('admin.tasks.index', compact('tasks', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only admin users can create tasks
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'You do not have permission to create tasks.');
        }

        $users = User::orderBy('name')->get();
        return view('admin.tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admin users can create tasks
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'You do not have permission to create tasks.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        $data = $request->all();
        $data['assigned_by'] = Auth::id();
        $data['completed'] = false;

        Task::create($data);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Non-admin users can only view their own assigned tasks
        if (!Auth::user()->hasRole('admin') && $task->assigned_to !== Auth::id()) {
            abort(403, 'You do not have permission to view this task.');
        }

        $task->load(['assignedTo', 'assignedBy']);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // Only admin users can edit tasks
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'You do not have permission to edit tasks.');
        }

        $users = User::orderBy('name')->get();
        return view('admin.tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Only admin users can update tasks
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'You do not have permission to update tasks.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'completed' => 'boolean',
        ]);

        $data = $request->all();
        
        // Handle completed status
        if ($request->has('completed')) {
            $data['completed'] = $request->boolean('completed');
        }

        $task->update($data);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Only admin users can delete tasks
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'You do not have permission to delete tasks.');
        }

        $task->delete();
        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Task $task)
    {
        // Admin users can toggle any task status
        // Non-admin users can only toggle their own assigned tasks
        if (!Auth::user()->hasRole('admin') && $task->assigned_to !== Auth::id()) {
            abort(403, 'You do not have permission to update this task status.');
        }

        $task->update([
            'completed' => !$task->completed
        ]);

        $status = $task->completed ? 'completed' : 'pending';
        
        return redirect()->back()
            ->with('success', "Task marked as {$status}.");
    }
}
