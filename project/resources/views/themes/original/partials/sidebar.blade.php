<!-- sidebar -->
@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

@php
    $currentRouteName = request()->route()->getName();
@endphp

<div id="sidebar" class="">
    <div class="sidebar-top">
        @if(userType() == 1 && optional(auth()->user()->role)->company == null)
            <a class="navbar-brand d-none d-lg-block" href="{{url('/')}}"> <img
                    src="{{getFile(config('location.companyLogo.path').optional($user->activeCompany)->logo)}}"
                    alt="{{config('basic.site_title')}}"/></a>
        @elseif(userType() == 2)
            <a class="navbar-brand d-none d-lg-block" href="{{url('/')}}"> <img
                    src="{{getFile(config('location.companyLogo.path'). optional(optional($user->salesCenter)->company)->logo)}}"
                    alt="{{config('basic.site_title')}}"/></a>
        @endif

        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">

        @if(adminAccessRoute(array_merge(config('permissionList.Company_Dashboard.Dashboard.permission.view'))))
            <li>
                <a class="{{menuActive(['user.home'])}}" href="{{ route('user.home') }}"><i
                        class="fal fa-house-flood"></i>@lang('Dashboard')</a>
            </li>
        @endif

        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Companies.Companies.permission.view'))))
            <li>
                <a class="{{menuActive(['user.companyList', 'user.createCompany', 'user.companyEdit'])}}"
                   href="{{ route('user.companyList') }}"><i class="fal fa-building"></i>@lang('Companies')</a>
            </li>
        @endif

        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Suppliers.Suppliers.permission.view'))))
            <li>
                <a class="{{menuActive(['user.suppliers'])}}"
                   href="{{ route('user.suppliers') }}"><i class="fab fa-adversal"></i>@lang('Suppliers')</a>
            </li>
        @endif

        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Sales_Center.Sales_Center.permission.view'))))
            <li>
                <a class="{{menuActive(['user.salesCenterList', 'user.createSalesCenter', 'user.salesCenterDetails'])}}"
                   href="{{ route('user.salesCenterList') }}"><i class="fab fa-adversal"></i>@lang('Sales Center')</a>
            </li>
        @endif

        @if(userType() == 2)
            <li>
                <a class="{{menuActive(['user.customerList', 'user.createCustomer', 'user.customerDetails', 'user.customerEdit'])}}"
                   href="{{ route('user.customerList') }}"><i class="fal fa-users"></i> @lang('Customers')</a>
            </li>
        @endif

        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Raw_Items.Items.permission.view'), config('permissionList.Manage_Raw_Items.Purchase.permission.view'), config('permissionList.Manage_Raw_Items.Purchase_History.permission.view'), config('permissionList.Manage_Raw_Items.Stock_List.permission.view'))))
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownRawItems"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i>@lang('Raw Items')
                </a>
                <div
                    class="collapse {{menuActive(['user.rawItemList', 'user.purchaseRawItem', 'user.purchaseRawItemList', 'user.rawItemPurchaseDetails', 'user.purchaseRawItemStocks'],4)}} dropdownRawItems"
                    id="dropdownRawItems">
                    <ul class="">
                        @if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Items.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.rawItemList']) ? 'active' : '' }}"
                                   href="{{ route('user.rawItemList') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Item List')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Items.Purchase.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.purchaseRawItem']) ? 'active' : '' }}"
                                   href="{{ route('user.purchaseRawItem') }}"><i
                                        class="fal fa-house-return"></i>@lang('Purchase')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Items.Purchase_History.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.purchaseRawItemList', 'user.rawItemPurchaseDetails']) ? 'active' : '' }}"
                                   href="{{ route('user.purchaseRawItemList') }}"><i
                                        class="fal fa-house-return"></i>@lang('Purchased History')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Items.Stock_List.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.purchaseRawItemStocks']) ? 'active' : '' }}"
                                   href="{{ route('user.purchaseRawItemStocks') }}"><i
                                        class="fal fa-house-return"></i>@lang('Item Stocks')
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Items.Items.permission.view'))))
            <li>
                <a class="{{menuActive(['user.itemList'])}}" href="{{ route('user.itemList') }}"><i
                        class="fal fa-sitemap"></i>@lang('Items')</a>
            </li>
        @endif

        @if(userType() == 2 || (userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Stocks.Stocks.permission.view')))))
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownManageStocks"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i>@lang('Stocks')
                </a>
                <div
                    class="collapse {{menuActive(['user.stockList', 'user.addStock', 'user.stockDetails', 'user.stockTransfer', 'user.stockTransferList'],4)}} dropdownManageStocks"
                    id="dropdownManageStocks">
                    <ul class="">
                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.stockList', 'user.stockDetails']) ? 'active' : '' }}"
                               href="{{ route('user.stockList') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Stock List')
                            </a>
                        </li>
                        @if(userType() == 1)
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.addStock']) ? 'active' : '' }}"
                                   href="{{ route('user.addStock') }}"><i class="fal fa-house-return"></i>@lang('Stock In')
                                </a>
                            </li>

                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.stockTransfer']) ? 'active' : '' }}" href="{{ route('user.stockTransfer') }}"><i
                                        class="fal fa-house-return"></i>@lang('Stock Transfer')
                                </a>
                            </li>

                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.stockTransferList']) ? 'active' : '' }}" href="{{ route('user.stockTransferList') }}"><i
                                        class="fal fa-house-return"></i>@lang('Stock Transfer List')
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

        @if(userType() == 2 || (userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Sales.Sales_List.permission.view')))))
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownManageSales"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i>@lang('Sales')
                </a>
                <div class="collapse {{menuActive(['user.salesItem', 'user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales'],4)}} dropdownManageSales" id="dropdownManageSales">
                    <ul class="">
                        @if(adminAccessRoute(config('permissionList.Manage_Sales.Sales_List.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales']) ? 'active' : '' }}"
                                   href="{{ route('user.salesList') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Sales List')
                                </a>
                            </li>
                        @endif

                        @if(userType() == 2)
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.salesItem']) ? 'active' : '' }}"
                                   href="{{ route('user.salesItem') }}"><i
                                        class="fal fa-house-return"></i>@lang('Sales Item')
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

        @if((userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Wastage.Wastage.permission.view')))))
            <li>
                <a class="{{menuActive(['user.wastageList'])}}" href="{{ route('user.wastageList') }}"><i
                        class="fal fa-sitemap"></i>@lang('Wastage')</a>
            </li>
        @endif

        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate_Members.Affiliate.permission.view'))))
            <li>
                <a class="{{menuActive(['user.affiliateMemberList', 'user.createAffiliateMember', 'user.affiliateMemberEdit'])}}"
                   href="{{ route('user.affiliateMemberList') }}"><i class="fal fa-sitemap"></i>@lang('Affiliate')
                </a>
            </li>
        @endif


        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_Category.permission.view'), config('permissionList.Manage_Expense.Expense_List.permission.view'))))
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropDownExpense"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i>@lang('Expense')
                </a>
                <div
                    class="collapse {{menuActive(['user.expenseCategory', 'user.expenseList'],4)}} dropDownExpense"
                    id="dropDownExpense">
                    <ul class="">
                        @if(adminAccessRoute(config('permissionList.Manage_Expense.Expense_Category.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.expenseCategory']) ? 'active' : '' }}"
                                   href="{{ route('user.expenseCategory') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Expense Category')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Expense.Expense_List.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.expenseList']) ? 'active' : '' }}"
                                   href="{{ route('user.expenseList') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Expense List')
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

        @if(userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Reports.Purchase_Report.permission.view'), config('permissionList.Manage_Reports.Purchase_Payment_Report.permission.view'), config('permissionList.Manage_Reports.Stock_Report.permission.view'), config('permissionList.Manage_Reports.Sales_Report.permission.view'), config('permissionList.Manage_Reports.Sales_Payment_Report.permission.view'), config('permissionList.Manage_Reports.Wastage_Report.permission.view'), config('permissionList.Manage_Reports.Affiliation_Report.permission.view'), config('permissionList.Manage_Reports.Expense_Report.permission.view'), config('permissionList.Manage_Reports.Profit_And_Loss_Report.permission.view'))))
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropdownManageReports"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i>@lang('Reports')
                </a>
                <div
                    class="collapse {{menuActive(['user.purchaseReports', 'user.stockReports', 'user.wastageReports', 'user.expenseReports', 'user.purchasePaymentReports', 'user.affiliateReports', 'user.salesReports', 'user.salesPaymentReports', 'user.profitLossReports'],4)}} dropdownManageReports"
                    id="dropdownManageReports">
                    <ul class="">
                        @if(adminAccessRoute(config('permissionList.Manage_Reports.Purchase_Report.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.purchaseReports']) ? 'active' : '' }}"
                                   href="{{ route('user.purchaseReports') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Purchase Report')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Reports.Purchase_Payment_Report.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.purchasePaymentReports']) ? 'active' : '' }}"
                                   href="{{ route('user.purchasePaymentReports') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Purchase Payment')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Reports.Stock_Report.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.stockReports']) ? 'active' : '' }}"
                                   href="{{ route('user.stockReports') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Stock Report')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Reports.Sales_Report.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.salesReports']) ? 'active' : '' }}"
                                   href="{{ route('user.salesReports') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Sales Report')
                                </a>
                            </li>
                        @endif

                        @if(adminAccessRoute(config('permissionList.Manage_Reports.Sales_Payment_Report.permission.view')))
                            <li>
                                <a class="{{ in_array($currentRouteName, ['user.salesPaymentReports']) ? 'active' : '' }}"
                                   href="{{ route('user.salesPaymentReports') }}"><i
                                        class="fal fa-sack-dollar"></i>@lang('Sales Payment')
                                </a>
                            </li>
                        @endif

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.wastageReports']) ? 'active' : '' }}"
                               href="{{ route('user.wastageReports') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Wastage Report')
                            </a>
                        </li>

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.affiliateReports']) ? 'active' : '' }}"
                               href="{{ route('user.affiliateReports') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Affiliation Report')
                            </a>
                        </li>

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.expenseReports']) ? 'active' : '' }}"
                               href="{{ route('user.expenseReports') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Expense Report')
                            </a>
                        </li>

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.profitLossReports']) ? 'active' : '' }}"
                               href="{{ route('user.profitLossReports') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Profit & Loss Report')
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
        @endif

        @if((userType() == 1 && auth()->user()->role_id == 0) || (userType() == 1 && adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.view'), config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.view'))) ))
            <li>
                <a
                    class="dropdown-toggle"
                    data-bs-toggle="collapse"
                    href="#dropDownRolesAndPermission"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    <i class="fal fa-car-building"></i>@lang('Roles & Permission')
                </a>
                <div
                    class="collapse {{menuActive(['user.role', 'user.role.staff'],4)}} dropDownRolesAndPermission"
                    id="dropDownRolesAndPermission">
                    <ul class="">
                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.role']) ? 'active' : '' }}"
                               href="{{ route('user.role') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Available Roles')
                            </a>
                        </li>

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.role.staff']) ? 'active' : '' }}"
                               href="{{ route('user.role.staff') }}"><i
                                    class="fal fa-sack-dollar"></i>
                                @lang('Manage Staff')
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif


        <li class="d-lg-none">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fal fa-sign-out-alt"></i> @lang('Logout')
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>

    @include($theme . 'partials.sidebarBottom')

</div>
