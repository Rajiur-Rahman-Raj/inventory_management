<?php $__env->startSection('title',__('2 Step Security')); ?>

<?php $__env->startSection('content'); ?>

<section class="transaction-history twofactor">
    <div class="container-fluid">
        <div class="row mt-2 ms-1">
            <div class="col">
                <div class="header-text-full mt-2">
                    <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('2 Step Security'); ?></h3>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('2 Step Security'); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row ms-1">
            <?php if(auth()->user()->two_fa): ?>
                <div class="col-lg-6 col-md-6 mb-3 coin-box-wrapper">
                    <div class="card text-center bg-dark py-2 two-factor-authenticator">
                        <h3 class="card-title golden-text"><?php echo app('translator')->get('Two Factor Authenticator'); ?></h3>
                        <div class="card-body">
                            <div class="box refferal-link">
                                <div class="input-group mt-0">
                                    <input
                                        type="text"
                                        value="<?php echo e($secret); ?>"
                                        class="form-control"
                                        id="referralURL"
                                        readonly
                                    />
                                    <button class="gold-btn copytext" id="copyBoard" onclick="copyFunction()"><i class="fal fa-copy"></i></button>
                                </div>
                            </div>

                            <div class="form-group mx-auto text-center py-4">
                                <img class="mx-auto" src="<?php echo e($previousQR); ?>">
                            </div>

                            <div class="form-group mx-auto text-center">
                                <a href="javascript:void(0)" class="btn btn-bg btn-lg btn-custom-authenticator"
                                   data-bs-toggle="modal" data-bs-target="#disableModal"><?php echo app('translator')->get('Disable Two Factor Authenticator'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-lg-6 col-md-6 mb-3 coin-box-wrapper">
                    <div class="card text-center bg-dark py-2 two-factor-authenticator">
                        <h3 class="card-title golden-text mt-4"><?php echo app('translator')->get('Two Factor Authenticator'); ?></h3>
                        <div class="card-body">
                            <div class="box refferal-link">

                                <div class="input-group mt-0">
                                    <input
                                        type="text"
                                        value="<?php echo e($secret); ?>"
                                        class="form-control"
                                        id="referralURL"
                                        readonly
                                    />
                                    <button class="gold-btn copytext" id="copyBoard" onclick="copyFunction()"><i class="fal fa-copy"></i></button>
                                </div>
                            </div>

                            <div class="form-group mx-auto text-center py-4">
                                <img class="mx-auto" src="<?php echo e($qrCodeUrl); ?>">
                            </div>

                            <div class="form-group mx-auto text-center">
                                <a href="javascript:void(0)" class="btn btn-bg btn-lg btn-custom-authenticator"
                                   data-bs-toggle="modal"
                                   data-bs-target="#enableModal"><?php echo app('translator')->get('Enable Two Factor Authenticator'); ?></a>
                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>


            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card text-center bg-dark py-2 two-factor-authenticator h-100">
                        <h3 class="card-title golden-text pt-4"><?php echo app('translator')->get('Google Authenticator'); ?></h3>
                    <div class="card-body">

                        <h6 class="text-uppercase my-3"><?php echo app('translator')->get('Use Google Authenticator to Scan the QR code  or use the code'); ?></h6>

                        <p class="py-3"><?php echo app('translator')->get('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.'); ?></p>
                        <a class="btn btn btn-bg btn-md mt-3 btn-custom-authenticator"
                           href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                           target="_blank"><?php echo app('translator')->get('DOWNLOAD APP'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Enable Modal -->
    <div class="modal fade" id="enableModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="planModalLabel"><?php echo app('translator')->get('Verify Your OTP'); ?></h4>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('user.twoStepEnable')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                            <div class="row g-4">
                                <div class="input-box col-12">
                                    <input type="hidden" name="key" value="<?php echo e($secret); ?>">
                                    <input type="text" class="form-control" name="code" placeholder="<?php echo app('translator')->get('Enter Google Authenticator Code'); ?>">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom close__btn" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button class="btn-custom" type="submit"><?php echo app('translator')->get('Verify'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Disable Modal -->
    <div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="planModalLabel"><?php echo app('translator')->get('Verify Your OTP to Disable'); ?></h4>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('user.twoStepDisable')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="input-box col-12">
                                <input type="text" class="form-control" name="code" placeholder="<?php echo app('translator')->get('Enter Google Authenticator Code'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn-danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button class="btn-custom" type="submit"><?php echo app('translator')->get('Verify'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startPush('script'); ?>
    <script>
        function copyFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/twoFA/index.blade.php ENDPATH**/ ?>