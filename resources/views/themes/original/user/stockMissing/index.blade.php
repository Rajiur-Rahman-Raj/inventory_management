@extends($theme.'layouts.user')
@section('title', trans('Stock Missing List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Stock Missing List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Stock Missing List')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-6">
                            <label for="">@lang('items')</label>
                            <select class="form-control js-example-basic-single" name="item_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                @foreach($stockItems as $stockItem)
                                    <option value="{{ optional($stockItem->item)->id }}" {{ @request()->item_id == optional($stockItem->item)->id ? 'selected' : '' }}>{{ optional($stockItem->item)->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-box col-lg-6">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(adminAccessRoute(config('permissionList.Manage_Stock_Missing.Stock_Missing.permission.add')))
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" class="btn btn-custom text-white addMissingStock"> <i class="fa fa-plus-circle"></i> @lang('Add Missing Stock')</a>
                </div>
            @endif

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Item')</th>
                        <th scope="col">@lang('Quantity')</th>
                        <th scope="col">@lang('Missing Date')</th>
                        @if(adminAccessRoute(config('permissionList.Manage_Stock_Missing.Stock_Missing.permission.delete')))
                            <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>

                    </thead>
                    <tbody>
                    @forelse($stockMissingLists as $key => $missingList)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($stockMissingLists) + $key}}</td>

                            <td data-label="@lang('Image')">
                                <div class="d-flex gap-2">
                                    <div class="logo-brand">
                                        <img
                                            src="{{ getFile(optional($missingList->item)->driver, optional($missingList->item)->image) }}"
                                            alt="">
                                    </div>
                                    <div class="product-summary">
                                        <p class="font-weight-bold mt-3">{{ optional($missingList->item)->name }}</p>
                                    </div>
                                </div>
                            </td>

                            <td data-label="@lang('Quantity')">{{ $missingList->quantity }}</td>
                            <td data-label="@lang('Date')">{{ customDate($missingList->missing_date) }}</td>

                            @if(adminAccessRoute(config('permissionList.Manage_Stock_Missing.Stock_Missing.permission.delete')))
                                <td data-label="Action" class="action d-flex justify-content-center">
                                    <button class="action-btn deleteItem"
                                            data-route="{{route('user.stockMissingDelete', $missingList->id)}}">
                                        <i class="fa fa-trash font-14" aria-hidden="true"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="100%" class="text-danger text-center">{{trans('No Data Found!')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $stockMissingLists->appends($_GET)->links($theme.'partials.pagination') }}
            </div>
        </div>
    </section>

    @push('loadModal')
        {{--  Add Wastage modal --}}
        <div class="modal fade" id="addMissingStockModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="{{ route('user.stockMissingStore') }}" method="post" class="login-form"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">@lang('Add Missing Stock Item')</h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold"></div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for="">@lang('items')</label>
                                            <select
                                                class="form-select selectedRawItem @error('item_id') is-invalid @enderror"
                                                name="item_id"
                                                aria-label="Default select example">
                                                <option  selected disabled>@lang('Select Raw Item')</option>
                                                @foreach($stockItems as $stockItem)
                                                    <option value="{{ optional($stockItem->item)->id }}">{{ optional($stockItem->item)->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('item_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12 m-0 mt-3">
                                            <label for="">@lang('Quantity')</label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    name="quantity"
                                                    value="{{old('quantity')}}"
                                                    placeholder="@lang('missing quantity')">
                                                <div class="input-group-append" readonly="">
                                                    <div
                                                        class="form-control currency_symbol append_group raw_item_unit"></div>
                                                </div>
                                            </div>
                                            @error('quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flatpickr">
                                            <label for="missing_date">@lang('Missing Date')</label>
                                            <div class="input-group">
                                                <input type="date"
                                                       placeholder="@lang('Missing Date')"
                                                       class="form-control missing_date @error('missing_date') is-invalid @enderror"
                                                       name="missing_date"
                                                       value="{{ old('missing_date',request()->missing_date) }}"
                                                       data-input>
                                                <div class="input-group-append"
                                                     readonly="">
                                                    <div
                                                        class="form-control payment-date-times">
                                                        <a class="input-button cursor-pointer"
                                                           title="clear" data-clear>
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback d-block">
                                                    @error('missing_date') @lang($message) @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn-custom">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--Delete Item Modal -->
        <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-item-name">@lang('Are you sure delete missing stock?')</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteItemRoute">
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
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
    @include($theme.'user.partials.getItemUnit')

    @if($errors->has('missing_date') || $errors->has('item_id') || $errors->has('quantity'))
        <script>
            var myModal = new bootstrap.Modal(document.getElementById("addWastageModal"), {});
            document.onreadystatechange = function () {
                myModal.show();
            };

        </script>
    @endif


    <script>
        'use strict'

        $(".flatpickr").flatpickr({
            wrap: true,
            maxDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

        $(document).ready(function () {

            $(document).on('click', '.addMissingStock', function () {
                var addMissingStockModal = new bootstrap.Modal(document.getElementById('addMissingStockModal'))
                addMissingStockModal.show();
            });

            $(document).on('click', '.deleteItem', function () {
                var deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'))
                deleteItemModal.show();

                let dataRoute = $(this).data('route');
                console.log(dataRoute);
                let dataProperty = $(this).data('property');

                $('.deleteItemRoute').attr('action', dataRoute)

            });
        });
    </script>
@endpush
