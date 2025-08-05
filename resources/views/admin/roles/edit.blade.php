@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Edit Role</h1>
                <p class="text-muted">Update role information and permissions</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-outline">
                    <i class="bi bi-eye me-2"></i>
                    View Role
                </a>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Roles
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Role Information</h5>
                        <p class="card-description">Update the role's basic information</p>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $role->name) }}" 
                                    
                                    placeholder="Enter role name"
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="3"
                                    placeholder="Describe what this role is for..."
                                >{{ old('description', $role->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($permissions->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label">Assign Permissions</label>
                                    @if($role->name === 'admin')
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Admin Role:</strong> This role automatically has all permissions. Permission selection is disabled for admin role.
                                        </div>
                                    @endif
                                    
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
                                                $modulePerms = $permissions->whereIn('name', $modulePermissions);
                                            @endphp
                                            @if($modulePerms->count() > 0)
                                                <div class="permission-module mb-4">
                                                    <div class="permission-module-header">
                                                        <h6 class="mb-3">
                                                            <i class="{{ $moduleIcons[$moduleName] ?? 'bi-circle' }} me-2"></i>
                                                            {{ $moduleName }}
                                                        </h6>
                                                    </div>
                                                    <div class="permission-module-content border rounded p-3 {{ $role->name === 'admin' ? 'bg-light' : '' }}">
                                        <div class="row g-3">
                                                            @foreach($modulePerms as $permission)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="checkbox" 
                                                            name="permissions[]" 
                                                            value="{{ $permission->id }}" 
                                                            id="permission_{{ $permission->id }}"
                                                            {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}
                                                                            {{ $role->name === 'admin' ? 'checked disabled' : '' }}
                                                        >
                                                                        <label class="form-check-label {{ $role->name === 'admin' ? 'text-muted' : '' }}" for="permission_{{ $permission->id }}">
                                                            <strong>{{ $permission->name }}</strong>
                                                            @if($permission->description)
                                                                <br><small class="text-muted">{{ $permission->description }}</small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    
                                    @error('permissions')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Update Role
                                </button>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Role Details</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Role ID:</span>
                                <span>#{{ $role->id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Created:</span>
                                <span>{{ $role->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Last Updated:</span>
                                <span>{{ $role->updated_at->format('M j, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Users Assigned:</span>
                                <span class="badge badge-secondary">{{ $role->users->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Guidelines</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <h6 class="mb-2">Permission Changes:</h6>
                            <ul class="mb-3">
                                <li>Changes apply to all users with this role</li>
                                <li>Users may need to log in again</li>
                                <li>Be careful with admin permissions</li>
                            </ul>

                            <h6 class="mb-2">Role Usage:</h6>
                            <ul class="mb-0">
                                <li>{{ $role->users->count() }} user(s) currently have this role</li>
                                <li>{{ $role->permissions->count() }} permission(s) assigned</li>
                                <li>Changes take effect immediately</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
