<?php $__env->startSection('title','405'); ?>

<?php $__env->startSection('content'); ?>
    <section class="error-page wow fadeInUp mb-5 pb-5">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-12 text-center my-5">
                    <span class="golden-text opps d-block"><?php echo e(trans('405')); ?></span>
                    <div class="sub_title golden-text mb-4 lead"><?php echo e(trans("Method Not Allowed")); ?></div>
                    <a class="gold-btn" href="<?php echo e(url('/')); ?>" ><?php echo app('translator')->get('Back To Home'); ?></a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/errors/405.blade.php ENDPATH**/ ?>