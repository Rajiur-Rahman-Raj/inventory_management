<!-- sidebar -->
<?php
    $user = \Illuminate\Support\Facades\Auth::user();
    $user_badge = \App\Models\Badge::with('details')->where('id', @$user->last_level)->first();
?>
<div id="sidebar" class="">
    <div class="sidebar-top">
        <a class="navbar-brand d-none d-lg-block" href="<?php echo e(url('/')); ?>"> <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" alt="<?php echo e(config('basic.site_title')); ?>" /></a>
        <div class="mobile-user-area d-lg-none">
            <div class="thumb">
                <img class="img-fluid user-img" src="<?php echo e(getFile(config('location.user.path').auth()->user()->image)); ?>" alt="...">
                <?php if(optional($user->userBadge)->badge_icon): ?>
                    <img src="<?php echo e(getFile(config('location.badge.path').optional($user->userBadge)->badge_icon)); ?>" alt="" class="rank-badge">
                <?php endif; ?>
            </div>

            <div class="content">
                <h5 class="mt-1 mb-1"><?php echo e(__(auth()->user()->fullname)); ?></h5>
                <span class=""><?php echo e(__(auth()->user()->username)); ?></span>
                <?php if(@$user->last_level != null && $user_badge): ?>
                    <p class="text-small mb-0"><?php echo app('translator')->get(optional($user->userBadge->details)->rank_name); ?> - (<?php echo app('translator')->get((optional($user->userBadge->details)->rank_level)); ?>)</p>
                <?php endif; ?>
            </div>

        </div>
        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">
        <li>
            <a class="<?php echo e(menuActive(['user.home'])); ?>" href="<?php echo e(route('user.home')); ?>"><i class="fal fa-house-flood"></i><?php echo app('translator')->get('Dashboard'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.companyList'])); ?>" href="<?php echo e(route('user.companyList')); ?>"><i class="fal fa-building"></i><?php echo app('translator')->get('Company List'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.customerList'])); ?>" href="<?php echo e(route('user.customerList')); ?>"><i class="fal fa-users"></i> <?php echo app('translator')->get('Customer List'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.salesCenterList'])); ?>" href="<?php echo e(route('user.salesCenterList')); ?>"><i class="fab fa-adversal"></i><?php echo app('translator')->get('Sales Center'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.itemList'])); ?>" href="<?php echo e(route('user.itemList')); ?>"><i class="fal fa-sitemap"></i><?php echo app('translator')->get('Item List'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.stockList'])); ?>" href="<?php echo e(route('user.stockList')); ?>"><i class="fal fa-layer-group"></i><?php echo app('translator')->get('Stock In'); ?></a>
        </li>





        <?php
            $segments = request()->segments();
            $last  = end($segments);
            $manageSalesSegments = ['sales-items'];
            $manageSalesReturnSegments = ['sales-return'];
        ?>

        <li>
            <a
                class="dropdown-toggle <?php echo e(in_array($last, $manageSalesSegments) || in_array($segments[1], $manageSalesSegments) ? 'manageSalesActive' : ''); ?>"
                data-bs-toggle="collapse"
                href="#dropdownCollapsible"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample">
                <i class="fal fa-car-building"></i><?php echo app('translator')->get('Manage Sales'); ?>
            </a>
            <div class="collapse <?php echo e(menuActive(['user.salesItem', 'user.salesList'],4)); ?> dropdownCollapsible" id="dropdownCollapsible">
                <ul class="">
                    <li>
                        <a class="<?php echo e(($last == 'sales-list') ? 'active' : ''); ?>" href="<?php echo e(route('user.salesList')); ?>"><i class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Sales List'); ?></a>
                    </li>
                    <li>
                        <a class="<?php echo e(($last == 'sales-items') ? 'active' : ''); ?>"  href="<?php echo e(route('user.salesItem')); ?>"><i class="fal fa-house-return"></i><?php echo app('translator')->get('Sales Item'); ?></a>
                    </li>
                </ul>
            </div>
        </li>

        <li>
            <a
                class="dropdown-toggle <?php echo e(in_array($last, $manageSalesReturnSegments) || in_array($segments[1], $manageSalesReturnSegments) ? 'manageSalesActive' : ''); ?>"
                data-bs-toggle="collapse"
                href="#dropdownCollapsible"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample">
                <i class="fal fa-car-building"></i><?php echo app('translator')->get('Manage Return'); ?>
            </a>
            <div class="collapse <?php echo e(menuActive(['user.salesReturn'],4)); ?> dropdownCollapsible" id="dropdownCollapsible">
                <ul class="">



                    <li>
                        <a class="<?php echo e(($last == 'sales-return') ? 'active' : ''); ?>"  href="<?php echo e(route('user.salesReturn')); ?>"><i class="fal fa-house-return"></i><?php echo app('translator')->get('Sales Return'); ?></a>
                    </li>
                </ul>
            </div>
        </li>































































































        <li class="d-lg-none">
            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fal fa-sign-out-alt"></i> <?php echo app('translator')->get('Logout'); ?>
            </a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
        </li>
    </ul>

    <?php echo $__env->make($theme . 'partials.sidebarBottom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/partials/sidebar.blade.php ENDPATH**/ ?>