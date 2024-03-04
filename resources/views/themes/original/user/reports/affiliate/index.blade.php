@extends($theme.'layouts.user')
@section('title', trans('Affiliate Commission Report'))
@section('content')
    @push('style')
        <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Affiliate Commission Report')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">@lang('Affiliate Commission Report')</li>
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
                            <select class="form-control js-example-basic-single" name="central_promoter_id"
                                    aria-label="Default select example">
                                @foreach($centralPromoter as $promoter)
                                    <option
                                        value="{{ $promoter->id }}" {{ @request()->central_promoter_id == $promoter->id ? 'selected' : '' }}>{{ kebab2Title($promoter->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <select class="form-control js-example-basic-single" name="affiliate_member_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All Members')</option>
                                @foreach($affiliateMembers as $member)
                                    <option
                                        value="{{ $member->id }}" {{ @request()->affiliate_member_id == $member->id ? 'selected' : '' }}>{{ $member->member_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-12">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(isset($affiliateReportRecords) && count($search) > 0)
                <div class="card card-table">
                    @if(count($affiliateReportRecords) > 0)
                        <div
                            class="card-header custom-card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="m-0 text-primary">@lang('All Affiliate Commissions')</h5>

                            <div class="total-price">
                                <ul class="m-0 list-unstyled">
                                    <li class="text-uppercase color-primary font-weight-bold">
                                        <span>@lang('Total Commission') =</span>
                                        <span>{{ $totalCommission }} {{ config('basic.currency_text') }} </span></li>
                                </ul>

                            </div>

                            <a href="javascript:void(0)" data-route="{{route('user.export.affiliateReports')}}"
                               class="btn text-white btn-custom2 reportsDownload downloadExcel"> <i
                                    class="fa fa-download"></i> @lang('Download Excel File')</a>

                        </div>
                    @endif
                    <ul class="list-style-none p-0 stock_list_style">
                        <div class="table-responsive">
                            <table class="table custom-table table-bordered mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">Affiliator</th>
                                    <th scope="col">Commission</th>
                                    <th scope="col">Date Of Commission</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($affiliateReportRecords) > 0)
                                    @foreach($affiliateReportRecords as $key => $commission)
                                        <tr>
                                            <td data-label="Affiliator">
                                                {{ $key == 0 ? $commission->centralPromoter->name : $commission->affiliateMember->member_name }}
                                            </td>
                                            <td data-label="Commission">{{ $commission->amount }}</td>
                                            <td data-label="Date Of Commission">{{ $commission->commission_date }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            <img
                                                src="http://127.0.0.1/inventory_management/project/assets/global/img/no_data.gif"
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
        var serachRoute = "{{route('user.affiliateReports')}}"
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
