<!-- sidebar -->
<?php
    $user = \Illuminate\Support\Facades\Auth::user();
?>

<?php
    $currentRouteName = request()->route()->getName();
?>

<div id="sidebar" class="">
    <div class="sidebar-top">
        <?php if(userType() == 1 && (optional(auth()->user()->role)->company == null || optional(auth()->user()->role)->company != null)): ?>
            <a class="navbar-brand d-none d-lg-block" href="<?php echo e(url('/')); ?>"> <img
                    src="<?php echo e(getFile(optional($user->activeCompany)->driver, optional($user->activeCompany)->logo)); ?>"
                    alt="<?php echo e(config('basic.site_title')); ?>"/></a>
        <?php elseif(userType() == 2): ?>
            <a class="navbar-brand d-none d-lg-block" href="<?php echo e(url('/')); ?>"> <img
                    src="<?php echo e(getFile(optional(optional($user->salesCenter)->company)->driver, optional(optional($user->salesCenter)->company)->logo)); ?>"
                    alt="<?php echo e(config('basic.site_title')); ?>"/></a>
        <?php endif; ?>

        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">
        <?php if(adminAccessRoute(array_merge(config('permissionList.Company_Dashboard.Dashboard.permission.view')))): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.home'])); ?>" href="<?php echo e(route('user.home')); ?>"><i
                        class="fal fa-house-flood"></i><?php echo app('translator')->get('Dashboard'); ?></a>
            </li>
        <?php endif; ?>

        <?php if(auth()->user()->role_id == 0 && userType() == 1): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.companyList', 'user.createCompany', 'user.companyEdit'])); ?>"
                   href="<?php echo e(route('user.companyList')); ?>"><i class="fal fa-building"></i><?php echo app('translator')->get('Companies'); ?></a>
            </li>
        <?php endif; ?>

        
        
        
        
        
        
        

        
        
        
        
        
        
        

        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Employee_List.permission.view')))): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownEmployees"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-users"></i> <?php echo app('translator')->get('Employees'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.employeeList', 'user.createEmployee', 'user.employeeDetails', 'user.employeeEdit', 'user.employeeSalaryList'],4)); ?> dropdownRawItems"
                    id="dropdownEmployees">
                    <ul class="">
                        <?php if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Item_List.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.employeeList', 'user.createEmployee', 'user.employeeEdit']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.employeeList')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Employee List'); ?>
                                </a>
                            </li>

                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.employeeSalaryList']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.employeeSalaryList')); ?>">
                                    <i class="fal fa-right-long"></i> <?php echo app('translator')->get('Salary List'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Suppliers.Suppliers.permission.view')))): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.suppliers', 'user.createSupplier', 'user.supplierEdit', 'user.supplierDetails'])); ?>"
                   href="<?php echo e(route('user.suppliers')); ?>"><i class="fal fa-people-carry"></i> <?php echo app('translator')->get('Suppliers'); ?></a>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Sales_Center.Sales_Center.permission.view')))): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.salesCenterList', 'user.createSalesCenter', 'user.salesCenterEdit', 'user.salesCenterDetails'])); ?>"
                   href="<?php echo e(route('user.salesCenterList')); ?>"> <i class="fal fa-shop"></i> <?php echo app('translator')->get('Sales Center'); ?></a>
            </li>
        <?php endif; ?>

        <?php if(userType() == 2): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.customerList', 'user.createCustomer', 'user.customerDetails', 'user.customerEdit'])); ?>"
                   href="<?php echo e(route('user.customerList')); ?>"><i class="fal fa-users"></i> <?php echo app('translator')->get('Customers'); ?></a>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Raw_Items.Item_List.permission.view'), config('permissionList.Manage_Raw_Items.Purchase.permission.add'), config('permissionList.Manage_Raw_Items.Purchase_History.permission.view'), config('permissionList.Manage_Raw_Items.Stock_List.permission.view')))): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownRawItems"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-rectangle-list"></i> <?php echo app('translator')->get('Raw Items'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.rawItemList', 'user.purchaseRawItem', 'user.purchaseRawItemList', 'user.rawItemPurchaseDetails', 'user.purchaseRawItemStocks'],4)); ?> dropdownRawItems"
                    id="dropdownRawItems">
                    <ul class="">
                        <?php if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Item_List.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.rawItemList']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.rawItemList')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Item List'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Purchase.permission.add'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseRawItem']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.purchaseRawItem')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Purchase'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Purchase_History.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseRawItemList', 'user.rawItemPurchaseDetails']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.purchaseRawItemList')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Purchased History'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Stock_List.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseRawItemStocks']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.purchaseRawItemStocks')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Stock List'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Items.Items.permission.view')))): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.itemList'])); ?>" href="<?php echo e(route('user.itemList')); ?>"> <i
                        class="fal fa-list-ol"></i><?php echo app('translator')->get('Items'); ?></a>
            </li>
        <?php endif; ?>

        <?php if(userType() == 2 || (userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Stocks.Stock_List.permission.view'), config('permissionList.Manage_Stocks.Stock_In.permission.add'), config('permissionList.Manage_Stocks.Stock_Transfer.permission.add'), config('permissionList.Manage_Stocks.Stock_Transfer_List.permission.view'))))): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownManageStocks"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-inventory"></i><?php echo app('translator')->get('Stocks'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.stockList', 'user.addStock', 'user.stockDetails', 'user.stockTransfer', 'user.stockTransferList', 'user.stockTransferDetails'],4)); ?> dropdownManageStocks"
                    id="dropdownManageStocks">
                    <ul class="">
                        <?php if(adminAccessRoute(config('permissionList.Manage_Stocks.Stock_List.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.stockList', 'user.stockDetails']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.stockList')); ?>"><i
                                        class="fal fa-right-long"></i><?php echo app('translator')->get('Stock List'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(userType() == 1 && adminAccessRoute(config('permissionList.Manage_Stocks.Stock_In.permission.add'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.addStock']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.addStock')); ?>"><i
                                        class="fal fa-right-long"></i><?php echo app('translator')->get('Stock In'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(userType() == 1 && adminAccessRoute(config('permissionList.Manage_Stocks.Stock_Transfer.permission.add'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.stockTransfer']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.stockTransfer')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Stock Transfer'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(userType() == 1 && adminAccessRoute(config('permissionList.Manage_Stocks.Stock_Transfer_List.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.stockTransferList', 'user.stockTransferDetails']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.stockTransferList')); ?>"><i
                                        class="fal fa-right-long"></i><?php echo app('translator')->get('Stock Transfer List'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if(userType() == 2 || (userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Sales.Sales_List.permission.view'))))): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownManageSales"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-cart-plus"></i> <?php echo app('translator')->get('Sales'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.salesItem', 'user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales'],4)); ?> dropdownManageSales"
                    id="dropdownManageSales">
                    <ul class="">
                        <?php if(adminAccessRoute(config('permissionList.Manage_Sales.Sales_List.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.salesList')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Sales List'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(userType() == 2): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.salesItem']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.salesItem')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Sales Item'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if((userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Wastage.Wastage.permission.view'))))): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.wastageList'])); ?>" href="<?php echo e(route('user.wastageList')); ?>"> <i
                        class="fal fa-trash-alt" aria-hidden="true"></i><?php echo app('translator')->get('Wastage'); ?></a>
            </li>
        <?php endif; ?>

        <?php if((userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Stock_Missing.Stock_Missing.permission.view'))))): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.stockMissingList'])); ?>" href="<?php echo e(route('user.stockMissingList')); ?>"> <i
                        class="fal regular fa-square-minus"></i> <?php echo app('translator')->get('Stock Missing'); ?></a>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate.Affiliate.permission.view')))): ?>
            <li>
                <a class="<?php echo e(menuActive(['user.affiliateMemberList', 'user.createAffiliateMember', 'user.affiliateMemberEdit'])); ?>"
                   href="<?php echo e(route('user.affiliateMemberList')); ?>"><i class="fal fa-sitemap"></i><?php echo app('translator')->get('Affiliate'); ?>
                </a>
            </li>
        <?php endif; ?>


        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_Category.permission.view'), config('permissionList.Manage_Expense.Expense_List.permission.view')))): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropDownExpense"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-money-bill"></i><?php echo app('translator')->get('Expense'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.expenseCategory', 'user.expenseList'],4)); ?> dropDownExpense"
                    id="dropDownExpense">
                    <ul class="">
                        <?php if(adminAccessRoute(config('permissionList.Manage_Expense.Expense_Category.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.expenseCategory']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.expenseCategory')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Expense Category'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Expense.Expense_List.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.expenseList']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.expenseList')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Expense List'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Reports.Purchase_Report.permission.view'), config('permissionList.Manage_Reports.Purchase_Payment_Report.permission.view'), config('permissionList.Manage_Reports.Stock_Report.permission.view'), config('permissionList.Manage_Reports.Sales_Report.permission.view'), config('permissionList.Manage_Reports.Sales_Payment_Report.permission.view'), config('permissionList.Manage_Reports.Wastage_Report.permission.view'), config('permissionList.Manage_Reports.Affiliation_Report.permission.view'), config('permissionList.Manage_Reports.Expense_Report.permission.view'), config('permissionList.Manage_Reports.Profit_And_Loss_Report.permission.view')))): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownManageReports"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-file-excel"></i> <?php echo app('translator')->get('Reports'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.purchaseReports', 'user.stockMissingReports', 'user.stockReports', 'user.wastageReports', 'user.expenseReports', 'user.purchasePaymentReports', 'user.affiliateReports', 'user.salesReports', 'user.salesPaymentReports', 'user.profitLossReports'],4)); ?> dropdownManageReports"
                    id="dropdownManageReports">
                    <ul class="">
                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Purchase_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.purchaseReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.purchaseReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Purchase Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Purchase_Payment_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.purchasePaymentReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.purchasePaymentReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Purchase Payment'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Stock_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.stockReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.stockReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Stock Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Sales_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.salesReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.salesReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Sales Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Sales_Payment_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.salesPaymentReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.salesPaymentReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Sales Payment'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Wastage_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.wastageReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.wastageReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Wastage Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('user.affiliateReports'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.affiliateReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.affiliateReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Affiliate Reports'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Stock_Missing_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.stockMissingReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.stockMissingReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Stock Missing Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Expense_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.expenseReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.expenseReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Expense Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Salary_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.salaryReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.salaryReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Salary Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Profit_And_Loss_Report.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.profitLossReports']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.profitLossReports')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Profit & Loss Report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if((userType() == 1 && auth()->user()->role_id == 0) || (userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.view'), config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.view'))) )): ?>
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropDownRolesAndPermission"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-user-lock"></i><?php echo app('translator')->get('Roles & Permission'); ?>
                </a>
                <div
                    class="collapse <?php echo e(menuActive(['user.role', 'user.role.staff', 'user.createRole', 'user.editRole'],4)); ?> dropDownRolesAndPermission"
                    id="dropDownRolesAndPermission">
                    <ul class="">
                        <?php if(adminAccessRoute(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.role']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.role')); ?>"><i
                                        class="fal fa-right-long"></i> <?php echo app('translator')->get('Available Roles'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(adminAccessRoute(config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.view'))): ?>
                            <li>
                                <a class="<?php echo e(in_array($currentRouteName, ['user.role.staff']) ? 'active' : ''); ?>"
                                   href="<?php echo e(route('user.role.staff')); ?>"><i class="fal fa-right-long"></i>
                                    <?php echo app('translator')->get('Manage Staff'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
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

    <?php if(auth()->user()->role_id == 0 && userType() == 1): ?>
        <?php echo $__env->make($theme . 'partials.sidebarBottom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

</div>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/partials/sidebar.blade.php ENDPATH**/ ?>