@extends($theme.'layouts.user')
@section('title',trans('Add New Customer'))

@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Add New Customer')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('user.customerList') }}">@lang('Customer List')</a>
                                    </li>

                                    <li class="breadcrumb-item active" aria-current="page">@lang('Add Customer')</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{route('user.customerList')}}"
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
                                <form action="{{ route('user.customerStore')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="@lang('Customer Name')"
                                                   value="{{ old('name') }}"/>
                                            @if($errors->has('name'))
                                                <div class="error text-danger">@lang($errors->first('name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="owner_name">@lang('Owner Name') <sub>(optional)</sub></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="owner_name"
                                                   placeholder="@lang('Owner Name')"
                                                   value="{{ old('owner_name') }}"/>
                                            @if($errors->has('owner_name'))
                                                <div class="error text-danger">@lang($errors->first('owner_name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email') <span><sub>(optional)</sub></span></label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="@lang('Customer Email')"
                                                   value="{{ old('email') }}"/>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone')</label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="@lang('Customer Phone')"
                                                   class="form-control"
                                                   value="{{ old('phone') }}"/>
                                            @if($errors->has('phone'))
                                                <div class="error text-danger">@lang($errors->first('phone'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="trade_id">@lang('Trade License') <sub>(optional)</sub></label>
                                            <input type="text"
                                                   name="trade_id"
                                                   placeholder="@lang('Trade License Id Number')"
                                                   class="form-control"
                                                   value="{{ old('trade_id') }}"/>
                                            @if($errors->has('trade_id'))
                                                <div class="error text-danger">@lang($errors->first('trade_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="national_id">@lang('National Id') <span
                                                    class="text-dark"> <sub>(optional)</sub></span></label>
                                            <input type="text" name="national_id" placeholder="@lang('National Id Number')"
                                                   class="form-control" value="{{ old('national_id') }}"/>
                                            @if($errors->has('national_id'))
                                                <div class="error text-danger">@lang($errors->first('national_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="check_no">@lang('Check No') <sub>(optional)</sub></label>
                                            <input type="text"
                                                   name="check_no"
                                                   placeholder="@lang('Check Number')"
                                                   class="form-control"
                                                   value="{{ old('check_no') }}"/>
                                            @if($errors->has('check_no'))
                                                <div class="error text-danger">@lang($errors->first('check_no'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="branch_name">@lang('Branch/Bank Name') <sub>(optional)</sub></label>
                                            <input type="text"
                                                   name="branch_name"
                                                   placeholder="@lang('Branch or Bank Name')"
                                                   class="form-control"
                                                   value="{{ old('branch_name') }}"/>
                                            @if($errors->has('branch_name'))
                                                <div class="error text-danger">@lang($errors->first('branch_name'))</div>
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
                                                      cols="30" rows="3" placeholder="@lang('Customer Address')"
                                                      name="address">{{ old('address') }}</textarea>
                                            @if($errors->has('address'))
                                                <div class="error text-danger">@lang($errors->first('address'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 mb-4 input-box">
                                            <label for="" class="golden-text">@lang('Customer Photo') <span class="text-muted"> <sub>(optional)</sub></span> </label>
                                            <div class="attach-file">
                                               <span class="prev">
                                                  @lang('Upload Logo')
                                               </span>
                                                <input type="file" name="image" class="form-control"/>
                                            </div>
                                            @error('image')
                                            <span class="text-danger">{{trans($message)}}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit">@lang('Add Customer')</button>
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
    @include($theme.'user.partials.locationJs')
@endpush
