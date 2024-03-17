<?php $__env->startSection('title', trans('Staff List')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Staff List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Staff List'); ?></li>
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
                            <label for=""><?php echo app('translator')->get('Name'); ?></label>
                            <input
                                type="text"
                                name="name"
                                value="<?php echo e(old('name', @request()->name)); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Name'); ?>"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for=""><?php echo app('translator')->get('Email'); ?></label>
                            <input
                                type="text"
                                name="email"
                                value="<?php echo e(old('email', @request()->email)); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Email'); ?>"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for=""><?php echo app('translator')->get('Phone'); ?></label>
                            <input
                                type="text"
                                name="phone"
                                value="<?php echo e(old('phone', @request()->phone)); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Phone'); ?>"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="username"><?php echo app('translator')->get('Username'); ?></label>
                            <input
                                type="text" class="form-control datepicker username" name="username"
                                value="<?php echo e(old('username',request()->username)); ?>" placeholder="<?php echo app('translator')->get('username'); ?>"
                                autocomplete="off"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="password"><?php echo app('translator')->get('Password'); ?></label>
                            <input
                                type="text" class="form-control datepicker password" name="password"
                                value="<?php echo e(old('password',request()->password)); ?>" placeholder="<?php echo app('translator')->get('password'); ?>"
                                autocomplete="off"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(adminAccessRoute(config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.add'))): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="<?php echo e(route('user.role.staffCreate')); ?>" class="btn btn-custom text-white"> <i
                            class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Create Staff'); ?></a>
                </div>
            <?php endif; ?>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('User'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Role'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.edit'), config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.delete')))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $roleUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($roleUsers) + $key); ?></td>

                            <td class="company-logo" data-label="<?php echo app('translator')->get('User'); ?>">
                                <div>
                                    <a href="" target="_blank">
                                        <img src="<?php echo e(getFile($value->driver, $value->image)); ?>">
                                    </a>
                                </div>
                                <div>
                                    <a href=""
                                       target="_blank"> <?php echo e($value->name); ?></a>
                                    <br>
                                    <?php if($value->email): ?>
                                        <span class="text-muted font-14">
                                        <span> <?php echo e($value->email); ?></span>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Role'); ?>">
                                <?php echo e(str_replace('_',' ',ucfirst(optional($value->role)->name))); ?>

                            </td>


                            <td data-label="Status">
                                <?php if($value->status == 1): ?>
                                    <span class="badge bg-success"> <?php echo app('translator')->get('Active'); ?> </span>
                                <?php else: ?>
                                    <span class="badge bg-success"> <?php echo app('translator')->get('Deactive'); ?> </span>
                                <?php endif; ?>
                            </td>

                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.edit'), config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.delete')))): ?>
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
                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Role_And_Permissions.Manage_Staff.permission.edit')))): ?>
                                                <li>
                                                    <a class="dropdown-item btn"
                                                       href="<?php echo e(route('user.role.staffEdit', $value->id)); ?>">
                                                        <i class="fas fa-edit"></i> <?php echo app('translator')->get('Edit'); ?>
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
                <?php echo e($roleUsers->appends($_GET)->links($theme.'partials.pagination')); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/role_permission/staffList.blade.php ENDPATH**/ ?>