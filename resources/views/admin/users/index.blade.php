@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Users</h1>
                <p class="text-muted">Manage system users and their permissions</p>
            </div>
            @can('manage_users')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i>
                Add New User
            </a>
            @endcan
        </div>

        <!-- Filters -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="search" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search by name or email..."
                        >
                    </div>

                    <!-- Role Filter -->
                    <div class="col-md-2">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">From Date</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="date_from" 
                            name="date_from" 
                            value="{{ request('date_from') }}"
                        >
                    </div>

                    <!-- Date To -->
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">To Date</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="date_to" 
                            name="date_to" 
                            value="{{ request('date_to') }}"
                        >
                    </div>

                    <!-- Filter Actions -->
                    <div class="col-md-1 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request()->hasAny(['search', 'role', 'status', 'date_from', 'date_to']))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm" title="Clear Filters">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Users</h5>
                <p class="card-description">
                    @if(request()->hasAny(['search', 'role', 'status', 'date_from', 'date_to']))
                        {{ $users->total() }} users found with current filters
                        <a href="{{ route('admin.users.index') }}" class="text-decoration-none ms-2">
                            <i class="bi bi-x-circle"></i> Clear filters
                        </a>
                    @else
                        {{ $users->total() }} users found
                    @endif
                </p>
            </div>
            
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Joined</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="text-muted">#{{ $user->id }}</td>
                                    <td class="fw-medium">{{ $user->name }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td>
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-secondary me-1">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No roles assigned</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $user->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->email_verified_at ? 'primary' : 'secondary' }}">
                                            {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('manage_users')
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($user->id === 1)
                                                {{-- No additional button for superadmin --}}
                                            @elseif($user->hasRole('admin'))
                                                <button type="button" class="btn btn-sm btn-outline" disabled title="Admin User - Protected">
                                                    <i class="bi bi-shield-check"></i>
                                                </button>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-destructive" title="Delete" 
                                                            data-confirm="Are you sure you want to delete this user?">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                            </div>
                            {{ $users->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-people text-muted mb-3" style="font-size: 4rem;"></i>
                        @if(request()->hasAny(['search', 'role', 'status', 'date_from', 'date_to']))
                            <h5 class="text-muted mb-3">No Users Found</h5>
                            <p class="text-muted mb-4">No users match your current filters. Try adjusting your search criteria.</p>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                                <i class="bi bi-x-circle me-2"></i>
                                Clear All Filters
                            </a>
                        @else
                            <h5 class="text-muted mb-3">No Users Found</h5>
                            <p class="text-muted mb-4">There are no users in the system yet.</p>
                            @can('manage_users')
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus me-2"></i>
                                Add First User
                            </a>
                            @endcan
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 
