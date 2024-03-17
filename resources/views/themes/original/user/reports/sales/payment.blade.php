@extends($theme.'layouts.user')
@section('title', trans('Sales Payment Reports'))
@section('content')
    @push('style')
        <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Sales Payment Reports')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">@lang('Sales Payment Reports')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data" class="searchForm">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-3">
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="@lang('From Date')"
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

                        <div class="input-box col-lg-3">
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="@lang('To Date')"
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
                        <div class="input-box col-lg-3">
                            <select class="form-control js-example-basic-single" name="sales_center_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All Center')</option>

                                @foreach($salesCenters as $center)
                                    <option
                                        value="{{ $center->id }}" {{ @request()->sales_center_id == $center->id ? 'selected' : '' }}>{{ $center->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(isset($salesPaymentReportRecords) && count($search) > 0)
                <div class="card card-table">
                    @if(count($salesPaymentReportRecords) > 0)
                        <div
                            class="card-header custom-card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="m-0 text-primary">@lang('All Payments')</h5>

                            <div class="total-price">
                                <ul class="m-0 list-unstyled">
                                    <li class="text-uppercase color-primary font-weight-bold">
                                        <span>@lang('Total Paid') =</span>
                                        <span>{{ $totalPaidAmount }} {{ config('basic.currency_text') }} </span></li>
                                    <li class="text-uppercase color-primary font-weight-bold">
                                        <span>@lang('Total Due') = </span>
                                        <span>{{ $totalDueAmount }} {{ config('basic.currency_text') }} </span></li>
                                </ul>

                            </div>

                            @if(adminAccessRoute(config('permissionList.Manage_Reports.Sales_Payment_Report.permission.export')))
                                <a href="javascript:void(0)" data-route="{{route('user.export.salesPaymentReports')}}"
                                   class="btn btn-custom2 text-white reportsDownload downloadExcel"> <i
                                        class="fa fa-download"></i> @lang('Download Excel File')</a>
                            @endif

                        </div>
                    @endif
                    <ul class="list-style-none p-0 stock_list_style">
                        <div class="table-responsive">
                            <table class="table custom-table table-bordered mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">Sales Center</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col">Due Amount</th>
                                    <th scope="col">Payment Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($salesPaymentReportRecords) > 0)
                                    @foreach($salesPaymentReportRecords as $key1 => $sale)
                                        @foreach($sale->salesPayments as $key2 => $saleDetails)
                                            <tr>
                                                <td data-label="Sales Center">{{ $sale->salesCenter->name }}</td>
                                                <td data-label="Paid Amount">{{ config('basic.currency_symbol') }} {{ $saleDetails->amount }}</td>
                                                <td data-label="Due Amount">{{ config('basic.currency_symbol') }} {{ $saleDetails->due }}</td>
                                                <td data-label="Payment Date">{{ customDate($saleDetails->payment_date) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            <img src="{{ asset('assets/global/img/no_data.gif') }}"
                                                 class="card-img-top empty-state-img" alt="..." style="width: 300px">
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </ul>
                </div>

            @endif
        </div>
    </section>

    @push('loadModal')

    @endpush
@endsection

@push('script')
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>

    <script>
        'use script'
        var serachRoute = "{{route('user.salesPaymentReports')}}"
        $(document).on("click", ".downloadExcel", function () {
            $('.searchForm').attr('action', $(this).data('route'));
            $('.searchForm').submit();
            $('.searchForm').attr('action', serachRoute);
        });

        $(document).ready(function () {
            $(".flatpickr").flatpickr({
                wrap: true,
                altInput: true,
                dateFormat: "Y-m-d H:i",
            });
        });
    </script>
@endpush
