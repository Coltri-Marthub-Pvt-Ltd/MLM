@extends('layouts.admin')

@section('title', 'View Sampling Request')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4">Sampling Request Details</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sampling-requests.index') }}">Sampling Requests</a></li>
                    <li class="breadcrumb-item active">#{{ $samplingRequest->id }}</li>
                </ol>
            </div>
            <a href="{{ route('admin.sampling-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-box-open me-2"></i>Request #{{ $samplingRequest->id }}
                    </h5>
                </div>
                <div>
                    <span class="badge bg-light text-dark">
                        <i class="far fa-clock me-1"></i> {{ $samplingRequest->created_at->format('M j, Y \a\t g:i a') }}
                    </span>
                    <span class="badge ms-2 {{ $samplingRequest->visit_request ? 'bg-success' : 'bg-secondary' }}">
                        {{ $samplingRequest->visit_request ? 'Visit Requested' : 'No Visit' }}
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row g-4">
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <div class="card h-100 border-start border-primary border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-circle me-2 text-primary"></i>Customer Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 fw-normal text-muted">Name</dt>
                                    <dd class="col-sm-8">{{ $samplingRequest->name }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">Phone</dt>
                                    <dd class="col-sm-8">{{ $samplingRequest->phone }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">Variant</dt>
                                    <dd class="col-sm-8">{{ $samplingRequest->variant }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="col-md-6">
                        <div class="card h-100 border-start border-info border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-address-card me-2 text-info"></i>Contact Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="text-muted small">Preferred Contact Details</h6>
                                    <p class="mb-0">{{ $samplingRequest->contact_details }}</p>
                                </div>
                                
                                @if($samplingRequest->other_details)
                                <div class="mt-3 pt-3 border-top">
                                    <h6 class="text-muted small">Additional Notes</h6>
                                    <p class="mb-0">{{ $samplingRequest->other_details }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Timeline -->
                    <div class="col-12">
                        <div class="card border-start border-success border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-history me-2 text-success"></i>Request Timeline
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-point"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Request Submitted</h6>
                                            <p class="text-muted small mb-0">
                                                {{ $samplingRequest->created_at->format('M j, Y \a\t g:i a') }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($samplingRequest->updated_at->gt($samplingRequest->created_at))
                                    <div class="timeline-item">
                                        <div class="timeline-point"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Last Updated</h6>
                                            <p class="text-muted small mb-0">
                                                {{ $samplingRequest->updated_at->format('M j, Y \a\t g:i a') }}
                                                <small>({{ $samplingRequest->updated_at->diffForHumans() }})</small>
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Request ID: #{{ $samplingRequest->id }}
                </small>
                <div>
                    <a href="{{ route('admin.sampling-requests.edit', $samplingRequest) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit Request
                    </a>
                    <form method="POST" action="{{ route('admin.sampling-requests.destroy', $samplingRequest) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this request?')">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.1);
        transition: all 0.2s;
    }
    .card:hover {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.2);
    }
    .border-3 {
        border-width: 3px !important;
    }
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    .timeline-point {
        position: absolute;
        left: -1.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background-color: #2e7d32;
        top: 0.25rem;
    }
    .timeline-content {
        padding-left: 1rem;
    }
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: -1rem;
        top: 1.25rem;
        bottom: 0;
        width: 2px;
        background-color: #e0e0e0;
    }
</style>
@endpush