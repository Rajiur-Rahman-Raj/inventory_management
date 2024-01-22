<?php $__env->startSection('title',__($page_title)); ?>

<?php $__env->startSection('content'); ?>

<section class="transaction-history">
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get($page_title); ?></h3>
                    <nav aria-label="breadcrumb ms-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__($page_title)); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

       <div class="row">
          <div class="col">
             <div class="d-flex justify-content-end mb-4">
                 <a href="<?php echo e(route('user.ticket.create')); ?>" class="btn btn-custom text-white "> <i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Create Ticket'); ?></a>
             </div>
            <div class="card bg-light">

                <div class="card-body p-0">
                    <div class="table-parent table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col"><?php echo app('translator')->get('Subject'); ?></th>
                                    <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                    <th scope="col"><?php echo app('translator')->get('Last Reply'); ?></th>
                                    <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td data-label="<?php echo app('translator')->get('Ticket Id'); ?>">
                                            <span class="font-weight-bold"> [<?php echo e(trans('Ticket#').$ticket->ticket); ?>

                                            ] <?php echo e($ticket->subject); ?>

                                            </span>
                                        </td>
                                        <td data-label="<?php echo app('translator')->get('status'); ?>">
                                            <?php if($ticket->status == 0): ?>
                                              <span class="badge rounded-pill bg-success"><?php echo app('translator')->get('Open'); ?></span>
                                            <?php elseif($ticket->status == 1): ?>
                                                <span class="badge rounded-pill bg-primary"><?php echo app('translator')->get('Answered'); ?></span>
                                            <?php elseif($ticket->status == 2): ?>
                                                <span class="badge rounded-pill bg-warning"><?php echo app('translator')->get('Replied'); ?></span>
                                            <?php elseif($ticket->status == 3): ?>
                                                <span class="badge rounded-pill bg-danger"><?php echo app('translator')->get('Closed'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(diffForHumans($ticket->last_reply)); ?></td>
                                        <td data-label="Action">
                                            <a href="<?php echo e(route('user.ticket.view', $ticket->ticket)); ?>" class="action-btn">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>

                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr class="text-center">
                                        <td colspan="100%"><?php echo e(__('No Data Found!')); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <?php echo e($tickets->appends($_GET)->links($theme.'partials.pagination')); ?>


                     </div>
                </div>
            </div>

          </div>
       </div>
    </div>
</section>


<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/support/index.blade.php ENDPATH**/ ?>