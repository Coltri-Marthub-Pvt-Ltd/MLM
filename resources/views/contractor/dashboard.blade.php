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
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        @foreach($giuft_card as $gift)
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="{{ $gift->image ? asset($gift->image) : asset('https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg') }}" alt="Gift Image"
                                                   class="img-fluid" width="55px" height="55px">
                                            </div>
                                            <div>
                                               <!-- <p>{{ \Illuminate\Support\Str::limit($gift->name, 30) }}</p> -->

                                            <p class="d-md-none">{{ \Illuminate\Support\Str::limit($gift->description, 30) }}</p>

                                            <p class="d-none d-md-block">{{ \Illuminate\Support\Str::limit($gift->description, 60) }}</p>
                                            </div>
                                        </div>
                                        @endforeach
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
                                             <a href="{{ route('contractor.products.brand.product',['brands',$top_brands->id]) }}">
                                            <div class="">
                                                {{$top_brands->name}}
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                               @foreach($brands as $brand)
                               <div class="col-6 mb-3">
                                        <a href="{{ route('contractor.products.brand.product',['brands',$brand->id]) }}">
                                        <div class="card shadow-sm border m-0 ratio ratio-1x1">
                                            <div class="card-body p-0 d-flex justify-content-center align-items-center"
                                                style="background-image: url('{{ asset($brand->image) }}'); background-size: cover; background-position: center;">
                                                <div style="color: white; text-shadow: 1px 1px 3px rgba(0,0,0,0.8); background-color: rgba(0,0,0,0.3); padding: 10px 15px;">
                                                    {{$brand->name}}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
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
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        @foreach($limitschame as $gift)
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="{{ $gift->image ? asset($gift->image) : asset('https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg') }}" alt="Gift Image"
                                                   class="img-fluid" width="55px" height="55px">
                                            </div>
                                            <div>
                                               <!-- <p>{{ \Illuminate\Support\Str::limit($gift->name, 30) }}</p> -->

                                            <p class="d-md-none">{{ \Illuminate\Support\Str::limit($gift->description, 30) }}</p>

                                            <p class="d-none d-md-block">{{ \Illuminate\Support\Str::limit($gift->description, 60) }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </li>
                                </ul>
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
                                                <th>Title</th>
                                                <th>Descriptions</th>
                                                <th>Valid Until</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($deal as $val)

                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>{{ $val->title }}</strong>
                                                        {{-- <br><small class="text-muted">First purchase discount</small> --}}
                                                    </div>
                                                </td>
                                                <td>{{ $val->description }} {{$val->product ? 'product name: '.$val->product->name: '' }} {{$val->coins ? 'Coins : '.$val->coins: '' }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($val->start_date)->format('d-M-Y') }}
                                                    to
                                                    {{ \Carbon\Carbon::parse($val->end_date)->format('d-M-Y') }}
                                                </td>

                                                <td>
                                                    <td>
                                                        @if(!$val->accepted)
                                                        <button class="btn btn-sm btn-primary accept-btn" data-id="{{ $val->id }}">Accept</button>
                                                        @else
                                                        <button class="btn btn-sm btn-success " data-id="{{ $val->id }}">Accepted</button>
                                                        @endif
                                                    </td>
                                                </td>
                                            </tr>
                                             @endforeach
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
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        @foreach($new as $gift)
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="{{ $gift->image ? asset($gift->image) : asset('https://png.pngtree.com/png-clipart/20190614/original/pngtree-vector-picture-icon-png-image_3792401.jpg') }}" alt="Gift Image"
                                                   class="img-fluid" width="55px" height="55px">
                                            </div>
                                            <div>
                                               <!-- <p>{{ \Illuminate\Support\Str::limit($gift->name, 30) }}</p> -->

                                            <p class="d-md-none">{{ \Illuminate\Support\Str::limit($gift->description, 30) }}</p>

                                            <p class="d-none d-md-block">{{ \Illuminate\Support\Str::limit($gift->description, 60) }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </li>
                                </ul>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.accept-btn', function() {
    var dealId = $(this).data('id');
    var btn = $(this);

    $.ajax({
        url: "{{ route('admin.deal.accept') }}",
        method: "POST",
        data: {
            id: dealId,
            _token: "{{ csrf_token() }}"
        },
        beforeSend: function() {
            btn.prop('disabled', true).text('Processing...');
        },
        success: function(response) {
            if (response.status === 'success') {
                btn.removeClass('btn-primary').addClass('btn-success').text('Accepted');
            } else {
                btn.prop('disabled', false).text('Accept');
                alert(response.message);
            }
        },
        error: function() {
            btn.prop('disabled', false).text('Accept');
            alert('Something went wrong.');
        }
    });
});
</script>

@endpush
