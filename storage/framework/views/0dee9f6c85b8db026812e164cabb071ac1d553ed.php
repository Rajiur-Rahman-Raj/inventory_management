<?php $__env->startSection('title', trans('Affiliate Members')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Affiliate Member List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Affiliate Members'); ?></li>
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
                                placeholder="<?php echo app('translator')->get('Member Name'); ?>"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for=""><?php echo app('translator')->get('Email'); ?></label>
                            <input
                                type="text"
                                name="email"
                                value="<?php echo e(old('email', @request()->email)); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Member Email'); ?>"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for=""><?php echo app('translator')->get('Phone'); ?></label>
                            <input
                                type="text"
                                name="phone"
                                value="<?php echo e(old('phone', @request()->phone)); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Member Phone'); ?>"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="from_date"><?php echo app('translator')->get('From Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-2">
                            <label for="to_date"><?php echo app('translator')->get('To Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>"
                                autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate.Affiliate.permission.add')))): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="<?php echo e(route('user.createAffiliateMember')); ?>" class="btn btn-custom text-white "> <i
                            class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add Member'); ?></a>
                </div>
            <?php endif; ?>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Member'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Sales Center'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Phone'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Division'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('District'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Commission'); ?>(%)</th>
                        <th scope="col"><?php echo app('translator')->get('Join Date'); ?></th>
                        <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate.Affiliate.permission.view'), config('permissionList.Manage_Affiliate.Affiliate.permission.edit'), config('permissionList.Manage_Affiliate.Affiliate.permission.delete')))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $affiliateMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($affiliateMembers) + $key); ?></td>

                            <td data-label="<?php echo app('translator')->get('Member'); ?>">
                                <?php echo e($member->member_name); ?>

                            </td>

                            <td data-label="<?php echo app('translator')->get('Sales Center'); ?>">
                                <?php if(count($member->salesCenter) > 0): ?>
                                    <?php $__currentLoopData = $member->salesCenter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-success"><?php echo e($salesCenter->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Phone'); ?>">
                                <?php echo e($member->phone); ?></td>
                            <td data-label="<?php echo app('translator')->get('Division'); ?>"><?php echo e(optional($member->division)->name); ?></td>
                            <td data-label="<?php echo app('translator')->get('District'); ?>"><?php echo e(optional($member->district)->name); ?></td>
                            <td data-label="<?php echo app('translator')->get('Commission'); ?>"><?php echo e($member->member_commission); ?></td>
                            <td data-label="<?php echo app('translator')->get('Join Date'); ?>"><?php echo e(dateTime($member->created_at)); ?></td>

                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate.Affiliate.permission.view'), config('permissionList.Manage_Affiliate.Affiliate.permission.edit'), config('permissionList.Manage_Affiliate.Affiliate.permission.delete')))): ?>
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
                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate.Affiliate.permission.view')))): ?>
                                                <li>
                                                    <a href="<?php echo e(route('user.affiliateMemberDetails', $member->id)); ?>"
                                                       class="dropdown-item"> <i
                                                            class="fal fa-eye"></i> <?php echo app('translator')->get('Details'); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate.Affiliate.permission.edit')))): ?>
                                                <li>
                                                    <a class="dropdown-item btn"
                                                       href="<?php echo e(route('user.affiliateMemberEdit', $member->id)); ?>">
                                                        <i class="fas fa-edit"></i> <?php echo app('translator')->get('Edit'); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if(adminAccessRoute(array_merge(config('permissionList.Manage_Affiliate.Affiliate.permission.delete')))): ?>
                                                <li>
                                                    <a class="dropdown-item btn deleteMember"
                                                       data-route="<?php echo e(route('user.affiliateMemberDelete', $member->id)); ?>"
                                                       data-property="<?php echo e($member); ?>">
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
                <?php echo e($affiliateMembers->appends($_GET)->links($theme.'partials.pagination')); ?>

            </div>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        <!-- Modal -->
        <div class="modal fade" id="deleteMemberModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-member-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="deleteCustomerRoute">
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
    <script src="<?php echo e(asset('assets/global/js/bootstrap-datepicker.js')); ?>"></script>
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

            $(document).on('click', '.deleteMember', function () {
                var deleteMemberModal = new bootstrap.Modal(document.getElementById('deleteMemberModal'))
                deleteMemberModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.deleteCustomerRoute').attr('action', dataRoute)

                $('.delete-member-name').text(`Are you sure to delete ${dataProperty.member_name}?`)

            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/affiliate/index.blade.php ENDPATH**/ ?>