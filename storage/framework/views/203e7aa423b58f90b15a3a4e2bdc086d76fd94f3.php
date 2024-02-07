<!-- sidebar -->
<?php
    $user = \Illuminate\Support\Facades\Auth::user();
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



























        <?php
            $currentRouteName = request()->route()->getName();
        ?>

        <li>
            <a
                class="dropdown-toggle"
                data-bs-toggle="collapse"
                href="#dropdownManageStocks"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample">
                <i class="fal fa-car-building"></i><?php echo app('translator')->get('Stocks'); ?>
            </a>
            <div
                class="collapse <?php echo e(menuActive(['user.stockList', 'user.addStock', 'user.stockDetails'],4)); ?> dropdownManageStocks"
                id="dropdownManageStocks">
                <ul class="">
                    <li>
                        <a class="<?php echo e(in_array($currentRouteName, ['user.stockList', 'user.stockDetails']) ? 'active' : ''); ?>"
                           href="<?php echo e(route('user.stockList')); ?>"><i class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Stock List'); ?>
                        </a>
                    </li>
                    <?php if(userType() == 1): ?>
                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.addStock']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.addStock')); ?>"><i class="fal fa-house-return"></i><?php echo app('translator')->get('Stock In'); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>


        <li>
            <a
                class="dropdown-toggle"
                data-bs-toggle="collapse"
                href="#dropdownManageSales"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample">
                <i class="fal fa-car-building"></i><?php echo app('translator')->get('Sales'); ?>
            </a>
            <div
                class="collapse <?php echo e(menuActive(['user.salesItem', 'user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales'],4)); ?> dropdownManageSales"
                id="dropdownManageSales">
                <ul class="">
                    <li>
                        <a class="<?php echo e(in_array($currentRouteName, ['user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales']) ? 'active' : ''); ?>"
                           href="<?php echo e(route('user.salesList')); ?>"><i class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Sales List'); ?>
                        </a>
                    </li>
                    <li>
                        <a class="<?php echo e(in_array($currentRouteName, ['user.salesItem']) ? 'active' : ''); ?>"
                           href="<?php echo e(route('user.salesItem')); ?>"><i class="fal fa-house-return"></i><?php echo app('translator')->get('Sales Item'); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </li>








        
        
        
        

        <?php if(userType() == 1): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownRawItems"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i><?php echo app('translator')->get('Raw Items'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.rawItemList', 'user.purchaseRawItem', 'user.purchaseRawItemList', 'user.rawItemPurchaseDetails', 'user.purchaseRawItemStocks'],4)); ?> dropdownRawItems"
                    id="dropdownRawItems">
                    <ul class="">
                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.rawItemList']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.rawItemList')); ?>"><i
                                    class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Item List'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseRawItem']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.purchaseRawItem')); ?>"><i
                                    class="fal fa-house-return"></i><?php echo app('translator')->get('Purchase'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseRawItemList', 'user.rawItemPurchaseDetails']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.purchaseRawItemList')); ?>"><i
                                    class="fal fa-house-return"></i><?php echo app('translator')->get('Purchased History'); ?>
                            </a>
                        </li>

                        <li>
                            <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseRawItemStocks']) ? 'active' : ''); ?>"
                               href="<?php echo e(route('user.purchaseRawItemStocks')); ?>"><i
                                    class="fal fa-house-return"></i><?php echo app('translator')->get('Item Stocks'); ?>
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
                class="collapse <?php echo e(menuActive(['user.purchaseReports', 'user.stockReports', 'user.wastageReports', 'user.expenseReports', 'user.purchasePaymentReports', 'user.affiliateReports', 'user.salesReports', 'user.salesPaymentReports'],4)); ?> dropdownManageReports"
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

                </ul>
            </div>
        </li>

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