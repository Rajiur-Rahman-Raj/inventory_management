<?php $__env->startSection('title',trans($title)); ?>
<?php $__env->startSection('content'); ?>

<!-- My Referral -->
<section class="transaction-history">
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('My Referral'); ?></h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo e(trans($title)); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- refferal-information -->
        <div class="search-bar refferal-link coin-box-wrapper">
            <form class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="input-box col-lg-12">
                        <label for=""><?php echo app('translator')->get('Referral Link'); ?></label>
                        <div class="input-group mt-0">
                            <input
                                type="text"
                                value="<?php echo e(route('register.sponsor',[Auth::user()->username])); ?>"
                                class="form-control"
                                id="sponsorURL"
                                readonly />
                            <button class="gold-btn copyReferalLink" type="button"><i class="fal fa-copy"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <?php if(0 < count($referrals)): ?>
            <div class="row mt-5">
                <div class="col-md-12 col-lg-12">
                    <div class="row" id="ref-label">
                        <div class="col-lg-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class=" btn-custom nav-link <?php if($key == '1'): ?>   active  <?php endif; ?> " id="v-pills-<?php echo e($key); ?>-tab" href="javascript:void(0)" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo e($key); ?>"  role="tab" aria-controls="v-pills-<?php echo e($key); ?>" aria-selected="true"><?php echo app('translator')->get('Level'); ?> <?php echo e($key); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <?php $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php if($key == '1'): ?> show active  <?php endif; ?> " id="v-pills-<?php echo e($key); ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo e($key); ?>-tab">
                                        <?php if( 0 < count($referral)): ?>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col"><?php echo app('translator')->get('Username'); ?></th>
                                                        <th scope="col"><?php echo app('translator')->get('Email'); ?></th>
                                                        <th scope="col"><?php echo app('translator')->get('Phone Number'); ?></th>
                                                        <th scope="col"><?php echo app('translator')->get('Upline'); ?></th>
                                                        <th scope="col"><?php echo app('translator')->get('Joined At'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $__currentLoopData = $referral; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>

                                                            <td data-label="<?php echo app('translator')->get('Username'); ?>">
                                                                <?php echo app('translator')->get($user->username); ?>
                                                            </td>
                                                            <td data-label="<?php echo app('translator')->get('Email'); ?>" class=""><?php echo e($user->email); ?></td>
                                                            <td data-label="<?php echo app('translator')->get('Phone Number'); ?>">
                                                                <?php echo e($user->phone); ?>

                                                            </td>
                                                            <td data-label="<?php echo app('translator')->get('Upline'); ?>">
                                                                <?php echo e($user->uplineRefer($user->referral_id)->username); ?>

                                                            </td>
                                                            <td data-label="<?php echo app('translator')->get('Joined At'); ?>">
                                                                <?php echo e(dateTime($user->created_at)); ?>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
 </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        'use strict'
        $(document).on('click', '.copyReferalLink', function () {
            var _this = $(this)[0];
            var copyText = $(this).siblings('input');
            $(copyText).prop('disabled', false);
            copyText.select();
            document.execCommand("copy");
            $(copyText).prop('disabled', true);
            $(this).text('Copied');
            setTimeout(function () {
                $(_this).text('');
                $(_this).html('<i class="fal fa-copy"></i>');
            }, 500)
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/referral.blade.php ENDPATH**/ ?>