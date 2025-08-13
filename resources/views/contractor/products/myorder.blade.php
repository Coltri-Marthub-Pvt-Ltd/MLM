@extends('layouts.contractor')

@section('title', 'My Orders')

@section('content')
<style>
    :root {
        --flipkart-blue: #2874f0;
        --flipkart-orange: #fb641b;
        --flipkart-light: #f1f3f6;
        --flipkart-dark: #212121;
        --flipkart-gray: #878787;
        --flipkart-white: #ffffff;
    }

    .orders-container {
        background-color: var(--flipkart-light);
        min-height: 100vh;
        font-family: 'Roboto', sans-serif;
        padding-bottom: 20px;
    }

    /* Tab Styles */
    .orders-tabs {
        display: flex;
        background: var(--flipkart-white);
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        border-bottom: 1px solid #e0e0e0;
    }

    .orders-tab {
        flex: 1;
        padding: 15px 0;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
        color: var(--flipkart-gray);
        border-bottom: 3px solid transparent;
        cursor: pointer;
    }

    .orders-tab.active {
        color: var(--flipkart-blue);
        border-bottom-color: var(--flipkart-blue);
    }

    /* Tab Content */
    .tab-content {
        display: none;
        padding: 15px;
    }

    .tab-content.active {
        display: block;
    }

    /* Order Card Styles */
    .order-card {
        background: var(--flipkart-white);
        margin-bottom: 15px;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .order-header {
        padding: 10px 12px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
    }

    .order-id {
        font-size: 13px;
        color: var(--flipkart-dark);
        font-weight: 500;
    }

    .order-date {
        font-size: 11px;
        color: var(--flipkart-gray);
    }

    .order-status {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 500;
    }

    .order-row {
        padding: 12px;
        display: flex;
        align-items: center;
    }

    .product-image {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-right: 12px;
        border: 1px solid #f0f0f0;
    }

    .product-details {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 12px;
        font-weight: 500;
        color: var(--flipkart-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 4px;
    }

    .product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 11px;
        color: var(--flipkart-gray);
    }

    .product-price {
        font-weight: 500;
        color: var(--flipkart-dark);
    }

    .order-total {
        font-size: 12px;
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-left: auto;
        text-align: right;
        min-width: 100px;
    }

    .points {
        font-size: 10px;
        color: var(--flipkart-gray);
    }

    .view-btn {
        padding: 5px;
        border-radius: 50%;
        border: 1px solid #c2c2c2;
        background: var(--flipkart-white);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        margin-left: 8px;
    }

    .view-btn:hover {
        background: #f0f0f0;
    }

    .view-icon {
        color: var(--flipkart-blue);
        font-size: 14px;
    }

    /* Status Colors */
    .status-pending { background: #fff4e5; color: #ff9f00; }
    .status-processing { background: #e5f0ff; color: #2874f0; }
    .status-shipped { background: #ffefe5; color: #fb641b; }
    .status-delivered { background: #e5f8ed; color: #03a685; }
    .status-cancelled { background: #ffebee; color: #e53935; }
    .status-returned { background: #f3e5f5; color: #8e24aa; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: var(--flipkart-white);
        margin-top: 8px;
        border-radius: 4px;
    }

    .empty-icon {
        font-size: 60px;
        color: #c2c2c2;
        margin-bottom: 16px;
    }

    .empty-text {
        font-size: 16px;
        color: var(--flipkart-gray);
        margin-bottom: 16px;
    }

    .shop-btn {
        padding: 10px 24px;
        background: var(--flipkart-orange);
        color: var(--flipkart-white);
        border: none;
        border-radius: 2px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .order-row {
            flex-wrap: wrap;
        }

        .order-total {
            margin-left: 62px; /* image width + margin */
            margin-top: 4px;
            text-align: left;
            min-width: auto;
        }
    }
</style>

<div class="orders-container">
    <div class="orders-tabs">
        <div class="orders-tab active" onclick="switchTab('product-orders', this)">Product Orders</div>
        <div class="orders-tab" onclick="switchTab('coins-orders', this)">Coins Orders</div>
    </div>

    {{-- Product Orders Tab --}}
    <div id="product-orders" class="tab-content active">
        @if ($orders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <div class="empty-text">You haven't placed any orders yet</div>
                <button class="shop-btn">Shop Now</button>
            </div>
        @else
            @foreach ($orders as $order)
                @php
                    $statusClasses = [
                        0 => 'status-pending',
                        1 => 'status-processing',
                        2 => 'status-shipped',
                        3 => 'status-delivered',
                        4 => 'status-cancelled',
                        5 => 'status-returned'
                    ];
                    $statusTexts = [
                        0 => 'Pending',
                        1 => 'Processing',
                        2 => 'Shipped',
                        3 => 'Delivered',
                        4 => 'Cancelled',
                        5 => 'Returned'
                    ];
                    $statusClass = $statusClasses[$order->status] ?? 'status-pending';
                    $statusText = $statusTexts[$order->status] ?? 'Pending';
                @endphp

                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-id">Order #{{ $order->order_number }}</span>
                            <span class="order-date">• {{ $order->created_at?->format('d M Y') ?? 'N/A' }}</span>
                        </div>
                        <div class="order-status {{ $statusClass }}">{{ $statusText }}</div>
                    </div>

                    <div class="order-row">
                        <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}" class="product-image">
                        <div class="product-details">
                            <div class="product-title">{{ $order->product->name }}</div>
                            <div class="product-meta">
                                <span class="product-price">₹{{ number_format($order->rate) }}</span>
                                <span>•</span>
                                <span>Qty: {{ $order->qty }}</span>
                            </div>
                        </div>
                        <div class="order-total">
                            ₹{{ number_format($order->rate * $order->qty) }}
                            <div class="points">{{ $order->product->points * $order->qty }} points</div>
                        </div>
                        <a href="{{ route('contractor.orders.track', $order->id) }}" class="view-btn" title="View Details">
                            <i class="fas fa-eye view-icon"></i>
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="pagination">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    {{-- Coins Orders Tab --}}
    <div id="coins-orders" class="tab-content">
        @if ($coinsOrders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🪙</div>
                <div class="empty-text">You haven't placed any coins orders yet</div>
                <button class="shop-btn">Redeem Now</button>
            </div>
        @else
            @foreach ($coinsOrders as $order)
                @php
                    $statusClass = $statusClasses[$order->status] ?? 'status-pending';
                    $statusText = $statusTexts[$order->status] ?? 'Pending';
                @endphp

                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-id">Order #{{ $order->order_number }}</span>
                            <span class="order-date">• {{ $order->created_at?->format('d M Y') ?? 'N/A' }}</span>
                        </div>
                        <div class="order-status {{ $statusClass }}">{{ $statusText }}</div>
                    </div>

                    <div class="order-row">
                        <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}" class="product-image">
                        <div class="product-details">
                            <div class="product-title">{{ $order->product->name }}</div>
                            <div class="product-meta">
                                <span>Qty: {{ $order->qty }}</span>
                            </div>
                        </div>
                        <div class="order-total">
                            {{ $order->product->points * $order->qty }} points
                        </div>
                        <a href="{{ route('contractor.coins.orders.track', $order->id) }}" class="view-btn" title="View Details">
                            <i class="fas fa-eye view-icon"></i>
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="pagination">
                {{ $coinsOrders->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function switchTab(tabId, clickedTab) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });

        // Deactivate all tabs
        document.querySelectorAll('.orders-tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Activate selected tab and content
        document.getElementById(tabId).classList.add('active');
        clickedTab.classList.add('active');
    }

    // Initialize the first tab as active when page loads
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('product-orders', document.querySelector('.orders-tab'));
    });
</script>

<!-- Font Awesome for the eye icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
