@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create Product</h1>
                <p class="text-muted">Add a new product to your catalog</p>
            </div>
            <a href="{{ route('admin.coins-products.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Products
            </a>
        </div>

        <!-- Create Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Product Information</h5>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.coins-products.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
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
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                <div class="form-text">Provide a detailed description of the product</div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                               
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="points" class="form-label">Coins</label>
                                        <input type="number" class="form-control @error('points') is-invalid @enderror" 
                                               id="points" name="points" value="{{ old('points', 0) }}" 
                                               min="0">
                                        <div class="form-text">Reward points for purchasing this product</div>
                                        @error('points')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <x-admin.category-selector 
                                    name="category_id" 
                                    label="Category" 
                                    :value="old('category_id', request('category_id'))" 
                                    :allowEmpty="true"
                                    emptyText="No Category" />
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label">Product Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <div class="form-text">Upload an image for the product (JPEG, PNG, JPG, GIF - Max: 2MB)</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Preview -->
                            <div id="image-preview" class="mb-4" style="display: none;">
                                <label class="form-label">Image Preview</label>
                                <div>
                                    <img id="preview-img" src="" alt="Preview" class="rounded" style="max-width: 200px; height: auto;">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>
                                    Create Product
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
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
                                <strong>Product Name:</strong>
                                <p class="text-muted mb-0">Choose a clear, descriptive name that customers will understand.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Description:</strong>
                                <p class="text-muted mb-0">Include important details like features, specifications, and benefits.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Price:</strong>
                                <p class="text-muted mb-0">Enter the price in Indian Rupees (₹). Use decimal points for paise (e.g., 199.99).</p>
                            </div>
                            <div class="mb-3">
                                <strong>Points:</strong>
                                <p class="text-muted mb-0">Reward points customers earn when purchasing this product. Leave as 0 if no points are awarded.</p>
                            </div>
                            <div class="mb-3">
                                <strong>Category:</strong>
                                <p class="text-muted mb-0">Select the most appropriate category to help customers find your product.</p>
                            </div>
                            <div class="mb-0">
                                <strong>Image:</strong>
                                <p class="text-muted mb-0">Upload a high-quality image that clearly shows the product. Recommended size: 800x600px or larger.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(\App\Models\Category::count() === 0)
                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title text-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No Categories
                        </h5>
                    </div>
                    <div class="card-content">
                        <p class="text-muted mb-3">You don't have any categories yet. Consider creating categories to organize your products.</p>
                        @can('manage_categories')
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline btn-sm">
                            <i class="bi bi-plus me-1"></i>
                            Create Category
                        </a>
                        @endcan
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

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });


    </script>
@endsection 
