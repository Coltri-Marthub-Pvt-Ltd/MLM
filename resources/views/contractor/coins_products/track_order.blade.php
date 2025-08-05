@extends('layouts.contractor')

@section('title', 'Track Order')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 font-weight-bold">Order Tracking - #{{ $order->order_number }}</h2>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Product Image -->
                    <div class="col-md-2">
                        <img src="{{ $order->product->image_url }}" class="img-fluid rounded" alt="">
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


                    <div class="col-md-10">
                        <h4>{{ $order->product->name }}</h4>
                        <p>Ordered on: {{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : 'N/A' }}</p>
                        <p>Status:
                            <span class="badge bg-{{ $statusColor }}">
                                {{ $statusText }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Timeline -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Tracking Progress</h5>
                <ul class="timeline">
                    @php
                        $statusFlow = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                        $currentStatusIndex = (int) $order->status;
                    if($order->status==4){
                       unset($statusFlow[3]);
                        $statusFlow[] = 'Cancelled';
                    }
                    if($order->status==5){
                        unset($statusFlow[3]);
                        $statusFlow[] = 'Returned';
                    }
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
    </style>
@endsection
