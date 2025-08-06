
@extends('layouts.admin')

@section('title', 'Create Complaint')

@section('content')
    <div class="fade-in">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create Complaint</h1>
                <p class="text-muted">Add a new customer complaint</p>
            </div>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Back to List
            </a>
        </div>

        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">Complaint Details</h5>
            </div>
            <div class="card-body">
                @include('admin.complaints.form')
            </div>
        </div>
    </div>
@endsection