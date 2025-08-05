
@extends('layouts.admin')

@section('title', 'View Sampling Request')

@section('content')
    <div class="fade-in">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Sampling Request Details</h1>
                <p class="text-muted">View product sampling request information</p>
            </div>
            <a href="{{ route('admin.sampling-requests.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Back to List
            </a>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Request #{{ $samplingRequest->id }}</h5>
                <p class="card-description">Submitted on {{ $samplingRequest->created_at->format('M j, Y \a\t g:i a') }}</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="text-muted">Name</h6>
                            <p class="fw-medium">{{ $samplingRequest->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="text-muted">Variant</h6>
                            <p class="fw-medium">{{ $samplingRequest->variant }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="text-muted">Phone</h6>
                            <p class="fw-medium">{{ $samplingRequest->phone }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="text-muted">Visit Request</h6>
                            <p>
                                @if($samplingRequest->visit_request)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Contact Details</h6>
                    <p class="fw-medium">{{ $samplingRequest->contact_details }}</p>
                </div>

                @if($samplingRequest->other_details)
                    <div class="mb-4">
                        <h6 class="text-muted">Other Details</h6>
                        <p class="fw-medium">{{ $samplingRequest->other_details }}</p>
                    </div>
                @endif

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.sampling-requests.edit', $samplingRequest) }}" class="btn btn-primary me-2">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('admin.sampling-requests.destroy', $samplingRequest) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this request?')">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection