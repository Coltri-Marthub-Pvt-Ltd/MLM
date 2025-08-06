<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;500;700&family=Open+Sans:wght@400;500;600;700&family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&family=Nunito:wght@400;500;600;700&family=Source+Sans+Pro:wght@400;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Admin CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <style>
        .badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.btn-group {
    gap: 5px;
}

/* Add to your admin styles */
#photoPreview img {
    transition: all 0.3s ease;
    object-fit: cover;
    border: 1px solid #dee2e6;
    border-radius: 4px;
}

#photoPreview img:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.current-photos {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.current-photos .photo-item {
    position: relative;
}

.current-photos .photo-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 4px;
}

.current-photos .photo-item .delete-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.current-photos .photo-item:hover .delete-btn {
    opacity: 1;
}

    </style>
      @stack('styles') 
</head>
<body class="admin-body" {!! \App\Models\Setting::getThemeAttributesString() !!}>
    <!-- Sidebar -->
    <nav class="admin-sidebar" id="sidebar">
        <div class="sidebar-brand text-center">
            <h4> Admin</h4>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                @can('view_dashboard')
                <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 nav-icon"></i>
                        Dashboard
                    </a>
                </div>
                @endcan
            </div>

            @if(auth()->user()->can('view_categories') || auth()->user()->can('view_products'))
            <div class="nav-section">
                <div class="nav-section-title">Product Management</div>
                @can('view_categories')
                <div class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags nav-icon"></i>
                        Categories
                    </a>
                </div>
                @endcan
                  <div class="nav-item">
                    <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                        <i class="bi bi-tags nav-icon"></i>
                        Brands
                    </a>
                </div>
                 <div class="nav-item">
                    <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                        <i class="bi bi-tags nav-icon"></i>
                        Location
                    </a>
                </div>
                 <div class="nav-item">
                    <a href="{{ route('admin.product-types.index') }}" class="nav-link {{ request()->routeIs('admin.product-types.*') ? 'active' : '' }}">
                        <i class="bi bi-tags nav-icon"></i>
                        Product Types
                    </a>
                </div>
                @can('view_products')
                <div class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box nav-icon"></i>
                        Products
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.coins-products.index') }}" class="nav-link {{ request()->routeIs('admin.coins-products.*') ? 'active' : '' }}">
                        <i class="bi bi-box nav-icon"></i>
                        Coins Products
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.gitcards.index') }}" class="nav-link {{ request()->routeIs('admin.gitcards.*') ? 'active' : '' }}">
                        <i class="bi bi-box nav-icon"></i>
                        Gitcards
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.limited-schemes.index') }}" class="nav-link {{ request()->routeIs('admin.limited-schemes.*') ? 'active' : '' }}">
                        <i class="bi bi-box nav-icon"></i>
                        Limited Schemes
                    </a>
                </div>
                   <div class="nav-item">
                    <a href="{{ route('admin.deals.index') }}" class="nav-link {{ request()->routeIs('admin.deals.*') ? 'active' : '' }}">
                        <i class="bi bi-box nav-icon"></i>
                        Deals
                    </a>
                </div>
                @endcan
                   <div class="nav-item">
                    <a href="{{ route('admin.new-schemes.index') }}" class="nav-link {{ request()->routeIs('admin.new-schemes.*') ? 'active' : '' }}">
                        <i class="bi bi-box nav-icon"></i>
                        New Schemes
                    </a>
                </div>
                 <div class="nav-item">
                    <a href="{{ route('admin.new-opportunities.index') }}" class="nav-link {{ request()->routeIs('admin.new-opportunities.*') ? 'active' : '' }}">
                        <i class="bi bi-box nav-icon"></i>
                        New Opportunities
                    </a>
                </div>
            </div>
            @endif

            @can('view_orders')
            <div class="nav-section">
                <div class="nav-section-title">Order Management</div>
                <div class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt nav-icon"></i>
                        Orders
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.coins-orders.index') }}" class="nav-link {{ request()->routeIs('admin.coins-orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt nav-icon"></i>
                       Coins Orders
                    </a>
                </div>
            </div>
            @endcan



            @can('view_tasks')
            <div class="nav-section">
                <div class="nav-section-title">Task Management</div>
                <div class="nav-item">
                    <a href="{{ route('admin.tasks.index') }}" class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task nav-icon"></i>
                        Tasks
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('admin.enquery') }}" class="nav-link {{ request()->routeIs('admin.enquery') ? 'active' : '' }}">
                        <i class="bi bi-list-task nav-icon"></i>
                        Enquery
                    </a>
                </div>
            </div>
            @endcan
              <div class="nav-section">
                <div class="nav-section-title">Task Management</div>
                <div class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task nav-icon"></i>
                        Events
                    </a>
                </div>
                 <div class="nav-item">
                    <a href="{{ route('admin.sampling-requests.index') }}" class="nav-link {{ request()->routeIs('admin.sampling-requests.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task nav-icon"></i>
                        Sampling Requests
                    </a>
                </div>
                   <div class="nav-item">
                    <a href="{{ route('admin.complaints.index') }}" class="nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task nav-icon"></i>
                        Complaints
                    </a>
                </div>
                 <div class="nav-item">
                    <a href="{{ route('admin.visit-requests.index') }}" class="nav-link {{ request()->routeIs('admin.visit-requests.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task nav-icon"></i>
                       Visit Requests
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.git-distributeds.index') }}" class="nav-link {{ request()->routeIs('admin.git-distributeds.*') ? 'active' : '' }}">
                        <i class="bi bi-list-task nav-icon"></i>
                       Photos
                    </a>
                </div>
            </div>
            

            @if(auth()->user()->can('view_users') || auth()->user()->can('view_roles') || auth()->user()->can('view_permissions') || auth()->user()->can('manage_contractors'))
            <div class="nav-section">
                <div class="nav-section-title">User Management</div>
                @can('view_users')
                    <div class="nav-item">
                    <a href="{{ route('admin.badges.index') }}" class="nav-link {{ request()->routeIs('admin.badges.*') ? 'active' : '' }}">
                        <i class="bi bi-award nav-icon"></i>
                        badges
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people nav-icon"></i>
                        Users
                    </a>
                </div>
                @endcan
                @can('manage_contractors')
                <div class="nav-item">
                    <a href="{{ route('admin.contractors.index') }}" class="nav-link {{ request()->routeIs('admin.contractors.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge nav-icon"></i>
                        Contractors
                    </a>
                </div>
                @endcan
                @can('view_roles')
                <div class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-check nav-icon"></i>
                        Roles
                    </a>
                </div>
                @endcan
                @can('view_permissions')
                <div class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                        <i class="bi bi-key nav-icon"></i>
                        Permissions
                    </a>
                </div>
                @endcan
            </div>
            @endif

            @can('manage_settings')
            <div class="nav-section">
                <div class="nav-section-title">System</div>
                <div class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear nav-icon"></i>
                        Settings
                    </a>
                </div>
            </div>
            @endcan
        </div>
    </nav>

    <!-- Main Content -->
    <div class="admin-main-content" id="main-content">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-content">
                <button class="sidebar-toggle" id="sidebar-toggle" type="button">
                    <i class="bi bi-list"></i>
                </button>

                <div class="header-actions">
                    <div class="dropdown">
                        <button class="btn btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i>
                            {{ Auth::user()->name }}
                            @if(Auth::user()->roles->count() > 0)
                                <span class="badge badge-primary ms-2">{{ Auth::user()->roles->first()->name }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">
                                <strong>{{ Auth::user()->name }}</strong>
                                <br>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </li>
                            @if(Auth::user()->roles->count() > 0)
                            <li class="dropdown-header">
                                <small class="text-muted">Roles:</small>
                                @foreach(Auth::user()->roles as $role)
                                    <br><span class="badge badge-secondary badge-sm">{{ $role->name }}</span>
                                @endforeach
                            </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-4">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" data-auto-dismiss="5000">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" data-auto-dismiss="5000">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay d-lg-none" id="sidebar-overlay" style="display: none;"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Admin JS -->
    <script>
        // Theme auto mode detection
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const colorMode = body.getAttribute('data-color-mode');
            
            function updateAutoMode() {
                if (colorMode === 'auto') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    body.setAttribute('data-color-mode', prefersDark ? 'dark' : 'light');
                }
            }
            
            // Initial update
            updateAutoMode();
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateAutoMode);
        });

        // Mobile responsive sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const mainContent = document.getElementById('main-content');

            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('show');
                    if (sidebar.classList.contains('show')) {
                        overlay.style.display = 'block';
                    } else {
                        overlay.style.display = 'none';
                    }
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                }
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.style.display = 'none';
            });

            // Close sidebar on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    overlay.style.display = 'none';
                }
            });

            // Auto-dismiss alerts
            const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');
            alerts.forEach(alert => {
                const delay = parseInt(alert.dataset.autoDismiss) || 5000;
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.3s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, delay);
            });

            // Form validation enhancement
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                    }
                });
            });

            // Table row actions
            const actionButtons = document.querySelectorAll('[data-confirm]');
            actionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const message = this.dataset.confirm;
                    if (!confirm(message)) {
                        e.preventDefault();
                    }
                });
            });

            // Current page highlighting in navigation
            const currentUrl = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentUrl) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @stack('scripts') 
</body>
</html> 