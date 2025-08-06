
@extends('layouts.admin')

@section('title', 'Complaints')

@section('content')
<style>
    /* For photo gallery thumbnails */
.img-thumbnail {
    transition: transform 0.2s;
}

.img-thumbnail:hover {
    transform: scale(1.05);
    cursor: pointer;
}

/* For photo delete button positioning */
.position-relative .btn {
    transform: translate(50%, -50%);
    padding: 0.25rem 0.5rem;
}

/* For date input */
input[type="date"] {
    padding: 0.375rem 0.75rem;
}
</style>
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Complaints</h1>
                <p class="text-muted">Manage customer complaints</p>
            </div>
            <a href="{{ route('admin.complaints.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Complaint
            </a>
        </div>

        <!-- Complaints Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Complaints</h5>
                <p class="card-description">List of all customer complaints</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="complaintsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Supplied Material</th>
                                <th>Date</th>
                                <th>City</th>
                                <th>Visit Request</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaints as $complaint)
                                <tr>
                                    <td class="text-muted">#{{ $complaint->id }}</td>
                                    <td class="fw-medium">{{ $complaint->name }}</td>
                                    <td class="text-muted">{{ $complaint->supplied_material }}</td>
                                    <td class="text-muted">{{ $complaint->date->format('d-M-Y') }}</td>
                                    <td class="text-muted">{{ $complaint->city }}</td>
                                    <td>
                                        @if($complaint->visit_request)
                                            <span class="badge bg-success">YES</span>
                                        @else
                                            <span class="badge bg-secondary">NO</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.complaints.edit', $complaint) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.complaints.destroy', $complaint) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this complaint?')">
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
            $('#complaintsTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: -1 }
                ],
                order: [[3, 'desc']] // Sort by date descending
            });
        });
    </script>
@endpush