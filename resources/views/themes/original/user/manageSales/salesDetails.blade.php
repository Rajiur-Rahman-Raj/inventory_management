@extends($theme.'layouts.user')
@section('title',trans('Sales Details'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1">{{ snake2Title(optional($singleSalesDetails->salesCenter)->name) }} @lang('Sales Details')</h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.salesList') }}">@lang('Sales List')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Sales Details')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="main row p-0">
            <div class="col-12">
                <div class="view-property-details">
                    <div class="row ms-2 me-2">
                        <div class="col-md-12 p-0">
                            <div class="card investment-details-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end investment__block">
                                        @if($singleSalesDetails->payment_status != 1)
                                            <a href="javascript:void(0)"
                                               class="btn btn-sm btn-primary text-white me-2 invest-details-back paidDueAmountBtn" data-route="{{ route('user.salesOrderUpdate', $singleSalesDetails->id) }}" data-property="{{ $singleSalesDetails }}">
                                                <span> @lang('Paid Due Amount') </span>
                                            </a>
                                        @endif
                                        <a href="{{ route('user.salesList') }}"
                                           class="btn btn-sm bgPrimary text-white invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> @lang('Back') </span>
                                        </a>
                                    </div>

                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    @if($singleSalesDetails->customer)
                                                        <div class="investmentDate d-flex justify-content-between">
                                                            <h6 class="font-weight-bold text-dark"><i
                                                                    class="fal fa-user me-2 text-primary"></i> @lang('Sales To Customer')
                                                                : </h6>
                                                            <p>{{ optional($singleSalesDetails->customer)->name }}</p>
                                                        </div>
                                                    @endif

                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-success"></i> @lang('Sales Date')
                                                            : </h6>
                                                        <p>{{ dateTime(customDate($singleSalesDetails->created_at)) }}</p>
                                                    </div>
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="fa fa-bangladeshi-taka-sign me-2 text-warning">
                                                                ৳ </i> @lang('Last Payment Date')
                                                            : </h6>
                                                        <p>{{ dateTime(customDate($singleSalesDetails->payment_date)) }}</p>
                                                    </div>
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"> @if($singleSalesDetails->payment_status == 1)
                                                                <i class="fal fa-check-double me-2 text-success"></i>
                                                            @else
                                                                <i class="fal fa-times me-2 text-danger"></i>
                                                            @endif  @lang('Payment Status')
                                                            : </h6>
                                                        @if($singleSalesDetails->payment_status == 1)
                                                            <p><span class="badge bg-success">@lang('Paid')</span></p>
                                                        @else
                                                            <p><span class="badge bg-warning">@lang('Due')</span></p>
                                                        @endif

                                                    </div>
                                                </div>

                                                <ul class="list-style-none p-0 stock_list_style">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Item</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Cost</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($singleSalesDetails->items as $key => $item)
                                                            <tr>
                                                                <td data-label="Item">{{ ucwords($item['item_name']) }}</td>
                                                                <td data-label="Quantity">{{ $item['item_quantity'] }}</td>
                                                                <td data-label="Cost">{{ $item['item_price'] }} {{ $basic->currency_symbol }}</td>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td colspan="2"
                                                                class="text-right font-weight-bold">@lang('Total Amount')</td>
                                                            <td class="font-weight-bold">
                                                                = {{ $singleSalesDetails->sub_total }} {{ $basic->currency_symbol }}</td>

                                                        </tr>

                                                        <tr>
                                                            <td colspan="2"
                                                                class="text-right font-weight-bold">@lang('Discount')</td>
                                                            <td class="font-weight-bold">
                                                                = {{ $singleSalesDetails->discount }} {{ $basic->currency_symbol }}</td>

                                                        </tr>

                                                        <tr>
                                                            <td colspan="2"
                                                                class="text-right font-weight-bold"> {{ $singleSalesDetails->payment_status == 1 ? 'Paid Amount' : 'Payable Amount' }}</td>
                                                            <td class="font-weight-bold">
                                                                = {{ $singleSalesDetails->total_amount }} {{ $basic->currency_symbol }}</td>
                                                        </tr>

                                                        @if($singleSalesDetails->payment_status == 0)
                                                            <tr>
                                                                <td colspan="2"
                                                                    class="text-right font-weight-bold">@lang('Customer Paid')</td>
                                                                <td class="font-weight-bold">
                                                                    = {{ $singleSalesDetails->customer_paid_amount }} {{ $basic->currency_symbol }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2"
                                                                    class="text-right font-weight-bold">@lang('Due Amount')</td>
                                                                <td class="font-weight-bold">
                                                                    = {{ $singleSalesDetails->due_amount }} {{ $basic->currency_symbol }}
                                                                </td>
                                                            </tr>

                                                        @endif

                                                        </tbody>
                                                    </table>

                                                </ul>

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
    </div>


    <div class="procced-modal">
        <div class="modal fade" id="paidDueAmountModal" tabindex="-1"
             aria-labelledby="proccedOrderModal" aria-hidden="true">
            <div class="modal-dialog ">
                <form action="" method="post" class="paidDueAmountRoute">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5"
                                id="exampleModalLabel">@lang('Make Payment Due Amount')</h1>
                            <button type="button" class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div
                                class="total-amount d-flex align-items-center justify-content-between">
                                <h5>@lang('Total Due Amount')</h5>
                                <h6 class="total-due-amount"></h6>
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
                                    <input type="date" name="payment_date"
                                           placeholder="@lang('payment date')"
                                           class="form-control payment_date"
                                           value="{{ old('payment_date',request()->payment_date) }}" required>
                                    <div class="invalid-feedback d-block">
                                        @error('payment_date') @lang($message) @enderror
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
                                    class="btn btn-primary">@lang('Confirm')
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>
        'use strict'
        $(document).on('click', '.paidDueAmountBtn', function () {
            var paidDueAmountModal = new bootstrap.Modal(document.getElementById('paidDueAmountModal'))
            paidDueAmountModal.show();

            let dataRoute = $(this).data('route');
            $('.paidDueAmountRoute').attr('action', dataRoute)

            let dataProperty = $(this).data('property');
            $('.total-due-amount').text(`${dataProperty.due_amount} {{ $basic->currency_symbol }}`);

            $('.due-or-change-text').text('Due Amount');
            $('.due-or-change-amount').text(`${dataProperty.due_amount} {{ $basic->currency_symbol }}`)
            $('.total-payable-amount').text(`${dataProperty.due_amount} {{ $basic->currency_symbol }}`)

            $('.due_or_change_amount_input').val(`${dataProperty.due_amount}`)
            $('.total_payable_amount_input').val(`${dataProperty.due_amount}`)

        });


        $(document).on('keyup', '.customer-paid-amount', function () {
            var totalAmount = parseFloat($('.total-due-amount').text().match(/[\d.]+/)[0]);
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
                $('.due-or-change-amount').text(`${dueOrChangeAmount.toFixed(2)} {{ $basic->currency_symbol }}`)
                $('.total-payable-amount').text(`${totalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${totalAmount.toFixed(2)}`)
            }
        });

    </script>
@endpush
