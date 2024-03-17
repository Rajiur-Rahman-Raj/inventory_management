@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
    @push('style')
        <style>
            .balance-box {
                background: linear-gradient(to right, rgb(73 159 233), rgb(207 115 223));
            }
        </style>
    @endpush

    @if(adminAccessRoute(array_merge(config('permissionList.Company_Dashboard.Dashboard.permission.view'))))
        <div class="container-fluid">
            <div class="main row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end mb-5">
                            <a href="#" class="show-hide  me-3" data-info="1"> <i
                                    class="fal fa-eye showHideEye"></i></a>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-xl-4 col-lg-6">
                            <div class="card-box balance-box p-0 h-100 sales-statistics">
                                <div class="user-account-number h-100">
                                    <i class="account-wallet far fa-wallet"></i>
                                    @if(userType() == 1)
                                        <div class="mb-4">
                                            <h5 class="text-white mb-2">
                                                @lang('Total Stock Transfer')
                                            </h5>
                                            <h3>
                                                <span class="text-white total_stock_transfer infoShowHide"></span>
                                            </h3>
                                        </div>
                                    @else
                                        <div class="mb-4">
                                            <h5 class="text-white mb-2">
                                                @lang('Total Sales Amount')
                                            </h5>
                                            <h3>
                                                <span class="text-white total_sales_amount infoShowHide"></span>
                                            </h3>
                                        </div>
                                    @endif


                                    <div class="">
                                        <h5 class="text-white mb-2">
                                            @lang('Total Stock Amount')
                                        </h5>
                                        <h3 class="total_stock_amount text-white infoShowHide"></h3>
                                    </div>
                                    @if(userType() == 1)
                                        <a href="{{ route('user.stockTransfer') }}" class="cash-in"> <i
                                                class="fal fa-paper-plane me-1"></i> @lang('Transfer Stock')</a>
                                    @else
                                        <a href="{{ route('user.salesItem') }}" class="cash-in"> <i
                                                class="fal fa-shopping-cart me-1"></i> @lang('Sales Item')</a>
                                    @endif


                                </div>
                            </div>
                        </div>

                        @if(userType() == 1)
                            <div class="col-xl-4 col-lg-6 d-sm-block d-none">
                                <div class="row g-3">
                                    <div class="col-lg-12 col-6 sales-statistics">
                                        <div class="dashboard-box gr-bg-1">
                                            <h5 class="text-white">@lang('Total Raw Item Purchase')</h5>
                                            <h3 class="text-white rawItemPurchaseAmount infoShowHide"></span>
                                            </h3>
                                            <i class="fal fa-usd-circle text-white" aria-hidden="true"></i>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-6 sales-statistics">
                                        <div class="dashboard-box gr-bg-2">
                                            <h5 class="text-white">@lang('Total Sales Amount')</h5>
                                            <h3 class="text-white total_sales_amount infoShowHide"></span>
                                            </h3>
                                            <i class="fal fa-usd-circle text-white"></i>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <div class="col-xl-4 col-lg-6 d-sm-block d-none">
                                <div class="row g-3">
                                    <div class="col-lg-12 col-6 customer-statistics">
                                        <div class="dashboard-box gr-bg-1">
                                            <h5 class="text-white">@lang('Total Customers')</h5>
                                            <h3 class="text-white totalCustomers infoShowHide"></h3>
                                            <i class="fal fa-users text-white"></i>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-6 sales-statistics">
                                        <div class="dashboard-box gr-bg-2">
                                            <h5 class="text-white">@lang('Due Amount')</h5>
                                            <h3 class="text-white customer_due_amount infoShowHide"></span>
                                            </h3>
                                            <i class="fal fa-usd-circle text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-xl-4 d-sm-block d-none">
                            <div class="row g-3">
                                @if(userType() == 1)
                                    <div class="col-xl-12 col-6 raw-item-statistics">
                                        <div class="dashboard-box gr-bg-3">
                                            <h5 class="text-white">@lang('Raw Item Due')</h5>
                                            <h3 class="text-white rawItemDueAmount infoShowHide"></span>
                                            </h3>
                                            <i class="fal fa-hand-holding-usd text-white"></i>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-6 box customer-statistics">
                                        <div class="dashboard-box gr-bg-4">
                                            <h5 class="text-white">@lang('Sales Due Amount')</h5>
                                            <h3 class="text-white customer_due_amount infoShowHide"></span>
                                            </h3>
                                            <i class="fal fa-hand-holding-usd text-white" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xl-12 col-6 item-statistics">
                                        <div class="dashboard-box gr-bg-3">
                                            <h5 class="text-white">@lang('Total Items')</h5>
                                            <h3 class="text-white totalItems infoShowHide"></h3>
                                            <i class="fal fa-list-ol text-white" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-6 box item-statistics">
                                        <div class="dashboard-box gr-bg-4">
                                            <h5 class="text-white">@lang('Stock Out Items')</h5>
                                            <h3 class="text-white stockOutItems infoShowHide"></span>
                                            </h3>
                                            <i class="far fa-times-circle text-white"></i>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main -->
        <div class="container-fluid">
            <div class="main row">
                <div class="col-12">
                    <div class="dashboard-box-wrapper d-none d-lg-block">
                        @if(userType() == 1)
                            <div class="row g-3 mb-4">

                                <div class="col-xl-3 col-md-6 box supplier-statistics">
                                    <div class="dashboard-box">
                                        <h5>@lang('Total Suppliers')</h5>
                                        <h3 class="totalSuppliers infoShowHide"></h3>
                                        <i class="fal fa-people-carry" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box raw-item-statistics">
                                    <div class="dashboard-box">
                                        <h5>@lang('Total Raw Items')</h5>
                                        <h3 class="totalRawItems infoShowHide"></h3>
                                        <i class="fal fa-rectangle-list" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box raw-item-statistics">
                                    <div class="dashboard-box">
                                        <h5>@lang('Stock Out Raw Items')</h5>
                                        <h3 class="outOfStockRawItems infoShowHide"></h3>
                                        <i class="far fa-times-circle" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box raw-item-statistics">
                                    <div class="dashboard-box">
                                        <h5>@lang('Wastage Raw Items')</h5>
                                        <h3 class="wastageRawItemsAmount infoShowHide"></h3>
                                        <i class="far fa-badge-dollar"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box sales-center-statistics">
                                    <div class="dashboard-box">
                                        <h5>@lang('Total Sales Center')</h5>
                                        <h3 class="totalSalesCenter infoShowHide"></h3>
                                        <i class="fal fa-shop" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box item-statistics">
                                    <div class="dashboard-box">
                                        <h5>@lang('Total Items')</h5>
                                        <h3 class="totalItems infoShowHide"></h3>
                                        <i class="fal fa-list-ol" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box item-statistics">
                                    <div class="dashboard-box">
                                        <h5>@lang('Stock Out Items')</h5>
                                        <h3 class="stockOutItems infoShowHide"></h3>
                                        <i class="far fa-times-circle" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box ">
                                    <div class="dashboard-box affiliate-member-statistics">
                                        <h5>@lang('Total Affiliate Member')</h5>
                                        <h3 class="totalAffiliateMember infoShowHide"></h3>
                                        <i class="fal fa-users" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box ">
                                    <div class="dashboard-box affiliate-member-statistics">
                                        <h5>@lang('Affiliate Member Commission')</h5>
                                        <h3 class="affiliateMemberCommission infoShowHide"></h3>
                                        <i class="fal fa-usd-circle" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box ">
                                    <div class="dashboard-box affiliate-member-statistics">
                                        <h5>@lang('Central Promoter Commission')</h5>
                                        <h3 class="centralPromoterCommission infoShowHide"></h3>
                                        <i class="fal fa-usd-circle" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box ">
                                    <div class="dashboard-box affiliate-member-statistics">
                                        <h5>@lang('Total Affiliate Commission')</h5>
                                        <h3 class="totalAffiliateCommission infoShowHide"></h3>
                                        <i class="fal fa-usd-circle" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 box ">
                                    <div class="dashboard-box affiliate-member-statistics">
                                        <h5>@lang('Total Expense')</h5>
                                        <h3 class="totalExpenseAmount infoShowHide"></h3>
                                        <i class="fal fa-usd-circle" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-lg-none mb-4">
                        <div class="card-box-wrapper owl-carousel card-boxes">
                            <div class="dashboard-box gr-bg-1 item-statistics">
                                <h5 class="text-white">@lang('Total Suppliers')</h5>
                                <h3 class="text-white totalSuppliers infoShowHide"></h3>
                                <i class="fal fa-people-carry text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-2 item-statistics">
                                <h5 class="text-white">@lang('Total Raw Items')</h5>
                                <h3 class="text-white totalRawItems infoShowHide"></h3>
                                <i class="fal fa-rectangle-list text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-3 item-statistics">
                                <h5 class="text-white">@lang('Stock Out Raw Items')</h5>
                                <h3 class="text-white outOfStockRawItems infoShowHide"></h3>
                                <i class="far fa-times-circle text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-5 item-statistics">
                                <h5 class="text-white">@lang('Wastage Raw Items')</h5>
                                <h3 class="text-white wastageRawItemsAmount infoShowHide"></h3>
                                <i class="far fa-badge-dollar text-white"></i>
                            </div>

                            <div class="dashboard-box gr-bg-5 item-statistics">
                                <h5 class="text-white">@lang('Total Sales Center')</h5>
                                <h3 class="text-white totalSalesCenter infoShowHide"></h3>
                                <i class="fal fa-shop text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-4 item-statistics">
                                <h5 class="text-white">@lang('Total Items')</h5>
                                <h3 class="text-white totalItems infoShowHide"></h3>
                                <i class="fal fa-list-ol text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-6 item-statistics">
                                <h5 class="text-white">@lang('Stock Out Items')</h5>
                                <h3 class="text-white stockOutItems infoShowHide"></h3>
                                <i class="far fa-times-circle text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-6 item-statistics">
                                <h5 class="text-white">@lang('Total Affiliate Member')</h5>
                                <h3 class="text-white totalAffiliateMember infoShowHide"></h3>
                                <i class="fal fa-users text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-6 item-statistics">
                                <h5 class="text-white">@lang('Affiliate Member Commission')</h5>
                                <h3 class="text-white affiliateMemberCommission infoShowHide"></h3>
                                <i class="fal fa-usd-circle text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-6 item-statistics">
                                <h5 class="text-white">@lang('Central Promoter Commission')</h5>
                                <h3 class="text-white centralPromoterCommission infoShowHide"></h3>
                                <i class="fal fa-usd-circle text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-6 item-statistics">
                                <h5 class="text-white">@lang('Total Affiliate Commission')</h5>
                                <h3 class="text-white totalAffiliateCommission infoShowHide"></h3>
                                <i class="fal fa-usd-circle text-white" aria-hidden="true"></i>
                            </div>

                            <div class="dashboard-box gr-bg-7 item-statistics">
                                <h5 class="text-white">@lang('Total Expense')</h5>
                                <h3 class="text-white totalExpenseAmount infoShowHide"></h3>
                                <i class="fal fa-usd-circle text-white" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main row">
                <div class="col-md-12">
                    <div class="card year-transaction  shadow-sm YearlySalesTransactions infoShowHide">
                        @if(userType() == 1)
                            <div class="card-body">
                                <h5 class="card-title">@lang('Yearly Stock & Sales Transactions')</h5>
                                <div class="yearly-sales-transaction-statistics">
                                    <canvas id="sales-transaction-current-year"></canvas>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <h5 class="card-title">@lang('Yearly Stock & Sales Transactions')</h5>
                                <div class="sales-center-yearly-sales-transaction-statistics">
                                    <canvas id="sales-center-yearly-sales-transaction-statistics"></canvas>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    @else
        <script>window.location = "{{ route(optional(auth()->user()->role)->permission[0]) }}";</script>
    @endif


@endsection

@push('script')
    <script src="{{ asset('assets/global/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>


    <script defer>

        document.addEventListener('DOMContentLoaded', onDocumentLoad);

        $(document).on('click', '.show-hide', function () {
            let data = $(this).data('info'); // Change $('.show-hide') to $(this) to refer to the clicked element

            if (data == 1) {
                $('.infoShowHide').addClass('d-none');
                $(this).find('.showHideEye').removeClass('fal fa-eye').addClass('fal fa-eye-slash'); // Use find() to target elements within $(this)
                $(this).data('info', 0); // Use $(this) to set data-info attribute of the clicked element
            } else {
                $('.infoShowHide').removeClass('d-none');
                $(this).find('.showHideEye').removeClass('fal fa-eye-slash').addClass('fal fa-eye'); // Use find() to target elements within $(this)
                $(this).data('info', 1); // Use $(this) to set data-info attribute of the clicked element
            }
        });


        const userType = "{{ userType() }}";

        function delayProcess(blockClass, svgColor) {
            Notiflix.Block.standard(`.${blockClass}`, {
                backgroundColor: 'rgb(201 200 255 / 20%)',
                svgColor: svgColor,
                messageColor: '#696969',
                messageFontSize: '18px',
                fontFamily: 'Oswald, sans-serif'
            });
        }

        function removeProcess(blockClass) {
            Notiflix.Block.remove(`.${blockClass}`);
        }

        function onDocumentLoad() {
            salesStatRecords();
            itemRecords();
            totalCustomerRecords();
            userType == 1 ? rawItemRecords() : '';
            userType == 1 ? affiliateMemberRecords() : '';
            userType == 1 ? salesCenterRecords() : '';
            userType == 1 ? supplierRecords() : '';
            userType == 1 ? expenseRecords() : '';
            userType == 1 ? getYearSalesTransactionChartRecords() : getSalesCenterYearSalesTransactionChartRecords();
        }

        function getSalesCenterYearSalesTransactionChartRecords() {
            delayProcess('sales-center-yearly-sales-transaction-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getSalesCenterYearSalesTransactionChartRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        Notiflix.Block.remove('.sales-center-yearly-sales-transaction-statistics');
                        let basic = response.basic;
                        let yearSalesCenterSalesTransactionChartRecords = response.data.yearSalesCenterSalesTransactionChartRecords;
                        currentYearSalesCenterSalesTransactionChart(yearSalesCenterSalesTransactionChartRecords);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function currentYearSalesCenterSalesTransactionChart(yearSalesCenterSalesTransactionChartRecords) {
            new Chart(document.getElementById("sales-center-yearly-sales-transaction-statistics"), {
                type: 'bar',
                data: {
                    labels: yearSalesCenterSalesTransactionChartRecords.yearLabels,
                    datasets: [
                        {
                            data: yearSalesCenterSalesTransactionChartRecords.yearTotalStockAmount,
                            label: "Total Stocks",
                            borderColor: "#65B741",
                            backgroundColor: "#65B741",
                        },
                        {
                            data: yearSalesCenterSalesTransactionChartRecords.yearTotalSalesAmount,
                            label: "Total Sales",
                            borderColor: "#CE5A67",
                            backgroundColor: "#CE5A67",
                        },
                        {
                            data: yearSalesCenterSalesTransactionChartRecords.yearTotalDueAmount,
                            label: "Due Sales",
                            borderColor: "#163020",
                            backgroundColor: "#163020",
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    aspectRatio: 1,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }


        function getYearSalesTransactionChartRecords() {
            delayProcess('yearly-sales-transaction-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getYearSalesTransactionChartRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        Notiflix.Block.remove('.yearly-sales-transaction-statistics');
                        let basic = response.basic;
                        let yearSalesTransactionChartRecords = response.data.yearSalesTransactionChartRecords;
                        currentYearSalesTransactionChart(yearSalesTransactionChartRecords);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function currentYearSalesTransactionChart(yearSalesTransactionChartRecords) {
            new Chart(document.getElementById("sales-transaction-current-year"), {
                type: 'bar',
                data: {
                    labels: yearSalesTransactionChartRecords.yearLabels,
                    datasets: [
                        {
                            data: yearSalesTransactionChartRecords.yearTotalStockAmount,
                            label: "Total Stocks",
                            borderColor: "#65B741",
                            backgroundColor: "#65B741",
                        },
                        {
                            data: yearSalesTransactionChartRecords.yearTotalStockTransfer,
                            label: "Transfer Stocks",
                            borderColor: "#0C359E",
                            backgroundColor: "#0C359E",
                        },
                        {
                            data: yearSalesTransactionChartRecords.yearTotalSalesAmount,
                            label: "Total Sales",
                            borderColor: "#CE5A67",
                            backgroundColor: "#CE5A67",
                        },
                        {
                            data: yearSalesTransactionChartRecords.yearTotalDueCustomerAmount,
                            label: "Sales Due",
                            borderColor: "#D63484",
                            backgroundColor: "#D63484",
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    aspectRatio: 1,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }


        function expenseRecords() {
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getExpenseRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        // removeProcess('expense-statistics');
                        let expenseStatRecords = response.data.expenseStatRecords;
                        let currency = response.currency;
                        expenseStatistics(expenseStatRecords, currency);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function expenseStatistics(expenseStatRecords, currency) {
            $('.totalExpenseAmount').text(`${expenseStatRecords.totalExpenseAmount ? parseFloat(expenseStatRecords.totalExpenseAmount).toFixed(2) : 0} ${currency}`);
        }


        function supplierRecords() {
            delayProcess('supplier-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getSupplierRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        removeProcess('supplier-statistics');
                        let supplierStatRecords = response.data.supplierStatRecords;
                        supplierStatistics(supplierStatRecords);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function supplierStatistics(supplierStatRecords) {
            $('.totalSuppliers').text(`${supplierStatRecords.totalSuppliers ? supplierStatRecords.totalSuppliers : 0}`);
        }

        function salesCenterRecords() {
            delayProcess('sales-center-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getSalesCenterRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        removeProcess('sales-center-statistics');
                        let salesCenterStatRecords = response.data.salesCenterStatRecords;
                        salesCenterStatistics(salesCenterStatRecords);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function salesCenterStatistics(salesCenterStatRecords) {
            $('.totalSalesCenter').text(`${salesCenterStatRecords.totalSalesCenter ? salesCenterStatRecords.totalSalesCenter : 0}`);
        }

        function affiliateMemberRecords() {
            delayProcess('affiliate-member-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getAffiliateMemberRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        removeProcess('affiliate-member-statistics');
                        let affiliateMemberStatRecords = response.data.affiliateMemberStatRecords;
                        let currency = response.currency;
                        affiliateMemberStatistics(affiliateMemberStatRecords, currency);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function affiliateMemberStatistics(affiliateMemberStatRecords, currency) {
            $('.totalAffiliateMember').text(`${affiliateMemberStatRecords.totalAffiliateMembers ? affiliateMemberStatRecords.totalAffiliateMembers : 0}`);
            $('.affiliateMemberCommission').text(`${affiliateMemberStatRecords.totalAffiliateMemberCommission ? parseFloat(affiliateMemberStatRecords.totalAffiliateMemberCommission).toFixed(2) : 0} ${currency}`);
            $('.centralPromoterCommission').text(`${affiliateMemberStatRecords.centralPromoterCommission ? parseFloat(affiliateMemberStatRecords.centralPromoterCommission).toFixed(2) : 0} ${currency}`);
            $('.totalAffiliateCommission').text(`${affiliateMemberStatRecords.totalAffiliateCommission ? parseFloat(affiliateMemberStatRecords.totalAffiliateCommission).toFixed(2) : 0} ${currency}`);
        }

        function rawItemRecords() {
            delayProcess('raw-item-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getRawItemRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        removeProcess('raw-item-statistics');
                        let rawItemStatRecords = response.data.rawItemStatRecords;
                        let currency = response.currency;
                        rawItemStatistics(rawItemStatRecords, currency);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function rawItemStatistics(rawItemStatRecords, currency) {
            $('.rawItemPurchaseAmount').text(`${rawItemStatRecords.totalRawItemPurchaseAmount ? parseFloat(rawItemStatRecords.totalRawItemPurchaseAmount).toFixed(2) : 0} ${currency}`);
            $('.rawItemDueAmount').text(`${rawItemStatRecords.totalRawItemDueAmount ? parseFloat(rawItemStatRecords.totalRawItemDueAmount).toFixed(2) : 0} ${currency}`);
            $('.wastageRawItemsAmount').text(`${rawItemStatRecords.totalRawItemWastageAmount ? parseFloat(rawItemStatRecords.totalRawItemWastageAmount).toFixed(2) : 0} ${currency}`);
            $('.outOfStockRawItems').text(`${rawItemStatRecords.totalOutOfStockRawItems ? rawItemStatRecords.totalOutOfStockRawItems : 0}`);
            $('.totalRawItems').text(`${rawItemStatRecords.totalRawItems ? rawItemStatRecords.totalRawItems : 0}`);
        }

        function totalCustomerRecords() {
            delayProcess('customer-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getCustomerRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        removeProcess('customer-statistics');
                        let customerRecords = response.customerRecords;
                        customerStatistics(customerRecords);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function customerStatistics(customerRecords) {
            $('.totalCustomers').text(`${customerRecords.totalCustomers ? customerRecords.totalCustomers : 0}`);
        }

        function salesStatRecords() {
            delayProcess('sales-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getSalesStatRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        removeProcess('sales-statistics');
                        let salesStatRecords = response.data.salesStatRecords;
                        let currency = response.currency;
                        salesStatistics(salesStatRecords, currency);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function salesStatistics(salesStatRecords, currency) {
            $('.total_sales_amount').text(`${salesStatRecords.totalSalesAmount ? parseFloat(salesStatRecords.totalSalesAmount).toFixed(2) : 0} ${currency}`);
            $('.sold_to_sales_centers').text(`${salesStatRecords.soldSalesCenterAmount ? parseFloat(salesStatRecords.soldSalesCenterAmount).toFixed(2) : 0} ${currency}`);
            $('.sold_to_customers').text(`${salesStatRecords.soldCustomerAmount ? parseFloat(salesStatRecords.soldCustomerAmount).toFixed(2) : 0} ${currency}`);
            $('.sales_center_due_amount').text(`${salesStatRecords.dueSalesCenterAmount ? parseFloat(salesStatRecords.dueSalesCenterAmount).toFixed(2) : 0} ${currency}`);
            $('.customer_due_amount').text(`${salesStatRecords.dueCustomerAmount ? parseFloat(salesStatRecords.dueCustomerAmount).toFixed(2) : 0} ${currency}`);
            $('.total_stock_amount').text(`${salesStatRecords.totalStockAmount ? parseFloat(salesStatRecords.totalStockAmount).toFixed(2) : 0} ${currency}`);
            $('.total_stock_transfer').text(`${salesStatRecords.totalStockTransfer ? parseFloat(salesStatRecords.totalStockTransfer).toFixed(2) : 0} ${currency}`);
        }

        function itemRecords() {
            delayProcess('item-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getItemRecords') }}",
                    method: 'GET',
                    success: function (response) {

                        removeProcess('item-statistics');
                        let itemRecords = response.itemRecords;
                        itemStatistics(itemRecords);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function itemStatistics(itemRecords) {
            $('.totalItems').text(`${itemRecords.totalItems ? itemRecords.totalItems : 0}`);
            $('.stockOutItems').text(`${itemRecords.totalOutOfStockItems ? itemRecords.totalOutOfStockItems : 0}`);
        }
    </script>
@endpush
