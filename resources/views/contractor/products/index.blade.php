@extends('layouts.contractor')

@section('title', 'Products')

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: var(--contractor-dark); font-weight: 700;">Browse Products</h1>
            <p class="text-muted">Discover our product catalog and earn rewards</p>
        </div>
        <div class="text-muted">
            {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="filter-card">
        <form method="GET" action="{{ route('contractor.products.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search Products</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search by name or description...">
                </div>
                <div class="col-md-2">
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
                    <label for="sort" class="form-label">Sort By</label>
                    <select class="form-select" id="sort" name="sort" onchange="this.form.submit()">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                        <option value="points" {{ request('sort') == 'points' ? 'selected' : '' }}>Points</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="direction" class="form-label">Order</label>
                    <select class="form-select" id="direction" name="direction" onchange="this.form.submit()">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-contractor w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('contractor.products.index') }}" class="btn btn-contractor-outline w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($products->count() > 0)
        <!-- Products Grid -->
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <a href="{{ route('contractor.products.show', $product) }}" class="text-decoration-none">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                            <div class="product-info">
                                @if($product->category)
                                    <div class="product-category">
                                        {{ $product->category->name }}
                                    </div>
                                @endif
                                
                                <h5 class="product-title">{{ $product->name }}</h5>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="product-price">{{ $product->formatted_price }}</div>
                                    <div class="product-points">
                                        <i class="bi bi-coin me-1"></i>
                                        {{ $product->points ?? 0 }} coins
                                    </div>
                                </div>
                                
                                @if($product->description)
                                    <p class="text-muted small mt-2 mb-0">
                                        {{ $product->short_description }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @else
        <!-- No Products Found -->
        <div class="contractor-card text-center py-5">
            <div class="contractor-card-content">
                <i class="bi bi-bag-x mb-3" style="font-size: 4rem; color: var(--contractor-primary);"></i>
                <h4 style="color: var(--contractor-dark);">No Products Found</h4>
                <p class="text-muted mb-4">
                    @if(request()->hasAny(['search', 'category']))
                        No products match your current filters. Try adjusting your search criteria.
                    @else
                        There are currently no products available in our catalog.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category']))
                    <a href="{{ route('contractor.products.index') }}" class="btn btn-contractor">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Clear Filters
                    </a>
                @endif
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Auto-submit form when sort or direction changes
    document.getElementById('sort').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('direction').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endpush 