@extends($theme.'layouts.user')
@section('title', 'Manage Sales Return')

@push('style')
    <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    <section class="pos-section section-1 profile-setting">
        <div class="container-fluid ">
            <div class="row main">
                <div class="col-xl-8 col-lg-8">
                    <div class="product-bg">.
                        <form>
                            <div class="row g-2 align-items-center">

                                <div class="col-md-6 filter_by_sales_order">
                                    <div class="product-top d-flex align-items-center flex-wrap ">
                                        <div class="input-group">
                                            <label for="" class="mb-2">@lang('Filter By Sales/Order')</label>
                                            <select class="form-select js-example-basic-single selected_sales_or_order"
                                                    name="sales_or_order"
                                                    aria-label="Default select example">
                                                <option value="order">@lang('Order Items')</option>
                                                <option value="sales">@lang('Sales Items')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 search_by_invoice_id">
                                    <div class="product-top">
                                        <div class="input-box">
                                            <label for="" class="mb-2">@lang('Search By Invoice Id')</label>
                                            <input type="text" class="form-control invoice_id" name="invoice_id"
                                                   placeholder="Invoice Id">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 d-none filter_by_items">
                                    <div class="product-top d-flex align-items-center flex-wrap ">
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
                        </form>

                        <div class="row pushSales">
                            @if(count($sales) > 0)
                                @foreach($sales as $sale)
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="product-box shadow-sm p-3 mb-5 bg-body rounded">
                                            <div class="product-title d-flex justify-content-between">
                                                @if($sale->payment_status == 1)
                                                    <a type="button" class="btn">
                                                        <span class="badge bg-success">@lang('Paid')</span>
                                                    </a>
                                                @else
                                                    <a type="button" class="btn border-warning">
                                                        <span class="badge bg-warning">@lang('Due')</span>
                                                    </a>
                                                @endif
                                                <a type="button" class="btn">
                                                    <span class="badge bg-primary"> {{ $sale->invoice_id }}</span>
                                                </a>
                                            </div>
                                            <div class="product-img">
                                                <a href="javascript:void(0)">
                                                    <img class="img-fluid"
                                                         src="{{ getFile(config('location.salesCenter.path').optional($sale->salesCenter)->image) }}"
                                                         alt="" style="height: 200px">
                                                </a>
                                            </div>
                                            <div class="product-content-box ">
                                                <div class="product-content">
                                                    <h6>
                                                        <a href="javascript:void(0)">@lang(optional($sale->salesCenter)->name)</a>
                                                    </h6>
                                                </div>

                                                <div
                                                    class="shopping-icon d-flex align-items-center justify-content-between">
                                                    <h4>
                                                        <button class="sellingPriceButton updateUnitPrice"
                                                                data-sellingprice=""
                                                                data-route="">{{ $sale->total_amount }} {{ $basic->currency_symbol }}</button>
                                                    </h4>
                                                    <button class="btn btn-sm returnOrderDetails"
                                                            data-property="{{ $sale }}"
                                                            data-route="{{ route('user.salesInvoiceUpdate', $sale->id) }}">
                                                        <i class="far fa-eye"></i></button>
                                                </div>
                                                <p class="mt-2">
                                                    <span>@lang('Order Date'):</span> {{ customDate($sale->created_at) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @else
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('assets/global/img/no_data.gif') }}"
                                         class="card-img-top empty-state-img" alt="...">
                                </div>
                            @endif
                        </div>

                    </div>
                </div>


                <div class="col-xl-4 col-lg-4">
                    <form action="" method="post" enctype="multipart/form-data" class="salesOrderUpdateForm">
                        @csrf
                        @method('put')
                        <div class="tab-tille">
                            <h4>@lang('Return by')</h4>
                        </div>

                        <div class="cart-side d-none">
                            <div class="tab-box">
                                <div class="description-content mt-2">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                             aria-labelledby="home-tab" tabindex="0">

                                            <div class="input-box mt-3">
                                                <label for="sales_center_id" class="mb-2">@lang('Sales Center?')</label>
                                                <input type="text" class="form-control salesCenterName"
                                                       name="sales_center_name"
                                                       value="{{ old('sales_center_name', @request()->sales_center_name) }}"
                                                       readonly>
                                            </div>

                                            <div class="customerField d-none">
                                                <div class="input-box mt-3">
                                                    <label for="customer_name" class="mb-2">@lang('Customer')</label>
                                                    <input type="text" class="form-control customerName"
                                                           name="customer_name"
                                                           value="{{ old('customer_name', @request()->customer_name) }}"
                                                           readonly>
                                                </div>

                                                <div class="input-box mt-3">
                                                    <input type="text" class="form-control customerPhone"
                                                           name="customer_phone" placeholder="Customer Phone"
                                                           value="{{ old('customer_phone', @request()->customer_phone) }}"
                                                           readonly>
                                                </div>

                                                <div class="input-box col-12 mt-3">
                                                    <textarea readonly class="form-control customerAddress" cols="10"
                                                              rows="2" placeholder="Customer Address"
                                                              name="customer_address"
                                                              spellcheck="false">{{ old('customer_address', @request()->customer_address) }}</textarea>
                                                </div>
                                            </div>

                                            <div class="ownerField d-none">
                                                <div class="input-box mt-3">
                                                    <input type="text" class="form-control ownerName" name="owner_name"
                                                           value="{{ old('owner_name', @request()->owner_name) }}"
                                                           readonly>
                                                </div>

                                                <div class="input-box mt-3">
                                                    <input type="text" class="form-control ownerPhone"
                                                           name="owner_phone"
                                                           value="{{ old('owner_phone', @request()->owner_phone) }}"
                                                           readonly>
                                                </div>

                                                <div class="input-box col-12 mt-3">
                                                    <textarea readonly class="form-control ownerAddress" cols="10"
                                                              rows="2" name="owner_address"
                                                              spellcheck="false">{{ old('owner_address', @request()->owner_address) }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="cart-items-area">
                                <div class="cart-box">
                                    <div class="cart-top d-flex align-items-center justify-content-between">
                                        <h6>items in cart</h6>
                                        <button type="button" class="btn clearCart">
                                            <i class="fa fa-times"></i>clear cart
                                        </button>
                                    </div>

                                    <div class="addCartItems">

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

                                        <div class="dueInvoiceField">
                                            <div class="total-amount d-flex align-items-center justify-content-between">
                                                <h5>Previous Paid</h5>
                                                <h6 class="previous-paid-area"></h6>
                                                <input type="hidden" name="previous_paid" class="previous-amount-input"
                                                       value="">
                                            </div>
                                        </div>

                                        <div class="order-btn d-flex flex-wrap">
                                            <button class="cancel cancelOrder" type="button">cancel order</button>
                                            <button type="button" class="porcced proccedOrderBtn">procced order
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
                                                                        {{--                                                                        <input type="date" name="payment_date"--}}
                                                                        {{--                                                                               placeholder="@lang('payment date')"--}}
                                                                        {{--                                                                               class="form-control payment_date"--}}
                                                                        {{--                                                                               value="{{ old('payment_date',request()->payment_date) }}">--}}
                                                                        {{--                                                                        <div class="invalid-feedback d-block">--}}
                                                                        {{--                                                                            @error('payment_date') @lang($message) @enderror--}}
                                                                        {{--                                                                        </div>--}}

                                                                        <div class="flatpickr">
                                                                            <div class="input-group">
                                                                                <input type="date"
                                                                                       placeholder="@lang('Select Payment Date')"
                                                                                       class="form-control payment_date"
                                                                                       name="payment_date"
                                                                                       value="{{ old('payment_date',request()->shipment_date) }}"
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
                                                                            <span><sup>(@lang('optional'))</sup></span></label>
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
                                                                        class="btn btn-primary">@lang('Confirm Return')
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
                    pushStockItems(response);
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
            // let result = checkSalesBy();
            // if (result) {
            var proccedOrderModal = new bootstrap.Modal(document.getElementById('proccedOrderModal'))
            proccedOrderModal.show();
            // }

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
                url: "{{ route('user.clearSingleReturnCartItem') }}",
                method: 'POST',
                data: {
                    cartId: cartId,
                },
                success: function (response) {
                    console.log(response);
                    return;
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
                        Notiflix.Notify.Warning(response.message);
                        thisClass.attr('max', response.stockQuantity)
                        thisClass.val(response.stockQuantity)

                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }


        //  new js start
        $(document).on('change', '.selected_sales_or_order', function () {
            let selectedValue = $(this).val();

            if (selectedValue == 'sales') {
                $('.filter_by_items').removeClass('d-none');
                $('.search_by_invoice_id').addClass('d-none');
                $('.filter_by_sales_order').removeClass('col-md-12');
                $('.filter_by_sales_order').addClass('col-md-6');
            } else {
                $('.filter_by_items').addClass('d-none');
                $('.search_by_invoice_id').removeClass('d-none');
                $('.filter_by_sales_order').removeClass('col-md-6');
                $('.filter_by_sales_order').addClass('col-md-6');
            }

            $.ajax({
                url: "{{ route('user.getSelectedSalesOrOrder') }}",
                method: 'POST',
                data: {
                    salesOrOrderValue: selectedValue,
                },
                success: function (response) {

                    if (response.status == 'stocks') {
                        pushStockItems(response);
                    } else {
                        pushSalesReturn(response);
                    }

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });

        })


        function pushStockItems(response) {

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

            $('.pushSales').html(itemsData);
        }


        function pushSalesReturn(response) {

            let sales = response.sales;

            let salesData = '';

            if (sales.length === 0) {
                salesData = `<div class="col-md-12 d-flex justify-content-center">
                                        <img src="{{ asset('assets/global/img/no_data.gif') }}" class="card-img-top empty-state-img" alt="..." style="width: 300px">
                                    </div>`
            } else {


                sales.forEach(function (sale) {
                    salesData += `<div class="col-xl-4 col-lg-6">
                                        <div class="product-box shadow-sm p-3 mb-5 bg-body rounded">
                                            <div class="product-title d-flex justify-content-between">
                                             ${sale.payment_status == 1 ? '<a type="button" class="btn"><span class="badge bg-success">' + 'Payment Complete' + '</span></a>' : '<a type="button"  class="btn border-warning"><span class="badge bg-warning">Due Payment</span></a>'}
                                                <a type="button" class="btn">
                                                        <span class="badge bg-primary"> ${sale.invoice_id}</span>
                                                    </a>
                                            </div>
                                            <div class="product-img">
                                                <a href="javascript:void(0)">
                                                    <img class="img-fluid" src="${sale.sales_center.image}"
                                                             alt="" style="height: 200px">
                                                </a>
                                            </div>
                                            <div class="product-content-box ">
                                                 <div class="product-content">
                                                     <h6>
                                                        <a href="javascript:void(0)"> ${sale.sales_center.name} </a>
                                                     </h6>
                                                 </div>

                                                <div class="shopping-icon d-flex align-items-center justify-content-between">
                                                    <h4>
                                                        <button class="sellingPriceButton updateUnitPrice"
                                                                data-sellingprice=""
                                                                data-route="">${sale.total_amount} {{ $basic->currency_symbol }}
                    </button>
                </h4>
                <button class="btn btn-sm addToCartButton" data-property=""><i class="far fa-eye"></i></button>
            </div>
            <p class="mt-2"> <span>@lang('Order Date'):</span> ${sale.order_date} </p>
                                                </div>
                                            </div>
                                        </div>`
                })


            }

            $('.pushSales').html(salesData);
        }


        $(document).on('input', '.invoice_id', function () {
            let invoiceId = $(this).val();
            getSingleSalesOrder(invoiceId);
        });

        function getSingleSalesOrder(invoiceId) {
            $.ajax({
                url: "{{ route('user.getSingleSalesOrder') }}",
                method: 'POST',
                data: {
                    invoiceId: invoiceId,
                },
                success: function (response) {
                    pushSalesReturn(response);

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }


        $(document).on('click', '.returnOrderDetails', function () {
            let _this = $(this);
            let route = $(this).data('route');
            $('.salesOrderUpdateForm').attr('action', route);
            $.ajax({
                url: "{{ route('user.clearSaleCartItems') }}",
                method: 'POST',
                success: function (response) {
                    showReturnOrderDetails(_this);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });

        function showReturnOrderDetails(_this) {
            let dataProperty = _this.data('property');
            let cartItems = dataProperty.sales_items;
            $('.cart-side').removeClass('d-none');
            $('.salesCenterName').val(dataProperty.sales_center.name);


            if (dataProperty.customer) {
                $('.customerField').removeClass('d-none');
                $('.ownerField').addClass('d-none');
                $('.customerName').val(dataProperty.customer.name);
                $('.customerPhone').val(dataProperty.customer.phone);
                $('.customerAddress').val(dataProperty.customer.address);
            } else {
                $('.ownerField').removeClass('d-none');
                $('.customerField').addClass('d-none');
                $('.ownerName').val(dataProperty.sales_center.owner_name);
                $('.ownerPhone').val(dataProperty.sales_center.user.phone);
                $('.ownerAddress').val(dataProperty.sales_center.address);
            }

            if (dataProperty.payment_status == 1) {
                $('.dueInvoiceField').addClass('d-none');
            } else {
                $('.dueInvoiceField').removeClass('d-none');
                $('.previous-paid-area').text(`${dataProperty.customer_paid_amount} {{ $basic->currency_symbol }}`)
                $('.previous-amount-input').val(`${dataProperty.customer_paid_amount}`);
            }

            $('.itemsDiscountInput').val(dataProperty.discount_parcent);

            storeSalesItemToCart(cartItems, dataProperty.id);
        }


        function storeSalesItemToCart(cartItems, salesId = null) {

            cartItems.forEach(function (salesItem) {
                $.ajax({
                    url: "{{ route('user.storeSalesCartItems') }}",
                    method: 'POST',
                    data: {
                        data: salesItem,
                        salesId: salesId,
                    },
                    success: function (response) {
                        let cartItems = response.cartItems;

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
            });
        }
    </script>
@endpush

