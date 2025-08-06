
    <style>
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .image-preview {
            position: relative;
            width: 100px;
            height: 100px;
        }
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }
        .remove-image {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">@if(isset($complaint)) Edit Complaint @else Create Complaint @endif</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $isEdit = isset($complaint);
                            $route = $isEdit ? route('admin.complaints.update', $complaint) : route('admin.complaints.store');
                        @endphp

                        <form method="POST" action="{{ $route }}" enctype="multipart/form-data" id="complaintForm">
                            @csrf
                            @if($isEdit) @method('PUT') @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $complaint->name ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="supplied_material" class="form-label">Supplied Material *</label>
                                        <input type="text" class="form-control @error('supplied_material') is-invalid @enderror" 
                                               id="supplied_material" name="supplied_material" 
                                               value="{{ old('supplied_material', $complaint->supplied_material ?? '') }}" required>
                                        @error('supplied_material')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date *</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                               id="date" name="date" 
                                               value="{{ old('date', isset($complaint) ? $complaint->date->format('Y-m-d') : '') }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City *</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" name="city" value="{{ old('city', $complaint->city ?? '') }}" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="visit_request" class="form-label">Visit Request *</label>
                                        <select class="form-select @error('visit_request') is-invalid @enderror" 
                                                id="visit_request" name="visit_request" required>
                                            <option value="1" {{ old('visit_request', $complaint->visit_request ?? '') == 1 ? 'selected' : '' }}>YES</option>
                                            <option value="0" {{ old('visit_request', $complaint->visit_request ?? '') == 0 ? 'selected' : '' }}>NO</option>
                                        </select>
                                        @error('visit_request')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address *</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="2" required>{{ old('address', $complaint->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="issues" class="form-label">Issues *</label>
                                <textarea class="form-control @error('issues') is-invalid @enderror" 
                                          id="issues" name="issues" rows="3" required>{{ old('issues', $complaint->issues ?? '') }}</textarea>
                                @error('issues')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="photos" class="form-label">Photos</label>
                                <input type="file" class="form-control @error('photos.*') is-invalid @enderror" 
                                       id="photos" name="photos[]" multiple accept="image/*">
                                @error('photos.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Preview of newly selected images -->
                                <div class="image-preview-container" id="newPhotosPreview"></div>
                                
                                <!-- Existing photos for edit mode -->
                                @if($isEdit && $complaint->photos->count())
                                    <div class="mt-3">
                                        <h6>Current Photos</h6>
                                        <div class="image-preview-container" id="existingPhotos">
                                            @foreach($complaint->photos as $photo)
                                                <div class="image-preview">
                                                    <img src="{{ asset('storage/'.$photo->path) }}" alt="Complaint Photo">
                                                    <div class="remove-image" onclick="removePhoto({{ $photo->id }})">
                                                        <i class="bi bi-x"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    @if($isEdit) Update Complaint @else Create Complaint @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview newly selected images
        document.getElementById('photos').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('newPhotosPreview');
            previewContainer.innerHTML = '';
            
            if(this.files.length > 0) {
                for(let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    if(file.type.match('image.*')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'image-preview';
                            previewDiv.innerHTML = `
                                <img src="${e.target.result}" alt="Preview">
                                <div class="remove-image" onclick="removeNewPhoto(${i})">
                                    <i class="bi bi-x"></i>
                                </div>
                            `;
                            previewContainer.appendChild(previewDiv);
                        }
                        
                        reader.readAsDataURL(file);
                    }
                }
            }
        });

        // Remove a newly selected photo from preview and file list
        function removeNewPhoto(index) {
            const fileInput = document.getElementById('photos');
            const dt = new DataTransfer();
            
            // Add all files except the one to remove
            for(let i = 0; i < fileInput.files.length; i++) {
                if(i !== index) {
                    dt.items.add(fileInput.files[i]);
                }
            }
            
            fileInput.files = dt.files;
            
            // Trigger change event to update preview
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }

        // Remove an existing photo via AJAX
        function removePhoto(photoId) {
            if(confirm('Are you sure you want to delete this photo?')) {
                fetch(`/admin/complaints/photos/${photoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.querySelector(`#existingPhotos div[data-id="${photoId}"]`).remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Form validation
        document.getElementById('complaintForm').addEventListener('submit', function(e) {
            const files = document.getElementById('photos').files;
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            for(let i = 0; i < files.length; i++) {
                if(files[i].size > maxSize) {
                    alert(`File "${files[i].name}" is too large. Maximum size is 2MB.`);
                    e.preventDefault();
                    return;
                }
            }
        });
    </script>
</body>
</html>