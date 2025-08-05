@extends('layouts.contractor')

@section('title', 'My Orders')

@section('content')
    <style>
        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #f3b374;
            border-color: var(--bs-nav-tabs-link-active-border-color);
        }

        .nav-link {
            color: #212529;
        }

        .nav-link:focus,
        .nav-link:hover {
            color: #f3b374;
        }

        .bg-dark {
            background-color: rgb(243, 179, 116) !important;
        }

        @media (max-width: 768px) {
            .order-row {
                flex-direction: column !important;
                text-align: center;
            }

            .order-row .col-md-2,
            .order-row .col-md-3,
            .order-row .col-md-1,
            .order-row .col-md-4 {
                margin-bottom: 10px;
            }

            .order-row .text-end {
                text-align: center !important;
            }
        }
    </style>

    <div class="container mt-5">
        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ProductOrders-tab" data-bs-toggle="tab"
                    data-bs-target="#ProductOrders" type="button" role="tab"
                    aria-controls="ProductOrders" aria-selected="true">
                    Product Orders
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="RedeemProductOrder-tab" data-bs-toggle="tab"
                    data-bs-target="#RedeemProductOrder" type="button" role="tab"
                    aria-controls="RedeemProductOrder" aria-selected="false">
                    Redeem Product Order
                </button>
            </li>
        </ul>

        <div class="tab-content pt-3" id="myTabContent">

            {{-- Product Orders Tab --}}
            <div class="tab-pane fade show active" id="ProductOrders" role="tabpanel" aria-labelledby="ProductOrders-tab">
                <h4 class="mb-4 fw-bold">My Orders</h4>
                @if ($orders->isEmpty())
                    <div class="alert alert-info">You have no orders yet.</div>
                @else
                    @foreach ($orders as $order)
                        @php
                            $statusLabels = [0 => 'Pending', 1 => 'Processing', 2 => 'Shipped', 3 => 'Delivered', 4 => 'Cancelled', 5 => 'Returned'];
                            $statusColors = [0 => 'danger', 1 => 'info', 2 => 'primary', 3 => 'success', 4 => 'danger', 5 => 'secondary'];
                            $statusText = $statusLabels[$order->status] ?? 'Unknown';
                            $statusColor = $statusColors[$order->status] ?? 'secondary';
                        @endphp

                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Order #{{ $order->order_number }}</span>
                                <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center order-row d-flex">
                                    <div class="col-md-2">
                                        <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="fw-bold mb-1">{{ $order->product->name }}</h5>
                                        <p class="text-muted mb-0">Ordered: {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <strong>Price</strong><br>
                                        ₹{{ number_format($order->rate) }}
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <strong>Qty</strong><br>
                                        {{ $order->qty }}
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <strong>Points</strong><br>
                                        {{ $order->product->points * $order->qty }}
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <strong>Status</strong><br>
                                        <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <a href="{{ route('contractor.orders.track', $order->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

            {{-- Redeem Product Orders Tab --}}
            <div class="tab-pane fade" id="RedeemProductOrder" role="tabpanel" aria-labelledby="RedeemProductOrder-tab">
                <h4 class="mb-4 fw-bold">My Coins Orders</h4>
                @if ($coinsOrders->isEmpty())
                    <div class="alert alert-info">You have no coins orders yet.</div>
                @else
                    @foreach ($coinsOrders as $order)
                        @php
                            $statusLabels = [0 => 'Pending', 1 => 'Processing', 2 => 'Shipped', 3 => 'Delivered', 4 => 'Cancelled', 5 => 'Returned'];
                            $statusColors = [0 => 'danger', 1 => 'info', 2 => 'primary', 3 => 'success', 4 => 'danger', 5 => 'secondary'];
                            $statusText = $statusLabels[$order->status] ?? 'Unknown';
                            $statusColor = $statusColors[$order->status] ?? 'secondary';
                        @endphp

                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Order #{{ $order->order_number }}</span>
                                <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center order-row d-flex">
                                    <div class="col-md-2">
                                        <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="fw-bold mb-1">{{ $order->product->name }}</h5>
                                        <p class="text-muted mb-0">Ordered: {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <strong>Qty</strong><br>
                                        {{ $order->qty }}
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <strong>Points</strong><br>
                                        {{ $order->product->points * $order->qty }}
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <strong>Status</strong><br>
                                        <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <a href="{{ route('contractor.coins.orders.track', $order->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
