@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="fade-in">
        <!-- Modern Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gradient">Dashboard Overview</h1>
                <p class="text-muted mb-0">Welcome back, <span class="fw-medium">{{ Auth::user()->name }}</span>! Here's what's happening today.</p>
            </div>
            <div class="date-badge bg-light rounded-pill px-3 py-2 d-none d-md-flex align-items-center">
                <i class="bi bi-calendar3 me-2 text-primary"></i>
                <span class="fw-medium">{{ now()->format('l, F j, Y') }}</span>
            </div>
        </div>
        
        @if(Auth::check() && Auth::user()->id == 1)
       <!-- Modern Statistics Cards - Glassmorphism Style -->
<div class="row g-4 mb-4">
    <!-- User Card -->
    <div class="col-12 col-md-4">
        <div class="admin-card glass-card stats-card-primary">
            <div class="card-content">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_users'] }}</div>
                        <div class="stats-label">Total Users</div>
                        <div class="stats-change positive">
                            <i class="bi bi-arrow-up"></i> 12% from last week
                        </div>
                    </div>
                    <div class="stats-icon bg-primary-soft">
                        <i class="bi bi-people-fill text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Card -->
    <div class="col-12 col-md-4">
        <div class="admin-card glass-card stats-card-success">
            <div class="card-content">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_roles'] }}</div>
                        <div class="stats-label">User Roles</div>
                        <div class="stats-change">
                            <i class="bi bi-dash"></i> No change
                        </div>
                    </div>
                    <div class="stats-icon bg-success-soft">
                        <i class="bi bi-person-badge-fill text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Card -->
    <div class="col-12 col-md-4">
        <div class="admin-card glass-card stats-card-info">
            <div class="card-content">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_permissions'] }}</div>
                        <div class="stats-label">Permissions</div>
                        <div class="stats-change positive">
                            <i class="bi bi-arrow-up"></i> 3 new
                        </div>
                    </div>
                    <div class="stats-icon bg-info-soft">
                        <i class="bi bi-shield-lock-fill text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="col-12 col-md-4">
        <div class="admin-card glass-card stats-card-warning">
            <div class="card-content">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_categories'] }}</div>
                        <div class="stats-label">Categories</div>
                        <div class="stats-change negative">
                            <i class="bi bi-arrow-down"></i> 2 inactive
                        </div>
                    </div>
                    <div class="stats-icon bg-warning-soft">
                        <i class="bi bi-collection-fill text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Card -->
    <div class="col-12 col-md-4">
        <div class="admin-card glass-card stats-card-purple">
            <div class="card-content">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_products'] }}</div>
                        <div class="stats-label">Products</div>
                        <div class="stats-change positive">
                            <i class="bi bi-arrow-up"></i> 5 new today
                        </div>
                    </div>
                    <div class="stats-icon bg-purple-soft">
                        <i class="bi bi-box-seam-fill text-purple"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Card -->
    <div class="col-12 col-md-4">
        <div class="admin-card glass-card stats-card-dark">
            <div class="card-content">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ now()->format('H:i') }}</div>
                        <div class="stats-label">Current Time</div>
                        <div class="stats-change">
                            {{ now()->format('A') }}
                        </div>
                    </div>
                    <div class="stats-icon bg-dark-soft">
                        <i class="bi bi-clock-fill text-dark"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Recent Activity Section -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card glass-card">
            <div class="card-header border-0 bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Recent User Activity</h5>
                        <p class="card-description text-muted mb-0">Latest registered users and their actions</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-content">
                @if($stats['recent_users']->count() > 0)
                    <div class="table-responsive">
                        <table class="table admin-table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">User</th>
                                    <th class="border-0 d-none d-md-table-cell">Email</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 text-end">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_users'] as $user)
                                    <tr>
                                        <td class="fw-medium d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-text bg-{{ $user->email_verified_at ? 'primary' : 'secondary' }}">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            {{ $user->name }}
                                        </td>
                                        <td class="text-muted d-none d-md-table-cell">{{ $user->email }}</td>
                                        <td>
                                            <span class="badge badge-pill bg-{{ $user->email_verified_at ? 'primary-soft text-primary' : 'secondary-soft text-secondary' }}">
                                                <i class="bi bi-{{ $user->email_verified_at ? 'check-circle-fill' : 'clock' }} me-1"></i>
                                                {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="text-muted text-end">{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-people text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="mb-1">No users found</h5>
                            <p class="text-muted mb-4">There are no recent users to display</p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus me-1"></i> Add New User
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions Card -->
        <div class="admin-card glass-card">
            <div class="card-header border-0 bg-transparent">
                <h5 class="card-title mb-1">Quick Actions</h5>
                <p class="card-description text-muted mb-0">Common admin tasks</p>
            </div>
            <div class="card-content">
                <div class="d-grid gap-2">
                    @can('manage_users')
                    <a href="{{ route('admin.users.create') }}" class="btn btn-action btn-outline-primary text-start">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Add New User
                        <i class="bi bi-arrow-right-short ms-auto"></i>
                    </a>
                    @endcan
                    
                    @can('view_users')
                    <a href="{{ route('admin.users.index') }}" class="btn btn-action btn-outline-secondary text-start">
                        <i class="bi bi-people-fill me-2"></i>
                        Manage Users
                        <i class="bi bi-arrow-right-short ms-auto"></i>
                    </a>
                    @endcan
                    
                    @can('manage_roles')
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-action btn-outline-success text-start">
                        <i class="bi bi-person-badge me-2"></i>
                        Create Role
                        <i class="bi bi-arrow-right-short ms-auto"></i>
                    </a>
                    @endcan
                    
                    @can('view_roles')
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-action btn-outline-info text-start">
                        <i class="bi bi-shield-check me-2"></i>
                        Role Permissions
                        <i class="bi bi-arrow-right-short ms-auto"></i>
                    </a>
                    @endcan
                    
                    @can('manage_permissions')
                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-action btn-outline-warning text-start">
                        <i class="bi bi-key-fill me-2"></i>
                        Add Permission
                        <i class="bi bi-arrow-right-short ms-auto"></i>
                    </a>
                    @endcan
                    
                    @can('manage_categories')
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-action btn-outline-purple text-start">
                        <i class="bi bi-tag-fill me-2"></i>
                        Add Category
                        <i class="bi bi-arrow-right-short ms-auto"></i>
                    </a>
                    @endcan

                    @can('manage_products')
                    <a href="{{ route('admin.products.create') }}" class="btn btn-action btn-outline-dark text-start">
                        <i class="bi bi-box-seam me-2"></i>
                        Add Product
                        <i class="bi bi-arrow-right-short ms-auto"></i>
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- System Info Card -->
        <div class="admin-card glass-card mt-4">
            <div class="card-header border-0 bg-transparent">
                <h5 class="card-title mb-1">System Health</h5>
                <p class="card-description text-muted mb-0">Server and application status</p>
            </div>
            <div class="card-content">
                <div class="system-info">
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="info-icon bg-primary-soft text-primary rounded-circle me-3">
                                <i class="bi bi-gear-fill"></i>
                            </div>
                            <div>
                                <div class="info-label">Laravel Version</div>
                                <div class="info-value">{{ app()->version() }}</div>
                            </div>
                        </div>
                        <span class="badge badge-pill bg-primary-soft text-primary">Latest</span>
                    </div>
                    
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="info-icon bg-success-soft text-success rounded-circle me-3">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <div>
                                <div class="info-label">PHP Version</div>
                                <div class="info-value">{{ PHP_VERSION }}</div>
                            </div>
                        </div>
                        <span class="badge badge-pill bg-success-soft text-success">Active</span>
                    </div>
                    
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="info-icon bg-{{ app()->environment() === 'production' ? 'info-soft text-info' : 'warning-soft text-warning' }} rounded-circle me-3">
                                <i class="bi bi-hdd-stack-fill"></i>
                            </div>
                            <div>
                                <div class="info-label">Environment</div>
                                <div class="info-value">{{ ucfirst(app()->environment()) }}</div>
                            </div>
                        </div>
                        <span class="badge badge-pill bg-{{ app()->environment() === 'production' ? 'info-soft text-info' : 'warning-soft text-warning' }}">
                            {{ app()->environment() === 'production' ? 'Live' : 'Development' }}
                        </span>
                    </div>
                    
                    <div class="info-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="info-icon bg-{{ config('app.debug') ? 'danger-soft text-danger' : 'secondary-soft text-secondary' }} rounded-circle me-3">
                                <i class="bi bi-bug-fill"></i>
                            </div>
                            <div>
                                <div class="info-label">Debug Mode</div>
                                <div class="info-value">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</div>
                            </div>
                        </div>
                        <span class="badge badge-pill bg-{{ config('app.debug') ? 'danger-soft text-danger' : 'secondary-soft text-secondary' }}">
                            {{ config('app.debug') ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        @else
        <!-- Non-admin dashboard with modern design -->
        <div class="row g-4 mb-4">
            <!-- Enquiry Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="admin-card glass-card stats-card-primary">
                    <a href="" class="text-decoration-none">
                        <div class="card-content">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stats-number">{{ $employee['enquery'] }}</div>
                                    <div class="stats-label">Enquiries</div>
                                    <div class="stats-change positive">
                                        <i class="bi bi-arrow-up"></i> {{ $employee['enquery_today'] }} new today
                                    </div>
                                </div>
                                <div class="stats-icon bg-primary-soft">
                                    <i class="bi bi-chat-square-text-fill text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="admin-card glass-card stats-card-success">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                        <div class="card-content">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stats-number">{{ $employee['orders'] }}</div>
                                    <div class="stats-label">Total Orders</div>
                                    <div class="stats-change positive">
                                        <i class="bi bi-arrow-up"></i> {{ $employee['orders_today'] }} new Today
                                    </div>
                                </div>
                                <div class="stats-icon bg-success-soft">
                                    <i class="bi bi-cart-check-fill text-success"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Payments Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="admin-card glass-card stats-card-info">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                        <div class="card-content">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stats-number">{{ $employee['pending_payments'] }}</div>
                                    <div class="stats-label">Payments</div>
                                    <div class="stats-change negative">
                                        <i class="bi bi-arrow-down"></i> {{ $employee['pending_payment_today'] }} pending today
                                    </div>
                                </div>
                                <div class="stats-icon bg-info-soft">
                                    <i class="bi bi-credit-card-fill text-info"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Sample Request Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="admin-card glass-card stats-card-warning">
                    <a href="{{ route('admin.sampling-requests.index') }}" class="text-decoration-none">
                        <div class="card-content">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stats-number">{{ $employee['sample_request'] }}</div>
                                    <div class="stats-label">Sample Requests</div>
                                    <div class="stats-change">
                                        <i class="bi bi-arrow-up"></i> {{ $employee['sample_request_today'] }} Today
                                    </div>
                                </div>
                                <div class="stats-icon bg-warning-soft">
                                    <i class="bi bi-box-seam-fill text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Visit Request Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="admin-card glass-card stats-card-purple">
                    <a href="{{ route('admin.visit-requests.index') }}" class="text-decoration-none">
                        <div class="card-content">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stats-number">{{ $employee['visit_request'] }}</div>
                                    <div class="stats-label">Visit Requests</div>
                                    <div class="stats-change positive">
                                        <i class="bi bi-arrow-up"></i> {{ $employee['visit_today'] }} new
                                    </div>
                                </div>
                                <div class="stats-icon bg-purple-soft">
                                    <i class="bi bi-calendar-event-fill text-purple"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Photos Card -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="admin-card glass-card stats-card-dark">
                    <a href="{{ route('admin.git-distributeds.index') }}" class="text-decoration-none">
                        <div class="card-content">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stats-number">{{ $employee['photo'] }}</div>
                                    <div class="stats-label">Photos Uploaded</div>
                                    <div class="stats-change positive">
                                        <i class="bi bi-image"></i> {{ $employee['photo_today'] }} today
                                    </div>
                                </div>
                                <div class="stats-icon bg-dark-soft">
                                    <i class="bi bi-images text-dark"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <style>
        /* Modern Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.15);
        }
        
        /* Text Gradient */
        .text-gradient {
            background: linear-gradient(90deg, #4f46e5 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Stats Cards */
        .stats-card .card-content {
            padding: 20px;
        }
        
        .stats-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
        }
        
        .stats-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 8px;
        }
        
        .stats-change {
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .stats-change.positive {
            color: #10b981;
        }
        
        .stats-change.negative {
            color: #ef4444;
        }
        
        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .bg-primary-soft {
            background-color: rgba(79, 70, 229, 0.1);
        }
        
        .bg-success-soft {
            background-color: rgba(16, 185, 129, 0.1);
        }
        
        .bg-info-soft {
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        .bg-warning-soft {
            background-color: rgba(245, 158, 11, 0.1);
        }
        
        .bg-danger-soft {
            background-color: rgba(239, 68, 68, 0.1);
        }
        
        .bg-purple-soft {
            background-color: rgba(139, 92, 246, 0.1);
        }
        
        .bg-dark-soft {
            background-color: rgba(30, 41, 59, 0.1);
        }
        
        .bg-secondary-soft {
            background-color: rgba(100, 116, 139, 0.1);
        }
        
        /* Quick Action Buttons */
        .btn-action {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: translateX(5px);
        }
        
        /* Avatar */
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .avatar-text {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: white;
            font-weight: 600;
        }
        
        .avatar-sm {
            width: 36px;
            height: 36px;
            font-size: 0.875rem;
        }
        
        /* System Info Items */
        .info-item {
            padding: 12px;
            border-radius: 8px;
            background-color: rgba(241, 245, 249, 0.5);
        }
        
        .info-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        
        .info-label {
            font-size: 0.75rem;
            color: #64748b;
        }
        
        .info-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: #1e293b;
        }
        
        /* Empty State */
        .empty-state {
            max-width: 300px;
            margin: 0 auto;
            text-align: center;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .stats-number {
                font-size: 1.5rem;
            }
            
            .stats-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }
            
            .card-content {
                padding: 16px;
            }
        }
        
        @media (max-width: 576px) {
            .stats-number {
                font-size: 1.3rem;
            }
            
            .stats-label {
                font-size: 0.75rem;
            }
            
            .stats-change {
                font-size: 0.65rem;
            }
        }
    </style>
@endsection