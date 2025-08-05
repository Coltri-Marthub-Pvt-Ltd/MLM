@extends('layouts.admin')

@section('title', 'Edit Contractor')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Edit Contractor</h1>
                <p class="text-muted">Update contractor information</p>
            </div>
            <a href="{{ route('admin.contractors.show', $contractor) }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Contractor
            </a>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Contractor Information</h5>
                <p class="card-description">Update the contractor's personal and document information</p>
            </div>
            
            <form method="POST" action="{{ route('admin.contractors.update', $contractor) }}" class="card-content">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- Personal Information -->
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Personal Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $contractor->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $contractor->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $contractor->phone) }}" 
                               placeholder="10-digit number" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $contractor->date_of_birth->format('Y-m-d')) }}" required>
                        <div class="form-text">Age: {{ $contractor->age }} years</div>
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address', $contractor->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Document Information -->
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Document Information</h6>
                    </div>

                    <div class="col-md-6">
                        <label for="aadhar_card" class="form-label">Aadhar Card Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('aadhar_card') is-invalid @enderror" 
                               id="aadhar_card" name="aadhar_card" value="{{ old('aadhar_card', $contractor->aadhar_card) }}" 
                               placeholder="12-digit number" required>
                        @error('aadhar_card')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="pan_card" class="form-label">PAN Card Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pan_card') is-invalid @enderror" 
                               id="pan_card" name="pan_card" value="{{ old('pan_card', $contractor->pan_card) }}" 
                               placeholder="ABCDE1234F" required>
                        @error('pan_card')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Account Status -->
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Account Status</h6>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" 
                                   value="1" {{ old('status', $contractor->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">
                                Active Status
                            </label>
                        </div>
                        <div class="form-text">Toggle contractor's active/inactive status</div>
                    </div>

                    <!-- Current Photos -->
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Current Document Photos</h6>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Aadhar Card Photo</label>
                        @if($contractor->aadhar_photo)
                            <div class="mb-2">
                                <img src="{{ Storage::url($contractor->aadhar_photo) }}" 
                                     alt="Aadhar Card" class="img-fluid rounded border" style="max-width: 200px;">
                            </div>
                        @else
                            <p class="text-muted">No photo uploaded</p>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">PAN Card Photo</label>
                        @if($contractor->pan_photo)
                            <div class="mb-2">
                                <img src="{{ Storage::url($contractor->pan_photo) }}" 
                                     alt="PAN Card" class="img-fluid rounded border" style="max-width: 200px;">
                            </div>
                        @else
                            <p class="text-muted">No photo uploaded</p>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('admin.contractors.show', $contractor) }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>
                        Update Contractor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 