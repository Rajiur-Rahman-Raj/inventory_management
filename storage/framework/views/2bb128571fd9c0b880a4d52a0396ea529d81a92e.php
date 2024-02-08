<?php $__env->startSection('title',trans('Create New Role')); ?>

<?php $__env->startSection('content'); ?>
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Create New Role'); ?></h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>

                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.role')); ?>"><?php echo app('translator')->get('Role List'); ?></a>
                                    </li>

                                    <li class="breadcrumb-item active"
                                        aria-current="page"><?php echo app('translator')->get('Create Role'); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="<?php echo e(route('user.role')); ?>"
                               class="btn btn-custom text-white create__ticket">
                                <i class="fas fa-backward"></i> <?php echo app('translator')->get('Back'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <!-- profile setting -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-12 m-0">
                            <form method="post" action="<?php echo e(route('user.roleStore')); ?>"
                                  class="mt-4" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <div class="input-box">
                                            <h6 for="name" class="font-weight-bold text-dark"> <?php echo app('translator')->get('Role Name'); ?> <span
                                                    class="text-danger">*</span></h6>
                                            <input type="text" name="name"
                                                   placeholder="Enter role name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   value="<?php echo e(old('name')); ?>">
                                            <div class="invalid-feedback">
                                                <?php $__errorArgs = ['name'];
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
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold text-dark"><?php echo app('translator')->get('Status'); ?></label>
                                        <div class="selectgroup">
                                            <select class="form-control js-example-basic-single" name="status"
                                                    aria-label="Default select example">
                                                <option
                                                    value="1" <?php echo e(@request()->status == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('Active'); ?></option>
                                                <option
                                                    value="0" <?php echo e(@request()->deactive == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('Deactive'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-4 card-primary ">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <div class="title">
                                                    <h5 class="accessibility"><?php echo app('translator')->get('Accessibility'); ?></h5>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <table width="100%" class="select-all-access">
                                                    <thead class="permission-group">
                                                    <tr>
                                                        <th class="p-2"><?php echo app('translator')->get('Permissions Group'); ?></th>
                                                        <th class="p-2"><input type="checkbox" class="selectAll"
                                                                               name="accessAll" id="allowAll"> <label
                                                                class="mb-0" for="allowAll">Allow All
                                                                Permissions</label>
                                                        </th>

                                                        <th class="p-2">Permission</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if(config('permissionList')): ?>
                                                        <?php
                                                            $i = 0;
                                                            $j = 500;
                                                        ?>

                                                        <?php $__currentLoopData = collect(config('permissionList')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $i++;
                                                            ?>
                                                            <tr class="partiallyCheckAll<?php echo e($i); ?>">
                                                                <td class="ps-2">
                                                                    <strong>
                                                                        <input type="checkbox"
                                                                               class="partiallySelectAll<?php echo e($i); ?>"
                                                                               name="partiallyAccessAll"
                                                                               id="partiallySelectAll<?php echo e($i); ?>"
                                                                               onclick="partiallySelectAll(<?php echo e($i); ?>)">
                                                                        <label
                                                                            for="partiallySelectAll<?php echo e($i); ?>"><?php echo app('translator')->get(str_replace('_', ' ', $key1)); ?></label>
                                                                    </strong>
                                                                </td>
                                                                <?php if(1 == count($permission)): ?>
                                                                    <td class="border-left ps-2">
                                                                        <input type="checkbox"
                                                                               class="cursor-pointer singlePermissionSelectAll<?php echo e($i); ?>"
                                                                               id="singlePermissionSelect<?php echo e($i); ?>"
                                                                               value="<?php echo e(join(",",collect($permission)->collapse()['permission']['view'])); ?>"
                                                                               onclick="singlePermissionSelectAll(<?php echo e($i); ?>)"
                                                                               name="permissions[]"/>
                                                                        <label
                                                                            for="singlePermissionSelect<?php echo e($i); ?>"><?php echo e(str_replace('_', ' ', collect($permission)->keys()[0])); ?></label>
                                                                    </td>
                                                                    <td class="ps-2 border-left" style="width: 178px;">
                                                                        <ul class="list-unstyled">
                                                                            <?php if(!empty(collect($permission)->collapse()['permission']['view'])): ?>
                                                                                <li>
                                                                                    <?php if(!empty(collect($permission)->collapse()['permission']['view'])): ?>
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="<?php echo e(join(",",collect($permission)->collapse()['permission']['view'])); ?>"
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/> <?php echo app('translator')->get('View'); ?>
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                            <?php endif; ?>

                                                                            <?php if(!empty(collect($permission)->collapse()['permission']['add'])): ?>
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                           value="<?php echo e(join(",",collect($permission)->collapse()['permission']['add'])); ?>"
                                                                                           class="cursor-pointer"
                                                                                           name="permissions[]"/> <?php echo app('translator')->get('Add'); ?>
                                                                                </li>
                                                                            <?php endif; ?>

                                                                            <?php if(!empty(collect($permission)->collapse()['permission']['edit'])): ?>
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                           value="<?php echo e(join(",",collect($permission)->collapse()['permission']['edit'])); ?>"
                                                                                           class="cursor-pointer"
                                                                                           name="permissions[]"/>
                                                                                    <?php echo app('translator')->get('Edit'); ?>
                                                                                </li>
                                                                            <?php endif; ?>

                                                                            <?php if(!empty(collect($permission)->collapse()['permission']['delete'])): ?>
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                           value="<?php echo e(join(",",collect($permission)->collapse()['permission']['delete'])); ?>"
                                                                                           class="cursor-pointer"
                                                                                           name="permissions[]"/>
                                                                                    <?php echo app('translator')->get('Delete'); ?>
                                                                                </li>
                                                                            <?php endif; ?>

                                                                            <?php if(collect($permission)->keys()[0] == 'Companies'): ?>
                                                                                <?php if(!empty(collect($permission)->collapse()['permission']['switch'])): ?>
                                                                                    <li>
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="<?php echo e(join(",",collect($permission)->collapse()['permission']['switch'])); ?>"
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/>
                                                                                        <?php echo app('translator')->get('Switch'); ?>
                                                                                    </li>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <?php if(collect($permission)->keys()[0] == 'Sales_List'): ?>
                                                                                <?php if(!empty(collect($permission)->collapse()['permission']['return'])): ?>
                                                                                    <li>
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="<?php echo e(join(",",collect($permission)->collapse()['permission']['return'])); ?>"
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/>
                                                                                        <?php echo app('translator')->get('Sales Return'); ?>
                                                                                    </li>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <?php if(collect($permission)->keys()[0] == 'Purchase_Report'): ?>
                                                                                <?php if(!empty(collect($permission)->collapse()['permission']['export'])): ?>
                                                                                    <li>
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="<?php echo e(join(",",collect($permission)->collapse()['permission']['export'])); ?>"
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/>
                                                                                        <?php echo app('translator')->get('Export'); ?>
                                                                                    </li>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>

                                                                        </ul>
                                                                    </td>
                                                                <?php else: ?>
                                                                    <td colspan="2">
                                                                        <!-- Nested table for the second column -->
                                                                        <table class="child-table">
                                                                            <tbody>
                                                                            <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php
                                                                                    $j++;
                                                                                ?>
                                                                                <tr class="partiallyCheckAll<?php echo e($j); ?>">
                                                                                    <td class="p-2">
                                                                                        <input type="checkbox"
                                                                                               class="cursor-pointer multiplePermissionSelectAll<?php echo e($j); ?>"
                                                                                               id="multiplePermissionSelectAll<?php echo e($j); ?>"
                                                                                               value="<?php echo e(join(",",$subMenu['permission']['view'])); ?>"
                                                                                               onclick="multiplePermissionSelectAll(<?php echo e($j); ?>)"
                                                                                               name="permissions[]">
                                                                                        <label class="mb-0"
                                                                                               for="multiplePermissionSelectAll<?php echo e($j); ?>"><?php echo app('translator')->get(str_replace('_', ' ', $key2)); ?></label>
                                                                                    </td>

                                                                                    <td class="ps-2 border-left  multiplePermissionCheck<?php echo e($j); ?>"
                                                                                        style="width: 178px;">
                                                                                        <ul class="list-unstyled py-2 mb-0">
                                                                                            <?php if(!empty($subMenu['permission']['view'])): ?>
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="<?php echo e(join(",",$subMenu['permission']['view'])); ?>"
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]">
                                                                                                    View
                                                                                                </li>
                                                                                            <?php endif; ?>

                                                                                            <?php if(!empty($subMenu['permission']['add'])): ?>
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="<?php echo e(join(",",$subMenu['permission']['add'])); ?>"
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]"/> <?php echo app('translator')->get('Add'); ?>
                                                                                                </li>
                                                                                            <?php endif; ?>

                                                                                            <?php if(!empty($subMenu['permission']['edit'])): ?>
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="<?php echo e(join(",",$subMenu['permission']['edit'])); ?>"
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]"/> <?php echo app('translator')->get('Edit'); ?>
                                                                                                </li>
                                                                                            <?php endif; ?>

                                                                                            <?php if(!empty($subMenu['permission']['delete'])): ?>
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="<?php echo e(join(",",$subMenu['permission']['delete'])); ?>"
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]"/> <?php echo app('translator')->get('Delete'); ?>
                                                                                                </li>
                                                                                            <?php endif; ?>

                                                                                            <?php if($key1 == 'Manage_Companies'): ?>
                                                                                                <?php if(!empty($subMenu['permission']['switch'])): ?>
                                                                                                    <li>
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            value="<?php echo e(join(",",$subMenu['permission']['switch'])); ?>"
                                                                                                            class="cursor-pointer"
                                                                                                            name="permissions[]"/>
                                                                                                        <?php echo app('translator')->get('Switch'); ?>
                                                                                                    </li>
                                                                                                <?php endif; ?>
                                                                                            <?php endif; ?>

                                                                                            <?php if($key1 == 'Manage_Sales'): ?>
                                                                                                <?php if(!empty($subMenu['permission']['return'])): ?>
                                                                                                    <li>
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            value="<?php echo e(join(",",$subMenu['permission']['return'])); ?>"
                                                                                                            class="cursor-pointer"
                                                                                                            name="permissions[]"/>
                                                                                                        <?php echo app('translator')->get('Return'); ?>
                                                                                                    </li>
                                                                                                <?php endif; ?>
                                                                                            <?php endif; ?>

                                                                                            <?php if($key1 == 'Manage_Reports'): ?>
                                                                                                <?php if(!empty($subMenu['permission']['export'])): ?>
                                                                                                    <li>
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            value="<?php echo e(join(",",$subMenu['permission']['export'])); ?>"
                                                                                                            class="cursor-pointer"
                                                                                                            name="permissions[]"/>
                                                                                                        <?php echo app('translator')->get('Export'); ?>
                                                                                                    </li>
                                                                                                <?php endif; ?>
                                                                                            <?php endif; ?>

                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="invalid-feedback d-block">
                                                <?php $__errorArgs = ['permissions'];
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

                                <button type="submit"
                                        class="btn waves-effect btn-custom waves-light btn-rounded  btn-block mt-3 w-100">
                                    <?php echo app('translator')->get('Create Role'); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        'use strict'
        function partiallySelectAll($key1) {
            if ($(`.partiallySelectAll${$key1}`).prop('checked') == true) {
                $(`.partiallyCheckAll${$key1}`).find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                $(`.partiallyCheckAll${$key1}`).find('input[type="checkbox"]').removeAttr('checked');
            }
        }

        function singlePermissionSelectAll($key) {
            if ($(`.singlePermissionSelectAll${$key}`).prop('checked') == true) {
                $(`.partiallyCheckAll${$key}`).find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                $(`.partiallyCheckAll${$key}`).find('input[type="checkbox"]').removeAttr('checked');
            }
        }

        function multiplePermissionSelectAll($key) {
            if ($(`.multiplePermissionSelectAll${$key}`).prop('checked') == true) {
                $(`.multiplePermissionCheck${$key}`).find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                $(`.multiplePermissionCheck${$key}`).find('input[type="checkbox"]').removeAttr('checked');
            }
        }

        $(document).ready(function () {
            $('.selectAll').on('click', function () {
                if ($(this).is(':checked')) {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').attr('checked', 'checked')
                } else {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').removeAttr('checked')
                    $('.allAccordianShowHide').removeClass('show');
                }
            })
        })
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/role_permission/createRole.blade.php ENDPATH**/ ?>