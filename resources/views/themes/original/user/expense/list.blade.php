@extends($theme.'layouts.user')
@section('title', trans('Expense List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Expense List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Expense List')</li>
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
                            <label for="category_id"
                                   class="mb-2">@lang('Category')</label>
                            <select
                                class="form-select js-example-basic-single"
                                name="category_id"
                                aria-label="Default select example">
                                <option value="" selected
                                        disabled>@lang('Select Category')</option>
                                @foreach($expenseCategories as $category)
                                    <option
                                        value="{{ $category->id }}" {{ old('category_id', @request()->category_id) == $category->id ? 'selected' : ''}}> @lang($category->name)</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback d-block">
                                @error('category_id') @lang($message) @enderror
                            </div>

                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date">@lang('From Date')</label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="{{ old('from_date',request()->from_date) }}" placeholder="@lang('From date')"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="to_date">@lang('To Date')</label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="{{ old('to_date',request()->to_date) }}" placeholder="@lang('To date')"
                                autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.add'))))
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" class="btn btn-custom text-white addNewExpense"> <i
                            class="fa fa-plus-circle"></i> @lang('Add Expense')</a>
                </div>
            @endif

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Category')</th>
                        <th scope="col">@lang('Amount')</th>
                        <th scope="col">@lang('Date Of Expense')</th>
                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.edit'), config('permissionList.Manage_Expense.Expense_List.permission.delete'))))
                            <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($expenseList as $key => $expense)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($expenseList) + $key}}</td>

                            <td data-label="@lang('Category')">{{ optional($expense->expenseCategory)->name }}</td>
                            <td data-label="@lang('Amount')">{{ $expense->amount }}</td>
                            <td data-label="@lang('Date')">{{ customDate($expense->expense_date) }}</td>

                            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.edit'), config('permissionList.Manage_Expense.Expense_List.permission.delete'))))
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
                                            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.edit'))))
                                                <li>
                                                    <a class="dropdown-item btn updateExpenseList"
                                                       data-route="{{route('user.updateExpenseList', $expense->id)}}"
                                                       data-property="{{ $expense }}">
                                                        <i class="fas fa-edit"></i> @lang('Edit')
                                                    </a>
                                                </li>
                                            @endif

                                            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.delete'))))
                                                <li>
                                                    <a class="dropdown-item btn deleteExpenseList"
                                                       data-route="{{route('user.deleteExpenseList', $expense->id)}}"
                                                       data-property="{{ $expense }}">
                                                        <i class="fas fa-trash-alt"></i> @lang('Delete')
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="100%" class="text-danger text-center">{{trans('No Data Found!')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $expenseList->appends($_GET)->links($theme.'partials.pagination') }}
            </div>
        </div>
    </section>

    @push('loadModal')
        {{--  Add Expense modal --}}
        <div class="modal fade" id="addExpenseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="{{ route('user.expenseListStore') }}" method="post" class="login-form"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">@lang('Add New Expense')</h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="input-box col-12 m-0">
                                            <label for="category_id"
                                                   class="mb-2">@lang('Category')</label>
                                            <select
                                                class="form-select"
                                                name="category_id"
                                                aria-label="Default select example">
                                                <option value="" selected
                                                        disabled>@lang('Select Category')</option>
                                                @foreach($expenseCategories as $category)
                                                    <option
                                                        value="{{ $category->id }}" {{ old('category_id', @request()->category_id) == $category->id ? 'selected' : ''}}> @lang($category->name)</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback d-block">
                                                @error('category_id') @lang($message) @enderror
                                            </div>
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="amount">@lang('Amount')</label>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control @error('amount') is-invalid @enderror"
                                                       name="amount"
                                                       value="{{old('amount')}}"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       placeholder="@lang('Expense Amount')" required>
                                            </div>
                                            @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="name">@lang('Expense Date') </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="@lang('Expense Date')"
                                                           class="form-control expense_date expenseDate"
                                                           name="expense_date"
                                                           value="{{ old('expense_date',request()->expense_date) }}"
                                                           data-input>
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control">
                                                            <a class="input-button cursor-pointer" title="clear"
                                                               data-clear>
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback d-block">
                                                        @error('expense_date') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn-custom">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{--  Edit Expense modal --}}
        <div class="modal fade" id="editExpenseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="" method="post" class="edit-expense-form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">@lang('Update Expense')</h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="input-box col-12 m-0">
                                            <label for="category_id"
                                                   class="mb-2">@lang('Category')</label>
                                            <select
                                                class="form-select expenseCategory"
                                                name="category_id"
                                                aria-label="Default select example">
                                                <option value="" selected
                                                        disabled>@lang('Select Category')</option>
                                                @foreach($expenseCategories as $category)
                                                    <option
                                                        value="{{ $category->id }}"> @lang($category->name)</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback d-block">
                                                @error('category_id') @lang($message) @enderror
                                            </div>
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="amount">@lang('Amount')</label>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control @error('amount') is-invalid @enderror expenseAmount"
                                                       name="amount"
                                                       value="{{old('amount')}}"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       placeholder="@lang('Expense Amount')" required>
                                            </div>
                                            @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="name">@lang('Expense Date') </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="@lang('Expense Date')"
                                                           class="form-control expense_date expenseDate"
                                                           name="expense_date"
                                                           value=""
                                                           data-input>
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control">
                                                            <a class="input-button cursor-pointer" title="clear"
                                                               data-clear>
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback d-block">
                                                        @error('expense_date') @lang($message) @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn-custom">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--Delete Item Modal -->
        <div class="modal fade" id="deleteExpenseModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-expense-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteExpenseRoute">
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
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>


    <script>
        'use strict'
        $(document).ready(function () {
            $(".flatpickr").flatpickr({
                wrap: true,
                altInput: true,
                dateFormat: "Y-m-d H:i",
            });

            $('.from_date').on('change', function () {
                $('.to_date').removeAttr('disabled');
            });


            $(document).on('click', '.addNewExpense', function () {
                var addExpenseModal = new bootstrap.Modal(document.getElementById('addExpenseModal'))
                addExpenseModal.show();


            });

            $(document).on('click', '.updateExpenseList', function () {
                var editExpenseModal = new bootstrap.Modal(document.getElementById('editExpenseModal'))
                editExpenseModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.expenseCategory').val(dataProperty.category_id);
                $('.expenseAmount').val(dataProperty.amount);
                $('.expenseDate').val(dataProperty.expense_date);
                $('.edit-expense-form').attr('action', dataRoute);
            });


            $(document).on('click', '.deleteExpenseList', function () {
                var deleteExpenseModal = new bootstrap.Modal(document.getElementById('deleteExpenseModal'))
                deleteExpenseModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');
                $('.deleteExpenseRoute').attr('action', dataRoute)
                $('.delete-expense-name').text(`Are you sure to delete ${dataProperty.expense_category.name}?`)
            });
        });
    </script>
@endpush
