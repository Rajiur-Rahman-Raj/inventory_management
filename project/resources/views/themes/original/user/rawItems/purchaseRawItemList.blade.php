@extends($theme.'layouts.user')
@section('title', trans('Purchase Item List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Purchased Item List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Purchased List')</li>
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
                            <label for="">@lang('Suppliers')</label>
                            <select class="form-control js-example-basic-single" name="supplier_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                @foreach($suppliers as $supplier)
                                    <option
                                        value="{{ $supplier->id }}" {{ @request()->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date">@lang('Purchased From Date')</label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="{{ old('from_date',request()->from_date) }}" placeholder="@lang('From date')"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="to_date">@lang('Purchased To Date')</label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="{{ old('to_date',request()->to_date) }}" placeholder="@lang('To date')"
                                autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="">@lang('Payment Status')</label>
                            <select class="form-control js-example-basic-single" name="payment_status"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                <option value="paid" {{ @request()->payment_status == 'paid' ? 'selected' : '' }}>@lang('Paid')</option>
                                <option value="due" {{ @request()->payment_status == 'due' ? 'selected' : '' }}>@lang('Due')</option>
                            </select>
                        </div>

                        <div class="input-box col-lg-12">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <a href="{{route('user.purchaseRawItem')}}" class="btn btn-custom text-white"> <i
                        class="fa fa-plus-circle"></i> @lang('Purchase')</a>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">@lang('SL')</th>
                            <th scope="col">@lang('Supplier')</th>
                            <th scope="col">@lang('Total Price')</th>
                            <th scope="col">@lang('Purchase Date')</th>
                            <th scope="col">@lang('Payment Status')</th>
                            <th scope="col" class="text-center">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($purchasedItems as $key => $purchaseItem)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($purchasedItems) + $key}}</td>
                            <td data-label="@lang('Supplier')"> {{ optional($purchaseItem->supplier)->name }} </td>
                            <td data-label="@lang('Total Price')"> {{ getAmount($purchaseItem->total_price) }} {{ $basic->currency_symbol }} </td>
                            <td data-label="@lang('Purchased Date')"> {{ customDate($purchaseItem->purchase_date) }} </td>
                            <td data-label="@lang('Payment Status')">
                                @if($purchaseItem->payment_status == 1)
                                    <span class="badge bg-success">@lang('Paid')</span>
                                @else
                                    <span class="badge bg-warning">@lang('Due')</span>
                                @endif
                            </td>


                            <td data-label="Action" class="action d-flex justify-content-center">
                                <a class="action-btn" href="{{ route('user.rawItemPurchaseDetails', $purchaseItem->id) }}">
                                    <i class="fa fa-eye font-14" aria-hidden="true"></i>
                                </a>
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
                        <span class="delete-item-name"></span>
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


            $(document).on('click', '.addNewItem', function () {
                var addItemModal = new bootstrap.Modal(document.getElementById('addItemModal'))
                addItemModal.show();
            });

            $(document).on('click', '.editItem', function () {
                var editItemModal = new bootstrap.Modal(document.getElementById('editItemModal'))
                editItemModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.edit-item-form').attr('action', dataRoute);

                $('.item-name').val(dataProperty.name);
                $('.item-unit').val(dataProperty.unit);
            });


            $(document).on('click', '.deletePurchaseRawItem', function () {
                var deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'))
                deleteItemModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');
                console.log(dataProperty);
                $('.deleteItemRoute').attr('action', dataRoute)
                $('.delete-item-name').text(`Are you sure to delete ${dataProperty.raw_item.name}?`)
            });
        });
    </script>
@endpush
