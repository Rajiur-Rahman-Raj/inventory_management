@extends($theme.'layouts.user')
@section('title',trans('Stock Transfer'))
@push('style')
    <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Stock Transfer')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">@lang('Stock Transfer')</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{route('user.stockList')}}"
                               class="btn btn-custom text-white create__ticket">
                                <i class="fas fa-backward"></i> @lang('Back')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <!-- profile setting -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-12">
                            <div id="tab1" class="content active">
                                <form action="{{ route('user.storeStockTransfer')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="supplier_id">@lang('Select Sales Center')</label>
                                            <select
                                                class="form-select js-example-basic-single @error('sales_center_id') is-invalid @enderror selectSalesCenter"
                                                name="sales_center_id"
                                                aria-label="Default select example">
                                                <option value="" selected disabled>@lang('Select Sales Center')</option>
                                                @foreach($salesCenters as $key => $salesCenter)
                                                    <option
                                                        value="{{ $salesCenter->id }}" {{ old('sales_center_id') == $salesCenter->id ? 'selected' : '' }}>{{ $salesCenter->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('sales_center_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('sales_center_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Transfer Date') </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="@lang('Transfer Date')"
                                                           class="form-control transfer_date transferDate"
                                                           name="transfer_date"
                                                           value="{{ old('transfer_date', request()->transfer_date) }}"
                                                           data-input>
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control">
                                                            <a class="input-button cursor-pointer" title="clear"
                                                               data-clear>
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="invalid-feedback d-block">
                                                        @error('transfer_date') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4 parentItemRow">
                                        <div class="col-md-12 d-flex justify-content-between">
                                            <div>
                                                <h6 class="text-dark font-weight-bold"> @lang('Add Stock Item') </h6>
                                            </div>

                                            <div class="addStockItemFieldButton">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)"
                                                       class="btn add-more-btn-custom float-end" id="stockItemGenerate"><i
                                                            class="fa fa-plus-circle"></i> {{ trans('Add More') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="purchaseItemField">
                                        <div class="row mt-4">
                                            <div class="input-box col-md-3">
                                                <label for="item_id">@lang('Select Item')</label>
                                                <select
                                                    class="form-select js-example-basic-single selectedItem @error('item_id.0') is-invalid @enderror"
                                                    name="item_id[]"
                                                    aria-label="Default select example">
                                                    <option value="" selected disabled>@lang('Select Item')</option>
                                                    @foreach($stocks as $key => $stock)
                                                        <option
                                                            value="{{ $stock->item->id }}" {{ old('item_id.0') == $stock->item->id ? 'selected' : '' }}>{{ $stock->item->name }}</option>
                                                    @endforeach
                                                </select>

                                                @if($errors->has('item_id'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('item_id.0'))
                                                    </div>
                                                @endif
                                            </div>


                                            <div class="input-box col-md-3">
                                                <label for="item_quantity"> @lang('Quantity')</label>
                                                <div class="input-group">
                                                    <input type="number" name="item_quantity[]"
                                                           class="form-control @error('item_quantity.0') is-invalid @enderror totalQuantity"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="{{ old('item_quantity.0') }}" min="1">
                                                    <div class="input-group-append" readonly="">
                                                        <div
                                                            class="form-control currency_symbol append_group item_unit"></div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    @error('item_quantity.0') @lang($message) @enderror
                                                </div>
                                            </div>

                                            <div class="input-box col-md-3 cost_per_unit_parent">
                                                <label for="cost_per_unit"> @lang('Cost Per Unit')</label>
                                                <div class="input-group">
                                                    <input type="text" name="cost_per_unit[]"
                                                           class="form-control @error('cost_per_unit.0') is-invalid @enderror costPerUnit"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="{{ old('cost_per_unit.0') }}">
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control currency_symbol append_group">
                                                            {{ $basic->currency_symbol }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    @error('cost_per_unit.0') @lang($message) @enderror
                                                </div>
                                            </div>

                                            <div class="input-box col-md-3">
                                                <label for="total_unit_cost"> @lang('Total Cost')</label>
                                                <div class="input-group">
                                                    <input type="text" name="total_unit_cost[]"
                                                           class="form-control @error('total_unit_cost.0') is-invalid @enderror totalItemCost"
                                                           value="{{ old('total_unit_cost.0') }}">
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control currency_symbol append_group">
                                                            {{ $basic->currency_symbol }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    @error('total_unit_cost.0') @lang($message) @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="addedItemField">

                                        @php
                                            $oldItemCounts = old('item_id') ? count(old('item_id')) : 0;
                                        @endphp

                                        @if($oldItemCounts > 1)
                                            @for($i = 1; $i < $oldItemCounts; $i++)
                                                <div class="row mt-4 addMoreItemBox" id="removeItemField{{$i}}">
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <button
                                                            class="btn btn-danger delete_item_desc custom_delete_desc_padding mt-4"
                                                            type="button" onclick="deleteItemField({{$i}})">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>

                                                    <div class="input-box col-md-3">
                                                        <label for="item_id">@lang('Select Item') <span
                                                                class="text-danger">*</span></label>
                                                        <select
                                                            class="form-select js-example-basic-single{{$i}} selectedItem @error("item_id.$i") is-invalid @enderror"
                                                            name="item_id[]"
                                                            aria-label="Default select example">
                                                            <option value="" selected
                                                                    disabled>@lang('Select Item')</option>
                                                            @foreach($stocks as $key => $stock)
                                                                <option value="{{ $stock->item->id }}" {{ old("item_id.$i") == $stock->item->id ? 'selected' : '' }}>{{ $stock->item->name }}</option>
                                                            @endforeach
                                                        </select>

                                                        @if($errors->has("item_id.$i"))
                                                            <div
                                                                class="error text-danger">@lang($errors->first("item_id.$i"))</div>
                                                        @endif
                                                    </div>


                                                    <div class="input-box col-md-3">
                                                        <label for="item_quantity"> @lang('Quantity')</label>
                                                        <div class="input-group">
                                                            <input type="text" name="item_quantity[]"
                                                                   class="form-control @error("item_quantity.$i") is-invalid @enderror totalQuantity"
                                                                   value="{{ old("item_quantity.$i") }}" min="1">
                                                            <div class="input-group-append" readonly="">
                                                                <div
                                                                    class="form-control currency_symbol append_group item_unit_{{$i}}"></div>
                                                            </div>
                                                        </div>

                                                        <div class="invalid-feedback">
                                                            @error("item_quantity.$i") @lang($message) @enderror
                                                        </div>
                                                    </div>

                                                    <div class="input-box col-md-3 cost_per_unit_parent">
                                                        <label for="cost_per_unit"> @lang('Cost Per Unit')</label>
                                                        <div class="input-group">
                                                            <input type="text" name="cost_per_unit[]"
                                                                   class="form-control @error("cost_per_unit.$i") is-invalid @enderror costPerUnit"
                                                                   value="{{ old("cost_per_unit.$i") }}">
                                                            <div class="input-group-append" readonly="">
                                                                <div class="form-control currency_symbol append_group">
                                                                    {{ $basic->currency_symbol }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="invalid-feedback">
                                                            @error("cost_per_unit.$i") @lang($message) @enderror
                                                        </div>
                                                    </div>

                                                    <div class="input-box col-md-3">
                                                        <label for="total_unit_cost"> @lang('Total Cost')</label>
                                                        <div class="input-group">
                                                            <input type="text" name="total_unit_cost[]"
                                                                   class="form-control @error("total_unit_cost.$i") is-invalid @enderror totalItemCost"
                                                                   value="{{ old("total_unit_cost.$i") }}">
                                                            <div class="input-group-append" readonly="">
                                                                <div class="form-control currency_symbol">
                                                                    {{ $basic->currency_symbol }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="invalid-feedback">
                                                            @error("total_unit_cost.$i") @lang($message) @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        @endif
                                    </div>

                                    <div class="border-line-area mt-5">
                                        <h6 class="border-line-title">@lang('Summary')</h6>
                                    </div>

                                    <div class="d-flex justify-content-end mt-2">
                                        <!-- Subtotal Field -->
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <span class="fw-bold mt-2 me-3">@lang('Total Transfer')</span>
                                            <div class="input-group w-50">
                                                <input type="number" name="sub_total"
                                                       value="{{ old('sub_total') ?? '0' }}"
                                                       class="form-control bg-white text-dark itemSubTotal"
                                                       data-subtotal="{{ old('sub_total') }}"
                                                       readonly>
                                                <div class="input-group-append">
                                                    <div class="form-control">
                                                        {{ $basic->currency_symbol }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4 mt-4">
                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100" type="submit">@lang('Transfer')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <input type="hidden" name="update_sub_total" class="updateSubTotal" value="{{ old('update_sub_total') ?? '0' }}">

@endsection

@push('script')
    @include($theme.'user.partials.getItemUnit')

    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
    <script>
        'use strict'
        $(".flatpickr").flatpickr({
            wrap: true,
            maxDate: "today",
            // maxDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

        $("#stockItemGenerate").on('click', function () {
            const id = Date.now();
            var form = `<div class="row addMoreItemBox" id="removeItemField${id}">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button
                                        class="btn btn-danger delete_item_desc custom_delete_desc_padding mt-4"
                                        type="button" onclick="deleteItemField(${id})">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>

                                <div class="input-box col-md-3">
                                    <label for="item_id">@lang('Select Item') </label>
                                    <select
                                        class="form-select js-example-basic-single${id} selectedItem_${id}" onchange="selectedItemHandel(${id})"
                                        name="item_id[]"
                                        aria-label="Default select example">
                                        <option value="" selected disabled>@lang('Select Item')</option>
                                           @foreach($stocks as $key => $stock)
            <option value="{{ $stock->item->id }}">{{ $stock->item->name }}</option>
                                           @endforeach
            </select>
        </div>

        <div class="input-box col-md-3">
            <label for="item_quantity"> @lang('Quantity')</label>
                                    <div class="input-group">
                                        <input type="text" name="item_quantity[]"
                                               class="form-control totalQuantity" min="1">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group item_unit_${id}"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-box col-md-3 cost_per_unit_parent">
                                    <label for="cost_per_unit"> @lang('Cost Per Unit')</label>
                                    <div class="input-group">
                                        <input type="text" name="cost_per_unit[]"
                                               class="form-control costPerUnit">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group">
                                                {{ $basic->currency_symbol }}
            </div>
        </div>
    </div>
</div>

<div class="input-box col-md-3">
    <label for="total_unit_cost"> @lang('Total Cost')</label>
                                     <div class="input-group">
                                         <input type="text" name="total_unit_cost[]" class="form-control totalItemCost">
                                         <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol">
                                                {{ $basic->currency_symbol }}
            </div>
        </div>
    </div>
</div>
</div>`;

            $('.addedItemField').append(form)

            const selectClass = `.js-example-basic-single${id}`;
            $(".addedItemField").find(selectClass).each(function () {
                $(this).select2({
                    width: '100%',
                });
            });
        });

        function deleteItemField(id) {
            $(`#removeItemField${id}`).remove();
            calculateItemTotalPrice();
        }

        $(document).on('input', '.costPerUnit', function () {
            calculateItemTotalPrice();
        });

        function calculateItemTotalPrice() {
            let subTotal = 0;

            let discount = parseFloat($('.discountPercentage').val());
            let vat = parseFloat($('.vatPercentage').val());

            discount = isNaN(discount) ? 0 : discount;
            vat = isNaN(vat) ? 0 : vat;

            $('.costPerUnit').each(function (key, value) {
                let costPerUnit = parseFloat($(this).val()).toFixed(2);
                let quantity = parseFloat($(value).parents('.cost_per_unit_parent').siblings().find('.totalQuantity').val()).toFixed(2);
                let cost = isNaN(quantity) || isNaN(costPerUnit) ? 0 : quantity * costPerUnit;
                subTotal = parseFloat(subTotal) + parseFloat(cost);
                $(value).parents('.cost_per_unit_parent').siblings().find('.totalItemCost').val(cost);
            });

            let updateSubTotal = parseFloat(subTotal).toFixed(2);

            let discountAmount = updateSubTotal * discount / 100;
            let vatAmount = updateSubTotal * vat / 100;
            let subTotalWithVat = subTotal + vatAmount;
            let totalAmount = subTotalWithVat - discountAmount;

            $('.itemSubTotal').val(subTotal);
            $('.totalPrice').val(parseFloat(totalAmount).toFixed(2));
            $('.updateSubTotal').val(updateSubTotal);
            totalSubCount(subTotal);
        }

        function totalSubCount(subtotal) {
            let total = parseFloat($('.updateSubTotal').val()).toFixed(2);
            $('.itemSubTotal').val(total);
        }


    </script>

@endpush
