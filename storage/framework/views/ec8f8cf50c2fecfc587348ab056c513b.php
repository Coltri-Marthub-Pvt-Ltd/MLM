<?php $__env->startSection('title', 'Events'); ?>

<?php $__env->startSection('content'); ?>
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Events</h1>
                <p class="text-muted">Manage your events</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.events.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Create New Event
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="admin-card mb-4">
            <div class="card-content">
                <form method="GET" action="<?php echo e(route('admin.events.index')); ?>">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">Search Events</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="<?php echo e(request('search')); ?>" placeholder="Search by title or description...">
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Event Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="upcoming" <?php echo e(request('type') == 'upcoming' ? 'selected' : ''); ?>>Upcoming</option>
                                <option value="current" <?php echo e(request('type') == 'current' ? 'selected' : ''); ?>>Current</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="order" class="form-label">Sort By</label>
                            <select class="form-select" id="order" name="order">
                                <option value="newest" <?php echo e(request('order') == 'newest' ? 'selected' : ''); ?>>Newest First</option>
                                <option value="oldest" <?php echo e(request('order') == 'oldest' ? 'selected' : ''); ?>>Oldest First</option>
                                <option value="order_asc" <?php echo e(request('order') == 'order_asc' ? 'selected' : ''); ?>>Order (Low to High)</option>
                                <option value="order_desc" <?php echo e(request('order') == 'order_desc' ? 'selected' : ''); ?>>Order (High to Low)</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Events Table -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">All Events</h5>
                <p class="card-description"><?php echo e($events->total()); ?> events found</p>
            </div>

           <?php if($events->count() > 0): ?>
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th>Featured Image</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Order</th>
                    <th>Slug</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php if($event->featured_image): ?>
                                <img src="<?php echo e(asset($event->featured_image)); ?>" alt="<?php echo e($event->title); ?>"
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-medium"><?php echo e($event->title); ?></td>
                        <td>
                            <?php if($event->type == 'upcoming'): ?>
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            <?php else: ?>
                                <span class="badge bg-success">Current</span>
                            <?php endif; ?>
                        </td>
                        <td class="fw-medium"><?php echo e($event->order); ?></td>
                        <td class="text-muted"><?php echo e($event->slug); ?></td>
                        <td class="text-muted"><?php echo e($event->created_at->format('M j, Y')); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="btn btn-sm btn-outline" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="btn btn-sm btn-outline" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.events.destroy', $event)); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-destructive" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
                <div class="card-content">
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-event text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mb-3">No Events Found</h5>
                        <p class="text-muted mb-4">There are no events in the system yet.</p>
                        <a href="<?php echo e(route('admin.events.create')); ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Create First Event
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\MLM\resources\views/admin/events/index.blade.php ENDPATH**/ ?>