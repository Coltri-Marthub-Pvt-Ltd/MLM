@extends('layouts.admin')

@section('title', 'Create Order')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create Order</h1>
                <p class="text-muted">Add a new order to the system</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Orders
            </a>
        </div>

        <!-- Create Order Form -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Order Details</h5>
                <p class="card-description">Enter all the required information for the order</p>
            </div>

            <form method="POST" action="{{ route('admin.orders.store') }}">
                @csrf
                <div class="card-content">
                    <div class="row g-3">
                        <!-- Date -->
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Client -->
                        <div class="col-md-6">
                            <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('client') is-invalid @enderror" 
                                   id="client" name="client" value="{{ old('client') }}" required>
                            @error('client')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Marketing Person -->
                        <div class="col-md-6">
                            <label for="mkt_person" class="form-label">Marketing Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mkt_person') is-invalid @enderror" 
                                   id="mkt_person" name="mkt_person" value="{{ old('mkt_person') }}" required>
                            @error('mkt_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sales Person -->
                        <div class="col-md-6">
                            <label for="sales_person" class="form-label">Sales Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sales_person') is-invalid @enderror" 
                                   id="sales_person" name="sales_person" value="{{ old('sales_person') }}" required>
                            @error('sales_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Partner ID -->
                        <div class="col-md-6">
                            <label for="partner_id" class="form-label">Partner ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('partner_id') is-invalid @enderror" 
                                   id="partner_id" name="partner_id" value="{{ old('partner_id') }}" required>
                            @error('partner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Area -->
                        <div class="col-md-6">
                            <label for="area" class="form-label">Area <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror" 
                                   id="area" name="area" value="{{ old('area') }}" required>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product -->
                        <div class="col-md-6">
                            <label for="product" class="form-label">Product <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('product') is-invalid @enderror" 
                                   id="product" name="product" value="{{ old('product') }}" required>
                            @error('product')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-6">
                            <label for="qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" 
                                   id="qty" name="qty" value="{{ old('qty') }}" min="1" required>
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rate -->
                        <div class="col-md-6">
                            <label for="rate" class="form-label">Rate <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control @error('rate') is-invalid @enderror" 
                                       id="rate" name="rate" value="{{ old('rate') }}" step="0.01" min="0" required>
                                @error('rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Transport -->
                        <div class="col-md-6">
                            <label for="transport" class="form-label">Transport</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control @error('transport') is-invalid @enderror" 
                                       id="transport" name="transport" value="{{ old('transport') }}" step="0.01" min="0">
                                @error('transport')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Supplier -->
                        <div class="col-md-6">
                            <label for="supplier" class="form-label">Supplier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('supplier') is-invalid @enderror" 
                                   id="supplier" name="supplier" value="{{ old('supplier') }}" required>
                            @error('supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Partner Commission -->
                        <div class="col-md-6">
                            <label for="partner_commission" class="form-label">Partner Commission</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control @error('partner_commission') is-invalid @enderror" 
                                       id="partner_commission" name="partner_commission" value="{{ old('partner_commission') }}" step="0.01" min="0">
                                @error('partner_commission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>
                            Create Order
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection 