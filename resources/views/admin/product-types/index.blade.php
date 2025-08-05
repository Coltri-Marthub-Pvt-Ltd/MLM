@extends('layouts.admin')

@section('title', 'Product Types')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Product Types</h1>
                <p class="text-muted">Manage product categories</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductTypeModal">
                <i class="bi bi-tags me-2"></i>
                Add New Product Type
            </button>
        </div>

        <!-- Product Types Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Product Types</h5>
                <p class="card-description">List of all product categories</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="productTypesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productTypes as $productType)
                                <tr>
                                    <td class="text-muted">#{{ $productType->id }}</td>
                                    <td class="fw-medium">{{ $productType->name }}</td>
                                    <td class="text-muted">{{ $productType->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-product-type-btn" 
                                                    data-id="{{ $productType->id }}"
                                                    data-name="{{ $productType->name }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.product-types.destroy', $productType) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this product type?')">
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

    <!-- Create Product Type Modal -->
    <div class="modal fade" id="createProductTypeModal" tabindex="-1" aria-labelledby="createProductTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.product-types.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductTypeModalLabel">Add New Product Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Type Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Product Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Type Modal -->
    <div class="modal fade" id="editProductTypeModal" tabindex="-1" aria-labelledby="editProductTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editProductTypeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductTypeModalLabel">Edit Product Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Product Type Name *</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Product Type</button>
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
            $('#productTypesTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-product-type-btn', function() {
                var productTypeId = $(this).data('id');
                var productTypeName = $(this).data('name');
                
                // Reset form and errors
                $('#editProductTypeForm')[0].reset();
                $('#editProductTypeForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                
                // Set form action
                $('#editProductTypeForm').attr('action', '/admin/product-types/' + productTypeId);
                
                // Fill form fields
                $('#edit_name').val(productTypeName);
                
                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editProductTypeModal'));
                editModal.show();
            });

            // Edit form submission handler
            $('#editProductTypeForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
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
                    success: function(response) {
                        if(response.success) {
                            // Close modal first
                            var modal = bootstrap.Modal.getInstance(document.getElementById('editProductTypeModal'));
                            modal.hide();
                            location.reload();
                            // Show success message
                            toastr.success(response.message || 'Product type updated successfully');
                            location.reload();
                            // Reload the page after a slight delay
                         
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).text('Update Product Type');
                        
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
                            toastr.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                            console.error(xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .admin-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eee;
        }
        
        .card-title {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .card-description {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 0;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .admin-table {
            width: 100%;
        }
        
        .admin-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
    </style>
        <!-- Include required CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

@endpush