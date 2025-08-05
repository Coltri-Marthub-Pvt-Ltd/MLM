@extends('layouts.contractor')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
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
    <div class="row">
        <div class="col-lg-6">
            <!-- Product Image -->
            <div class="contractor-card">
                <div class="contractor-card-content text-center">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm"
                        style="max-height: 500px; width: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Product Information -->
            <div class="contractor-card">
                <div class="contractor-card-content">
                    @if ($product->category)
                        <div class="product-category mb-3">
                            {{ $product->category->name }}
                        </div>
                    @endif

                    <h1 class="h2 mb-3" style="color: var(--contractor-dark); font-weight: 700;">
                        {{ $product->name }}
                    </h1>

                    <!-- Price and Points -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="text-center p-3" style="background: rgba(5, 150, 105, 0.1); border-radius: 8px;">
                                <h3 class="mb-1" style="color: #059669; font-weight: 700;">
                                   <i class="bi bi-coin me-1"></i>
                                    {{ $product->points ?? 0 }} Coins
                                </h3>
                                <small class="text-muted">Reward Coins</small>
                            </div>
                        </div>
                       
                    </div>

                    <!-- Product Description -->
                    @if ($product->description)
                        <div class="mb-4">
                            <h5 style="color: var(--contractor-dark); font-weight: 600; margin-bottom: 1rem;">
                                <i class="bi bi-info-circle me-2"></i>
                                Product Description
                            </h5>
                            <div style="color: #6B7280; line-height: 1.6;">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Product Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 style="color: var(--contractor-dark); font-weight: 600; margin-bottom: 1rem;">
                                <i class="bi bi-clipboard-data me-2"></i>
                                Product Details
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500;">Product ID:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600;">#{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500;">Category:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600;">
                                        @if ($product->category)
                                            {{ $product->category->name }}
                                        @else
                                            Uncategorized
                                        @endif
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500;">Added On:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600;">
                                        {{ $product->created_at->format('F j, Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6B7280; font-weight: 500;">Qty:</td>
                                    <td style="color: var(--contractor-dark); font-weight: 600;">
                                        <input type="number" id="qtyInput" name="qty" value="1"
                                            class="form-control" style="width:30%;" min="1" step="1"
                                            pattern="\d+" onblur="checkQty(this)">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3">
                       
                        @if ($product->order->where('status','==',0)->count() > 0)
                         <a href="{{route('contractor.myorders')}}" class="btn btn-success" data-id="{{ $product->id }}">
                                <i class="bi bi-arrow-left me-2"></i>
                                Go to Order
                            </a>
                            @else
                           
                            <button class="btn btn-contractor" id="addToProceed" data-id="{{ $product->id }}">
                                <i class="bi bi-arrow-left me-2"></i>
                                 Proceed to Order
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if ($relatedProducts->count() > 0)
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 style="color: var(--contractor-dark); font-weight: 700;">
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

            <div class="row">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="product-card">
                            <a href="{{ route('contractor.products.show', $relatedProduct) }}"
                                class="text-decoration-none">
                                <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}"
                                    class="product-image">
                                <div class="product-info">
                                    @if ($relatedProduct->category)
                                        <div class="product-category">
                                            {{ $relatedProduct->category->name }}
                                        </div>
                                    @endif

                                    <h6 class="product-title">{{ $relatedProduct->name }}</h6>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="product-price" style="font-size: 1rem;">
                                            {{ $relatedProduct->formatted_price }}
                                        </div>
                                        <div class="product-points" style="font-size: 0.8rem;">
                                            <i class="bi bi-star-fill me-1"></i>
                                            {{ $relatedProduct->points ?? 0 }} pts
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



        $('#addToProceed').click(function() {
            let productId = $(this).data('id');
            let qty = getQty();
            $.ajax({
                url: "{{ route('contractor.coins-products.proceed') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    qty: qty
                },
                success: function(response) {
                    if (response.success) {
                       $('#addToProceed').replaceWith(`
                        <a href="{{ route('contractor.myorders') }}" class="btn btn-success" data-id="${response.product_id}">
                            <i class="bi bi-cart-check me-1"></i>
                            Go to Order
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
                            '/my-orders');
                    }
                }
            });
        });
    </script>
@endsection

@push('styles')
    <style>
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--contractor-primary);
        }

        .table td {
            padding: 0.75rem 0;
            border: none;
        }

        .product-card {
            height: 300px;
        }

        .product-card .product-image {
            height: 150px;
        }

        .product-card .product-info {
            padding: 1rem;
        }

        .product-card .product-title {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }
    </style>
@endpush
