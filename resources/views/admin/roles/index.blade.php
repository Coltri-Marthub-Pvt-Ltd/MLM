@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Roles</h1>
                <p class="text-muted">Manage user roles and their permissions</p>
            </div>
            @can('manage_roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="bi bi-shield-plus me-2"></i>
                Create New Role
            </a>
            @endcan
        </div>

        <!-- Roles Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Roles</h5>
                <p class="card-description">{{ $roles->total() }} roles found</p>
            </div>
            
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Permissions</th>
                                <th>Users</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td class="text-muted">#{{ $role->id }}</td>
                                    <td class="fw-medium">{{ $role->name }}</td>
                                    <td class="text-muted">{{ ucfirst($role->name) }} role</td>
                                    <td>
                                        @if($role->name === 'admin')
                                            <span class="badge badge-success">All permissions (automatic)</span>
                                        @elseif($role->permissions->count() > 0)
                                            <span class="badge badge-primary">{{ $role->permissions->count() }} permission(s)</span>
                                        @else
                                            <span class="text-muted">No permissions</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($role->users->count() > 0)
                                            <span class="badge badge-secondary">{{ $role->users->count() }} user(s)</span>
                                        @else
                                            <span class="text-muted">No users</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $role->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('manage_roles')
                                            @if($role->name !== 'admin')
                                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-destructive" title="Delete" 
                                                        data-confirm="Are you sure you want to delete this role?">
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
                @if($roles->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of {{ $roles->total() }} results
                            </div>
                            {{ $roles->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-shield-check text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mb-3">No Roles Found</h5>
                        <p class="text-muted mb-4">There are no roles in the system yet.</p>
                        @can('manage_roles')
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            <i class="bi bi-shield-plus me-2"></i>
                            Create First Role
                        </a>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 
