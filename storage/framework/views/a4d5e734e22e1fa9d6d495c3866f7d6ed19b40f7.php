<?php $__env->startSection('title', 'Company List'); ?>

<?php $__env->startSection('content'); ?>
    <section class="payment-gateway">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="company-top d-flex justify-content-between">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('All Companies'); ?></h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Company List'); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="">
                            <a href="<?php echo e(route('user.createCompany')); ?>" class="btn btn-custom text-white create__ticket">
                                <i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Create Company'); ?></a>
                        </div>
                    </div>

                </div>
            </div>


            <?php if(count($companies) > 0): ?>
                <div class="badge-box-wrapper">
                    <div class="row g-4 mb-4">
                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xl-4 col-md-4 col-12 box">
                                <div
                                    class="badge-box  <?php echo e(Auth()->user()->active_company_id == null || Auth()->user()->active_company_id != $company->id ? 'locked' : ''); ?>">
                                    <img class="img-fluid"

                                         src="<?php echo e(getFile($company->driver, $company->logo)); ?>"
                                         alt=""/>
                                    <h3 class="m-0"><?php echo app('translator')->get($company->name); ?></h3>
                                    <p class=""><?php echo app('translator')->get($company->email); ?></p>
                                    <div class="text-start">
                                        <h5><?php echo app('translator')->get('Phone'); ?>: <span>
                                                <a href="tel:<?php echo e($company->phone); ?>"><?php echo e($company->phone); ?></a>
                                            </span>
                                        </h5>

                                        <h5><?php echo app('translator')->get('Address'); ?>: <span><?php echo e($company->address); ?></span></h5>
                                        <h5><?php echo app('translator')->get('Trade Id'); ?>: <span><?php echo e($company->trade_id); ?></span></h5>

                                    </div>
                                    <div class="lock-icon">
                                        <i class="far fa-lock-alt"></i>
                                    </div>
                                    <div class="sidebar-dropdown-items">
                                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <i class="fal fa-cog" aria-hidden="true"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <?php if(Auth()->user()->active_company_id == null || Auth()->user()->active_company_id != $company->id): ?>
                                                <li>
                                                    <a class="dropdown-item btn activeCompany"
                                                       data-route="<?php echo e(route('user.activeCompany', $company->id)); ?>"
                                                       data-property="<?php echo e($company); ?>">
                                                        <i class="fas fa-check"></i> <?php echo app('translator')->get('Active'); ?>
                                                    </a>
                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <a class="dropdown-item btn inactiveCompany"
                                                       data-route="<?php echo e(route('user.inactiveCompany', $company->id)); ?>"
                                                       data-property="<?php echo e($company); ?>">
                                                        <i class="fas fa-check"></i> <?php echo app('translator')->get('Inactive'); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <li>
                                                <a class="dropdown-item btn" href="<?php echo e(route('user.companyEdit', $company->id)); ?>">
                                                    <i class="fas fa-edit"></i> <?php echo app('translator')->get('Edit'); ?>
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item btn deleteCompany"
                                                   data-route="<?php echo e(route('user.deleteCompany', $company->id)); ?>"
                                                   data-property="<?php echo e($company); ?>">
                                                    <i class="fas fa-trash-alt"></i> <?php echo app('translator')->get('Delete'); ?>
                                                </a>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        <div class="modal fade" id="activeCompanyModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <div class="modal-content">
                    <div class="modal-header modal-primary modal-header-custom">
                        <h4 class="modal-title"><?php echo app('translator')->get('Active Confirmation'); ?></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="active-company-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="activeCompanyRoute">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>
                            <button type="submit"
                                    class="btn btn-sm btn-custom text-white"><?php echo app('translator')->get('Yes'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="inactiveCompanyModal" tabindex="-1" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-md">
                <div class="modal-content">
                    <div class="modal-header modal-primary modal-header-custom">
                        <h4 class="modal-title"><?php echo app('translator')->get('Inactive Confirmation'); ?></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="inactive-company-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="inactiveCompanyRoute">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>
                            <button type="submit"
                                    class="btn btn-sm btn-custom text-white"><?php echo app('translator')->get('Yes'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteCompanyModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-company-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="deleteCompanyRoute">
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
        $(document).on('click', '.activeCompany', function () {
            var activeCompanyModal = new bootstrap.Modal(document.getElementById('activeCompanyModal'))
            activeCompanyModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');

            $('.activeCompanyRoute').attr('action', dataRoute)

            $('.active-company-name').text(`Are you sure to active ${dataProperty.name}?`)

        });

        $(document).on('click', '.inactiveCompany', function () {
            var inactiveCompanyModal = new bootstrap.Modal(document.getElementById('inactiveCompanyModal'))
            inactiveCompanyModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');

            $('.inactiveCompanyRoute').attr('action', dataRoute)

            $('.inactive-company-name').text(`Are you sure to inavtive ${dataProperty.name}?`)

        });

        $(document).on('click', '.deleteCompany', function () {
            var deleteCompanyModal = new bootstrap.Modal(document.getElementById('deleteCompanyModal'))
            deleteCompanyModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');

            $('.deleteCompanyRoute').attr('action', dataRoute)

            $('.delete-company-name').text(`Are you sure to delete ${dataProperty.name}?`)

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/company/index.blade.php ENDPATH**/ ?>