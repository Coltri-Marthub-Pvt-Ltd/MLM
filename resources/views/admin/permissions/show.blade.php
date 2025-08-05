@extends('layouts.admin')

@section('title', 'Permission Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Permission Details</h1>
                <p class="text-muted">View permission information and assignments</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Permissions
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Permission Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Permission Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Permission Name</label>
                                    <div class="fw-medium">
                                        <i class="bi bi-key text-primary me-2"></i>
                                        {{ $permission->name }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Description</label>
                                    <div>{{ $permission->description ?: 'No description provided' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Permission ID</label>
                                    <div class="fw-medium">#{{ $permission->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created</label>
                                    <div>{{ $permission->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div>{{ $permission->updated_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Roles -->
                <div class="admin-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Assigned to Roles</h5>
                            <p class="card-description">Roles that have this permission</p>
                        </div>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline">
                            <i class="bi bi-shield me-1"></i>
                            Manage Roles
                        </a>
                    </div>
                    <div class="card-content">
                        @if($permission->roles->count() > 0)
                            <div class="row g-3">
                                @foreach($permission->roles as $role)
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <i class="bi bi-shield text-success me-2"></i>
                                                        {{ $role->name }}
                                                    </h6>
                                                    @if($role->description)
                                                        <p class="text-muted small mb-2">{{ $role->description }}</p>
                                                    @endif
                                                    <div class="small text-muted">
                                                        {{ $role->users->count() }} user(s) with this role
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-outline">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-shield-exclamation text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mb-2">No Roles Assigned</h5>
                                <p class="text-muted mb-3">This permission is not assigned to any roles yet.</p>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-shield me-1"></i>
                                    Assign to Role
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Users with this Permission (through roles) -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Users with this Permission</h5>
                        <p class="card-description">Users who have this permission through their roles</p>
                    </div>
                    <div class="card-content">
                        @php
                            $usersWithPermission = collect();
                            foreach($permission->roles as $role) {
                                $usersWithPermission = $usersWithPermission->merge($role->users);
                            }
                            $usersWithPermission = $usersWithPermission->unique('id');
                        @endphp

                        @if($usersWithPermission->count() > 0)
                            <div class="table-responsive">
                                <table class="table admin-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Via Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usersWithPermission as $user)
                                            <tr>
                                                <td class="fw-medium">{{ $user->name }}</td>
                                                <td class="text-muted">{{ $user->email }}</td>
                                                <td>
                                                    @foreach($user->roles->intersect($permission->roles) as $role)
                                                        <span class="badge badge-secondary me-1">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>
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
                                <h5 class="text-muted mb-2">No Users Have This Permission</h5>
                                <p class="text-muted mb-3">No users currently have this permission through any role.</p>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline btn-sm">
                                    <i class="bi bi-shield me-1"></i>
                                    Assign to Roles
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
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-outline">
                                <i class="bi bi-key-fill me-2"></i>
                                Create New Permission
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Permission Statistics -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Usage Statistics</h5>
                    </div>
                    <div class="card-content">
                        @php
                            $totalUsers = $usersWithPermission->count();
                        @endphp
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                                        {{ $permission->roles->count() }}
                                    </div>
                                    <div class="text-muted small">Roles</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success" style="font-size: 1.5rem;">
                                    {{ $totalUsers }}
                                </div>
                                <div class="text-muted small">Users</div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Created:</span>
                                <span>{{ $permission->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Last Modified:</span>
                                <span>{{ $permission->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($permission->roles->count() > 0)
                    <div class="admin-card mt-4">
                        <div class="card-header">
                            <h5 class="card-title">Role Distribution</h5>
                        </div>
                        <div class="card-content">
                            @foreach($permission->roles as $role)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small">{{ $role->name }}</span>
                                    <span class="badge badge-secondary">{{ $role->users->count() }} users</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 
