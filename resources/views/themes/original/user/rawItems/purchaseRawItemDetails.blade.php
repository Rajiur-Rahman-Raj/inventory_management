@extends($theme.'layouts.user')
@section('title',trans('Purchased Raw Item Details'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1">{{ snake2Title($rawItem) }} @lang('Purchase Details')</h4>
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
                                        <a href="{{ route('user.purchaseRawItemList') }}"
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
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Last Purchased Date')
                                                            : </h6>
                                                        <p>{{ dateTime(customDate($singlePurchaseItem->last_purchase_date)) }}</p>
                                                    </div>
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Purchased From')
                                                            : </h6>
                                                        <p>{{ optional($singlePurchaseItem->suppliers)->name }}</p>
                                                    </div>
                                                </div>

                                                @if(count($singlePurchaseItemDetails) > 0)
                                                    <ul class="list-style-none p-0 stock_list_style">

                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">@lang('Quantity')</th>
                                                                <th scope="col">@lang('Cost Per Unit')</th>
                                                                <th scope="col">@lang('Total Unit Cost')</th>
                                                                <th scope="col">@lang('Purchased Date')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>


                                                            @foreach($singlePurchaseItemDetails as $key => $purchaseInDetail)

                                                                <tr>
                                                                    <td data-label="Quantity">{{ $purchaseInDetail->quantity }}</td>
                                                                    <td data-label="Cost Per Unit">{{ $purchaseInDetail->cost_per_unit }} {{ $basic->currency_symbol }}</td>
                                                                    <td data-label="Total Unit Cost">{{ $purchaseInDetail->total_unit_cost }} {{ $basic->currency_symbol }}</td>
                                                                    <td data-label="Purchased Date">{{ customDate($purchaseInDetail->purchase_date) }}</td>
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
@endsection
