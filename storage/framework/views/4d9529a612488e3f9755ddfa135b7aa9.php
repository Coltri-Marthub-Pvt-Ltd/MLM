<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Mobile App-like Header -->
    <div class="sticky-top bg-white shadow-sm d-md-none">
        <div class="container-fluid py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="/contractor/dashboard" class="text-decoration-none me-2">
                        <i class="bi bi-arrow-left" style="font-size: 1.2rem; color: var(--contractor-dark);"></i>
                    </a>
                    <h5 class="mb-0 fw-bold" style="color: var(--contractor-dark);">Browse Products</h5>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-contractor rounded-circle me-2" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="bi bi-sliders2"></i>
                    </button>
                    <span class="badge bg-contractor rounded-pill"><?php echo e($products->total()); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Header -->
    <div class="d-none d-md-block mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 fw-bold" style="color: var(--contractor-dark);">Browse Products</h1>
                <p class="text-muted">Discover our product catalog and earn rewards</p>
            </div>
            <div class="text-muted">
                <?php echo e($products->total()); ?> <?php echo e(Str::plural('product', $products->total())); ?> found
            </div>
        </div>
    </div>

    <!-- Mobile Filter Panel -->
    <div class="collapse d-md-none mb-3" id="filterCollapse">
        <div class="card rounded-3 shadow-sm border-0">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('contractor.products.index')); ?>">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" 
                                       id="search" name="search" value="<?php echo e(request('search')); ?>" 
                                       placeholder="Search products...">
                            </div>
                        </div>
                        <div class="col-6">
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" 
                                            <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-select" id="sort" name="sort">
                                <option value="created_at" <?php echo e(request('sort') == 'created_at' ? 'selected' : ''); ?>>Newest</option>
                                <option value="price" <?php echo e(request('sort') == 'price' ? 'selected' : ''); ?>>Price</option>
                                <option value="points" <?php echo e(request('sort') == 'points' ? 'selected' : ''); ?>>Points</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <button type="submit" class="btn btn-contractor btn-sm flex-grow-1 me-2">
                                <i class="bi bi-funnel me-1"></i> Apply
                            </button>
                            <a href="<?php echo e(route('contractor.products.index')); ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Desktop Filters -->
    <div class="d-none d-md-block mb-4">
        <div class="card rounded-3 shadow-sm border-0">
            <div class="card-body p-3">
                <form method="GET" action="<?php echo e(route('contractor.products.index')); ?>">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" 
                                       id="search" name="search" value="<?php echo e(request('search')); ?>" 
                                       placeholder="Search products...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" 
                                            <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="sort" name="sort">
                                <option value="created_at" <?php echo e(request('sort') == 'created_at' ? 'selected' : ''); ?>>Newest</option>
                                <option value="price" <?php echo e(request('sort') == 'price' ? 'selected' : ''); ?>>Price</option>
                                <option value="points" <?php echo e(request('sort') == 'points' ? 'selected' : ''); ?>>Points</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="direction" name="direction">
                                <option value="asc" <?php echo e(request('direction') == 'asc' ? 'selected' : ''); ?>>Ascending</option>
                                <option value="desc" <?php echo e(request('direction') == 'desc' ? 'selected' : ''); ?>>Descending</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-contractor w-100">
                                <i class="bi bi-funnel"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if($products->count() > 0): ?>
        <!-- Products Grid - Modern Card Design -->
        <div class="row g-1 g-md-2"> <!-- Reduced gap on mobile -->
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card product-card h-93 border-0 shadow-sm">
                        <a href="<?php echo e(route('contractor.products.show', $product)); ?>" class="text-decoration-none text-dark">
                            <div class="position-relative">
                                <img src="<?php echo e($product->image_url); ?>" class="card-img-top rounded-top" 
                                     alt="<?php echo e($product->name); ?>" style="height: 120px; object-fit: cover;">
                                <!-- Red Coin Badge in Top Right Corner -->
                                <span class="position-absolute top-0 end-0 m-1 bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" 
                                      style="width: 24px; height: 24px; font-size: 10px;">
                                    <span class=" bg-danger rounded-pill" style="font-size: 10px;">
                                        <?php echo e($product->points ?? 0); ?>

                                    </span>
                                </span>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title mb-0 fw-bold" style="font-size: 12px;"> <?php echo e(Str::limit($product->name, 15)); ?></h6>
                                <p class="card-text text-muted small mb-2 d-none d-md-block">
                                    <?php echo e(Str::limit($product->description, 60)); ?>

                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-contractor" style="font-size: 12px;"><?php echo e($product->formatted_price); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Modern Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($products->onEachSide(1)->links('pagination::bootstrap-5')); ?>

        </div>
    <?php else: ?>
        <!-- No Products Found - Modern Empty State -->
        <div class="card border-0 shadow-sm rounded-3 text-center py-5 my-4">
            <div class="card-body">
                <div class="empty-state-icon mb-3">
                    <i class="bi bi-bag-x-fill" style="font-size: 3rem; color: var(--contractor-primary);"></i>
                </div>
                <h4 class="fw-bold mb-2" style="color: var(--contractor-dark);">No Products Found</h4>
                <p class="text-muted mb-4">
                    <?php if(request()->hasAny(['search', 'category'])): ?>
                        No products match your current filters. Try adjusting your search criteria.
                    <?php else: ?>
                        There are currently no products available in our catalog.
                    <?php endif; ?>
                </p>
                <?php if(request()->hasAny(['search', 'category'])): ?>
                    <a href="<?php echo e(route('contractor.products.index')); ?>" class="btn btn-contractor rounded-pill px-4">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Clear Filters
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>

    /* Pagination Styles */
.page-link {
    color: var(--contractor-dark);
    border: 1px solid #dee2e6;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.page-item.active .page-link {
    background-color: var(--contractor-primary);
    border-color: var(--contractor-primary);
}

.page-link:hover {
    color: var(--contractor-dark);
    background-color: #f8f9fa;
}

@media (max-width: 575.98px) {
    .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}

    /* Modern Card Hover Effect */
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 8px !important;
    }
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    
    /* Mobile-specific styles */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 0.75rem !important;
        }
        .card-img-top {
            height: 69px !important;
        }
        .badge.bg-contractor {
            font-size: 10px;
            padding: 3px 6px;
        }
        /* Remove horizontal scroll */
        html, body {
            overflow-x: hidden;
        }
        /* Adjust card spacing */
        .product-card {
            margin-bottom: 0.25rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-submit form when filters change on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const mobileFilters = ['category', 'sort'];
        mobileFilters.forEach(filter => {
            const element = document.getElementById(filter);
            if (element) {
                element.addEventListener('change', function() {
                    if (window.innerWidth < 768) {
                        this.form.submit();
                    }
                });
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.contractor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\MLM\resources\views/contractor/products/index.blade.php ENDPATH**/ ?>