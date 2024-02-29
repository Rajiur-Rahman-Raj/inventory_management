@extends($theme.'layouts.user')
@section('title', trans('Available Roles'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Available Roles')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Available Roles')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-4">
                            <label for="">@lang('Role')</label>
                            <select class="form-control js-example-basic-single" name="role_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                @foreach($allRoles as $role)
                                    <option
                                        value="{{ $role->id }}" {{ @request()->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-4">
                            <label for="">@lang('Status')</label>
                            <select class="form-control js-example-basic-single" name="status"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                <option
                                    value="active" {{ @request()->status == 'active' ? 'selected' : '' }}>@lang('Active')</option>
                                <option
                                    value="deactive" {{ @request()->deactive == 'deactive' ? 'selected' : '' }}>@lang('Deactive')</option>
                            </select>
                        </div>

                        <div class="input-box col-lg-4">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-4">
                @if(userType() == 1)
                    <a href="{{route('user.createRole')}}" class="btn btn-custom text-white"> <i
                            class="fa fa-plus-circle"></i> @lang('Create Role')</a>
                @endif
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $key => $role)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($roles) + $key}}</td>

                            <td data-label="@lang('Name')"> {{ $role->name }} </td>
                            <td data-label="@lang('Status')" class="font-weight-bold">
                                <span
                                    class="badge {{ $role->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $role->status == 1 ? 'Active' : 'Deactive' }} </span>
                            </td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button
                                        type="button"
                                        class="dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if(userType() == 1)
                                            <li>
                                                <a href="{{ route('user.editRole', $role->id) }}"
                                                   class="dropdown-item"> <i class="fal fa-edit"></i> @lang('Edit')
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item btn deleteRole"
                                                   data-route="{{route('user.deleteRole', $role->id)}}"
                                                   data-property="{{ $role }}">
                                                    <i class="fas fa-trash-alt"></i> @lang('Delete')
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="100%" class="text-danger text-center">{{trans('No Available Roles')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @push('loadModal')

        <!--Delete Role Modal -->
        <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-role-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteRoleRoute">
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
        $(document).ready(function () {

            $(document).on('click', '.deleteRole', function () {
                var deleteRoleModal = new bootstrap.Modal(document.getElementById('deleteRoleModal'))
                deleteRoleModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');
                $('.deleteRoleRoute').attr('action', dataRoute)
                $('.delete-role-name').text(`Are you sure to delete ${dataProperty.name}?`)
            });
        });
    </script>
@endpush
