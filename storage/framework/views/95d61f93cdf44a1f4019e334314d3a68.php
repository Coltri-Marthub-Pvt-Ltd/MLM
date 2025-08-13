<?php $__env->startSection('title', '403 - Permission Denied'); ?>

<?php $__env->startSection('content'); ?>
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="admin-card text-center">
                    <div class="card-content py-5">
                        <!-- Error Icon -->
                        <div class="mb-4">
                            <i class="bi bi-shield-exclamation text-danger" style="font-size: 5rem;"></i>
                        </div>
                        
                        <!-- Error Title -->
                        <h1 class="display-4 fw-bold text-danger mb-3">403</h1>
                        <h2 class="h4 mb-4">Permission Denied</h2>
                        
                        <!-- Error Message -->
                        <div class="mb-4">
                            <p class="text-muted mb-3">
                                You don't have the required permissions to access this page.
                            </p>
                            <p class="text-muted">
                                If you believe this is an error, please contact your administrator.
                            </p>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <button onclick="window.history.back()" class="btn btn-outline">
                                <i class="bi bi-arrow-left me-2"></i>
                                Go Back
                            </button>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_dashboard')): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary">
                                <i class="bi bi-house me-2"></i>
                                Dashboard
                            </a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('view_dashboard')): ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Login
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info Card -->
                <div class="admin-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-info-circle me-2"></i>
                            What can I do?
                        </h5>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-semibold">
                                        <i class="bi bi-person-check me-2 text-primary"></i>
                                        Check Your Role
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Make sure you have the correct role assigned to your account.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-semibold">
                                        <i class="bi bi-headset me-2 text-success"></i>
                                        Contact Support
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        Reach out to your administrator for assistance.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\MLM\resources\views/errors/403.blade.php ENDPATH**/ ?>