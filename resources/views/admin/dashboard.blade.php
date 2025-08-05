@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Dashboard</h1>
                <p class="text-muted">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <div class="text-muted">
                <i class="bi bi-calendar me-2"></i>
                {{ now()->format('F j, Y') }}
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-4">
                <div class="admin-card stats-card stats-card-primary">
                    <div class="card-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-number">{{ $stats['total_users'] }}</div>
                                <div class="stats-label">Total Users</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="admin-card stats-card stats-card-success">
                    <div class="card-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-number">{{ $stats['total_roles'] }}</div>
                                <div class="stats-label">Total Roles</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="admin-card stats-card stats-card-info">
                    <div class="card-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-number">{{ $stats['total_permissions'] }}</div>
                                <div class="stats-label">Total Permissions</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-key"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="admin-card stats-card stats-card-warning">
                    <div class="card-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-number">{{ $stats['total_categories'] }}</div>
                                <div class="stats-label">Categories</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-tags"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="admin-card stats-card stats-card-purple">
                    <div class="card-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-number">{{ $stats['total_products'] }}</div>
                                <div class="stats-label">Products</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-box"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="admin-card stats-card stats-card-info">
                    <div class="card-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-number">{{ now()->format('H:i') }}</div>
                                <div class="stats-label">Current Time</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Recent Users</h5>
                        <p class="card-description">Latest registered users</p>
                    </div>
                    <div class="card-content">
                        @if($stats['recent_users']->count() > 0)
                            <div class="table-responsive">
                                <table class="table admin-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Joined</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stats['recent_users'] as $user)
                                            <tr>
                                                <td class="fw-medium">{{ $user->name }}</td>
                                                <td class="text-muted">{{ $user->email }}</td>
                                                <td class="text-muted">{{ $user->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $user->email_verified_at ? 'primary' : 'secondary' }}">
                                                        {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-people text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="text-muted mb-0">No users found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                        <p class="card-description">Common admin tasks</p>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-3">
                            @can('manage_users')
                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline">
                                <i class="bi bi-person-plus me-2"></i>
                                Add New User
                            </a>
                            @endcan
                            
                            @can('view_users')
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                                <i class="bi bi-list-ul me-2"></i>
                                View All Users
                            </a>
                            @endcan
                            
                            @can('manage_roles')
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-outline">
                                <i class="bi bi-shield-plus me-2"></i>
                                Create Role
                            </a>
                            @endcan
                            
                            @can('view_roles')
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline">
                                <i class="bi bi-shield-check me-2"></i>
                                View All Roles
                            </a>
                            @endcan
                            
                            @can('manage_permissions')
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-outline">
                                <i class="bi bi-key me-2"></i>
                                Add Permission
                            </a>
                            @endcan
                            
                            @can('view_permissions')
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline">
                                <i class="bi bi-key-fill me-2"></i>
                                View All Permissions
                            </a>
                            @endcan

                            @can('manage_categories')
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline">
                                <i class="bi bi-tag me-2"></i>
                                Add Category
                            </a>
                            @endcan

                            @can('manage_products')
                            <a href="{{ route('admin.products.create') }}" class="btn btn-outline">
                                <i class="bi bi-plus-square me-2"></i>
                                Add Product
                            </a>
                            @endcan

                            @can('manage_settings')
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline">
                                <i class="bi bi-gear me-2"></i>
                                Settings
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">System Info</h5>
                        <p class="card-description">Server and application details</p>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Laravel Version:</span>
                                <span>{{ app()->version() }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">PHP Version:</span>
                                <span>{{ PHP_VERSION }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Environment:</span>
                                <span class="badge badge-{{ app()->environment() === 'production' ? 'primary' : 'warning' }}">
                                    {{ ucfirst(app()->environment()) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Debug Mode:</span>
                                <span class="badge badge-{{ config('app.debug') ? 'warning' : 'primary' }}">
                                    {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
