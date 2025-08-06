@extends('layouts.contractor')

@section('title', 'My Profile')

@section('content')
<!-- Welcome Section -->
<section class="welcome-section">
    <!-- Profile Header -->
    <div class="profile-header-card">
        <div class="profile-avatar">
            <div class="avatar-circle">
                <i class="bi bi-person" style="font-size: 2.5rem; color: var(--contractor-primary);"></i>
            </div>
        </div>
        <div class="profile-basic-info">
            <h2 class="profile-name">{{ $contractor->name }}</h2>
            <p class="profile-id">ID: #{{ str_pad($contractor->id, 6, '0', STR_PAD_LEFT) }}</p>
            @if($contractor->isVerified())
                <span class="status-badge verified">
                    <i class="bi bi-check-circle"></i> Verified
                </span>
            @else
                <span class="status-badge pending">
                    <i class="bi bi-clock"></i> Pending Verification
                </span>
            @endif
        </div>
    </div>
    
    <!-- Progress Cards -->
    <div class="progress-cards">
        @if(isset($contractor->points))
        <div class="progress-card">
            <div class="progress-value">{{ number_format($contractor->points ?? 0) }}</div>
            <div class="progress-label">Points</div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min((($contractor->points ?? 0) / 1000) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="progress-card">
            <div class="progress-value">{{ $directMamber }}</div>
            <div class="progress-label">Direct Referrals</div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(($directMamber / 10) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="progress-card">
            <div class="progress-value">{{ $referalMember }}</div>
            <div class="progress-label">Chain Depth</div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(($referalMember / 5) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profile Information Section -->
<section class="profile-info-section py-3">
    <div class="container-fluid px-3">
        
        <!-- Personal Information -->
        <div class="info-card-wrapper mb-3">
            <div class="info-card-header">
                <h5><i class="bi bi-person-lines-fill me-2"></i>Personal Information</h5>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $contractor->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $contractor->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value">+91 {{ $contractor->phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date of Birth</span>
                    <span class="info-value">{{ $contractor->date_of_birth->format('d M, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Age</span>
                    <span class="info-value">{{ $contractor->age }} years</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address</span>
                    <span class="info-value">{{ $contractor->address }}</span>
                </div>
            </div>
        </div>

        <!-- Document Information -->
        <div class="info-card-wrapper mb-3">
            <div class="info-card-header">
                <h5><i class="bi bi-file-earmark-text me-2"></i>Document Information</h5>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label">Aadhaar Card</span>
                    <span class="info-value">{{ substr($contractor->aadhar_card, 0, 4) }}****{{ substr($contractor->aadhar_card, -4) }}</span>
                </div>
                @if($contractor->pan_card)
                <div class="info-row">
                    <span class="info-label">PAN Card</span>
                    <span class="info-value">{{ $contractor->pan_card }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Registration Date</span>
                    <span class="info-value">{{ $contractor->created_at->format('d M, Y') }}</span>
                </div>
                @if($contractor->verified_at)
                <div class="info-row">
                    <span class="info-label">Verification Date</span>
                    <span class="info-value">{{ $contractor->verified_at->format('d M, Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Referral Information -->
        @if($contractor->referencedBy || $directMamber > 0)
        <div class="info-card-wrapper mb-3">
            <div class="info-card-header">
                <h5><i class="bi bi-people me-2"></i>Referral Information</h5>
            </div>
            <div class="info-card-body">
                @if($contractor->referencedBy)
                <div class="info-row">
                    <span class="info-label">Referred By</span>
                    <span class="info-value">{{ $contractor->referencedBy->name }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Direct Referrals</span>
                    <span class="info-value">{{ $directMamber }} member{{ $directMamber != 1 ? 's' : '' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Referral Chain</span>
                    <span class="info-value">{{ $referalMember }} level{{ $referalMember != 1 ? 's' : '' }} deep</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Account Actions -->
        <div class="info-card-wrapper mb-4">
            <div class="info-card-header">
                <h5><i class="bi bi-gear me-2"></i>Account Actions</h5>
            </div>
            <div class="info-card-body">
                <div class="action-buttons">
                    <button class="action-btn edit-btn" onclick="showEditModal()">
                        <i class="bi bi-pencil me-2"></i>Edit Profile
                    </button>
                    <form action="{{ route('contractor.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="action-btn logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Edit Profile Modal (placeholder for future implementation) -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Profile editing functionality will be available soon. Please contact support for any changes needed.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile specific styles using existing design system */
.profile-header-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 15px rgba(139, 69, 19, 0.1);
    text-align: center;
}

.profile-avatar {
    margin-bottom: 1rem;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    background: var(--contractor-light);
    border: 3px solid var(--contractor-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.profile-basic-info .profile-name {
    color: var(--contractor-dark);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.profile-basic-info .profile-id {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-badge.verified {
    background: rgba(40, 167, 69, 0.1);
    color: var(--contractor-success);
}

.status-badge.pending {
    background: rgba(255, 193, 7, 0.1);
    color: var(--contractor-warning);
}

.profile-info-section {
    background: var(--contractor-secondary);
}

.info-card-wrapper {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(139, 69, 19, 0.08);
}

.info-card-header {
    background: linear-gradient(135deg, var(--contractor-primary), var(--contractor-accent));
    color: white;
    padding: 1rem;
}

.info-card-header h5 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.info-card-body {
    padding: 0;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #f8f9fa;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    color: #666;
    font-weight: 500;
    font-size: 0.9rem;
    flex: 1;
}

.info-value {
    color: var(--contractor-dark);
    font-weight: 600;
    font-size: 0.9rem;
    text-align: right;
    flex: 1;
    word-break: break-word;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.action-btn.edit-btn {
    background: var(--contractor-primary);
    color: white;
}

.action-btn.edit-btn:hover {
    background: var(--contractor-dark);
    transform: translateY(-1px);
}

.action-btn.logout-btn {
    background: var(--contractor-danger);
    color: white;
}

.action-btn.logout-btn:hover {
    background: #c82333;
    transform: translateY(-1px);
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
        padding: 0.75rem 1rem;
    }
    
    .info-value {
        text-align: left;
    }
    
    .profile-basic-info .profile-name {
        font-size: 1.3rem;
    }
}
</style>

<script>
function showEditModal() {
    const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
    modal.show();
}
</script>

@endsection