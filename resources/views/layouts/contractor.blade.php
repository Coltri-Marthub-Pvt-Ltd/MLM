<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Contractor Portal') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Contractor CSS -->
    <link href="{{ asset('css/contractor.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <div class="app-container">
        <!-- Header -->
        <header class="app-header">
            <a href="{{ route('contractor.dashboard') }}" class="logo-section">
                <div class="logo">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div class="logo-text">Contractor</div>
            </a>
            
            <div class="badge-icon">
                <i class="bi bi-award"></i>
                @if(isset($badges) && count($badges) > 0)
                    <div class="badge-count">{{ count($badges) }}</div>
                @endif
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success mb-4 mx-3 mt-3">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="alert alert-danger mb-4 mx-3 mt-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer Menu -->
        <footer class="app-footer">
            <div class="footer-menu">
                <a href="{{ route('contractor.dashboard') }}" class="footer-menu-item {{ request()->routeIs('contractor.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-briefcase footer-icon"></i>
                    <span>Business</span>
                </a>
                <a href="{{ route('contractor.products.index') }}" class="footer-menu-item {{ request()->routeIs('contractor.products.*') ? 'active' : '' }}">
                    <i class="bi bi-bag footer-icon"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('contractor.profile') }}" class="footer-menu-item {{ request()->routeIs('contractor.profile') ? 'active' : '' }}">
                    <i class="bi bi-person footer-icon"></i>
                    <span>You</span>
                </a>
                <a href="{{ route('contractor.coins-products.index') }}" class="footer-menu-item {{ request()->routeIs('contractor.coins-products.*') ? 'active' : '' }}">
                    <i class="bi bi-coin footer-icon"></i>
                    <span>Points</span>
                </a>
                <a href="{{ route('contractor.leaders') }}" class="footer-menu-item {{ request()->routeIs('contractor.leaders') ? 'active' : '' }}">
                    <i class="bi bi-trophy footer-icon"></i>
                    <span>Leaders</span>
                </a>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
