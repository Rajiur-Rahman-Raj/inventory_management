@extends($theme.'layouts.user')
@section('title', 'badges')

@section('content')
    <section class="payment-gateway">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="company-top d-flex justify-content-between">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('All Companies')</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">@lang('Company List')</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="">
                            <a href="{{route('user.createCompany')}}" class="btn btn-custom text-white create__ticket">
                                <i class="fa fa-plus-circle"></i> @lang('Create Company')</a>
                        </div>
                    </div>

                </div>
            </div>


            @if(count($companies) > 0)
                <div class="badge-box-wrapper">
                    <div class="row g-4 mb-4">
                        @foreach($companies as $company)
                            <div class="col-xl-4 col-md-4 col-12 box">
                                <div
                                    class="badge-box  {{ Auth()->user()->active_company_id == null || Auth()->user()->active_company_id != $company->id ? 'locked' : '' }}">
                                    <img class="img-fluid"
                                         src="{{ getFile(config('location.companyLogo.path').$company->logo) }}"
                                         alt=""/>
                                    <h3 class="m-0">@lang($company->name)</h3>
                                    <p class="">@lang($company->email)</p>
                                    <div class="text-start">
                                        <h5>@lang('Phone'): <span>
                                                <a href="tel:{{ $company->phone }}">{{ $company->phone }}</a>
                                            </span>
                                        </h5>

                                        <h5>@lang('Address'): <span>{{ $company->address }}</span></h5>
                                        <h5>@lang('Trade Id'): <span>{{ $company->trade_id }}</span></h5>

                                    </div>
                                    <div class="lock-icon">
                                        <i class="far fa-lock-alt"></i>
                                    </div>
                                    <div class="sidebar-dropdown-items">
                                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <i class="fal fa-cog" aria-hidden="true"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            @if(Auth()->user()->active_company_id == null || Auth()->user()->active_company_id != $company->id)
                                                <li>
                                                    <a class="dropdown-item btn activeCompany"
                                                       data-route="{{route('user.activeCompany', $company->id)}}"
                                                       data-property="{{ $company }}">
                                                        <i class="fas fa-check"></i> @lang('Active')
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item btn inactiveCompany"
                                                       data-route="{{route('user.inactiveCompany', $company->id)}}"
                                                       data-property="{{ $company }}">
                                                        <i class="fas fa-check"></i> @lang('Inactive')
                                                    </a>
                                                </li>
                                            @endif

                                            <li>
                                                <a class="dropdown-item btn" href="{{ route('user.companyEdit', $company->id) }}">
                                                    <i class="fas fa-edit"></i> @lang('Edit')
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item btn deleteCompany"
                                                   data-route="{{route('user.deleteCompany', $company->id)}}"
                                                   data-property="{{ $company }}">
                                                    <i class="fas fa-trash-alt"></i> @lang('Delete')
                                                </a>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('loadModal')
        <div class="modal fade" id="activeCompanyModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <div class="modal-content">
                    <div class="modal-header modal-primary modal-header-custom">
                        <h4 class="modal-title">@lang('Active Confirmation')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="active-company-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="activeCompanyRoute">
                            @csrf
                            @method('put')
                            <button type="submit"
                                    class="btn btn-sm btn-custom text-white">@lang('Yes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="inactiveCompanyModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <div class="modal-content">
                    <div class="modal-header modal-primary modal-header-custom">
                        <h4 class="modal-title">@lang('Inactive Confirmation')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="inactive-company-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="inactiveCompanyRoute">
                            @csrf
                            @method('put')
                            <button type="submit"
                                    class="btn btn-sm btn-custom text-white">@lang('Yes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteCompanyModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <div class="modal-content">
                    <div class="modal-header modal-primary modal-header-custom">
                        <h4 class="modal-title">@lang('Delete Confirmation')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="delete-company-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteCompanyRoute">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                    class="btn btn-sm btn-custom text-white">@lang('Yes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush

@endsection

@push('script')
    <script>
        'use strict'
        $(document).on('click', '.activeCompany', function () {
            var activeCompanyModal = new bootstrap.Modal(document.getElementById('activeCompanyModal'))
            activeCompanyModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');

            $('.activeCompanyRoute').attr('action', dataRoute)

            $('.active-company-name').text(`Are you sure to active ${dataProperty.name}?`)

        });

        $(document).on('click', '.inactiveCompany', function () {
            var inactiveCompanyModal = new bootstrap.Modal(document.getElementById('inactiveCompanyModal'))
            inactiveCompanyModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');

            $('.inactiveCompanyRoute').attr('action', dataRoute)

            $('.inactive-company-name').text(`Are you sure to inavtive ${dataProperty.name}?`)

        });

        $(document).on('click', '.deleteCompany', function () {
            var deleteCompanyModal = new bootstrap.Modal(document.getElementById('deleteCompanyModal'))
            deleteCompanyModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');

            $('.deleteCompanyRoute').attr('action', dataRoute)

            $('.delete-company-name').text(`Are you sure to delete ${dataProperty.name}?`)

        });
    </script>
@endpush
