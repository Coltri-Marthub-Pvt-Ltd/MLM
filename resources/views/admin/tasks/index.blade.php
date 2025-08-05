@extends('layouts.admin')

@section('title', 'Tasks')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Tasks</h1>
                <p class="text-muted">
                    @if(Auth::user()->hasRole('admin'))
                        Manage and assign tasks to users
                    @else
                        View and update your assigned tasks
                    @endif
                </p>
            </div>
            @can('manage_tasks')
            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Create New Task
            </a>
            @endcan
        </div>

        <!-- Search and Filters -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="{{ route('admin.tasks.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search" class="form-label">Search</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="search" 
                                    name="search" 
                                    placeholder="Search tasks, descriptions, or users..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                </select>
                            </div>
                        </div>
                        @if(Auth::user()->hasRole('admin') && $users->count() > 0)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="user" class="form-label">Assigned To</label>
                                <select class="form-select" id="user" name="user">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-2">
                            <label for="due_date_from" class="form-label">Due Date From</label>
                            <input type="date" class="form-control" id="due_date_from" name="due_date_from" 
                                   value="{{ request('due_date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="due_date_to" class="form-label">Due Date To</label>
                            <input type="date" class="form-control" id="due_date_to" name="due_date_to" 
                                   value="{{ request('due_date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if(request()->hasAny(['search', 'status', 'user', 'due_date_from', 'due_date_to']))
                        <div class="mt-3">
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-outline">
                                <i class="bi bi-x-circle me-1"></i>
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    @if(request()->hasAny(['search', 'status', 'user', 'due_date_from', 'due_date_to']))
                        Filtered Results
                    @else
                        All Tasks
                    @endif
                </h5>
                <p class="card-description">{{ $tasks->total() }} task{{ $tasks->total() != 1 ? 's' : '' }} found</p>
            </div>
            
            @if($tasks->count() > 0)
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr class="{{ $task->is_overdue ? 'table-warning' : '' }}">
                                    <td>
                                        <div class="fw-medium">{{ $task->title }}</div>
                                        @if($task->description)
                                            <div class="text-muted small">{{ Str::limit($task->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->assignedTo)
                                            <div class="fw-medium">{{ $task->assignedTo->name }}</div>
                                            <div class="text-muted small">{{ $task->assignedTo->email }}</div>
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->assignedBy)
                                            <div class="text-muted small">{{ $task->assignedBy->name }}</div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->due_date)
                                            <div class="{{ $task->is_overdue ? 'text-danger fw-medium' : 'text-muted' }}">
                                                {{ $task->due_date->format('M j, Y') }}
                                            </div>
                                            @if($task->is_overdue)
                                                <span class="badge badge-danger badge-sm">Overdue</span>
                                            @endif
                                        @else
                                            <span class="text-muted">No due date</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $task->status_color }}">
                                            {{ $task->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('manage_tasks')
                                            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-outline" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @endcan
                                            @if(!$task->completed)
                                                <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Mark as Completed">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning" title="Mark as Pending">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @can('manage_tasks')
                                            <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-destructive" title="Delete" 
                                                        data-confirm="Are you sure you want to delete this task?">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($tasks->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
                            </div>
                            {{ $tasks->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-list-task text-muted mb-3" style="font-size: 4rem;"></i>
                        @if(request()->hasAny(['search', 'status', 'user', 'due_date_from', 'due_date_to']))
                            <h5 class="text-muted mb-3">No Tasks Found</h5>
                            <p class="text-muted mb-4">No tasks match your current filters.</p>
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline">
                                <i class="bi bi-arrow-left me-2"></i>
                                View All Tasks
                            </a>
                        @else
                            <h5 class="text-muted mb-3">No Tasks Found</h5>
                            <p class="text-muted mb-4">There are no tasks in the system yet.</p>
                            @can('manage_tasks')
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>
                                Create First Task
                            </a>
                            @endcan
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 