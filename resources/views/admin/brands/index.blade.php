@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Brands</h1>
                <p class="text-muted">Manage product brands</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBrandModal">
                <i class="bi bi-bookmark-plus me-2"></i>
                Add New Brand
            </button>
        </div>

        <!-- Brands Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Brands</h5>
                <p class="card-description">List of all product brands</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="brandsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Products</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($brands as $brand)
                                <tr>
                                    <td class="text-muted">#{{ $brand->id }}</td>
                                    <td>
                                        @if($brand->image)
                                            <img src="{{ asset('storage/'.$brand->image) }}" alt="{{ $brand->name }}" class="img-thumbnail" width="50">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td class="fw-medium">{{ $brand->name }}</td>
                                    <td class="text-muted">{{ $brand->slug }}</td>
                                    <td class="text-muted">{{ Str::limit($brand->description, 30) }}</td>
                                    <td>
                                        @if($brand->products_count > 0)
                                            <span class="badge bg-primary">{{ $brand->products_count }} product(s)</span>
                                        @else
                                            <span class="text-muted">No products</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $brand->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-brand-btn" 
                                                    data-id="{{ $brand->id }}"
                                                    data-name="{{ $brand->name }}"
                                                    data-description="{{ $brand->description }}"
                                                    data-image="{{ $brand->image ? asset('storage/'.$brand->image) : '' }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this brand?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Brand Modal -->
    <div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="createBrandForm" method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBrandModalLabel">Add New Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Brand Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label">Brand Logo</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Brand Modal -->
    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editBrandForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_name" class="form-label">Brand Name *</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                                <div class="invalid-feedback" id="name-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_image" class="form-label">Brand Logo</label>
                                <input type="file" class="form-control" id="edit_image" name="image">
                                <div class="invalid-feedback" id="image-error"></div>
                                <div id="currentImageContainer" class="mt-2">
                                    <img id="currentImage" src="" class="img-thumbnail" width="100" style="display: none;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label" for="remove_image">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                            <div class="invalid-feedback" id="description-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include required JS libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#brandsTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 2 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-brand-btn', function() {
                var brandId = $(this).data('id');
                var brandName = $(this).data('name');
                var brandDescription = $(this).data('description');
                var brandImage = $(this).data('image');
                
                // Reset form and errors
                $('#editBrandForm')[0].reset();
                $('#editBrandForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                
                // Set form action
                $('#editBrandForm').attr('action', '/admin/brands/' + brandId);
                
                // Fill form fields
                $('#edit_name').val(brandName);
                $('#edit_description').val(brandDescription);
                
                // Handle image display
                if(brandImage && brandImage !== '') {
                    $('#currentImage').attr('src', brandImage).show();
                    $('#currentImageContainer').show();
                } else {
                    $('#currentImage').hide();
                    $('#currentImageContainer').hide();
                }
                
                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editBrandModal'));
                editModal.show();
            });

            // Edit form submission handler
            $('#editBrandForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var url = form.attr('action');
                var submitBtn = $('#updateButton');
                
                // Show loading state
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
                
                // Clear previous errors
                form.find('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.success) {
                            // Close modal and reload page
                            var modal = bootstrap.Modal.getInstance(document.getElementById('editBrandModal'));
                            modal.hide();
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).text('Update Brand');
                        
                        if(xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            for (var field in errors) {
                                var input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                $('#' + field + '-error').text(errors[field][0]);
                            }
                        } else {
                            // Other errors
                            alert('An error occurred: ' + (xhr.responseJSON?.message || 'Please try again.'));
                            console.error(xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <!-- Include required CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">


@endpush