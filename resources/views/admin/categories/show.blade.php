@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Category Details</h1>
                <p class="text-muted">View category information and hierarchy</p>
            </div>
            <div class="d-flex gap-2">
                @can('manage_categories')
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Category
                </a>
                @endcan
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Categories
                </a>
            </div>
        </div>

        <!-- Breadcrumb -->
        @if($category->parent)
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                @foreach($category->breadcrumb as $breadcrumbItem)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumbItem->name }}</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.categories.show', $breadcrumbItem) }}">{{ $breadcrumbItem->name }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <!-- Category Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Category Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Name</label>
                                    <div class="fw-medium">{{ $category->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Slug</label>
                                    <div class="text-muted">{{ $category->slug }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Parent Category</label>
                                    <div>
                                        @if($category->parent)
                                            <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-decoration-none">
                                                <span class="badge badge-secondary">{{ $category->parent->name }}</span>
                                            </a>
                                        @else
                                            <span class="text-muted">Root Category</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Category ID</label>
                                    <div class="fw-medium">#{{ $category->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created</label>
                                    <div>{{ $category->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div>{{ $category->updated_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subcategories -->
                @if($category->children->count() > 0)
                <div class="admin-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Subcategories</h5>
                            <p class="card-description">Child categories under this category</p>
                        </div>
                        @can('manage_categories')
                        <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" class="btn btn-sm btn-outline">
                            <i class="bi bi-plus me-1"></i>
                            Add Subcategory
                        </a>
                        @endcan
                    </div>
                    <div class="card-content">
                        <div class="row g-3">
                            @foreach($category->children as $child)
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h6 class="mb-0">
                                                <a href="{{ route('admin.categories.show', $child) }}" class="text-decoration-none">
                                                    {{ $child->name }}
                                                </a>
                                            </h6>
                                            @can('manage_categories')
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-sm btn-outline" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                            @endcan
                                        </div>
                                        <div class="text-muted small">
                                            {{ $child->products()->count() }} products
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Products in Category -->
                @if($category->products->count() > 0)
                <div class="admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Products in Category</h5>
                            <p class="card-description">Products directly assigned to this category</p>
                        </div>
                        @can('manage_products')
                        <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}" class="btn btn-sm btn-outline">
                            <i class="bi bi-plus me-1"></i>
                            Add Product
                        </a>
                        @endcan
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table admin-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Points</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products->take(10) as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                                     class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            </td>
                                            <td class="fw-medium">
                                                <a href="{{ route('admin.products.show', $product) }}" class="text-decoration-none">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td class="fw-medium text-success">{{ $product->formatted_price }}</td>
                                            <td class="fw-medium text-primary">{{ $product->points ?? 0 }} pts</td>
                                            <td class="text-muted">{{ $product->created_at->format('M j, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @can('manage_products')
                                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($category->products->count() > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" class="btn btn-outline">
                                    View All {{ $category->products->count() }} Products
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Statistics -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Statistics</h5>
                    </div>
                    <div class="card-content">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                                        {{ $stats['products_count'] }}
                                    </div>
                                    <div class="text-muted small">Products</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success" style="font-size: 1.5rem;">
                                    {{ $stats['children_count'] }}
                                </div>
                                <div class="text-muted small">Subcategories</div>
                            </div>
                        </div>
                        @if($stats['total_descendants'] > 0)
                        <hr>
                        <div class="text-center">
                            <div class="fw-bold text-info" style="font-size: 1.2rem;">
                                {{ $stats['total_descendants'] }}
                            </div>
                            <div class="text-muted small">Total Descendants</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-2">
                            @can('manage_categories')
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline">
                                <i class="bi bi-pencil me-2"></i>
                                Edit Category
                            </a>
                            <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" class="btn btn-outline">
                                <i class="bi bi-plus me-2"></i>
                                Add Subcategory
                            </a>
                            @endcan
                            @can('manage_products')
                            <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}" class="btn btn-outline">
                                <i class="bi bi-box me-2"></i>
                                Add Product
                            </a>
                            @endcan
                            @can('view_products')
                            <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" class="btn btn-outline">
                                <i class="bi bi-list me-2"></i>
                                View Products
                            </a>
                            @endcan
                            @can('manage_categories')
                            @if($stats['products_count'] == 0 && $stats['children_count'] == 0)
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-destructive w-100" 
                                        data-confirm="Are you sure you want to delete this category? This action cannot be undone.">
                                    <i class="bi bi-trash me-2"></i>
                                    Delete Category
                                </button>
                            </form>
                            @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
