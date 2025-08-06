@extends('layouts.admin')

@section('title', 'View Complaint')

@section('content')
    <div class="fade-in">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-2">Complaint Details</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.complaints.index') }}">Complaints</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View #{{ $complaint->id }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to List
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Complaint #{{ $complaint->id }}</h5>
                <span class="badge bg-white text-primary">
                    {{ $complaint->created_at->format('M j, Y \a\t g:i a') }}
                </span>
            </div>
            
            <div class="card-body">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6 class="info-card-title">
                                <i class="bi bi-person me-2"></i>Complainant Information
                            </h6>
                            <div class="info-card-body">
                                <div class="info-item">
                                    <span class="info-label">Name:</span>
                                    <span class="info-value">{{ $complaint->name }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">City:</span>
                                    <span class="info-value">{{ $complaint->city }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Address:</span>
                                    <span class="info-value">{{ $complaint->address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Complaint Details -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6 class="info-card-title">
                                <i class="bi bi-file-earmark-text me-2"></i>Complaint Details
                            </h6>
                            <div class="info-card-body">
                                <div class="info-item">
                                    <span class="info-label">Date:</span>
                                    <span class="info-value">{{ $complaint->date->format('d M, Y') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Material Supplied:</span>
                                    <span class="info-value">{{ $complaint->supplied_material }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Visit Request:</span>
                                    <span class="info-value">
                                        @if($complaint->visit_request)
                                            <span class="badge bg-success">YES</span>
                                        @else
                                            <span class="badge bg-secondary">NO</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Issues -->
                    <div class="col-12">
                        <div class="info-card">
                            <h6 class="info-card-title">
                                <i class="bi bi-exclamation-triangle me-2"></i>Reported Issues
                            </h6>
                            <div class="info-card-body">
                                <div class="bg-light p-3 rounded">
                                    {!! nl2br(e($complaint->issues)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Photos -->
                    @if($complaint->photos->count())
                    <div class="col-12">
                        <div class="info-card">
                            <h6 class="info-card-title">
                                <i class="bi bi-images me-2"></i>Attached Photos ({{ $complaint->photos->count() }})
                            </h6>
                            <div class="info-card-body">
                                <div class="gallery-container">
                                    @foreach($complaint->photos as $photo)
                                    <div class="gallery-item">
                                        <a href="{{ asset('storage/'.$photo->path) }}" data-fancybox="gallery" data-caption="Photo {{ $loop->iteration }}">
                                            <img src="{{ asset('storage/'.$photo->path) }}" class="img-fluid rounded" alt="Complaint Photo">
                                            <div class="gallery-overlay">
                                                <i class="bi bi-zoom-in"></i>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="card-footer bg-light d-flex justify-content-between">
                <div>
                    <small class="text-muted">
                        Last updated: {{ $complaint->updated_at->diffForHumans() }}
                    </small>
                </div>
                <div>
                    <a href="{{ route('admin.complaints.edit', $complaint) }}" class="btn btn-outline-primary me-2">
                        <i class="bi bi-pencil-square me-2"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('admin.complaints.destroy', $complaint) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this complaint?')">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
    <style>
        .info-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .info-card-title {
            padding: 1rem 1.25rem;
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
        }
        
        .info-card-body {
            padding: 1.25rem;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 0.75rem;
        }
        
        .info-item:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 500;
            color: #6c757d;
            min-width: 150px;
        }
        
        .info-value {
            color: #212529;
            word-break: break-word;
        }
        
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        
        .gallery-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .gallery-overlay i {
            color: white;
            font-size: 1.5rem;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .gallery-container {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            
            .gallery-item img {
                height: 150px;
            }
            
            .info-item {
                flex-direction: column;
            }
            
            .info-label {
                margin-bottom: 0.25rem;
                min-width: auto;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Custom options if needed
        });
    </script>
@endpush