@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Order Details</h1>
                <p class="text-muted">Order ID: {{ $order->order_number }} | Date:
                    {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</p>
            </div>
            <div class="d-flex gap-2">
                @can('manage_orders')
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Order
                    </a>
                @endcan
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Orders
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Order Information -->
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Order Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <img src="{{ $order->product->image_url }}" class="img-fluid rounded" alt="">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted">Product</label>
                                <div class="fw-medium">{{ optional($order->product)->name ?? 'N/A' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted">contractor</label>
                                <div class="fw-medium">{{ optional($order->contractor)->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Contractor Phone</label>
                                <div class="fw-medium">{{ optional($order->contractor)->phone ?? 'N/A' }}</div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Action </h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="POST" action="{{ route('admin.orders.status.update') }}">
                                    @csrf

                                    <input type="hidden" name="id" id="" value="{{ request()->segment(3) }}">
                                    <input type="hidden" name="user_id" id="" value="{{ $order->user_id }}">
                                    <input type="hidden" name="points" id=""
                                        value="{{ $order->product->points ?? 0 * $order->qty }}">
                                    <label for="status">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="0" @if ($order->status == 0) selected @endif>Pending
                                        </option>
                                        <option value="1" @if ($order->status == 1) selected @endif>Processing
                                        </option>
                                        <option value="2" @if ($order->status == 2) selected @endif>Approve &
                                            Shipped</option>
                                        <option value="3" @if ($order->status == 3) selected @endif>Delivered
                                        </option>
                                        <option value="4" @if ($order->status == 4) selected @endif>Cancelled
                                        </option>
                                        <option value="5" @if ($order->status == 5) selected @endif>Returned
                                        </option>
                                    </select>
                                    <button type="submit" style="margin-top:28px; witdht:260px;" class="btn btn-primary">
                                        <i class="bi bi-check2-circle me-2"></i>
                                        Update Status
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                @if(Auth::user()->id==1)
                                <form method="POST" action="{{ route('admin.orders.assign.update') }}">
                                    @csrf
                                    <input type="hidden" name="id" id=""
                                        value="{{ request()->segment(3) }}">
                                    <label for="status">Assign user</label>
                                    <select name="user_id" id="" class="form-control">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($order->assign_to == $user->id) selected @endif>{{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" style="margin-top:28px; witdht:260px;" class="btn btn-primary">
                                        <i class="bi bi-check2-circle me-2"></i>
                                        Assign To
                                    </button>
                                </form>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Details -->
            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Financial Details</h5>
                    </div>
                    <div class="card-content">
                        <div class="row g-3">
                            <div class="col-12 row">
                                <div class="col-6">
                                    <label class="form-label text-muted">Quantity</label>
                                    <div class="fw-medium fs-4">{{ $order->qty }}</div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted">Coins</label>
                                    <div class="fw-medium fs-4">{{ $order->product->points ?? 0 * $order->qty }}</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-muted">Rate</label>
                                <div class="fw-medium fs-4 text-success">₹{{ number_format($order->rate, 2) }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted">Subtotal</label>
                                <div class="fw-medium fs-4 text-primary">
                                    ₹{{ number_format($order->qty * $order->rate, 2) }}</div>
                            </div>
                            @if ($order->transport)
                                <div class="col-12">
                                    <label class="form-label text-muted">Transport</label>
                                    <div class="fw-medium fs-5">₹{{ number_format($order->transport, 2) }}</div>
                                </div>
                            @endif
                            @if ($order->partner_commission)
                                <div class="col-12">
                                    <label class="form-label text-muted">Partner Commission</label>
                                    <div class="fw-medium fs-5">₹{{ number_format($order->partner_commission, 2) }}</div>
                                </div>
                            @endif
                            <div class="col-12">
                                <hr>
                                <label class="form-label text-muted">Total Amount</label>
                                <div class="fw-bold fs-3 text-success">
                                    ₹{{ number_format($order->qty * $order->rate + ($order->transport ?? 0), 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                @can('manage_orders')
                    <div class="admin-card">
                        <div class="card-header">
                            <h5 class="card-title">Actions</h5>
                        </div>
                        <div class="card-content">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil me-2"></i>
                                    Edit Order
                                </a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-destructive w-100"
                                        data-confirm="Are you sure you want to delete this order? This action cannot be undone.">
                                        <i class="bi bi-trash me-2"></i>
                                        Delete Order
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="admin-card mt-4">
            <div class="card-header">
                <h5 class="card-title">Order Timeline</h5>
            </div>
            <div class="card-content">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Order Created</h6>
                            <p class="timeline-text text-muted">
                                {{ optional($order->created_at)->format('M j, Y \a\t g:i A') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    @if ($order->updated_at != $order->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Order Updated</h6>
                                <p class="timeline-text text-muted">{{ $order->updated_at->format('M j, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-marker {
            position: absolute;
            left: -23px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px #dee2e6;
        }

        .timeline-content {
            padding-left: 20px;
        }

        .timeline-title {
            margin-bottom: 5px;
            font-weight: 600;
        }

        .timeline-text {
            margin-bottom: 0;
            font-size: 0.875rem;
        }
    </style>
@endsection
