@extends('layouts.contractor')

@section('title', 'Track Order')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold">Order Tracking - #{{ $order->order_number }}</h2>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center flex-wrap flex-md-nowrap">
                    <!-- Product Image -->
                    <div class="col-12 col-md-2 text-center mb-3 mb-md-0">
                        <img src="{{ $order->product->image_url }}" class="img-fluid rounded" alt="Product Image">
                    </div>

                    <!-- Product Info -->
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
                            0 => 'warning',
                            1 => 'info',
                            2 => 'primary',
                            3 => 'success',
                            4 => 'danger',
                            5 => 'secondary',
                        ];

                        $statusText = $statusLabels[$order->status] ?? 'Unknown';
                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                    @endphp

                    <div class="col-12 col-md-10">
                        <h4 class="fw-bold">{{ $order->product->name }}</h4>
                        <p class="mb-1">Ordered on: {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</p>
                        <p>Status:
                            <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Timeline -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Tracking Progress</h5>
                <ul class="timeline">
                    @php
                        $statusFlow = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                        if ($order->status == 4) {
                            unset($statusFlow[3]);
                            $statusFlow[] = 'Cancelled';
                        }
                        if ($order->status == 5) {
                            unset($statusFlow[3]);
                            $statusFlow[] = 'Returned';
                        }
                        $currentStatusIndex = array_search($statusLabels[$order->status], $statusFlow);
                    @endphp

                    @foreach ($statusFlow as $index => $step)
                        <li class="{{ $index <= $currentStatusIndex ? 'active' : '' }}">{{ $step }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            list-style: none;
            padding-left: 0;
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #dee2e6;
            z-index: 0;
        }

        .timeline li {
            position: relative;
            z-index: 1;
            padding: 0 10px;
            text-align: center;
            flex: 1;
            font-weight: bold;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .timeline li::before {
            content: '';
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 8px;
            background-color: #dee2e6;
        }

        .timeline li.active {
            color: #28a745;
        }

        .timeline li.active::before {
            background-color: #28a745;
        }

        @media (max-width: 576px) {
            .timeline {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .timeline::before {
                display: none;
            }

            .timeline li {
                flex: unset;
                text-align: left;
                padding-left: 30px;
                position: relative;
            }

            .timeline li::before {
                position: absolute;
                left: 0;
                top: 4px;
            }
        }
    </style>
@endsection
