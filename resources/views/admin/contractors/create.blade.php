@extends('layouts.admin')

@section('title', 'Add New Contractor')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Add New Contractor</h1>
                <p class="text-muted">Create a new contractor account</p>
            </div>
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Contractors
            </a>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Contractor Information</h5>
                <p class="card-description">Fill in the contractor's personal and document information</p>
            </div>
            
            <form method="POST" action="{{ route('admin.contractors.store') }}" enctype="multipart/form-data" class="card-content">
                @csrf
                
                <div class="row g-4">
                    <!-- Personal Information -->
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Personal Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" 
                               placeholder="10-digit number" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                        <div class="form-text">Must be 18 years or older</div>
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
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
                               id="aadhar_card" name="aadhar_card" value="{{ old('aadhar_card') }}" 
                               placeholder="12-digit number" required>
                        @error('aadhar_card')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="pan_card" class="form-label">PAN Card Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pan_card') is-invalid @enderror" 
                               id="pan_card" name="pan_card" value="{{ old('pan_card') }}" 
                               placeholder="ABCDE1234F" required>
                        @error('pan_card')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="aadhar_photo" class="form-label">Aadhar Card Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('aadhar_photo') is-invalid @enderror" 
                               id="aadhar_photo" name="aadhar_photo" accept="image/*" required>
                        <div class="form-text">JPEG, PNG, JPG up to 2MB</div>
                        @error('aadhar_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="pan_photo" class="form-label">PAN Card Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('pan_photo') is-invalid @enderror" 
                               id="pan_photo" name="pan_photo" accept="image/*" required>
                        <div class="form-text">JPEG, PNG, JPG up to 2MB</div>
                        @error('pan_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Account Information -->
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Account Information</h6>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        <div class="form-text">Minimum 8 characters</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('admin.contractors.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>
                        Create Contractor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 