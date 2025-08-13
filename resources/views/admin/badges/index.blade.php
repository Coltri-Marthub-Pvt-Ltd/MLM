@extends('layouts.admin')

@section('title', 'Badges')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Badges</h1>
                <p class="text-muted">Manage achievement badges</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBadgeModal">
                <i class="bi bi-award me-2"></i>
                Add New Badge
            </button>
        </div>

        <!-- Badges Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Badges</h5>
                <p class="card-description">List of all achievement badges</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="badgesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Coins</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($badges as $badge)
                                <tr>
                                    <td class="text-muted">#{{ $badge->id }}</td>
                                    <td>
                                        @if($badge->image)
                                            <img src="{{ asset($badge->image) }}" alt="{{ $badge->name }}" class="img-thumbnail" width="50">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td class="fw-medium">{{ $badge->name }}</td>
                                    <td class="text-primary fw-bold">{{ $badge->coins }}</td>
                                    <td class="text-muted">{{ $badge->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-badge-btn" 
                                                    data-id="{{ $badge->id }}"
                                                    data-name="{{ $badge->name }}"
                                                    data-coins="{{ $badge->coins }}"
                                                    data-image="{{ $badge->image ? asset($badge->image) : '' }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.badges.destroy', $badge) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this badge?')">
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

    <!-- Create Badge Modal -->
    <div class="modal fade" id="createBadgeModal" tabindex="-1" aria-labelledby="createBadgeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createBadgeForm" method="POST" action="{{ route('admin.badges.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBadgeModalLabel">Add New Badge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Badge Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="coins" class="form-label">Coins Reward *</label>
                            <input type="number" class="form-control @error('coins') is-invalid @enderror" id="coins" name="coins" min="0" required>
                            @error('coins')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Badge Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Badge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Badge Modal -->
    <div class="modal fade" id="editBadgeModal" tabindex="-1" aria-labelledby="editBadgeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editBadgeForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBadgeModalLabel">Edit Badge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Badge Name *</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_coins" class="form-label">Coins Reward *</label>
                            <input type="number" class="form-control" id="edit_coins" name="coins" min="0" required>
                            <div class="invalid-feedback" id="coins-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Badge Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                            <div class="invalid-feedback" id="image-error"></div>
                            
                            <div id="currentImageContainer" class="mt-3">
                                <img id="currentImage" src="" class="img-thumbnail mb-2" width="100" style="display: none;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                    <label class="form-check-label" for="remove_image">
                                        Remove current image
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Badge</button>
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
            $('#badgesTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 2 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-badge-btn', function() {
                var badgeId = $(this).data('id');
                var badgeName = $(this).data('name');
                var badgeCoins = $(this).data('coins');
                var badgeImage = $(this).data('image');
                
                // Reset form and errors
                $('#editBadgeForm')[0].reset();
                $('#editBadgeForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#remove_image').prop('checked', false);
                
                // Set form action
                $('#editBadgeForm').attr('action', '/admin/badges/' + badgeId);
                
                // Fill form fields
                $('#edit_name').val(badgeName);
                $('#edit_coins').val(badgeCoins);
                
                // Handle image display
                var currentImage = $('#currentImage');
                var currentImageContainer = $('#currentImageContainer');
                
                if(badgeImage && badgeImage !== '') {
                    currentImage.attr('src', badgeImage).show();
                    currentImageContainer.show();
                } else {
                    currentImage.hide();
                    currentImageContainer.hide();
                }
                
                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editBadgeModal'));
                editModal.show();
            });

            // Form submission handler for create
            $('#createBadgeForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var url = form.attr('action');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.success) {
                            // Close modal and reload page
                            $('#createBadgeModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'Badge created successfully',
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            for (var field in errors) {
                                var input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').text(errors[field][0]);
                            }
                        } else {
                            // Other errors
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'An error occurred. Please try again.',
                            });
                            console.error(xhr.responseText);
                        }
                    }
                });
            });

            // Form submission handler for edit
            $('#editBadgeForm').on('submit', function(e) {
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
                            // Close modal first
                            var modal = bootstrap.Modal.getInstance(document.getElementById('editBadgeModal'));
                            modal.hide();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'Badge updated successfully',
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).text('Update Badge');
                        
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'An error occurred. Please try again.',
                            });
                            console.error(xhr.responseText);
                        }
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
        
        .img-thumbnail {
            max-height: 50px;
            object-fit: contain;
            background-color: #f8f9fa;
        }
    </style>
@endpush