<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Contractor Dashboard - {{ config('app.name', 'Laravel') }}</title>

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

        /* Enhanced Navigation Bar */
        .navbar {
            background: linear-gradient(135deg, var(--contractor-primary), var(--contractor-accent));
            box-shadow: 0 2px 10px rgba(35, 50, 64, 0.1);
            padding: 0.5rem 0;
        }

        .navbar-container {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white !important;
            font-weight: 700;
            font-size: 1.25rem;
            margin-right: 2rem;
        }

        .logo-icon {
            font-size: 1.5rem;
            margin-right: 0.75rem;
        }

        .nav-menu {
            display: flex;
            flex-grow: 1;
        }

        .nav-menu-left {
            display: flex;
            align-items: center;
        }

        .nav-menu-right {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .nav-item {
            position: relative;
            margin: 0 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-link i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .badge-menu {
            display: flex;
            align-items: center;
            margin-left: 1rem;
        }

        .menu-badge {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            color: white;
            font-weight: 500;
            margin-left: 0.75rem;
            transition: all 0.2s ease;
        }

        .menu-badge:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .badge-icon {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .badge-value {
            font-weight: 600;
            margin-left: 0.25rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            margin-left: 1.5rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            color: white;
            font-weight: 600;
        }

        .user-name {
            color: white;
            font-weight: 500;
            margin-right: 1rem;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-logout i {
            margin-right: 0.5rem;
        }

        /* Mobile menu adjustments */
        @media (max-width: 992px) {
            .navbar-container {
                flex-wrap: wrap;
            }
            
            .badge-menu {
                order: 3;
                width: 100%;
                justify-content: flex-end;
                margin: 0.5rem 0;
                padding: 0 1rem;
            }
            
            .user-menu {
                margin-left: auto;
            }
        }

        /* Main content remains the same */
        .main-content {
            padding: 2rem 0;
        }

        .welcome-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(35, 50, 64, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        /* ... rest of your existing styles ... */
    </style>
</head>

<body>
    <!-- Combined Navigation Bar with Enhanced Menu -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <div class="navbar-container">
                <!-- Logo/Brand -->
                <a class="navbar-brand" href="{{ route('contractor.dashboard') }}">
                    <i class="bi bi-person-badge logo-icon"></i>
                    Contractor Portal
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Main Navigation -->
                <div class="collapse navbar-collapse nav-menu" id="navbarNav">
                    <!-- Badges and User Menu -->
                    <div class="nav-menu-right">
                        <div class="badge-menu">
                            <div class="menu-badge">
                                <i class="bi bi-coin badge-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>