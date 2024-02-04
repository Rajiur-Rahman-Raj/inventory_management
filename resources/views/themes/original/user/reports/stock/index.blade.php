@extends($theme.'layouts.user')
@section('title', trans('Stock Reports'))
@section('content')
    @push('style')
        <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Stock Reports')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Stock Reports')</li>
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
            @if(isset($stockReportRecords) && count($stockReportRecords) > 0 && count($search) > 0)
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" data-route="{{route('user.export.stockReports')}}"
                       class="btn btn-custom text-white reportsDownload downloadExcel"> <i
                            class="fa fa-download"></i> @lang('Download Excel')</a>
                </div>
            @endif

            @if(isset($stockReportRecords) && count($search) > 0)
                <ul class="list-style-none p-0 stock_list_style">
                    <table class="table table-bordered mt-4">
                        <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Cost Per Unit</th>
                            <th scope="col">Stock Date</th>
                            <th scope="col">Sub Total</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(count($stockReportRecords) > 0)
                            @foreach($stockReportRecords as $key1 => $stockIn)
                                @foreach($stockIn->stockInDetails as $key2 => $stockInDetail)
                                    <tr>
                                        <td data-label="Item">{{ $stockInDetail->item->name }}</td>
                                        <td data-label="Quantity">{{ $stockInDetail->quantity }}</td>
                                        <td data-label="Cost Per Unit">{{ $stockInDetail->cost_per_unit }} {{ config('basic.currency_symbol') }}</td>
                                        <td data-label="Stock Date"> {{ customDate($stockInDetail->stock_date) }} </td>
                                        <td data-label="Sub Total">{{ $stockInDetail->total_unit_cost }} {{ config('basic.currency_symbol') }}</td>
                                    </tr>
                                @endforeach
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
                        @if(count($stockReportRecords) > 0)
                            <tr>
                                <td colspan="4" class="text-end">@lang('Total Cost')</td>
                                <td >= {{ $totalStockCost }} {{ config('basic.currency_symbol') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </ul>
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
        var serachRoute = "{{route('user.stockReports')}}"
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
