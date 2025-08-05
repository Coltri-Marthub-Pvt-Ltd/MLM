@extends('layouts.contractor')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<section class="welcome-section">
    
    
    <!-- Progress Cards -->
    <div class="progress-cards">
        <div class="progress-card">
         
            <div class="progress-value">{{ $contractor->points }}</div>
            <div class="progress-label">Coins</div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(($contractor->points / 1000) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="progress-card">
           
            <div class="progress-value">{{ $directMamber }}</div>
            <div class="progress-label">Sponsors</div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(($directMamber / 10) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Tabs -->
<section class="menu-tabs">
    <div class="tab-list">
        <a href="#" class="tab-item">
            <div class="tab-icon">
                <i class="bi bi-gift"></i>
            </div>
            <div class="tab-content">
                <div class="tab-title">Gift Card</div>
                <div class="tab-description">Redeem your points for gift cards</div>
            </div>
            <div class="tab-arrow">
                <i class="bi bi-chevron-right"></i>
            </div>
        </a>
        
        <a href="{{ route('contractor.myorders') }}" class="tab-item">
            <div class="tab-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="tab-content">
                <div class="tab-title">Order</div>
                <div class="tab-description">View your order history</div>
            </div>
            <div class="tab-arrow">
                <i class="bi bi-chevron-right"></i>
            </div>
        </a>
        
        <a href="#" class="tab-item">
            <div class="tab-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="tab-content">
                <div class="tab-title">Limited Scheme</div>
                <div class="tab-description">Time-limited offers and schemes</div>
            </div>
            <div class="tab-arrow">
                <i class="bi bi-chevron-right"></i>
            </div>
        </a>
        
        <a href="#" class="tab-item">
            <div class="tab-icon">
                <i class="bi bi-tags"></i>
            </div>
            <div class="tab-content">
                <div class="tab-title">Deals</div>
                <div class="tab-description">Special deals and discounts</div>
            </div>
            <div class="tab-arrow">
                <i class="bi bi-chevron-right"></i>
            </div>
        </a>
        
        <a href="#" class="tab-item">
            <div class="tab-icon">
                <i class="bi bi-star"></i>
            </div>
            <div class="tab-content">
                <div class="tab-title">New</div>
                <div class="tab-description">Latest updates and features</div>
            </div>
            <div class="tab-arrow">
                <i class="bi bi-chevron-right"></i>
            </div>
        </a>
    </div>
</section>
@endsection
