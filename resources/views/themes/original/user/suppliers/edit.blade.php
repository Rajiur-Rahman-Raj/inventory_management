@extends($theme.'layouts.user')
@section('title',trans('Edit Supplier'))


@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Edit Supplier')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.customerList') }}">@lang('Supplier List')</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">@lang('Edit Supplier')</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{route('user.suppliers')}}" class="btn btn-custom text-white create__ticket">
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
                                <form action="{{ route('user.supplierUpdate', $supplier->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="@lang('Supplier Name')"
                                                   value="{{ old('name', $supplier->name) }}"/>
                                            @if($errors->has('name'))
                                                <div class="error text-danger">@lang($errors->first('name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email') <span><sub>(optional)</sub></span></label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="@lang('Supplier Email')"
                                                   value="{{ old('email', $supplier->email) }}"/>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone')</label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="@lang('Supplier Phone')"
                                                   class="form-control"
                                                   value="{{ old('phone', $supplier->phone) }}"/>
                                            @if($errors->has('phone'))
                                                <div class="error text-danger">@lang($errors->first('phone'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="national_id">@lang('National Id') <span
                                                    class="text-muted"> <span><sub>(optional)</sub></span></span></label>
                                            <input type="text" name="national_id" placeholder="@lang('National Id')"
                                                   class="form-control" value="{{ old('national_id', $supplier->national_id) }}"/>
                                            @if($errors->has('national_id', $supplier->national_id))
                                                <div class="error text-danger">@lang($errors->first('national_id'))
                                                </div>
                                            @endif
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="division_id">@lang('Division') </label>
                                            <select class="form-select js-example-basic-single selectedDivision"
                                                    name="division_id"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled>@lang('Select Division')</option>
                                                @foreach($divisions as $division)
                                                    <option
                                                        value="{{ $division->id }}" {{ old('division_id', $supplier->division_id) == $division->id ? 'selected' : ''}}> @lang($division->name)</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('division_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('division_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="district_id">@lang('District')</label>
                                            <select class="form-select js-example-basic-single selectedDistrict"
                                                    name="district_id"
                                                    aria-label="Default select example"
                                                    data-olddistrictid="{{ old('district_id') }}">
                                                <option value="" disabled selected>@lang('Select District')</option>
                                                @foreach($districts as $district)
                                                    <option
                                                        value="{{ $district->id }}" {{ old('district_id', $supplier->district_id) == $district->id ? 'selected' : ''}}> @lang($district->name)</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('district_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('district_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="district_id">@lang('Upazila') <span
                                                    class="text-muted"><span><sub>(optional)</sub></span></span></label>
                                            <select class="form-select js-example-basic-single selectedUpazila"
                                                    name="upazila_id"
                                                    aria-label="Default select example"
                                                    data-oldupazilaid="{{ old('upazila_id') }}">
                                                <option value="" disabled selected>@lang('Select Upazila')</option>
                                                @foreach($upazilas as $upazila)
                                                    <option value="{{ $upazila->id }}" {{ old('upazila_id', $supplier->upazila_id) == $upazila->id ? 'selected' : ''}}> @lang($upazila->name)</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('upazila_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('upazila_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="union_id">@lang('Union') <span
                                                    class="text-muted"><sub>(optional)</sub></span></label>
                                            <select class="form-select js-example-basic-single selectedUnion"
                                                    name="union_id" aria-label="Default select example"
                                                    data-oldunionid="{{ old('union_id') }}">
                                                <option value="" disabled selected>@lang('Select Union')</option>
                                                @foreach($unions as $union)
                                                    <option
                                                        value="{{ $union->id }}" {{ old('union_id', $supplier->union_id) == $union->id ? 'selected' : ''}}> @lang($union->name)</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('union_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('union_id'))
                                                </div>
                                            @endif
                                        </div>


                                        <div class="input-box col-12">
                                            <label for="address">@lang('Address') </label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      cols="30" rows="3" placeholder="@lang('Sales Center Address')"
                                                      name="address">{{ old('address', $supplier->address) }}</textarea>
                                            @if($errors->has('address'))
                                                <div class="error text-danger">@lang($errors->first('address'))</div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 mb-4 input-box">
                                            <label for="" class="golden-text">@lang('Photo') <span class="text-muted"> <sub>(optional)</sub></span> </label>
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

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit">@lang('Update Supplier')</button>
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
