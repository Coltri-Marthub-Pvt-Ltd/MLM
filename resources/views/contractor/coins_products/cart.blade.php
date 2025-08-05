@extends('layouts.contractor')

@section('title', 'Cart')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- Left: Cart Items -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header text-white font-weight-bold" style="background-color: rgb(243, 179, 116) !important;">
                        Cart Items
                    </div>
                    <ul class="list-group list-group-flush">
                        @if(count($carts) > 0)
                        @foreach ($carts as $item)
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                            alt="Product" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="mb-1 font-weight-bold">{{ $item->product->name }}</h5>
                                        </p>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <span class="font-weight-bold d-block">₹{{ number_format($item->price) }}</span>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="font-weight-bold d-block">{{ $item->points }}</span>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <input type="number" id="qtyInput" name="qty" value="{{ $item->qty }}"
                                            class="form-control" min="1" step="1" pattern="\d+"
                                            onchange="checkQty(this,{{ $item->id }},{{$item->product->id}})">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <form method="POST" action="{{ route('contractor.cart.remove', $item->id) }}"
                                            onsubmit="return confirm('Are you sure you want to remove this item from your cart?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash me-1"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        @else
                        <li class="list-group-item" style="text-align: center;">
                            empty
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- Right: Order Summary -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-white font-weight-bold" style="background-color: rgb(243, 179, 116) !important;">
                        Order Summary
                    </div>
                     @if(count($carts) > 0)
                    <div class="card-body">
                        <p class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($carts->sum('price') ?? 0.0) }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <span>Points</span>
                            <span>{{ $carts->sum('points') ?? 0 }}</span>
                        </p>
                        <hr>
                        <p class="d-flex justify-content-between font-weight-bold">
                            <span>Total</span>
                            <span>₹{{ number_format($carts->sum('price') ?? 0.0) }}</span>
                        </p>
                        <a href="{{route('contractor.cart.checkout')}}" class="btn btn-success btn-block">Proceed to Checkout</a>
                    </div>
                     @else
                        <p style="text-align: center;">
                            empty
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
    function checkQty(input, id, product_id) {
        let qty = input.value;

        if (qty === '' || parseInt(qty) < 1) {
            alert("Quantity must be at least 1.");
            input.value = 1;
            return false;
        }

        $.ajax({
            url: "{{ route('contractor.cart.update') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                qty: qty,
                product_id: product_id
            },
            success: function(response) {
                if (response.success) {
                   window.location.href = '/contractor/cart';

                }
            }
        });
    }
</script>

@endsection
