@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
    <div class="fade-in">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Edit Event</h5>
            </div>
            <div class="card-content">
                <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="date" class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                            value="{{ old('date', optional($event)->date ? $event->date->format('Y-m-d') : '') }}" required>
                        @error('date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title', $event->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug"
                            value="{{ old('slug', $event->slug) }}" required>
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
                                <option value="upcoming" {{ old('type', $event->type) == 'upcoming' ? 'selected' : '' }}>
                                    Upcoming</option>
                                <option value="current" {{ old('type', $event->type) == 'current' ? 'selected' : '' }}>
                                    Current</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="order" class="form-label">Order</label>
                            <input type="number" class="form-control" id="order" name="order"
                                value="{{ old('order', $event->order) }}">
                            @error('order')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image">
                        @error('featured_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @if ($event->featured_image)
                            <div class="mt-2">
                                <img src="{{ asset($event->featured_image) }}" alt="Current featured image"
                                    style="max-height: 100px;">
                                <p class="small text-muted mt-1">Current image</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="gallery" class="form-label">Gallery Images</label>
                        <input type="file" class="form-control" id="gallery" name="gallery[]" multiple>
                        @error('gallery.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        @if (count($event->gallery_urls) > 0)
                            <div class="mt-3">
                                <h6>Current Gallery Images</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($event->gallery_urls as $index => $imageUrl)
                                        <div class="position-relative">
                                            <img src="{{ $imageUrl }}" alt="Gallery image" class="img-thumbnail"
                                                style="height: 80px;">
                                            <a href="{{ route('admin.events.deleteImage', ['event' => $event, 'imageIndex' => $index]) }}"
                                                class="position-absolute top-0 end-0 btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline me-3">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('title').addEventListener('input', function() {
                let slug = this.value.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            });
        </script>
    @endpush
@endsection
