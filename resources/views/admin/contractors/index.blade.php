@extends('layouts.admin')

@section('title', 'Contractors')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Contractors</h1>
                <p class="text-muted">Manage contractor registrations and verifications</p>
            </div>
            @can('manage_contractors')
            <a href="{{ route('admin.contractors.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i>
                Add New Contractor
            </a>
            @endcan
        </div>

        <!-- Filters -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="{{ route('admin.contractors.index') }}" class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="search" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search by name, email, phone..."
                        >
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Verification Filter -->
                    <div class="col-md-2">
                        <label for="verification" class="form-label">Verification</label>
                        <select class="form-select" id="verification" name="verification">
                            <option value="">All Verification</option>
                            <option value="verified" {{ request('verification') === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="pending" {{ request('verification') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">From Date</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="date_from" 
                            name="date_from" 
                            value="{{ request('date_from') }}"
                        >
                    </div>

                    <!-- Date To -->
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">To Date</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="date_to" 
                            name="date_to" 
                            value="{{ request('date_to') }}"
                        >
                    </div>

                    <!-- Filter Actions -->
                    <div class="col-md-1 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request()->hasAny(['search', 'status', 'verification', 'date_from', 'date_to']))
                                <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline btn-sm" title="Clear Filters">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contractors Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Contractors</h5>
                <p class="card-description">
                    @if(request()->hasAny(['search', 'status', 'verification', 'date_from', 'date_to']))
                        {{ $contractors->total() }} contractors found with current filters
                        <a href="{{ route('admin.contractors.index') }}" class="text-decoration-none ms-2">
                            <i class="bi bi-x-circle"></i> Clear filters
                        </a>
                    @else
                        {{ $contractors->total() }} contractors found
                    @endif
                </p>
            </div>
            
            @if($contractors->count() > 0)
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Documents</th>
                                <th>Status</th>
                                <th>Verification</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contractors as $contractor)
                                <tr>
                                    <td class="text-muted">#{{ $contractor->id }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $contractor->name }}</div>
                                        <div class="text-muted small">Age: {{ $contractor->age }} years</div>
                                    </td>
                                    <td>
                                        <div class="text-muted">{{ $contractor->email }}</div>
                                        <div class="text-muted small">{{ $contractor->phone }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted small">
                                            Aadhar: {{ substr($contractor->aadhar_card, 0, 4) }}****{{ substr($contractor->aadhar_card, -4) }}
                                        </div>
                                        <div class="text-muted small">
                                            PAN: {{ $contractor->pan_card }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $contractor->isActive() ? 'primary' : 'secondary' }}">
                                            {{ $contractor->isActive() ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($contractor->isVerified())
                                            <span class="badge badge-primary">Verified</span>
                                            <div class="text-muted small">
                                                by {{ $contractor->verifiedBy->name ?? 'Unknown' }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $contractor->verified_at->format('M j, Y') }}
                                            </div>
                                        @else
                                            <span class="badge badge-secondary">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $contractor->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.contractors.show', $contractor) }}" class="btn btn-sm btn-outline" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('manage_contractors')
                                            <a href="{{ route('admin.contractors.edit', $contractor) }}" class="btn btn-sm btn-outline" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            


                                            <form method="POST" action="{{ route('admin.contractors.destroy', $contractor) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-destructive" title="Delete" 
                                                        data-confirm="Are you sure you want to delete this contractor? This action cannot be undone.">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($contractors->hasPages())
                    <div class="card-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $contractors->firstItem() }} to {{ $contractors->lastItem() }} of {{ $contractors->total() }} results
                            </div>
                            {{ $contractors->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-person-badge text-muted mb-3" style="font-size: 4rem;"></i>
                        @if(request()->hasAny(['search', 'status', 'verification', 'date_from', 'date_to']))
                            <h5 class="text-muted mb-3">No Contractors Found</h5>
                            <p class="text-muted mb-4">No contractors match your current filters. Try adjusting your search criteria.</p>
                            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline">
                                <i class="bi bi-x-circle me-2"></i>
                                Clear All Filters
                            </a>
                        @else
                            <h5 class="text-muted mb-3">No Contractors Found</h5>
                            <p class="text-muted mb-4">There are no contractors in the system yet.</p>
                            @can('manage_contractors')
                            <a href="{{ route('admin.contractors.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus me-2"></i>
                                Add First Contractor
                            </a>
                            @endcan
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 