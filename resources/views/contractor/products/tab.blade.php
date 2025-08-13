@extends('layouts.contractor')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-3 py-3">
    <div class="row g-3">
        <!-- Category Wise -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.product.categories','category') }}" class="card-link">
                <div class="data-card gradient-1">
                    <div class="card-badge">{{ $category }}</div>
                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">CATEGORY WISE</h3>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Application Chart -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.product.categories','type') }}" class="card-link">
                <div class="data-card gradient-2">
                    <div class="card-badge">{{ $appliChart }}</div>
                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">APPLICATION CHART</h3>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Brand Wise -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.product.categories','brand') }}" class="card-link">
                <div class="data-card gradient-3">
                    <div class="card-badge">{{ $brand }}</div>
                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">BRAND WISE</h3>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-tags"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Area Wise -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.product.categories','area') }}" class="card-link">
                <div class="data-card gradient-4">
                    <div class="card-badge">{{ $area }}</div>
                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">AREA WISE</h3>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-map-marked-alt"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --card-radius: 12px;
        --card-padding: 15px;
        --text-color: white;
        --badge-size: 28px;
    }

    .card-link {
        text-decoration: none;
        display: block;
        height: 100%;
        position: relative;
    }

    .data-card {
        border-radius: var(--card-radius);
        padding: var(--card-padding);
        height: 110px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .card-badge {
        position: absolute;
        top: 0;
        right: 0;
        width: var(--badge-size);
        height: var(--badge-size);
        background-color: rgba(255,255,255,0.9);
        color: #333;
        border-radius: 0 0 0 var(--badge-size);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        box-shadow: -2px 2px 4px rgba(0,0,0,0.1);
    }

    .data-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }

    .card-content {
        height: 100%;
    }

    .card-title {
        color: var(--text-color);
        font-size: 16px;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .chart-icon {
        font-size: 28px;
        color: rgba(255,255,255,0.9);
    }

    /* Gradient Colors */
    .gradient-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .gradient-2 { background: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%); }
    .gradient-3 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .gradient-4 { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }

    @media (max-width: 576px) {
        .data-card {
            height: 100px;
        }
        .card-title {
            font-size: 14px;
        }
        .chart-icon {
            font-size: 24px;
        }
        .card-badge {
            width: 35px;
            height: 25px;
            font-size: 12px;
        }
    }
</style>
@endsection
