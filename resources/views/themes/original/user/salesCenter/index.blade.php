@extends($theme.'layouts.user')
@section('title', trans('Sales Center List'))
@section('content')
    @push('style')
        <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap-datepicker.css') }}"/>
    @endpush
    <!-- Invest history -->
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Sales Center List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Sales Center')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">

                        <div class="input-box col-lg-3">
                            <label for="">@lang('Sales Center')</label>
                            <select class="form-control js-example-basic-single" name="sales_center_id" aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                @foreach($centerLists as $centerList)
                                    <option
                                        value="{{ $centerList->id }}" {{ old('sales_center_id', @request()->sales_center_id) == $centerList->id ? 'selected' : '' }}>{{ $centerList->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date">@lang('From Date')</label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="{{ old('from_date',request()->from_date) }}" placeholder="@lang('From date')"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="to_date">@lang('To Date')</label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="{{ old('to_date',request()->to_date) }}" placeholder="@lang('To date')"
                                autocomplete="off" readonly disabled="true"/>
                        </div>
                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <a href="{{route('user.createSalesCenter')}}" class="btn btn-custom text-white "> <i
                        class="fa fa-plus-circle"></i> @lang('Create Center')</a>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('Center Code')</th>
                        <th scope="col">@lang('Center Name')</th>
                        <th scope="col">@lang('Owner')</th>
                        <th scope="col">@lang('Division')</th>
                        <th scope="col">@lang('District')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($centerLists as $key => $centerList)
                        <tr>
                            <td data-label="@lang('Center Code')">{{ $centerList->code }}</td>
                            <td data-label="@lang('Center Name')">{{ $centerList->name }}</td>
                            <td class="company-logo" data-label="@lang('Owner')">
                                <div>
                                    <a href="" target="_blank">
                                        <img
                                            src="{{ getFile(config('location.user.path').optional($centerList->user)->image) }}">
                                    </a>
                                </div>
                                <div>
                                    <a href=""
                                       target="_blank">{{ $centerList->user->name }}</a>
                                    <br>
                                    <span class="text-muted font-14">
                                        <span>{{ optional($centerList->user)->phone }}</span>
                                    </span>
                                </div>
                            </td>
                            <td data-label="@lang('Division')">{{ optional($centerList->division)->name }}</td>
                            <td data-label="@lang('District')">{{ optional($centerList->district)->name }}</td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button
                                        type="button"
                                        class="dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('user.salesCenterDetails', $centerList->id) }}"
                                               class="dropdown-item"> <i class="fal fa-eye"></i> @lang('Details') </a>
                                        </li>

{{--                                        <li>--}}
{{--                                            <a class="dropdown-item btn"--}}
{{--                                               href="{{ route('user.salesCenterEdit', $centerList->id) }}">--}}
{{--                                                <i class="fas fa-edit"></i> @lang('Edit')--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

                                        <li>
                                            <a class="dropdown-item btn deleteCenter"
                                               data-route="{{route('user.deleteSalesCenter', $centerList->id)}}"
                                               data-property="{{ $centerList }}">
                                                <i class="fas fa-trash-alt"></i> @lang('Delete')
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="100%" class="text-danger text-center">{{trans('No Data Found!')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @push('loadModal')
        <!-- Modal -->
        <div class="modal fade" id="deleteCenterModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <div class="modal-content">
                    <div class="modal-header modal-primary modal-header-custom">
                        <h4 class="modal-title">@lang('Delete Confirmation')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="delete-center-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteCenterRoute">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                    class="btn btn-sm btn-custom text-white">@lang('Yes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endsection

@push('script')
    <script src="{{ asset('assets/global/js/bootstrap-datepicker.js') }}"></script>
    <script>
        'use strict'
        $(document).ready(function () {
            $(".datepicker").datepicker({
                autoclose: true,
                clearBtn: true
            });

            $('.from_date').on('change', function () {
                $('.to_date').removeAttr('disabled');
            });

            $(document).on('click', '.deleteCenter', function () {
                var deleteCenterModal = new bootstrap.Modal(document.getElementById('deleteCenterModal'))
                deleteCenterModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.deleteCenterRoute').attr('action', dataRoute)

                $('.delete-center-name').text(`Are you sure to delete ${dataProperty.name}?`)

            });
        });
    </script>
@endpush
