<?php $__env->startSection('title', trans('Purchase Item List')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Purchased Item List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Purchased List'); ?></li>
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
                            <label for=""><?php echo app('translator')->get('Suppliers'); ?></label>
                            <select class="form-control js-example-basic-single" name="supplier_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($supplier->id); ?>" <?php echo e(@request()->supplier_id == $supplier->id ? 'selected' : ''); ?>><?php echo e($supplier->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date"><?php echo app('translator')->get('Purchased From Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="to_date"><?php echo app('translator')->get('Purchased To Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>"
                                autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for=""><?php echo app('translator')->get('Payment Status'); ?></label>
                            <select class="form-control js-example-basic-single" name="payment_status"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <option value="paid" <?php echo e(@request()->payment_status == 'paid' ? 'selected' : ''); ?>><?php echo app('translator')->get('Paid'); ?></option>
                                <option value="due" <?php echo e(@request()->payment_status == 'due' ? 'selected' : ''); ?>><?php echo app('translator')->get('Due'); ?></option>
                            </select>
                        </div>

                        <div class="input-box col-lg-12">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <a href="<?php echo e(route('user.purchaseRawItem')); ?>" class="btn btn-custom text-white"> <i
                        class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Purchase'); ?></a>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Supplier'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Total Price'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Purchase Date'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Payment Status'); ?></th>
                            <th scope="col" class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $purchasedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $purchaseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($purchasedItems) + $key); ?></td>
                            <td data-label="<?php echo app('translator')->get('Supplier'); ?>"> <?php echo e(optional($purchaseItem->supplier)->name); ?> </td>
                            <td data-label="<?php echo app('translator')->get('Total Price'); ?>"> <?php echo e(getAmount($purchaseItem->total_price)); ?> <?php echo e($basic->currency_symbol); ?> </td>
                            <td data-label="<?php echo app('translator')->get('Purchased Date'); ?>"> <?php echo e(customDate($purchaseItem->purchase_date)); ?> </td>
                            <td data-label="<?php echo app('translator')->get('Payment Status'); ?>">
                                <?php if($purchaseItem->payment_status == 1): ?>
                                    <span class="badge bg-success"><?php echo app('translator')->get('Paid'); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-warning"><?php echo app('translator')->get('Due'); ?></span>
                                <?php endif; ?>
                            </td>


                            <td data-label="Action" class="action d-flex justify-content-center">
                                <a class="action-btn" href="<?php echo e(route('user.rawItemPurchaseDetails', $purchaseItem->id)); ?>">
                                    <i class="fa fa-eye font-14" aria-hidden="true"></i>
                                </a>
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/rawItems/purchaseRawItemList.blade.php ENDPATH**/ ?>