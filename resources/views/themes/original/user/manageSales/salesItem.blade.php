@extends($theme.'layouts.user')
@section('title', 'Manage Sales')

@push('style')
    <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    <section class="pos-section section-1">
        <div class="container-fluid ">
            <div class="row main">
                <div class="col-xl-8 col-lg-8">
                    <div class="product-bg">
                        <div class="row g-2">
                            <div class="col-md-12">
                                <div class="product-top d-flex align-items-center flex-wrap">
                                    <div class="input-group">
                                        <label for="" class="mb-2">@lang('Filter By Items')</label>
                                        <select class="form-select js-example-basic-single selectedItems"
                                                data-oldselecteditems="{{ session('filterItemId') }}"
                                                name="item_id"
                                                aria-label="Default select example">
                                            <option value="all">@lang('All Items')</option>
                                            @foreach($items as $item)
                                                <option
                                                    value="{{ $item->id }}" {{ old('item_id', session('filterItemId')) == $item->id ? 'selected' : ''}}> @lang($item->name)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row pushItem">
                            @if(count($stocks) > 0)
                                @foreach($stocks as $stock)
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="product-box shadow-sm p-3 mb-5 bg-body rounded">
                                            <div class="product-title d-flex justify-content-between">
                                                @if($stock->quantity > 0)
                                                    <a type="button" class="btn">
                                                        @lang('in stock') <span
                                                            class="badge bg-success">{{ $stock->quantity }}</span>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)"
                                                       class="text-danger border-danger">@lang('out of stock')</a>
                                                @endif
                                            </div>
                                            <div class="product-img">
                                                <a href="javascript:void(0)">
                                                    <img class="img-fluid"
                                                         src="{{ getFile(config('location.itemImage.path').optional($stock->item)->image) }}"
                                                         alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-box ">
                                                <div class="product-content">
                                                    <h6>
                                                        <a href="javascript:void(0)">{{ optional($stock->item)->name }}</a>
                                                    </h6>

                                                </div>
                                                <div
                                                    class="shopping-icon d-flex align-items-center justify-content-between">
                                                    <h4>
                                                        <button class="sellingPriceButton updateUnitPrice"
                                                                data-sellingprice="{{ $stock->selling_price }}"
                                                                data-route="{{ route('user.updateItemUnitPrice', $stock->id) }}">{{ $stock->selling_price }} {{ $basic->currency_symbol }}</button>
                                                    </h4>
                                                    @if($stock->quantity > 0)
                                                        <button class="btn btn-sm addToCartButton"
                                                                data-property="{{ $stock }}"><i
                                                                class="fa fa-cart-plus"></i></button>
                                                    @else
                                                        <button class="btn btn-sm addToCartButton opacity-0 disabled"><i
                                                                class="fa fa-cart-plus"></i></button>
                                                    @endif
                                                </div>
                                                <p>
                                                    <span>Purchase Price:</span> {{ $stock->last_cost_per_unit }} {{ $basic->currency_symbol }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img
                                        src="{{ asset('assets/global/img/no_data.gif') }}"
                                        class="card-img-top empty-state-img" alt="...">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-4">
                    <form action="{{ route('user.salesOrderStore') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="cart-side">
                            <div class="tab-box">
                                <div class="tab-tille">
                                    <h4>@lang('sales by')</h4>
                                </div>
                                <div class="description-tab">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                                    aria-controls="home-tab-pane"
                                                    aria-selected="true">@lang('Customer')
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                    data-bs-target="#contact-tab-pane" type="button" role="tab"
                                                    aria-controls="contact-tab-pane" aria-selected="false">
                                                @lang('Sales Center')
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="description-content mt-2">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                             aria-labelledby="home-tab" tabindex="0">

                                            <div class="cutomer-select mt-2">
                                                <label for="sales_center_id"
                                                       class="mb-2">@lang('Which Sales Center?')</label>
                                                <select
                                                    class="form-select js-example-basic-single select-sales-center salesCenterId"
                                                    name="sales_center_id"
                                                    aria-label="Default select example">
                                                    <option value="" selected
                                                            disabled>@lang('Select Sales Center')</option>
                                                    @foreach($salesCenters as $saleCenter)
                                                        <option
                                                            value="{{ $saleCenter->id }}" {{ old('sales_center_id', @request()->sales_center_id) == $saleCenter->id ? 'selected' : ''}}> @lang($saleCenter->name)</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback d-block">
                                                    @error('sales_center_id') @lang($message) @enderror
                                                </div>
                                            </div>

                                            <div class="cutomer-select mt-3">
                                                <select
                                                    class="form-select js-example-basic-single select-customer customerId"
                                                    name="customer_id"
                                                    aria-label="Default select example">
                                                    <option value="" selected disabled>@lang('Select Customer')</option>

                                                    @foreach($customers as $customer)
                                                        <option
                                                            value="{{ $customer->id }}" {{ old('customer_id', @request()->customer_id) == $customer->id ? 'selected' : ''}}> @lang($customer->name)</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback d-block">
                                                    @error('customer_id') @lang($message) @enderror
                                                </div>
                                            </div>

                                            <div class="cautomer-details">
                                                <div class="mb-2">
                                                    <input type="text" class="form-control customerPhone"
                                                           id="exampleFormControlInput1" name="customer_phone"
                                                           value="{{ old('customer_name', @request()->customer_name) }}"
                                                           placeholder="Customer Phone">
                                                </div>
                                                <div class="mb-3">
                                    <textarea class="form-control customerAddress" id="exampleFormControlTextarea1"
                                              placeholder="Customer Address" name="customer_address"
                                              rows="3">{{ old('customer_address', @request()->customer_address) }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                             aria-labelledby="contact-tab" tabindex="0">
                                            <div class="cutomer-select">
                                                <select
                                                    class="form-select js-example-basic-single select-sales-center selectSalesCenter salesCenterId"
                                                    name="sales_center_id"
                                                    aria-label="Default select example">
                                                    <option value="" selected
                                                            disabled>@lang('Select Sales Center')</option>

                                                    @foreach($salesCenters as $saleCenter)
                                                        <option
                                                            value="{{ $saleCenter->id }}" {{ old('sales_center_id', @request()->sales_center_id) == $saleCenter->id ? 'selected' : ''}}> @lang($saleCenter->name)</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="cautomer-details">
                                                <div class="mb-2">
                                                    <input type="text" class="form-control owner-name"
                                                           id="exampleFormControlInput1"
                                                           name="owner_name"
                                                           value="{{ old('owner_name', @request()->owner_name) }}"
                                                           placeholder="Owner Name">
                                                </div>

                                                <div class="mb-2">
                                                    <input type="text" class="form-control owner-phone"
                                                           id="exampleFormControlInput1"
                                                           name="owner_phone"
                                                           value="{{ old('owner_phone', @request()->owner_phone) }}"
                                                           placeholder="Owner Phone">
                                                </div>

                                                <div class="mb-3">
                                    <textarea class="form-control sales-center-address" id="exampleFormControlTextarea1"
                                              placeholder="Sales Center Address" rows="5"
                                              name="sales_center_address">{{ old('sales_center_address', @request()->sales_center_address) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-items-area {{ count($cartItems) > 0 ? '' : 'd-none' }}">
                                <div class="cart-box">
                                    <div class="cart-top d-flex align-items-center justify-content-between">
                                        <h6>items in cart</h6>
                                        <button type="button" class="btn clearCart">
                                            <i class="fa fa-times"></i>clear cart
                                        </button>
                                    </div>

                                    <div class="addCartItems">
                                        @foreach($cartItems as $cartItem)
                                            <div class="cat-item d-flex">
                                                <div class="tittle">{{ optional($cartItem->item)->name }}</div>
                                                <input type="hidden" name="item_id[]"
                                                       value="{{ optional($cartItem->item)->id }}">

                                                <input type="hidden" name="stock_id[]"
                                                       value="{{ $cartItem->stock_id }}">

                                                <input type="hidden" name="item_name[]"
                                                       value="{{ optional($cartItem->item)->name }}">

                                                <div class="quantity">
                                                    <input type="number" name="item_quantity[]"
                                                           value="{{ $cartItem->quantity }}"
                                                           class="itemQuantityInput"
                                                           data-stockid="{{ $cartItem->stock_id }}"
                                                           data-itemid="{{ $cartItem->item_id }}"
                                                           data-cartitem="{{ $cartItem->cost_per_unit }}"
                                                           min="1">
                                                </div>
                                                <input type="hidden" name="cost_per_unit[]"
                                                       value="{{ $cartItem->cost_per_unit }}">
                                                <div class="prize">
                                                    <h6 class="cart-item-cost">{{ $cartItem->cost }} {{ $basic->currency_symbol }}</h6>
                                                    <input type="hidden" name="item_price[]"
                                                           value="{{ $cartItem->cost }}" class="item_price_input">
                                                </div>
                                                <div class="remove">
                                                    <a href="javascript:void(0)" class="clearSingleCartItem"
                                                       data-id="{{ $cartItem->id }}">
                                                        <i class="fa fa-times"></i></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="total-box">
                                    <div class="amount">
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control itemsDiscountInput"
                                                   aria-label="" name="discount_parcent" placeholder="discount"
                                                   max="100" value="{{ old('discount_parcent') }}">
                                            <span class="input-group-text">%</span>

                                        </div>
                                    </div>
                                    <div class="total">
                                        <ul>
                                            <li>
                                                <h5>subtotal</h5>
                                                <h6><span
                                                        class="sub-total-area">{{getAmount($subTotal, config('basic.fraction_number'))}}</span>
                                                    <span
                                                        class="sub-total-area-span">{{ $basic->currency_symbol }}</span>
                                                </h6>
                                                <input type="hidden" name="sub_total"
                                                       value="{{getAmount($subTotal, config('basic.fraction_number'))}}"
                                                       class="sub-total-input">
                                            </li>
                                            <li>
                                                <h5>Discount</h5>
                                                <h6 class="discount-area">0 {{ $basic->currency_symbol }}</h6>
                                                <input type="hidden" name="discount_amount" value="0"
                                                       class="discount-amount-input">
                                            </li>

                                        </ul>
                                        <div class="total-amount d-flex align-items-center justify-content-between">
                                            <h5>total</h5>
                                            <h6 class="total-area">{{getAmount($subTotal, config('basic.fraction_number'))}} {{ $basic->currency_symbol }}</h6>
                                            <input type="hidden" name="total_amount" class="total-amount-input"
                                                   value="{{getAmount($subTotal, config('basic.fraction_number'))}}">
                                        </div>
                                        <div class="order-btn d-flex flex-wrap">
                                            <button class="cancel cancelOrder" type="button">cacel order</button>
                                            <button type="button" class="porcced proccedOrderBtn">proceed order
                                            </button>

                                            <div class="procced-modal">
                                                <div class="modal fade" id="proccedOrderModal" tabindex="-1"
                                                     aria-labelledby="proccedOrderModal" aria-hidden="true">
                                                    <div class="modal-dialog ">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalLabel">@lang('Make Payment')</h1>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div
                                                                    class="total-amount d-flex align-items-center justify-content-between">
                                                                    <h5>@lang('Total Order Amount')</h5>
                                                                    <h6 class="make-payment-total-amount"></h6>
                                                                </div>
                                                                <div
                                                                    class="enter-amount d-flex justify-content-between align-items-center">
                                                                    <h6>Customer Paid Amount</h6>
                                                                    <input type="text"
                                                                           class="form-control customer-paid-amount"
                                                                           value="0" min="0"
                                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                                           id="exampleFormControlInput1"
                                                                           name="customer_paid_amount">
                                                                </div>
                                                                <div
                                                                    class="change-amount d-flex align-items-center justify-content-between">
                                                                    <h4 class="m-2 due-or-change-text"></h4>  <span
                                                                        class="due-or-change-amount"></span>
                                                                    <input type="hidden" name="due_or_change_amount"
                                                                           class="due_or_change_amount_input">
                                                                </div>
                                                                <div
                                                                    class="total-amount d-flex align-items-center justify-content-between">
                                                                    <h5>@lang('Total Payable Amount')</h5>
                                                                    <h6 class="total-payable-amount"></h6>
                                                                    <input type="hidden" name="total_payable_amount"
                                                                           class="total_payable_amount_input">
                                                                </div>
                                                                <div class="file">
                                                                    <div class="mb-3">
                                                                        <label for="formFile" class="form-label">Payment
                                                                            Date</label>

                                                                        <div class="flatpickr">
                                                                            <div class="input-group">
                                                                                <input type="date"
                                                                                       placeholder="@lang('Select Payment Date')"
                                                                                       class="form-control payment_date"
                                                                                       name="payment_date"
                                                                                       value="{{ old('payment_date',request()->payment_date) }}"
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
                                                                                    @error('payment_date') @lang($message) @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="mb-3">
                                                                        <label for="formFile"
                                                                               class="form-label">@lang('Payment Note')
                                                                            <span><sub>(@lang('optional'))</sub></span></label>
                                                                        <textarea class="form-control"
                                                                                  id="exampleFormControlTextarea1"
                                                                                  placeholder="Write payment note"
                                                                                  rows="4"
                                                                                  name="payment_note"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                        data-bs-dismiss="modal">cancel
                                                                </button>
                                                                <button type="submit"
                                                                        class="btn btn-primary">@lang('Confirm Order')
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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


    <div class="clear-cart profile-setting">
        <div class="modal fade" id="updateUnitPriceModal" tabindex="-1" aria-labelledby="cartModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cartModal">Update Unit Price</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="" class="m-0 p-0 updateItemUnitPriceRoute" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="input-box col-md-12">
                                <label for="selling_price">@lang('Cost Per Unit')</label>
                                <div class="input-group">
                                    <input type="hidden" name="filter_item_id" class="filter_item_id" value="">
                                    <input type="text" name="selling_price"
                                           class="form-control selling_cost_per_unit @error('selling_price') is-invalid @enderror"
                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                           value="{{ old('selling_price') }}">
                                    <div class="input-group-append" readonly="">
                                        <div class="form-control currency_symbol append_group">
                                            {{ $basic->currency_symbol }}
                                        </div>
                                    </div>
                                    @if($errors->has('selling_price'))
                                        <div
                                            class="error text-danger">@lang($errors->first('selling_price'))
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Update</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="clear-cart profile-setting">
        <div class="modal fade" id="clearCartModal" tabindex="-1" aria-labelledby="clearCartModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cartModal">Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.clearCartItems') }}" class="m-0 p-0"
                          method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p>Are you sure clear all cart items?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Clear</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="clear-cart profile-setting">
        <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cartModal">Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.clearCartItems') }}" class="m-0 p-0"
                          method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p>Are you sure cancel this order?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                No
                            </button>
                            <button type="submit" class="btn btn-primary">Yes</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="clear-cart profile-setting">
        <div class="modal fade" id="clearSingleCartModal" tabindex="-1" aria-labelledby="clearSingleCartModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cartModal">Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="" class="m-0 p-0 clearSingleCartItemRoute"
                          method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p>Are you sure clear <span class="single-cart-item-name"></span> cart items?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Clear</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="clear-cart profile-setting">

    </div>

@endsection

@push('script')
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>

    @if($errors->has('payment_date'))
        <script>
            var myModal = new bootstrap.Modal(document.getElementById("proccedOrderModal"), {});
            document.onreadystatechange = function () {
                myModal.show();
                showProccedOrderModal();
                updateTotal();
            };

        </script>
    @endif


    <script>
        'use strict'
        var canShowWarning = true;
        $(".flatpickr").flatpickr({
            wrap: true,
            maxDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

        if (!isNaN(parseFloat($('.selectedItems').data('oldselecteditems')))) {
            getSelectedItems(parseFloat($('.selectedItems').data('oldselecteditems')));
        }


        $('.select-customer').select2({
            width: '100%',
        }).on('select2:open', () => {
            $(".select2-results:not(:has(a))").append(`<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{ route('user.createCustomer') }}"
                    class="btn btn-outline-primary" target="_blank">+ Create New Customer </a>
                    </li>`);
        });

        $('.select-sales-center').select2({
            width: '100%',
        }).on('select2:open', () => {
            $(".select2-results:not(:has(a))").append(`<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{ route('user.createSalesCenter') }}"
                    class="btn btn-outline-primary" target="_blank">+ Create Sales Center </a>
                    </li>`);
        });

        $('.selectedItems').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedItems(selectedValue);
        })

        function getSelectedItems(value) {
            $.ajax({
                url: "{{ route('user.getSelectedItems') }}",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    let stocks = response.stocks;
                    let itemsData = '';

                    if (stocks.length === 0) {
                        itemsData = `<div class="col-md-12 d-flex justify-content-center">
                                        <img src="{{ asset('assets/global/img/no_data.gif') }}" class="card-img-top empty-state-img" alt="..." style="width: 300px">
                                    </div>`
                    } else {
                        stocks.forEach(function (stock) {
                            itemsData += `


                                <div class="col-xl-4 col-lg-6">
                        <div class="product-box shadow-sm p-3 mb-5 bg-body rounded">
                            <div class="product-title">
                                ${stock.quantity > 0 ? '<a type="button" class="btn">in stock <span class="badge bg-success">' + stock.quantity + '</span></a>' : '<a href="javascript:void(0)" class="text-danger border-danger">out of stock</a>'}

                            </div>

                            <div class="product-img">
                                <a href="javascript:void(0)">
                                    <img class="img-fluid"
                                         src="${stock.item.image}"
                                         alt="">
                                </a>
                            </div>
                            <div class="product-content-box ">
                                <div class="product-content">
                                    <h6>
                                        <a href="javascript:void(0)">${stock.item.name}</a>
                                    </h6>

                                </div>
                                <div
                                    class="shopping-icon d-flex align-items-center justify-content-between">
                                    <h4>
                                        <button class="sellingPriceButton updateUnitPrice"
                                                data-filteritemid=${value}
                                                data-sellingprice="${stock.selling_price}"
                                                data-route="${stock.item_price_route}">${stock.selling_price} {{ $basic->currency_symbol }}</button>
                                    </h4>

                                    ${stock.quantity > 0 ? `<button class="btn btn-sm addToCartButton" data-property='${JSON.stringify(stock)}'><i class="fa fa-cart-plus"></i></button>` : `<button class="btn btn-sm addToCartButton opacity-0 disabled"><i class="fa fa-cart-plus"></i></button>`}
                            </div>
                            <p>
                                <span>Purchase Price:</span> ${stock.last_cost_per_unit} {{ $basic->currency_symbol }}
                            </p>
                        </div>
                    </div>
                </div>

`;
                        });
                    }

                    $('.pushItem').html(itemsData);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $('.select-customer').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedCustomer(selectedValue);
        });

        function getSelectedCustomer(value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('user.getSelectedCustomer') }}",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    let customer = response.customer;
                    $('.customerPhone').val(customer.phone);
                    $('.customerAddress').val(customer.address);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $('.selectSalesCenter').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedSalesCenter(selectedValue);
        });

        function getSelectedSalesCenter(value) {
            $.ajax({
                url: "{{ route('user.getSelectedSalesCenter') }}",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    let salesCenter = response.salesCenter;
                    $('.owner-name').val(salesCenter.owner_name);
                    $('.owner-phone').val(salesCenter.user.phone);
                    $('.sales-center-address').val(salesCenter.address);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $(document).on('click', '.addToCartButton', function () {
            let dataProperty = $(this).data('property');
            getAddToCartItems(dataProperty);
        });

        function getAddToCartItems(dataProperty) {
            $.ajax({
                url: "{{ route('user.storeCartItems') }}",
                method: 'POST',
                data: {
                    data: dataProperty,
                },
                success: function (response) {
                    if (response.status) {
                        Notiflix.Notify.Success(response.message);
                    } else {
                        Notiflix.Notify.Warning(response.message);
                    }

                    let cartItems = response.cartItems;
                    if (cartItems.length > 0) {
                        $('.cart-items-area').removeClass('d-none')
                    } else {
                        $('.cart-items-area').addClass('d-none')
                    }


                    let itemsData = '';

                    cartItems.forEach(function (cartItem) {
                        itemsData += `<div class="cat-item d-flex">
                        <div class="tittle">${cartItem.item.name}</div>
                        <input type="hidden" name="item_id[]" value="${cartItem.item.id}">
                        <input type="hidden" name="stock_id[]" value="${cartItem.stock_id}">
                        <input type="hidden" name="item_name[]" value="${cartItem.item.name}">
                        <div class="quantity">
                            <input type="number" name="item_quantity[]" value="${cartItem.quantity}"
                                   class="itemQuantityInput" data-cartitem="${cartItem.cost_per_unit}" data-stockid="${cartItem.stock_id}"
                                                           data-itemid="${cartItem.item_id}" min="1">
                        </div>
                        <input type="hidden" name="cost_per_unit[]"
                                                       value="${cartItem.cost_per_unit}">
                        <div class="prize">
                            <h6 class="cart-item-cost">${cartItem.cost} {{ $basic->currency_symbol }}</h6>
                            <input type="hidden" name="item_price[]" value="${cartItem.cost}" class="item_price_input">
                        </div>

                        <div class="remove">
                            <a href="javascript:void(0)" class="clearSingleCartItem" data-id="${cartItem.id}"
                               data-name="${cartItem.item.name}">
                               <i class="fa fa-times"></i></a>
                        </div>
                    </div>`;
                    });

                    $('.addCartItems').html(itemsData);

                    // Recalculate subtotal and total
                    updateSubtotal();
                    updateTotal();

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }


        function checkSalesBy() {
            var activeTab = $('#myTab li button.nav-link.active').attr('id');
            var activeDataBsTarget = $('#myTab li button.nav-link.active').attr('data-bs-target');

            let saleCenterId = $(activeDataBsTarget).children().find('.salesCenterId').val();

            if (activeTab == 'home-tab') {
                let customerId = $(activeDataBsTarget).children().find('.customerId').val();
                if (!saleCenterId) {
                    Notiflix.Notify.Failure('please select sales center');
                    return false;
                } else if (!customerId) {
                    Notiflix.Notify.Failure('please select customer');
                    return false;
                } else {
                    return true;
                }
            } else {

                if (!saleCenterId) {
                    Notiflix.Notify.Failure('please select sales center');
                    return false;
                } else {
                    return true;
                }

            }
        }


        $(document).on('click', '.proccedOrderBtn', function () {
            showProccedOrderModal();
        });

        function showProccedOrderModal() {
            let result = checkSalesBy();
            if (result) {
                var proccedOrderModal = new bootstrap.Modal(document.getElementById('proccedOrderModal'))
                proccedOrderModal.show();
            }

            var totalAmount = parseFloat($('.total-area').text().match(/[\d.]+/)[0]);
            $('.make-payment-total-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)
            $('.due-or-change-text').text('Due Amount');
            $('.due-or-change-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)
            $('.total-payable-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)

            $('.due_or_change_amount_input').val(`${totalAmount.toFixed(2)}`)
            $('.total_payable_amount_input').val(`${totalAmount.toFixed(2)}`)
        }

        $(document).on('keyup', '.customer-paid-amount', function () {
            var totalAmount = parseFloat($('.total-area').text().match(/[\d.]+/)[0]);
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


        $(document).on('click', '.updateUnitPrice', function () {
            var updateUnitPriceModal = new bootstrap.Modal(document.getElementById('updateUnitPriceModal'))
            updateUnitPriceModal.show();

            let dataRoute = $(this).data('route');
            let dataSellingPrice = $(this).data('sellingprice');
            let datafilteritemid = $(this).data('filteritemid');

            $('.updateItemUnitPriceRoute').attr('action', dataRoute)
            $('.selling_cost_per_unit').val(dataSellingPrice);
            $('.filter_item_id').val(datafilteritemid);

        });

        $(document).on('click', '.clearCart', function () {
            var clearCartModal = new bootstrap.Modal(document.getElementById('clearCartModal'))
            clearCartModal.show();
        });

        $(document).on('click', '.cancelOrder', function () {
            var cancelOrderModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'))
            cancelOrderModal.show();
        });


        $(document).on('click', '.clearSingleCartItem', function () {
            let cartId = $(this).data('id');
            $.ajax({
                url: "{{ route('user.clearSingleCartItem') }}",
                method: 'POST',
                data: {
                    cartId: cartId,
                },
                success: function (response) {
                    let cartItems = response.cartItems;
                    if (cartItems.length > 0) {
                        $('.cart-items-area').removeClass('d-none')
                    } else {
                        $('.cart-items-area').addClass('d-none')
                    }


                    let itemsData = '';

                    cartItems.forEach(function (cartItem) {
                        itemsData += `<div class="cat-item d-flex">
                        <div class="tittle">${cartItem.item.name}</div>
                         <input type="hidden" name="item_id[]" value="${cartItem.item.id}">
                         <input type="hidden" name="stock_id[]" value="${cartItem.stock_id}">
                        <input type="hidden" name="item_name[]" value="${cartItem.item.name}">
                        <div class="quantity">
                            <input type="number" name="item_quantity[]" value="${cartItem.quantity}"
                                   class="itemQuantityInput" data-cartitem="${cartItem.cost_per_unit}" min="1">
                        </div>
                        <input type="hidden" name="cost_per_unit[]"
                                                       value="${cartItem.cost_per_unit}">
                        <div class="prize">
                            <h6 class="cart-item-cost">${cartItem.cost} {{ $basic->currency_symbol }}</h6>
                            <input type="hidden" name="item_price[]" value="${cartItem.cost}" class="item_price_input">
                        </div>
                        <div class="remove">
                            <a href="javascript:void(0)" class="clearSingleCartItem" data-id="${cartItem.id}"
                        data-name="${cartItem.item.name}">
                               <i class="fa fa-times"></i></a>
                        </div>
                    </div>`;
                    });

                    $('.addCartItems').html(itemsData);
                    // Recalculate subtotal and total
                    updateSubtotal();
                    updateTotal();

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });

        });


        function updateSubtotal() {
            let subtotal = 0;
            $('.itemQuantityInput').each(function (index, element) {
                let cartQuantity = isNaN(parseFloat($(element).val())) ? 0 : parseFloat($(element).val());
                let costPerUnit = parseFloat($(element).data('cartitem'));
                subtotal += cartQuantity * costPerUnit;
            });

            $('.sub-total-area').text(`${subtotal.toFixed(2)} {{ $basic->currency_symbol }}`);
            $('.sub-total-input').val(`${subtotal.toFixed(2)}`);
            $('.sub-total-area-span').addClass('d-none');
        }

        function updateTotal() {
            let subTotal = parseFloat($('.sub-total-area').text());
            let discount = parseFloat($('.itemsDiscountInput').val());

            discount = isNaN(discount) ? 0 : discount;

            let discountAmount = subTotal * discount / 100;
            let totalAmount = subTotal - discountAmount;

            // Update the discount and total amounts
            $('.discount-area').text(`${discountAmount.toFixed(2)} {{ $basic->currency_symbol }}`);
            $('.discount-amount-input').val(`${discountAmount.toFixed(2)}`);
            $('.total-area').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`);
            $('.total-amount-input').val(`${totalAmount.toFixed(2)}`);
        }

        $(document).on('input', '.itemsDiscountInput', function () {
            // Recalculate total after updating the discount
            let discount = $(this).val();
            if (discount > 100) {
                Notiflix.Notify.Warning('Discount cannot exceed 100%');
                thisClass.attr('max', 100)
                return;
            }
            updateTotal();
        });


        $('.itemQuantityInput').each(function (index, element) {
            $(document).on('input', `.${element.className}`, function () {
                let thisClass = $(this);
                let cartQuantity = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
                let costPerUnit = parseFloat($(this).data('cartitem')).toFixed(2);
                let singleCartItemCost = cartQuantity * costPerUnit;
                $(this).parent().siblings('.prize').find('.cart-item-cost').text(`${singleCartItemCost.toFixed(2)} {{ $basic->currency_symbol }}`);
                $(this).parent().siblings('.prize').find('.item_price_input').val(`${singleCartItemCost.toFixed(2)}`);

                // Recalculate subtotal and total
                updateSubtotal();
                updateTotal();

                let stockId = $(this).data('stockid');
                let itemId = $(this).data('itemid');
                // update quantity and cost also cartItems table
                updateCartItem(stockId, itemId, cartQuantity, costPerUnit, singleCartItemCost, thisClass);

            })
        });

        $(document).on('input', '.itemQuantityInput', function () {
            $('.itemQuantityInput').each(function (index, element) {
                $(document).on('input', `.${element.className}`, function () {
                    let thisClass = $(this);
                    let cartQuantity = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
                    let costPerUnit = parseFloat($(this).data('cartitem')).toFixed(2);
                    let singleCartItemCost = cartQuantity * costPerUnit;
                    $(this).parent().siblings('.prize').find('.cart-item-cost').text(`${singleCartItemCost.toFixed(2)} {{ $basic->currency_symbol }}`);
                    $(this).parent().siblings('.prize').find('.item_price_input').val(`${singleCartItemCost.toFixed(2)}`);
                    // Recalculate subtotal and total
                    updateSubtotal();
                    updateTotal();

                    let stockId = $(this).data('stockid');
                    let itemId = $(this).data('itemid');
                    // update quantity and cost also cartItems table
                    updateCartItem(stockId, itemId, cartQuantity, costPerUnit, singleCartItemCost, thisClass);
                })
            });
        });

        function updateCartItem(stockId, itemId, cartQuantity, costPerUnit, singleCartItemCost, thisClass) {
            // update quantity and cost also cartItems table
            $.ajax({
                url: "{{ route('user.updateCartItems') }}",
                method: 'POST',
                data: {
                    stockId: stockId,
                    itemId: itemId,
                    cartQuantity: cartQuantity,
                    costPerUnit: costPerUnit,
                    singleCartItemCost: singleCartItemCost,
                },
                success: function (response) {
                    if (!response.status) {
                        thisClass.attr('max', response.stockQuantity)
                        thisClass.val(response.stockQuantity)

                        if (!response.status && canShowWarning) {
                            Notiflix.Notify.Warning(response.message);
                            canShowWarning = false;
                            setTimeout(() => {
                                canShowWarning = true;
                            }, 1000); // 1 seconds interval
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }


    </script>
@endpush
