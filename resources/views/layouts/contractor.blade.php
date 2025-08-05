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

    <style>
        :root {
            --contractor-primary: #F3B374;
            --contractor-secondary: #FFF1D4;
            --contractor-dark: #233240;
            --contractor-light: #FFF1D4;
            --contractor-accent: #F3B374;
        }

        body {
            background-color: var(--contractor-secondary);
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--contractor-primary), var(--contractor-accent));
            box-shadow: 0 2px 10px rgba(35, 50, 64, 0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: color 0.2s ease;
            text-decoration: none;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white !important;
            font-weight: 600;
        }

        .btn-contractor {
            background: linear-gradient(135deg, var(--contractor-primary), var(--contractor-accent));
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-contractor:hover {
            background: linear-gradient(135deg, #E5A066, #F3B374);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(243, 179, 116, 0.3);
        }

        .btn-contractor-outline {
            background: transparent;
            border: 2px solid var(--contractor-primary);
            color: var(--contractor-primary);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-contractor-outline:hover {
            background: var(--contractor-primary);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(243, 179, 116, 0.3);
        }

        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 120px);
        }

        .contractor-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(35, 50, 64, 0.08);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .contractor-card:hover {
            transform: translateY(-2px);
        }

        .contractor-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #F3F4F6;
            background: rgba(243, 179, 116, 0.05);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .contractor-card-content {
            padding: 1.5rem;
        }

        .contractor-card-title {
            color: var(--contractor-dark);
            font-weight: 600;
            margin-bottom: 0;
            font-size: 1.125rem;
        }

        .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #059669;
            border-radius: 8px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(35, 50, 64, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(35, 50, 64, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .product-info {
            padding: 1.25rem;
        }

        .product-title {
            color: var(--contractor-dark);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .product-price {
            color: #059669;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .product-points {
            color: var(--contractor-primary);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .product-category {
            background: rgba(243, 179, 116, 0.1);
            color: var(--contractor-primary);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 0.75rem;
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(35, 50, 64, 0.08);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--contractor-primary);
            box-shadow: 0 0 0 0.2rem rgba(243, 179, 116, 0.25);
        }

        .pagination .page-link {
            color: var(--contractor-primary);
            border-color: #dee2e6;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--contractor-primary);
            border-color: var(--contractor-primary);
            color: white !important;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(243, 179, 116, 0.3);
        }

        .pagination .page-link:hover {
            color: var(--contractor-dark);
            background-color: rgba(243, 179, 116, 0.1);
            border-color: var(--contractor-primary);
            transform: translateY(-1px);
        }

        .pagination .page-item.disabled .page-link {
            color: #6B7280;
            background-color: #F9FAFB;
            border-color: #E5E7EB;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('contractor.dashboard') }}">
                <i class="bi bi-person-badge me-2"></i>
                Contractor Portal
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contractor.dashboard') ? 'active' : '' }}"
                            href="{{ route('contractor.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contractor.products.*') ? 'active' : '' }}"
                            href="{{ route('contractor.products.index') }}">
                            <i class="bi bi-bag me-1"></i>
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contractor.products.*') ? 'active' : '' }}"
                            href="{{ route('contractor.show.cart') }}">
                            <i class="bi bi-cart-check me-1"></i>
                            Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contractor.products.*') ? 'active' : '' }}"
                            href="{{ route('contractor.myorders') }}">
                            <i class="bi bi-clipboard-check me-1"></i>
                            My Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contractor.coins-products.*') ? 'active' : '' }}"
                            href="{{ route('contractor.coins-products.index') }}">
                            <i class="bi bi-coin me-1"></i>
                            Coins Products
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::guard('contractor')->user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('contractor.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-contractor">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
