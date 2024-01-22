<?php $__env->startSection('title', 'badges'); ?>

<?php $__env->startSection('content'); ?>
    <section class="payment-gateway">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('All Badges'); ?></h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Badges'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <?php if(count($allBadges) > 0): ?>
                <div class="badge-box-wrapper">
                    <div class="row g-4 mb-4">
                        <?php $__currentLoopData = $allBadges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xl-4 col-md-4 col-12 box">
                                <div class="badge-box <?php echo e(Auth::user()->ranking($badge->id, $badge->min_deposit) == 'true' ? '' : 'locked'); ?>">
                                    <img src="<?php echo e(getFile(config('location.badge.path').$badge->badge_icon)); ?>" alt="" />
                                    <h3><?php echo app('translator')->get(optional($badge->details)->rank_level); ?></h3>
                                    <p class="mb-3"><?php echo app('translator')->get(optional($badge->details)->rank_name); ?></p>
                                    <div class="text-start">
                                        <h5><?php echo app('translator')->get('Minimum Invest'); ?>: <span><?php echo e($basic->currency_symbol); ?><?php echo e($badge->min_invest); ?></span></h5>
                                        <h5><?php echo app('translator')->get('Minimum Deposit'); ?>: <span><?php echo e($basic->currency_symbol); ?><?php echo e($badge->min_deposit); ?></span></h5>
                                        <h5><?php echo app('translator')->get('Minimum Earning'); ?>: <span><?php echo e($basic->currency_symbol); ?><?php echo e($badge->min_earning); ?></span></h5>
                                        <h5><?php echo app('translator')->get('Bonus'); ?>: <span><?php echo e($basic->currency_symbol); ?><?php echo e($badge->bonus); ?></span></h5>
                                    </div>
                                    <div class="lock-icon">
                                        <i class="far fa-lock-alt"></i>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/themes/original/user/badge/index.blade.php ENDPATH**/ ?>