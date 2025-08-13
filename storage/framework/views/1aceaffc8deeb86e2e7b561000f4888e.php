<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid profile-container">
        <!-- Mobile Menu - Horizontal Scroll for small screens -->
        <div class="mobile-nav-container d-lg-none">
            <div class="mobile-nav-scroll">

                <div class="mobile-nav-item active" data-section="orders">
                    <i class="fas fa-box-open"></i>
                    <span>Orders</span>
                </div>
                <div class="mobile-nav-item" data-section="partners">
                    <i class="fas fa-handshake"></i>
                    <span>Partners</span>
                </div>
                <div class="mobile-nav-item" data-section="sponsor-points">
                    <i class="fas fa-coins"></i>
                    <span>Points</span>
                </div>
                <div class="mobile-nav-item" data-section="gift-redime">
                    <i class="fas fa-gift"></i>
                    <span>Gifts</span>
                </div>
                <div class="mobile-nav-item" data-section="deals">
                    <i class="fas fa-tag"></i>
                    <span>P Details</span>
                </div>
            </div>
        </div>

        <!-- Desktop Sidebar - Hidden on mobile -->
        <div class="row d-none d-lg-flex">
            <div class="col-lg-3 col-md-4">
                <div class="profile-sidebar-container">

                    <div class="nav-item orders selected" onclick="loadSection('orders')">
                        <i class="fas fa-box-open"></i>
                        <span class="nav-text">Orders</span>
                    </div>

                    <div class="nav-item partners" onclick="loadSection('partners')">
                        <i class="fas fa-handshake"></i>
                        <span class="nav-text">Partners</span>
                    </div>

                    <div class="nav-item sponsor-points" onclick="loadSection('sponsor-points')">
                        <i class="fas fa-coins"></i>
                        <span class="nav-text">Sponsor Points</span>
                    </div>

                    <div class="nav-item gift-redime" onclick="loadSection('gift-redime')">
                        <i class="fas fa-gift"></i>
                        <span class="nav-text">Gift Redemption</span>
                    </div>

                    <div class="nav-item personal-deals" onclick="loadSection('deals')">
                        <i class="fas fa-tag"></i>
                        <span class="nav-text">Personal Details</span>
                    </div>
                </div>
            </div>

            <!-- Desktop Content Area -->
            <div class="col-lg-9 col-md-8">
                <div class="profile-content">
                    <div id="content-area">
                        <!-- Orders content loaded by default -->
                        <div class="content-section">
                            <div class="content-section welcome-content">
                                <div class="welcome-section">
                                    <div class="welcome-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <h2><?php echo e(Auth::user()->name); ?></h2>
                                    <div class="personal-info">
                                        <p><i class="fas fa-envelope"></i> <?php echo e(Auth::user()->email); ?></p>
                                        <p><i class="fas fa-phone"></i> +91 <?php echo e(Auth::user()->phone); ?></p>
                                    </div>
                                    <div class="quick-stats">
                                        <a href="<?php echo e(route('contractor.myorders')); ?>" style="text-decoration: none;">
                                            <div class="stat-item">
                                                <i class="fas fa-box-open"></i>
                                                <span> Pending Orders</span>
                                            </div>
                                        </a>
                                        <a href="<?php echo e(route('contractor.myorders')); ?>" style="text-decoration: none;">
                                            <div class="stat-item">
                                                <i class="fas fa-coins"></i>
                                                <span> Delevred order</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Content Area - Shows below tabs -->
        <div class="mobile-content-area d-lg-none">
            <div id="mobile-content">
                <!-- Orders content loaded by default -->
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-box-open"></i> My Orders</h3>
                    <div class="order-tabs">
                        <div class="order-tab active" data-type="pending">Pending</div>
                        <div class="order-tab" data-type="processing">Processing</div>
                        <div class="order-tab" data-type="shipped">Shipped</div>
                        <div class="order-tab" data-type="delivered">Delivered</div>
                    </div>
                    <div class="order-list">
                        <div class="order-item">
                            <div class="order-id">#ORD-2023-456</div>
                            <div class="order-status processing">Processing</div>
                            <div class="order-date">Placed: 15 Nov 2023 | Total: $125.99</div>
                            <div class="order-products">
                                <div class="product-item">
                                    <div class="product-image">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-name">Premium Widget Pro</div>
                                        <div class="product-price">89.99 × 1</div>
                                    </div>
                                </div>
                                <div class="product-item">
                                    <div class="product-image">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-name">Accessory Kit</div>
                                        <div class="product-price">35.99 × 1</div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-actions">
                                <button class="btn btn-track">Track Order</button>
                                <button class="btn btn-cancel">Cancel</button>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="order-id">#ORD-2023-457</div>
                            <div class="order-status shipped">Shipped</div>
                            <div class="order-date">Placed: 18 Nov 2023 | Total: $59.99</div>
                            <div class="order-products">
                                <div class="product-item">
                                    <div class="product-image">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-name">Basic Widget</div>
                                        <div class="product-price">59.99 × 1</div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-actions">
                                <button class="btn btn-track">Track Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Base Styles */
        .profile-container {
            padding: 0;
        }

        /* Mobile Navigation Styles */
        .mobile-nav-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background: white;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .mobile-nav-scroll {
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 0 15px;
            gap: 15px;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 12px;
            min-width: 70px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .mobile-nav-item i {
            font-size: 20px;
            margin-bottom: 5px;
            color: #6c757d;
        }

        .mobile-nav-item span {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
        }

        .mobile-nav-item.active {
            background-color: #f0f7ff;
        }

        .mobile-nav-item.active i,
        .mobile-nav-item.active span {
            color: #0d6efd;
        }

        /* Mobile Content Area */


        /* Desktop Sidebar Styles */
        .profile-sidebar-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e0e0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 12px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background-color: #f0f7ff;
        }

        .nav-item i {
            font-size: 18px;
            color: #6c757d;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .nav-text {
            font-size: 15px;
            color: #333;
            font-weight: 500;
        }

        .nav-item.selected {
            background-color: #e3f2fd;
            box-shadow: inset 3px 0 0 #0d6efd;
        }

        .nav-item.selected i,
        .nav-item.selected .nav-text {
            color: #0d6efd;
        }

        /* Content Styles - Shared between mobile and desktop */
        .welcome-section {
            text-align: center;
            padding: 20px 0;
        }

        .welcome-avatar {
            font-size: 60px;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        .welcome-section h2 {
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .personal-info {
            margin: 15px 0;
            text-align: left;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .personal-info p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .personal-info i {
            width: 20px;
            text-align: center;
            color: #0d6efd;
        }

        .quick-stats {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .stat-item {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #333;
            border: 1px solid #e0e0e0;
        }

        .stat-item i {
            color: #0d6efd;
        }

        /* Orders Section */
        .order-list {
            margin-top: 15px;
        }

        .order-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
            position: relative;
        }

        .order-id {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .order-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .order-status.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .order-status.processing {
            background-color: #cce5ff;
            color: #004085;
        }

        .order-status.shipped {
            background-color: #d4edda;
            color: #155724;
        }

        .order-status.delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .order-status.cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-date {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .order-products {
            margin: 10px 0;
            border-top: 1px dashed #eee;
            padding-top: 10px;
        }

        .product-item {
            display: flex;
            margin-bottom: 8px;
            align-items: center;
        }

        .product-image {
            width: 50px;
            height: 50px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .product-price {
            font-size: 13px;
            color: #6c757d;
        }

        .order-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-track,
        .btn-review,
        .btn-cancel {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-track {
            background-color: #0d6efd;
            color: white;
        }

        .btn-review {
            background-color: #6c757d;
            color: white;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }

        /* Points Section */
        .points-balance {
            text-align: center;
            margin: 20px 0;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            padding: 20px;
            border-radius: 10px;
            color: white;
        }

        .balance-amount {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .balance-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .activity-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .activity-list li {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .activity-list li i {
            margin-right: 10px;
            font-size: 16px;
        }

        .activity-list li span {
            flex-grow: 1;
        }

        .activity-list li .date {
            font-size: 12px;
            color: #6c757d;
        }

        /* Gift Cards Section */
        .gift-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .gift-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        .gift-image {
            height: 80px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-size: 24px;
        }

        .gift-details {
            padding: 12px;
        }

        .gift-details h5 {
            margin: 0 0 5px 0;
            font-size: 14px;
        }

        .gift-details p {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #6c757d;
        }

        .btn-redeem {
            width: 100%;
            padding: 5px;
            font-size: 12px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
        }

        /* Deals Section */
        .deals-grid {
            margin-top: 15px;
        }

        .deal-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
            position: relative;
        }

        .deal-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }

        .deal-badge.active {
            background-color: #d4edda;
            color: #155724;
        }

        .deal-badge.expired {
            background-color: #f8d7da;
            color: #721c24;
        }

        .deal-badge.special {
            background-color: #fff3cd;
            color: #856404;
        }

        .deal-card h5 {
            margin: 0 0 5px 0;
            font-size: 15px;
        }

        .deal-card p {
            margin: 0 0 5px 0;
            font-size: 13px;
            color: #6c757d;
        }

        .deal-code {
            font-size: 13px;
            font-weight: 500;
            color: #0d6efd;
            margin-top: 10px;
        }

        /* Partners Section */
        .partner-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
            position: relative;
            overflow: hidden;
        }

        .partner-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .partner-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
            color: white;
        }

        .partner-avatar.gradient-1 {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        }

        .partner-avatar.gradient-2 {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .partner-avatar.gradient-3 {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        }

        .partner-avatar.gradient-4 {
            background: linear-gradient(135deg, #ffc3a0 0%, #ffafbd 100%);
        }

        .partner-info h4 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .partner-info p {
            margin: 3px 0 0;
            font-size: 13px;
            color: #6c757d;
        }

        .partner-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #eee;
        }

        .stat-box {
            text-align: center;
            flex: 1;
        }

        .stat-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            margin-top: 3px;
        }

        .partner-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .btn-message,
        .btn-call {
            flex: 1;
            padding: 8px;
            border-radius: 6px;
            border: none;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-message {
            background-color: #e3f2fd;
            color: #0d6efd;
        }

        .btn-call {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .gift-cards {
                grid-template-columns: 1fr;
            }

            .welcome-avatar {
                font-size: 50px;
            }

            .welcome-section h2 {
                font-size: 22px;
            }

            .balance-amount {
                font-size: 30px;
            }
        }

        /* Loading Animation */
        .loading {
            text-align: center;
            padding: 40px 0;
        }

        .loading .spinner-border {
            width: 2.5rem;
            height: 2.5rem;
            border-width: 0.2em;
            color: #0d6efd;
        }

        /* Transition for content changes */
        .content-section {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Order Tabs */
        .order-tabs {
            display: flex;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 15px;
        }

        .order-tab {
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            color: #6c757d;
            border-bottom: 2px solid transparent;
        }

        .order-tab.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
            font-weight: 500;
        }

        /* Deal Tabs */
        .deal-tabs {
            display: flex;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 15px;
        }

        .deal-tab {
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            color: #6c757d;
            border-bottom: 2px solid transparent;
        }

        .deal-tab.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
            font-weight: 500;
        }

        /* Stats Card */
        .stats-card {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }

        .stat {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: #6c757d;
        }

        .content-section {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
        }

        .section-title {
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .contractor-info {
            margin-top: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }

        .info-value {
            flex: 1;
        }

        .document-section {
            margin-top: 30px;
        }

        .sub-title {
            color: #444;
            margin-bottom: 15px;
        }

        .document-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .document-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #fff;
        }

        .document-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #eee;
            margin-top: 10px;
        }
    </style>

    <script>
        // Mobile navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile nav items
            const mobileNavItems = document.querySelectorAll('.mobile-nav-item');

            mobileNavItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    mobileNavItems.forEach(navItem => {
                        navItem.classList.remove('active');
                    });

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Load the corresponding section
                    const section = this.getAttribute('data-section');
                    loadMobileSection(section);
                });
            });

            // Initialize with orders section active
            loadMobileSection('orders');
        });

        // Desktop navigation functionality
        function loadSection(section) {
            // Remove selected class from all items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('selected');
            });

            // Add selected class to clicked item
            event.currentTarget.classList.add('selected');

            // Show loading
            showLoading('content-area');

            // Load content
            setTimeout(() => {
                loadContent(section, 'content-area');
            }, 300);
        }

        // Mobile section loading
        function loadMobileSection(section) {
            // Show loading
            showLoading('mobile-content');

            // Load content
            setTimeout(() => {
                loadContent(section, 'mobile-content');
            }, 300);
        }

        function showLoading(containerId) {
            document.getElementById(containerId).innerHTML = `
        <div class="loading">
            <div class="spinner-border" role="status"></div>
        </div>
    `;
        }

        function loadContent(section, containerId) {
            let content = '';

            switch (section) {

                case 'orders':
                    content = `
                    <div class="content-section welcome-content">
                     <div class="content-section welcome-content">
                                <div class="welcome-section">
                                    <div class="welcome-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <h2><?php echo e(Auth::user()->name); ?></h2>
                                    <div class="personal-info">
                                        <p><i class="fas fa-envelope"></i> <?php echo e(Auth::user()->email); ?></p>
                                        <p><i class="fas fa-phone"></i> +91 <?php echo e(Auth::user()->phone); ?></p>
                                    </div>
                                    <div class="quick-stats">
                                        <a href="<?php echo e(route('contractor.myorders')); ?>" style="text-decoration: none;">
                                        <div class="stat-item">
                                            <i class="fas fa-box-open"></i>
                                            <span>3 Pending Orders</span>
                                        </div>
                                        </a>
                                        <a href="<?php echo e(route('contractor.myorders')); ?>" style="text-decoration: none;">
                                        <div class="stat-item">
                                            <i class="fas fa-coins"></i>
                                            <span>1 Delevred order</span>
                                        </div>
                                         </a>
                                    </div>
                                </div>
                            </div>
                </div>
            `;
                    break;

                case 'partners':
                    content = `
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-handshake"></i> My Partners</h3>
                    <div class="stats-card">
                        <div class="stat">
                            <div class="stat-value"><?php echo e($partners['total_users']); ?></div>
                            <div class="stat-label">Active Partners</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo e($partners['direct_user']); ?></div>
                            <div class="stat-label">Direct</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo e($partners['tier_user']); ?></div>
                            <div class="stat-label">Tear Wise</div>
                        </div>
                    </div>

                </div>
            `;
                    break;

                case 'sponsor-points':
                    content = `
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-coins"></i> Sponsor Points</h3>
                    <div class="points-balance">
                        <div class="balance-amount"><?php echo e($partners['gain_point'] + $partners['sponser_point']); ?></div>
                        <div class="balance-label">Available Points</div>
                    </div>
                    <div class="stats-card">
                        <div class="stat">
                            <div class="stat-value"><?php echo e($partners['sponser_point']); ?></div>
                            <div class="stat-label">Tear Points</div>
                        </div>
                          <div class="stat">
                            <div class="stat-value"><?php echo e($partners['gain_point']); ?></div>
                            <div class="stat-label">Self Points</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo e($partners['used_points']); ?></div>
                            <div class="stat-label">Used Points</div>
                        </div>
                    </div>

                </div>
            `;
                    break;

                case 'gift-redime':
                    content = `
                <div class="content-section">
                    <h3 class="section-title"><i class="fas fa-gift"></i> Gift Redemption</h3>
                    <div class="points-balance">
                        <div class="balance-amount">1,250</div>
                        <div class="balance-label">Available Points</div>
                        <div class="quick-stats">
                                        <a href="http://mlm.local/contractor/my-orders" style="text-decoration: none;">
                                        <div class="stat-item">
                                            <i class="fas fa-box-open"></i>
                                            <span>Gift redeam Orders</span>
                                        </div>
                                        </a>

                                    </div>
                    </div>

                </div>
            `;
                    break;

                case 'deals':
                    content = `
                <div class="content-section">

    <div class="contractor-info">
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value"><?php echo e($contractor->name); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value"><?php echo e($contractor->email); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value"><?php echo e($contractor->phone); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Aadhar Card:</span>
            <span class="info-value"><?php echo e($contractor->aadhar_card); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">PAN Card:</span>
            <span class="info-value"><?php echo e($contractor->pan_card); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Date of Birth:</span>
            <span class="info-value"><?php echo e($contractor->date_of_birth); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Address:</span>
            <span class="info-value"><?php echo e($contractor->address); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value"><?php echo e($contractor->status); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Points:</span>
            <span class="info-value"><?php echo e($contractor->points); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Verified At:</span>
            <span class="info-value"><?php echo e($contractor->verified_at); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Verified By:</span>
            <span class="info-value"><?php echo e($contractor->verified_by); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Referenced By:</span>
            <span class="info-value"><?php echo e($contractor->referenced_by); ?></span>
        </div>
    </div>

    <!-- For displaying file uploads (aadhar_photo and pan_photo) -->
    <div class="document-section">
        <h4 class="sub-title">Document Photos</h4>
        <div class="document-grid">
            <div class="document-card">
                <h5>Aadhar Card Photo</h5>
                <?php if($contractor->aadhar_photo): ?>
                    <img src="<?php echo e(asset('storage/' . $contractor->aadhar_photo)); ?>" alt="Aadhar Card Photo" class="document-image">
                <?php else: ?>
                    <p>No Aadhar photo uploaded</p>
                <?php endif; ?>
            </div>
            <div class="document-card">
                <h5>PAN Card Photo</h5>
                <?php if($contractor->pan_photo): ?>
                    <img src="<?php echo e(asset('storage/' . $contractor->pan_photo)); ?>" alt="PAN Card Photo" class="document-image">
                <?php else: ?>
                    <p>No PAN photo uploaded</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
            `;
                    break;
            }

            document.getElementById(containerId).innerHTML = content;

            // Initialize any tab functionality in the loaded content
            if (section === 'orders') {
                initOrderTabs();
            }
            if (section === 'deals') {
                initDealTabs();
            }
        }

        function initOrderTabs() {
            const tabs = document.querySelectorAll('.order-tab');
            const orderItems = document.querySelectorAll('.order-item');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Filter orders based on status
                    const status = this.getAttribute('data-type');
                    orderItems.forEach(item => {
                        const itemStatus = item.querySelector('.order-status').textContent
                            .toLowerCase();
                        if (status === 'pending') {
                            // Show all non-delivered orders
                            if (itemStatus !== 'delivered' && itemStatus !== 'cancelled') {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        } else if (itemStatus.includes(status)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        }

        function initDealTabs() {
            const tabs = document.querySelectorAll('.deal-tab');
            const dealCards = document.querySelectorAll('.deal-card');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Filter deals based on type
                    const type = this.getAttribute('data-type');
                    dealCards.forEach(card => {
                        const badgeType = card.querySelector('.deal-badge').textContent
                            .toLowerCase();
                        if (type === 'active' && badgeType === 'active') {
                            card.style.display = 'block';
                        } else if (type === 'expired' && badgeType === 'expired') {
                            card.style.display = 'block';
                        } else if (type === 'special' && badgeType === 'special') {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.contractor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\MLM\resources\views/contractor/profile.blade.php ENDPATH**/ ?>