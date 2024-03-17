@extends($theme.'layouts.user')
@section('title', trans('Category List'))
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
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Category List')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Category List')</li>
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
                            <label for="">@lang('Name')</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', @request()->name) }}"
                                class="form-control"
                                placeholder="@lang('Category Name')"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i>@lang('Search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_Category.permission.add'))))
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" class="btn btn-custom text-white addNewCategory"> <i
                            class="fa fa-plus-circle"></i> @lang('Add Category')</a>
                </div>
            @endif

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Category')</th>
                        @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_Category.permission.edit'), config('permissionList.Manage_Expense.Expense_Category.permission.delete'))))
                            <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($expenseCategories as $key => $category)
                        <tr>
                            <td data-label="@lang('SL')">{{loopIndex($expenseCategories) + $key}}</td>

                            <td data-label="@lang('Category')">{{ $category->name }}</td>

                            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_Category.permission.edit'), config('permissionList.Manage_Expense.Expense_Category.permission.delete'))))
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
                                            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_Category.permission.edit'))))
                                                <li>
                                                    <a class="dropdown-item btn updateExpenseCategory"
                                                       data-route="{{route('user.updateExpenseCategory', $category->id)}}"
                                                       data-property="{{ $category }}">
                                                        <i class="fas fa-edit"></i> @lang('Edit')
                                                    </a>
                                                </li>
                                            @endif

                                            @if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_Category.permission.delete'))))
                                                <li>
                                                    <a class="dropdown-item btn deleteExpenseCategory"
                                                       data-route="{{route('user.deleteExpenseCategory', $category->id)}}"
                                                       data-property="{{ $category }}">
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
                {{ $expenseCategories->appends($_GET)->links($theme.'partials.pagination') }}
            </div>
        </div>
    </section>

    @push('loadModal')
        {{--  Add Item modal --}}
        <div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="{{ route('user.expenseCategoryStore') }}" method="post" class="login-form"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">@lang('Add New Category')</h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for="">@lang('Name')</label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="form-control @error('name') is-invalid @enderror"
                                                    name="name"
                                                    value="{{old('name')}}"
                                                    placeholder="@lang('Category Name')" required>
                                            </div>
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
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

        {{--  Edit Category modal --}}
        <div class="modal fade" id="editCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="" method="post" class="edit-category-form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">@lang('Edit Category')</h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for="">@lang('Category Name')</label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control @error('name') is-invalid @enderror category-name"
                                                    name="name"
                                                    value="{{old('name')}}"
                                                    placeholder="@lang('Enter Item Name')" required>
                                            </div>
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
        <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-category-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <form action="" method="post" class="deleteCategoryRoute">
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


            $(document).on('click', '.addNewCategory', function () {
                var addCategoryModal = new bootstrap.Modal(document.getElementById('addCategoryModal'))
                addCategoryModal.show();


            });

            $(document).on('click', '.updateExpenseCategory', function () {
                var editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'))
                editCategoryModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.edit-category-form').attr('action', dataRoute);
                $('.category-name').val(dataProperty.name);
            });


            $(document).on('click', '.deleteExpenseCategory', function () {
                var deleteCategoryModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'))
                deleteCategoryModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');
                $('.deleteCategoryRoute').attr('action', dataRoute)
                $('.delete-category-name').text(`Are you sure to delete ${dataProperty.name}?`)

            });
        });
    </script>
@endpush
