<?php $__env->startSection('title',trans('Member Details')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Member Details'); ?></h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a></li>
                            <li class="breadcrumb-item"><a
                                    href="<?php echo e(route('user.affiliateMemberList')); ?>"><?php echo app('translator')->get('Member List'); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Member Details'); ?></li>
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
                                        <a href="<?php echo e(route('user.affiliateMemberList')); ?>"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?> </span>
                                        </a>
                                    </div>

                                    <div class="p-4 border shadow-sm rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Sales Center'); ?>
                                                            : </h6>
                                                        <p class="ms-2">
                                                            <?php $__currentLoopData = $memberDetails->salesCenter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <span class="badge bg-success"><?php echo e($salesCenter->name); ?></span>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Joining Date'); ?>
                                                            : </h6>
                                                        <p class="ms-2"><?php echo e(dateTime($memberDetails->created_at)); ?></p>
                                                    </div>
                                                </div>

                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Member Commission'); ?>
                                                            : </h6>
                                                        <p class="ms-2"><?php echo e($memberDetails->member_commission); ?>%</p>
                                                    </div>
                                                </div>

                                                <ul class="invest-history-details-ul">
                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Customer Name'); ?> :</span> <span
                                                                class="text-muted"><?php echo e($memberDetails->member_name); ?></span></span>
                                                    </li>

                                                    <?php if($memberDetails->email): ?>
                                                        <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Email'); ?> :</span>  <span
                                                                class="text-muted"><?php echo e($memberDetails->email); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Phone'); ?></span> <span
                                                                class="text-muted"><?php echo e($memberDetails->phone); ?></span></span>
                                                    </li>

                                                    <?php if($memberDetails->national_id): ?>
                                                        <li class="my-3">
                                                            <span class=""><i
                                                                    class="fal fa-check-circle site__color text-success"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted"> <?php echo app('translator')->get('National Id'); ?> : </span> <span
                                                                    class="text-muted"><?php echo e($memberDetails->member_national_id); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li class="my-3">
                                                        <span>
                                                            <i class="fal fa-check-circle site__color text-purple"
                                                               aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Division'); ?> :</span>
                                                            <span
                                                                class="text-muted"><?php echo e(optional($memberDetails->division)->name); ?></span>
                                                        </span>
                                                    </li>

                                                    <li class="my-3">
                                                            <span><i
                                                                    class="fal fa-check-circle site__color text-purple"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted"><?php echo app('translator')->get('District'); ?> : </span> <span
                                                                    class="text-muted"><?php echo e(optional($memberDetails->district)->name); ?></span></span>
                                                    </li>

                                                    <?php if($memberDetails->upazila): ?>
                                                        <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Upazila'); ?> :</span> <span
                                                                class="text-muted"><?php echo e(optional($memberDetails->upazila)->name); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if($memberDetails->union): ?>
                                                        <li class="my-3">
                                                        <span><i
                                                                class="fal fa-check-circle site__color"
                                                                aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Union'); ?> :</span> <span
                                                                class="text-muted"><?php echo e(optional($memberDetails->union)->name); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if($memberDetails->date_of_death): ?>
                                                        <li class="my-3">
                                                        <span><i
                                                                class="fal fa-check-circle site__color"
                                                                aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Date of Death'); ?> :</span> <span
                                                                class="text-muted"><?php echo e(customDate($memberDetails->date_of_death)); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li class="my-3">
                                                    <span><i
                                                            class="fal fa-check-circle site__color"
                                                            aria-hidden="true"></i> <span
                                                            class="font-weight-bold text-muted"><?php echo app('translator')->get('Member Wife'); ?> :</span> <span
                                                            class="text-muted"><?php echo e($memberDetails->wife_name); ?></span></span>
                                                    </li>

                                                    <li class="my-3">
                                                    <span><i
                                                            class="fal fa-check-circle site__color"
                                                            aria-hidden="true"></i> <span
                                                            class="font-weight-bold text-muted"><?php echo app('translator')->get('Wife National Id'); ?> :</span> <span
                                                            class="text-muted"><?php echo e($memberDetails->wife_national_id); ?></span></span>
                                                    </li>

                                                    <li class="my-3">
                                                    <span><i
                                                            class="fal fa-check-circle site__color"
                                                            aria-hidden="true"></i> <span
                                                            class="font-weight-bold text-muted"><?php echo app('translator')->get('Wife Commission'); ?> :</span> <span
                                                            class="text-muted"><?php echo e($memberDetails->wife_commission); ?></span></span>
                                                    </li>

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted"><?php echo app('translator')->get('Address'); ?> :</span> <span
                                                                class="text-muted"><?php echo e($memberDetails->address); ?></span></span>
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/affiliate/details.blade.php ENDPATH**/ ?>