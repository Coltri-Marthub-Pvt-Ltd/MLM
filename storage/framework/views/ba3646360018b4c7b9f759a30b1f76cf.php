<?php $__env->startSection('title', 'Business Opportunities'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-0">
        <!-- Mobile Back Button -->
        <div class="d-block d-md-none px-3 bg-light border-bottom">
            <a onclick="history.back()" class="text-decoration-none me-2">
                <i class="bi bi-arrow-left" style="font-size: 1.2rem; color: var(--contractor-dark);"></i>
            </a>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="opportunitiesTab" role="tablist">
            <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" id="<?php echo e(Str::slug($badge->name)); ?>-tab"
                        data-bs-toggle="tab" data-bs-target="#<?php echo e(Str::slug($badge->name)); ?>" type="button" role="tab"
                        aria-controls="<?php echo e(Str::slug($badge->name)); ?>" aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>"
                        style="font-size: 10px">
                        <?php echo e($badge->name); ?>

                    </button>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content border border-top-0 rounded-bottom" id="opportunitiesTabContent">
            <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $opportunitiesForBadge = $opportunities->where('badge_id', $badge->id);
                ?>
                <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" id="<?php echo e(Str::slug($badge->name)); ?>"
                    role="tabpanel" aria-labelledby="<?php echo e(Str::slug($badge->name)); ?>-tab">

                    <div class="card border-0">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                            <h5 class="mb-0" style="font-size: 10px"><?php echo e($badge->name); ?> Opportunities</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if($opportunitiesForBadge->count() > 0): ?>
                                <table class="table table-striped table-hover datatable display responsive nowrap w-100"
                                    style="font-size: 10px">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">ID</th>
                                            <th data-priority="2">Project Name</th>
                                            <th class="d-none d-sm-table-cell">Location</th>
                                            <th class="d-none d-md-table-cell">Area (sq/ft)</th>
                                            <th data-priority="3">Client</th>
                                            <th class="d-none d-lg-table-cell">Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $opportunitiesForBadge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opportunity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#<?php echo e($opportunity->id); ?></td>
                                                <td><?php echo e($opportunity->project_name); ?></td>
                                                <td class="d-none d-sm-table-cell">
                                                    <?php echo e($opportunity->location->name ?? 'N/A'); ?></td>
                                                <td class="d-none d-md-table-cell"><?php echo e(number_format($opportunity->area)); ?>

                                                </td>
                                                <td><?php echo e($opportunity->client_name); ?></td>
                                                <td class="d-none d-lg-table-cell"><?php echo e($opportunity->client_phone); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary py-0 view-details"

                                                        data-id="<?php echo e($opportunity->id); ?>"
                                                        data-project-name="<?php echo e($opportunity->project_name); ?>"
                                                        data-location="<?php echo e($opportunity->location->name ?? 'N/A'); ?>"
                                                        data-area="<?php echo e($opportunity->area); ?>"
                                                        data-client-name="<?php echo e($opportunity->client_name); ?>"
                                                        data-client-phone="<?php echo e($opportunity->client_phone); ?>"
                                                        data-project-brief="<?php echo e($opportunity->project_brief); ?>"
                                                        data-badge-name="<?php echo e($badge->name); ?>" style="font-size: 10px">
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="p-3 text-center">
                                    <p class="text-muted">No opportunities available for <?php echo e($badge->name); ?> tier</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Opportunity Details Modal -->
   <div class="modal fade" id="opportunityDetailsModal" tabindex="-1" aria-labelledby="opportunityDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header border-bottom-2 py-3">
        <h5 class="modal-title d-flex align-items-center" id="opportunityDetailsModalLabel" style="font-size: 1.1rem;">
          <i class="fas fa-project-diagram me-2 text-primary"></i>Project Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="font-size: 0.9rem;">
        <div class="mb-3">
          <span class="badge bg-primary px-3 py-2 fs-6" id="modalBadgeName"></span>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <dl class="row">
              <dt class="col-5 fw-semibold text-secondary">Project ID:</dt>
              <dd class="col-7" id="modalId"></dd>

              <dt class="col-5 fw-semibold text-secondary">Project Name:</dt>
              <dd class="col-7" id="modalProjectName"></dd>

              <dt class="col-5 fw-semibold text-secondary">Location:</dt>
              <dd class="col-7" id="modalLocation"></dd>

              <dt class="col-5 fw-semibold text-secondary">Area:</dt>
              <dd class="col-7" id="modalArea"></dd>
            </dl>
          </div>

          <div class="col-md-6">
            <dl class="row">
              <dt class="col-5 fw-semibold text-secondary">Client Name:</dt>
              <dd class="col-7" id="modalClientName"></dd>

              <dt class="col-5 fw-semibold text-secondary">Client Phone:</dt>
              <dd class="col-7" id="modalClientPhone"></dd>
            </dl>
          </div>
        </div>

        <div>
          <h6 class="fw-bold mb-2">Project Brief:</h6>
          <div id="modalProjectBrief" class="border rounded p-3 bg-light" style="min-height: 100px; white-space: pre-wrap;"></div>
        </div>
      </div>

      <div class="modal-footer py-2 border-top-2">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Close
        </button>
        <a href="#" id="modalContactClient" class="btn btn-primary btn-sm">
          <i class="fas fa-phone me-1"></i> Contact Client
        </a>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

   <script>
$(document).ready(function () {
    let initializedTables = {};

    // Function to initialize DataTable only once

    // Populate modal when clicking View button
    $(document).on('click', '.view-details', function () {
        const id = $(this).data('id');

        $("#opportunityDetailsModal").modal('show');

        $('#modalId').text('#' + $(this).data('id'));
        $('#modalProjectName').text($(this).data('project-name'));
        $('#modalLocation').text($(this).data('location'));
        $('#modalArea').text($(this).data('area'));
        $('#modalClientName').text($(this).data('client-name'));
        $('#modalClientPhone').text($(this).data('client-phone'));
        $('#modalProjectBrief').text($(this).data('project-brief'));
        $('#modalBadgeName').text($(this).data('badge-name'));

        // Optional: contact link
        $('#modalContactClient').attr('href', 'tel:' + $(this).data('client-phone'));
    });
});
</script>

<?php $__env->stopPush(); ?>




<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .nav-tabs .nav-link {
            border: none;
            color: #666;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: var(--contractor-primary);
            border-bottom: 2px solid var(--contractor-primary);
            background-color: transparent;
        }

        .view-details {
            padding: 0.15rem 0.5rem;
        }

        .datatable thead th {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .datatable tbody td {
            vertical-align: middle;
        }

        #modalProjectBrief {
            white-space: pre-line;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.contractor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\MLM\resources\views/contractor/business_opportunity/index.blade.php ENDPATH**/ ?>