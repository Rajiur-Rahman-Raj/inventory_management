<div class="sidebar-bottom">
    <!-- Default dropup button -->
    <div class="btn-group dropup">
        <button
            type="button"
            class="dropdown-toggle"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="<?php echo e(getFile(config('location.companyLogo.path').@Auth::user()->activeCompany->logo)); ?>"
                 alt="..."/> <?php echo e(@Auth::user()->activeCompany->name); ?>

        </button>
        <?php if($companies): ?>
            <ul
                class="dropdown-menu"
                aria-labelledby="dropdownMenuButton1">
                <?php $__empty_1 = true; $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('user.companyActive',$item->id)); ?>">
                            <img src="<?php echo e(getFile(config('location.companyLogo.path').$item->logo)); ?>"
                                 alt="<?php echo e($item->name); ?>"/>
                            <?php echo e($item->name); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
                <hr/>
                <li>
                    <a class="dropdown-item" href="<?php echo e(route('user.companyList')); ?>">
                        <i class="fal fa-cog"></i><?php echo app('translator')->get('All Companies'); ?></a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\inventory_management\project\resources\views/themes/original/partials/sidebarBottom.blade.php ENDPATH**/ ?>