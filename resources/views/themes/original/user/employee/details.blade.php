@extends($theme.'layouts.user')
@section('title',trans('Employee Details'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1">@lang('Sales Center Details')</h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Employee Details')</li>
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
                                        <a href="{{ route('user.employeeList') }}"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> @lang('Back') </span>
                                        </a>
                                    </div>

                                    <div class="p-4 border shadow-sm rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">

                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> @lang('Joining Date')
                                                            : </h6>
                                                        <h6 class="ms-2">{{ dateTime($singleEmployee->joining_date) }}</h6>
                                                    </div>
                                                </div>

                                                <ul class="invest-history-details-ul">
                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Name') :</span> <span
                                                                class="text-muted">{{ $singleEmployee->name }}</span></span>
                                                    </li>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Designation') :</span> <span
                                                                class="text-muted">{{ $singleEmployee->designation }}</span></span>
                                                    </li>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Email:')</span> <span
                                                                class="text-muted">{{ $singleEmployee->email }}</span></span>
                                                    </li>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Phone:')</span> <span
                                                                class="text-muted">{{ $singleEmployee->phone }}</span></span>
                                                    </li>

                                                    @if($singleEmployee->national_id)
                                                        <li class="my-3">
                                                            <span class=""><i
                                                                    class="fal fa-check-circle site__color text-success"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted"> @lang('National Id') : </span> <span
                                                                    class="text-muted">{{ $singleEmployee->national_id }}</span></span>
                                                        </li>
                                                    @endif

                                                    <li class="my-3">
                                                            <span><i
                                                                    class="fal fa-check-circle text-warning"
                                                                    aria-hidden="true"></i> <span
                                                                    class="font-weight-bold text-muted">@lang('Date Of Birth') :</span> <span
                                                                    class="text-muted">{{ $singleEmployee->date_of_birth }}</span></span>
                                                    </li>

                                                    @if($singleEmployee->employee_type == 1)
                                                        <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Employee Type') :</span> <span
                                                                class="text-muted">@lang('Full Time')</span></span>
                                                        </li>
                                                    @else
                                                        <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Employee Type') :</span> <span
                                                                class="text-muted">@lang('Part Time')</span></span>
                                                        </li>
                                                    @endif


                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Joining Salary')</span> <span
                                                                class="text-muted">{{ $singleEmployee->joining_salary }} {{ config('basic.currency_symbol') }}</span></span>
                                                    </li>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Current Salary')</span> <span
                                                                class="text-muted">{{ $singleEmployee->current_salary }} {{ config('basic.currency_symbol') }}</span></span>
                                                    </li>


                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Present Address')</span> <span
                                                                class="text-muted">{{ $singleEmployee->present_address }}</span></span>
                                                    </li>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary"
                                                                 aria-hidden="true"></i> <span
                                                                class="font-weight-bold text-muted">@lang('Permanent Address')</span> <span
                                                                class="text-muted">{{ $singleEmployee->permanent_address }}</span></span>
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
