<!-- sidebar -->
<?php
    $user = \Illuminate\Support\Facades\Auth::user();
?>

<?php
    $currentRouteName = request()->route()->getName();
?>

<div id="sidebar" class="">
    <div class="sidebar-top">
        <?php if(userType() == 1): ?>
            <a class="navbar-brand d-none d-lg-block" href="<?php echo e(url('/')); ?>"> <img
                    src="<?php echo e(getFile(config('location.companyLogo.path').optional($user->activeCompany)->logo)); ?>"
                    alt="<?php echo e(config('basic.site_title')); ?>"/></a>
        <?php else: ?>
            <a class="navbar-brand d-none d-lg-block" href="<?php echo e(url('/')); ?>"> <img
                    src="<?php echo e(getFile(config('location.companyLogo.path'). optional(optional($user->salesCenter)->company)->logo)); ?>"
                    alt="<?php echo e(config('basic.site_title')); ?>"/></a>
        <?php endif; ?>

        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">
        <li>
            <a class="<?php echo e(menuActive(['user.home'])); ?>" href="<?php echo e(route('user.home')); ?>"><i
                    class="fal fa-house-flood"></i><?php echo app('translator')->get('Dashboard'); ?></a>
        </li>

        <?php if(userType() == 1): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.companyList', 'user.createCompany', 'user.companyEdit'])); ?>"
                   href="<?php echo e(route('user.companyList')); ?>"><i class="fal fa-building"></i><?php echo app('translator')->get('Companies'); ?></a>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.suppliers'])); ?>"
                   href="<?php echo e(route('user.suppliers')); ?>"><i class="fab fa-adversal"></i><?php echo app('translator')->get('Suppliers'); ?></a>
            </li>
        <?php endif; ?>














































































































































        <?php if(userType() == 1): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropDownExpense"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i><?php echo app('translator')->get('Expense'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.expenseCategory', 'user.expenseList'],4)); ?> dropDownExpense"
                    id="dropDownExpense">
                    <ul class="">
                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.expenseCategory']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.expenseCategory')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Expense Category'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.expenseList']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.expenseList')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Expense List'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownManageReports"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i><?php echo app('translator')->get('Reports'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.purchaseReports', 'user.stockReports', 'user.wastageReports', 'user.expenseReports', 'user.purchasePaymentReports', 'user.affiliateReports', 'user.salesReports', 'user.salesPaymentReports', 'user.profitLossReports'],4)); ?> dropdownManageReports"
                    id="dropdownManageReports">
                    <ul class="">
                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.purchaseReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Purchase Report'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.purchasePaymentReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.purchasePaymentReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Purchase Payment'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.stockReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.stockReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Stock Report'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.salesReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.salesReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Sales Report'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.salesPaymentReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.salesPaymentReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Sales Payment'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.wastageReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.wastageReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Wastage Report'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.affiliateReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.affiliateReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Affiliation Report'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.expenseReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.expenseReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Expense Report'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.profitLossReports']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.profitLossReports')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Profit & Loss Report'); ?>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropDownRolesAndPermission"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i><?php echo app('translator')->get('Roles & Permission'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.role'],4)); ?> dropDownRolesAndPermission"
                    id="dropDownRolesAndPermission">
                    <ul class="">
                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.role']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.role')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Available Roles'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.expenseList']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.expenseList')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Manage Staff'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>


        <li class="d-lg-none">
            <a href="<?php echo e(route('logout')); ?>"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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