@extends($theme.'layouts.user')
@section('title', trans('Sales List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Sales List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Sales List')</li>
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
                            <select
                                class="form-select js-example-basic-single select-sales-center salesCenterId"
                                name="sales_center_id"
                                aria-label="Default select example">
                                <option value="all">@lang('All')</option>
                                @foreach($salesCenters as $saleCenter)
                                    <option
                                        value="{{ $saleCenter->id }}" {{ old('sales_center_id', @request()->sales_center_id) == $saleCenter->id ? 'selected' : ''}}> @lang($saleCenter->name)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="from_date">@lang('Sales From Date')</label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="{{ old('from_date',request()->from_date) }}" placeholder="@lang('From date')"
                                autocomplete="off" readonly/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="to_date">@lang('Sales To Date')</label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="{{ old('to_date',request()->to_date) }}" placeholder="@lang('To date')"
                                autocomplete="off" readonly disabled="true"/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="">@lang('Payment Status')</label>
                            <select
                                class="form-select js-example-basic-single select-sales-center salesCenterId"
                                name="status"
                                aria-label="Default select example">
                                <option value="all">@lang('All')</option>
                                <option value="1" {{ old('status', @request()->status) == '1' ? 'selected' : ''}}> Paid </option>
                                <option value="0" {{ old('status', @request()->status) == '0' ? 'selected' : ''}}> Due </option>
                            </select>
                        </div>
                        <div class="input-box col-lg-2">
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
                        <th scope="col">@lang('Sales Center')</th>
                        <th scope="col">@lang('Total Amount')</th>
                        <th scope="col">@lang('Sales Date')</th>
                        <th scope="col">@lang('Last Payment Date')</th>
                        <th scope="col">@lang('Payment Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($salesLists as $key => $salesList)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($salesLists) + $key}}</td>
                            <td data-label="@lang('Sales Center')"> {{ optional($salesList->salesCenter)->name }} </td>
                            <td data-label="@lang('Total Amount')"
                                class="font-weight-bold">  {{ $salesList->total_amount }} {{ $basic->currency_symbol }}</td>
                            <td data-label="@lang('Sales Date')"> {{ customDate($salesList->created_at) }} </td>
                            <td data-label="@lang('Last Payment Date')"> {{ customDate($salesList->payment_date) }} </td>
                            <td data-label="@lang('Payment Status')">
                                @if($salesList->payment_status == 1)
                                    <span class="badge bg-success">@lang('Paid')</span>
                                @else
                                    <span class="badge bg-warning">@lang('Due')</span>
                                @endif
                            </td>

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
                                            <a href="{{ route('user.salesInvoice', $salesList->id) }}"
                                               class="dropdown-item"> <i
                                                    class="fal fa-file-invoice"></i> @lang('Invoice') </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('user.salesDetails', $salesList->id) }}"
                                               class="dropdown-item"> <i class="fal fa-eye"></i> @lang('Details') </a>
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
