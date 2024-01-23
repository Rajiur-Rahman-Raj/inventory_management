@extends($theme.'layouts.user')
@section('title',trans('Add New Stock'))
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
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Add New Stock')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">@lang('Add New Stock')</li>
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
                                <form action="{{ route('user.stockStore')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-12">
                                            <label for="name">@lang('Stock In Date') </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="@lang('Stock Date')"
                                                           class="form-control stock_date"
                                                           name="stock_date"
                                                           value="{{ old('stock_date',request()->stock_date) }}"
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
                                                        @error('stock_date') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12 d-flex justify-content-between">
                                            <div>
                                                <h6 class="text-dark font-weight-bold"> @lang('Add Stock Item') </h6>
                                            </div>
                                            <div class="addStockItemFieldButton">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)"
                                                       class="btn add-more-btn-custom float-end"
                                                       id="stockItemGenerate"><i
                                                            class="fa fa-plus-circle"></i> {{ trans('Add More') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stockItemField">
                                        {{-- Item Field --}}
                                        <div class="row parentItemRow">
                                            <div class="input-box col-md-3">
                                                <label for="item_id">@lang('Select Item')</label>
                                                <select
                                                    class="form-select js-example-basic-single selectedItem @error('item_id.0') is-invalid @enderror"
                                                    name="item_id[]"
                                                    aria-label="Default select example">
                                                    <option value="" selected disabled>@lang('Select Item')</option>
                                                    @foreach($items as $key => $item)
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
                                                    <input type="text" name="item_quantity[]"
                                                           class="form-control @error('item_quantity.0') is-invalid @enderror totalQuantity"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="{{ old('item_quantity.0') }}">
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

                                        {{-- Raw Item Field --}}
                                        <div class="row parentRawItemRow">
                                            <div class="input-box col-md-6 mt-3">
                                                <label for="raw_item_id">@lang('Select Raw Item')</label>
                                                <select
                                                    class="form-select js-example-basic-single selectedRawItem raw_item_id @error('raw_item_id.0.0') is-invalid @enderror"
                                                    name="raw_item_id[0][]"
                                                    aria-label="Default select example">
                                                    <option value="" selected
                                                            disabled>@lang('Select Raw Item')</option>
                                                    @foreach($rawItems as $key => $rawItem)
                                                        <option
                                                            value="{{ $rawItem->id }}" {{ old('raw_item_id.0') == $rawItem->id ? 'selected' : '' }}>{{ $rawItem->name }}</option>
                                                    @endforeach
                                                </select>

                                                @if($errors->has('raw_item_id'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('raw_item_id.0'))
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="input-box col-md-5 mt-3">
                                                <label for="raw_item_quantity"> @lang('Expense Quantity')</label>
                                                <div class="input-group">
                                                    <input type="text" name="raw_item_quantity[0][]"
                                                           class="form-control raw_item_quantity @error('raw_item_quantity.0') is-invalid @enderror totalRawItemQuantity"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="{{ old('raw_item_quantity.0.0') }}">
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control currency_symbol append_group raw_item_unit"></div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    @error('raw_item_quantity.0') @lang($message) @enderror
                                                </div>
                                            </div>
                                            <div class="input-box col-md-1 mt-5">
                                                <span class="input-group-btn">
                                                    <button
                                                        class="btn btn-outline-success mt-2 rawItemFieldBtn rawItemFieldGenerate"
                                                        type="button"
                                                        id="rawItemFieldGenerate">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        @php
                                            $oldRawItemCounts = old('raw_item_id') ? count(old('raw_item_id')) : 0;
                                        @endphp

                                        @if($oldRawItemCounts > 1)
                                            @for($i = 1; $i < $oldRawItemCounts; $i++)
                                                {{-- Old Raw Item Field --}}
                                                <div class="row parentRawItemRow">
                                                    <div class="input-box col-md-6 mt-3">
                                                        <label for="raw_item_id">@lang('Select Raw Item')</label>
                                                        <select
                                                            class="form-select js-example-basic-single raw_item_id @error("raw_item_id.$i") is-invalid @enderror"
                                                            name="raw_item_id[0][]"
                                                            onchange="selectedRawItemHandel({{$i}})"
                                                            aria-label="Default select example">
                                                            <option value="" selected
                                                                    disabled>@lang('Select Raw Item')</option>
                                                            @foreach($rawItems as $key => $rawItem)
                                                                <option
                                                                    value="{{ $rawItem->id }}" {{ old("raw_item_id.$i") == $rawItem->id ? 'selected' : '' }}>{{ $rawItem->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has("raw_item_id.$i"))
                                                            <div
                                                                class="error text-danger">@lang($errors->first("raw_item_id.$i"))</div>
                                                        @endif
                                                    </div>
                                                    <div class="input-box col-md-5 mt-3">
                                                        <label
                                                            for="raw_item_quantity"> @lang('Expense Quantity')</label>
                                                        <div class="input-group">
                                                            <input type="text" name="raw_item_quantity[0][]"
                                                                   value="{{ old("raw_item_quantity.$i") }}"
                                                                   class="form-control raw_item_quantity @error("item_quantity.$i") is-invalid @enderror totalRawItemQuantity">
                                                            <div class="input-group-append" readonly="">
                                                                <div
                                                                    class="form-control currency_symbol append_group"></div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @error("raw_item_quantity.$i") @lang($message) @enderror
                                                        </div>
                                                    </div>
                                                    <div class="input-box col-md-1 mt-5">
                                                            <span class="input-group-btn">
                                                                <button
                                                                    class="btn btn-outline-danger delete_raw_item_field mt-2"
                                                                    type="button">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </span>
                                                    </div>
                                                </div>
                                                @push('script')
                                                    <script>
                                                        const rawItemSelect2Class{{$i}} = `.js-example-basic-single{{$i}}`;
                                                        $(document).ready(function () {
                                                            $(rawItemSelect2Class{{$i}}).select2({
                                                                width: '100%',
                                                            });
                                                        });
                                                    </script>
                                                @endpush
                                            @endfor
                                        @endif
                                        {{--                                    </div>--}}

                                        {{--                                    <div class="addedItemField">--}}
                                        @php
                                            $oldItemCounts = old('item_id') ? count(old('item_id')) : 0;
                                        @endphp

                                        @if($oldItemCounts > 1)
                                            @for($i = 1; $i < $oldItemCounts; $i++)
                                                <div id="removeItemField{{$i}}">
                                                    {{-- Old Item Field --}}
                                                    <div class="row mt-4 addMoreItemBox parentItemRow">
                                                        <div class="col-md-12 d-flex justify-content-end">
                                                            <button
                                                                class="btn btn-danger delete_item_desc custom_delete_desc_padding mt-4"
                                                                type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>

                                                        <div class="input-box col-md-3">
                                                            <label for="item_id">@lang('Select Item') </label>
                                                            <select
                                                                class="form-select js-example-basic-single{{$i}} selectedItem_{{$i}} @error("item_id.$i") is-invalid @enderror"
                                                                name="item_id[]"
                                                                aria-label="Default select example">
                                                                <option value="" selected
                                                                        disabled>@lang('Select Item')</option>
                                                                @foreach($items as $key => $item)
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
                                                                       value="{{ old("item_quantity.$i") }}">
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
                                                                    <div
                                                                        class="form-control currency_symbol append_group">
                                                                        {{ $basic->currency_symbol }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="invalid-feedback">
                                                                @error("item_quantity.$i") @lang($message) @enderror
                                                            </div>
                                                        </div>

                                                        <div class="input-box col-md-3 mt-3">
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

                                                    <div class="row">
                                                        <div class="input-box col-md-6 mt-3">
                                                            <label for="raw_item_id">@lang('Select Raw Item')</label>
                                                            <select
                                                                class="form-select js-example-basic-single raw_item_id @error("raw_item_id.$i") selectedRawItem is-invalid @enderror"
                                                                name="raw_item_id[0][]"
                                                                aria-label="Default select example">
                                                                <option value="" selected
                                                                        disabled>@lang('Select Raw Item')</option>
                                                                @foreach($rawItems as $key => $rawItem)
                                                                    <option
                                                                        value="{{ $rawItem->id }}" {{ old("raw_item_id.$i") == $rawItem->id ? 'selected' : '' }}>{{ $rawItem->name }}</option>
                                                                @endforeach
                                                            </select>

                                                            @if($errors->has("raw_item_id.$i"))
                                                                <div
                                                                    class="error text-danger">@lang($errors->first("raw_item_id.$i"))
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="input-box col-md-5 mt-3">
                                                            <label
                                                                for="raw_item_quantity"> @lang('Expense Quantity')</label>
                                                            <div class="input-group">
                                                                <input type="text" name="raw_item_quantity[0][]"
                                                                       class="form-control raw_item_quantity @error("raw_item_quantity.$i") is-invalid @enderror totalRawItemQuantity"
                                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                                       value="{{ old("raw_item_quantity.$i") }}">
                                                                <div class="input-group-append" readonly="">
                                                                    <div
                                                                        class="form-control currency_symbol append_group raw_item_unit_{{$i}}"></div>
                                                                </div>
                                                            </div>

                                                            <div class="invalid-feedback">
                                                                @error("raw_item_quantity.$i") @lang($message) @enderror
                                                            </div>
                                                        </div>

                                                        <div class="input-box col-md-1 mt-5">
                                                            <span class="input-group-btn">
                                                                <button
                                                                    class="btn btn-outline-success mt-2 rawItemFieldBtn rawItemFieldGenerate"
                                                                    type="button"
                                                                    id="rawItemFieldGenerate">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="addRawItemField_{{$i}}">
                                                        {{--TODO  old raw item field problem not fixed  --}}
                                                    </div>
                                                </div>
                                            @endfor
                                        @endif
                                    </div>

                                    <div class="border-line-area mt-5">
                                        <h6 class="border-line-title">@lang('Summary')</h6>
                                    </div>

                                    <div class=" d-flex justify-content-end mt-2">
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <span class="fw-bold mt-2 me-3">@lang('Sub Total')</span>
                                            <div class="input-group w-50">
                                                <input type="number" name="sub_total"
                                                       value="{{ old('sub_total') ?? '0' }}"
                                                       class="form-control bg-white text-dark itemSubTotal"
                                                       data-subtotal="{{ old('sub_total') }}"
                                                       readonly>
                                                <div class="input-group-append" readonly="">
                                                    <div class="form-control">
                                                        {{ $basic->currency_symbol }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4 mt-4">
                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit">@lang('Add Stock')</button>
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
            minDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

        $("#stockItemGenerate").on('click', function () {
            let parentLength = $('.parentItemRow').length;

            let itemMarkup = $('.parentItemRow:eq(0)').clone();
            itemMarkup.prepend(`<div class="col-md-12 d-flex justify-content-end">
                                    <button class="btn btn-danger itemRemoveBtn delete_item_desc custom_delete_desc_padding mt-4" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>`);

            itemMarkup.addClass('mt-4').find('input').val('');
            itemMarkup.find('.input-group-append > .item_unit').text('');

            $('.stockItemField').append(itemMarkup);

            let rawItemMarkup = $('.parentRawItemRow:eq(0)').clone();
            rawItemMarkup.find('input').val('');
            rawItemMarkup.find('.raw_item_id').attr('name', `raw_item_id[${parentLength}][]`);
            rawItemMarkup.find('.raw_item_quantity').attr('name', `raw_item_quantity[${parentLength}][]`);
            rawItemMarkup.find('.input-group-append > .raw_item_unit').text('');

            $('.stockItemField').append(rawItemMarkup);

            $('.js-example-basic-single').each(function () {
                $(this).select2({
                    width: '100%',
                });

                if ($(this).siblings('.select2').length > 1)
                    $(this).siblings('.select2').not(':first').remove();
            });
        });

        $(document).on('click', '.rawItemFieldGenerate', function () {

            var closestParentRawItemRow = $(this).closest('.parentRawItemRow');
            var parentItemRowIndex = closestParentRawItemRow.prevAll('.parentItemRow').not('.parentRawItemRow').length - 1;
            let parentLength = $('.parentItemRow').length;

            let rawItemMarkup = $('.parentRawItemRow:eq(0)').clone();
            rawItemMarkup.find('input').val('');
            rawItemMarkup.find('.raw_item_id').attr('name', `raw_item_id[${parentItemRowIndex}][]`);
            rawItemMarkup.find('.raw_item_quantity').attr('name', `raw_item_quantity[${parentItemRowIndex}][]`);
            rawItemMarkup.find('.input-group-append > .raw_item_unit').text('');
            rawItemMarkup.find('.rawItemFieldBtn').removeClass('btn-outline-success rawItemFieldGenerate').addClass('btn-outline-danger rawItemFieldRemove').find('i').removeClass('fa-plus').addClass('fa-minus');
            $(this).parents('.parentRawItemRow').after(rawItemMarkup);
            $('.js-example-basic-single').each(function () {
                $(this).select2({
                    width: '100%',
                });

                if ($(this).siblings('.select2').length > 1)
                    $(this).siblings('.select2').not(':first').remove();
            });
        });

        $(document).on('click', '.itemRemoveBtn', function () {
            $(this).parents('.parentItemRow').nextUntil('.parentItemRow').remove();
            $(this).parents('.parentItemRow').remove();
        });

        $(document).on('click', '.rawItemFieldRemove', function () {
            $(this).parents('.parentRawItemRow').remove();
        });



        $(document).on('input', '.costPerUnit', function () {
            calculateItemTotalPrice();
        });

        function calculateItemTotalPrice() {
            let subTotal = 0;

            $('.costPerUnit').each(function (key, value) {
                let costPerUnit = parseFloat($(this).val()).toFixed(2);
                let quantity = parseFloat($(value).parents('.cost_per_unit_parent').siblings().find('.totalQuantity').val()).toFixed(2);
                let cost = isNaN(quantity) || isNaN(costPerUnit) ? 0 : quantity * costPerUnit;
                subTotal = parseFloat(subTotal) + parseFloat(cost);
                $(value).parents('.cost_per_unit_parent').siblings().find('.totalItemCost').val(cost);
            });

            let updateSubTotal = parseFloat(subTotal).toFixed(2);

            $('.itemSubTotal').val(subTotal);
            $('.updateSubTotal').val(updateSubTotal);
            totalSubCount(subTotal);
        }

        function totalSubCount(subtotal) {
            let total = parseFloat($('.updateSubTotal').val()).toFixed(2);
            $('.itemSubTotal').val(total);
        }
    </script>

@endpush
