<?php if(count($properties) > 0): ?>
    <div class="col-lg-12">
        <div class="row g-4 mb-5">
            <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-4">
                    <?php echo $__env->make($theme.'partials.propertyBox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php echo e($properties->appends($_GET)->links()); ?>

            </ul>
        </nav>
    </div>
<?php else: ?>
    <div class="custom-not-found mt-5">
        <img src="<?php echo e(asset($themeTrue.'img/no_data_found.png')); ?>" alt="<?php echo app('translator')->get('not found'); ?>" class="img-fluid">
    </div>
<?php endif; ?>


<?php $__env->startPush('loadModal'); ?>
    <?php echo $__env->make($theme.'partials.investNowModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset($themeTrue.'js/investNow.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/themes/original/user/property/allProperty.blade.php ENDPATH**/ ?>