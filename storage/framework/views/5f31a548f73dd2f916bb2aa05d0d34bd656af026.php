<?php $__env->startSection('title', trans('Stock Missing List')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Stock Missing List'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Stock Missing List'); ?></li>
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
                            <label for=""><?php echo app('translator')->get('items'); ?></label>
                            <select class="form-control js-example-basic-single" name="item_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <?php $__currentLoopData = $stockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e(optional($stockItem->item)->id); ?>" <?php echo e(@request()->item_id == optional($stockItem->item)->id ? 'selected' : ''); ?>><?php echo e(optional($stockItem->item)->name); ?></option>
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

            <?php if(adminAccessRoute(config('permissionList.Manage_Stock_Missing.Stock_Missing.permission.add'))): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" class="btn btn-custom text-white addMissingStock"> <i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add Missing Stock'); ?></a>
                </div>
            <?php endif; ?>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Item'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Quantity'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Missing Date'); ?></th>
                        <?php if(adminAccessRoute(config('permissionList.Manage_Stock_Missing.Stock_Missing.permission.delete'))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>

                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $stockMissingLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $missingList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($stockMissingLists) + $key); ?></td>

                            <td data-label="<?php echo app('translator')->get('Image'); ?>">
                                <div class="d-flex gap-2">
                                    <div class="logo-brand">
                                        <img
                                            src="<?php echo e(getFile(optional($missingList->item)->driver, optional($missingList->item)->image)); ?>"
                                            alt="">
                                    </div>
                                    <div class="product-summary">
                                        <p class="font-weight-bold mt-3"><?php echo e(optional($missingList->item)->name); ?></p>
                                    </div>
                                </div>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Quantity'); ?>"><?php echo e($missingList->quantity); ?></td>
                            <td data-label="<?php echo app('translator')->get('Date'); ?>"><?php echo e(customDate($missingList->missing_date)); ?></td>

                            <?php if(adminAccessRoute(config('permissionList.Manage_Stock_Missing.Stock_Missing.permission.delete'))): ?>
                                <td data-label="Action" class="action d-flex justify-content-center">
                                    <button class="action-btn deleteItem"
                                            data-route="<?php echo e(route('user.stockMissingDelete', $missingList->id)); ?>">
                                        <i class="fa fa-trash font-14" aria-hidden="true"></i>
                                    </button>
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
                <?php echo e($stockMissingLists->appends($_GET)->links($theme.'partials.pagination')); ?>

            </div>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        
        <div class="modal fade" id="addMissingStockModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md profile-setting">
                <form action="<?php echo e(route('user.stockMissingStore')); ?>" method="post" class="login-form"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Add Missing Stock Item'); ?></h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="payment-method-details property-title font-weight-bold"></div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12 m-0">
                                            <label for=""><?php echo app('translator')->get('items'); ?></label>
                                            <select
                                                class="form-select selectedRawItem <?php $__errorArgs = ['item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="item_id"
                                                aria-label="Default select example">
                                                <option  selected disabled><?php echo app('translator')->get('Select Raw Item'); ?></option>
                                                <?php $__currentLoopData = $stockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e(optional($stockItem->item)->id); ?>"><?php echo e(optional($stockItem->item)->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['item_id'];
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

                                        <div class="input-box col-12 m-0 mt-3">
                                            <label for=""><?php echo app('translator')->get('Quantity'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="quantity"
                                                    value="<?php echo e(old('quantity')); ?>"
                                                    placeholder="<?php echo app('translator')->get('missing quantity'); ?>">
                                                <div class="input-group-append" readonly="">
                                                    <div
                                                        class="form-control currency_symbol append_group raw_item_unit"></div>
                                                </div>
                                            </div>
                                            <?php $__errorArgs = ['quantity'];
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

                                        <div class="flatpickr">
                                            <label for="missing_date"><?php echo app('translator')->get('Missing Date'); ?></label>
                                            <div class="input-group">
                                                <input type="date"
                                                       placeholder="<?php echo app('translator')->get('Missing Date'); ?>"
                                                       class="form-control missing_date <?php $__errorArgs = ['missing_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       name="missing_date"
                                                       value="<?php echo e(old('missing_date',request()->missing_date)); ?>"
                                                       data-input>
                                                <div class="input-group-append"
                                                     readonly="">
                                                    <div
                                                        class="form-control payment-date-times">
                                                        <a class="input-button cursor-pointer"
                                                           title="clear" data-clear>
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback d-block">
                                                    <?php $__errorArgs = ['missing_date'];
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
                        <span class="delete-item-name"><?php echo app('translator')->get('Are you sure delete missing stock?'); ?></span>
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
    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>
    <?php echo $__env->make($theme.'user.partials.getItemUnit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if($errors->has('missing_date') || $errors->has('item_id') || $errors->has('quantity')): ?>
        <script>
            var myModal = new bootstrap.Modal(document.getElementById("addWastageModal"), {});
            document.onreadystatechange = function () {
                myModal.show();
            };

        </script>
    <?php endif; ?>


    <script>
        'use strict'

        $(".flatpickr").flatpickr({
            wrap: true,
            maxDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

        $(document).ready(function () {

            $(document).on('click', '.addMissingStock', function () {
                var addMissingStockModal = new bootstrap.Modal(document.getElementById('addMissingStockModal'))
                addMissingStockModal.show();
            });

            $(document).on('click', '.deleteItem', function () {
                var deleteItemModal = new bootstrap.Modal(document.getElementById('deleteItemModal'))
                deleteItemModal.show();

                let dataRoute = $(this).data('route');
                console.log(dataRoute);
                let dataProperty = $(this).data('property');

                $('.deleteItemRoute').attr('action', dataRoute)

            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/stockMissing/index.blade.php ENDPATH**/ ?>