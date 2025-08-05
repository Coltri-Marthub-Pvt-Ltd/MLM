
@php
    $isEdit = isset($samplingRequest);
    $route = $isEdit ? route('admin.sampling-requests.update', $samplingRequest) : route('admin.sampling-requests.store');
@endphp

<form method="POST" action="{{ $route }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $samplingRequest->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="variant" class="form-label">Variant *</label>
                <input type="text" class="form-control @error('variant') is-invalid @enderror" 
                       id="variant" name="variant" value="{{ old('variant', $samplingRequest->variant ?? '') }}" required>
                @error('variant')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="phone" class="form-label">Phone *</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone', $samplingRequest->phone ?? '') }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="visit_request" class="form-label">Visit Request *</label>
                <select class="form-select @error('visit_request') is-invalid @enderror" id="visit_request" name="visit_request" required>
                    <option value="1" {{ old('visit_request', $samplingRequest->visit_request ?? '') == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('visit_request', $samplingRequest->visit_request ?? '') == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('visit_request')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="contact_details" class="form-label">Contact Details *</label>
        <textarea class="form-control @error('contact_details') is-invalid @enderror" 
                  id="contact_details" name="contact_details" rows="3" required>{{ old('contact_details', $samplingRequest->contact_details ?? '') }}</textarea>
        @error('contact_details')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="other_details" class="form-label">Other Details</label>
        <textarea class="form-control @error('other_details') is-invalid @enderror" 
                  id="other_details" name="other_details" rows="3">{{ old('other_details', $samplingRequest->other_details ?? '') }}</textarea>
        @error('other_details')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.sampling-requests.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            @if($isEdit) Update Request @else Create Request @endif
        </button>
    </div>
</form>