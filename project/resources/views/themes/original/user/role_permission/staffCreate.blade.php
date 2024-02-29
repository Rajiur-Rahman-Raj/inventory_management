@extends($theme.'layouts.user')
@section('title',trans('Add New Staff'))

@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Add New Staff')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>

                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.role.staff') }}">@lang('StaffList')</a>
                                    </li>

                                    <li class="breadcrumb-item active"
                                        aria-current="page">@lang('Create Staff')</li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <a href="{{route('user.role.staff')}}"
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
                                <form action="{{ route('user.role.staffStore')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">

                                        <div class="input-box col-md-6">
                                            <label for="role_id">@lang('Role') </label>
                                            <select class="form-select js-example-basic-single"
                                                    name="role_id"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled>@lang('Select Role')</option>
                                                @foreach($roles as $role)
                                                    <option
                                                        value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : ''}}> @lang($role->name)</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('role_id'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('role_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="@lang('Staff Name')"
                                                   value="{{ old('name') }}"/>
                                            @if($errors->has('name'))
                                                <div class="error text-danger">@lang($errors->first('name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email') <span><sub>(optional)</sub></span></label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="@lang('Email')"
                                                   value="{{ old('email') }}"/>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone')</label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="@lang('Phone')"
                                                   class="form-control"
                                                   value="{{ old('phone') }}"/>
                                            @if($errors->has('phone'))
                                                <div class="error text-danger">@lang($errors->first('phone'))</div>
                                            @endif
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="username">@lang('Username')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="username"
                                                   placeholder="@lang('username')"
                                                   value="{{ old('username') }}"/>
                                            @if($errors->has('username'))
                                                <div class="error text-danger">@lang($errors->first('username'))</div>
                                            @endif
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="password">@lang('password') <span
                                                    class="text-muted"> </span></label>
                                            <input type="text" name="password" placeholder="@lang('password')"
                                                   class="form-control" value="{{ old('password') }}"/>
                                            @if($errors->has('password'))
                                                <div class="error text-danger">@lang($errors->first('password'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-12">
                                            <label for="status">@lang('Status') </label>
                                            <select class="form-select js-example-basic-single" name="status"
                                                    aria-label="Default select example">
                                                <option
                                                    value="1" {{ old('status') == 1 ? 'selected' : ''}}> @lang('Active') </option>
                                                <option
                                                    value="0" {{ old('status') == 0 ? 'selected' : ''}}> @lang('Deactive') </option>
                                            </select>

                                            @if($errors->has('role_id'))
                                                <div class="error text-danger">@lang($errors->first('role_id'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit">@lang('Create Staff')</button>
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

@endpush
