@extends($theme.'layouts.user')
@section('title', trans('Stock Missing Reports'))
@section('content')
    @push('style')
        <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Stock Missing Reports')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">@lang('Stock Missing Reports')</li>
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
                            <select class="form-control js-example-basic-single" name="item_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All Items')</option>
                                @foreach($stockItems as $stockItem)
                                    <option value="{{ optional($stockItem->item)->id }}" {{ @request()->item_id == optional($stockItem->item)->id ? 'selected' : '' }}>{{ optional($stockItem->item)->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')</button>
                        </div>
                    </div>
                </form>
            </div>

            @if(isset($stockMissingReportRecords) && count($search) > 0)
                <div class="card card-table">
                    @if(count($stockMissingReportRecords) > 0)
                        <div
                            class="card-header custom-card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="m-0 text-primary">@lang('All Missing Stocks')</h5>

                            <div class="total-price">
                                <ul class="m-0 list-unstyled">
                                    <li class="text-uppercase  color-primary font-weight-bold mb-1">
                                        <span>@lang('Total Quantity') = </span>
                                        <span>{{ $totalMissing }} </span></li>

                                    <li class="text-uppercase color-primary font-weight-bold">
                                        <span>@lang('Total Amount') =</span>
                                        <span>{{ $totalMissingAmount }} {{ config('basic.currency_text') }}</span></li>
                                </ul>
                            </div>

                            @if(adminAccessRoute(config('permissionList.Manage_Reports.Stock_Missing_Report.permission.export')))
                                <a href="javascript:void(0)" data-route="{{route('user.export.stockMissingReports')}}"
                                   class="btn text-white btn-custom2 reportsDownload downloadExcel"> <i
                                        class="fa fa-download"></i> @lang('Download Excel File')</a>
                            @endif

                        </div>
                    @endif
                    <div class="table-responsive">
                        <ul class="list-style-none p-0 stock_list_style">
                            <table class="table custom-table table-bordered mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Cost Per Unit</th>
                                    <th scope="col">Sub Total</th>
                                    <th scope="col">Date Of Missing</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($stockMissingReportRecords) > 0)
                                    @foreach($stockMissingReportRecords as $key => $stockMissing)
                                        <tr>
                                            <td data-label="Item">{{ optional($stockMissing->item)->name }}</td>
                                            <td data-label="Quantity">{{ $stockMissing->quantity }}</td>
                                            <td data-label="Cost Per Unit">{{ config('basic.currency_symbol') }} {{ $stockMissing->cost_per_unit }}</td>
                                            <td data-label="Sub Total">{{ config('basic.currency_symbol') }} {{ $stockMissing->total_cost }}</td>
                                            <td data-label="Date Of Missing">{{ customDate($stockMissing->missing_date) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            <img
                                                src="{{ asset('assets/global/img/no_data.gif') }}"
                                                class="card-img-top empty-state-img" alt="..." style="width: 300px">
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>

    <script>
        'use script'
        var serachRoute = "{{route('user.stockMissingReports')}}"
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
