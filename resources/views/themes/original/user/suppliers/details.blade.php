@extends($theme.'layouts.user')
@section('title',trans('Supplier Details'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1">@lang('Supplier Details')</h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('user.suppliers') }}">@lang('Suppliers')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Supplier Details')</li>
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
                                        <a href="{{ route('user.suppliers') }}"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> @lang('Back') </span>
                                        </a>
                                    </div>

                                    <div class="p-4 border shadow-sm rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Joining Date')
                                                            : </h6>
                                                        <p>{{ dateTime($supplier->created_at) }}</p>
                                                    </div>
                                                </div>
                                                <ul class="invest-history-details-ul">
                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Supplier Name') :</span> <span
                                                                class="text-muted">{{ $supplier->name }}</span></span>
                                                    </li>

                                                    @if($supplier->email)
                                                        <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Email') :</span>  <span
                                                                class="text-muted">{{ $supplier->email }}</span></span>
                                                        </li>
                                                    @endif

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Phone')</span> <span
                                                                class="text-muted">{{ $supplier->phone }}</span></span>
                                                    </li>

                                                    @if($supplier->national_id)
                                                        <li class="my-3">
                                                            <span class=""><i
                                                                    class="fal fa-check-circle site__color text-success"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted"> @lang('National Id') : </span> <span
                                                                    class="text-muted">{{ $supplier->national_id }}</span></span>
                                                        </li>
                                                    @endif

                                                    <li class="my-3">
                                                        <span>
                                                            <i class="fal fa-check-circle site__color text-purple"
                                                               aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Division') :</span>
                                                            <span
                                                                class="text-muted">{{ optional($supplier->division)->name }}</span>
                                                        </span>
                                                    </li>

                                                    <li class="my-3">
                                                            <span><i
                                                                    class="fal fa-check-circle site__color text-purple"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted">@lang('District') : </span> <span
                                                                    class="text-muted">{{ optional($supplier->district)->name }}</span></span>
                                                    </li>

                                                    @if($supplier->upazila)
                                                        <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Upazila') :</span> <span
                                                                class="text-muted">{{ optional($supplier->upazila)->name }}</span></span>
                                                        </li>
                                                    @endif

                                                    @if($supplier->union)
                                                        <li class="my-3">
                                                        <span><i
                                                                class="fal fa-check-circle site__color"
                                                                aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Union') :</span> <span
                                                                class="text-muted">{{ optional($supplier->union)->name }}</span></span>
                                                        </li>
                                                    @endif

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Address') :</span> <span
                                                                class="text-muted">{{ $supplier->address }}</span></span>
                                                    </li>
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
@endsection
