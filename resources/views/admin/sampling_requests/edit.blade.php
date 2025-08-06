@extends('layouts.admin')

@section('title', 'Edit Sampling Request')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4">Edit Sampling Request</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sampling-requests.index') }}">Sampling Requests</a></li>
                    <li class="breadcrumb-item active">Edit #{{ $samplingRequest->id }}</li>
                </ol>
            </div>
            <a href="{{ route('admin.sampling-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Request #{{ $samplingRequest->id }}
                </h5>
                <span class="badge bg-light text-dark">
                    Created: {{ $samplingRequest->created_at->format('M j, Y') }}
                </span>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('admin.sampling-requests.update', $samplingRequest) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <div class="form-section mb-4">
                                <h6 class="form-section-title">
                                    <i class="fas fa-user-circle me-2 text-primary"></i>Customer Information
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $samplingRequest->name) }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone', $samplingRequest->phone) }}" required>
                                </div>
                            </div>
                            
                            <div class="form-section mb-4">
                                <h6 class="form-section-title">
                                    <i class="fas fa-box-open me-2 text-success"></i>Product Details
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="variant" class="form-label">Product Variant</label>
                                    <input type="text" class="form-control" id="variant" name="variant" 
                                           value="{{ old('variant', $samplingRequest->variant) }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <div class="form-section mb-4">
                                <h6 class="form-section-title">
                                    <i class="fas fa-address-card me-2 text-info"></i>Contact Information
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="contact_details" class="form-label">Preferred Contact Details</label>
                                    <textarea class="form-control" id="contact_details" name="contact_details" 
                                              rows="3">{{ old('contact_details', $samplingRequest->contact_details) }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="visit_request" 
                                               name="visit_request" value="1" {{ old('visit_request', $samplingRequest->visit_request) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="visit_request">Requires Visit</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fas fa-sticky-note me-2 text-warning"></i>Additional Information
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="other_details" class="form-label">Other Details</label>
                                    <textarea class="form-control" id="other_details" name="other_details" 
                                              rows="3">{{ old('other_details', $samplingRequest->other_details) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4 border-top pt-4">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i> Reset Changes
                        </button>
                        <div>
                            <a href="{{ route('admin.sampling-requests.show', $samplingRequest) }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    }
    .form-section {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.25rem;
        border-left: 3px solid var(--bs-primary);
    }
    .form-section-title {
        color: var(--bs-primary);
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    .form-check-input:checked {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
    textarea.form-control {
        min-height: 100px;
    }
</style>
@endpush