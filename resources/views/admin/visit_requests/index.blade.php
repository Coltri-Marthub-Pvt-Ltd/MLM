@extends('layouts.admin')

@section('title', 'Visit Requests')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Visit Requests</h1>
                <p class="text-muted">Manage customer visit requests</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createVisitRequestModal">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Request
            </button>
        </div>

        <!-- Visit Requests Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Visit Requests</h5>
                <p class="card-description">List of all customer visit requests</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="visitRequestsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Variant</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Sampling Tokens</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visitRequests as $request)
                                <tr>
                                    <td class="text-muted">#{{ $request->id }}</td>
                                    <td class="fw-medium">{{ $request->name }}</td>
                                    <td>{{ $request->variant }}</td>
                                    <td>{{ $request->phone }}</td>
                                    <td>{{ $request->city }}</td>
                                    <td>{{ $request->sampling_tokens }}</td>
                                    <td class="text-muted">{{ $request->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.visit-requests.show', $request) }}" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-primary edit-visit-request-btn" 
                                                    data-id="{{ $request->id }}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editVisitRequestModal"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.visit-requests.destroy', $request) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this request?')">
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
                <div class="mt-4">
                    {{ $visitRequests->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createVisitRequestModal" tabindex="-1" aria-labelledby="createVisitRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.visit-requests.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createVisitRequestModalLabel">Create New Visit Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="variant" class="form-label">Variant *</label>
                                    <input type="text" class="form-control @error('variant') is-invalid @enderror" 
                                           id="variant" name="variant" value="{{ old('variant') }}" required>
                                    @error('variant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone *</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                               <div class="mb-3">
                                    <label for="city" class="form-label">City *</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                        id="city" name="city" value="{{ old('city') }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="order_issue" class="form-label">Order Issue *</label>
                            <textarea class="form-control @error('order_issue') is-invalid @enderror" 
                                      id="order_issue" name="order_issue" rows="3" required>{{ old('order_issue') }}</textarea>
                            @error('order_issue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="sampling_tokens" class="form-label">Sampling Tokens</label>
                            <input type="text" class="form-control @error('sampling_tokens') is-invalid @enderror" 
                                   id="sampling_tokens" name="sampling_tokens" value="{{ old('sampling_tokens') }}">
                            @error('sampling_tokens')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <!-- Edit Modal -->
<div class="modal fade" id="editVisitRequestModal" tabindex="-1" aria-labelledby="editVisitRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editVisitRequestForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editVisitRequestModalLabel">Edit Visit Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_variant" class="form-label">Variant *</label>
                                <input type="text" class="form-control" id="edit_variant" name="variant" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">Phone *</label>
                                <input type="tel" class="form-control" id="edit_phone" name="phone" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                                <label for="edit_city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="edit_city" name="city" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Address *</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="2" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_order_issue" class="form-label">Order Issue *</label>
                        <textarea class="form-control" id="edit_order_issue" name="order_issue" rows="3" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_sampling_tokens" class="form-label">Sampling Tokens</label>
                        <input type="text" class="form-control" id="edit_sampling_tokens" name="sampling_tokens">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Request</button>
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
            $('#visitRequestsTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });

            // Edit button click handler
     $(document).on('click', '.edit-visit-request-btn', function() {
    var requestId = $(this).data('id');

    $.get('/admin/visit-requests/' + requestId + '/edit', function(data) {
        console.log('testing',data.name);
        $('#edit_name').val(data.name);
        $('#edit_variant').val(data.variant);
        $('#edit_phone').val(data.phone);
        $('#edit_city').val(data.city); 
        $('#edit_address').val(data.address);
        $('#edit_order_issue').val(data.order_issue);
        $('#edit_sampling_tokens').val(data.sampling_tokens);
        
        $('#editVisitRequestForm').attr('action', '/admin/visit-requests/' + requestId);
    }).fail(function(xhr) {
        console.error('Error:', xhr.responseText);
        toastr.error('Failed to load request data');
    });
});
        });
    </script>
@endpush

@push('styles')
    <style>
        <style>
        /* Loading state for modal */
        .modal-body.loading {
            position: relative;
            min-height: 200px;
            opacity: 0.5;
            pointer-events: none;
        }
        
        .modal-body.loading:after {
            content: "Loading...";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2rem;
            color: #333;
        }
        
        /* Other existing styles */
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