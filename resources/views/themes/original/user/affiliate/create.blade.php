@extends($theme.'layouts.user')
@section('title',trans('Add Affiliate Member'))

@push('style')
    <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Add New Member')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>

                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.affiliateMemberList') }}">@lang('Member List')</a>
                                    </li>

                                    <li class="breadcrumb-item active"
                                        aria-current="page">@lang('Add Member')</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{route('user.affiliateMemberList')}}"
                               class="btn btn-custom text-white create__ticket">
                                <i class="fas fa-backward"></i> @lang('Back')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <!-- profile setting -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-12">
                            <div id="tab1" class="content active">
                                <form action="{{ route('user.affiliateMemberStore')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="sales_center_id">@lang('Sales Center') </label>
                                            <select class="form-select js-example-basic-single"
                                                    name="sales_center_id[]"
                                                    aria-label="Default select example" multiple>
                                                <option value="" disabled>@lang('Select Sale Center')</option>
                                                @foreach($saleCenters as $saleCenter)
                                                    <option value="{{ $saleCenter->id }}"
                                                        {{ in_array($saleCenter->id, old('sales_center_id', @request()->sales_center_id) ?: []) ? 'selected' : '' }}>
                                                        @lang($saleCenter->name)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('sales_center_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('sales_center_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="member_name">@lang('Member Name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="member_name"
                                                   placeholder="@lang('Affiliate Member Name')"
                                                   value="{{ old('member_name') }}"/>
                                            @if($errors->has('member_name'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('member_name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email')
                                                <span><sub>(@lang('optional'))</sub></span></label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="@lang('Member Email')"
                                                   value="{{ old('email') }}"/>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone')</label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="@lang('Member Phone')"
                                                   class="form-control"
                                                   value="{{ old('phone') }}"/>
                                            @if($errors->has('phone'))
                                                <div class="error text-danger">@lang($errors->first('phone'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="division_id">@lang('Division') </label>
                                            <select class="form-select js-example-basic-single selectedDivision"
                                                    name="division_id"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled>@lang('Select Division')</option>
                                                @foreach($allDivisions as $division)
                                                    <option
                                                        value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : ''}}> @lang($division->name)</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('division_id'))
                                                <div class="error text-danger">@lang($errors->first('division_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="district_id">@lang('District')</label>
                                            <select class="form-select js-example-basic-single selectedDistrict"
                                                    name="district_id"
                                                    aria-label="Default select example"
                                                    data-olddistrictid="{{ old('district_id') }}">
                                            </select>

                                            @if($errors->has('district_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('district_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="district_id">@lang('Upazila') <span
                                                    class="text-dark"><sub>(optional)</sub></span></label>
                                            <select class="form-select js-example-basic-single selectedUpazila"
                                                    name="upazila_id"
                                                    aria-label="Default select example"
                                                    data-oldupazilaid="{{ old('upazila_id') }}">
                                            </select>

                                            @if($errors->has('upazila_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('upazila_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="union_id">@lang('Union') <span
                                                    class="text-dark"><sub>(optional)</sub></span></label>
                                            <select class="form-select js-example-basic-single selectedUnion" name="union_id" aria-label="Default select example" data-oldunionid="{{ old('union_id') }}"></select>

                                            @if($errors->has('union_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('union_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="address">@lang('Address') </label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      cols="30" rows="3" placeholder="@lang('Member Address')"
                                                      name="address">{{ old('address') }}</textarea>
                                            @if($errors->has('address'))
                                                <div class="error text-danger">@lang($errors->first('address'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="member_national_id">@lang('National Id') <span
                                                    class="text-dark"> <sub>(optional)</sub></span></label>
                                            <input type="text" name="member_national_id" placeholder="@lang('Member NID')"
                                                   class="form-control" value="{{ old('national_id') }}"/>
                                            @if($errors->has('member_national_id'))
                                                <div class="error text-danger">@lang($errors->first('member_national_id'))
                                                </div>
                                            @endif
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="national_id">@lang('Member Commission') <span
                                                    class="text-dark"> (%) </span></label>
                                            <input type="text" name="member_commission" placeholder=""
                                                   class="form-control" value="{{ old('member_commission', 1) }}"/>
                                            @if($errors->has('member_commission'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('member_commission'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="date_of_death">@lang('Date of death') <span
                                                    class="text-dark"><sub>(optional)</sub></span></label>
                                            <div class="flatpickr">
                                                <div class="input-group">
                                                    <input type="date"
                                                           placeholder="@lang('Member Date of Death')"
                                                           class="form-control date_of_death"
                                                           name="date_of_death"
                                                           value="{{ old('date_of_death',request()->date_of_death) }}"
                                                           data-input>
                                                    <div class="input-group-append"
                                                         readonly="">
                                                        <div
                                                            class="form-control">
                                                            <a class="input-button cursor-pointer"
                                                               title="clear" data-clear>
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback d-block">
                                                        @error('date_of_death') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="wife_name">@lang('Wife Name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="wife_name"
                                                   placeholder="@lang('Member Wife Name')"
                                                   value="{{ old('wife_name') }}"/>
                                            @if($errors->has('wife_name'))
                                                <div class="error text-danger">@lang($errors->first('wife_name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="wife_national_id">@lang('Wife National Id') <span
                                                    class="text-dark"> <sub>(@lang('optional'))</sub></span></label>
                                            <input type="text" name="wife_national_id"
                                                   placeholder="@lang('Wife NID')"
                                                   class="form-control" value="{{ old('wife_national_id') }}"/>
                                            @if($errors->has('wife_national_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('wife_national_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="national_id">@lang('Wife Commission') <span class="text-dark"> (%) </span></label>
                                            <input type="text" name="wife_commission" placeholder=""
                                                   class="form-control" value="{{ old('wife_commission', 0.5) }}"/>
                                            @if($errors->has('wife_commission'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('wife_commission'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit">@lang('Add Member')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
    @include($theme.'user.partials.locationJs')

    <script>
        'use strict'
        $(".flatpickr").flatpickr({
            wrap: true,
            maxDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

    </script>
@endpush
