@extends($theme.'layouts.user')
@section('title',trans('Edit Employee'))

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
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Edit Employee')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">@lang('Edit Employee')</li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <a href="{{route('user.employeeList')}}"
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
                                <form action="{{ route('user.employeeUpdate', $singleEmployeeInfo->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Name') </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="@lang('Employee Name')"
                                                   value="{{ old('name', $singleEmployeeInfo->name) }}"/>
                                            @if($errors->has('name'))
                                                <div class="error text-danger">@lang($errors->first('name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone') </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="phone"
                                                   placeholder="@lang('Phone Number')"
                                                   value="{{ old('phone', $singleEmployeeInfo->phone) }}"/>
                                            @if($errors->has('phone'))
                                                <div class="error text-danger">@lang($errors->first('phone'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email') </label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="@lang('Email Address')"
                                                   value="{{ old('email', $singleEmployeeInfo->email) }}"/>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="national_id">@lang('National Id') <span
                                                    class="text-muted"> <sub>(optional)</sub></span></label>
                                            <input type="text" name="national_id" placeholder="@lang('National Id')"
                                                   class="form-control" value="{{ old('national_id', $singleEmployeeInfo->national_id) }}"/>
                                            @if($errors->has('national_id'))
                                                <div class="error text-danger">@lang($errors->first('national_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="date_of_birth">@lang('Date of Birth') <span
                                                    class="text-dark"><sub>(optional)</sub></span></label>
                                            <div class="flatpickr">
                                                <div class="input-group">
                                                    <input type="date"
                                                           placeholder="@lang('select date')"
                                                           class="form-control date_of_birth"
                                                           name="date_of_birth"
                                                           value="{{ old('date_of_birth',$singleEmployeeInfo->date_of_birth) }}"
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
                                                        @error('date_of_birth') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="joining_date">@lang('Joining Date') <span
                                                    class="text-dark"></span></label>
                                            <div class="flatpickr">
                                                <div class="input-group">
                                                    <input type="date"
                                                           placeholder="@lang('select date')"
                                                           class="form-control joining_date"
                                                           name="joining_date"
                                                           value="{{ old('joining_date',$singleEmployeeInfo->joining_date) }}"
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
                                                        @error('joining_date') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="designation">@lang('Designation') </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="designation"
                                                   placeholder="@lang('Employee Designation')"
                                                   value="{{ old('designation', $singleEmployeeInfo->designation) }}"/>
                                            @if($errors->has('designation'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('designation'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="employee_type">@lang('Employment Type') </label>
                                            <select class="form-select js-example-basic-single"
                                                    name="employee_type"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled>@lang('Select Employee Type')</option>
                                                <option value="1" {{ old('employee_type', $singleEmployeeInfo->employee_type) == 1 ? 'selected' : ''}}> @lang('Full Time') </option>
                                                <option value="2" {{ old('employee_type', $singleEmployeeInfo->employee_type) == 2 ? 'selected' : ''}}> @lang('Part Time') </option>
                                            </select>

                                            @if($errors->has('employee_type'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('employee_type'))</div>
                                            @endif
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="joining_salary"> @lang('Joining Salary')</label>
                                            <div class="input-group">
                                                <input type="text" name="joining_salary"
                                                       class="form-control @error('joining_salary') is-invalid @enderror"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       value="{{ old('joining_salary', $singleEmployeeInfo->joining_salary) }}">
                                                <div class="input-group-append" readonly="">
                                                    <div class="form-control currency_symbol append_group">
                                                        {{ $basic->currency_symbol }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invalid-feedback">
                                                @error('joining_salary') @lang($message) @enderror
                                            </div>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="current_salary"> @lang('Current Salary')</label>
                                            <div class="input-group">
                                                <input type="text" name="current_salary"
                                                       class="form-control @error('current_salary') is-invalid @enderror"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       value="{{ old('current_salary', $singleEmployeeInfo->current_salary) }}">
                                                <div class="input-group-append" readonly="">
                                                    <div class="form-control currency_symbol append_group">
                                                        {{ $basic->currency_symbol }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invalid-feedback">
                                                @error('current_salary') @lang($message) @enderror
                                            </div>
                                        </div>


                                        <div class="input-box col-12">
                                            <label for="present_address">@lang('Present Address') </label>
                                            <textarea
                                                class="form-control @error('present_address') is-invalid @enderror"
                                                cols="30" rows="3" placeholder="@lang('Present Address')"
                                                name="present_address"
                                                value="{{old('present_address', $singleEmployeeInfo->present_address)}}">{{ old('present_address', $singleEmployeeInfo->present_address) }}</textarea>
                                            @if($errors->has('present_address'))
                                                <div class="error text-danger">@lang($errors->first('present_address'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="permanent_address">@lang('Permanent Address') </label>
                                            <textarea
                                                class="form-control @error('permanent_address') is-invalid @enderror"
                                                cols="30" rows="3" placeholder="@lang('Permanent Address')"
                                                name="permanent_address"
                                                value="{{old('permanent_address', $singleEmployeeInfo->permanent_address)}}">{{ old('permanent_address', $singleEmployeeInfo->permanent_address) }}</textarea>
                                            @if($errors->has('permanent_address'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('permanent_address'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-6 mb-4 input-box">
                                            <label for="" class="golden-text">@lang('Employee Photo') <span
                                                    class="text-muted"> <sub>(optional)</sub></span> </label>
                                            <div class="attach-file">
                                               <span class="prev">
                                                  @lang('Upload Photo')
                                               </span>
                                                <input type="file" name="image" class="form-control"/>
                                            </div>
                                            @error('image')
                                            <span class="text-danger">{{trans($message)}}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="status">@lang('Status') </label>
                                            <select class="form-select js-example-basic-single"
                                                    name="status"
                                                    aria-label="Default select example">
                                                <option value="1" {{ old('status', $singleEmployeeInfo->status) == 1 ? 'selected' : ''}}> @lang('Active') </option>
                                                <option value="0" {{ old('status', $singleEmployeeInfo->status) == 2 ? 'selected' : ''}}> @lang('Deactive') </option>
                                            </select>

                                            @if($errors->has('status'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('status'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit">@lang('Create Employee')</button>
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
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

    </script>
@endpush
