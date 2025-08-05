@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create Category</h1>
                <p class="text-muted">Add a new category to organize your products</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Categories
            </a>
        </div>

        <!-- Create Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Category Information</h5>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.categories.store') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug') }}">
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
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('parent_id', request('parent_id')) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
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
                                    Create Category
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
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

                @if($categories->isNotEmpty())
                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Existing Categories</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <p class="text-muted mb-3">Current categories that can be used as parents:</p>
                            <ul class="list-unstyled">
                                @foreach($categories->take(5) as $category)
                                    <li class="mb-2">
                                        <span class="badge badge-secondary">{{ $category->name }}</span>
                                        <div class="text-muted small">
                                            {{ $category->products()->count() }} products
                                        </div>
                                    </li>
                                @endforeach
                                @if($categories->count() > 5)
                                    <li class="text-muted small">...and {{ $categories->count() - 5 }} more</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @else
                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title text-info">
                            <i class="bi bi-info-circle me-2"></i>
                            First Category
                        </h5>
                    </div>
                    <div class="card-content">
                        <p class="text-muted mb-0">This will be your first category! It will be created as a root category since no parent categories exist yet.</p>
                    </div>
                </div>
                @endif
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
