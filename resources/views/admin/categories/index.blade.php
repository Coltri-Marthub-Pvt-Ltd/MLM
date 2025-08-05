@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Categories</h1>
                <p class="text-muted">Manage product categories and subcategories</p>
            </div>
            @can('manage_categories')
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-tag me-2"></i>
                Add New Category
            </a>
            @endcan
        </div>

        <!-- Categories Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Categories</h5>
                <p class="card-description">{{ $categories->total() }} categories found</p>
            </div>
            
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent Category</th>
                                <th>Products</th>
                                <th>Subcategories</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="text-muted">#{{ $category->id }}</td>
                                    <td class="fw-medium">
                                        @if($category->parent_id)
                                            <i class="bi bi-arrow-return-right text-muted me-1"></i>
                                        @endif
                                        {{ $category->name }}
                                    </td>
                                    <td class="text-muted">{{ $category->slug }}</td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge badge-secondary">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-muted">Root Category</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->products_count > 0)
                                            <span class="badge badge-primary">{{ $category->products_count }} product(s)</span>
                                        @else
                                            <span class="text-muted">No products</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->children_count > 0)
                                            <span class="badge badge-info">{{ $category->children_count }} subcategory(ies)</span>
                                        @else
                                            <span class="text-muted">No subcategories</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $category->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('manage_categories')
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-destructive" title="Delete" 
                                                        data-confirm="Are you sure you want to delete this category? This action cannot be undone.">
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
                @if($categories->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
                            </div>
                            {{ $categories->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-tags text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mb-3">No Categories Found</h5>
                        <p class="text-muted mb-4">There are no categories in the system yet.</p>
                        @can('manage_categories')
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-tag me-2"></i>
                            Create First Category
                        </a>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 
