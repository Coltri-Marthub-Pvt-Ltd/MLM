@extends('layouts.admin')

@section('title', 'View Git Distributed')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mt-4">Git Distributed Details</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.git-distributeds.index') }}">Git Distributeds</a></li>
                    <li class="breadcrumb-item active">#{{ $gitDistributed->id }}</li>
                </ol>
            </div>
            <a href="{{ route('admin.git-distributeds.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="fas fa-code-branch me-2"></i>Git Distributed #{{ $gitDistributed->id }}
                </h5>
                <span class="badge bg-light text-dark">
                    <i class="far fa-calendar me-1"></i> {{ $gitDistributed->created_at->format('M j, Y') }}
                </span>
            </div>
            
            <div class="card-body">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="card h-100 border-start border-primary border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Basic Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4 fw-normal text-muted">Name</dt>
                                    <dd class="col-sm-8">{{ $gitDistributed->name }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">Date</dt>
                                    <dd class="col-sm-8">{{ $gitDistributed->date->format('M j, Y') }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">City</dt>
                                    <dd class="col-sm-8">{{ $gitDistributed->city }}</dd>

                                    <dt class="col-sm-4 fw-normal text-muted">Location</dt>
                                    <dd class="col-sm-8">{{ $gitDistributed->location->name }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image Preview -->
                    <div class="col-md-6">
                        <div class="card h-100 border-start border-info border-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-image me-2 text-info"></i>Image Preview
                                </h6>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if($gitDistributed->image)
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('storage/' . $gitDistributed->image) }}" 
                                             class="img-fluid rounded" 
                                             style="max-height: 200px; width: auto;"
                                             alt="Git Distributed Image">
                                    </div>
                                    <div class="mt-auto">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i> 
                                            Click image to view full size
                                        </small>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-image fa-3x mb-3"></i>
                                        <p>No image available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i> 
                    Last updated: {{ $gitDistributed->updated_at->diffForHumans() }}
                </small>
                <div>
                    <a href="{{ route('admin.git-distributeds.edit', $gitDistributed) }}" 
                       class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form method="POST" 
                          action="{{ route('admin.git-distributeds.destroy', $gitDistributed) }}" 
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this item?')">
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
    dt {
        font-weight: 500;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add click handler for image preview modal
    $(document).ready(function() {
        $('img[src*="/storage/"]').on('click', function() {
            var imgSrc = $(this).attr('src');
            $('#imagePreviewModal').find('.modal-body img').attr('src', imgSrc);
            $('#imagePreviewModal').modal('show');
        });
    });
</script>
@endpush

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" class="img-fluid" alt="Preview">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>