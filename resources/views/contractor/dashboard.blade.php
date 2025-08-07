@extends('layouts.contractor')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="progress-cards">
            <!-- Card 1: Coins -->
            <div class="progress-card">
                <div class="progress-label">Coins</div>
                <div class="progress-value">{{ $contractor->points }}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ min(($contractor->points / 1000) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
            <div class="progress-card">
                <div class="progress-label">Remaning</div>
                <div class="progress-value">{{ $nextBadge->name }} : {{ $nextBadge->coins - $contractor->points }} coins</div>
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ min(($nextBadge->coins / 50) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
            <!-- Card 2: Sponsors -->

            <!-- Card 3: Add your third metric -->

            <div class="progress-card">
                <div class="progress-label">Sponsors</div>
                <div class="progress-value">{{ $directMamber }}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ min(($directMamber / 10) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Add your fourth metric -->
            <div class="progress-card">
                <div class="progress-label">Till today</div>
                <div class="progress-value">{{ $sponsorsToday }}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ min(($sponsorsToday / 100) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap Vertical Tabs -->
    <section class="vertical-tabs-section py-3">
        <div class="row">
            <div class="col-5">
                <!-- Vertical Tab Navigation -->
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders"
                        type="button" role="tab" aria-controls="v-pills-orders" aria-selected="false">
                        Orders
                    </button>
                    <button class="nav-link" id="v-pills-gift-tab" data-bs-toggle="pill" data-bs-target="#v-pills-gift"
                        type="button" role="tab" aria-controls="v-pills-gift" aria-selected="false">
                        Gift Card
                    </button>
                    <button class="nav-link" id="v-pills-schemes-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-schemes" type="button" role="tab" aria-controls="v-pills-schemes"
                        aria-selected="false">
                        Limited Schemes
                    </button>
                    <button class="nav-link" id="v-pills-deals-tab" data-bs-toggle="pill" data-bs-target="#v-pills-deals"
                        type="button" role="tab" aria-controls="v-pills-deals" aria-selected="false">
                        Deals
                    </button>
                    <button class="nav-link" id="v-pills-new-tab" data-bs-toggle="pill" data-bs-target="#v-pills-new"
                        type="button" role="tab" aria-controls="v-pills-new" aria-selected="false">
                        New
                    </button>
                </div>
            </div>

            <div class="col-7">
                <!-- Tab Content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Default Logo (shown when no tab is active) -->
                    <div class="tab-pane fade show active" id="default-logo-tab" role="tabpanel">
                        <div class="default-logo-content">
                            <div class="default-logo-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Gift Card Tab -->
                    <div class="tab-pane fade" id="v-pills-gift" role="tabpanel" aria-labelledby="v-pills-gift-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-gift me-2"></i>
                                    Gift Card Redemption
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="progress-card">
                                    <div class="progress-label">Partner Points</div>
                                    <div class="progress-value">200</div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 20%"></div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg"
                                                    alt="Gift Card" class="img-fluid" width="40px" height="40px">
                                            </div>
                                            <div>
                                                <p>Lorem ip dor sit...</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg"
                                                    alt="Gift Card" class="img-fluid" width="40px" height="40px">
                                            </div>
                                            <div>
                                                <p>Lorem ip dor sit...</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg"
                                                    alt="Gift Card" class="img-fluid" width="40px" height="40px">
                                            </div>
                                            <div>
                                                <p>Lorem ip dor sit...</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg"
                                                    alt="Gift Card" class="img-fluid" width="40px" height="40px">
                                            </div>
                                            <div>
                                                <p>Lorem ip dor sit...</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg"
                                                    alt="Gift Card" class="img-fluid" width="40px" height="40px">
                                            </div>
                                            <div>
                                                <p>Lorem ip dor sit...</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg"
                                                    alt="Gift Card" class="img-fluid" width="40px" height="40px">
                                            </div>
                                            <div>
                                                <p>Lorem ip dor sit...</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-box-seam me-2"></i>
                                    Order
                                </h5>
                            </div>
                            <div class="card-body ds_brand_card_section">
                                <div class="row">
                                   <div class="col-sm-12 text-center mb-3">
                                        <div class="card active_hlt brand-animation">
                                            <div class="">
                                                {{$top_brands->name}}
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($brands as $brand)
                                    <div class="col-6 mb-3">
                                        <div class="card shadow-sm border m-0 ratio ratio-1x1">
                                            <div class="card-body d-flex justify-content-center align-items-center">
                                                {{$brand->name}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Limited Schemes Tab -->
                    <div class="tab-pane fade" id="v-pills-schemes" role="tabpanel"
                        aria-labelledby="v-pills-schemes-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Limited Time Schemes
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Scheme</th>
                                                <th>Duration</th>
                                                <th>Reward</th>
                                                <th>Progress</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>Double Points Week</strong>
                                                        <br><small class="text-muted">Earn 2x points on all
                                                            purchases</small>
                                                    </div>
                                                </td>
                                                <td>7 days</td>
                                                <td>2x Points</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar" style="width: 75%"></div>
                                                    </div>
                                                    <small class="text-muted">3 days left</small>
                                                </td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-success">Participate</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>Referral Bonus</strong>
                                                        <br><small class="text-muted">Get 500 points per referral</small>
                                                    </div>
                                                </td>
                                                <td>30 days</td>
                                                <td>500 Points</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar" style="width: 45%"></div>
                                                    </div>
                                                    <small class="text-muted">13 days left</small>
                                                </td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-success">Share</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deals Tab -->
                    <div class="tab-pane fade" id="v-pills-deals" role="tabpanel" aria-labelledby="v-pills-deals-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-tags me-2"></i>
                                    Special Deals & Discounts
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Deal</th>
                                                <th>Discount</th>
                                                <th>Valid Until</th>
                                                <th>Usage</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>New User Discount</strong>
                                                        <br><small class="text-muted">First purchase discount</small>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-danger">20% OFF</span></td>
                                                <td>2024-02-15</td>
                                                <td>0/1</td>
                                                <td><span class="badge bg-success">Available</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary">Use Now</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>Bulk Purchase</strong>
                                                        <br><small class="text-muted">Buy 3+ items get 15% off</small>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-warning">15% OFF</span></td>
                                                <td>2024-01-31</td>
                                                <td>2/5</td>
                                                <td><span class="badge bg-success">Available</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary">Shop Now</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Features Tab -->
                    <div class="tab-pane fade" id="v-pills-new" role="tabpanel" aria-labelledby="v-pills-new-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-star me-2"></i>
                                    Latest Updates & Features
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Feature</th>
                                                <th>Type</th>
                                                <th>Release Date</th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>Mobile App</strong>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-primary">New</span></td>
                                                <td>2024-01-20</td>
                                                <td><span class="badge bg-success">Live</span></td>
                                                <td>Download our new mobile app for better experience</td>
                                                <td>
                                                    <button class="btn btn-sm btn-success">Download</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>Real-time Tracking</strong>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-info">Update</span></td>
                                                <td>2024-01-18</td>
                                                <td><span class="badge bg-success">Live</span></td>
                                                <td>Track your orders in real-time with live updates</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">Try Now</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>AI Recommendations</strong>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-warning">Beta</span></td>
                                                <td>2024-02-01</td>
                                                <td><span class="badge bg-warning">Coming Soon</span></td>
                                                <td>Get personalized product recommendations</td>
                                                <td>
                                                    <button class="btn btn-sm btn-secondary" disabled>Waitlist</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const defaultLogoTab = document.getElementById('default-logo-tab');
            const tabButtons = document.querySelectorAll('.nav-link');

            // Function to hide default logo when any tab is clicked
            function hideDefaultLogo() {
                if (defaultLogoTab) {
                    defaultLogoTab.classList.remove('show', 'active');
                }
            }

            // Add click event listeners to all tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    hideDefaultLogo();
                });
            });

            // Listen for Bootstrap tab events
            document.addEventListener('shown.bs.tab', function(event) {
                // Hide default logo when any tab is shown
                if (event.target.id !== 'default-logo-tab') {
                    hideDefaultLogo();
                }
            });
        });
    </script>
@endpush
