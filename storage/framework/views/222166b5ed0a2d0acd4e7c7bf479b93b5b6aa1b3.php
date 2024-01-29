<?php $__env->startSection('title','419'); ?>


<?php $__env->startSection('content'); ?>
<section class="error-page wow fadeInUp mb-5 pb-5">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-12 text-center my-5">
                <span class="golden-text opps d-block"><?php echo app('translator')->get('419'); ?></span>
                <div class="sub_title golden-text mb-4 lead"><?php echo app('translator')->get("Sorry, your session has expired"); ?></div>
                <a class="gold-btn" href="<?php echo e(url('/')); ?>" ><?php echo app('translator')->get('Back To Home'); ?></a>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/errors/419.blade.php ENDPATH**/ ?>