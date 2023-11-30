@extends($theme.'layouts.user')
@section('title',trans('Sales Invoice'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"> @lang('Sales Invoice')</h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.salesList') }}">@lang('Sales List')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Sales Invoice')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="main row p-0">
            <div class="col-12">
                <div class="section-invoice section-1">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-box" id="salesInvoice">
                                    <div
                                        class="invoice-top d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="invoice-img">
                                            <img src="{{ asset('assets/global/img/invoice.png') }}" alt="">
                                            <h3>@lang('Invoice') - <span># {{ $singleSalesDetails->invoice_id }}</span>
                                            </h3>
                                            <h4>Date - <span> {{ customDate($singleSalesDetails->created_at) }}</span>
                                            </h4>

                                        </div>
                                        <div class="invoice-top-content">
                                            <h3>{{ optional($singleSalesDetails->company)->name }}</h3>
                                            <h5>{{ optional($singleSalesDetails->company)->address }}</h5>
                                            @if(optional($singleSalesDetails->company)->email)
                                                <h5>{{ optional($singleSalesDetails->company)->email }}</h5>
                                            @endif
                                            @if(optional($singleSalesDetails->company)->phone)
                                                <h5>{{ optional($singleSalesDetails->company)->phone }}</h5>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="invoice-date-box d-flex flex-wrap justify-content-between mt-5">
                                        @if($singleSalesDetails->customer_id)
                                            <div class="invoice-number">
                                                <h3 class="font-weight-bold">@lang('Bill To')</h3>
                                                <h4>{{ optional($singleSalesDetails->salesCenter)->name }}</h4>
                                                <h5>{{ optional($singleSalesDetails->salesCenter)->address }} {{ optional(optional($singleSalesDetails->salesCenter)->upazila)->name }}
                                                    , {{ optional(optional($singleSalesDetails->salesCenter)->district)->name }}</h5>
                                                @if(optional(optional($singleSalesDetails->salesCenter)->user)->email)
                                                    <h5>{{ optional(optional($singleSalesDetails->salesCenter)->user)->email }}</h5>
                                                @endif
                                                @if(optional(optional($singleSalesDetails->salesCenter)->user)->phone)
                                                    <h5>{{ optional(optional($singleSalesDetails->salesCenter)->user)->phone }}</h5>
                                                @endif
                                            </div>
                                        @else
                                            <div class="invoice-number">
                                                <h3 class="font-weight-bold">@lang('Bill To')</h3>
                                                <h4>{{ optional($singleSalesDetails->company)->name }}</h4>
                                                <h5>{{ optional($singleSalesDetails->company)->address }}</h5>
                                                @if(optional($singleSalesDetails->company)->email)
                                                    <h5>{{ optional($singleSalesDetails->company)->email }}</h5>
                                                @endif
                                                @if(optional($singleSalesDetails->company)->phone)
                                                    <h5>{{ optional($singleSalesDetails->company)->phone }}</h5>
                                                @endif
                                            </div>
                                        @endif

                                        @if($singleSalesDetails->customer_id)
                                            <div class="invoice-id">
                                                <h3 class="font-weight-bold">@lang('Invoiced To')</h3>
                                                <h4>{{ optional($singleSalesDetails->customer)->name }}</h4>
                                                <h5>{{ optional($singleSalesDetails->customer)->address }} {{ optional(optional($singleSalesDetails->customer)->upazila)->name }}
                                                    , {{ optional(optional($singleSalesDetails->customer)->district)->name }}</h5>
                                                @if(optional($singleSalesDetails->customer)->phone)
                                                    <h5>{{ optional($singleSalesDetails->customer)->phone }}</h5>
                                                @endif
                                                @if(optional($singleSalesDetails->customer)->email)
                                                    <h5>{{ optional($singleSalesDetails->customer)->email }}</h5>
                                                @endif
                                            </div>
                                        @else
                                            <div class="invoice-id">
                                                <h3 class="font-weight-bold">@lang('Invoiced To')</h3>
                                                <h4>{{ optional($singleSalesDetails->salesCenter)->name }}</h4>
                                                <h5>{{ optional($singleSalesDetails->salesCenter)->address }} {{ optional(optional($singleSalesDetails->salesCenter)->upazila)->name }}
                                                    , {{ optional(optional($singleSalesDetails->salesCenter)->district)->name }}</h5>
                                                @if(optional(optional($singleSalesDetails->salesCenter)->user)->email)
                                                    <h5>{{ optional(optional($singleSalesDetails->salesCenter)->user)->email }}</h5>
                                                @endif
                                                @if(optional(optional($singleSalesDetails->salesCenter)->user)->phone)
                                                    <h5>{{ optional(optional($singleSalesDetails->salesCenter)->user)->phone }}</h5>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="invoice-table">

                                        <table class="table table-hover">
                                            <thead>
                                            <th scope="col">@lang('item')</th>
                                            <th scope="col">@lang('quantity')</th>
                                            <th scope="col">@lang('Price')</th>
                                            </thead>
                                            <tbody>
                                            @foreach($singleSalesDetails->items as $key => $item)
                                                <tr>
                                                    <td>{{ $item['item_name'] }}</td>
                                                    <td>{{ $item['item_quantity'] }}</td>
                                                    <td>{{ $item['item_price'] }} {{ $basic->currency_symbol }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="note-box d-flex align-items-center justify-content-between">
                                        <div class="invoice-note">
                                            <h4>@lang('Subtotal')
                                                <span>{{ $singleSalesDetails->sub_total }} {{ $basic->currency_symbol }}</span>
                                            </h4>
                                            <h4>@lang('Discount')
                                                <span>{{ $singleSalesDetails->discount }} {{ $basic->currency_symbol }}</span>
                                            </h4>
                                            <h4>@lang('Payable')
                                                <span>{{ $singleSalesDetails->total_amount }} {{ $basic->currency_symbol }}</span>
                                            </h4>
                                            @if($singleSalesDetails->payment_status == 0)
                                                <h4>@lang('Due Amount')
                                                    <span>{{ $singleSalesDetails->due_amount }} {{ $basic->currency_symbol }}</span>
                                                </h4>
                                            @endif
                                        </div>

                                        <div class="invoice-total">
                                            <h3>@lang('You Paid')</h3>
                                            @if($singleSalesDetails->payment_status == 0)
                                                <h1>{{ $singleSalesDetails->customer_paid_amount }} {{ $basic->currency_symbol }}</h1>
                                            @else
                                                <h1>{{ $singleSalesDetails->total_amount }} {{ $basic->currency_symbol }}</h1>
                                            @endif

                                        </div>
                                    </div>


                                </div>

                                <div class="invoice-btn clearfix text-end">
                                    <a class="float-right" href="javascript:void(0)" id="salesInvoicePrint"><i
                                            class="fas fa-print"></i> @lang('Print') </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>
        'use strict'
        $(document).on('click', '#salesInvoicePrint', function () {
            let allContents = document.getElementById('body').innerHTML;
            let printContents = document.getElementById('salesInvoice').innerHTML;
            document.getElementById('body').innerHTML = printContents;
            window.print();
            document.getElementById('body').innerHTML = allContents;
        })

    </script>

@endpush
