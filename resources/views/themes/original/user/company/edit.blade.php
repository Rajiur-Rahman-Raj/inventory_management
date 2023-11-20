@extends($theme.'layouts.user')
@section('title',trans('Edit Company'))


@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Edit Company')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">@lang('Edit Company')</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{route('user.companyList')}}" class="btn btn-custom text-white create__ticket">
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
                                <form action="{{ route('user.companyUpdate', $singleCompany->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Name') <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="@lang('Company Name')"
                                                   value="{{ old('name', $singleCompany->name) }}"/>
                                            @if($errors->has('name'))
                                                <div class="error text-danger">@lang($errors->first('name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email') <span class="text-danger">*</span></label>
                                            <input type="email"
                                                   name="email"
                                                   placeholder="@lang('Company Email')"
                                                   class="form-control"
                                                   value="{{ old('email', $singleCompany->email) }}"/>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone Number') <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="@lang('Company Number')"
                                                   value="{{ old('phone', $singleCompany->phone) }}"
                                                   class="form-control"/>
                                            @if($errors->has('phone'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('phone'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="trade_id">@lang('Trade Id') <span class="text-muted"> <sup>(optional)</sup> </span></label>
                                            <input type="text" name="trade_id" placeholder="@lang('Trade Id')"
                                                   class="form-control" value="{{ old('trade_id', $singleCompany->trade_id) }}"/>
                                            @if($errors->has('trade_id'))
                                                <div class="error text-danger">@lang($errors->first('trade_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="address">@lang('Company Address') <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      cols="30" rows="3" placeholder="@lang('Company Address')"
                                                      name="address">{{ old('address', $singleCompany->address) }}</textarea>
                                            @if($errors->has('address'))
                                                <div class="error text-danger">@lang($errors->first('address'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 mb-4 input-box">
                                            <label for="" class="golden-text">@lang('Company Logo') <span class="text-danger"></span></label>
                                            <div class="attach-file">
                                               <span class="prev">
                                                  @lang('Upload Logo')
                                               </span>
                                                <input type="file" name="logo" class="form-control"/>
                                            </div>
                                            @error('logo')
                                            <span class="text-danger">{{trans($message)}}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100" type="submit">@lang('Update Company')</button>
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
