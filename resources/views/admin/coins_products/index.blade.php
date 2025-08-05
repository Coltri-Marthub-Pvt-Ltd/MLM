@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">🪙 Coins Products</h1>
                <p class="text-muted">Manage your product catalog</p>
            </div>
            @can('manage_products')
            <a href="{{ route('admin.coins-products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Product
            </a>
            @endcan
        </div>

        <!-- Search and Filters -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="{{ route('admin.coins-products.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search Products</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search by name or description...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="min_price" class="form-label">Min Price</label>
                            <input type="number" class="form-control" id="min_price" name="min_price" 
                                   value="{{ request('min_price') }}" step="0.01" min="0">
                        </div>
                        <div class="col-md-2">
                            <label for="max_price" class="form-label">Max Price</label>
                            <input type="number" class="form-control" id="max_price" name="max_price" 
                                   value="{{ request('max_price') }}" step="0.01" min="0">
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

        <!-- Products Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Products</h5>
                <p class="card-description">{{ $products->total() }} products found</p>
            </div>
            
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Coins</th>
                                <th>Slug</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                             class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td class="fw-medium">{{ $product->name }}</td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge badge-secondary">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">Uncategorized</span>
                                        @endif
                                    </td>
                                   
                                    <td class="fw-medium text-primary">{{ $product->points ?? 0 }} pts</td>
                                    <td class="text-muted">{{ $product->slug }}</td>
                                    <td class="text-muted">{{ $product->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.coins-products.show', $product) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('manage_products')
                                            <a href="{{ route('admin.coins-products.edit', $product) }}" class="btn btn-sm btn-outline" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.coins-products.destroy', $product) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-destructive" title="Delete" 
                                                        data-confirm="Are you sure you want to delete this product?">
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
                @if($products->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                            </div>
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-box text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mb-3">No Products Found</h5>
                        <p class="text-muted mb-4">There are no products in the system yet.</p>
                        @can('manage_products')
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add First Product
                        </a>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 
