@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<style>
    .auto-adjust-table th,
.auto-adjust-table td {
    white-space: nowrap;
}
.auto-adjust-table {
    width: 100%;
    table-layout: auto;
}
.img-fluid {
  max-width: 123%!important;
  height: auto;
}


</style>
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Orders</h1>
                <p class="text-muted">Manage all orders and transactions</p>
            </div>
            @can('manage_orders')
            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Order
            </a>
            @endcan
        </div>

        <!-- Search and Filters -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="{{ route('admin.orders.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search Orders</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search by client, partner, product...">
                        </div>
                        <div class="col-md-2">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" 
                                   value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" 
                                   value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="area" class="form-label">Area</label>
                            <select class="form-select" id="area" name="area">
                                <option value="">All Areas</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>
                                        {{ $area }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Orders</h5>
                <p class="card-description">{{ $orders->total() }} orders found</p>
            </div>
            
            @if($orders->count() > 0)
                <div class="table-responsive">
    <table class="table admin-table mb-0 auto-adjust-table">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Image</th>
                                <th>Order Number</th>
                                <th>Contractor</th>
                                <th>Phone</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Total</th>
                                <th>Points</th>
                                <th>date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                   <td>{{ $loop->iteration }}</td>
                                   <td>
                                        <img src="{{ optional($order->product)->image_url ?? asset('images/no-image.png') }}" 
                                            class="img-fluid rounded" 
                                            alt="" >
                                    </td>
                                   <td>{{ $order->order_number }}</td>
                                     <td>{{ $order->contractor->name??'' }}</td>
                                     <td>{{ $order->contractor->phone ??'' }}</td>
                                    <td>{{ $order->product->name??'' }}</td>
                                    <td class="text-center">{{ $order->qty }}</td>
                                    <td class="fw-medium text-success">₹{{ number_format($order->rate, 2) }}</td>
                                    <td class="fw-medium text-primary">₹{{ number_format($order->qty * $order->rate, 2) }}</td>
                                    <td class="fw-medium text-primary">{{ $order->product->points ?? 0 * $order->qty }}</td>
                                   <td class="fw-medium">{{ \Carbon\Carbon::parse($order->date)->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('manage_orders')
                                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-destructive" title="Delete" 
                                                        data-confirm="Are you sure you want to delete this order?">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                            </div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-receipt text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mb-3">No Orders Found</h5>
                        <p class="text-muted mb-4">There are no orders in the system yet.</p>
                        @can('manage_orders')
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add First Order
                        </a>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 