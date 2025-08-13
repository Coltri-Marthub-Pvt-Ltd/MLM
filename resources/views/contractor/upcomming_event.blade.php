@extends('layouts.contractor')

@section('title', 'Upcoming Events')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    {{-- <div class="d-flex justify-content-between align-items-center mb-4">

            <button class="btn btn-outline-secondary ms-2 d-md-none" id="filterToggle">
                <i class="fas fa-filter"></i>
            </button>
        </div>
    </div> --}}

    <div class="row">
        <!-- Event Filters - Hidden on mobile by default -->
        <div class="col-md-3 mb-4 d-none d-md-block" id="filterSection">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 d-md-none">
                        <h5 class="card-title mb-0">Filters</h5>
                        <button class="btn-close" id="closeFilter"></button>
                    </div>
                    <h5 class="card-title mb-3 d-none d-md-block">Filters</h5>

                    <div class="mb-3">
                        <label class="form-label">Event Type</label>
                        <select class="form-select">
                            <option selected>All Events</option>
                            <option>Conferences</option>
                            <option>Workshops</option>
                            <option>Meetups</option>
                            <option>Webinars</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <input type="text" class="form-control datepicker" placeholder="Select date range">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <select class="form-select">
                            <option selected>All Locations</option>
                            <option>New York</option>
                            <option>London</option>
                            <option>Tokyo</option>
                            <option>Remote</option>
                        </select>
                    </div>

                    <button class="btn btn-outline-primary w-100">Apply Filters</button>
                </div>
            </div>
        </div>

        <!-- Events List -->
        <div class="col-md-9">
            <!-- Updated: 2 cards per row on mobile, 3 on desktop -->
            <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 g-3 g-md-4">
                <!-- Event Card 1 -->
                 @foreach($data as $event)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="position-relative">
                            <img src="{{ $event->featured_image_url }}" class="card-img-top" alt="Event Image">
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">Upcoming</span>
                            <span class="badge bg-primary position-absolute bottom-0 start-0 m-2">Free</span>
                        </div>
                        <div class="card-body">
                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}

                                    @php
                                        $diff = \Carbon\Carbon::parse($event->date)->diffForHumans();
                                    @endphp

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</span>
                                <span class="text-muted small"><i class="fas fa-users me-1"></i> ({{ $diff }})</span>
                            </div>
                            <h5 class="card-title mb-2">{{ $event->title }}</h5>
                            <p class="card-text text-muted small mb-3 d-none d-sm-block">{{ \Illuminate\Support\Str::limit($event->description, 69) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> India</span>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Event Card 2 -->
                {{-- <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="card-img-top" alt="Event Image">
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">Limited Seats</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Jun 2, 2023</span>
                                <span class="text-muted small"><i class="fas fa-users me-1"></i> 120</span>
                            </div>
                            <h5 class="card-title mb-2">UX Design Workshop</h5>
                            <p class="card-text text-muted small mb-3 d-none d-sm-block">Hands-on workshop to improve your UX design skills.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> London</span>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Card 3 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865" class="card-img-top" alt="Event Image">
                            <span class="badge bg-success position-absolute top-0 end-0 m-2">Early Bird</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Jun 10, 2023</span>
                                <span class="text-muted small"><i class="fas fa-users me-1"></i> 200</span>
                            </div>
                            <h5 class="card-title mb-2">Tech Leadership Summit</h5>
                            <p class="card-text text-muted small mb-3 d-none d-sm-block">Strategies for leading tech teams in the modern workplace.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> Remote</span>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Card 4 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4" class="card-img-top" alt="Event Image">
                            <span class="badge bg-info position-absolute top-0 end-0 m-2">New</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Jun 22, 2023</span>
                                <span class="text-muted small"><i class="fas fa-users me-1"></i> 80</span>
                            </div>
                            <h5 class="card-title mb-2">Data Science Meetup</h5>
                            <p class="card-text text-muted small mb-3 d-none d-sm-block">Networking event for data science professionals.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> Tokyo</span>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Card 5 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692" class="card-img-top" alt="Event Image">
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">Upcoming</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Jul 5, 2023</span>
                                <span class="text-muted small"><i class="fas fa-users me-1"></i> 150</span>
                            </div>
                            <h5 class="card-title mb-2">Product Management Workshop</h5>
                            <p class="card-text text-muted small mb-3 d-none d-sm-block">Learn agile product management techniques.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> San Francisco</span>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Card 6 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0" class="card-img-top" alt="Event Image">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">VIP</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Jul 18, 2023</span>
                                <span class="text-muted small"><i class="fas fa-users me-1"></i> 50</span>
                            </div>
                            <h5 class="card-title mb-2">Executive Leadership Forum</h5>
                            <p class="card-text text-muted small mb-3 d-none d-sm-block">Exclusive event for senior executives.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> Chicago</span>

                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Pagination -->
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Date Range Picker -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize date range picker
        $('.datepicker').daterangepicker({
            opens: 'left',
            locale: {
                format: 'MM/DD/YYYY'
            }
        });

        // Add hover effect to cards
        $('.hover-shadow').hover(
            function() {
                $(this).addClass('shadow');
            },
            function() {
                $(this).removeClass('shadow');
            }
        );

        // Toggle filter section on mobile
        $('#filterToggle').click(function() {
            $('#filterSection').removeClass('d-none').addClass('d-block');
            $('body').addClass('modal-open');
        });

        // Close filter section on mobile
        $('#closeFilter').click(function() {
            $('#filterSection').addClass('d-none').removeClass('d-block');
            $('body').removeClass('modal-open');
        });

        // Close filter when clicking outside on mobile
        $(document).on('click', function(e) {
            if ($(window).width() < 768) {
                if (!$(e.target).closest('#filterSection').length &&
                    !$(e.target).is('#filterToggle') &&
                    $('#filterSection').hasClass('d-block')) {
                    $('#filterSection').addClass('d-none').removeClass('d-block');
                    $('body').removeClass('modal-open');
                }
            }
        });
    });
</script>
@endpush

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Date Range Picker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<style>
    /* Custom Styles */
    .card {
        border-radius: 10px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card-img-top {
        height: 160px;
        object-fit: cover;
    }

    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35em 0.65em;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    /* Mobile filter styles */
    @media (max-width: 767.98px) {
        #filterSection {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 1050;
            background: white;
            overflow-y: auto;
            padding: 1rem;
            margin: 0;
        }

        #filterSection .card {
            box-shadow: none;
            height: 100%;
            border: none !important;
        }

        body.modal-open {
            overflow: hidden;
        }
    }

    /* Mobile (xs) adjustments */
    @media (max-width: 575.98px) {
        .card-img-top {
            height: 100px;
        }
        .card-title {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }
        .card-text {
            font-size: 0.7rem;
            margin-bottom: 0.5rem;
        }
        .badge {
            font-size: 0.6rem;
        }
        .text-muted.small {
            font-size: 0.7rem;
        }
        .btn-sm {
            padding: 0.15rem 0.3rem;
            font-size: 0.7rem;
        }
    }

    /* Tablet (sm-md) adjustments */
    @media (max-width: 767.98px) {
        .card-img-top {
            height: 120px;
        }
    }
</style>
@endpush
