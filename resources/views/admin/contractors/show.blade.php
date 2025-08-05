@extends('layouts.admin')

@section('title', 'Contractor Details')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Contractor Details</h1>
                <p class="text-muted">View contractor information and verification status</p>
            </div>
            <div class="d-flex gap-2">
                @can('manage_contractors')
                <a href="{{ route('admin.contractors.edit', $contractor) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Contractor
                </a>
                @endcan
                <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Contractors
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Contractor Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Contractor Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Full Name</label>
                                    <div class="fw-medium">{{ $contractor->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Email Address</label>
                                    <div>{{ $contractor->email }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Phone Number</label>
                                    <div>{{ $contractor->phone }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Date of Birth</label>
                                    <div>{{ $contractor->date_of_birth->format('F j, Y') }} ({{ $contractor->age }} years old)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Contractor ID</label>
                                    <div class="fw-medium">#{{ $contractor->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Registration Date</label>
                                    <div>{{ $contractor->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <div>{{ $contractor->updated_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Age Eligibility</label>
                                    <div>
                                        @if($contractor->isEligible())
                                            <span class="badge badge-primary">Eligible (18+)</span>
                                        @else
                                            <span class="badge badge-danger">Under 18</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Address</label>
                            <div>{{ $contractor->address }}</div>
                        </div>
                    </div>
                </div>

                <!-- Document Information -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Document Information</h5>
                        <p class="card-description">Identity verification documents</p>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-card-text text-primary me-2"></i>
                                        <h6 class="mb-0">Aadhar Card</h6>
                                    </div>
                                    <div class="text-muted small mb-2">
                                        {{ substr($contractor->aadhar_card, 0, 4) }}****{{ substr($contractor->aadhar_card, -4) }}
                                    </div>
                                    @if($contractor->aadhar_photo)
                                        <a href="{{ Storage::url($contractor->aadhar_photo) }}" target="_blank" class="btn btn-sm btn-outline">
                                            <i class="bi bi-eye me-1"></i>
                                            View Photo
                                        </a>
                                    @else
                                        <span class="text-muted small">No photo uploaded</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-card-text text-primary me-2"></i>
                                        <h6 class="mb-0">PAN Card</h6>
                                    </div>
                                    <div class="text-muted small mb-2">
                                        {{ $contractor->pan_card }}
                                    </div>
                                    @if($contractor->pan_photo)
                                        <a href="{{ Storage::url($contractor->pan_photo) }}" target="_blank" class="btn btn-sm btn-outline">
                                            <i class="bi bi-eye me-1"></i>
                                            View Photo
                                        </a>
                                    @else
                                        <span class="text-muted small">No photo uploaded</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contractor Hierarchy -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Contractor Hierarchy</h5>
                        <p class="card-description">Referral relationships and network</p>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <!-- Referred By -->
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-arrow-up-circle text-primary me-2"></i>
                                        <h6 class="mb-0">Referred By</h6>
                                    </div>
                                    @if($contractor->referencedBy)
                                        <div class="mb-2">
                                            <div class="fw-medium">{{ $contractor->referencedBy->name }}</div>
                                            <div class="text-muted small">{{ $contractor->referencedBy->phone }}</div>
                                            <div class="text-muted small">{{ $contractor->referencedBy->email }}</div>
                                        </div>
                                        <a href="{{ route('admin.contractors.show', $contractor->referencedBy) }}" class="btn btn-sm btn-outline">
                                            <i class="bi bi-eye me-1"></i>
                                            View Referrer
                                        </a>
                                    @else
                                        <div class="text-muted">
                                            <i class="bi bi-dash-circle me-1"></i>
                                            No referrer (Top level contractor)
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Referrals -->
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-arrow-down-circle text-primary me-2"></i>
                                        <h6 class="mb-0">Referrals ({{ $contractor->referrals->count() }})</h6>
                                    </div>
                                    @if($contractor->referrals->count() > 0)
                                        <div class="mb-2">
                                            @foreach($contractor->referrals->take(3) as $referral)
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <div class="fw-medium">{{ $referral->name }}</div>
                                                        <div class="text-muted small">{{ $referral->phone }}</div>
                                                    </div>
                                                    <a href="{{ route('admin.contractors.show', $referral) }}" class="btn btn-sm btn-outline">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                            @if($contractor->referrals->count() > 3)
                                                <div class="text-muted small">
                                                    +{{ $contractor->referrals->count() - 3 }} more referrals
                                                </div>
                                            @endif
                                        </div>
                                        <a href="{{ route('admin.contractors.index') }}?search={{ $contractor->phone }}" class="btn btn-sm btn-outline">
                                            <i class="bi bi-list me-1"></i>
                                            View All Referrals
                                        </a>
                                    @else
                                        <div class="text-muted">
                                            <i class="bi bi-dash-circle me-1"></i>
                                            No referrals yet
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Photos -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Document Photos</h5>
                        <p class="card-description">Uploaded identity document images</p>
                    </div>
                    <div class="card-content">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <h6 class="mb-3">Aadhar Card Photo</h6>
                                    @if($contractor->aadhar_photo)
                                        <img src="{{ Storage::url($contractor->aadhar_photo) }}" 
                                             alt="Aadhar Card" 
                                             class="img-fluid rounded border" 
                                             style="max-width: 100%; height: auto;">
                                    @else
                                        <div class="text-center py-4">
                                            <i class="bi bi-card-image text-muted mb-2" style="font-size: 3rem;"></i>
                                            <p class="text-muted mb-0">No photo uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <h6 class="mb-3">PAN Card Photo</h6>
                                    @if($contractor->pan_photo)
                                        <img src="{{ Storage::url($contractor->pan_photo) }}" 
                                             alt="PAN Card" 
                                             class="img-fluid rounded border" 
                                             style="max-width: 100%; height: auto;">
                                    @else
                                        <div class="text-center py-4">
                                            <i class="bi bi-card-image text-muted mb-2" style="font-size: 3rem;"></i>
                                            <p class="text-muted mb-0">No photo uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Account Status -->
                <div class="admin-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Account Status</h5>
                    </div>
                    <div class="card-content">
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div>
                                <span class="badge badge-{{ $contractor->isActive() ? 'primary' : 'secondary' }}">
                                    {{ $contractor->isActive() ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Verification</label>
                            <div>
                                @if($contractor->isVerified())
                                    <span class="badge badge-primary">Verified</span>
                                    @if($contractor->verified_at)
                                        <small class="text-muted d-block mt-1">
                                            Verified {{ $contractor->verified_at->diffForHumans() }}
                                        </small>
                                    @endif
                                @else
                                    <span class="badge badge-secondary">Pending</span>
                                @endif
                            </div>
                        </div>
                        @if($contractor->verifiedBy)
                        <div class="mb-3">
                            <label class="form-label text-muted">Verified By</label>
                            <div>{{ $contractor->verifiedBy->name }}</div>
                        </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label text-muted">Can Login</label>
                            <div>
                                @if($contractor->canLogin())
                                    <span class="badge badge-primary">Yes</span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-content">
                        <div class="d-grid gap-2">
                            @can('manage_contractors')
                            <a href="{{ route('admin.contractors.edit', $contractor) }}" class="btn btn-outline">
                                <i class="bi bi-pencil me-2"></i>
                                Edit Contractor
                            </a>
                            
                            @if(!$contractor->isVerified())
                                <form method="POST" action="{{ route('admin.contractors.verify', $contractor) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline w-100" 
                                            data-confirm="Are you sure you want to verify this contractor?">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Verify Contractor
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.contractors.toggle-status', $contractor) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline w-100"
                                        data-confirm="Are you sure you want to {{ $contractor->isActive() ? 'deactivate' : 'activate' }} this contractor?">
                                    <i class="bi bi-{{ $contractor->isActive() ? 'pause' : 'play' }} me-2"></i>
                                    {{ $contractor->isActive() ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.contractors.destroy', $contractor) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-destructive w-100" 
                                        data-confirm="Are you sure you want to delete this contractor? This action cannot be undone.">
                                    <i class="bi bi-trash me-2"></i>
                                    Delete Contractor
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 