@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
    <div class="fade-in">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Edit Event: {{ $event->title }}</h5>
            </div>
            <div class="card-content">
                <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $event->slug) }}" required>
                        @error('slug')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="upcoming" {{ old('type', $event->type) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="current" {{ old('type', $event->type) == 'current' ? 'selected' : '' }}>Current</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="order" class="form-label">Order</label>
                            <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $event->order) }}">
                            @error('order')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Featured Image</label>
                        <div>
                            <img src="{{ $event->getFirstMediaUrl('featured_image') }}" alt="Featured Image" class="img-thumbnail mb-2" style="max-height: 150px;">
                        </div>
                        <label for="featured_image" class="form-label">Change Featured Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image">
                        @error('featured_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Gallery Images</label>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($event->getMedia('gallery') as $image)
                                <div class="position-relative">
                                    <img src="{{ $image->getUrl() }}" alt="Gallery Image" class="img-thumbnail" style="height: 100px;">
                                    <a href="{{ route('admin.events.deleteImage', ['event' => $event->id, 'mediaId' => $image->id]) }}" 
                                       class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" 
                                       onclick="return confirm('Are you sure you want to delete this image?')">
                                        ×
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <label for="gallery" class="form-label">Add More Gallery Images</label>
                        <input type="file" class="form-control" id="gallery" name="gallery[]" multiple>
                        @error('gallery.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline me-3">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection