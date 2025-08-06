@extends('layouts.admin')

@section('title', 'Visit Request Details')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4">Visit Request Details</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.visit-requests.index') }}">Visit Requests</a></li>
                    <li class="breadcrumb-item active">#{{ $visitRequest->id }}</li>
                </ol>
            </div>
            <div>
                <a href="{{ route('admin.visit-requests.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i>Visit Request #{{ $visitRequest->id }}
                </h5>
                <span class="badge bg-light text-dark">
                    <i class="far fa-clock me-1"></i> {{ $visitRequest->created_at->format('M j, Y \a\t g:i a') }}
                </span>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <!-- Customer Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-start border-primary border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-circle me-2 text-primary"></i>Customer Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 fw-normal text-muted">Name</dt>
                                    <dd class="col-sm-8">{{ $visitRequest->name }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">Phone</dt>
                                    <dd class="col-sm-8">{{ $visitRequest->phone }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">City</dt>
                                    <dd class="col-sm-8">{{ $visitRequest->city }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-start border-success border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-box-open me-2 text-success"></i>Order Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 fw-normal text-muted">Variant</dt>
                                    <dd class="col-sm-8">{{ $visitRequest->variant }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">Sampling Tokens</dt>
                                    <dd class="col-sm-8">{{ $visitRequest->sampling_tokens ?? 'N/A' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Address -->
                    <div class="col-12 mb-4">
                        <div class="card border-start border-info border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-map-marker-alt me-2 text-info"></i>Address Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0 font-monospace">{{ $visitRequest->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Issue -->
                    <div class="col-12 mb-4">
                        <div class="card border-start border-warning border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-exclamation-circle me-2 text-warning"></i>Order Issue Description
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($visitRequest->order_issue)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
                <small class="text-muted">
                    <i class="far fa-clock me-1"></i> Last updated: {{ $visitRequest->updated_at->diffForHumans() }}
                </small>
                <div>
                    <a href="{{ route('admin.visit-requests.edit', $visitRequest) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.visit-requests.destroy', $visitRequest) }}" class="d-inline">
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
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .border-3 {
        border-width: 3px !important;
    }
    dt {
        font-weight: 500;
    }
    .font-monospace {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>
@endpush