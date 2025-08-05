// resources/views/admin/sampling_requests/index.blade.php

@extends('layouts.admin')

@section('title', 'Sampling Requests')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Sampling Requests</h1>
                <p class="text-muted">Manage product sampling requests</p>
            </div>
            <a href="{{ route('admin.sampling-requests.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Request
            </a>
        </div>

        <!-- Requests Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Sampling Requests</h5>
                <p class="card-description">List of all product sampling requests</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="requestsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Variant</th>
                                <th>Phone</th>
                                <th>Visit Request</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td class="text-muted">#{{ $request->id }}</td>
                                    <td class="fw-medium">{{ $request->name }}</td>
                                    <td class="text-muted">{{ $request->variant }}</td>
                                    <td class="text-muted">{{ $request->phone }}</td>
                                    <td>
                                        @if($request->visit_request)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $request->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.sampling-requests.edit', $request) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.sampling-requests.show', $request) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.sampling-requests.destroy', $request) }}" class="d-inline">
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#requestsTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: -1 }
                ]
            });
        });
    </script>
@endpush