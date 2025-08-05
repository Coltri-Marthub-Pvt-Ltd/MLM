@extends('layouts.contractor')

@section('title', 'My Orders')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 font-weight-bold">My Orders</h2>

        @if ($orders->isEmpty())
            <div class="alert alert-info">You have no orders yet.</div>
        @else
            @foreach ($orders as $order)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold">Order #{{ $order->order_number }}</span>
                        <span
                            class="badge bg-{{ $order->status == 'Completed' ? 'success' : ($order->status == 'Pending' ? 'warning' : 'secondary') }}">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Product Image -->
                            <div class="col-md-2">
                                <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}"
                                    class="img-fluid rounded">
                            </div>

                            <!-- Product Name + Date -->
                            <div class="col-md-3">
                                <h5 class="mb-1 font-weight-bold">{{ $order->product->name }}</h5>
                                <p class="mb-0 text-muted">Ordered:
                                    {{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : 'N/A' }}</p>
                            </div>

                            <!-- Price -->
                            <div class="col-md-1 text-center">
                                <strong>Price</strong><br>
                                ₹{{ number_format($order->rate) }}
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-1 text-center">
                                <strong>Qty</strong><br>
                                {{ $order->qty }}
                            </div>

                            <!-- Points -->
                            <div class="col-md-1 text-center">
                                <strong>Points</strong><br>
                                {{ $order->total_points }}
                            </div>

                            <!-- Status -->
                            <div class="col-md-2 text-center">
                                <strong>Status</strong><br>
                                @php
                                    $statusLabels = [
                                        0 => 'Pending',
                                        1 => 'Processing',
                                        2 => 'Shipped',
                                        3 => 'Delivered',
                                        4 => 'Cancelled',
                                        5 => 'Returned',
                                    ];

                                    $statusColors = [
                                        0 => 'warning', // Pending
                                        1 => 'info', // Processing
                                        2 => 'primary', // Shipped
                                        3 => 'success', // Delivered
                                        4 => 'danger', // Cancelled
                                        5 => 'secondary', // Returned
                                    ];

                                    $statusText = $statusLabels[$order->status] ?? 'Unknown';
                                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            <!-- View Button -->
                            <div class="col-md-2 text-end">
                                <a href="{{ route('contractor.orders.track', $order->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach

            <!-- Pagination (optional) -->
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
