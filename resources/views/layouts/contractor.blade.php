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
    <style>
        .app-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: #ffffff; /* or your preferred header color */
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* optional shadow */
}

.logo-section {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: inherit;
}

.logo {
    margin-right: 0.5rem;
    font-size: 1.5rem;
}

.badges-container {
    display: flex;
    gap: 1rem; /* space between badges */
}

.badge-icon {
    position: relative;
    font-size: 1.25rem;
    cursor: pointer;
    color: #666; /* or your preferred icon color */
}

.badge-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #ff4757; /* or your preferred badge color */
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 0.7rem;
    font-weight: bold;
}
.progress-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 15px; /* Spacing between cards */
}

/* Default: 4 cards per row (Desktop) */
.progress-card {
    flex: 1 1 calc(25% - 15px); /* 4 cards with gap adjustment */
    min-width: 200px; /* Minimum card width */
    box-sizing: border-box;
}

/* Tablet: 2 cards per row */
@media (max-width: 992px) {
    .progress-card {
        flex: 1 1 calc(50% - 15px); /* 2 cards per row */
    }
}

/* Mobile: 2 cards per row (stacked if too narrow) */
@media (max-width: 576px) {
    .progress-card {
        flex: 1 1 calc(50% - 15px); /* 2 cards per row */
        min-width: 150px; /* Smaller min-width for mobile */
    }
}

.progress-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 columns on desktop */
    gap: 15px;
}

@media (max-width: 992px) {
    .progress-cards {
        grid-template-columns: repeat(2, 1fr); /* 2 columns on tablet/mobile */
    }
}
    </style>
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

    <div class="badges-container">
        @foreach($currentBadge as $badge)
        <div class="badge-icon">
            <img src="{{ asset($badge->image) }}" style="border-radius: 15px; width: 26px;height: 29px;"
            alt="{{ $badge->name }}" class="" width="30"  title="{{ $badge->name }}">

        </div>
        @endforeach

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
                <a href="{{ route('contractor.business.opportunity') }}" class="footer-menu-item {{ request()->routeIs('contractor.business.opportunity') ? 'active' : '' }}">
                    <i class="bi bi-briefcase footer-icon"></i>
                    <span>Business</span>
                </a>
                <a href="{{ route('contractor.wise') }}" class="footer-menu-item {{ request()->routeIs('contractor.wise') ? 'active' : '' }}">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @stack('scripts')

</body>
</html>
