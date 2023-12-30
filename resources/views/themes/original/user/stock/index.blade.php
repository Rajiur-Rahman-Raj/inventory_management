@extends($theme.'layouts.user')
@section('title', trans('Stock List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Stock List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Stock List')</li>
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
                            <label for="">@lang('Items')</label>

                            <select class="form-control js-example-basic-single" name="item_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                @foreach($allItems as $item)
                                    <option value="{{ $item->id }}" {{ @request()->item_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="">@lang('Stocks')</label>
                            <select class="form-control js-example-basic-single" name="stock_check"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                <option value="available_in_stock" {{ @request()->stock_check == 'available_in_stock' ? 'selected' : '' }}>@lang('Available In Stock')</option>
                                <option value="out_of_stock" {{ @request()->stock_check == 'out_of_stock' ? 'selected' : '' }}>@lang('Out Of Stock')</option>
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date">@lang('Last Stock From Date')</label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="{{ old('from_date',request()->from_date) }}" placeholder="@lang('From date')"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="to_date">@lang('Last Stock To Date')</label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="{{ old('to_date',request()->to_date) }}" placeholder="@lang('To date')"
                                autocomplete="off" readonly disabled="true"/>
                        </div>
                        <div class="input-box col-lg-12">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <a href="{{route('user.addStock')}}" class="btn btn-custom text-white "> <i
                        class="fa fa-plus-circle"></i> @lang('Add Stock')</a>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Item Name')</th>
                        <th scope="col">@lang('Quantity')</th>
                        <th scope="col">@lang('Last Cost Per Unit')</th>
                        <th scope="col">@lang('Last Stock Date')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>

                    </thead>
                    <tbody>
                    @forelse($stockLists as $key => $stockList)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($stockLists) + $key}}</td>

                            <td data-label="@lang('Item Name')"> {{ optional($stockList->item)->name }} </td>
                            <td data-label="@lang('Quantity')" class="font-weight-bold">
                                <span
                                    class="badge {{ $stockList->quantity > 0 ? 'bg-info' : 'bg-danger' }}">{{ $stockList->quantity }} </span>
                            </td>
                            <td data-label="@lang('Last Cost Per Unit')"> {{ $stockList->last_cost_per_unit }} {{ $basic->currency_symbol }} </td>
                            <td data-label="@lang('Last Stock Date')"> {{ customDate($stockList->last_stock_date) }} </td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button
                                        type="button"
                                        class="dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            {{--                                            <a href="{{ route('user.stockDetails', $stockList->id) }}"--}}
                                            <a href="{{ route('user.stockDetails', [slug(optional($stockList->item)->name), $stockList->id]) }}"
                                               class="dropdown-item"> <i class="fal fa-eye"></i> @lang('Details') </a>
                                        </li>
                                        {{--                                        <li>--}}
                                        {{--                                            <a class="dropdown-item btn editItem"--}}
                                        {{--                                               data-route="{{route('user.updateItem', $itemList->id)}}"--}}
                                        {{--                                               data-property="{{ $itemList }}">--}}
                                        {{--                                                <i class="fas fa-edit"></i> @lang('Details')--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </li>--}}
                                        {{--                                        <li>--}}
                                        {{--                                            <a class="dropdown-item btn editItem"--}}
                                        {{--                                               data-route="{{route('user.updateItem', $itemList->id)}}"--}}
                                        {{--                                               data-property="{{ $itemList }}">--}}
                                        {{--                                                <i class="fas fa-edit"></i> @lang('Edit')--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </li>--}}

                                        {{--                                        <li>--}}
                                        {{--                                            <a class="dropdown-item btn deleteItem"--}}
                                        {{--                                               data-route="{{route('user.deleteItem', $itemList->id)}}"--}}
                                        {{--                                               data-property="{{ $itemList }}">--}}
                                        {{--                                                <i class="fas fa-trash-alt"></i> @lang('Delete')--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </li>--}}
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
        {{--  Add Item modal --}}
        <div class="modal fade" id="addItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <form action="{{ route('user.itemStore') }}" method="post" class="login-form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">@lang('Add New Item')</h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for="">@lang('Item Name')</label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="form-control @error('name') is-invalid @enderror"
                                                    name="name"
                                                    value="{{old('name')}}"
                                                    placeholder="@lang('Enter Item Name')" required>
                                            </div>
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="">@lang('Unit')</label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="form-control @error('unit') is-invalid @enderror"
                                                    name="unit"
                                                    value="{{old('unit', 'Coil')}}"
                                                    placeholder="@lang('Item Unit')" required>
                                            </div>
                                            @error('unit')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
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

        {{--  Edit Item modal --}}
        <div class="modal fade" id="editItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <form action="" method="post" class="edit-item-form">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">@lang('Edit Item')</h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for="">@lang('Item Name')</label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control @error('name') is-invalid @enderror item-name"
                                                    name="name"
                                                    value="{{old('name')}}"
                                                    placeholder="@lang('Enter Item Name')" required>
                                            </div>
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="">@lang('Unit')</label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control @error('unit') is-invalid @enderror item-unit"
                                                    name="unit"
                                                    value="{{old('unit')}}"
                                                    placeholder="@lang('Item Unit')" required>
                                            </div>
                                            @error('unit')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
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


            $(document).on('click', '.deleteItem', function () {
                var deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'))
                deleteItemModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.deleteItemRoute').attr('action', dataRoute)

                $('.delete-item-name').text(`Are you sure to delete ${dataProperty.name}?`)

            });
        });
    </script>
@endpush
