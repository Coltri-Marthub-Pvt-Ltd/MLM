@extends('layouts.contractor')

@section('title', 'Leaderboard')

@section('content')
    <div class="page-content">
        <!-- Page Header -->
        <div class="leaderboard-container">
            <div class="d-flex align-items-center mb-3 d-md-none">
                <a href="{{ url()->previous() }}" class="back-btn-mobile">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="mb-0">Leaderboard</h5>
            </div>

            @foreach ($leaders as $index => $leader)
                <!-- Rest of your leader cards -->
            @endforeach
        </div>
        <!-- Badge Categories Filter - Mobile Optimized -->
        <div class="filter-card mb-3">
            <div class="row g-2">
                <div class="col-12">
                    <div class="badge-filters-scroll">
                        <div class="d-flex flex-nowrap overflow-auto pb-2">
                            <button class="badge-filter-btn active flex-shrink-0" data-badge="all">
                                <i class="bi bi-trophy me-1"></i>
                                All
                            </button>
                            @foreach ($badges as $badge)
                                <button class="badge-filter-btn flex-shrink-0" data-badge="{{ $badge->name }}">
                                    <img src="{{ asset($badge->image) }}" width="15" class="me-1">
                                    {{ $badge->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard - Mobile Optimized -->
        <div class="leaderboard-container">
            @foreach ($leaders as $index => $leader)
                <div class="leader-card-mobile" data-badges="{{ $leader['badges'] }}">
                    <div class="leader-rank-mobile">
                        @if ($index < 3)
                            <div class="rank-medal-mobile rank-{{ $index + 1 }}">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                        @else
                            <div class="rank-number-mobile">{{ $index + 1 }}</div>
                        @endif
                    </div>

                    <div class="leader-main-mobile">
                        <div class="leader-avatar-mobile">
                            <div class="avatar-circle-mobile">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>

                        <div class="leader-info-mobile">
                            <div class="leader-name-mobile">{{ $leader['name'] }}</div>
                            <div class="leader-badges-mobile">
                                @foreach (explode(',', $leader['badges']) as $badge)
                                    <span class="badge-item-mobile badge-{{ trim($badge) }}">
                                        <i class="bi bi-award me-1"></i>
                                        {{ ucfirst(trim($badge)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="leader-stats-mobile">
                        <div class="stat-item-mobile">
                            <div class="stat-value-mobile">{{ $leader['points'] }}</div>
                            <div class="stat-label-mobile">Points</div>
                        </div>
                        <div class="stat-item-mobile">
                            <div class="stat-value-mobile">{{ $leader['sponsors'] }}</div>
                            <div class="stat-label-mobile">Sponsors</div>
                        </div>
                        <div class="stat-item-mobile">
                            <div class="stat-value-mobile">{{ $leader['orders'] }}</div>
                            <div class="stat-label-mobile">Orders</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div class="no-results" style="display: none;">
            <div class="card text-center p-3">
                <div class="card-body">
                    <i class="bi bi-emoji-frown mb-2" style="font-size: 2.5rem; color: var(--contractor-primary);"></i>
                    <h5 style="color: var(--contractor-dark);">No Leaders Found</h5>
                    <p class="text-muted mb-3 small">
                        No leaders match the selected badge category.
                    </p>
                    <button class="btn btn-contractor btn-sm" onclick="showAllLeaders()">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Show All Leaders
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Mobile-first styles */
        .badge-filters-scroll {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .badge-filter-btn {
            padding: 8px 12px;
            margin-right: 8px;
            border-radius: 20px;
            border: 1px solid #ddd;
            background: white;
            font-size: 0.8rem;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
        }

        .badge-filter-btn.active {
            background-color: var(--contractor-primary);
            color: white;
            border-color: var(--contractor-primary);
        }

        .leader-card-mobile {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .leader-main-mobile {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .leader-rank-mobile {
            position: absolute;
            top: 12px;
            left: 12px;
        }

        .rank-medal-mobile {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .rank-medal-mobile.rank-1 {
            background: gold;
            color: white;
        }

        .rank-medal-mobile.rank-2 {
            background: silver;
            color: white;
        }

        .rank-medal-mobile.rank-3 {
            background: #cd7f32;
            color: white;
        }

        .rank-number-mobile {
            font-size: 0.9rem;
            font-weight: bold;
            color: #666;
        }

        .leader-avatar-mobile {
            margin-right: 12px;
            margin-left: 24px;
        }

        .avatar-circle-mobile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--contractor-primary);
        }

        .leader-info-mobile {
            flex: 1;
        }

        .leader-name-mobile {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .leader-badges-mobile {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .badge-item-mobile {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            background: #f0f0f0;
            display: inline-flex;
            align-items: center;
        }

        .leader-stats-mobile {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }

        .stat-item-mobile {
            text-align: center;
            flex: 1;
        }

        .stat-value-mobile {
            font-weight: bold;
            font-size: 0.9rem;
        }

        .stat-label-mobile {
            font-size: 0.7rem;
            color: #666;
        }

        /* Desktop overrides */
        @media (min-width: 768px) {
            .leader-card-mobile {
                flex-direction: row;
                align-items: center;
                padding: 15px;
            }

            .leader-main-mobile {
                flex: 1;
                margin-bottom: 0;
            }

            .leader-stats-mobile {
                border-top: none;
                padding-top: 0;
                flex: 0 0 250px;
                justify-content: space-around;
            }
        }

        /* Add this to your existing styles */
        .page-header-mobile {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: white;
            border-bottom: 1px solid #eee;
            margin: -15px -15px 15px -15px;
        }

        .back-btn-mobile {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f5f5f5;
            margin-right: 10px;
            color: var(--contractor-primary);
            text-decoration: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const badgeFilters = document.querySelectorAll('.badge-filter-btn');
            const leaderCards = document.querySelectorAll('.leader-card-mobile');
            const noResults = document.querySelector('.no-results');
            const leaderboardContainer = document.querySelector('.leaderboard-container');

            badgeFilters.forEach(filter => {
                filter.addEventListener('click', function() {
                    // Remove active class from all filters
                    badgeFilters.forEach(f => f.classList.remove('active'));
                    // Add active class to clicked filter
                    this.classList.add('active');

                    const selectedBadge = this.getAttribute('data-badge');
                    filterLeaders(selectedBadge);
                });
            });

            function filterLeaders(badge) {
                let visibleCount = 0;

                leaderCards.forEach(card => {
                    const cardBadges = card.getAttribute('data-badges').split(',');
                    const hasBadge = badge === 'all' || cardBadges.some(b => b.trim().toLowerCase() ===
                        badge.toLowerCase());

                    if (hasBadge) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0) {
                    leaderboardContainer.style.display = 'none';
                    noResults.style.display = 'block';
                } else {
                    leaderboardContainer.style.display = 'block';
                    noResults.style.display = 'none';
                }
            }

            // Global function for no results button
            window.showAllLeaders = function() {
                badgeFilters.forEach(f => f.classList.remove('active'));
                document.querySelector('[data-badge="all"]').classList.add('active');
                filterLeaders('all');
            };
        });
    </script>
@endpush
