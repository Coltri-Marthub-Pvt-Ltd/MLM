@extends('layouts.contractor')

@section('title', $product->name)

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    :root {
        --flipkart-blue: #2874f0;
        --flipkart-orange: #fb641b;
        --flipkart-light: #f1f3f6;
        --flipkart-dark: #212121;
        --flipkart-gray: #878787;
        --flipkart-white: #ffffff;
    }

    .product-detail-container {
        background-color: var(--flipkart-light);
        min-height: 100vh;
        font-family: 'Roboto', sans-serif;
        padding: 15px;
    }

    .back-link {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        color: var(--flipkart-blue);
        text-decoration: none;
        font-size: 14px;
    }

    .back-link i {
        margin-right: 5px;
    }

    .product-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .product-image-col {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0 15px;
        margin-bottom: 15px;
    }

    .product-info-col {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0 15px;
    }

    .product-card {
        background: var(--flipkart-white);
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .product-image-container {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-image {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
    }

    .product-info-content {
        padding: 15px;
    }

    .product-category {
        font-size: 12px;
        color: var(--flipkart-gray);
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .product-title {
        font-size: 18px;
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-bottom: 15px;
    }

    .points-badge {
        background: rgba(5, 150, 105, 0.1);
        border-radius: 4px;
        padding: 10px;
        text-align: center;
        margin-bottom: 15px;
    }

    .points-value {
        font-size: 18px;
        font-weight: 500;
        color: #059669;
        margin-bottom: 5px;
    }

    .points-label {
        font-size: 12px;
        color: var(--flipkart-gray);
    }

    .section-title {
        font-size: 15px;
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 8px;
    }

    .product-description {
        font-size: 13px;
        color: var(--flipkart-gray);
        line-height: 1.6;
        margin-bottom: 15px;
        white-space: pre-line;
    }

    .details-table {
        width: 100%;
    }

    .details-table td {
        padding: 8px 0;
        vertical-align: top;
    }

    .details-label {
        font-size: 13px;
        color: var(--flipkart-gray);
        font-weight: 500;
        width: 120px;
    }

    .details-value {
        font-size: 13px;
        color: var(--flipkart-dark);
        font-weight: 500;
    }

    .qty-input {
        width: 60px;
        padding: 5px;
        border: 1px solid #e0e0e0;
        border-radius: 2px;
        text-align: center;
    }

    .action-btns {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .action-btn {
        padding: 10px 15px;
        border-radius: 2px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .primary-btn {
        background: var(--flipkart-blue);
        color: white;
        border: none;
    }

    .success-btn {
        background: #059669;
        color: white;
        border: none;
    }

    .related-products {
        margin-top: 30px;
    }

    .related-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .related-title {
        font-size: 16px;
        font-weight: 500;
        color: var(--flipkart-dark);
    }

    .view-all {
        font-size: 13px;
        color: var(--flipkart-blue);
        text-decoration: none;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    @media (min-width: 768px) {
        .product-image-col {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .product-info-col {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .related-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (min-width: 992px) {
        .product-image-col {
            flex: 0 0 40%;
            max-width: 40%;
        }

        .product-info-col {
            flex: 0 0 60%;
            max-width: 60%;
        }
    }
</style>

<div class="product-detail-container">
    <a href="{{ url()->previous() }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <div class="product-row">
        <div class="product-image-col">
            <div class="product-card">
                <div class="product-image-container">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                </div>
            </div>
        </div>

        <div class="product-info-col">
            <div class="product-card">
                <div class="product-info-content">
                    @if ($product->category)
                        <div class="product-category">{{ $product->category->name }}</div>
                    @endif

                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="points-badge">
                        <div class="points-value">
                            <i class="fas fa-coins"></i> {{ $product->points ?? 0 }} Coins
                        </div>
                        <div class="points-label">Reward Coins</div>
                    </div>

                    @if ($product->description)
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i> Product Description
                        </div>
                        <div class="product-description">
                            {{ $product->description }}
                        </div>
                    @endif

                    <table class="details-table">
                        <tr>
                            <td class="details-label">Product ID:</td>
                            <td class="details-value">#{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <td class="details-label">Category:</td>
                            <td class="details-value">
                                @if ($product->category)
                                    {{ $product->category->name }}
                                @else
                                    Uncategorized
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="details-label">Added On:</td>
                            <td class="details-value">
                                {{ $product->created_at->format('F j, Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="details-label">Qty:</td>
                            <td class="details-value">
                                <input type="number" id="qtyInput" name="qty" value="1"
                                    class="qty-input" min="1" step="1"
                                    pattern="\d+" onblur="checkQty(this)">
                            </td>
                        </tr>
                    </table>

                    <div class="action-btns">
                        @if ($product->order->where('status','==',0)->count() > 0)
                            <a href="{{route('contractor.myorders')}}" class="action-btn success-btn">
                                <i class="fas fa-shopping-cart"></i> Go to Order
                            </a>
                        @else
                            <button class="action-btn primary-btn" id="addToProceed" data-id="{{ $product->id }}">
                                <i class="fas fa-arrow-right"></i> Proceed to Order
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($relatedProducts->count() > 0)
        <div class="related-products">
            <div class="related-header">
                <h3 class="related-title">
                    <i class="fas fa-th-large"></i> Related Products
                </h3>
                @if ($product->category)
                    <a href="{{ route('contractor.products.index', ['category' => $product->category->id]) }}" class="view-all">
                        View All <i class="fas fa-chevron-right"></i>
                    </a>
                @endif
            </div>

            <div class="related-grid">
                @foreach ($relatedProducts as $relatedProduct)
                    <a href="{{ route('contractor.products.show', $relatedProduct) }}" class="product-card">
                        <div class="product-image-container">
                            <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" class="product-image">
                        </div>
                        <div class="product-info-content">
                            <h6 class="product-title">{{ $relatedProduct->name }}</h6>
                            <div class="points-value" style="font-size: 14px;">
                                <i class="fas fa-coins"></i> {{ $relatedProduct->points ?? 0 }} coins
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    function getQty() {
        let qty = parseInt(document.getElementById('qtyInput').value);
        return isNaN(qty) || qty < 1 ? 1 : qty;
    }

    function checkQty(input) {
        const value = input.value;
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
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = "{{ route('contractor.myorders') }}";
                        }, 1500);

                         $('#addToProceed').replaceWith(`
                        <a href="{{ route('contractor.myorders') }}" class="action-btn success-btn">
                            <i class="fas fa-shopping-cart"></i> Go to Order
                        </a>
                    `);
                    } else {
                        toastr.error(response.message);
                        resetButton(btn);
                    }

            }
        });
    });
</script>
@endsection
