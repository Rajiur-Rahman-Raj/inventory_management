<?php $__env->startSection('title', trans('Employee List')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Employee List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Employees'); ?></li>
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
                            <label for="from_joining_date"><?php echo app('translator')->get('From Joining Date'); ?></label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="<?php echo app('translator')->get('select date'); ?>"
                                           class="form-control from_joining_date"
                                           name="from_joining_date"
                                           value="<?php echo e(old('from_joining_date',request()->from_joining_date)); ?>"
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
                            <label for="to_date"><?php echo app('translator')->get('To Joining Date'); ?></label>
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date"
                                           placeholder="<?php echo app('translator')->get('select date'); ?>"
                                           class="form-control to_joining_date"
                                           name="to_joining_date"
                                           value="<?php echo e(old('to_joining_date',request()->to_joining_date)); ?>"
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

            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Employee_List.permission.add')))): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="<?php echo e(route('user.createEmployee')); ?>" class="btn btn-custom text-white "> <i
                            class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Create Employee'); ?></a>
                </div>
            <?php endif; ?>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('Employee'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Designation'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Joining Date'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Present Address'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $employeeLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="company-logo" data-label="<?php echo app('translator')->get('Employee'); ?>">
                                <div>
                                    <a href="" target="_blank">
                                        <img src="<?php echo e(getFile($employee->driver, $employee->image)); ?>">
                                    </a>
                                </div>
                                <div>
                                    <a href=""
                                       target="_blank"><?php echo e($employee->name); ?></a>
                                    <br>
                                    <?php if($employee->email): ?>
                                        <span class="text-muted font-14">
                                        <span><?php echo e($employee->email); ?></span>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Designation'); ?>"><?php echo e($employee->designation); ?></td>

                            <td data-label="<?php echo app('translator')->get('Joining Date'); ?>"><?php echo e(customDate($employee->joining_date)); ?></td>

                            <td data-label="<?php echo app('translator')->get('Present Address'); ?>"><?php echo e($employee->present_address); ?></td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="<?php echo e(route('user.employeeDetails', $employee->id)); ?>"
                                               class="dropdown-item"> <i class="fal fa-eye"></i> <?php echo app('translator')->get('Details'); ?> </a>
                                        </li>

                                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Employee_List.permission.edit')))): ?>
                                            <li>
                                                <a class="dropdown-item btn" href="<?php echo e(route('user.employeeEdit', $employee->id)); ?>">
                                                    <i class="fas fa-edit"></i> <?php echo app('translator')->get('Edit'); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Employees.Employee_List.permission.delete')))): ?>
                                            <li>
                                                <a class="dropdown-item btn deleteEmployee"
                                                   data-route="<?php echo e(route('user.employeeDelete', $employee->id)); ?>"
                                                   data-empname="<?php echo e($employee->name); ?>">
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
                <?php echo e($employeeLists->appends($_GET)->links($theme.'partials.pagination')); ?>

            </div>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        <!-- Modal -->
        <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-employee-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="deleteEmployeeRoute">
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/employee/index.blade.php ENDPATH**/ ?>