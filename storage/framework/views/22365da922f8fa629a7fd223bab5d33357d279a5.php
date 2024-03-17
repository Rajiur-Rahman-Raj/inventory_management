<?php $__env->startSection('title', trans('Available Roles')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap-datepicker.css')); ?>"/>
    <?php $__env->stopPush(); ?>
    <!-- Invest history -->
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Available Roles'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Available Roles'); ?></li>
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
                            <label for=""><?php echo app('translator')->get('Role'); ?></label>
                            <select class="form-control js-example-basic-single" name="role_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <?php $__currentLoopData = $allRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($role->id); ?>" <?php echo e(@request()->role_id == $role->id ? 'selected' : ''); ?>><?php echo e($role->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-4">
                            <label for=""><?php echo app('translator')->get('Status'); ?></label>
                            <select class="form-control js-example-basic-single" name="status"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <option
                                    value="active" <?php echo e(@request()->status == 'active' ? 'selected' : ''); ?>><?php echo app('translator')->get('Active'); ?></option>
                                <option
                                    value="deactive" <?php echo e(@request()->deactive == 'deactive' ? 'selected' : ''); ?>><?php echo app('translator')->get('Deactive'); ?></option>
                            </select>
                        </div>

                        <div class="input-box col-lg-4">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <?php if(adminAccessRoute(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.add'))): ?>
                    <?php if(userType() == 1): ?>
                        <a href="<?php echo e(route('user.createRole')); ?>" class="btn btn-custom text-white"> <i
                                class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Create Role'); ?></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.edit'), config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.delete')))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($roles) + $key); ?></td>

                            <td data-label="<?php echo app('translator')->get('Name'); ?>"> <?php echo e($role->name); ?> </td>
                            <td data-label="<?php echo app('translator')->get('Status'); ?>" class="font-weight-bold">
                                <span
                                    class="badge <?php echo e($role->status == 1 ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($role->status == 1 ? 'Active' : 'Deactive'); ?> </span>
                            </td>

                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.edit'), config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.delete')))): ?>
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
                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.edit')))): ?>
                                                <li>
                                                    <a href="<?php echo e(route('user.editRole', $role->id)); ?>"
                                                       class="dropdown-item"> <i class="fal fa-edit"></i> <?php echo app('translator')->get('Edit'); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Available_Roles.permission.delete')))): ?>
                                                <li>
                                                    <a class="dropdown-item btn deleteRole"
                                                       data-route="<?php echo e(route('user.deleteRole', $role->id)); ?>"
                                                       data-property="<?php echo e($role); ?>">
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
                            <td colspan="100%" class="text-danger text-center"><?php echo e(trans('No Available Roles')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($roles->appends($_GET)->links($theme.'partials.pagination')); ?>

            </div>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        <!--Delete Role Modal -->
        <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-role-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="deleteRoleRoute">
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/role_permission/roleList.blade.php ENDPATH**/ ?>