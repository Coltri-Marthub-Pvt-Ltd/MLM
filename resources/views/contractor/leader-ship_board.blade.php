@extends('layouts.contractor')

@section('title', 'Leader ship Board')

@section('content')
<div class="container-fluid px-3 py-3">
    <div class="row g-3">
        <!-- Upcoming Event -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.upcomming.event') }}" class="card-link">
                <div class="data-card gradient-1">

                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">Up Coming Event</h3>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Photos of Event -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.event.gallery') }}" class="card-link">
                <div class="data-card gradient-2">

                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">Photos of Event</h3>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-images"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tier wise -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.top.wise','tire') }}" class="card-link">
                <div class="data-card gradient-3">

                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">Tier wise</h3>
                        <p>(top 10 partner)</p>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-trophy"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Coins wise -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.top.wise','coin') }}" class="card-link">
                <div class="data-card gradient-4">

                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">Coins wise</h3>
                         <p>(top 10 partner)</p>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-coins"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Top sponsor -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.top.wise','sponser') }}" class="card-link">
                <div class="data-card gradient-5">

                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">Top sponsor</h3>
                         <p>(top 10 partner)</p>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Area Wise -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.top.wise','area') }}" class="card-link">
                <div class="data-card gradient-6">

                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">Area Wise</h3>
                         <p>(top 10 partner)</p>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-map-marked-alt"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Oldest Active member -->
        <div class="col-md-6 col-6">
            <a href="{{ route('contractor.top.wise','oldest') }}" class="card-link">
                <div class="data-card gradient-7">

                    <div class="card-content d-flex flex-column justify-content-between h-100">
                        <h3 class="card-title text-center mb-2">Oldest Active member</h3>
                            <p>(top 10 partner)</p>
                        <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                            <i class="chart-icon fas fa-user-clock"></i>
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
        margin-bottom: 0.2rem;
    }

    .card-content p {
        color: rgba(255,255,255,0.9);
        font-size: 12px;
        text-align: center;
        margin-bottom: 0;
    }

    .chart-icon {
        font-size: 28px;
        color: rgba(255,255,255,0.9);
    }

    /* Gradient Colors */
    .gradient-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); } /* Upcoming Event - Purple/Blue */
    .gradient-2 { background: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%); } /* Photos - Pink */
    .gradient-3 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); } /* Tier - Royal */
    .gradient-4 { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); } /* Coins - Gold */
    .gradient-5 { background: linear-gradient(135deg, #5ee7df 0%, #b490ca 100%); } /* Sponsor - Teal/Purple */
    .gradient-6 { background: linear-gradient(135deg, #c3cfe2 0%, #c3cfe2 100%); } /* Area - Light Blue */
    .gradient-7 { background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); } /* Oldest Member - Soft Blue */

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
