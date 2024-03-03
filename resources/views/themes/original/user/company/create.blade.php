@extends($theme.'layouts.user')
@section('title',trans('Create Company'))

@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Create Company')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">@lang('Create Company')</li>
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
                                <form action="{{ route('user.companyStore')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Name') </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="@lang('Company Name')"
                                                   value="{{ old('name') }}"/>
                                            @if($errors->has('name'))
                                                <div class="error text-danger">@lang($errors->first('name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email')</label>
                                            <input type="email"
                                                   name="email"
                                                   placeholder="@lang('Company Email')"
                                                   class="form-control"
                                                   value="{{ old('email') }}"/>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone Number') </label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="@lang('Company Number')"
                                                   value="{{ old('phone') }}"
                                                   class="form-control"/>
                                            @if($errors->has('phone'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('phone'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="trade_id">@lang('Trade Id') <span class="text-muted"><sub>(optional)</sub></span></label>
                                            <input type="text" name="trade_id" placeholder="@lang('Trade Id')"
                                                   class="form-control" value="{{ old('trade_id') }}"/>
                                            @if($errors->has('trade_id'))
                                                <div class="error text-danger">@lang($errors->first('trade_id'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="address">@lang('Company Address') </label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      cols="30" rows="3" placeholder="@lang('Company Address')"
                                                      name="address">{{ old('address') }}</textarea>
                                            @if($errors->has('address'))
                                                <div class="error text-danger">@lang($errors->first('address'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 mb-4 input-box">
                                            <label for="" class="golden-text">@lang('Company Logo') </label>
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


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check mt-3 centralPromoterCheckBox">
                                                    <input class="form-check-input" type="checkbox" name="promoter_check_box" id="checkCentralPromoter">
                                                    <label class="form-check-label" for="checkCentralPromoter">
                                                        Add Central Promoter
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row centralPromoterForm d-none">
                                            <div class="input-box col-md-6 mt-4 mb-4">
                                                <label for="placeholder">@lang('Promoter Name') </label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="promoter_name"
                                                       placeholder="@lang('Central Promoter Name')"
                                                       value="{{ old('promoter_name') }}"/>
                                                @if($errors->has('promoter_name'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('promoter_name'))</div>
                                                @endif
                                            </div>

                                            <div class="input-box col-md-6 mt-4 mb-4">
                                                <label for="promoter_email">@lang('Email') </label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="promoter_email"
                                                       placeholder="@lang('Promoter Email')"
                                                       value="{{ old('promoter_email') }}"/>
                                                @if($errors->has('promoter_email'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('promoter_email'))</div>
                                                @endif
                                            </div>

                                            <div class="input-box col-md-6 mb-4">
                                                <label for="promoter_phone">@lang('Phone Number') </label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="promoter_phone"
                                                       placeholder="@lang('Promoter Phone Number')"
                                                       value="{{ old('promoter_phone') }}"/>
                                                @if($errors->has('promoter_email'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('promoter_phone'))</div>
                                                @endif
                                            </div>

                                            <div class="input-box col-md-6">
                                                <label for="promoter_commission">@lang('Promoter Commission') (%)</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="promoter_commission"
                                                       placeholder="@lang('Promoter Commission')"
                                                       value="1"/>
                                                @if($errors->has('promoter_commission'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('promoter_commission'))</div>
                                                @endif
                                            </div>

                                            <div class="input-box col-12  mb-4">
                                                <label for="promoter_address">@lang('Address') </label>
                                                <textarea
                                                    class="form-control @error('promoter_address') is-invalid @enderror"
                                                    cols="30" rows="3" placeholder="@lang('Promoter Address')"
                                                    name="promoter_address">{{ old('promoter_address') }}</textarea>
                                                @if($errors->has('promoter_address'))
                                                    <div class="error text-danger">@lang($errors->first('promoter_address'))</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit">@lang('Create Company')</button>
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
    <script>
        // Get the checkbox element
        var checkbox = document.getElementById("checkCentralPromoter");

        // Add event listener to the checkbox
        checkbox.addEventListener('change', function() {
            // Check if the checkbox is checked
            if (this.checked) {
                $('.centralPromoterForm').removeClass('d-none')
            } else {
                // If unchecked, apply condition 2
                $('.centralPromoterForm').addClass('d-none')
            }
        });
    </script>
@endpush

