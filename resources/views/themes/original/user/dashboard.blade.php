@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
    @push('style')
        <style>
            {{--.balance-box {--}}
            {{--    --}}{{--background: linear-gradient(to right,{{hex2rgba(config('basic.base_color'))}},{{hex2rgba(config('basic.secondary_color'))}});--}}
            {{--   --}}
            {{--}--}}
             .balance-box {
                background: linear-gradient(to right,rgb(73 159 233),rgb(207 115 223));
            }
        </style>
    @endpush
    <!-- Balance Box -->
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card-box balance-box p-0 h-100 sales-statistics">
                            <div class="user-account-number p-4 h-100">
                                <i class="account-wallet far fa-wallet"></i>
                                <div class="mb-4">
                                    <h5 class="text-white mb-2">
                                        @lang('Total Sales Amount')
                                    </h5>
                                    <h3>
                                        <span class="text-white total_sales_amount"></span>
                                    </h3>
{{--                                    <div class="card-footer">--}}
                                        <p class="mb-0"><span class="text-sm font-weight-normal userCurrentYearClass text-danger"><i class="userCurrentYearArrowIcon fal fa-arrow-down"></i><span class="userCurrentYearPercentage"> 87.5%</span></span> than previous year	</p>
{{--                                    </div>--}}
                                </div>
                                <div class="">
                                    <h5 class="text-white mb-2">
                                        @lang('Total Profit Amount')
                                    </h5>
                                    <h3>
                                        <span class="text-white total_profit_amount"><small><sup class="currency_symbol"></sup></small></span>
                                    </h3>
                                    <p class="mb-0"><span class="text-sm font-weight-normal userCurrentYearClass text-success"><i class="userCurrentYearArrowIcon fal fa-arrow-up"></i><span class="userCurrentYearPercentage"> 87.5%</span></span> than previous year</p>
                                </div>
                                <a href="#" class="cash-in"> <i class="fal fa-shopping-cart me-1"></i> @lang('Sales Item')</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 d-sm-block d-none">
                        <div class="row g-3">
                            <div class="col-lg-12 col-6 sales-statistics">
                                <div class="dashboard-box gr-bg-1">
                                    <h5 class="text-white">@lang('Sold To Sales Centers')</h5>
                                    <h3 class="text-white sold_to_sales_centers"></span>
                                    </h3>
                                    <i class="fal fa-file-invoice-dollar text-white"></i>
                                </div>
                            </div>

                            <div class="col-lg-12 col-6 sales-statistics">
                                <div class="dashboard-box gr-bg-2">
                                    <h5 class="text-white">@lang('Sold To Customers')</h5>
                                    <h3 class="text-white sold_to_customers"></span>
                                    </h3>
                                    <i class="fal fa-usd-circle text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 d-sm-block d-none">
                        <div class="row g-3">
                            <div class="col-xl-12 col-6 sales-statistics">
                                <div class="dashboard-box gr-bg-3">
                                    <h5 class="text-white">@lang('Sales Centers Due Amount')</h5>
                                    <h3 class="text-white sales_center_due_amount"></span>
                                    </h3>
                                    <i class="far fa-funnel-dollar text-white"></i>
                                </div>
                            </div>
                            <div class="col-xl-12 col-6 box sales-statistics">
                                <div class="dashboard-box gr-bg-4">
                                    <h5 class="text-white">@lang('Customers Due Amount')</h5>
                                    <h3 class="text-white customer_due_amount"></span>
                                    </h3>
                                    <i class="far fa-funnel-dollar text-white"></i>
                                </div>
                            </div>
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
                    <div class="row g-3 mb-4">
                        <div class="col-xl-3 col-md-6 box item-statistics">
                            <div class="dashboard-box">
                                <h5>@lang('Total Items')</h5>
                                <h3 class="totalInvestment"></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box item-statistics">
                            <div class="dashboard-box">
                                <h5>@lang('Stock Out Items')</h5>
                                <h3 class="runningInvestment"></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box block-statistics">
                            <div class="dashboard-box">
                                <h5>@lang('Total Customers')</h5>
                                <h3 class="dueInvestment"></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box block-statistics">
                            <div class="dashboard-box">
                                <h5>@lang('Total Expense')</h5>
                                <h3 class="completedInvestment">{{ $investment['completedInvestment'] }}</h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5>@lang('Raw Item Purchase')</h5>
                                <h3>
                                    <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($depositBonus + $investBonus + $profitBonus)}}
                                </h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5>@lang('Wastage Raw Items')</h5>
                                <h3>
                                    <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small><span>{{ getAmount($lastBonus) }}</span>
                                </h3>
                                <i class="far fa-badge-dollar"></i>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5>@lang('Due Amount Supplier')</h5>
                                <h3>
                                    <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small><span>{{getAmount($totalInterestProfit, config('basic.fraction_number'))}}</span>
                                </h3>
                                <i class="far fa-hand-holding-usd"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5>@lang('Total Affiliate Member')</h5>
                                <h3>{{$ticket}}</h3>
                                <i class="fal fa-ticket"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-lg-none mb-4">
                    <div class="card-box-wrapper owl-carousel card-boxes">
                        <div class="dashboard-box gr-bg-1">
                            <h5 class="text-white">@lang('Total Sales Amount')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($walletBalance, config('basic.fraction_number'))}}
                            </h3>
                            <i class="fal fa-funnel-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-2">
                            <h5 class="text-white">@lang('Interest Balance')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($interestBalance, config('basic.fraction_number'))}}
                            </h3>
                            <i class="fal fa-hand-holding-usd text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-3">
                            <h5 class="text-white">@lang('Total Deposit')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($totalDeposit, config('basic.fraction_number'))}}
                            </h3>
                            <i class="fal fa-box-usd text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-5">
                            <h5 class="text-white">@lang('Total Invest')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($investment['totalInvestAmount'])}}
                            </h3>
                            <i class="fal fa-search-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-5">
                            <h5 class="text-white">@lang('Running Invest')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($investment['runningInvestAmount'])}}
                            </h3>
                            <i class="fal fa-search-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-4">
                            <h5 class="text-white">@lang('Total Earn')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($totalInterestProfit, config('basic.fraction_number'))}}
                            </h3>
                            <i class="fal fa-badge-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-6">
                            <h5 class="text-white">@lang('Total Payout')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($totalPayout)}}
                            </h3>
                            <i class="fal fa-usd-circle text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-7">
                            <h5 class="text-white">@lang('Total Referral Bonus')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($depositBonus + $investBonus)}}
                            </h3>
                            <i class="fal fa-lightbulb-dollar text-white"></i>
                        </div>

                        <div class="dashboard-box gr-bg-8">
                            <h5 class="text-white">@lang('Last Referral Bonus')</h5>
                            <h3 class="text-white">
                                <small><sup>{{trans(config('basic.currency_symbol'))}}</sup></small>{{getAmount($lastBonus, config('basic.fraction_number'))}}
                            </h3>
                            <i class="fal fa-box-open text-white"></i>
                        </div>

                        <div class="dashboard-box gr-bg-9">
                            <h5 class="text-white">@lang('Total Ticket')</h5>
                            <h3 class="text-white">{{$ticket}}</h3>
                            <i class="fal fa-ticket text-white"></i>
                        </div>
                    </div>
                </div>

                <!---- charts ----->
                <div class="chart-information d-none d-lg-block">
                    <div class="row justify-content-center">
                        <div class="row">
                            <div class="col-lg-12 mb-4 mb-lg-0">
                                <div class="progress-wrapper">
                                    <div id="container" class="apexcharts-canvas"></div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset($themeTrue.'js/apexcharts.js')}}"></script>


    <script defer>

        document.addEventListener('DOMContentLoaded', onDocumentLoad);

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
            $('.total_sales_amount').text(parseFloat(salesStatRecords.totalSalesAmount).toFixed(2) + ` ${currency}`);
            $('.sold_to_sales_centers').text(parseFloat(salesStatRecords.soldSalesCenterAmount).toFixed(2) + ` ${currency}`);
            $('.sold_to_customers').text(parseFloat(salesStatRecords.soldCustomerAmount).toFixed(2) + ` ${currency}`);
            $('.sales_center_due_amount').text(parseFloat(salesStatRecords.dueSalesCenterAmount).toFixed(2) + ` ${currency}`);
            $('.customer_due_amount').text(parseFloat(salesStatRecords.dueCustomerAmount).toFixed(2) + ` ${currency}`);
        }

        function itemRecords(){
            delayProcess('item-statistics', '#000000');
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('user.getItemRecords') }}",
                    method: 'GET',
                    success: function (response) {
                        console.log(response)
                        return 0;
                        removeProcess('item-statistics');
                        let salesStatRecords = response.data.salesStatRecords;
                        console.log(salesStatRecords);
                        let currency = response.currency;
                        itemStatistics(salesStatRecords, currency);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            }, 1000)
        }

        function itemStatistics(salesStatRecords, currency) {
            $('.total_sales_amount').text(parseFloat(salesStatRecords.totalSalesAmount).toFixed(2) + ` ${currency}`);
            $('.sold_to_sales_centers').text(parseFloat(salesStatRecords.soldSalesCenterAmount).toFixed(2) + ` ${currency}`);
            $('.sold_to_customers').text(parseFloat(salesStatRecords.soldCustomerAmount).toFixed(2) + ` ${currency}`);
            $('.sales_center_due_amount').text(parseFloat(salesStatRecords.dueSalesCenterAmount).toFixed(2) + ` ${currency}`);
            $('.customer_due_amount').text(parseFloat(salesStatRecords.dueCustomerAmount).toFixed(2) + ` ${currency}`);
        }





    </script>

    <script>
        "use strict";
        var options = {
            theme: {
                mode: "light",
            },

            series: [
                {
                    name: "{{trans('Deposit')}}",
                    color: 'rgba(255, 72, 0, 1)',
                    data: {!! $monthly['funding']->flatten() !!}
                },
                {
                    name: "{{trans('Deposit Bonus')}}",
                    color: 'rgba(39, 144, 195, 1)',
                    data: {!! $monthly['referralFundBonus']->flatten() !!}
                },
                {
                    name: "{{trans('Investment')}}",
                    color: 'rgba(247, 147, 26, 1)',
                    data: {!! $monthly['investment']->flatten() !!}
                },
                {
                    name: "{{trans('Investment Bonus')}}",
                    color: 'rgba(136, 203, 245, 1)',
                    data: {!! $monthly['referralInvestBonus']->flatten() !!}
                },
                {
                    name: "{{trans('Profit')}}",
                    color: 'rgba(247, 147, 26, 1)',
                    data: {!! $monthly['monthlyGaveProfit']->flatten() !!}
                },
                {
                    name: "{{trans('Payout')}}",
                    color: 'rgba(240, 16, 16, 1)',
                    data: {!! $monthly['payout']->flatten() !!}
                },
            ],
            chart: {
                type: 'bar',
                height: 350,
                background: '#fff',
                toolbar: {
                    show: false
                }

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! $monthly['investment']->keys() !!},

            },
            yaxis: {
                title: {
                    text: ""
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                colors: ['#000'],
                y: {
                    formatter: function (val) {
                        return "{{trans($basic->currency_symbol)}}" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#container"), options);
        chart.render();

        $(document).on('click', '#details', function () {
            var title = $(this).data('servicetitle');
            var description = $(this).data('description');
            $('#title').text(title);
            $('#servicedescription').text(description);
        });

        $(document).ready(function () {
            let isActiveCronNotification = '{{ $basic->is_active_cron_notification }}';
            if (isActiveCronNotification == 1)
                $('#cron-info').modal('show');
            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).parents('.input-group-append').siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });


            $(document).on('click', '.loginAccount', function () {
                var route = $(this).data('route');
                $('.loginAccountAction').attr('action', route)
            });

            $(document).on('click', '.copyReferalLink', function () {
                var _this = $(this)[0];
                var copyText = $(this).siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Copied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fal fa-copy"></i>');
                }, 500)
            });
        })
    </script>

@endpush
