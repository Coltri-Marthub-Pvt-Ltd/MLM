@extends('layouts.contractor')

@section('title', 'Track Order')

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

    .order-details-container {
        background-color: var(--flipkart-light);
        min-height: 100vh;
        font-family: 'Roboto', sans-serif;
        padding: 15px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .order-title {
        font-size: 18px;
        font-weight: 500;
        color: var(--flipkart-dark);
    }

    .back-btn {
        color: var(--flipkart-blue);
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .back-btn i {
        margin-right: 5px;
    }

    .order-card {
        background: var(--flipkart-white);
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        overflow: hidden;
    }

    .product-section {
        padding: 15px;
        display: flex;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-right: 15px;
        border: 1px solid #f0f0f0;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-size: 14px;
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-bottom: 8px;
    }

    .product-meta {
        font-size: 12px;
        color: var(--flipkart-gray);
    }

    .order-meta {
        padding: 15px;
    }

    .meta-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .meta-label {
        font-size: 13px;
        color: var(--flipkart-gray);
    }

    .meta-value {
        font-size: 13px;
        font-weight: 500;
        color: var(--flipkart-dark);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Status Colors */
    .status-pending { background: #fff4e5; color: #ff9f00; }
    .status-processing { background: #e5f0ff; color: #2874f0; }
    .status-shipped { background: #ffefe5; color: #fb641b; }
    .status-delivered { background: #e5f8ed; color: #03a685; }
    .status-cancelled { background: #ffebee; color: #e53935; }
    .status-returned { background: #f3e5f5; color: #8e24aa; }

    .timeline-container {
        background: var(--flipkart-white);
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        padding: 15px;
        margin-top: 15px;
    }

    .timeline-title {
        font-size: 15px;
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-bottom: 15px;
    }

    .timeline {
        list-style: none;
        padding-left: 0;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 10px;
        width: 2px;
        background: #e0e0e0;
    }

    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 20px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #c2c2c2;
    }

    .timeline-item.active::before {
        background: var(--flipkart-blue);
        width: 12px;
        height: 12px;
        left: 5px;
    }

    .timeline-item.completed::before {
        background: #03a685;
    }

    .timeline-content {
        font-size: 13px;
    }

    .timeline-status {
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-bottom: 3px;
    }

    .timeline-date {
        font-size: 11px;
        color: var(--flipkart-gray);
    }

    @media (max-width: 576px) {
        .product-image {
            width: 60px;
            height: 60px;
        }

        .product-name {
            font-size: 13px;
        }

        .meta-label, .meta-value {
            font-size: 12px;
        }
    }
</style>

<div class="order-details-container">
    <div class="order-header">
        <h1 class="order-title">Order #{{ $order->order_number }}</h1>
        <a href="{{ url()->previous() }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="order-card">
        <div class="product-section">
            <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}" class="product-image">
            <div class="product-info">
                <div class="product-name">{{ $order->product->name }}</div>
                <div class="product-meta">
                    <div>Qty: {{ $order->qty }}</div>
                    <div>₹{{ number_format($order->rate * $order->qty) }}</div>
                </div>
            </div>
        </div>

        <div class="order-meta">
            @php
                $statusLabels = [
                    0 => 'Pending',
                    1 => 'Processing',
                    2 => 'Shipped',
                    3 => 'Delivered',
                    4 => 'Cancelled',
                    5 => 'Returned',
                ];
                $statusClasses = [
                    0 => 'status-pending',
                    1 => 'status-processing',
                    2 => 'status-shipped',
                    3 => 'status-delivered',
                    4 => 'status-cancelled',
                    5 => 'status-returned',
                ];
                $statusText = $statusLabels[$order->status] ?? 'Unknown';
                $statusClass = $statusClasses[$order->status] ?? 'status-pending';
            @endphp

            <div class="meta-row">
                <span class="meta-label">Order Date</span>
                <span class="meta-value">{{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Status</span>
                <span class="meta-value">
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </span>
            </div>

            <div class="meta-row">
                <span class="meta-label">Total Amount</span>
                <span class="meta-value">₹{{ number_format($order->rate * $order->qty) }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Points Earned</span>
                <span class="meta-value">{{ $order->product->points * $order->qty }} points</span>
            </div>
        </div>
    </div>

    <div class="timeline-container">
        <h3 class="timeline-title">Order Status Timeline</h3>
        <ul class="timeline">
            @php
                $statusFlow = [
                    ['status' => 0, 'label' => 'Order Placed'],
                    ['status' => 1, 'label' => 'Processing'],
                    ['status' => 2, 'label' => 'Shipped'],
                ];

                // For delivered orders
                if ($order->status >= 3) {
                    $statusFlow[] = ['status' => 3, 'label' => 'Delivered'];
                }

                // For cancelled/returned orders
                if ($order->status == 4) {
                    $statusFlow = [
                        ['status' => 0, 'label' => 'Order Placed'],
                        ['status' => 4, 'label' => 'Cancelled']
                    ];
                } elseif ($order->status == 5) {
                    $statusFlow = [
                        ['status' => 0, 'label' => 'Order Placed'],
                        ['status' => 5, 'label' => 'Returned']
                    ];
                }

                $currentStatus = $order->status;
            @endphp

            @foreach ($statusFlow as $index => $step)
                @php
                    $isCompleted = $currentStatus > $step['status'];
                    $isActive = $currentStatus == $step['status'];
                    $statusClass = $isActive ? 'active' : ($isCompleted ? 'completed' : '');
                @endphp

                <li class="timeline-item {{ $statusClass }}">
                    <div class="timeline-content">
                        <div class="timeline-status">{{ $step['label'] }}</div>
                        @if($isCompleted || $isActive)
                            <div class="timeline-date">
                                @if($step['status'] == 0)
                                    {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                                @elseif($isActive)
                                    In progress
                                @else
                                    Completed
                                @endif
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
