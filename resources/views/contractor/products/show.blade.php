@extends('layouts.contractor')

@section('title', $product->name)

@section('content')
    <!-- Mobile Back Button (Only visible on mobile) -->
    <div class="d-lg-none d-flex align-items-center mb-3">
        <a href="{{ route('contractor.products.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left" style="font-size: 1.5rem; color: var(--contractor-primary);"></i>
        </a>
        <h5 class="ms-2 mb-0" style="color: var(--contractor-dark);">{{ $product->name }}</h5>
    </div>

    <!-- Breadcrumb (Hidden on mobile) -->
    <nav aria-label="breadcrumb" class="mb-5 d-none d-lg-block">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('contractor.products.index') }}" style="color: var(--contractor-primary);">Products</a>
            </li>
            @if ($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('contractor.products.index', ['category' => $product->category->id]) }}"
                        style="color: var(--contractor-primary);">{{ $product->category->name }}</a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="row g-3 g-lg-4">
        <div class="col-lg-6">
            <!-- Product Image -->
            <div class="contractor-card h-100">
                <div class="contractor-card-content p-2 p-lg-3 text-center">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm"
                        style="max-height: 500px; width: 100%; object-fit: contain;">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Product Information -->
            <div class="contractor-card h-100">
                <div class="contractor-card-content p-3 p-lg-4">
                    @if ($product->category)
                        <div class="product-category mb-2 text-muted small">
                            {{ $product->category->name }}
                        </div>
                    @endif

                    <h1 class="h3 mb-3 d-none d-lg-block" style="color: var(--contractor-dark); font-weight: 700;">
                        {{ $product->name }}
                    </h1>

                    <!-- Price and Points -->
                    <div class="row mb-3 mb-lg-4 g-2 g-lg-3">
                        <div class="col-md-6">
                            <div class="p-2 p-lg-3" style="background: rgba(5, 150, 105, 0.1); border-radius: 8px;">
                                <h3 class="mb-1 text-center" style="color: #059669; font-weight: 700; font-size: 1.2rem;">
                                    {{ $product->formatted_price }}
                                </h3>
                                <small class="text-muted d-block text-center" style="font-size: 0.75rem;">Market
                                    Price</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2 p-lg-3" style="background: rgba(243, 179, 116, 0.1); border-radius: 8px;">
                                <h3 class="mb-1 text-center"
                                    style="color: var(--contractor-primary); font-weight: 700; font-size: 1.2rem;">
                                    <i class="bi bi-coin me-1"></i>
                                    {{ $product->points ?? 0 }} coins
                                </h3>
                                <small class="text-muted d-block text-center" style="font-size: 0.75rem;">Reward
                                    Coins</small>
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    @if ($product->description)
                        <div class="mb-3 mb-lg-4">
                            <h5 class="mb-2 mb-lg-3"
                                style="color: var(--contractor-dark); font-weight: 600; font-size: 1rem;">
                                <i class="bi bi-info-circle me-2"></i>
                                Product Description
                            </h5>
                            <div style="color: #6B7280; line-height: 1.6; font-size: 0.875rem;">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Product Details -->
                    <div class="mb-3 mb-lg-4">
                        <h5 class="mb-2 mb-lg-3" style="color: var(--contractor-dark); font-weight: 600; font-size: 1rem;">
                            <i class="bi bi-clipboard-data me-2"></i>
                            Product Details
                        </h5>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500; width: 40%; font-size: 0.875rem;">Product
                                        ID:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600; font-size: 0.875rem;">
                                        #{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500; font-size: 0.875rem;">Category:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600; font-size: 0.875rem;">
                                        @if ($product->category)
                                            {{ $product->category->name }}
                                        @else
                                            Uncategorized
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500; font-size: 0.875rem;">Reward Coins:</td>
                                    <td style="color: var(--contractor-primary); font-weight: 600; font-size: 0.875rem;">
                                        {{ $product->points ?? 0 }} points
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500; font-size: 0.875rem;">Added On:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600; font-size: 0.875rem;">
                                        {{ $product->created_at->format('F j, Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500; font-size: 0.875rem;">Quantity:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600;">
                                        <input type="number" id="qtyInput" name="qty" value="1"
                                            class="form-control d-inline-block" style="width:80px; font-size: 0.875rem;"
                                            min="1" step="1" pattern="\d+" onblur="checkQty(this)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 gap-lg-3 mt-3 mt-lg-4 flex-column flex-sm-row">
                        <button class="btn btn-contractor-outline flex-grow-1 py-2" id="orderNowBtn"
                            data-id="{{ $product->id }}" style="font-size: 0.875rem;">
                            <i class="bi bi-arrow-left me-2"></i>
                            Proceed to Order
                        </button>
                        @if (!$product->cart)
                            <button class="btn btn-contractor flex-grow-1 py-2" id="addToCartBtn"
                                data-id="{{ $product->id }}" style="font-size: 0.875rem;">
                                <i class="bi bi-cart-check me-1"></i>
                                Add to Cart
                            </button>
                        @else
                            <a href="{{ route('contractor.show.cart') }}" class="btn btn-success flex-grow-1 py-2"
                                data-id="{{ $product->id }}" style="font-size: 0.875rem;">
                                <i class="bi bi-cart-check me-1"></i>
                                Go to Cart
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products (Hidden on mobile) -->
    @if ($relatedProducts->count() > 0)
        <div class="mt-5 pt-4 d-none d-lg-block">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="h4" style="color: var(--contractor-dark); font-weight: 700;">
                    <i class="bi bi-grid me-2"></i>
                    Related Products
                </h3>
                @if ($product->category)
                    <a href="{{ route('contractor.products.index', ['category' => $product->category->id]) }}"
                        class="btn btn-contractor-outline btn-sm">
                        <i class="bi bi-arrow-right me-1"></i>
                        View All in {{ $product->category->name }}
                    </a>
                @endif
            </div>

            <div class="row g-3">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="product-card h-100">
                            <a href="{{ route('contractor.products.show', $relatedProduct) }}"
                                class="text-decoration-none d-block h-100">
                                <div class="h-100 d-flex flex-column">
                                    <div class="flex-grow-1 d-flex align-items-center p-3">
                                        <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}"
                                            class="product-image img-fluid mx-auto"
                                            style="max-height: 150px; object-fit: contain;">
                                    </div>
                                    <div class="product-info p-3">
                                        @if ($relatedProduct->category)
                                            <div class="product-category small text-muted mb-1">
                                                {{ $relatedProduct->category->name }}
                                            </div>
                                        @endif

                                        <h6 class="product-title mb-2">{{ $relatedProduct->name }}</h6>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="product-price fw-bold">
                                                {{ $relatedProduct->formatted_price }}
                                            </div>
                                            <div class="product-points text-contractor">
                                                <i class="bi bi-star-fill me-1"></i>
                                                {{ $relatedProduct->points ?? 0 }} pts
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function getQty() {
            let qty = parseInt(document.getElementById('qtyInput').value);
            return isNaN(qty) || qty < 1 ? 1 : qty;
        }

        function checkQty(input) {
            const value = input.value;

            // If empty or less than 1
            if (value === '' || parseInt(value) < 1) {
                alert("Quantity must be at least 1.");
                input.value = 1;
            }
        }

        $('#addToCartBtn').click(function() {
            let productId = $(this).data('id');
            let qty = getQty();
            $.ajax({
                url: "{{ route('contractor.products.cart') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    qty: qty
                },
                success: function(response) {
                    if (response.success) {
                        $('#addToCartBtn').replaceWith(`
                        <a href="{{ route('contractor.show.cart') }}" class="btn btn-success flex-grow-1 py-2" data-id="${response.product_id}" style="font-size: 0.875rem;">
                            <i class="bi bi-cart-check me-1"></i>
                            Go to Cart
                        </a>
                    `);
                    }
                }
            });
        });

        $('#orderNowBtn').click(function() {
            let productId = $(this).data('id');
            let qty = getQty();
            $.ajax({
                url: "{{ route('contractor.products.myorder') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    qty: qty
                },
                success: function(response) {
                    if (response.success) {
                        $('#orderNowBtn').html(
                            '<i class="bi bi-box-arrow-in-right me-2"></i> Go to My Orders');
                        $('#orderNowBtn').removeClass('btn-contractor-outline').addClass('btn-info');
                        $('#orderNowBtn').off().click(() => window.location.href =
                            '/contractor/my-orders');
                    }
                }
            });
        });





        $('#orderNowBtn').click(function() {
            let productId = $(this).data('id');
            let qty = getQty();
            let btn = $(this);

            // Show loading state
            btn.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking...'
                );
            btn.prop('disabled', true);

            // First check if order exists with status 5
           $.ajax({
    url: "{{ route('contractor.products.check-order') }}",
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        product_id: productId
    },
    success: function(response) {
        if (response.exists) {
            // Show confirmation dialog only if status is 5
            console.log('testing',response.status);
            if (response.status != 3) {
                if (confirm(response.message + '\n\nAre you sure you want to create another order?')) {
                    proceedWithOrder(productId, qty, btn);
                } else {
                    resetButton(btn);
                }
            } else {
                // For other statuses, just proceed
                proceedWithOrder(productId, qty, btn);
            }
        } else {
            // No existing order, proceed normally
            proceedWithOrder(productId, qty, btn);
        }
    },
    error: function(xhr) {
        toastr.error(xhr.responseJSON.message || 'Error checking order status');
        resetButton(btn);
    }
})
        });

        function proceedWithOrder(productId, qty, btn) {

            btn.html('<span class="spinner-border spinner-border-sm"></span> Processing...');

            $.ajax({
                url: "{{ route('contractor.products.order') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    qty: qty
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = "{{ route('contractor.myorders') }}";
                        }, 1500);
                    } else {
                        toastr.error(response.message);
                        resetButton(btn);
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || 'An error occurred');
                    resetButton(btn);
                }
            });
        }

        function resetButton(btn) {
            btn.html('<i class="bi bi-arrow-left me-2"></i> Proceed to Order');
            btn.prop('disabled', false);
        }
    </script>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Add to your existing styles */
        .btn-processing {
            position: relative;
        }

        .btn-processing:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -8px 0 0 -8px;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .breadcrumb {
            background: transparent;
            padding: 0.75rem 0;
            margin-bottom: 0;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--contractor-primary);
        }

        .table td {
            padding: 0.5rem 0;
            border: none;
            vertical-align: middle;
        }

        .product-card {
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e5e7eb;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .product-card .product-info {
            background: white;
        }

        .product-card .product-title {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            color: var(--contractor-dark);
            font-weight: 600;
            height: 2.5em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-card .product-price {
            color: var(--contractor-dark);
        }

        .product-card .product-category {
            color: var(--contractor-primary);
            font-size: 0.8rem;
        }

        .contractor-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            background: white;
        }

        .contractor-card-content {
            padding: 1rem;
        }

        .btn-contractor-outline {
            border: 2px solid var(--contractor-primary);
            color: var(--contractor-primary);
            font-weight: 600;
        }

        .btn-contractor-outline:hover {
            background-color: var(--contractor-primary);
            color: white;
        }

        /* Mobile-specific styles */
        @media (max-width: 767.98px) {
            body {
                font-size: 12px;
            }

            .contractor-card-content {
                padding: 0.75rem;
            }

            .d-flex.gap-3 {
                flex-direction: column;
                gap: 0.75rem !important;
            }

            .h3,
            h1.h3 {
                font-size: 1.25rem;
            }

            .h5,
            h5 {
                font-size: 1rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }

            .table td,
            .table th {
                padding: 0.25rem 0;
                font-size: 0.875rem;
            }

            #qtyInput {
                font-size: 0.875rem;
                padding: 0.25rem 0.5rem;
                width: 70px;
            }
        }
    </style>
@endpush
