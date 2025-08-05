@extends('layouts.admin')

@section('title', 'Role Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Role Details</h1>
                <p class="text-muted">View role information and permissions</p>
            </div>
            <div class="d-flex gap-2">
                @if($role->name !== 'admin')
                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Role
                </a>
                @else
                <div class="alert alert-info mb-0 py-2 px-3">
                    <i class="bi bi-info-circle me-2"></i>
                    <small><strong>Admin Role:</strong> This role cannot be modified and has all permissions by default.</small>
                </div>
                @endif
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Roles
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Role Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Role Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Role Name</label>
                                    <div class="fw-medium">{{ $role->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Description</label>
                                    <div>{{ $role->description ?: 'No description provided' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Role ID</label>
                                    <div class="fw-medium">#{{ $role->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created</label>
                                    <div>{{ $role->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div>{{ $role->updated_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Permissions -->
                <div class="admin-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Assigned Permissions</h5>
                            <p class="card-description">
                                @if($role->name === 'admin')
                                    All permissions (automatic for admin role)
                                @else
                                    Permissions granted to this role
                                @endif
                            </p>
                        </div>
                        @if($role->name !== 'admin')
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline">
                            <i class="bi bi-pencil me-1"></i>
                            Edit Permissions
                        </a>
                        @else
                        <span class="badge badge-success">Auto-managed</span>
                        @endif
                    </div>
                    <div class="card-content">
                        @if($role->permissions->count() > 0)
                            @php
                                // Group permissions by module
                                $permissionModules = [
                                    'Dashboard' => ['view_dashboard'],
                                    'Categories' => ['view_categories', 'manage_categories'],
                                    'Products' => ['view_products', 'manage_products'],
                                                'Orders' => ['view_orders', 'manage_orders'],
            'Tasks' => ['view_tasks', 'manage_tasks'],
                                    'Users' => ['view_users', 'manage_users'],
                                    'Roles' => ['view_roles', 'manage_roles'],
                                    'Permissions' => ['view_permissions', 'manage_permissions'],
                                    'Settings' => ['manage_settings']
                                ];
                                
                                $moduleIcons = [
                                    'Dashboard' => 'bi-speedometer2',
                                    'Categories' => 'bi-tags',
                                    'Products' => 'bi-box',
                                                'Orders' => 'bi-receipt',
            'Tasks' => 'bi-list-task',
                                    'Users' => 'bi-people',
                                    'Roles' => 'bi-shield-check',
                                    'Permissions' => 'bi-key',
                                    'Settings' => 'bi-gear'
                                ];
                            @endphp
                            
                            <div class="permissions-by-module">
                                @foreach($permissionModules as $moduleName => $modulePermissions)
                                    @php
                                        $modulePerms = $role->permissions->whereIn('name', $modulePermissions);
                                    @endphp
                                    @if($modulePerms->count() > 0)
                                        <div class="permission-module mb-3">
                                            <div class="permission-module-header">
                                                <h6 class="mb-0">
                                                    <i class="{{ $moduleIcons[$moduleName] ?? 'bi-circle' }} me-2"></i>
                                                    {{ $moduleName }}
                                                </h6>
                                            </div>
                                            <div class="permission-module-content">
                                                <div class="row g-2">
                                                    @foreach($modulePerms as $permission)
                                                        <div class="col-md-6">
                                                            <div class="d-flex align-items-start p-2 border rounded">
                                                                <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                                                                <div>
                                                                    <div class="fw-medium small">{{ $permission->name }}</div>
                                                                    @if($permission->description)
                                                                        <div class="text-muted small">{{ $permission->description }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-key-fill text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mb-2">No Permissions Assigned</h5>
                                <p class="text-muted mb-3">This role doesn't have any permissions assigned yet.</p>
                                @if($role->name !== 'admin')
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-key me-1"></i>
                                    Assign Permissions
                                </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Users with this Role -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Users with this Role</h5>
                        <p class="card-description">All users currently assigned to this role</p>
                    </div>
                    <div class="card-content">
                        @if($role->users->count() > 0)
                            <div class="table-responsive">
                                <table class="table admin-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Joined</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($role->users as $user)
                                            <tr>
                                                <td class="fw-medium">{{ $user->name }}</td>
                                                <td class="text-muted">{{ $user->email }}</td>
                                                <td class="text-muted">{{ $user->created_at->format('M j, Y') }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $user->email_verified_at ? 'primary' : 'secondary' }}">
                                                        {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline">
                                                        <i class="bi bi-eye me-1"></i>
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-people text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mb-2">No Users Assigned</h5>
                                <p class="text-muted mb-3">No users have been assigned to this role yet.</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">
                                    <i class="bi bi-people me-1"></i>
                                    Manage Users
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-2">
                            @if($role->name !== 'admin')
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline">
                                <i class="bi bi-pencil me-2"></i>
                                Edit Role
                            </a>
                            @endif
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-outline">
                                <i class="bi bi-shield-plus me-2"></i>
                                Create New Role
                            </a>
                            @if($role->name !== 'admin')
                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-destructive w-100" 
                                        data-confirm="Are you sure you want to delete this role? This action cannot be undone and will remove the role from all users.">
                                    <i class="bi bi-trash me-2"></i>
                                    Delete Role
                                </button>
                            </form>
                            @else
                            <div class="alert alert-warning text-center py-2 mb-0">
                                <small><i class="bi bi-shield-check me-1"></i><strong>Protected Role</strong><br>
                                Admin role cannot be modified or deleted</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Role Statistics -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Role Statistics</h5>
                    </div>
                    <div class="card-content">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                                        {{ $role->permissions->count() }}
                                    </div>
                                    <div class="text-muted small">Permissions</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success" style="font-size: 1.5rem;">
                                    {{ $role->users->count() }}
                                </div>
                                <div class="text-muted small">Users</div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Created:</span>
                                <span>{{ $role->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Last Modified:</span>
                                <span>{{ $role->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
