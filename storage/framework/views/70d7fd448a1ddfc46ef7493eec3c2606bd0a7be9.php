<div class="user-panel d-none d-lg-inline-block">
       <span class="profile">
          <img src="<?php echo e(getFile(config('location.user.path').auth()->user()->image)); ?>"
               class="img-fluid"
               alt="<?php echo app('translator')->get('user img'); ?>" />
       </span>
        <ul class="user-dropdown">
            <li>
                <a href="<?php echo e(route('user.home')); ?>">
                    <i class="fal fa-border-all"></i> <?php echo e(trans('Dashboard')); ?>

                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.profile')); ?>">
                    <i class="fal fa-user"></i> <?php echo app('translator')->get('My Profile'); ?>
                </a>
            </li>

            <li>
                <a href="<?php echo e(route('user.twostep.security')); ?>">
                    <i class="fal fa-lock"></i> <?php echo app('translator')->get('2FA Security'); ?>
                </a>
            </li>

            <li>
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fal fa-sign-out-alt"></i> <?php echo app('translator')->get('Logout'); ?>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
            </li>
        </ul>
</div>
<?php /**PATH C:\xampp\htdocs\inventory_management\project\resources\views/themes/original/partials/userDropdown.blade.php ENDPATH**/ ?>