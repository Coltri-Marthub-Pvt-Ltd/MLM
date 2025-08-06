@extends('layouts.admin')

@section('title', 'Monthly Targets')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Monthly Targets</h1>
                <p class="text-muted">Manage monthly targets for users</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTargetModal">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Target
            </button>
        </div>

        <!-- Targets Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Monthly Targets</h5>
                <p class="card-description">List of all monthly targets</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="targetsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Target</th>
                                <th>Date</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($targets as $target)
                                <tr>
                                    <td class="text-muted">#{{ $target->id }}</td>
                                    <td>{{ $target->user->name }}</td>
                                    <td class="fw-bold text-primary">{{ number_format($target->target, 2) }}</td>
                                    <td>{{ $target->date->format('M Y') }}</td>
                                    <td class="text-muted">{{ $target->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary edit-target-btn" 
                                                    data-id="{{ $target->id }}"
                                                    data-user_id="{{ $target->user_id }}"
                                                    data-target="{{ $target->target }}"
                                                    data-date="{{ $target->date->format('Y-m') }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.monthly-targets.destroy', $target) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this target?')">
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

    <!-- Create Target Modal -->
    <div class="modal fade" id="createTargetModal" tabindex="-1" aria-labelledby="createTargetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createTargetForm" method="POST" action="{{ route('admin.monthly-targets.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTargetModalLabel">Add New Monthly Target</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User *</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="target" class="form-label">Target Amount *</label>
                            <input type="number" step="0.01" class="form-control @error('target') is-invalid @enderror" 
                                   id="target" name="target" required>
                            @error('target')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Month *</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('date') is-invalid @enderror" 
                                       id="date" name="date" required
                                       placeholder="Select month">
                                <span class="input-group-text cursor-pointer" id="datePickerTrigger">
                                    <i class="bi bi-calendar"></i>
                                </span>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Target</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Target Modal -->
    <div class="modal fade" id="editTargetModal" tabindex="-1" aria-labelledby="editTargetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editTargetForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTargetModalLabel">Edit Monthly Target</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_user_id" class="form-label">User *</label>
                            <select class="form-select" id="edit_user_id" name="user_id" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="user_id-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_target" class="form-label">Target Amount *</label>
                            <input type="number" step="0.01" class="form-control" 
                                   id="edit_target" name="target" required>
                            <div class="invalid-feedback" id="target-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_date" class="form-label">Month *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" 
                                       id="edit_date" name="date" required
                                       placeholder="Select month">
                                <span class="input-group-text cursor-pointer" id="editDatePickerTrigger">
                                    <i class="bi bi-calendar"></i>
                                </span>
                                <div class="invalid-feedback" id="date-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Target</button>
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
    
    <!-- Flatpickr with month select -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

    <script>
        // Initialize when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            $('#targetsTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Initialize date picker for create form
            const createDatePicker = flatpickr("#date", {
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "Y-m",
                        altFormat: "F Y",
                        theme: "light"
                    })
                ],
                allowInput: true
            });

            // Trigger date picker when icon is clicked
            document.getElementById('datePickerTrigger').addEventListener('click', function() {
                createDatePicker.toggle();
            });

            // Initialize date picker for edit form
            let editDatePicker;
            
            // Edit button click handler
            $(document).on('click', '.edit-target-btn', function() {
                var targetId = $(this).data('id');
                var userId = $(this).data('user_id');
                var target = $(this).data('target');
                var date = $(this).data('date');
                
                // Reset form and errors
                $('#editTargetForm')[0].reset();
                $('#editTargetForm .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                
                // Set form action
                $('#editTargetForm').attr('action', '/admin/monthly-targets/' + targetId);
                
                // Fill form fields
                $('#edit_user_id').val(userId);
                $('#edit_target').val(target);
                
                // Initialize or reinitialize the date picker
                if (editDatePicker) {
                    editDatePicker.destroy();
                }
                
                editDatePicker = flatpickr("#edit_date", {
                    plugins: [
                        new monthSelectPlugin({
                            shorthand: true,
                            dateFormat: "Y-m",
                            altFormat: "F Y",
                            theme: "light"
                        })
                    ],
                    allowInput: true,
                    defaultDate: date
                });
                
                // Set the date value
                $('#edit_date').val(date);
                
                // Trigger date picker when icon is clicked
                document.getElementById('editDatePickerTrigger').addEventListener('click', function() {
                    editDatePicker.toggle();
                });
                
                // Initialize and show modal
                var editModal = new bootstrap.Modal(document.getElementById('editTargetModal'));
                editModal.show();
            });

            // Form submission handler for create
            $('#createTargetForm').on('submit', function(e) {
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
                            $('#createTargetModal').modal('hide');
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'Target created successfully',
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
                        submitBtn.prop('disabled', false).text('Save Target');
                        
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
            $('#editTargetForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
                var url = form.attr('action');
                var submitBtn = $('#updateButton');
                
                // Show loading state
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.success) {
                            // Close modal
                            $('#editTargetModal').modal('hide');
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message || 'Target updated successfully',
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
                        submitBtn.prop('disabled', false).text('Update Target');
                        
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