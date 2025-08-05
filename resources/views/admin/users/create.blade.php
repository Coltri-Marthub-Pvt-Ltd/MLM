@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create User</h1>
                <p class="text-muted">Add a new user to the system</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Users
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">User Information</h5>
                        <p class="card-description">Enter the basic information for the new user</p>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.users.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
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
                                    value="{{ old('email') }}" 
                                    placeholder="Enter user's email address"
                                    autocomplete="off"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Enter a secure password"
                                    autocomplete="new-password"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="Confirm the password"
                                    autocomplete="new-password"
                                >
                            </div>

                            @if($roles->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label">Assign Role</label>
                                    <div class="border rounded p-3">
                                        <div class="form-check mb-2">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="role" 
                                                value="" 
                                                id="role_none"
                                                {{ !old('role') ? 'checked' : '' }}
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
                                                    {{ old('role') == $role->id ? 'checked' : '' }}
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
                                    <i class="bi bi-person-plus me-2"></i>
                                    Create User
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
                        <h5 class="card-title">Guidelines</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <h6 class="mb-2">Password Requirements:</h6>
                            <ul class="mb-3">
                                <li>Minimum 8 characters</li>
                                <li>Must be confirmed</li>
                                <li>Use strong passwords</li>
                            </ul>

                            <h6 class="mb-2">Role Assignment:</h6>
                            <ul class="mb-0">
                                <li>Users can have only one role</li>
                                <li>Roles can be changed later</li>
                                <li>Some roles may grant admin access</li>
                                <li>Select "No Role" for basic users</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
