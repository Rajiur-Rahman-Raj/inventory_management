<?php $__env->startSection('title', trans('Sales List')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Sales List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Sales List'); ?></li>
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
                            <label for=""><?php echo app('translator')->get('Item Name'); ?></label>
                            <input
                                type="text"
                                name="name"
                                value="<?php echo e(old('name', @request()->name)); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('item Name'); ?>"/>
                        </div>

                        <div class="input-box col-lg-3">
                            <label for="from_date"><?php echo app('translator')->get('Last Stock From Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>"
                                autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-3">
                            <label for="to_date"><?php echo app('translator')->get('Last Stock To Date'); ?></label>
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

            <div class="d-flex justify-content-end mb-4">
                <a href="<?php echo e(route('user.addStock')); ?>" class="btn btn-custom text-white "> <i
                        class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add Stock'); ?></a>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Sales Center'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Total Amount'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Last Payment Date'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Payment Status'); ?></th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $salesLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $salesList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($salesLists) + $key); ?></td>
                            <td data-label="<?php echo app('translator')->get('Sales Center'); ?>"> <?php echo e(optional($salesList->salesCenter)->name); ?> </td>
                            <td data-label="<?php echo app('translator')->get('Total Amount'); ?>"
                                class="font-weight-bold">  <?php echo e($salesList->total_amount); ?> </td>
                            <td data-label="<?php echo app('translator')->get('Last Payment Date'); ?>"> <?php echo e(customDate($salesList->payment_date)); ?> </td>
                            <td data-label="<?php echo app('translator')->get('Payment Status'); ?>">
                                <?php if($salesList->payment_status == 1): ?>
                                    <span class="badge bg-success"><?php echo app('translator')->get('Completed'); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-warning"><?php echo app('translator')->get('Due'); ?></span>
                                <?php endif; ?>
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
        
        <div class="modal fade" id="addItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <form action="<?php echo e(route('user.itemStore')); ?>" method="post" class="login-form">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Add New Item'); ?></h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for=""><?php echo app('translator')->get('Item Name'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="name"
                                                    value="<?php echo e(old('name')); ?>"
                                                    placeholder="<?php echo app('translator')->get('Enter Item Name'); ?>" required>
                                            </div>
                                            <?php $__errorArgs = ['name'];
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
                                            <label for=""><?php echo app('translator')->get('Unit'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="form-control <?php $__errorArgs = ['unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="unit"
                                                    value="<?php echo e(old('unit', 'Coil')); ?>"
                                                    placeholder="<?php echo app('translator')->get('Item Unit'); ?>" required>
                                            </div>
                                            <?php $__errorArgs = ['unit'];
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

        
        <div class="modal fade" id="editItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <form action="" method="post" class="edit-item-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Edit Item'); ?></h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for=""><?php echo app('translator')->get('Item Name'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> item-name"
                                                    name="name"
                                                    value="<?php echo e(old('name')); ?>"
                                                    placeholder="<?php echo app('translator')->get('Enter Item Name'); ?>" required>
                                            </div>
                                            <?php $__errorArgs = ['name'];
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
                                            <label for=""><?php echo app('translator')->get('Unit'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control <?php $__errorArgs = ['unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> item-unit"
                                                    name="unit"
                                                    value="<?php echo e(old('unit')); ?>"
                                                    placeholder="<?php echo app('translator')->get('Item Unit'); ?>" required>
                                            </div>
                                            <?php $__errorArgs = ['unit'];
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


            $(document).on('click', '.deleteItem', function () {
                var deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'))
                deleteItemModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.deleteItemRoute').attr('action', dataRoute)

                $('.delete-item-name').text(`Are you sure to delete ${dataProperty.name}?`)

            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/manageSales/salesList.blade.php ENDPATH**/ ?>