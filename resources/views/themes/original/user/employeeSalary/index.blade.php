@extends($theme.'layouts.user')
@section('title', trans('Employee Salary List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Employee Salary List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">@lang('Employee Salary List')</li>
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
                            <label for="from_date">@lang('From Date')</label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="@lang('select date')"
                                           class="form-control from_date"
                                           name="from_date"
                                           value="{{ old('from_date',request()->from_date) }}"
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
                            <label for="to_date">@lang('To Date')</label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="@lang('select date')"
                                           class="form-control to_date"
                                           name="to_date"
                                           value="{{ old('to_date',request()->to_date) }}"
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

            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Salary_List.permission.add'))))
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" class="btn btn-custom text-white addEmployeeSalaryBtn"
                       data-route="{{route('user.addEmployeeSalary')}}"> <i
                            class="fa fa-plus-circle"></i> @lang('Add Employee Salary')</a>
                </div>
            @endif

            <div class="table-parent table-responsive me-2 ms-2 mt-4">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('Employee')</th>
                        <th scope="col">@lang('Salary Paid')</th>
                        <th scope="col">@lang('Payment Date')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($employeeSalaryLists as $key => $salaryList)
                        <tr>
                            <td class="company-logo" data-label="@lang('Employee')">
                                <div>
                                    <a href="" target="_blank">
                                        <img
                                            src="{{ getFile(optional($salaryList->employee)->driver, optional($salaryList->employee)->image) }}">
                                    </a>
                                </div>
                                <div>
                                    <a href=""
                                       target="_blank">{{ optional($salaryList->employee)->name }}</a>
                                    <br>
                                    @if(optional($salaryList->employee)->email)
                                        <span class="text-muted font-14">
                                        <span>{{ optional($salaryList->employee)->email }}</span>
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td data-label="@lang('Salary Paid')">{{ $salaryList->amount }} {{ $basic->currency_symbol }}</td>

                            <td data-label="@lang('Payment Date')">{{ customDate($salaryList->payment_date) }}</td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Salary_List.permission.edit'))))
                                            <li>
                                                <a href="javascript:void(0)"
                                                   class="dropdown-item btn employeeSalaryEdit"
                                                   data-route="{{ route('user.employeeSalaryEdit', $salaryList->id) }}"
                                                   data-employeesalary="{{ $salaryList }}"> <i
                                                        class="fa fa-edit"></i> @lang('Edit')</a>

                                            </li>
                                        @endif

                                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Salary_List.permission.delete'))))
                                            <li>
                                                <a class="dropdown-item btn deleteEmployeeSalary"
                                                   data-route="{{route('user.employeeSalaryDelete', $salaryList->id)}}">
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
        <div class="modal fade" id="addEmployeeSalaryModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <form action="" method="post" class="addEmployeeSalaryRoute">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header modal-primary modal-header-custom">
                            <h4 class="modal-title">@lang('Add Employee Salary')</h4>
                            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="input-box col-lg-12">
                                    <label for="employee_id">@lang('Select Employee')</label>
                                    <select class="form-control" name="employee_id"
                                            aria-label="Default select example">
                                        <option value="" selected disabled>@lang('Select Employee')</option>
                                        @foreach($employees as $employee)
                                            <option
                                                value="{{ $employee->id }}" {{ old('employee_id', @request()->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="amount"> @lang('Amount')</label>
                                    <div class="input-group">
                                        <input type="text" name="amount"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                               value="{{ old('amount') }}">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group">
                                                {{ $basic->currency_symbol }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="invalid-feedback">
                                        @error('current_salary') @lang($message) @enderror
                                    </div>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="payment_date">@lang('Payment Date') <span
                                            class="text-dark"></span></label>
                                    <div class="flatpickr">
                                        <div class="input-group">
                                            <input type="date"
                                                   placeholder="@lang('select date')"
                                                   class="form-control payment_date"
                                                   name="payment_date"
                                                   value="{{ old('payment_date',request()->payment_date) }}"
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
                                            <div class="invalid-feedback d-block">
                                                @error('payment_date') @lang($message) @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal">@lang('No')</button>


                            <button type="submit" class="btn btn-sm btn-custom text-white">@lang('Yes')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editEmployeeSalaryModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <form action="" method="post" class="editEmployeeSalaryRoute">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header modal-primary modal-header-custom">
                            <h4 class="modal-title">@lang('Edit Employee Salary')</h4>
                            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="input-box col-lg-12">
                                    <label for="employee_id">@lang('Select Employee')</label>
                                    <select class="form-control selectedEmployeeSalary" name="employee_id"
                                            aria-label="Default select example">
                                        <option value="" selected disabled>@lang('Select Employee')</option>
                                        @foreach($employees as $employee)
                                            <option
                                                value="{{ $employee->id }}" {{ old('employee_id', @request()->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="amount"> @lang('Amount')</label>
                                    <div class="input-group">
                                        <input type="text" name="amount"
                                               class="form-control @error('amount') is-invalid @enderror employeeSalaryAmount"
                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                               value="">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group">
                                                {{ $basic->currency_symbol }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="invalid-feedback">
                                        @error('current_salary') @lang($message) @enderror
                                    </div>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="payment_date">@lang('Payment Date') <span
                                            class="text-dark"></span></label>
                                    <div class="flatpickr">
                                        <div class="input-group">
                                            <input type="date"
                                                   placeholder="@lang('select date')"
                                                   class="form-control payment_date employeeSalaryPaymentDate"
                                                   name="payment_date"
                                                   value=""
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
                                            <div class="invalid-feedback d-block">
                                                @error('payment_date') @lang($message) @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal">@lang('No')</button>


                            <button type="submit" class="btn btn-sm btn-custom text-white">@lang('Yes')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="deleteEmployeeSalaryModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="">Are you sure to delete?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteEmployeeSalaryRoute">
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

            $(document).on('click', '.addEmployeeSalaryBtn', function () {
                var addEmployeeSalaryModal = new bootstrap.Modal(document.getElementById('addEmployeeSalaryModal'))
                addEmployeeSalaryModal.show();
                let dataRoute = $(this).data('route');
                $('.addEmployeeSalaryRoute').attr('action', dataRoute)
            });

            $(document).on('click', '.employeeSalaryEdit', function () {
                var editEmployeeSalaryModal = new bootstrap.Modal(document.getElementById('editEmployeeSalaryModal'))
                editEmployeeSalaryModal.show();

                let dataRoute = $(this).data('route');
                $('.editEmployeeSalaryRoute').attr('action', dataRoute);

                let salaryList = $(this).data('employeesalary');
                $('.selectedEmployeeSalary').val(salaryList.employee_id);
                $('.employeeSalaryAmount').val(salaryList.amount);

                const datetimeString = salaryList.payment_date;
                const dateObject = new Date(datetimeString);
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const formattedDate = dateObject.toLocaleDateString('en-US', options);
                $('.employeeSalaryPaymentDate').val(formattedDate);
            });

            $(document).on('click', '.deleteEmployeeSalary', function () {
                var deleteEmployeeSalaryModal = new bootstrap.Modal(document.getElementById('deleteEmployeeSalaryModal'))
                deleteEmployeeSalaryModal.show();

                let dataRoute = $(this).data('route');

                $('.deleteEmployeeSalaryRoute').attr('action', dataRoute);

            });
        });
    </script>
@endpush
