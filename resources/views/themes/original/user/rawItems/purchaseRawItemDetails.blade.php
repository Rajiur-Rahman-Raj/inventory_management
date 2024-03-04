@extends($theme.'layouts.user')
@section('title',trans('Purchased Raw Item Details'))
@section('content')
    @push('style')
        <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('user.purchaseRawItemList') }}">@lang('Purchase List')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Details')</li>
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
                                        @if($singlePurchaseItem->payment_status != 1)
                                            <a href="javascript:void(0)"
                                               class="btn btn-sm btn-primary text-white me-2 invest-details-back paidDueAmountBtn"
                                               data-route="{{ route('user.purchaseRawItemDueAmountUpdate', $singlePurchaseItem->id) }}"
                                               data-property="{{ $singlePurchaseItem }}">
                                                <span> @lang('Pay Due Amount') </span>
                                            </a>
                                        @endif
                                        <a href="{{ route('user.purchaseRawItemList') }}"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> @lang('Back') </span>
                                        </a>
                                    </div>

                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="fal fa-user me-2 text-info"></i> @lang('Purchased From: ')
                                                        </h6>
                                                        <h6 class="ms-2">{{ optional($singlePurchaseItem->supplier)->name }}</h6>
                                                    </div>

                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Purchased Date: ')
                                                        </h6>
                                                        <h6 class="ms-2">{{ dateTime(customDate($singlePurchaseItem->purchase_date)) }}</h6>
                                                    </div>

                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"> @if($singlePurchaseItem->payment_status == 1)
                                                                <i class="fal fa-check-double me-2 text-success"></i>
                                                            @else
                                                                <i class="fal fa-money-check-alt text-success"></i>
                                                            @endif  @lang('Payment Status')
                                                            : </h6>
                                                        @if($singlePurchaseItem->payment_status == 1)
                                                            <h6 class="ms-2"><span
                                                                    class="badge bg-success">@lang('Paid')</span></h6>
                                                        @else
                                                            <h6 class="ms-2"><span
                                                                    class="badge bg-warning">@lang('Due')</span></h6>
                                                        @endif
                                                    </div>

                                                </div>

                                                @if(count($singlePurchaseItemDetails) > 0)
                                                    <ul class="list-style-none p-0 stock_list_style">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">@lang('Item')</th>
                                                                <th scope="col">@lang('Quantity')</th>
                                                                <th scope="col">@lang('Cost Per Unit')</th>
                                                                <th scope="col">@lang('Total Unit Cost')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @foreach($singlePurchaseItemDetails as $key => $purchaseInDetail)
                                                                <tr>
                                                                    <td data-label="Quantity">{{ optional($purchaseInDetail->rawItem)->name }}</td>
                                                                    <td data-label="Quantity">{{ $purchaseInDetail->quantity }}</td>
                                                                    <td data-label="Cost Per Unit">{{ $purchaseInDetail->cost_per_unit }} {{ $basic->currency_symbol }}</td>
                                                                    <td data-label="Total Unit Cost">{{ $purchaseInDetail->total_unit_cost }} {{ $basic->currency_symbol }}</td>
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td colspan="3"
                                                                    class="text-right">@lang('Total Price')</td>
                                                                <td>
                                                                    = {{ $totalItemCost }} {{ $basic->currency_symbol }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </ul>
                                                @endif
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

    <!-- Modal -->
    <div class="procced-modal">
        <div class="modal fade" id="paidDueAmountModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog ">
                <form action="" method="post" class="paidDueAmountRoute">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Make Payment')</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="total-amount d-flex align-items-center justify-content-between">
                                <h5>@lang('Total Due Amount')</h5>
                                <h6 class="total-due-amount"></h6>
                            </div>

                            <div class="enter-amount d-flex justify-content-between align-items-center">
                                <h6>@lang('Discount Amount')</h6>
                                <div class="input-group d-flex ">
                                    <input type="text" name="discount_amount" value="0" min="0"  class="form-control bg-white text-dark discount-amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                </div>
                            </div>

                            <div class="enter-amount d-flex justify-content-between align-items-center">
                                <h6>@lang('Paid Amount')</h6>
                                <div class="input-group d-flex ">
                                    <input type="text" class="form-control paid-amount" value="0" min="0"
                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                           id="exampleFormControlInput1" name="paid_amount">
                                </div>

                            </div>

                            <div class="change-amount d-flex align-items-center justify-content-between">
                                <h4 class="m-2 due-or-change-text">Due Amount</h4>  <span
                                    class="due-or-change-amount"></span>
                                <input type="hidden" name="due_or_change_amount" class="due_or_change_amount_input"
                                       value="">
                            </div>
                            <div class="total-amount d-flex align-items-center justify-content-between">
                                <h5>Total Payable Amount</h5>
                                <h6 class="total-payable-amount"></h6>
                                <input type="hidden" name="total_payable_amount" class="total_payable_amount_input"
                                       value="">
                            </div>
                            <div class="file">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Payment
                                        Date</label>
                                    <div class="flatpickr">
                                        <div class="input-group">
                                            <input type="hidden" placeholder="Select Payment Date"
                                                   class="form-control payment_date flatpickr-input" name="payment_date"
                                                   value="" data-input="">
                                            <div class="input-group-append" readonly="">
                                                <div class="form-control payment-date-times">
                                                    <a class="input-button cursor-pointer" title="clear" data-clear="">
                                                        <i class="fas fa-times" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback d-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">@lang('Note')
                                        <span><sub>(optional)</sub></span></label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                              placeholder="Details note write here" rows="4" name="note"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>

    @if($errors->has('payment_date'))
        <script>
            var myModal = new bootstrap.Modal(document.getElementById("paidDueAmountModal"), {});
            document.onreadystatechange = function () {
                myModal.show();
                payDueAmountPaymentModal();
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

        $(document).on('click', '.paidDueAmountBtn', function () {
            payDueAmountPaymentModal();
        });

        function payDueAmountPaymentModal(_this) {
            var paidDueAmountModal = new bootstrap.Modal(document.getElementById('paidDueAmountModal'));
            paidDueAmountModal.show();

            let dataRoute = $('.paidDueAmountBtn').data('route');
            $('.paidDueAmountRoute').attr('action', dataRoute)

            let dataProperty = $('.paidDueAmountBtn').data('property');
            $('.total-due-amount').text(`${dataProperty.due_amount} {{ $basic->currency_symbol }}`);

            $('.due-or-change-text').text('Due Amount');
            $('.due-or-change-amount').text(`${dataProperty.due_amount} {{ $basic->currency_symbol }}`)
            $('.total-payable-amount').text(`${dataProperty.due_amount} {{ $basic->currency_symbol }}`)

            $('.due_or_change_amount_input').val(`${dataProperty.due_amount}`)
            $('.total_payable_amount_input').val(`${dataProperty.due_amount}`)
        }


        $(document).on('keyup', '.paid-amount', function () {
            makeDuePaymentCal();
        });

        function makeDuePaymentCal(_this){
            let totalAmount = parseFloat($('.total-due-amount').text().match(/[\d.]+/)[0]);
            var discountAmount = isNaN(parseFloat($('.discount-amount').val())) ? 0 : parseFloat($('.discount-amount').val());
            let customerPaidAmount = isNaN(parseFloat($('.paid-amount').val())) ? 0 : parseFloat($('.paid-amount').val());


            if(discountAmount > totalAmount){
                Notiflix.Notify.warning('Discount amount can not exceed the total due amount');
                $(this).val(totalAmount);
            }

            let newTotalAmount = totalAmount - discountAmount;

            let dueOrChangeAmount = newTotalAmount - customerPaidAmount;

            if (dueOrChangeAmount >= 0) {
                $('.due-or-change-text').text('Due Amount')
                $('.due-or-change-amount').text(`${dueOrChangeAmount.toFixed(2)} {{ $basic->currency_symbol }}`)
                $('.total-payable-amount').text(`${customerPaidAmount.toFixed(2)} {{ $basic->currency_symbol }}`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${customerPaidAmount.toFixed(2)}`)

            } else {
                $('.due-or-change-text').text('Change Amount')
                $('.due-or-change-amount').text(`${Math.abs(dueOrChangeAmount).toFixed(2)} {{ $basic->currency_symbol }}`)
                $('.total-payable-amount').text(`${newTotalAmount.toFixed(2)} {{ $basic->currency_symbol }}`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${newTotalAmount.toFixed(2)}`)
            }
        }


        $(document).on('keyup', '.discount-amount', function (){
            makeDuePaymentCal();
        });


    </script>

@endpush
