@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Edit Product</h1>
                <p class="text-muted">Update product information</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline">
                    <i class="bi bi-eye me-2"></i>
                    View Product
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Products
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Product Information</h5>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $product->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug', $product->slug) }}">
                                <div class="form-text">Leave empty to auto-generate from name</div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                                <div class="form-text">Provide a detailed description of the product</div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" name="price" value="{{ old('price', $product->price) }}" 
                                                   step="0.01" min="0">
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="points" class="form-label">Coins</label>
                                        <input type="number" class="form-control @error('points') is-invalid @enderror" 
                                               id="points" name="points" value="{{ old('points', $product->points ?? 0) }}" 
                                               min="0">
                                        <div class="form-text">Reward points for purchasing this product</div>
                                        @error('points')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="location_id" class="form-label">Location</label>
                                        <select class="form-select @error('location_id') is-invalid @enderror" 
                                                id="location_id" name="location_id">
                                            <option value="">Select Location</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" 
                                                    {{ old('location_id', $product->location_id) == $location->id ? 'selected' : '' }}>
                                                    {{ $location->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('location_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <x-admin.category-selector 
                                            name="category_id" 
                                            label="Category" 
                                            :value="old('category_id', $product->category_id)" 
                                            :allowEmpty="true"
                                            emptyText="No Category" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="brand_id" class="form-label">Brand</label>
                                        <select class="form-select @error('brand_id') is-invalid @enderror" 
                                                id="brand_id" name="brand_id">
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" 
                                                    {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="product_type_id" class="form-label">Product Type</label>
                                <select class="form-select @error('product_type_id') is-invalid @enderror" 
                                        id="product_type_id" name="product_type_id">
                                    <option value="">Select Product Type</option>
                                    @foreach($productTypes as $type)
                                        <option value="{{ $type->id }}" 
                                            {{ old('product_type_id', $product->product_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Image -->
                            @if($product->image)
                            <div class="mb-4">
                                <label class="form-label">Current Image</label>
                                <div class="d-flex align-items-start gap-3">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                         class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-2">Current product image</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="mb-4">
                                <label for="image" class="form-label">
                                    @if($product->image)
                                        Replace Product Image
                                    @else
                                        Product Image
                                    @endif
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <div class="form-text">
                                    @if($product->image)
                                        Upload a new image to replace the current one
                                    @else
                                        Upload an image for the product
                                    @endif
                                    (JPEG, PNG, JPG, GIF - Max: 2MB)
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Preview -->
                            <div id="image-preview" class="mb-4" style="display: none;">
                                <label class="form-label">New Image Preview</label>
                                <div>
                                    <img id="preview-img" src="" alt="Preview" class="rounded" style="max-width: 200px; height: auto;">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>
                                    Update Product
                                </button>
                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline">
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
                                <p class="text-muted mb-0">{{ $product->name }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Price:</strong>
                                <p class="text-muted mb-0">{{ $product->formatted_price }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Points:</strong>
                                <p class="text-muted mb-0">{{ $product->points ?? 0 }} points</p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Category:</strong>
                                <p class="text-muted mb-0">
                                    @if($product->category)
                                        {{ $product->category->name }}
                                    @else
                                        Uncategorized
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Brand:</strong>
                                <p class="text-muted mb-0">
                                    @if($product->brand)
                                        {{ $product->brand->name }}
                                    @else
                                        No brand
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Location:</strong>
                                <p class="text-muted mb-0">
                                    @if($product->location)
                                        {{ $product->location->name }}
                                    @else
                                        No location
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <strong>Current Product Type:</strong>
                                <p class="text-muted mb-0">
                                    @if($product->productType)
                                        {{ $product->productType->name }}
                                    @else
                                        No type
                                    @endif
                                </p>
                            </div>
                            <div class="mb-0">
                                <strong>Has Image:</strong>
                                <p class="text-muted mb-0">
                                    @if($product->image)
                                        <i class="bi bi-check-circle text-success"></i> Yes
                                    @else
                                        <i class="bi bi-x-circle text-danger"></i> No
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
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
                                <p class="text-muted mb-0">Upload a high-quality image that clearly shows the product. The new image will replace the existing one.</p>
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