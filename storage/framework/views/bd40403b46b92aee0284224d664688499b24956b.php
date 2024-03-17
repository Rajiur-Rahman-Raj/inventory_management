<?php $__env->startSection('title', trans('Raw Item Stocks')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Raw Item Stocks'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Raw Item Stocks'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-6">
                            <label for=""><?php echo app('translator')->get('Items'); ?></label>
                            <select class="form-control js-example-basic-single" name="item_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <?php $__currentLoopData = $rawItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($item->id); ?>" <?php echo e(@request()->item_id == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-6">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(adminAccessRoute(config('permissionList.Manage_Raw_Items.Purchase.permission.add'))): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="<?php echo e(route('user.purchaseRawItem')); ?>" class="btn btn-custom text-white"> <i
                            class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Purchase'); ?></a>
                </div>
            <?php endif; ?>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Item'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Quantity'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $purchasedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $purchaseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($purchasedItems) + $key); ?></td>
                            <td data-label="<?php echo app('translator')->get('Image'); ?>">
                                <div class="d-flex gap-2">
                                    <div class="logo-brand">
                                        <img
                                            src="<?php echo e(getFile(optional($purchaseItem->rawItem)->driver, optional($purchaseItem->rawItem)->image)); ?>"
                                            alt="">
                                    </div>
                                    <div class="product-summary">
                                        <p class="font-weight-bold mt-3"><?php echo e(optional($purchaseItem->rawItem)->name); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Quantity'); ?>" class="font-weight-bold">
                                <span class="badge <?php echo e($purchaseItem->quantity > 0 ? 'bg-info' : 'bg-danger'); ?>"><?php echo e($purchaseItem->quantity); ?> </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="text-center">
                            <td colspan="100%" class="text-danger text-center"><?php echo e(trans('No Data Found!')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($purchasedItems->appends($_GET)->links($theme.'partials.pagination')); ?>

            </div>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        <!--Delete Item Modal -->
        <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="editModalLabel"
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
                        <span class="delete-item-name"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <form action="" method="post" class="deleteItemRoute">
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


            $(document).on('click', '.addNewItem', function () {
                var addItemModal = new bootstrap.Modal(document.getElementById('addItemModal'))
                addItemModal.show();


            });

            $(document).on('click', '.editItem', function () {
                var editItemModal = new bootstrap.Modal(document.getElementById('editItemModal'))
                editItemModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.edit-item-form').attr('action', dataRoute);

                $('.item-name').val(dataProperty.name);
                $('.item-unit').val(dataProperty.unit);
            });


            $(document).on('click', '.deletePurchaseRawItem', function () {
                var deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'))
                deleteItemModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');
                console.log(dataProperty);
                $('.deleteItemRoute').attr('action', dataRoute)
                $('.delete-item-name').text(`Are you sure to delete ${dataProperty.raw_item.name}?`)
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/rawItems/purchaseRawItemStocks.blade.php ENDPATH**/ ?>