@extends('layouts.contractor')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<section class="welcome-section">
    <h1 class="welcome-title">Welcome back, {{ $contractor->name }}!</h1>
    <p class="welcome-subtitle">Here's your dashboard overview</p>
    
    <!-- Progress Cards -->
    <div class="progress-cards">
        <div class="progress-card">
            <div class="progress-value">{{ $contractor->points }}</div>
            <div class="progress-label">Coins</div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(($contractor->points / 1000) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="progress-card">
            <div class="progress-value">{{ $directMamber }}</div>
            <div class="progress-label">Sponsors</div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(($directMamber / 10) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap Vertical Tabs -->
<section class="vertical-tabs-section">
    <div class="row">
        <div class="col-5">
            <!-- Vertical Tab Navigation -->
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-gift-tab" data-bs-toggle="pill" data-bs-target="#v-pills-gift" type="button" role="tab" aria-controls="v-pills-gift" aria-selected="true">
                    <i class="bi bi-gift me-2"></i>
                    Gift Card
                </button>
                <button class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" type="button" role="tab" aria-controls="v-pills-orders" aria-selected="false">
                    <i class="bi bi-box-seam me-2"></i>
                    Orders
                </button>
                <button class="nav-link" id="v-pills-schemes-tab" data-bs-toggle="pill" data-bs-target="#v-pills-schemes" type="button" role="tab" aria-controls="v-pills-schemes" aria-selected="false">
                    <i class="bi bi-clock-history me-2"></i>
                    Limited Schemes
                </button>
                <button class="nav-link" id="v-pills-deals-tab" data-bs-toggle="pill" data-bs-target="#v-pills-deals" type="button" role="tab" aria-controls="v-pills-deals" aria-selected="false">
                    <i class="bi bi-tags me-2"></i>
                    Deals
                </button>
                <button class="nav-link" id="v-pills-new-tab" data-bs-toggle="pill" data-bs-target="#v-pills-new" type="button" role="tab" aria-controls="v-pills-new" aria-selected="false">
                    <i class="bi bi-star me-2"></i>
                    New Features
                </button>
            </div>
        </div>
        
        <div class="col-7">
            <!-- Tab Content -->
            <div class="tab-content" id="v-pills-tabContent">
                <!-- Gift Card Tab -->
                <div class="tab-pane fade show active" id="v-pills-gift" role="tabpanel" aria-labelledby="v-pills-gift-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-gift me-2"></i>
                                Gift Card Redemption
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Gift Card</th>
                                            <th>Points Required</th>
                                            <th>Value</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-credit-card me-2 text-primary"></i>
                                                    <div>
                                                        <strong>Amazon Gift Card</strong>
                                                        <br><small class="text-muted">Digital delivery</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-warning">1,000</span></td>
                                            <td>$10.00</td>
                                            <td><span class="badge bg-success">Available</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Redeem</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-credit-card me-2 text-success"></i>
                                                    <div>
                                                        <strong>Starbucks Gift Card</strong>
                                                        <br><small class="text-muted">Email delivery</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-warning">500</span></td>
                                            <td>$5.00</td>
                                            <td><span class="badge bg-success">Available</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Redeem</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-credit-card me-2 text-info"></i>
                                                    <div>
                                                        <strong>Netflix Gift Card</strong>
                                                        <br><small class="text-muted">Digital code</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-warning">2,000</span></td>
                                            <td>$20.00</td>
                                            <td><span class="badge bg-secondary">Coming Soon</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary" disabled>Coming Soon</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-box-seam me-2"></i>
                                Order History
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>#ORD-001</strong></td>
                                            <td>Premium Headphones</td>
                                            <td>2024-01-15</td>
                                            <td><span class="badge bg-success">Delivered</span></td>
                                            <td>$299.99</td>
                                            <td>
                                                <a href="{{ route('contractor.myorders') }}" class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-002</strong></td>
                                            <td>Smart Watch</td>
                                            <td>2024-01-10</td>
                                            <td><span class="badge bg-warning">Processing</span></td>
                                            <td>$199.99</td>
                                            <td>
                                                <a href="{{ route('contractor.myorders') }}" class="btn btn-sm btn-outline-primary">Track</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-003</strong></td>
                                            <td>Wireless Earbuds</td>
                                            <td>2024-01-05</td>
                                            <td><span class="badge bg-info">Shipped</span></td>
                                            <td>$89.99</td>
                                            <td>
                                                <a href="{{ route('contractor.myorders') }}" class="btn btn-sm btn-outline-primary">Track</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Limited Schemes Tab -->
                <div class="tab-pane fade" id="v-pills-schemes" role="tabpanel" aria-labelledby="v-pills-schemes-tab">
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
                                                    <br><small class="text-muted">Earn 2x points on all purchases</small>
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
