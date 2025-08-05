@extends('layouts.admin')

@section('title', 'Permissions')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Permissions</h1>
                <p class="text-muted">Manage system permissions</p>
            </div>
            @can('manage_permissions')
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                <i class="bi bi-key me-2"></i>
                Add New Permission
            </a>
            @endcan
        </div>

        <!-- Search Filter -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="{{ route('admin.permissions.index') }}">
                    <div class="row g-3">
                        <div class="col-md-10">
                            <label for="search" class="form-label">Search Permissions</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search by permission name...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline">
                                    <i class="bi bi-search me-2"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                    @if(request('search'))
                        <div class="mt-3">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-outline">
                                <i class="bi bi-x-circle me-1"></i>
                                Clear Search
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Permissions Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    @if(request('search'))
                        Search Results for "{{ request('search') }}"
                    @else
                        All Permissions
                    @endif
                </h5>
                <p class="card-description">
                    {{ $permissions->total() }} permission{{ $permissions->total() != 1 ? 's' : '' }} found
                    @if(request('search'))
                        matching "{{ request('search') }}"
                    @endif
                </p>
            </div>
            
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Roles</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td class="text-muted">#{{ $permission->id }}</td>
                                    <td class="fw-medium">{{ $permission->name }}</td>
                                    <td class="text-muted">{{ $permission->description ?: 'No description' }}</td>
                                    <td>
                                        @if($permission->roles->count() > 0)
                                            <span class="badge badge-primary">{{ $permission->roles->count() }} role(s)</span>
                                        @else
                                            <span class="text-muted">No roles</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $permission->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.permissions.show', $permission) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($permissions->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $permissions->firstItem() }} to {{ $permissions->lastItem() }} of {{ $permissions->total() }} results
                            </div>
                            {{ $permissions->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-key text-muted mb-3" style="font-size: 4rem;"></i>
                        @if(request('search'))
                            <h5 class="text-muted mb-3">No Permissions Found</h5>
                            <p class="text-muted mb-4">No permissions match your search criteria "{{ request('search') }}".</p>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline">
                                <i class="bi bi-arrow-left me-2"></i>
                                View All Permissions
                            </a>
                        @else
                            <h5 class="text-muted mb-3">No Permissions Found</h5>
                            <p class="text-muted mb-4">There are no permissions in the system yet.</p>
                            @can('manage_permissions')
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                                <i class="bi bi-key me-2"></i>
                                Add First Permission
                            </a>
                            @endcan
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 
