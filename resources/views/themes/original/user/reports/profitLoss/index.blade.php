@extends($theme.'layouts.user')
@section('title', trans('Profit Loss Reports'))
@section('content')
    @push('style')
        <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <!-- Invest history -->
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Profit Loss Reports')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Reports')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data" class="searchForm">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-4">
                            <label for="from_date">@lang('From Date')</label>

                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="@lang('Select date')"
                                           class="form-control from_date"
                                           name="from_date"
                                           value="{{ old('from_date',request()->from_date) }}"
                                           data-input>
                                    <div class="input-group-append" readonly="">
                                        <div class="form-control">
                                            <a class="input-button cursor-pointer"
                                               title="clear" data-clear>
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block">
                                        @error('from_date') @lang($message) @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="input-box col-lg-4">
                            <label for="to_date">@lang('To Date')</label>

                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="@lang('Select date')"
                                           class="form-control to_date"
                                           name="to_date"
                                           value="{{ old('to_date',request()->to_date) }}"
                                           data-input>
                                    <div class="input-group-append" readonly="">
                                        <div class="form-control">
                                            <a class="input-button cursor-pointer"
                                               title="clear" data-clear>
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block">
                                        @error('to_date') @lang($message) @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-box col-lg-4">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(adminAccessRoute(config('permissionList.Manage_Reports.Profit_And_Loss_Report.permission.export')))
                @if(isset($profitLossReportRecords) && count($search) > 0)
                    <div class="d-flex justify-content-end mb-4">
                        <a href="javascript:void(0)" data-route="{{route('user.export.profitLossReports')}}"
                           class="btn btn-custom text-white reportsDownload downloadExcel"> <i
                                class="fa fa-download"></i> @lang('Download Excel')</a>
                    </div>
                @endif
            @endif

            @if(isset($profitLossReportRecords) && count($search) > 0)
                <div class="report-box">
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th class="bg-white">
                                <h5 class="text-primary">@lang('Reports Summery')</h5>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>@lang('Total Purchase')</td>
                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalPurchase'], false) }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Total Purchase Due')</td>
                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalPurchaseDue'], false) }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Total Stock')</td>
                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalStocks'], false) }} </td>
                        </tr>

                        <tr>
                            <td>@lang('Total Stock Transfer')</td>
                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalStockTransfer'], false) }} </td>
                        </tr>

                        @if(userType() == 1)
                            <tr>
                                <td>@lang('Total Sales')</td>
                                <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalSales'], false) }} </td>
                            </tr>

                            <tr>
                                <td>@lang('Total Sales Due')</td>
                                <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalSalesDue'], false) }} </td>
                            </tr>

                            <tr>
                                <td>@lang('Total Wastage')</td>
                                <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalWastage'], false) }} </td>
                            </tr>

                            <tr>
                                <td>@lang('Total Stock Missing')</td>
                                <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalStockMissing'], false) }} </td>
                            </tr>

                            <tr>
                                <td>@lang('Total Affiliate Commission')</td>
                                <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalAffiliateCommission'], false) }} </td>
                            </tr>
                        @endif

                        <tr>
                            <td>@lang('Total Expense')</td>
                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalExpense'], false) }} </td>
                        </tr>

                        <tr>
                            <td>@lang('Total Salary')</td>
                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['totalSalary'], false) }} </td>
                        </tr>

                        <tr>
                            <td>@lang('Revenue')</td>
                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['revenue'], false) }} </td>
                        </tr>

                        <tr>
                            <td>@lang('Net Profit')</td>
                            <td class="{{ $profitLossReportRecords['netProfit'] < 0 ? 'text-danger' : 'text-success' }}">
                                {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['netProfit'], false) }}
                            </td>
                        </tr>


                        {{--                        <tr>--}}
                        {{--                            <td>@lang('Sales profit')</td>--}}
                        {{--                            <td> {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['salesProfit'], false) }} </td>--}}
                        {{--                        </tr>--}}

                        {{--                        <tr>--}}
                        {{--                            <td>@lang('Net profit')</td>--}}
                        {{--                            <td class="{{ $profitLossReportRecords['netProfit'] < 0 ? 'text-danger' : 'text-success' }}">--}}
                        {{--                                {{ config('basic.currency_text') }} {{ fractionNumber($profitLossReportRecords['netProfit'], false) }}--}}
                        {{--                            </td>--}}
                        {{--                        </tr>--}}

                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>

    @push('loadModal')

    @endpush
@endsection

@push('script')
    {{--    <script src="{{ asset('assets/global/js/bootstrap-datepicker.js') }}"></script>--}}
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>

    <script>
        'use script'

        var serachRoute = "{{route('user.profitLossReports')}}"
        $(document).on("click", ".downloadExcel", function () {
            $('.searchForm').attr('action', $(this).data('route'));
            $('.searchForm').submit();
            $('.searchForm').attr('action', serachRoute);
        });

        $(document).ready(function () {
            // $(".datepicker").datepicker({
            //     autoclose: true,
            //     clearBtn: true
            // });

            $(".flatpickr").flatpickr({
                wrap: true,
                altInput: true,
                dateFormat: "Y-m-d H:i",
            });

            // $('.from_date').on('change', function () {
            //     $('.to_date').removeAttr('disabled');
            // });
        });
    </script>
@endpush
