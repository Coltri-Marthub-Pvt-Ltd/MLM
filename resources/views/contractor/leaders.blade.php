@extends('layouts.contractor')

@section('title', 'Leaderboard')

@section('content')
    <div class="page-content">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0" style="color: var(--contractor-dark); font-weight: 700;">Leaderboard</h1>
                <p class="text-muted mb-0">Top performers and achievers</p>
            </div>
            <div class="text-muted d-none d-md-block">
                {{ count($leaders) }} leaders
            </div>
        </div>

        <!-- Mobile Leader Count -->
        <div class="d-md-none mb-3">
            <div class="text-muted text-center">
                {{ count($leaders) }} leaders
            </div>
        </div>

        <!-- Badge Categories Filter -->
        <div class="filter-card mb-4">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Filter by Badge Category</label>
                    <div class="badge-filters">
                        <button class="badge-filter-btn active" data-badge="all">
                            <i class="bi bi-trophy me-2"></i>
                            All Categories
                        </button>
                        <button class="badge-filter-btn" data-badge="bronze">
                            <i class="bi bi-award me-2"></i>
                            Bronze
                        </button>
                        <button class="badge-filter-btn" data-badge="silver">
                            <i class="bi bi-award me-2"></i>
                            Silver
                        </button>
                        <button class="badge-filter-btn" data-badge="gold">
                            <i class="bi bi-award me-2"></i>
                            Gold
                        </button>
                        <button class="badge-filter-btn" data-badge="platinum">
                            <i class="bi bi-award me-2"></i>
                            Platinum
                        </button>
                        <button class="badge-filter-btn" data-badge="diamond">
                            <i class="bi bi-award me-2"></i>
                            Diamond
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="leaderboard-container">
            @foreach($leaders as $index => $leader)
                <div class="leader-card" data-badges="{{ $leader['badges'] }}">
                    <div class="leader-rank">
                        @if($index < 3)
                            <div class="rank-medal rank-{{ $index + 1 }}">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                        @else
                            <div class="rank-number">{{ $index + 1 }}</div>
                        @endif
                    </div>
                    
                    <div class="leader-avatar">
                        <div class="avatar-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </div>
                    
                    <div class="leader-info">
                        <div class="leader-name">{{ $leader['name'] }}</div>
                        <div class="leader-badges">
                            @foreach(explode(',', $leader['badges']) as $badge)
                                <span class="badge-item badge-{{ trim($badge) }}">
                                    <i class="bi bi-award me-1"></i>
                                    {{ ucfirst(trim($badge)) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="leader-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{ $leader['points'] }}</div>
                            <div class="stat-label">Points</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $leader['sponsors'] }}</div>
                            <div class="stat-label">Sponsors</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $leader['orders'] }}</div>
                            <div class="stat-label">Orders</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div class="no-results" style="display: none;">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-emoji-frown mb-3" style="font-size: 4rem; color: var(--contractor-primary);"></i>
                    <h4 style="color: var(--contractor-dark);">No Leaders Found</h4>
                    <p class="text-muted mb-4">
                        No leaders match the selected badge category.
                    </p>
                    <button class="btn btn-contractor" onclick="showAllLeaders()">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Show All Leaders
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const badgeFilters = document.querySelectorAll('.badge-filter-btn');
    const leaderCards = document.querySelectorAll('.leader-card');
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
            const hasBadge = badge === 'all' || cardBadges.some(b => b.trim().toLowerCase() === badge.toLowerCase());
            
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