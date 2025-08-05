@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Edit User</h1>
                <p class="text-muted">Update user information and permissions</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline">
                    <i class="bi bi-eye me-2"></i>
                    View User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Users
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">User Information</h5>
                        <p class="card-description">Update the user's basic information</p>
                    </div>
                    <div class="card-content">
                        @if($user->id === 1)
                            <div class="alert alert-info mb-4">
                                <i class="bi bi-shield-fill me-2"></i>
                                <strong>Superadmin Notice:</strong> You are editing the superadmin user. This user has the highest level of protection and full system access.
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}" 
                                    placeholder="Enter user's full name"
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}" 
                                    placeholder="Enter user's email address"
                                    autocomplete="off"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Leave blank to keep current password"
                                    autocomplete="new-password"
                                >
                                <div class="form-text">Leave blank to keep the current password</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="Confirm the new password"
                                    autocomplete="new-password"
                                >
                            </div>

                            @if($roles->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label">Assign Role</label>
                                    <div class="border rounded p-3">
                                        @php
                                            $currentRoleId = old('role', $user->roles->first()?->id);
                                        @endphp
                                        <div class="form-check mb-2">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="role" 
                                                value="" 
                                                id="role_none"
                                                {{ !$currentRoleId ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="role_none">
                                                <strong>No Role</strong>
                                                <br><small class="text-muted">User will have no specific role assigned</small>
                                            </label>
                                        </div>
                                        @foreach($roles as $role)
                                            <div class="form-check mb-2">
                                                <input 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    name="role" 
                                                    value="{{ $role->id }}" 
                                                    id="role_{{ $role->id }}"
                                                    {{ $currentRoleId == $role->id ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    <strong>{{ $role->name }}</strong>
                                                    @if($role->description)
                                                        <br><small class="text-muted">{{ $role->description }}</small>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('role')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Update User
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">User Details</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">User ID:</span>
                                <span>#{{ $user->id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Created:</span>
                                <span>{{ $user->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Last Updated:</span>
                                <span>{{ $user->updated_at->format('M j, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Email Status:</span>
                                <span class="badge badge-{{ $user->email_verified_at ? 'primary' : 'secondary' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                </span>
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
                            <h6 class="mb-2">Password Update:</h6>
                            <ul class="mb-3">
                                <li>Leave blank to keep current password</li>
                                <li>Minimum 8 characters if changing</li>
                                <li>Must confirm new password</li>
                            </ul>

                            <h6 class="mb-2">Role Management:</h6>
                            <ul class="mb-0">
                                <li>Users can have only one role</li>
                                <li>Changes take effect immediately</li>
                                <li>User may need to log in again</li>
                                <li>Admin roles grant full access</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
