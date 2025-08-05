@extends('layouts.admin')

@section('title', 'View Event')

@section('content')
    <div class="fade-in">
        <div class="admin-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Event Details</h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-destructive" 
                                    onclick="return confirm('Are you sure you want to delete this event?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-4">
                            <img src="{{ $event->getFirstMediaUrl('featured_image') }}" alt="Featured Image" class="img-fluid rounded">
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach($event->getMedia('gallery') as $image)
                                <img src="{{ $image->getUrl() }}" alt="Gallery Image" class="img-thumbnail" style="height: 80px;">
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3 class="mb-3">{{ $event->title }}</h3>
                        
                        <div class="mb-3">
                            <span class="badge {{ $event->type == 'upcoming' ? 'bg-warning text-dark' : 'bg-success' }}">
                                {{ ucfirst($event->type) }}
                            </span>
                            <span class="badge bg-secondary ms-2">
                                Order: {{ $event->order }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <p class="text-muted mb-1">Slug:</p>
                            <p>{{ $event->slug }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-muted mb-1">Description:</p>
                            <div>{!! nl2br(e($event->description)) !!}</div>
                        </div>

                        <div class="text-muted small">
                            Created: {{ $event->created_at->format('M j, Y \a\t g:i A') }}<br>
                            Last Updated: {{ $event->updated_at->format('M j, Y \a\t g:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection