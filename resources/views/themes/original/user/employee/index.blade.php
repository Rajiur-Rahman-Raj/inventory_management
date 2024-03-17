@extends($theme.'layouts.user')
@section('title', trans('Employee List'))
@section('content')
    @push('style')
        <link href="{{ asset('assets/global/css/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <!-- Invest history -->
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Employee List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Employees')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">

                        <div class="input-box col-lg-3">
                            <label for="employee_id">@lang('Employee')</label>
                            <select class="form-control js-example-basic-single" name="employee_id"
                                    aria-label="Default select example">
                                <option value="">@lang('All')</option>
                                @foreach($employees as $employee)
                                    <option
                                        value="{{ $employee->id }}" {{ old('employee_id', @request()->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_joining_date">@lang('From Joining Date')</label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="@lang('select date')"
                                           class="form-control from_joining_date"
                                           name="from_joining_date"
                                           value="{{ old('from_joining_date',request()->from_joining_date) }}"
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
                                </div>
                            </div>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="to_date">@lang('To Joining Date')</label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="@lang('select date')"
                                           class="form-control to_joining_date"
                                           name="to_joining_date"
                                           value="{{ old('to_joining_date',request()->to_joining_date) }}"
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
                                </div>
                            </div>
                        </div>
                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Employee_List.permission.add'))))
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{route('user.createEmployee')}}" class="btn btn-custom text-white "> <i
                            class="fa fa-plus-circle"></i> @lang('Create Employee')</a>
                </div>
            @endif

            <div class="table-parent table-responsive me-2 ms-2 mt-4">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('Employee')</th>
                        <th scope="col">@lang('Designation')</th>
                        <th scope="col">@lang('Joining Date')</th>
                        <th scope="col">@lang('Present Address')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($employeeLists as $key => $employee)
                        <tr>
                            <td class="company-logo" data-label="@lang('Employee')">
                                <div>
                                    <a href="" target="_blank">
                                        <img src="{{ getFile($employee->driver, $employee->image) }}">
                                    </a>
                                </div>
                                <div>
                                    <a href=""
                                       target="_blank">{{ $employee->name }}</a>
                                    <br>
                                    @if($employee->email)
                                        <span class="text-muted font-14">
                                        <span>{{ $employee->email }}</span>
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td data-label="@lang('Designation')">{{ $employee->designation }}</td>

                            <td data-label="@lang('Joining Date')">{{ customDate($employee->joining_date) }}</td>

                            <td data-label="@lang('Present Address')">{{ $employee->present_address }}</td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('user.employeeDetails', $employee->id) }}"
                                               class="dropdown-item"> <i class="fal fa-eye"></i> @lang('Details') </a>
                                        </li>

                                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Employee_List.permission.edit'))))
                                            <li>
                                                <a class="dropdown-item btn" href="{{ route('user.employeeEdit', $employee->id) }}">
                                                    <i class="fas fa-edit"></i> @lang('Edit')
                                                </a>
                                            </li>
                                        @endif

                                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Employee_List.permission.delete'))))
                                            <li>
                                                <a class="dropdown-item btn deleteEmployee"
                                                   data-route="{{route('user.employeeDelete', $employee->id)}}"
                                                   data-empname="{{ $employee->name }}">
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
                {{ $employeeLists->appends($_GET)->links($theme.'partials.pagination') }}
            </div>
        </div>
    </section>

    @push('loadModal')
        <!-- Modal -->
        <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-employee-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteEmployeeRoute">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-custom text-white">@lang('Yes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endsection

@push('script')
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>

    <script>
        'use strict'
        $(".flatpickr").flatpickr({
            wrap: true,
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

    </script>
    <script>
        'use strict'
        $(document).ready(function () {

            $(document).on('click', '.deleteEmployee', function () {
                console.log('hi');
                var deleteEmployeeModal = new bootstrap.Modal(document.getElementById('deleteEmployeeModal'))
                deleteEmployeeModal.show();

                let dataRoute = $(this).data('route');
                let empName = $(this).data('empname');

                $('.deleteEmployeeRoute').attr('action', dataRoute)

                $('.delete-employee-name').text(`Are you sure to delete ${empName}?`)

            });
        });
    </script>
@endpush
