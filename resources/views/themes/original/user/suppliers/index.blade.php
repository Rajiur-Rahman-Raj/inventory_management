@extends($theme.'layouts.user')
@section('title', trans('Customer List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Supplier List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Supplier List')</li>
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
                                placeholder="@lang('Supplier Name')"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="">@lang('Email')</label>
                            <input
                                type="text"
                                name="email"
                                value="{{ old('email', @request()->email) }}"
                                class="form-control"
                                placeholder="@lang('Supplier Email')"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="">@lang('Phone')</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', @request()->phone) }}"
                                class="form-control"
                                placeholder="@lang('Supplier Phone')"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="from_date">@lang('From Date')</label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="{{ old('from_date',request()->from_date) }}" placeholder="@lang('From date')"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-2">
                            <label for="to_date">@lang('To Date')</label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="{{ old('to_date',request()->to_date) }}" placeholder="@lang('To date')"
                                autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Suppliers.Suppliers.permission.add'))))
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{route('user.createSupplier')}}" class="btn btn-custom text-white "> <i
                            class="fa fa-plus-circle"></i> @lang('Add Supplier')</a>
                </div>
            @endif

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Phone')</th>
                        <th scope="col">@lang('Division')</th>
                        <th scope="col">@lang('District')</th>
                        <th scope="col">@lang('Join Date')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($suppliers as $key => $supplier)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($suppliers) + $key}}</td>

                            <td class="company-logo" data-label="@lang('Name')">
                                <div>
                                    <a href="" target="_blank">
                                        <img src="{{ getFile($supplier->driver, $supplier->image) }}">
                                    </a>
                                </div>
                                <div>
                                    <a href=""
                                       target="_blank">{{ $supplier->name }}</a>
                                    <br>
                                    @if($supplier->email)
                                        <span class="text-muted font-14">
                                        <span>{{ $supplier->email }}</span>
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td data-label="@lang('Phone')">{{ $supplier->phone }}</td>
                            <td data-label="@lang('Division')">{{ optional($supplier->division)->name }}</td>
                            <td data-label="@lang('District')">{{ optional($supplier->district)->name }}</td>
                            <td data-label="@lang('Join Date')">{{ dateTime($supplier->created_at) }}</td>

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
                                            <a href="{{ route('user.supplierDetails', $supplier->id) }}"
                                               class="dropdown-item"> <i class="fal fa-eye"></i> @lang('Details') </a>
                                        </li>
                                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Suppliers.Suppliers.permission.edit'))))
                                            <li>
                                                <a class="dropdown-item btn"
                                                   href="{{ route('user.supplierEdit', $supplier->id) }}">
                                                    <i class="fas fa-edit"></i> @lang('Edit')
                                                </a>
                                            </li>
                                        @endif

                                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Suppliers.Suppliers.permission.delete'))))
                                            <li>
                                                <a class="dropdown-item btn deleteSupplier"
                                                   data-route="{{route('user.deleteSupplier', $supplier->id)}}"
                                                   data-property="{{ $supplier }}">
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
                            <td colspan="100%" class="text-danger text-center">{{trans('No Data Found!')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $suppliers->appends($_GET)->links($theme.'partials.pagination') }}
            </div>
        </div>
    </section>

    @push('loadModal')
        <!-- Modal -->
        <div class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-supplier-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteSupplierRoute">
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
    <script src="{{ asset('assets/global/js/bootstrap-datepicker.js') }}"></script>
    <script>
        'use strict'
        $(document).ready(function () {
            $(".datepicker").datepicker({
                autoclose: true,
                clearBtn: true
            });

            $('.from_date').on('change', function () {
                $('.to_date').removeAttr('disabled');
            });

            $(document).on('click', '.deleteSupplier', function () {
                var deleteSupplierModal = new bootstrap.Modal(document.getElementById('deleteSupplierModal'))
                deleteSupplierModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.deleteSupplierRoute').attr('action', dataRoute)

                $('.delete-supplier-name').text(`Are you sure to delete ${dataProperty.name}?`)

            });
        });
    </script>
@endpush
