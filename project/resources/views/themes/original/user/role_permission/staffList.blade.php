@extends($theme.'layouts.user')
@section('title', trans('Staff List'))
@section('content')
    @push('style')
        <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap-datepicker.css') }}"/>
    @endpush
    <!-- Invest history -->
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Staff List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Staff List')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-2">
                            <label for="">@lang('Name')</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', @request()->name) }}"
                                class="form-control"
                                placeholder="@lang('Name')"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="">@lang('Email')</label>
                            <input
                                type="text"
                                name="email"
                                value="{{ old('email', @request()->email) }}"
                                class="form-control"
                                placeholder="@lang('Email')"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="">@lang('Phone')</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', @request()->phone) }}"
                                class="form-control"
                                placeholder="@lang('Phone')"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="username">@lang('Username')</label>
                            <input
                                type="text" class="form-control datepicker username" name="username"
                                value="{{ old('username',request()->username) }}" placeholder="@lang('username')"
                                autocomplete="off"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="password">@lang('Password')</label>
                            <input
                                type="text" class="form-control datepicker password" name="password"
                                value="{{ old('password',request()->password) }}" placeholder="@lang('password')"
                                autocomplete="off" />
                        </div>

                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <a href="{{route('user.role.staffCreate')}}" class="btn btn-custom text-white"> <i
                        class="fa fa-plus-circle"></i> @lang('Create Staff')</a>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('User')</th>
                        <th scope="col">@lang('Role')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roleUsers as $key => $value)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($roleUsers) + $key}}</td>

                            <td data-label="@lang('User')">
                                {{ $value->name }}
                            </td>

                            <td data-label="@lang('Role')">
                                {{str_replace('_',' ',ucfirst(optional($value->role)->name))}}
                            </td>


                            <td data-label="Status">
                                @if($value->status == 1)
                                    <span class="badge bg-success"> @lang('Active') </span>
                                @else
                                    <span class="badge bg-success"> @lang('Deactive') </span>
                                @endif
                            </td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button
                                        type="button"
                                        class="dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item btn" href="{{ route('user.role.staffEdit', $value->id) }}">
                                                <i class="fas fa-edit"></i> @lang('Edit')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="100%" class="text-danger text-center">{{trans('No Data Found!')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('script')

@endpush
