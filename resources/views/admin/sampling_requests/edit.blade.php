
@extends('layouts.admin')

@section('title', 'Edit Sampling Request')

@section('content')
    <div class="fade-in">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Edit Sampling Request</h1>
                <p class="text-muted">Update product sampling request details</p>
            </div>
            <a href="{{ route('admin.sampling-requests.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Back to List
            </a>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Request Details</h5>
            </div>
            <div class="card-body">
                @include('admin.sampling_requests.form')
            </div>
        </div>
    </div>
@endsection