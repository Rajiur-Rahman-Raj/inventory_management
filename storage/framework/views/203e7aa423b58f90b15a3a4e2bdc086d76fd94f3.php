<!-- sidebar -->
<?php
    $user = \Illuminate\Support\Facades\Auth::user();
    $user_badge = \App\Models\Badge::with('details')->where('id', @$user->last_level)->first();
?>
<div id="sidebar" class="">
    <div class="sidebar-top">
        <a class="navbar-brand d-none d-lg-block" href="<?php echo e(url('/')); ?>"> <img
                src="<?php echo e(getFile(config('location.companyLogo.path').@Auth::user()->activeCompany->logo)); ?>"
                alt="<?php echo e(config('basic.site_title')); ?>"/></a>
        <div class="mobile-user-area d-lg-none">
            <div class="thumb">
                <img class="img-fluid user-img" src="<?php echo e(getFile(config('location.user.path').auth()->user()->image)); ?>"
                     alt="...">
                <?php if(optional($user->userBadge)->badge_icon): ?>
                    <img src="<?php echo e(getFile(config('location.badge.path').optional($user->userBadge)->badge_icon)); ?>"
                         alt="" class="rank-badge">
                <?php endif; ?>
            </div>

            <div class="content">
                <h5 class="mt-1 mb-1"><?php echo e(__(auth()->user()->fullname)); ?></h5>
                <span class=""><?php echo e(__(auth()->user()->username)); ?></span>
                <?php if(@$user->last_level != null && $user_badge): ?>
                    <p class="text-small mb-0"><?php echo app('translator')->get(optional($user->userBadge->details)->rank_name); ?> -
                        (<?php echo app('translator')->get((optional($user->userBadge->details)->rank_level)); ?>)</p>
                <?php endif; ?>
            </div>
        </div>

        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">
        <li>
            <a class="<?php echo e(menuActive(['user.home'])); ?>" href="<?php echo e(route('user.home')); ?>"><i
                    class="fal fa-house-flood"></i><?php echo app('translator')->get('Dashboard'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.companyList', 'user.createCompany', 'user.companyEdit'])); ?>"
               href="<?php echo e(route('user.companyList')); ?>"><i class="fal fa-building"></i><?php echo app('translator')->get('Companies'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.customerList', 'user.createCustomer', 'user.customerDetails', 'user.customerEdit'])); ?>"
               href="<?php echo e(route('user.customerList')); ?>"><i class="fal fa-users"></i> <?php echo app('translator')->get('Customers'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.salesCenterList', 'user.createSalesCenter', 'user.salesCenterDetails'])); ?>"
               href="<?php echo e(route('user.salesCenterList')); ?>"><i class="fab fa-adversal"></i><?php echo app('translator')->get('Sales Center'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.itemList'])); ?>" href="<?php echo e(route('user.itemList')); ?>"><i
                    class="fal fa-sitemap"></i><?php echo app('translator')->get('Items'); ?></a>
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
                    <li>
                        <a class="<?php echo e(in_array($currentRouteName, ['user.addStock']) ? 'active' : ''); ?>"
                           href="<?php echo e(route('user.addStock')); ?>"><i class="fal fa-house-return"></i><?php echo app('translator')->get('Stock In'); ?></a>
                    </li>
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

        <li>
            <a class="<?php echo e(menuActive(['user.suppliers'])); ?>"
               href="<?php echo e(route('user.suppliers')); ?>"><i class="fab fa-adversal"></i><?php echo app('translator')->get('Suppliers'); ?></a>
        </li>

        
        
        
        

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
                           href="<?php echo e(route('user.rawItemList')); ?>"><i class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Item List'); ?>
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

        <li>
            <a class="<?php echo e(menuActive(['user.wastageList'])); ?>" href="<?php echo e(route('user.wastageList')); ?>"><i class="fal fa-sitemap"></i><?php echo app('translator')->get('Wastage'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.affiliateMemberList'])); ?>" href="<?php echo e(route('user.affiliateMemberList')); ?>"><i class="fal fa-sitemap"></i><?php echo app('translator')->get('Affiliate'); ?></a>
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