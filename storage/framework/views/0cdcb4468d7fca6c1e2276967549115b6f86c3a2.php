<?php $__env->startSection('title', trans('Employee Salary List')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Employee Salary List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page"><?php echo app('translator')->get('Employee Salary List'); ?></li>
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
                            <label for="employee_id"><?php echo app('translator')->get('Employee'); ?></label>
                            <select class="form-control js-example-basic-single" name="employee_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($employee->id); ?>" <?php echo e(old('employee_id', @request()->employee_id) == $employee->id ? 'selected' : ''); ?>><?php echo e($employee->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date"><?php echo app('translator')->get('From Date'); ?></label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="<?php echo app('translator')->get('select date'); ?>"
                                           class="form-control from_date"
                                           name="from_date"
                                           value="<?php echo e(old('from_date',request()->from_date)); ?>"
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
                            <label for="to_date"><?php echo app('translator')->get('To Date'); ?></label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="<?php echo app('translator')->get('select date'); ?>"
                                           class="form-control to_date"
                                           name="to_date"
                                           value="<?php echo e(old('to_date',request()->to_date)); ?>"
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
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Salary_List.permission.add')))): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" class="btn btn-custom text-white addEmployeeSalaryBtn"
                       data-route="<?php echo e(route('user.addEmployeeSalary')); ?>"> <i
                            class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add Employee Salary'); ?></a>
                </div>
            <?php endif; ?>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('Employee'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Salary Paid'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Payment Date'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $employeeSalaryLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $salaryList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="company-logo" data-label="<?php echo app('translator')->get('Employee'); ?>">
                                <div>
                                    <a href="" target="_blank">
                                        <img
                                            src="<?php echo e(getFile(optional($salaryList->employee)->driver, optional($salaryList->employee)->image)); ?>">
                                    </a>
                                </div>
                                <div>
                                    <a href=""
                                       target="_blank"><?php echo e(optional($salaryList->employee)->name); ?></a>
                                    <br>
                                    <?php if(optional($salaryList->employee)->email): ?>
                                        <span class="text-muted font-14">
                                        <span><?php echo e(optional($salaryList->employee)->email); ?></span>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Salary Paid'); ?>"><?php echo e($salaryList->amount); ?> <?php echo e($basic->currency_symbol); ?></td>

                            <td data-label="<?php echo app('translator')->get('Payment Date'); ?>"><?php echo e(customDate($salaryList->payment_date)); ?></td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Salary_List.permission.edit')))): ?>
                                            <li>





                                                <a href="javascript:void(0)"
                                                   class="dropdown-item btn employeeSalaryEdit"
                                                   data-route="<?php echo e(route('user.employeeSalaryEdit', $salaryList->id)); ?>" data-employeesalary="<?php echo e($salaryList); ?>"> <i
                                                        class="fa fa-edit"></i> <?php echo app('translator')->get('Edit'); ?></a>

                                            </li>
                                        <?php endif; ?>

                                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Salary_List.permission.delete')))): ?>
                                            <li>
                                                <a class="dropdown-item btn deleteEmployeeSalary"
                                                   data-route="<?php echo e(route('user.employeeSalaryDelete', $salaryList->id)); ?>">
                                                    <i class="fas fa-trash-alt"></i> <?php echo app('translator')->get('Delete'); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            </td>
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
        <!-- Modal -->
        <div class="modal fade" id="addEmployeeSalaryModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <form action="" method="post" class="addEmployeeSalaryRoute">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header modal-primary modal-header-custom">
                            <h4 class="modal-title"><?php echo app('translator')->get('Add Employee Salary'); ?></h4>
                            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="input-box col-lg-12">
                                    <label for="employee_id"><?php echo app('translator')->get('Select Employee'); ?></label>
                                    <select class="form-control" name="employee_id"
                                            aria-label="Default select example">
                                        <option value="" selected disabled><?php echo app('translator')->get('Select Employee'); ?></option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($employee->id); ?>" <?php echo e(old('employee_id', @request()->employee_id) == $employee->id ? 'selected' : ''); ?>><?php echo e($employee->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="amount"> <?php echo app('translator')->get('Amount'); ?></label>
                                    <div class="input-group">
                                        <input type="text" name="amount"
                                               class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                               value="<?php echo e(old('amount')); ?>">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group">
                                                <?php echo e($basic->currency_symbol); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="invalid-feedback">
                                        <?php $__errorArgs = ['current_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="payment_date"><?php echo app('translator')->get('Payment Date'); ?> <span
                                            class="text-dark"></span></label>
                                    <div class="flatpickr">
                                        <div class="input-group">
                                            <input type="date"
                                                   placeholder="<?php echo app('translator')->get('select date'); ?>"
                                                   class="form-control payment_date"
                                                   name="payment_date"
                                                   value="<?php echo e(old('payment_date',request()->payment_date)); ?>"
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
                                                <?php $__errorArgs = ['payment_date'];
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
                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>


                            <button type="submit" class="btn btn-sm btn-custom text-white"><?php echo app('translator')->get('Yes'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editEmployeeSalaryModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <form action="" method="post" class="editEmployeeSalaryRoute">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header modal-primary modal-header-custom">
                            <h4 class="modal-title"><?php echo app('translator')->get('Edit Employee Salary'); ?></h4>
                            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="input-box col-lg-12">
                                    <label for="employee_id"><?php echo app('translator')->get('Select Employee'); ?></label>
                                    <select class="form-control selectedEmployeeSalary" name="employee_id"
                                            aria-label="Default select example">
                                        <option value="" selected disabled><?php echo app('translator')->get('Select Employee'); ?></option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($employee->id); ?>" <?php echo e(old('employee_id', @request()->employee_id) == $employee->id ? 'selected' : ''); ?>><?php echo e($employee->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="amount"> <?php echo app('translator')->get('Amount'); ?></label>
                                    <div class="input-group">
                                        <input type="text" name="amount"
                                               class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> employeeSalaryAmount"
                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                               value="">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group">
                                                <?php echo e($basic->currency_symbol); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="invalid-feedback">
                                        <?php $__errorArgs = ['current_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="input-box col-md-12 mt-3">
                                    <label for="payment_date"><?php echo app('translator')->get('Payment Date'); ?> <span
                                            class="text-dark"></span></label>
                                    <div class="flatpickr">
                                        <div class="input-group">
                                            <input type="date"
                                                   placeholder="<?php echo app('translator')->get('select date'); ?>"
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
                                                <?php $__errorArgs = ['payment_date'];
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
                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>


                            <button type="submit" class="btn btn-sm btn-custom text-white"><?php echo app('translator')->get('Yes'); ?></button>
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
                        <h4 class="modal-title"><?php echo app('translator')->get('Delete Confirmation'); ?></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="">Are you sure to delete?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="deleteEmployeeSalaryRoute">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('delete'); ?>
                            <button type="submit" class="btn btn-sm btn-custom text-white"><?php echo app('translator')->get('Yes'); ?></button>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/employeeSalary/index.blade.php ENDPATH**/ ?>