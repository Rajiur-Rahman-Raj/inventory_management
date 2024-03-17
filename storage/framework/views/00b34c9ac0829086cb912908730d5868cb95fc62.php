<?php $__env->startSection('title',trans('Customer Details')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Customer Details'); ?></h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a></li>
                            <li class="breadcrumb-item"><a
                                    href="<?php echo e(route('user.customerList')); ?>"><?php echo app('translator')->get('Customer List'); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Customer Details'); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="main row p-0">
            <div class="col-12">
                <div class="view-property-details">
                    <div class="row ms-2 me-2">
                        <div class="col-md-12 p-0">
                            <div class="card investment-details-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end investment__block">
                                        <a href="<?php echo e(route('user.customerList')); ?>"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?> </span>
                                        </a>
                                    </div>

                                    <div class="p-4 border shadow-sm rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Joining Date'); ?>
                                                            : </h6>
                                                        <p><?php echo e(dateTime($customer->created_at)); ?></p>
                                                    </div>
                                                </div>
                                                <ul class="invest-history-details-ul">
                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Customer Name'); ?> :</span> <span
                                                                class="text-muted"><?php echo e($customer->name); ?></span></span>
                                                    </li>

                                                    <?php if($customer->email): ?>
                                                        <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Email'); ?> :</span>  <span
                                                                class="text-muted"><?php echo e($customer->email); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Phone'); ?></span> <span
                                                                class="text-muted"><?php echo e($customer->phone); ?></span></span>
                                                    </li>

                                                    <?php if($customer->national_id): ?>
                                                        <li class="my-3">
                                                            <span class=""><i
                                                                    class="fal fa-check-circle site__color text-success"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted"> <?php echo app('translator')->get('National Id'); ?> : </span> <span
                                                                    class="text-muted"><?php echo e($customer->national_id); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li class="my-3">
                                                        <span>
                                                            <i class="fal fa-check-circle site__color text-purple"
                                                               aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Division'); ?> :</span>
                                                            <span
                                                                class="text-muted"><?php echo e(optional($customer->division)->name); ?></span>
                                                        </span>
                                                    </li>

                                                    <li class="my-3">
                                                            <span><i
                                                                    class="fal fa-check-circle site__color text-purple"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted"><?php echo app('translator')->get('District'); ?> : </span> <span
                                                                    class="text-muted"><?php echo e(optional($customer->district)->name); ?></span></span>
                                                    </li>

                                                    <?php if($customer->upazila): ?>
                                                        <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Upazila'); ?> :</span> <span
                                                                class="text-muted"><?php echo e(optional($customer->upazila)->name); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if($customer->union): ?>
                                                        <li class="my-3">
                                                        <span><i
                                                                class="fal fa-check-circle site__color"
                                                                aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Union'); ?> :</span> <span
                                                                class="text-muted"><?php echo e(optional($customer->union)->name); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Address'); ?> :</span> <span
                                                                class="text-muted"><?php echo e($customer->address); ?></span></span>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/customer/details.blade.php ENDPATH**/ ?>