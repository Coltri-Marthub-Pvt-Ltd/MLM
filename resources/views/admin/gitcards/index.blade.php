@extends('layouts.admin')

@section('title', 'GitCards')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">GitCards</h1>
                <p class="text-muted">Manage GitCard rewards</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGitCardModal">
                <i class="bi bi-credit-card me-2"></i>
                Add New GitCard
            </button>
        </div>

        <!-- GitCards Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All GitCards</h5>
                <p class="card-description">List of all GitCard rewards</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="gitCardsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Coins</th>
                                <th>Order</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gitcards as $gitcard)
                                <tr>
                                    <td class="text-muted">#{{ $gitcard->id }}</td>
                                    <td>
                                        @if($gitcard->image)
                                            <img src="{{ asset($gitcard->image) }}" alt="{{ $gitcard->name }}" class="img-thumbnail" width="50">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td class="fw-medium">{{ $gitcard->name }}</td>
                                    <td class="text-muted">{{ Str::limit($gitcard->description, 30) }}</td>
                                    <td class="text-primary fw-bold">{{ $gitcard->coins }}</td>
                                    <td class="text-info fw-bold">{{ $gitcard->orderBY }}</td>
                                    <td class="text-muted">{{ $gitcard->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-gitcard-btn" 
                                                    data-id="{{ $gitcard->id }}"
                                                    data-name="{{ $gitcard->name }}"
                                                    data-description="{{ $gitcard->description }}"
                                                    data-coins="{{ $gitcard->coins }}"
                                                    data-orderby="{{ $gitcard->orderBY }}"
                                                    data-image="{{ $gitcard->image ? asset($gitcard->image) : '' }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.gitcards.destroy', $gitcard) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this GitCard?')">
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

    <!-- Create GitCard Modal -->
    <div class="modal fade" id="createGitCardModal" tabindex="-1" aria-labelledby="createGitCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="createGitCardForm" method="POST" action="{{ route('admin.gitcards.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createGitCardModalLabel">Add New GitCard</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="coins" class="form-label">Coins *</label>
                                    <input type="number" class="form-control @error('coins') is-invalid @enderror" id="coins" name="coins" min="0" required>
                                    @error('coins')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="orderBY" class="form-label">Order *</label>
                                    <input type="number" class="form-control @error('orderBY') is-invalid @enderror" id="orderBY" name="orderBY" required>
                                    @error('orderBY')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                        <button type="submit" class="btn btn-primary">Save GitCard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit GitCard Modal -->
    <div class="modal fade" id="editGitCardModal" tabindex="-1" aria-labelledby="editGitCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editGitCardForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGitCardModalLabel">Edit GitCard</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Name *</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                    <div class="invalid-feedback" id="name-error"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_coins" class="form-label">Coins *</label>
                                    <input type="number" class="form-control" id="edit_coins" name="coins" min="0" required>
                                    <div class="invalid-feedback" id="coins-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_orderBY" class="form-label">Order *</label>
                                    <input type="number" class="form-control" id="edit_orderBY" name="orderBY" required>
                                    <div class="invalid-feedback" id="orderBY-error"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_image" class="form-label">Image</label>
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
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                            <div class="invalid-feedback" id="description-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update GitCard</button>
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#gitCardsTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 2 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-gitcard-btn', function() {
                var gitcardId = $(this).data('id');
                var gitcardName = $(this).data('name');
                var gitcardDescription = $(this).data('description');
                var gitcardCoins = $(this).data('coins');
                var gitcardOrderBY = $(this).data('orderby');
                var gitcardImage = $(this).data('image');
                
                // Reset form and errors
                $('#editGitCardForm')[0].reset();
                $('#editGitCardForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#remove_image').prop('checked', false);
                
                // Set form action
                $('#editGitCardForm').attr('action', '/admin/gitcards/' + gitcardId);
                
                // Fill form fields
                $('#edit_name').val(gitcardName);
                $('#edit_description').val(gitcardDescription);
                $('#edit_coins').val(gitcardCoins);
                $('#edit_orderBY').val(gitcardOrderBY);
                
                // Handle image display
                var currentImage = $('#currentImage');
                var currentImageContainer = $('#currentImageContainer');
                
                if(gitcardImage && gitcardImage !== '') {
                    currentImage.attr('src', gitcardImage).show();
                    currentImageContainer.show();
                } else {
                    currentImage.hide();
                    currentImageContainer.hide();
                }
                
                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editGitCardModal'));
                editModal.show();
            });

            // Form submission handler for create
            $('#createGitCardForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var url = form.attr('action');
                var submitBtn = form.find('button[type="submit"]');
                
                // Show loading state
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.success) {
                            // Close modal
                            $('#createGitCardModal').modal('hide');
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'GitCard created successfully',
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
                        submitBtn.prop('disabled', false).text('Save GitCard');
                        
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
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'An error occurred. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            console.error(xhr.responseText);
                        }
                    }
                });
            });

            // Form submission handler for edit
            $('#editGitCardForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var url = form.attr('action');
                var submitBtn = $('#updateButton');
                
                // Show loading state
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.success) {
                            // Close modal
                            $('#editGitCardModal').modal('hide');
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'GitCard updated successfully',
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
                        submitBtn.prop('disabled', false).text('Update GitCard');
                        
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
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'An error occurred. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
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