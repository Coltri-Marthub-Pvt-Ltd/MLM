@extends('layouts.admin')

@section('title', 'Create Role')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create Role</h1>
                <p class="text-muted">Add a new role to the system</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Roles
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Role Information</h5>
                        <p class="card-description">Enter the basic information for the new role</p>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.roles.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    placeholder="Enter role name (e.g., admin, editor, viewer)"
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
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($permissions->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label">Assign Permissions</label>
                                    
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
                                                    <div class="permission-module-content border rounded p-3">
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
                                                                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                                        >
                                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
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
                                    <i class="bi bi-shield-plus me-2"></i>
                                    Create Role
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
                        <h5 class="card-title">Guidelines</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <h6 class="mb-2">Role Naming:</h6>
                            <ul class="mb-3">
                                <li>Use lowercase names</li>
                                <li>Use descriptive names</li>
                                <li>Avoid spaces (use underscores)</li>
                                <li>Examples: admin, editor, viewer</li>
                            </ul>

                            <h6 class="mb-2">Permission Assignment:</h6>
                            <ul class="mb-0">
                                <li>Only assign necessary permissions</li>
                                <li>Admin roles should have all permissions</li>
                                <li>Regular users need limited access</li>
                                <li>Permissions can be changed later</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
