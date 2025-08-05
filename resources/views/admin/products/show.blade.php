@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Product Details</h1>
                <p class="text-muted">View product information and specifications</p>
            </div>
            <div class="d-flex gap-2">
                @can('manage_products')
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Product
                </a>
                @endcan
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Products
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Product Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Product Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Product Name</label>
                                    <div class="fw-medium">{{ $product->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Slug</label>
                                    <div class="text-muted">{{ $product->slug }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Price</label>
                                    <div class="fw-bold text-success" style="font-size: 1.2rem;">{{ $product->formatted_price }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Reward Points</label>
                                    <div class="fw-bold text-primary" style="font-size: 1.1rem;">{{ $product->points ?? 0 }} points</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Product ID</label>
                                    <div class="fw-medium">#{{ $product->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created</label>
                                    <div>{{ $product->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div>{{ $product->updated_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Product Information -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Category</label>
                                    <div>
                                        @if($product->category)
                                            <a href="{{ route('admin.categories.show', $product->category) }}" class="text-decoration-none">
                                                <span class="badge badge-secondary">{{ $product->category->name }}</span>
                                            </a>
                                        @else
                                            <span class="text-muted">Uncategorized</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Brand</label>
                                    <div>
                                        @if($product->brand)
                                            <span class="badge badge-primary">{{ $product->brand->name }}</span>
                                        @else
                                            <span class="text-muted">No brand</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Location</label>
                                    <div>
                                        @if($product->location)
                                            <span class="badge badge-info">{{ $product->location->name }}</span>
                                        @else
                                            <span class="text-muted">No location</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Product Type</label>
                                    <div>
                                        @if($product->productType)
                                            <span class="badge badge-warning">{{ $product->productType->name }}</span>
                                        @else
                                            <span class="text-muted">No type</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                @if($product->description)
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Description</h5>
                    </div>
                    <div class="card-content">
                        <div class="text-muted">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Product Image -->
                <div class="admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Product Image</h5>
                        @can('manage_products')
                        @if($product->image)
                        <form method="POST" action="{{ route('admin.products.remove-image', $product) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-destructive" title="Remove Image" 
                                    data-confirm="Are you sure you want to remove this image?">
                                <i class="bi bi-trash me-1"></i>
                                Remove Image
                            </button>
                        </form>
                        @endif
                        @endcan
                    </div>
                    <div class="card-content">
                        <div class="text-center">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                        </div>
                        @if(!$product->image)
                            <div class="text-center py-5">
                                <i class="bi bi-image text-muted mb-3" style="font-size: 4rem;"></i>
                                <h5 class="text-muted mb-3">No Image</h5>
                                <p class="text-muted mb-4">This product doesn't have an image yet.</p>
                                @can('manage_products')
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline">
                                    <i class="bi bi-upload me-2"></i>
                                    Upload Image
                                </a>
                                @endcan
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-2">
                            @can('manage_products')
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline">
                                <i class="bi bi-pencil me-2"></i>
                                Edit Product
                            </a>
                            @if($product->category)
                            <a href="{{ route('admin.products.index') }}?category={{ $product->category->id }}" class="btn btn-outline">
                                <i class="bi bi-tags me-2"></i>
                                View Category Products
                            </a>
                            @endif
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-destructive w-100" 
                                        data-confirm="Are you sure you want to delete this product? This action cannot be undone.">
                                    <i class="bi bi-trash me-2"></i>
                                    Delete Product
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- Product Stats -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Product Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Product ID:</span>
                                <span>#{{ $product->id }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Slug:</span>
                                <span>{{ $product->slug }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Price:</span>
                                <span class="fw-bold text-success">{{ $product->formatted_price }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Points:</span>
                                <span class="fw-bold text-primary">{{ $product->points ?? 0 }} pts</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Category:</span>
                                <span>
                                    @if($product->category)
                                        {{ $product->category->name }}
                                    @else
                                        Uncategorized
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Brand:</span>
                                <span>
                                    @if($product->brand)
                                        {{ $product->brand->name }}
                                    @else
                                        No brand
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Location:</span>
                                <span>
                                    @if($product->location)
                                        {{ $product->location->name }}
                                    @else
                                        No location
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Product Type:</span>
                                <span>
                                    @if($product->productType)
                                        {{ $product->productType->name }}
                                    @else
                                        No type
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Has Image:</span>
                                <span>
                                    @if($product->image)
                                        <i class="bi bi-check-circle text-success"></i> Yes
                                    @else
                                        <i class="bi bi-x-circle text-danger"></i> No
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Created:</span>
                                <span>{{ $product->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Information -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Related Information</h5>
                    </div>
                    <div class="card-content">
                        @if($product->category)
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-tags text-primary me-2"></i>
                            <div>
                                <div class="fw-medium">{{ $product->category->name }}</div>
                                <div class="text-muted small">
                                    {{ $product->category->products()->count() }} products in category
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->brand)
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-shop text-info me-2"></i>
                            <div>
                                <div class="fw-medium">{{ $product->brand->name }}</div>
                                <div class="text-muted small">
                                    {{ $product->brand->products()->count() }} products from this brand
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="d-grid gap-2">
                            @if($product->category)
                            <a href="{{ route('admin.categories.show', $product->category) }}" class="btn btn-outline btn-sm">
                                <i class="bi bi-eye me-1"></i>
                                View Category
                            </a>
                            <a href="{{ route('admin.products.index') }}?category={{ $product->category->id }}" class="btn btn-outline btn-sm">
                                <i class="bi bi-list me-1"></i>
                                All Products in Category
                            </a>
                            @endif
                            @if($product->brand)
                            <a href="#" class="btn btn-outline btn-sm">
                                <i class="bi bi-eye me-1"></i>
                                View Brand
                            </a>
                            <a href="{{ route('admin.products.index') }}?brand={{ $product->brand->id }}" class="btn btn-outline btn-sm">
                                <i class="bi bi-list me-1"></i>
                                All Products from Brand
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection