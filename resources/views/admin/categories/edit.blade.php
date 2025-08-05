@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Edit Category</h1>
                <p class="text-muted">Update category information</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline">
                    <i class="bi bi-eye me-2"></i>
                    View Category
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Categories
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Category Information</h5>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $category->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
                                <div class="form-text">Leave empty to auto-generate from name</div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select class="form-select @error('parent_id') is-invalid @enderror" 
                                        id="parent_id" name="parent_id">
                                    <option value="">No Parent (Root Category)</option>
                                    @foreach($parentCategories as $parentCategory)
                                        <option value="{{ $parentCategory->id }}" 
                                                {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                            {{ $parentCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Select a parent category to create a subcategory</div>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>
                                    Update Category
                                </button>
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Current Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Current Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="mb-3">
                                <strong>Current Name:</strong>
                                <p class="text-muted mb-0">{{ $category->name }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Slug:</strong>
                                <p class="text-muted mb-0">{{ $category->slug }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Parent:</strong>
                                <p class="text-muted mb-0">
                                    @if($category->parent)
                                        {{ $category->parent->name }}
                                    @else
                                        Root Category
                                    @endif
                                </p>
                            </div>
                            <div class="mb-0">
                                <strong>Products:</strong>
                                <p class="text-muted mb-0">{{ $category->products()->count() }} products</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warnings -->
                @if($category->children()->exists() || $category->products()->exists())
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title text-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Important Notice
                        </h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            @if($category->children()->exists())
                                <div class="alert alert-warning">
                                    <strong>Subcategories:</strong> This category has {{ $category->children()->count() }} subcategories. Changing the parent will affect the hierarchy.
                                </div>
                            @endif
                            @if($category->products()->exists())
                                <div class="alert alert-info">
                                    <strong>Products:</strong> This category has {{ $category->products()->count() }} products assigned to it.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tips -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Tips</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <div class="mb-3">
                                <strong>Category Name:</strong>
                                <p class="text-muted mb-0">Choose a clear, descriptive name for your category.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Slug:</strong>
                                <p class="text-muted mb-0">URL-friendly version of the name. Will be auto-generated if left empty.</p>
                            </div>
                            <div class="mb-0">
                                <strong>Parent Category:</strong>
                                <p class="text-muted mb-0">Create hierarchical categories by selecting a parent. Leave empty for top-level categories.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = document.getElementById('slug');
            if (!slug.value || slug.dataset.autoGenerated === 'true') {
                slug.value = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                slug.dataset.autoGenerated = 'true';
            }
        });

        document.getElementById('slug').addEventListener('input', function(e) {
            if (e.target.value) {
                e.target.dataset.autoGenerated = 'false';
            }
        });
    </script>
@endsection 
