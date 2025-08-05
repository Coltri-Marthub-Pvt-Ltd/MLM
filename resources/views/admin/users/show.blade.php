@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">User Details</h1>
                <p class="text-muted">View user information and permissions</p>
            </div>
            <div class="d-flex gap-2">
                @can('manage_users')
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Edit User
                </a>
                @endcan
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Users
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- User Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">User Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Full Name</label>
                                    <div class="fw-medium">{{ $user->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Email Address</label>
                                    <div>{{ $user->email }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Email Status</label>
                                    <div>
                                        <span class="badge badge-{{ $user->email_verified_at ? 'primary' : 'secondary' }}">
                                            {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                        </span>
                                        @if($user->email_verified_at)
                                            <small class="text-muted ms-2">
                                                Verified {{ $user->email_verified_at->diffForHumans() }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">User ID</label>
                                    <div class="fw-medium">#{{ $user->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Member Since</label>
                                    <div>{{ $user->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div>{{ $user->updated_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Roles -->
                <div class="admin-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Assigned Roles</h5>
                            <p class="card-description">Roles determine what the user can access</p>
                        </div>
                        @can('manage_users')
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline">
                            <i class="bi bi-pencil me-1"></i>
                            Edit Roles
                        </a>
                        @endcan
                    </div>
                    <div class="card-content">
                        @if($user->roles->count() > 0)
                            <div class="row g-3">
                                @foreach($user->roles as $role)
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-shield-check text-primary me-2"></i>
                                                <h6 class="mb-0">{{ $role->name }}</h6>
                                            </div>
                                            @if($role->description)
                                                <p class="text-muted small mb-2">{{ $role->description }}</p>
                                            @endif
                                            <div class="text-muted small">
                                                {{ $role->permissions->count() }} permission(s)
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-shield-slash text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mb-2">No Roles Assigned</h5>
                                <p class="text-muted mb-3">This user doesn't have any roles assigned yet.</p>
                                @can('manage_users')
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-shield-plus me-1"></i>
                                    Assign Roles
                                </a>
                                @endcan
                            </div>
                        @endif
                    </div>
                </div>

                <!-- User Permissions -->
                @if($user->roles->count() > 0)
                    <div class="admin-card">
                        <div class="card-header">
                            <h5 class="card-title">Effective Permissions</h5>
                            <p class="card-description">All permissions granted through assigned roles</p>
                        </div>
                        <div class="card-content">
                            @php
                                $allPermissions = $user->roles->flatMap->permissions->unique('id');
                            @endphp
                            
                            @if($allPermissions->count() > 0)
                                <div class="row g-2">
                                    @foreach($allPermissions as $permission)
                                        <div class="col-auto">
                                            <span class="badge badge-muted">
                                                <i class="bi bi-key me-1"></i>
                                                {{ $permission->name }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="bi bi-key text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-0">No permissions granted</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-2">
                            @can('manage_users')
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline">
                                <i class="bi bi-pencil me-2"></i>
                                Edit User
                            </a>
                            @if(!$user->email_verified_at)
                                <button type="button" class="btn btn-outline" disabled>
                                    <i class="bi bi-envelope-check me-2"></i>
                                    Send Verification Email
                                </button>
                            @endif
                            @if($user->id === 1)
                                <div class="alert alert-info">
                                    <i class="bi bi-shield-fill me-2"></i>
                                    <strong>Superadmin Protection:</strong> This user has the highest level of protection and cannot be deleted or modified.
                                </div>
                            @elseif($user->hasRole('admin'))
                                <div class="alert alert-warning">
                                    <i class="bi bi-shield-check me-2"></i>
                                    <strong>Admin Protection:</strong> This user has admin privileges and cannot be deleted for security reasons.
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-destructive w-100" 
                                            data-confirm="Are you sure you want to delete this user? This action cannot be undone.">
                                        <i class="bi bi-trash me-2"></i>
                                        Delete User
                                    </button>
                                </form>
                            @endif
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- User Statistics -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">User Statistics</h5>
                    </div>
                    <div class="card-content">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                                        {{ $user->roles->count() }}
                                    </div>
                                    <div class="text-muted small">Roles</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success" style="font-size: 1.5rem;">
                                    {{ $user->roles->flatMap->permissions->unique('id')->count() }}
                                </div>
                                <div class="text-muted small">Permissions</div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Account Age:</span>
                                <span>{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Last Modified:</span>
                                <span>{{ $user->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
