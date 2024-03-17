<?php $__env->startSection('title', trans('Expense List')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <!-- Invest history -->
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Expense List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Expense List'); ?></li>
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
                                   class="mb-2"><?php echo app('translator')->get('Category'); ?></label>
                            <select
                                class="form-select js-example-basic-single"
                                name="category_id"
                                aria-label="Default select example">
                                <option value="" selected
                                        disabled><?php echo app('translator')->get('Select Category'); ?></option>
                                <?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', @request()->category_id) == $category->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback d-block">
                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date"><?php echo app('translator')->get('From Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="to_date"><?php echo app('translator')->get('To Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>"
                                autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.add')))): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" class="btn btn-custom text-white addNewExpense"> <i
                            class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add Expense'); ?></a>
                </div>
            <?php endif; ?>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Category'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Amount'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Date Of Expense'); ?></th>
                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.edit'), config('permissionList.Manage_Expense.Expense_List.permission.delete')))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $expenseList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($expenseList) + $key); ?></td>

                            <td data-label="<?php echo app('translator')->get('Category'); ?>"><?php echo e(optional($expense->expenseCategory)->name); ?></td>
                            <td data-label="<?php echo app('translator')->get('Amount'); ?>"><?php echo e($expense->amount); ?></td>
                            <td data-label="<?php echo app('translator')->get('Date'); ?>"><?php echo e(customDate($expense->expense_date)); ?></td>

                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.edit'), config('permissionList.Manage_Expense.Expense_List.permission.delete')))): ?>
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
                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.edit')))): ?>
                                                <li>
                                                    <a class="dropdown-item btn updateExpenseList"
                                                       data-route="<?php echo e(route('user.updateExpenseList', $expense->id)); ?>"
                                                       data-property="<?php echo e($expense); ?>">
                                                        <i class="fas fa-edit"></i> <?php echo app('translator')->get('Edit'); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Expense.Expense_List.permission.delete')))): ?>
                                                <li>
                                                    <a class="dropdown-item btn deleteExpenseList"
                                                       data-route="<?php echo e(route('user.deleteExpenseList', $expense->id)); ?>"
                                                       data-property="<?php echo e($expense); ?>">
                                                        <i class="fas fa-trash-alt"></i> <?php echo app('translator')->get('Delete'); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="text-center">
                            <td colspan="100%" class="text-danger text-center"><?php echo e(trans('No Data Found!')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        
        <div class="modal fade" id="addExpenseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="<?php echo e(route('user.expenseListStore')); ?>" method="post" class="login-form"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Add New Expense'); ?></h5>
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
                                                   class="mb-2"><?php echo app('translator')->get('Category'); ?></label>
                                            <select
                                                class="form-select"
                                                name="category_id"
                                                aria-label="Default select example">
                                                <option value="" selected
                                                        disabled><?php echo app('translator')->get('Select Category'); ?></option>
                                                <?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', @request()->category_id) == $category->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($category->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <div class="invalid-feedback d-block">
                                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="amount"><?php echo app('translator')->get('Amount'); ?></label>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       name="amount"
                                                       value="<?php echo e(old('amount')); ?>"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       placeholder="<?php echo app('translator')->get('Expense Amount'); ?>" required>
                                            </div>
                                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="name"><?php echo app('translator')->get('Expense Date'); ?> </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="<?php echo app('translator')->get('Expense Date'); ?>"
                                                           class="form-control expense_date expenseDate"
                                                           name="expense_date"
                                                           value="<?php echo e(old('expense_date',request()->expense_date)); ?>"
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
                                                        <?php $__errorArgs = ['expense_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn-custom"><?php echo app('translator')->get('Submit'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="modal fade" id="editExpenseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="" method="post" class="edit-expense-form" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Update Expense'); ?></h5>
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
                                                   class="mb-2"><?php echo app('translator')->get('Category'); ?></label>
                                            <select
                                                class="form-select expenseCategory"
                                                name="category_id"
                                                aria-label="Default select example">
                                                <option value="" selected
                                                        disabled><?php echo app('translator')->get('Select Category'); ?></option>
                                                <?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($category->id); ?>"> <?php echo app('translator')->get($category->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <div class="invalid-feedback d-block">
                                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="amount"><?php echo app('translator')->get('Amount'); ?></label>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> expenseAmount"
                                                       name="amount"
                                                       value="<?php echo e(old('amount')); ?>"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       placeholder="<?php echo app('translator')->get('Expense Amount'); ?>" required>
                                            </div>
                                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="input-box col-12 m-0">
                                            <label for="name"><?php echo app('translator')->get('Expense Date'); ?> </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="<?php echo app('translator')->get('Expense Date'); ?>"
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
                                                        <?php $__errorArgs = ['expense_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn-custom"><?php echo app('translator')->get('Submit'); ?></button>
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
                        <h4 class="modal-title"><?php echo app('translator')->get('Delete Confirmation'); ?></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="delete-expense-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="deleteExpenseRoute">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('delete'); ?>
                            <button type="submit"
                                    class="btn btn-sm btn-custom text-white"><?php echo app('translator')->get('Yes'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>


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
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/expense/list.blade.php ENDPATH**/ ?>