@extends('layouts.admin')

@section('title', 'Deals')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Deals</h1>
                <p class="text-muted">Manage deals and promotions</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDealModal">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Deal
            </button>
        </div>

        <!-- Deals Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Deals</h5>
                <p class="card-description">List of all deals and promotions</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="dealsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Product</th>
                                <th>Date Range</th>
                                <th>Coins</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deals as $deal)
                                <tr>
                                    <td class="text-muted">#{{ $deal->id }}</td>
                                    <td>
                                        @if ($deal->image)
                                            <img src="{{ asset($deal->image) }}" alt="{{ $deal->title }}"
                                                class="img-thumbnail" width="50">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td class="fw-medium">{{ $deal->title }}</td>
                                    <td>
                                        @if ($deal->product)
                                            {{ $deal->product->name }}
                                        @else
                                            <span class="text-danger">Product not found</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">Start:
                                                {{ $deal->start_date->format('M j, Y') }}</small>
                                            <small class="text-muted">End: {{ $deal->end_date->format('M j, Y') }}</small>
                                        </div>
                                    </td>
                                    <td class="text-primary fw-bold">{{ $deal->coins }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $deal->status === 'active' ? 'success' : ($deal->status === 'inactive' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($deal->status) }}
                                        </span>
                                    </td>
                                    <td class="text-info fw-bold">{{ $deal->order_by }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-deal-btn"
                                                data-id="{{ $deal->id }}" data-title="{{ $deal->title }}"
                                                data-description="{{ $deal->description }}"
                                                data-start-date="{{ $deal->start_date->format('Y-m-d') }}"
                                                data-end-date="{{ $deal->end_date->format('Y-m-d') }}"
                                                data-product-id="{{ $deal->product_id }}" data-coins="{{ $deal->coins }}"
                                                data-status="{{ $deal->status }}" data-order-by="{{ $deal->order_by }}"
                                                data-image="{{ $deal->image ? asset($deal->image) : '' }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.deals.destroy', $deal) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this deal?')">
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

    <!-- Create Deal Modal -->
    <div class="modal fade" id="createDealModal" tabindex="-1" aria-labelledby="createDealModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="createDealForm" method="POST" action="{{ route('admin.deals.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createDealModalLabel">Add New Deal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>

                                 <div class="mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Product </label>
                                    <select class="form-select" id="product_id" name="product_id">
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                   <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date *</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="coins" class="form-label">Coins </label>
                                    <input type="number" class="form-control" id="coins" name="coins"
                                        min="0">
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="expired">Expired</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_by" class="form-label">Order *</label>
                                    <input type="number" class="form-control" id="order_by" name="order_by" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Deal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Deal Modal -->
    <div class="modal fade" id="editDealModal" tabindex="-1" aria-labelledby="editDealModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editDealForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDealModalLabel">Edit Deal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="edit_start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control" id="edit_start_date" name="start_date"
                                        required>
                                </div>
                                 <div class="mb-3">
                                    <label for="edit_title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" id="edit_title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_product_id" class="form-label">Product </label>
                                    <select class="form-select" id="edit_product_id" name="product_id">
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_end_date" class="form-label">End Date *</label>
                                    <input type="date" class="form-control" id="edit_end_date" name="end_date"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_coins" class="form-label">Coins </label>
                                    <input type="number" class="form-control" id="edit_coins" name="coins"
                                        min="0">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_status" class="form-label">Status *</label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="expired">Expired</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_order_by" class="form-label">Order *</label>
                                    <input type="number" class="form-control" id="edit_order_by" name="order_by"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="edit_image" name="image"
                                        accept="image/*">

                                    <div id="currentImageContainer" class="mt-3">
                                        <img id="currentImage" src="" class="img-thumbnail mb-2" width="100"
                                            style="display: none;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remove_image"
                                                name="remove_image">
                                            <label class="form-check-label" for="remove_image">
                                                Remove current image
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Deal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#dealsTable').DataTable({
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 2
                    },
                    {
                        responsivePriority: 3,
                        targets: -1
                    }
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-deal-btn', function() {
                var dealId = $(this).data('id');
                var dealTitle = $(this).data('title');
                var dealDescription = $(this).data('description');
                var dealStartDate = $(this).data('start-date');
                var dealEndDate = $(this).data('end-date');
                var dealProductId = $(this).data('product-id');
                var dealCoins = $(this).data('coins');
                var dealStatus = $(this).data('status');
                var dealOrderBy = $(this).data('order-by');
                var dealImage = $(this).data('image');

                // Reset form
                $('#editDealForm')[0].reset();
                $('#remove_image').prop('checked', false);

                // Set form action
                $('#editDealForm').attr('action', '/admin/deals/' + dealId);

                // Fill form fields
                $('#edit_title').val(dealTitle);
                $('#edit_description').val(dealDescription);
                $('#edit_start_date').val(dealStartDate);
                $('#edit_end_date').val(dealEndDate);
                $('#edit_product_id').val(dealProductId);
                $('#edit_coins').val(dealCoins);
                $('#edit_status').val(dealStatus);
                $('#edit_order_by').val(dealOrderBy);

                // Handle image display
                var currentImage = $('#currentImage');
                var currentImageContainer = $('#currentImageContainer');

                if (dealImage && dealImage !== '') {
                    currentImage.attr('src', dealImage).show();
                    currentImageContainer.show();
                } else {
                    currentImage.hide();
                    currentImageContainer.hide();
                }

                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editDealModal'));
                editModal.show();
            });

            // Form submission handler for create
            $('#createDealForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var url = form.attr('action');
                var submitBtn = form.find('button[type="submit"]');

                // Show loading state
                submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                    );

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Close modal
                            $('#createDealModal').modal('hide');

                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'Deal created successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        // Reset button state
                        submitBtn.prop('disabled', false).text('Save Deal');

                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message ||
                                'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });

            // Form submission handler for edit
            $('#editDealForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var url = form.attr('action');
                var submitBtn = $('#updateButton');

                // Show loading state
                submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
                    );

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Close modal
                            $('#editDealModal').modal('hide');

                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'Deal updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        // Reset button state
                        submitBtn.prop('disabled', false).text('Update Deal');

                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message ||
                                'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        .admin-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
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

        .img-thumbnail {
            max-height: 50px;
            object-fit: contain;
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
        }
    </style>
@endpush
