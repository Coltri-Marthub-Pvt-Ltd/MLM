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
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
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

        .welcome-title {
            color: var(--contractor-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #6B7280;
            font-size: 1rem;
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(35, 50, 64, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--contractor-primary), var(--contractor-accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stats-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--contractor-dark);
            margin-bottom: 0.25rem;
        }

        .stats-label {
            color: #6B7280;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(35, 50, 64, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-title {
            color: var(--contractor-dark);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.125rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6B7280;
            font-weight: 500;
        }

        .info-value {
            color: var(--contractor-dark);
            font-weight: 600;
        }

        .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #059669;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('contractor.dashboard') }}">
                <i class="bi bi-person-badge me-2"></i>
                Contractor Portal
            </a>

            <div class="badges">
                @foreach ($badges as $badge)
                    <div class="badge-card d-inline gap-2">
                        
                       
                        @if ($contractor->points <= $badge->coins)
                            <img src="{{ $badge->image_url }}" alt="{{ $badge->name }}" width="30px"  height="30px" title="{{ $badge->name }}" class="border border-rounded" />
                          
                        @endif
                    </div>
                @endforeach
            </div>

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
                            {{ $contractor->name }}
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

            <!-- Welcome Card -->
            <div class="welcome-card">
                <h1 class="welcome-title">Welcome back, {{ $contractor->name }}!</h1>
                <p class="welcome-subtitle">Here's your contractor dashboard overview</p>
            </div>

            <!-- Stats Row -->
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="bi bi-coin me-1"></i>
                        </div>
                        <div class="stats-number">{{ $contractor->points }}</div>
                        <div class="stats-label">Coins</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="bi bi-people me-1"></i>
                        </div>
                        <div class="stats-number">{{ $directMamber }}</div>
                        <div class="stats-label">Direct Members</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon">
                            <i class="bi bi-people me-1"></i>
                        </div>
                        <div class="stats-number">{{ $referalMember }}</div>
                        <div class="stats-label">Refreal Members</div>
                    </div>
                </div>
            </div>

            <!-- Information Cards -->
            <div class="row">
                <div class="col-md-6">
                    <div class="info-card">
                        <h3 class="info-title">
                            <i class="bi bi-person me-2"></i>
                            Personal Information
                        </h3>
                        <div class="info-item">
                            <span class="info-label">Full Name:</span>
                            <span class="info-value">{{ $contractor->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $contractor->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $contractor->phone }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date of Birth:</span>
                            <span class="info-value">{{ $contractor->date_of_birth->format('F j, Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card">
                        <h3 class="info-title">
                            <i class="bi bi-card-text me-2"></i>
                            Identity Information
                        </h3>
                        <div class="info-item">
                            <span class="info-label">Aadhar Card:</span>
                            <span
                                class="info-value">{{ substr($contractor->aadhar_card, 0, 4) }}****{{ substr($contractor->aadhar_card, -4) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">PAN Card:</span>
                            <span
                                class="info-value">{{ $contractor->pan_card ? substr($contractor->pan_card, 0, 3) . '****' . substr($contractor->pan_card, -1) : 'Not provided' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Age:</span>
                            <span class="info-value">{{ $contractor->age }} years</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status:</span>
                            <span class="info-value">
                                @if ($contractor->isEligible())
                                    <span class="badge bg-success">Eligible</span>
                                @else
                                    <span class="badge bg-danger">Not Eligible</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Address:</span>
                            <span class="info-value">{{ Str::limit($contractor->address, 50) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full Address Card -->
            <div class="row">
                <div class="col-12">
                    <div class="info-card">
                        <h3 class="info-title">
                            <i class="bi bi-geo-alt me-2"></i>
                            Complete Address
                        </h3>
                        <p class="mb-0" style="color: var(--contractor-dark); font-weight: 500;">
                            {{ $contractor->address }}
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
