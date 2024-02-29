@extends($theme.'layouts.user')
@section('title',trans('Member Details'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1">@lang('Member Details')</h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('user.affiliateMemberList') }}">@lang('Member List')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Member Details')</li>
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
                                        <a href="{{ route('user.affiliateMemberList') }}"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> @lang('Back') </span>
                                        </a>
                                    </div>

                                    <div class="p-4 border shadow-sm rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Sales Center')
                                                            : </h6>
                                                        <p class="ms-2">
                                                            @foreach($memberDetails->salesCenter as $salesCenter)
                                                                <span class="badge bg-success">{{ $salesCenter->name }}</span>
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Joining Date')
                                                            : </h6>
                                                        <p class="ms-2">{{ dateTime($memberDetails->created_at) }}</p>
                                                    </div>
                                                </div>

                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Member Commission')
                                                            : </h6>
                                                        <p class="ms-2">{{ $memberDetails->member_commission }}%</p>
                                                    </div>
                                                </div>

                                                <ul class="invest-history-details-ul">
                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Customer Name') :</span> <span
                                                                class="text-muted">{{ $memberDetails->member_name }}</span></span>
                                                    </li>

                                                    @if($memberDetails->email)
                                                        <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Email') :</span>  <span
                                                                class="text-muted">{{ $memberDetails->email }}</span></span>
                                                        </li>
                                                    @endif

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Phone')</span> <span
                                                                class="text-muted">{{ $memberDetails->phone }}</span></span>
                                                    </li>

                                                    @if($memberDetails->national_id)
                                                        <li class="my-3">
                                                            <span class=""><i
                                                                    class="fal fa-check-circle site__color text-success"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted"> @lang('National Id') : </span> <span
                                                                    class="text-muted">{{ $memberDetails->member_national_id }}</span></span>
                                                        </li>
                                                    @endif

                                                    <li class="my-3">
                                                        <span>
                                                            <i class="fal fa-check-circle site__color text-purple"
                                                               aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Division') :</span>
                                                            <span
                                                                class="text-muted">{{ optional($memberDetails->division)->name }}</span>
                                                        </span>
                                                    </li>

                                                    <li class="my-3">
                                                            <span><i
                                                                    class="fal fa-check-circle site__color text-purple"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted">@lang('District') : </span> <span
                                                                    class="text-muted">{{ optional($memberDetails->district)->name }}</span></span>
                                                    </li>

                                                    @if($memberDetails->upazila)
                                                        <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Upazila') :</span> <span
                                                                class="text-muted">{{ optional($memberDetails->upazila)->name }}</span></span>
                                                        </li>
                                                    @endif

                                                    @if($memberDetails->union)
                                                        <li class="my-3">
                                                        <span><i
                                                                class="fal fa-check-circle site__color"
                                                                aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Union') :</span> <span
                                                                class="text-muted">{{ optional($memberDetails->union)->name }}</span></span>
                                                        </li>
                                                    @endif

                                                    @if($memberDetails->date_of_death)
                                                        <li class="my-3">
                                                        <span><i
                                                                class="fal fa-check-circle site__color"
                                                                aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Date of Death') :</span> <span
                                                                class="text-muted">{{ customDate($memberDetails->date_of_death) }}</span></span>
                                                        </li>
                                                    @endif

                                                    <li class="my-3">
                                                    <span><i
                                                            class="fal fa-check-circle site__color"
                                                            aria-hidden="true"></i> <span
                                                            class="font-weight-bold text-muted">@lang('Member Wife') :</span> <span
                                                            class="text-muted">{{ $memberDetails->wife_name }}</span></span>
                                                    </li>

                                                    <li class="my-3">
                                                    <span><i
                                                            class="fal fa-check-circle site__color"
                                                            aria-hidden="true"></i> <span
                                                            class="font-weight-bold text-muted">@lang('Wife National Id') :</span> <span
                                                            class="text-muted">{{ $memberDetails->wife_national_id }}</span></span>
                                                    </li>

                                                    <li class="my-3">
                                                    <span><i
                                                            class="fal fa-check-circle site__color"
                                                            aria-hidden="true"></i> <span
                                                            class="font-weight-bold text-muted">@lang('Wife Commission') :</span> <span
                                                            class="text-muted">{{ $memberDetails->wife_commission }}</span></span>
                                                    </li>

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Address') :</span> <span
                                                                class="text-muted">{{ $memberDetails->address }}</span></span>
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
