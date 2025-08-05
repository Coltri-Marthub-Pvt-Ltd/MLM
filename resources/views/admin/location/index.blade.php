@extends('layouts.admin')

@section('title', 'Locations')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Locations</h1>
                <p class="text-muted">Manage event locations</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLocationModal">
                <i class="bi bi-geo-alt me-2"></i>
                Add New Location
            </button>
        </div>

        <!-- Locations Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Locations</h5>
                <p class="card-description">List of all event locations</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="locationsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td class="text-muted">#{{ $location->id }}</td>
                                    <td class="fw-medium">{{ $location->name }}</td>
                                  
                                    <td class="text-muted">{{ $location->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-location-btn" 
                                                    data-id="{{ $location->id }}"
                                                    data-name="{{ $location->name }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this location?')">
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

    <!-- Create Location Modal -->
    <div class="modal fade" id="createLocationModal" tabindex="-1" aria-labelledby="createLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.locations.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createLocationModalLabel">Add New Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Location Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Location Modal -->
    <div class="modal fade" id="editLocationModal" tabindex="-1" aria-labelledby="editLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editLocationForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLocationModalLabel">Edit Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Location Name *</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Location</button>
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
            $('#locationsTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-location-btn', function() {
                var locationId = $(this).data('id');
                var locationName = $(this).data('name');
                
                // Reset form and errors
                $('#editLocationForm')[0].reset();
                $('#editLocationForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                
                // Set form action
                $('#editLocationForm').attr('action', '/admin/locations/' + locationId);
                
                // Fill form fields
                $('#edit_name').val(locationName);
                
                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editLocationModal'));
                editModal.show();
            });

            // Edit form submission handler
            $('#editLocationForm').on('submit', function(e) {
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
                            // Close modal and reload page
                            var modal = bootstrap.Modal.getInstance(document.getElementById('editLocationModal'));
                            modal.hide();
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        
                        submitBtn.prop('disabled', false).text('Update Location');
                        
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