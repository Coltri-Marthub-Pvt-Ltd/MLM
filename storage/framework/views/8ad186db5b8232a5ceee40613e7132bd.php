<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --flipkart-blue: #2874f0;
        --flipkart-orange: #fb641b;
        --flipkart-light: #f1f3f6;
        --flipkart-dark: #212121;
        --flipkart-gray: #878787;
        --flipkart-white: #ffffff;
    }

    .products-container {
        background-color: var(--flipkart-light);
        min-height: 100vh;
        font-family: 'Roboto', sans-serif;
        padding: 15px;
    }

    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        position: relative;
    }

    .filter-btn {
        background: var(--flipkart-white);
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 13px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .filter-btn i {
        margin-right: 5px;
    }

    .filter-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 40px;
        background: var(--flipkart-white);
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 15px;
        width: 250px;
        z-index: 10;
    }

    .filter-dropdown.show {
        display: block;
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .filter-title {
        font-size: 14px;
        font-weight: 500;
        color: var(--flipkart-dark);
    }

    .close-filter {
        background: none;
        border: none;
        color: var(--flipkart-gray);
        font-size: 16px;
        cursor: pointer;
    }

    .filter-group {
        margin-bottom: 15px;
    }

    .filter-group label {
        font-size: 12px;
        color: var(--flipkart-gray);
        display: block;
        margin-bottom: 5px;
    }

    .filter-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #e0e0e0;
        border-radius: 2px;
        font-size: 13px;
    }

    .apply-btn {
        background: var(--flipkart-blue);
        color: white;
        border: none;
        border-radius: 2px;
        padding: 8px;
        width: 100%;
        font-size: 13px;
        cursor: pointer;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .product-card {
        background: var(--flipkart-white);
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .product-image-container {
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-info {
        padding: 8px;
    }

    .product-title {
        font-size: 12px;
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        font-size: 13px;
        font-weight: 500;
        color: var(--flipkart-dark);
        margin-bottom: 4px;
    }

    .product-points {
        font-size: 11px;
        color: var(--flipkart-blue);
        display: flex;
        align-items: center;
    }

    .product-points i {
        margin-right: 4px;
        font-size: 11px;
    }

    .empty-state {
        background: var(--flipkart-white);
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        padding: 30px 15px;
        text-align: center;
        grid-column: 1 / -1;
    }

    .empty-icon {
        font-size: 35px;
        color: #c2c2c2;
        margin-bottom: 12px;
    }

    .empty-title {
        font-size: 15px;
        color: var(--flipkart-dark);
        margin-bottom: 8px;
    }

    .empty-text {
        font-size: 12px;
        color: var(--flipkart-gray);
        margin-bottom: 12px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        grid-column: 1 / -1;
    }

    @media (max-width: 480px) {
        .products-grid {
            gap: 8px;
        }

        .product-image-container {
            height: 80px;
            padding: 6px;
        }

        .product-title {
            font-size: 11px;
        }

        .product-price {
            font-size: 12px;
        }

        .product-points {
            font-size: 10px;
        }
    }

    @media (max-width: 350px) {
        .filter-dropdown {
            width: 200px;
        }
    }
</style>

<div class="products-container">
    <div class="filter-bar">
        <div class="product-count">
            <?php echo e($products->total()); ?> <?php echo e(Str::plural('product', $products->total())); ?>

        </div>
        <button class="filter-btn" id="filterButton">
            <i class="fas fa-filter"></i> Filter
        </button>
        <div class="filter-dropdown" id="filterDropdown">
            <div class="filter-header">
                <div class="filter-title">Filter Options</div>
                <button class="close-filter" id="closeFilter">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filter-group">
                <label for="sort">Sort By</label>
                <select id="sort" name="sort">
                    <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name</option>
                    <option value="price" <?php echo e(request('sort') == 'price' ? 'selected' : ''); ?>>Price</option>
                    <option value="points" <?php echo e(request('sort') == 'points' ? 'selected' : ''); ?>>Points</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="direction">Order</label>
                <select id="direction" name="direction">
                    <option value="asc" <?php echo e(request('direction') == 'asc' ? 'selected' : ''); ?>>Ascending</option>
                    <option value="desc" <?php echo e(request('direction') == 'desc' ? 'selected' : ''); ?>>Descending</option>
                </select>
            </div>
            <button class="apply-btn" onclick="applyFilters()">
                Apply Filters
            </button>
        </div>
    </div>

    <div class="products-grid">
        <?php if($products->count() > 0): ?>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('contractor.coins-products.show', $product)); ?>" class="product-card">
                    <div class="product-image-container">
                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo e($product->name); ?></h3>

                        <div class="product-points">
                            <i class="fas fa-coins"></i>
                            <?php echo e($product->points ?? 0); ?> coins
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="empty-title">No Products Found</h3>
                <p class="empty-text">
                    <?php if(request()->hasAny(['search', 'sort', 'direction'])): ?>
                        No products match your current filters.
                    <?php else: ?>
                        There are currently no products available.
                    <?php endif; ?>
                </p>
                <?php if(request()->hasAny(['search', 'sort', 'direction'])): ?>
                    <button class="filter-btn" onclick="resetFilters()">
                        <i class="fas fa-sync-alt"></i> Reset Filters
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if($products->count() > 0): ?>
        <div class="pagination">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    const filterButton = document.getElementById('filterButton');
    const filterDropdown = document.getElementById('filterDropdown');
    const closeFilter = document.getElementById('closeFilter');

    function toggleFilters() {
        filterDropdown.classList.toggle('show');
    }

    function hideFilters() {
        filterDropdown.classList.remove('show');
    }

    function applyFilters() {
        const sort = document.getElementById('sort').value;
        const direction = document.getElementById('direction').value;

        const url = new URL(window.location.href);
        url.searchParams.set('sort', sort);
        url.searchParams.set('direction', direction);

        window.location.href = url.toString();
    }

    function resetFilters() {
        window.location.href = "<?php echo e(route('contractor.coins-products.index')); ?>";
    }

    // Initialize event listeners
    filterButton.addEventListener('click', toggleFilters);
    closeFilter.addEventListener('click', hideFilters);

    // Close filter dropdown when clicking outside
    window.addEventListener('click', function(event) {
        if (!event.target.matches('.filter-btn') &&
            !event.target.closest('.filter-dropdown') &&
            !event.target.matches('.close-filter')) {
            hideFilters();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.contractor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\MLM\resources\views/contractor/coins_products/index.blade.php ENDPATH**/ ?>