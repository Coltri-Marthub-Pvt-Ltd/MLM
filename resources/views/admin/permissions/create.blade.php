@extends('layouts.admin')

@section('title', 'Create Permission')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create Permission</h1>
                <p class="text-muted">Add a new permission to the system</p>
            </div>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Permissions
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Permission Information</h5>
                        <p class="card-description">Enter the basic information for the new permission</p>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.permissions.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    placeholder="Enter permission name (e.g., view_posts, edit_users)"
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="3"
                                    placeholder="Describe what this permission allows..."
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-key me-2"></i>
                                    Create Permission
                                </button>
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Guidelines</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <h6 class="mb-2">Permission Naming:</h6>
                            <ul class="mb-3">
                                <li>Use descriptive action names</li>
                                <li>Follow pattern: action_resource</li>
                                <li>Use underscores, not spaces</li>
                                <li>Examples: view_users, edit_posts, delete_comments</li>
                            </ul>

                            <h6 class="mb-2">Common Patterns:</h6>
                            <ul class="mb-3">
                                <li><code>view_*</code> - Read access</li>
                                <li><code>create_*</code> - Create new items</li>
                                <li><code>edit_*</code> - Modify existing items</li>
                                <li><code>delete_*</code> - Remove items</li>
                                <li><code>manage_*</code> - Full control</li>
                            </ul>

                            <h6 class="mb-2">Best Practices:</h6>
                            <ul class="mb-0">
                                <li>Be specific about what's allowed</li>
                                <li>Group related permissions</li>
                                <li>Consider permission hierarchy</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
