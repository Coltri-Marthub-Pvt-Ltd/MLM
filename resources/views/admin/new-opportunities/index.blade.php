@extends('layouts.admin')

@section('title', 'New Opportunities')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">New Opportunities</h1>
                <p class="text-muted">Manage new opportunities</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNewOpportunityModal">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Opportunity
            </button>
        </div>

        <!-- New Opportunities Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All New Opportunities</h5>
                <p class="card-description">List of all new opportunities</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="newOpportunitiesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Badge</th>
                                <th>Location</th>
                                <th>Project Name</th>
                                <th>Area (sqr/ft)</th>
                                <th>Client Name</th>
                                <th>Client Phone</th>
                                <th>Order</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($opportunities as $opportunity)
                                <tr>
                                    <td class="text-muted">#{{ $opportunity->id }}</td>
                                    <td>{{ $opportunity->badge->name }}</td>
                                    <td>{{ $opportunity->location->name }}</td>
                                    <td class="fw-medium">{{ $opportunity->project_name }}</td>
                                    <td class="text-muted">{{ $opportunity->area }}</td>
                                    <td>{{ $opportunity->client_name }}</td>
                                    <td>{{ $opportunity->client_phone }}</td>
                                    <td class="text-info fw-bold">{{ $opportunity->order }}</td>
                                    <td class="text-muted">{{ $opportunity->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-new-opportunity-btn" 
                                                    data-id="{{ $opportunity->id }}"
                                                    data-badge_id="{{ $opportunity->badge_id }}"
                                                    data-location_id="{{ $opportunity->location_id }}"
                                                    data-project_name="{{ $opportunity->project_name }}"
                                                    data-area="{{ $opportunity->area }}"
                                                    data-client_name="{{ $opportunity->client_name }}"
                                                    data-client_phone="{{ $opportunity->client_phone }}"
                                                    data-order="{{ $opportunity->order }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.new-opportunities.destroy', $opportunity) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this opportunity?')">
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

    <!-- Create New Opportunity Modal -->
    <div class="modal fade" id="createNewOpportunityModal" tabindex="-1" aria-labelledby="createNewOpportunityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="createNewOpportunityForm" method="POST" action="{{ route('admin.new-opportunities.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNewOpportunityModalLabel">Add New Opportunity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="badge_id" class="form-label">Badge *</label>
                                    <select class="form-control @error('badge_id') is-invalid @enderror" id="badge_id" name="badge_id" required>
                                        <option value="">Select Badge</option>
                                        @foreach($badges as $badge)
                                            <option value="{{ $badge->id }}" {{ old('badge_id') == $badge->id ? 'selected' : '' }}>{{ $badge->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('badge_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location_id" class="form-label">Location *</label>
                                    <select class="form-control @error('location_id') is-invalid @enderror" id="location_id" name="location_id" required>
                                        <option value="">Select Location</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
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
                                <div class="mb-3">
                                    <label for="project_name" class="form-label">Project Name *</label>
                                    <input type="text" class="form-control @error('project_name') is-invalid @enderror" id="project_name" name="project_name" value="{{ old('project_name') }}" required>
                                    @error('project_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="area" class="form-label">Area (sqr/ft) *</label>
                                    <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area') }}" required>
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_name" class="form-label">Client Name *</label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_phone" class="form-label">Client Phone *</label>
                                    <input type="text" class="form-control @error('client_phone') is-invalid @enderror" id="client_phone" name="client_phone" value="{{ old('client_phone') }}" required>
                                    @error('client_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="order" class="form-label">Order *</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order') }}" required>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Opportunity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit New Opportunity Modal -->
    <div class="modal fade" id="editNewOpportunityModal" tabindex="-1" aria-labelledby="editNewOpportunityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editNewOpportunityForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNewOpportunityModalLabel">Edit Opportunity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_badge_id" class="form-label">Badge *</label>
                                    <select class="form-control" id="edit_badge_id" name="badge_id" required>
                                        <option value="">Select Badge</option>
                                        @foreach($badges as $badge)
                                            <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="badge_id-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_location_id" class="form-label">Location *</label>
                                    <select class="form-control" id="edit_location_id" name="location_id" required>
                                        <option value="">Select Location</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="location_id-error"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_project_name" class="form-label">Project Name *</label>
                                    <input type="text" class="form-control" id="edit_project_name" name="project_name" required>
                                    <div class="invalid-feedback" id="project_name-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_area" class="form-label">Area (sqr/ft) *</label>
                                    <input type="text" class="form-control" id="edit_area" name="area" required>
                                    <div class="invalid-feedback" id="area-error"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_client_name" class="form-label">Client Name *</label>
                                    <input type="text" class="form-control" id="edit_client_name" name="client_name" required>
                                    <div class="invalid-feedback" id="client_name-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_client_phone" class="form-label">Client Phone *</label>
                                    <input type="text" class="form-control" id="edit_client_phone" name="client_phone" required>
                                    <div class="invalid-feedback" id="client_phone-error"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_order" class="form-label">Order *</label>
                            <input type="number" class="form-control" id="edit_order" name="order" required>
                            <div class="invalid-feedback" id="order-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Opportunity</button>
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
            $('#newOpportunitiesTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 3 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-new-opportunity-btn', function() {
                var opportunityId = $(this).data('id');
                var badgeId = $(this).data('badge_id');
                var locationId = $(this).data('location_id');
                var projectName = $(this).data('project_name');
                var area = $(this).data('area');
                var clientName = $(this).data('client_name');
                var clientPhone = $(this).data('client_phone');
                var order = $(this).data('order');
                
                // Reset form and errors
                $('#editNewOpportunityForm')[0].reset();
                $('#editNewOpportunityForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                
                // Set form action
                $('#editNewOpportunityForm').attr('action', '/admin/new-opportunities/' + opportunityId);
                
                // Fill form fields
                $('#edit_badge_id').val(badgeId);
                $('#edit_location_id').val(locationId);
                $('#edit_project_name').val(projectName);
                $('#edit_area').val(area);
                $('#edit_client_name').val(clientName);
                $('#edit_client_phone').val(clientPhone);
                $('#edit_order').val(order);
                
                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editNewOpportunityModal'));
                editModal.show();
            });

            // Form submission handler for create
            $('#createNewOpportunityForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
                var url = form.attr('action');
                var submitBtn = form.find('button[type="submit"]');
                
                // Show loading state
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.success) {
                            // Close modal
                            $('#createNewOpportunityModal').modal('hide');
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'New Opportunity created successfully',
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
                        submitBtn.prop('disabled', false).text('Save Opportunity');
                        
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
           // Form submission handler for create
$('#createNewOpportunityForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    var url = form.attr('action');
    var submitBtn = form.find('button[type="submit"]');
    var modal = $('#createNewOpportunityModal');
    
    // Show loading state
    submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function(response) {
            if(response.success) {
                // Close modal first
                modal.modal('hide');
                
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: response.message || 'New Opportunity created successfully',
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
            submitBtn.prop('disabled', false).text('Save Opportunity');
            
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
            }
        },
        complete: function() {
            // Ensure button is reset if request completes (success or error)
            submitBtn.prop('disabled', false).text('Save Opportunity');
        }
    });
});

// Form submission handler for edit
$('#editNewOpportunityForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    var url = form.attr('action');
    var submitBtn = $('#updateButton');
    var modal = $('#editNewOpportunityModal');
    
    // Show loading state
    submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function(response) {
            if(response.success) {
                // Close modal first
                modal.modal('hide');
                
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: response.message || 'Opportunity updated successfully',
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
            submitBtn.prop('disabled', false).text('Update Opportunity');
            
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
            }
        },
        complete: function() {
            // Ensure button is reset if request completes (success or error)
            submitBtn.prop('disabled', false).text('Update Opportunity');
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