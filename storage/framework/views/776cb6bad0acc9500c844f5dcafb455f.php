<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid px-3 py-3">
        <div class="row g-3">
            <!-- Category Wise -->
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $tableName = $cat->getTable();

                    // Array of gradient classes
                    $gradients = ['gradient-1', 'gradient-2', 'gradient-3', 'gradient-4'];
                    // Get random gradient
                    $randomGradient = $gradients[array_rand($gradients)];
                    $gradients = ['gradient-1', 'gradient-2', 'gradient-3', 'gradient-4'];
                    $gradientIndex = $cat->id % count($gradients);
                    $selectedGradient = $gradients[$gradientIndex];

                ?>

                <div class="col-md-6 col-6">
                    <a href="<?php echo e(($tableName=='product_types') ? route('contractor.type.brands') : route('contractor.products.brand.product', [$tableName, $cat->id])); ?>" class="card-link">
                        <div class="data-card <?php echo e($randomGradient); ?>">
                            <div class="card-badge"><?php echo e($cat->products->count()); ?></div>
                            <div class="card-content d-flex flex-column justify-content-between h-100">
                                <h3 class="card-title text-center mb-2"> <?php echo e($cat->name); ?></h3>
                                <div class="chart-placeholder d-flex justify-content-center align-items-center flex-grow-1">
                                    <i class="chart-icon fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --card-radius: 12px;
            --card-padding: 15px;
            --text-color: white;
            --badge-size: 28px;
        }

        .card-link {
            text-decoration: none;
            display: block;
            height: 100%;
            position: relative;
        }

        .data-card {
            border-radius: var(--card-radius);
            padding: var(--card-padding);
            height: 110px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .card-badge {
            position: absolute;
            top: 0;
            right: 0;
            width: var(--badge-size);
            height: var(--badge-size);
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            border-radius: 0 0 0 var(--badge-size);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .data-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .card-content {
            height: 100%;
        }

        .card-title {
            color: var(--text-color);
            font-size: 16px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chart-icon {
            font-size: 28px;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Gradient Colors */
        .gradient-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-2 {
            background: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%);
        }

        .gradient-3 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .gradient-4 {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        }

        /* Add more gradients if you want more variety */
        .gradient-5 {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        }

        .gradient-6 {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .gradient-7 {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        }

        .gradient-8 {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        }

        @media (max-width: 576px) {
            .data-card {
                height: 100px;
            }

            .card-title {
                font-size: 14px;
            }

            .chart-icon {
                font-size: 24px;
            }

            .card-badge {
                width: 35px;
                height: 25px;
                font-size: 12px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.contractor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\MLM\resources\views/contractor/products/caregories.blade.php ENDPATH**/ ?>