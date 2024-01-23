<!-- sidebar -->
@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<div id="sidebar" class="">
    <div class="sidebar-top">
        @if(userType() == 1)
            <a class="navbar-brand d-none d-lg-block" href="{{url('/')}}"> <img
                    src="{{getFile(config('location.companyLogo.path').optional($user->activeCompany)->logo)}}"
                    alt="{{config('basic.site_title')}}"/></a>
        @else
            <a class="navbar-brand d-none d-lg-block" href="{{url('/')}}"> <img
                    src="{{getFile(config('location.companyLogo.path'). optional(optional($user->salesCenter)->company)->logo)}}"
                    alt="{{config('basic.site_title')}}"/></a>
        @endif

        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">
        <li>
            <a class="{{menuActive(['user.home'])}}" href="{{ route('user.home') }}"><i
                    class="fal fa-house-flood"></i>@lang('Dashboard')</a>
        </li>

        @if(userType() == 1)
            <li>
                <a class="{{menuActive(['user.companyList', 'user.createCompany', 'user.companyEdit'])}}"
                   href="{{ route('user.companyList') }}"><i class="fal fa-building"></i>@lang('Companies')</a>
            </li>
        @endif

        <li>
            <a class="{{menuActive(['user.customerList', 'user.createCustomer', 'user.customerDetails', 'user.customerEdit'])}}"
               href="{{ route('user.customerList') }}"><i class="fal fa-users"></i> @lang('Customers')</a>
        </li>

        @if(userType() == 1)
            <li>
                <a class="{{menuActive(['user.salesCenterList', 'user.createSalesCenter', 'user.salesCenterDetails'])}}"
                   href="{{ route('user.salesCenterList') }}"><i class="fab fa-adversal"></i>@lang('Sales Center')</a>
            </li>
        @endif

        @if(userType() == 1)
            <li>
                <a class="{{menuActive(['user.itemList'])}}" href="{{ route('user.itemList') }}"><i
                        class="fal fa-sitemap"></i>@lang('Items')</a>
            </li>
        @endif

        @php
            $currentRouteName = request()->route()->getName();
        @endphp

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
                class="collapse {{menuActive(['user.stockList', 'user.addStock', 'user.stockDetails'],4)}} dropdownManageStocks"
                id="dropdownManageStocks">
                <ul class="">
                    <li>
                        <a class="{{ in_array($currentRouteName, ['user.stockList', 'user.stockDetails']) ? 'active' : '' }}"
                           href="{{ route('user.stockList') }}"><i class="fal fa-sack-dollar"></i>@lang('Stock List')
                        </a>
                    </li>
                    @if(userType() == 1)
                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.addStock']) ? 'active' : '' }}"
                               href="{{ route('user.addStock') }}"><i class="fal fa-house-return"></i>@lang('Stock In')
                            </a>
                        </li>
                    @endif
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
                <i class="fal fa-car-building"></i>@lang('Sales')
            </a>
            <div
                class="collapse {{menuActive(['user.salesItem', 'user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales'],4)}} dropdownManageSales"
                id="dropdownManageSales">
                <ul class="">
                    <li>
                        <a class="{{ in_array($currentRouteName, ['user.salesList', 'user.salesDetails', 'user.salesInvoice', 'user.returnSales']) ? 'active' : '' }}"
                           href="{{ route('user.salesList') }}"><i class="fal fa-sack-dollar"></i>@lang('Sales List')
                        </a>
                    </li>
                    <li>
                        <a class="{{ in_array($currentRouteName, ['user.salesItem']) ? 'active' : '' }}"
                           href="{{ route('user.salesItem') }}"><i class="fal fa-house-return"></i>@lang('Sales Item')
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        @if(userType() == 1)
            <li>
                <a class="{{menuActive(['user.suppliers'])}}"
                   href="{{ route('user.suppliers') }}"><i class="fab fa-adversal"></i>@lang('Suppliers')</a>
            </li>
        @endif

        {{--        <li>--}}
        {{--            <a class="{{menuActive(['user.raw-items'])}}"--}}
        {{--               href="{{ route('user.raw-items') }}"><i class="fab fa-adversal"></i>@lang('Raw Items')</a>--}}
        {{--        </li>--}}

        @if(userType() == 1)
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
                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.rawItemList']) ? 'active' : '' }}"
                               href="{{ route('user.rawItemList') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Item List')
                            </a>
                        </li>
                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.purchaseRawItem']) ? 'active' : '' }}"
                               href="{{ route('user.purchaseRawItem') }}"><i
                                    class="fal fa-house-return"></i>@lang('Purchase')
                            </a>
                        </li>

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.purchaseRawItemList', 'user.rawItemPurchaseDetails']) ? 'active' : '' }}"
                               href="{{ route('user.purchaseRawItemList') }}"><i
                                    class="fal fa-house-return"></i>@lang('Purchased History')
                            </a>
                        </li>

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.purchaseRawItemStocks']) ? 'active' : '' }}"
                               href="{{ route('user.purchaseRawItemStocks') }}"><i
                                    class="fal fa-house-return"></i>@lang('Item Stocks')
                            </a>
                        </li>
                    </ul>
                </div>


            </li>
        @endif

        @if(userType() == 1)
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
                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.expenseCategory']) ? 'active' : '' }}"
                               href="{{ route('user.expenseCategory') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Expense Category')
                            </a>
                        </li>

                        <li>
                            <a class="{{ in_array($currentRouteName, ['user.expenseList']) ? 'active' : '' }}"
                               href="{{ route('user.expenseList') }}"><i
                                    class="fal fa-sack-dollar"></i>@lang('Expense List')
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if(userType() == 1)
            <li>
                <a class="{{menuActive(['user.wastageList'])}}" href="{{ route('user.wastageList') }}"><i
                        class="fal fa-sitemap"></i>@lang('Wastage')</a>
            </li>
        @endif

        @if(userType() == 1)
            <li>
                <a class="{{menuActive(['user.affiliateMemberList', 'user.createAffiliateMember', 'user.affiliateMemberEdit'])}}"
                   href="{{ route('user.affiliateMemberList') }}"><i class="fal fa-sitemap"></i>@lang('Affiliate')</a>
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
