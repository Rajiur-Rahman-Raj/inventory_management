<!-- sidebar -->
@php
    $user = \Illuminate\Support\Facades\Auth::user();
    $user_badge = \App\Models\Badge::with('details')->where('id', @$user->last_level)->first();
@endphp
<div id="sidebar" class="">
    <div class="sidebar-top">
        <a class="navbar-brand d-none d-lg-block" href="{{url('/')}}"> <img
                src="{{getFile(config('location.companyLogo.path').@Auth::user()->activeCompany->logo)}}"
                alt="{{config('basic.site_title')}}"/></a>
        <div class="mobile-user-area d-lg-none">
            <div class="thumb">
                <img class="img-fluid user-img" src="{{getFile(config('location.user.path').auth()->user()->image)}}"
                     alt="...">
                @if(optional($user->userBadge)->badge_icon)
                    <img src="{{ getFile(config('location.badge.path').optional($user->userBadge)->badge_icon) }}"
                         alt="" class="rank-badge">
                @endif
            </div>

            <div class="content">
                <h5 class="mt-1 mb-1">{{ __(auth()->user()->fullname) }}</h5>
                <span class="">{{ __(auth()->user()->username) }}</span>
                @if(@$user->last_level != null && $user_badge)
                    <p class="text-small mb-0">@lang(optional($user->userBadge->details)->rank_name) -
                        (@lang((optional($user->userBadge->details)->rank_level)))</p>
                @endif
            </div>
        </div>

        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">
        <li>
            <a class="{{menuActive(['user.home'])}}" href="{{ route('user.home') }}"><i
                    class="fal fa-house-flood"></i>@lang('Dashboard')</a>
        </li>

        <li>
            <a class="{{menuActive(['user.companyList', 'user.createCompany', 'user.companyEdit'])}}"
               href="{{ route('user.companyList') }}"><i class="fal fa-building"></i>@lang('Companies')</a>
        </li>

        <li>
            <a class="{{menuActive(['user.customerList', 'user.createCustomer', 'user.customerDetails', 'user.customerEdit'])}}"
               href="{{ route('user.customerList') }}"><i class="fal fa-users"></i> @lang('Customers')</a>
        </li>

        <li>
            <a class="{{menuActive(['user.salesCenterList', 'user.createSalesCenter', 'user.salesCenterDetails'])}}"
               href="{{ route('user.salesCenterList') }}"><i class="fab fa-adversal"></i>@lang('Sales Center')</a>
        </li>

        <li>
            <a class="{{menuActive(['user.itemList'])}}" href="{{ route('user.itemList') }}"><i
                    class="fal fa-sitemap"></i>@lang('Items')</a>
        </li>

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
                    <li>
                        <a class="{{ in_array($currentRouteName, ['user.addStock']) ? 'active' : '' }}"
                           href="{{ route('user.addStock') }}"><i class="fal fa-house-return"></i>@lang('Stock In')</a>
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

        <li>
            <a class="{{menuActive(['user.suppliers'])}}"
               href="{{ route('user.suppliers') }}"><i class="fab fa-adversal"></i>@lang('Suppliers')</a>
        </li>

{{--        <li>--}}
{{--            <a class="{{menuActive(['user.raw-items'])}}"--}}
{{--               href="{{ route('user.raw-items') }}"><i class="fab fa-adversal"></i>@lang('Raw Items')</a>--}}
{{--        </li>--}}

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
                class="collapse {{menuActive(['user.rawItemList', 'user.purchaseRawItem', 'user.purchaseRawItemList'],4)}} dropdownRawItems"
                id="dropdownRawItems">
                <ul class="">
                    <li>
                        <a class="{{ in_array($currentRouteName, ['user.rawItemList']) ? 'active' : '' }}"
                           href="{{ route('user.rawItemList') }}"><i class="fal fa-sack-dollar"></i>@lang('Item List')
                        </a>
                    </li>
                    <li>
                        <a class="{{ in_array($currentRouteName, ['user.purchaseRawItem']) ? 'active' : '' }}"
                           href="{{ route('user.purchaseRawItem') }}"><i class="fal fa-house-return"></i>@lang('Purchase In')
                        </a>
                    </li>

                    <li>
                        <a class="{{ in_array($currentRouteName, ['user.purchaseRawItemList']) ? 'active' : '' }}"
                           href="{{ route('user.purchaseRawItemList') }}"><i class="fal fa-house-return"></i>@lang('Purchased List')
                        </a>
                    </li>
                </ul>
            </div>
        </li>

{{--        <li>--}}
{{--            <a class="{{menuActive(['user.purchase-raw-items'])}}"--}}
{{--               href="{{ route('user.purchase-raw-items') }}"><i class="fab fa-adversal"></i>@lang('Purchase Raw Items')</a>--}}
{{--        </li>--}}

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
