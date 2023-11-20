@extends($theme.'layouts.user')
@section('title',trans('Item Stock Details'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1">@lang('Item Stock Details')</h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Item Stock Details')</li>
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
                                        <a href="{{ route('user.stockList') }}"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> @lang('Back') </span>
                                        </a>
                                    </div>

                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Stock Date')
                                                            : </h6>
                                                        <p>{{ dateTime(customDate($singleStock->stock_date)) }}</p>
                                                    </div>
                                                </div>

                                                @if($singleStock->items != null)
                                                    <ul class="list-style-none p-0 stock_list_style">
                                                        <li class="my-3">
                                                        <span class="custom-text">
                                                            <i class="far fa-check-circle mr-2 text-success"
                                                               aria-hidden="true"></i>
                                                            @lang('Item Details')
                                                        </span>
                                                        </li>

                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Item</th>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Cost</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @php
                                                                $totalItemCost = 0;
                                                            @endphp

                                                            @foreach($singleStock->items as $item)
                                                                <tr>
                                                                    <td data-label="Item">{{ $singleStock->item($item['item_id'])->name  }}</td>
                                                                    <td data-label="Quantity">{{ $item['item_quantity'] }} {{ $basic->currency_symbol }}</td>
                                                                    <td data-label="Cost">{{ $item['item_total_cost']}} {{ $basic->currency_symbol }}</td>
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td colspan="2" class="text-right">Total Price</td>
                                                                <td>{{ $singleStock->sub_total }} {{ $basic->currency_symbol }}</td>
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
@endsection
