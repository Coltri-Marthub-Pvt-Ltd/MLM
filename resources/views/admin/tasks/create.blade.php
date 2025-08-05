@extends('layouts.admin')

@section('title', 'Create Task')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Create Task</h1>
                <p class="text-muted">Create a new task and assign it to a user</p>
            </div>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Tasks
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Task Information</h5>
                        <p class="card-description">Enter the details for the new task</p>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('admin.tasks.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('title') is-invalid @enderror" 
                                    id="title" 
                                    name="title" 
                                    value="{{ old('title') }}" 
                                    placeholder="Enter task title"
                                    required
                                >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="4" 
                                    placeholder="Describe the task in detail..."
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="assigned_to" class="form-label">Assign To <span class="text-danger">*</span></label>
                                        <div class="searchable-select-container">
                                            <input 
                                                type="text" 
                                                class="form-control searchable-select-input @error('assigned_to') is-invalid @enderror" 
                                                id="assigned_to_search" 
                                                placeholder="Search and select a user..."
                                                autocomplete="off"
                                            >
                                            <input 
                                                type="hidden" 
                                                id="assigned_to" 
                                                name="assigned_to" 
                                                value="{{ old('assigned_to') }}"
                                                required
                                            >
                                            <div class="searchable-select-dropdown" id="assigned_to_dropdown">
                                                <div class="searchable-select-option" data-value="" data-text="Select a user">
                                                    <div class="fw-medium">Select a user</div>
                                                </div>
                                                @foreach($users as $user)
                                                    <div class="searchable-select-option {{ old('assigned_to') == $user->id ? 'selected' : '' }}" 
                                                         data-value="{{ $user->id }}" 
                                                         data-text="{{ $user->name }} - {{ $user->email }}"
                                                         data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                                        <div class="fw-medium">{{ $user->name }}</div>
                                                        <div class="text-muted small">{{ $user->email }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('assigned_to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="due_date" class="form-label">Due Date</label>
                                        <input 
                                            type="date" 
                                            class="form-control @error('due_date') is-invalid @enderror" 
                                            id="due_date" 
                                            name="due_date" 
                                            value="{{ old('due_date') }}"
                                            min="{{ date('Y-m-d') }}"
                                        >
                                        @error('due_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>
                                    Create Task
                                </button>
                                <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Task Guidelines</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            <h6 class="mb-2">Task Assignment:</h6>
                            <ul class="mb-3">
                                <li>Tasks are assigned to users</li>
                                <li>You will be recorded as the task creator</li>
                                <li>Tasks start in pending status</li>
                                <li>Due dates are optional but recommended</li>
                            </ul>

                            <h6 class="mb-2">Task Status:</h6>
                            <ul class="mb-3">
                                <li><strong>Pending:</strong> Task is not yet completed</li>
                                <li><strong>Completed:</strong> Task has been finished</li>
                                <li><strong>Overdue:</strong> Task is past its due date</li>
                            </ul>

                            <h6 class="mb-2">Best Practices:</h6>
                            <ul class="mb-0">
                                <li>Use clear, descriptive task titles</li>
                                <li>Provide detailed descriptions</li>
                                <li>Set realistic due dates</li>
                                <li>Use description field for instructions</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">Available Users</h5>
                    </div>
                    <div class="card-content">
                        <div class="small">
                            @if($users->count() > 0)
                                <p class="mb-2">{{ $users->count() }} user{{ $users->count() != 1 ? 's' : '' }} available:</p>
                                @foreach($users->take(5) as $user)
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>{{ $user->name }}</span>
                                        <span class="text-muted">{{ $user->email }}</span>
                                    </div>
                                @endforeach
                                @if($users->count() > 5)
                                    <div class="text-muted">... and {{ $users->count() - 5 }} more</div>
                                @endif
                            @else
                                <p class="text-muted">No users available for task assignment.</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline">
                                    <i class="bi bi-person-plus me-1"></i>
                                    Manage Users
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initSearchableSelect();
        });

        function initSearchableSelect() {
            const searchInput = document.getElementById('assigned_to_search');
            const hiddenInput = document.getElementById('assigned_to');
            const dropdown = document.getElementById('assigned_to_dropdown');
            const options = dropdown.querySelectorAll('.searchable-select-option');

            // Set initial display value
            const selectedOption = dropdown.querySelector('.searchable-select-option.selected');
            if (selectedOption) {
                searchInput.value = selectedOption.getAttribute('data-text');
                hiddenInput.value = selectedOption.getAttribute('data-value');
            }

            // Show dropdown on input focus
            searchInput.addEventListener('focus', function() {
                dropdown.classList.add('show');
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.searchable-select-container')) {
                    dropdown.classList.remove('show');
                }
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                options.forEach(option => {
                    const searchText = option.getAttribute('data-search') || '';
                    const displayText = option.getAttribute('data-text') || '';
                    
                    if (searchText.includes(searchTerm) || displayText.toLowerCase().includes(searchTerm)) {
                        option.classList.remove('hidden');
                    } else {
                        option.classList.add('hidden');
                    }
                });
            });

            // Option selection
            options.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    options.forEach(opt => opt.classList.remove('selected'));
                    
                    // Add selected class to clicked option
                    this.classList.add('selected');
                    
                    // Update input values
                    searchInput.value = this.getAttribute('data-text');
                    hiddenInput.value = this.getAttribute('data-value');
                    
                    // Hide dropdown
                    dropdown.classList.remove('show');
                });
            });

            // Prevent form submission when pressing Enter in search input
            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    
                    // Select first visible option
                    const firstVisible = dropdown.querySelector('.searchable-select-option:not(.hidden)');
                    if (firstVisible) {
                        firstVisible.click();
                    }
                }
            });

            // Handle arrow key navigation
            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                    event.preventDefault();
                    
                    const visibleOptions = Array.from(dropdown.querySelectorAll('.searchable-select-option:not(.hidden)'));
                    const currentSelected = dropdown.querySelector('.searchable-select-option.selected');
                    let newIndex = 0;
                    
                    if (currentSelected) {
                        const currentIndex = visibleOptions.indexOf(currentSelected);
                        if (event.key === 'ArrowDown') {
                            newIndex = (currentIndex + 1) % visibleOptions.length;
                        } else {
                            newIndex = (currentIndex - 1 + visibleOptions.length) % visibleOptions.length;
                        }
                    }
                    
                    if (visibleOptions[newIndex]) {
                        visibleOptions[newIndex].click();
                    }
                }
            });
        }
    </script>
@endsection 