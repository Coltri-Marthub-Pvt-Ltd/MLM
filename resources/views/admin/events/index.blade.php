@extends('layouts.admin')

@section('title', 'Events')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Events</h1>
                <p class="text-muted">Manage your events</p>
            </div>
            <div>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Create New Event
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="{{ route('admin.events.index') }}">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">Search Events</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Search by title or description...">
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Event Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="upcoming" {{ request('type') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="current" {{ request('type') == 'current' ? 'selected' : '' }}>Current</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="order" class="form-label">Sort By</label>
                            <select class="form-select" id="order" name="order">
                                <option value="newest" {{ request('order') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('order') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="order_asc" {{ request('order') == 'order_asc' ? 'selected' : '' }}>Order (Low to High)</option>
                                <option value="order_desc" {{ request('order') == 'order_desc' ? 'selected' : '' }}>Order (High to Low)</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Events Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Events</h5>
                <p class="card-description">{{ $events->total() }} events found</p>
            </div>

           @if($events->count() > 0)
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th>Featured Image</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Order</th>
                    <th>Slug</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>
                            @if($event->featured_image)
                                <img src="{{ asset($event->featured_image) }}" alt="{{ $event->title }}"
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-medium">{{ $event->title }}</td>
                        <td>
                            @if($event->type == 'upcoming')
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            @else
                                <span class="badge bg-success">Current</span>
                            @endif
                        </td>
                        <td class="fw-medium">{{ $event->order }}</td>
                        <td class="text-muted">{{ $event->slug }}</td>
                        <td class="text-muted">{{ $event->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-outline" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-destructive" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-event text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mb-3">No Events Found</h5>
                        <p class="text-muted mb-4">There are no events in the system yet.</p>
                        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Create First Event
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
