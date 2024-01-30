@extends($theme.'layouts.user')
@section('title',trans('Purchase Raw Items'))
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
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Purchase Raw Items')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">@lang('Purchase Raw Items')</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{route('user.purchaseRawItemList')}}"
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
                                <form action="{{ route('user.storePurchaseItem')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="supplier_id">@lang('Select Supplier')</label>
                                            <select
                                                class="form-select js-example-basic-single @error('supplier_id') is-invalid @enderror selectSupplier"
                                                name="supplier_id"
                                                aria-label="Default select example">
                                                <option value="" selected disabled>@lang('Select Supplier')</option>
                                                @foreach($suppliers as $key => $supplier)
                                                    <option
                                                        value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('supplier_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('supplier_id'))
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Purchase Date') </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="@lang('Purchase Date')"
                                                           class="form-control purchase_date purchaseDate"
                                                           name="purchase_date"
                                                           value="{{ old('purchase_date',request()->purchase_date) }}"
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
                                                        @error('purchase_date') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 d-flex justify-content-between">
                                            <div>
                                                <h6 class="text-dark font-weight-bold"> @lang('Add Purchase Item') </h6>
                                            </div>

                                            <div class="addPurchaseItemFieldButton">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)"
                                                       class="btn add-more-btn-custom float-end"
                                                       id="purchaseItemGenerate"><i
                                                            class="fa fa-plus-circle"></i> {{ trans('Add More') }}
                                                    </a>
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
                                                    @foreach($allItems as $key => $item)
                                                        <option
                                                            value="{{ $item->id }}" {{ old('item_id.0') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                                    @error('item_quantity.0') @lang($message) @enderror
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
                                                            @foreach($allItems as $key => $item)
                                                                <option
                                                                    value="{{ $item->id }}" {{ old("item_id.$i") == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                                            @error("item_quantity.$i") @lang($message) @enderror
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
                                            <span class="fw-bold mt-2 me-3">@lang('Sub Total')</span>
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

                                    <div class="d-flex justify-content-end mt-2">
                                        <!-- Discount Input Field -->
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <span class="fw-bold mt-2 me-3">@lang('Discount')</span>
                                            <div class="input-group w-50">
                                                <input type="number" name="discount_percentage" id="discountPercentage"
                                                       value="{{ old('discount_percentage') ?? '0' }}"
                                                       class="form-control bg-white text-dark discountPercentage"
                                                       data-discount="{{ old('discount_percentage') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-2">
                                        <!-- Discount Input Field -->
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <span class="fw-bold mt-2 me-3">@lang('Vat')</span>
                                            <div class="input-group w-50">
                                                <input type="number" name="vat_percentage" id="vatPercentage"
                                                       value="{{ old('vat_percentage') ?? '0' }}"
                                                       class="form-control bg-white text-dark vatPercentage"
                                                       data-discount="{{ old('vat_percentage') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-2">
                                        <!-- Total Price Field -->
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <span class="fw-bold mt-2 me-3">@lang('Total Price')</span>
                                            <div class="input-group w-50">
                                                <input type="number" name="total_price"
                                                       value="{{ old('total_price') ?? '0' }}"
                                                       class="form-control bg-white text-dark totalPrice"
                                                       data-total="{{ old('total_price') }}"
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
                                            <button class="btn-custom w-100 proceedPurchaseBtn" type="button">@lang('Proceed Purchase')</button>
{{--                                            data-bs-toggle="modal" data-bs-target="#proceedPurchaseModal"--}}
{{--                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#proceedPurchaseModal">--}}
{{--                                                Launch demo modal--}}
{{--                                            </button>--}}
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="procced-modal">
                                        <div class="modal fade" id="proceedPurchaseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog ">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Make Payment</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="total-amount d-flex align-items-center justify-content-between">
                                                            <h5>Total Purchased Amount</h5>
                                                            <h6 class="make-payment-total-amount"></h6>
                                                        </div>
                                                        <div class="enter-amount d-flex justify-content-between align-items-center">
                                                            <h6>Paid Amount</h6>
                                                            <input type="text" class="form-control customer-paid-amount" value="0" min="0" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" id="exampleFormControlInput1" name="paid_amount">
                                                        </div>
                                                        <div class="change-amount d-flex align-items-center justify-content-between">
                                                            <h4 class="m-2 due-or-change-text"></h4>  <span class="due-or-change-amount"></span>
                                                            <input type="hidden" name="due_or_change_amount" class="due_or_change_amount_input">
                                                        </div>
                                                        <div class="total-amount d-flex align-items-center justify-content-between">
                                                            <h5>@lang('Total Payable Amount')</h5>
                                                            <h6 class="total-payable-amount"></h6>
                                                            <input type="hidden" name="total_payable_amount" class="total_payable_amount_input">
                                                        </div>
                                                        <div class="file">
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">@lang('Payment Date')</label>

                                                                <div class="flatpickr">
                                                                    <div class="input-group">
                                                                        <input type="hidden" placeholder="Select Payment Date" class="form-control payment_date flatpickr-input" name="payment_date" value="" data-input="">
                                                                        <div class="input-group-append" readonly="">
                                                                            <div class="form-control payment-date-times">
                                                                                <a class="input-button cursor-pointer" title="clear" data-clear="">
                                                                                    <i class="fas fa-times" aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="invalid-feedback d-block"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">@lang('Note')                                                                            <span><sub>(optional)</sub></span></label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="details note write here" rows="4" name="note"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Cancel')
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">@lang('Confirm Purchase')</button>
                                                    </div>
                                                </div>
                                            </div>
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
    @include($theme.'user.partials.getRawItemUnit')

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

        $(document).on('click', '.proceedPurchaseBtn', function () {
            let result = checkPurchaseBy();
            if(result){
                showPurchaseModal();
            }
        });

        function checkPurchaseBy(){
            let selectSupplier = $('.selectSupplier').val();
            let purchaseDate = $('.purchaseDate').val();
            if(!selectSupplier){
                Notiflix.Notify.failure('Please Select Supplier');
                return false;
            }else if(purchaseDate == ''){
                Notiflix.Notify.failure('Please Select Purchase Date');
                return false;
            }
            return true;
        }

        function showPurchaseModal() {
            var proceedPurchaseModal = new bootstrap.Modal(document.getElementById('proceedPurchaseModal'))
            proceedPurchaseModal.show();

            var totalAmount = parseFloat($('.totalPrice').val());
            $('.make-payment-total-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)
            $('.due-or-change-text').text('Due Amount');
            $('.due-or-change-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)
            $('.total-payable-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)

            $('.due_or_change_amount_input').val(`${totalAmount.toFixed(2)}`)
            $('.total_payable_amount_input').val(`${totalAmount.toFixed(2)}`)
        }

        $(document).on('keyup', '.customer-paid-amount', function () {
            var totalAmount = parseFloat($('.totalPrice').val());
            let customerPaidAmount = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());

            let dueOrChangeAmount = totalAmount - customerPaidAmount;

            if (dueOrChangeAmount >= 0) {
                $('.due-or-change-text').text('Due Amount')
                $('.due-or-change-amount').text(`${dueOrChangeAmount.toFixed(2)} {{ $basic->currency_symbol }}`)
                $('.total-payable-amount').text(`${customerPaidAmount.toFixed(2)} {{ $basic->currency_symbol }}`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${customerPaidAmount.toFixed(2)}`)

            } else {
                $('.due-or-change-text').text('Change Amount')
                $('.due-or-change-amount').text(`${Math.abs(dueOrChangeAmount).toFixed(2)} {{ $basic->currency_symbol }}`)
                $('.total-payable-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${totalAmount.toFixed(2)}`)
            }
        });


        $("#purchaseItemGenerate").on('click', function () {
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
                                           @foreach($allItems as $key => $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
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


        $(document).on('input', '.discountPercentage', function () {
            // Recalculate total after updating the discount
            let discount = $(this).val();
            if (discount > 100) {
                Notiflix.Notify.warning('Discount cannot exceed 100%');
                $('.discountPercentage').attr('max', 100)
                $('.discountPercentage').val(100)
                return;
            }
            calculateItemTotalPrice();
        });

        $(document).on('input', '.vatPercentage', function () {
            // Recalculate total after updating the Vat
            let vat = $(this).val();
            if (vat > 100) {
                Notiflix.Notify.warning('Vat cannot exceed 100%');
                $('.vatPercentage').attr('max', 100)
                $('.vatPercentage').val(100)
                return;
            }
            calculateItemTotalPrice();
        });

    </script>

@endpush
