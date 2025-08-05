@extends('layouts.admin')

@section('title', 'Task Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Task Details</h1>
                <p class="text-muted">View task information and status</p>
            </div>
            <div class="d-flex gap-2">
                @can('manage_tasks')
                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Task
                </a>
                @endcan
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Tasks
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Information -->
            <div class="col-lg-8">
                <!-- Task Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">{{ $task->title }}</h5>
                        <div class="d-flex gap-2">
                            <span class="badge badge-{{ $task->status_color }}">
                                {{ $task->status_text }}
                            </span>
                            @if($task->is_overdue)
                                <span class="badge badge-danger">Overdue</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-content">
                        @if($task->description)
                            <div class="mb-3">
                                <label class="form-label text-muted">Description</label>
                                <div class="whitespace-pre-wrap">{{ $task->description }}</div>
                            </div>
                        @endif

                        <div class="row">
                            @if($task->due_date)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Due Date</label>
                                    <div class="{{ $task->is_overdue ? 'text-danger fw-medium' : '' }}">
                                        {{ $task->due_date->format('M j, Y') }}
                                        @if($task->is_overdue)
                                            <small class="text-danger">({{ $task->due_date->diffForHumans() }})</small>
                                        @else
                                            <small class="text-muted">({{ $task->due_date->diffForHumans() }})</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($task->completed_at)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Completed At</label>
                                    <div>
                                        {{ $task->completed_at->format('M j, Y g:i A') }}
                                        <small class="text-muted">({{ $task->completed_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Assignment Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Assignment Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Assigned To</label>
                                    @if($task->assignedTo)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-fill text-muted"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $task->assignedTo->name }}</div>
                                                <div class="text-muted small">{{ $task->assignedTo->email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">No user assigned</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Assigned By</label>
                                    @if($task->assignedBy)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-check-fill text-muted"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $task->assignedBy->name }}</div>
                                                <div class="text-muted small">{{ $task->assignedBy->email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Unknown</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                @can('manage_tasks')
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>
                                Edit Task
                            </a>
                            @if(!$task->completed)
                                <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Mark as Completed
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100">
                                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                                        Mark as Pending
                                    </button>
                                </form>
                            @endif
                            @if($task->assignedTo)
                                <a href="{{ route('admin.users.show', $task->assignedTo) }}" class="btn btn-outline">
                                    <i class="bi bi-person me-2"></i>
                                    View User
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <!-- Quick Actions for Regular Users -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Task Actions</h5>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-2">
                            @if(!$task->completed)
                                <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Mark as Completed
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100">
                                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                                        Mark as Pending
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endcan

                <!-- Task Summary -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Task Summary</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status:</span>
                                <span class="badge badge-{{ $task->status_color }}">
                                    {{ $task->status_text }}
                                </span>
                            </div>
                            @if($task->due_date)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Due Date:</span>
                                <span class="{{ $task->is_overdue ? 'text-danger' : '' }}">
                                    {{ $task->due_date->format('M j, Y') }}
                                </span>
                            </div>
                            @endif
                            @if($task->assignedTo)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Assigned To:</span>
                                <span>{{ $task->assignedTo->name }}</span>
                            </div>
                            @endif
                            @if($task->assignedBy)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Created By:</span>
                                <span>{{ $task->assignedBy->name }}</span>
                            </div>
                            @endif
                            @if($task->completed_at)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Completed:</span>
                                <span>{{ $task->completed_at->format('M j') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Record Information -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Record Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Created:</span>
                                <span>{{ $task->created_at->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Last Updated:</span>
                                <span>{{ $task->updated_at->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Task ID:</span>
                                <span class="fw-medium">{{ $task->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 