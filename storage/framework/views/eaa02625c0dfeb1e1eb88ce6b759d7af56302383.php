<?php $__env->startSection('title',trans('Stock Transfer')); ?>
<?php $__env->startPush('style'); ?>
    <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Stock Transfer'); ?></h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page"><?php echo app('translator')->get('Stock Transfer'); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="<?php echo e(route('user.stockList')); ?>"
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
                        <div class="col-lg-12">
                            <div id="tab1" class="content active">
                                <form action="<?php echo e(route('user.storeStockTransfer')); ?>" method="post"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="supplier_id"><?php echo app('translator')->get('Select Sales Center'); ?></label>
                                            <select
                                                class="form-select js-example-basic-single <?php $__errorArgs = ['sales_center_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> selectSalesCenter"
                                                name="sales_center_id"
                                                aria-label="Default select example">
                                                <option value="" selected disabled><?php echo app('translator')->get('Select Sales Center'); ?></option>
                                                <?php $__currentLoopData = $salesCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $salesCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($salesCenter->id); ?>" <?php echo e(old('sales_center_id') == $salesCenter->id ? 'selected' : ''); ?>><?php echo e($salesCenter->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php if($errors->has('sales_center_id')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('sales_center_id')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="name"><?php echo app('translator')->get('Transfer Date'); ?> </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="<?php echo app('translator')->get('Transfer Date'); ?>"
                                                           class="form-control transfer_date transferDate"
                                                           name="transfer_date"
                                                           value="<?php echo e(old('transfer_date', request()->transfer_date)); ?>"
                                                           data-input>
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control">
                                                            <a class="input-button cursor-pointer" title="clear"
                                                               data-clear>
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="invalid-feedback d-block">
                                                        <?php $__errorArgs = ['transfer_date'];
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

                                    <div class="row mt-4 parentItemRow">
                                        <div class="col-md-12 d-flex justify-content-between">
                                            <div>
                                                <h6 class="text-dark font-weight-bold"> <?php echo app('translator')->get('Add Stock Item'); ?> </h6>
                                            </div>

                                            <div class="addStockItemFieldButton">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)"
                                                       class="btn add-more-btn-custom float-end" id="stockItemGenerate"><i
                                                            class="fa fa-plus-circle"></i> <?php echo e(trans('Add More')); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="purchaseItemField">
                                        <div class="row mt-4">
                                            <div class="input-box col-md-3">
                                                <label for="item_id"><?php echo app('translator')->get('Select Item'); ?></label>
                                                <select
                                                    class="form-select js-example-basic-single selectedItem <?php $__errorArgs = ['item_id.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="item_id[]"
                                                    aria-label="Default select example">
                                                    <option value="" selected disabled><?php echo app('translator')->get('Select Item'); ?></option>
                                                    <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($stock->item->id); ?>" <?php echo e(old('item_id.0') == $stock->item->id ? 'selected' : ''); ?>><?php echo e($stock->item->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <?php if($errors->has('item_id')): ?>
                                                    <div
                                                        class="error text-danger"><?php echo app('translator')->get($errors->first('item_id.0')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>


                                            <div class="input-box col-md-3">
                                                <label for="item_quantity"> <?php echo app('translator')->get('Quantity'); ?></label>
                                                <div class="input-group">
                                                    <input type="number" name="item_quantity[]"
                                                           class="form-control <?php $__errorArgs = ['item_quantity.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalQuantity"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="<?php echo e(old('item_quantity.0')); ?>" min="1">
                                                    <div class="input-group-append" readonly="">
                                                        <div
                                                            class="form-control currency_symbol append_group item_unit"></div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    <?php $__errorArgs = ['item_quantity.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="input-box col-md-3 cost_per_unit_parent">
                                                <label for="cost_per_unit"> <?php echo app('translator')->get('Cost Per Unit'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" name="cost_per_unit[]"
                                                           class="form-control <?php $__errorArgs = ['cost_per_unit.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> costPerUnit"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="<?php echo e(old('cost_per_unit.0')); ?>">
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control currency_symbol append_group">
                                                            <?php echo e($basic->currency_symbol); ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    <?php $__errorArgs = ['cost_per_unit.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="input-box col-md-3">
                                                <label for="total_unit_cost"> <?php echo app('translator')->get('Total Cost'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" name="total_unit_cost[]"
                                                           class="form-control <?php $__errorArgs = ['total_unit_cost.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalItemCost"
                                                           value="<?php echo e(old('total_unit_cost.0')); ?>">
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control currency_symbol append_group">
                                                            <?php echo e($basic->currency_symbol); ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    <?php $__errorArgs = ['total_unit_cost.0'];
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

                                    <div class="addedItemField">

                                        <?php
                                            $oldItemCounts = old('item_id') ? count(old('item_id')) : 0;
                                        ?>

                                        <?php if($oldItemCounts > 1): ?>
                                            <?php for($i = 1; $i < $oldItemCounts; $i++): ?>
                                                <div class="row mt-4 addMoreItemBox" id="removeItemField<?php echo e($i); ?>">
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <button
                                                            class="btn btn-danger delete_item_desc custom_delete_desc_padding mt-4"
                                                            type="button" onclick="deleteItemField(<?php echo e($i); ?>)">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>

                                                    <div class="input-box col-md-3">
                                                        <label for="item_id"><?php echo app('translator')->get('Select Item'); ?> <span
                                                                class="text-danger">*</span></label>
                                                        <select
                                                            class="form-select js-example-basic-single<?php echo e($i); ?> selectedItem <?php $__errorArgs = ["item_id.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="item_id[]"
                                                            aria-label="Default select example">
                                                            <option value="" selected
                                                                    disabled><?php echo app('translator')->get('Select Item'); ?></option>
                                                            <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($stock->item->id); ?>" <?php echo e(old("item_id.$i") == $stock->item->id ? 'selected' : ''); ?>><?php echo e($stock->item->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>

                                                        <?php if($errors->has("item_id.$i")): ?>
                                                            <div
                                                                class="error text-danger"><?php echo app('translator')->get($errors->first("item_id.$i")); ?></div>
                                                        <?php endif; ?>
                                                    </div>


                                                    <div class="input-box col-md-3">
                                                        <label for="item_quantity"> <?php echo app('translator')->get('Quantity'); ?></label>
                                                        <div class="input-group">
                                                            <input type="text" name="item_quantity[]"
                                                                   class="form-control <?php $__errorArgs = ["item_quantity.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalQuantity"
                                                                   value="<?php echo e(old("item_quantity.$i")); ?>" min="1">
                                                            <div class="input-group-append" readonly="">
                                                                <div
                                                                    class="form-control currency_symbol append_group item_unit_<?php echo e($i); ?>"></div>
                                                            </div>
                                                        </div>

                                                        <div class="invalid-feedback">
                                                            <?php $__errorArgs = ["item_quantity.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>

                                                    <div class="input-box col-md-3 cost_per_unit_parent">
                                                        <label for="cost_per_unit"> <?php echo app('translator')->get('Cost Per Unit'); ?></label>
                                                        <div class="input-group">
                                                            <input type="text" name="cost_per_unit[]"
                                                                   class="form-control <?php $__errorArgs = ["cost_per_unit.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> costPerUnit"
                                                                   value="<?php echo e(old("cost_per_unit.$i")); ?>">
                                                            <div class="input-group-append" readonly="">
                                                                <div class="form-control currency_symbol append_group">
                                                                    <?php echo e($basic->currency_symbol); ?>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="invalid-feedback">
                                                            <?php $__errorArgs = ["cost_per_unit.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>

                                                    <div class="input-box col-md-3">
                                                        <label for="total_unit_cost"> <?php echo app('translator')->get('Total Cost'); ?></label>
                                                        <div class="input-group">
                                                            <input type="text" name="total_unit_cost[]"
                                                                   class="form-control <?php $__errorArgs = ["total_unit_cost.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalItemCost"
                                                                   value="<?php echo e(old("total_unit_cost.$i")); ?>">
                                                            <div class="input-group-append" readonly="">
                                                                <div class="form-control currency_symbol">
                                                                    <?php echo e($basic->currency_symbol); ?>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="invalid-feedback">
                                                            <?php $__errorArgs = ["total_unit_cost.$i"];
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
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="border-line-area mt-5">
                                        <h6 class="border-line-title"><?php echo app('translator')->get('Summary'); ?></h6>
                                    </div>

                                    <div class="d-flex justify-content-end mt-2">
                                        <!-- Subtotal Field -->
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <span class="fw-bold mt-2 me-3"><?php echo app('translator')->get('Total Transfer'); ?></span>
                                            <div class="input-group w-50">
                                                <input type="number" name="sub_total"
                                                       value="<?php echo e(old('sub_total') ?? '0'); ?>"
                                                       class="form-control bg-white text-dark itemSubTotal"
                                                       data-subtotal="<?php echo e(old('sub_total')); ?>"
                                                       readonly>
                                                <div class="input-group-append">
                                                    <div class="form-control">
                                                        <?php echo e($basic->currency_symbol); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4 mt-4">
                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100" type="submit"><?php echo app('translator')->get('Transfer'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <input type="hidden" name="update_sub_total" class="updateSubTotal" value="<?php echo e(old('update_sub_total') ?? '0'); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <?php echo $__env->make($theme.'user.partials.getItemUnit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>
    <script>
        'use strict'
        $(".flatpickr").flatpickr({
            wrap: true,
            maxDate: "today",
            // maxDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

        $("#stockItemGenerate").on('click', function () {
            const id = Date.now();
            var form = `<div class="row addMoreItemBox" id="removeItemField${id}">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button
                                        class="btn btn-danger delete_item_desc custom_delete_desc_padding mt-4"
                                        type="button" onclick="deleteItemField(${id})">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>

                                <div class="input-box col-md-3">
                                    <label for="item_id"><?php echo app('translator')->get('Select Item'); ?> </label>
                                    <select
                                        class="form-select js-example-basic-single${id} selectedItem_${id}" onchange="selectedItemHandel(${id})"
                                        name="item_id[]"
                                        aria-label="Default select example">
                                        <option value="" selected disabled><?php echo app('translator')->get('Select Item'); ?></option>
                                           <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($stock->item->id); ?>"><?php echo e($stock->item->name); ?></option>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="input-box col-md-3">
            <label for="item_quantity"> <?php echo app('translator')->get('Quantity'); ?></label>
                                    <div class="input-group">
                                        <input type="text" name="item_quantity[]"
                                               class="form-control totalQuantity" min="1">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group item_unit_${id}"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-box col-md-3 cost_per_unit_parent">
                                    <label for="cost_per_unit"> <?php echo app('translator')->get('Cost Per Unit'); ?></label>
                                    <div class="input-group">
                                        <input type="text" name="cost_per_unit[]"
                                               class="form-control costPerUnit">
                                        <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol append_group">
                                                <?php echo e($basic->currency_symbol); ?>

            </div>
        </div>
    </div>
</div>

<div class="input-box col-md-3">
    <label for="total_unit_cost"> <?php echo app('translator')->get('Total Cost'); ?></label>
                                     <div class="input-group">
                                         <input type="text" name="total_unit_cost[]" class="form-control totalItemCost">
                                         <div class="input-group-append" readonly="">
                                            <div class="form-control currency_symbol">
                                                <?php echo e($basic->currency_symbol); ?>

            </div>
        </div>
    </div>
</div>
</div>`;

            $('.addedItemField').append(form)

            const selectClass = `.js-example-basic-single${id}`;
            $(".addedItemField").find(selectClass).each(function () {
                $(this).select2({
                    width: '100%',
                });
            });
        });

        function deleteItemField(id) {
            $(`#removeItemField${id}`).remove();
            calculateItemTotalPrice();
        }

        $(document).on('input', '.costPerUnit', function () {
            calculateItemTotalPrice();
        });

        function calculateItemTotalPrice() {
            let subTotal = 0;

            let discount = parseFloat($('.discountPercentage').val());
            let vat = parseFloat($('.vatPercentage').val());

            discount = isNaN(discount) ? 0 : discount;
            vat = isNaN(vat) ? 0 : vat;

            $('.costPerUnit').each(function (key, value) {
                let costPerUnit = parseFloat($(this).val()).toFixed(2);
                let quantity = parseFloat($(value).parents('.cost_per_unit_parent').siblings().find('.totalQuantity').val()).toFixed(2);
                let cost = isNaN(quantity) || isNaN(costPerUnit) ? 0 : quantity * costPerUnit;
                subTotal = parseFloat(subTotal) + parseFloat(cost);
                $(value).parents('.cost_per_unit_parent').siblings().find('.totalItemCost').val(cost);
            });

            let updateSubTotal = parseFloat(subTotal).toFixed(2);

            let discountAmount = updateSubTotal * discount / 100;
            let vatAmount = updateSubTotal * vat / 100;
            let subTotalWithVat = subTotal + vatAmount;
            let totalAmount = subTotalWithVat - discountAmount;

            $('.itemSubTotal').val(subTotal);
            $('.totalPrice').val(parseFloat(totalAmount).toFixed(2));
            $('.updateSubTotal').val(updateSubTotal);
            totalSubCount(subTotal);
        }

        function totalSubCount(subtotal) {
            let total = parseFloat($('.updateSubTotal').val()).toFixed(2);
            $('.itemSubTotal').val(total);
        }


    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/stock/transfer.blade.php ENDPATH**/ ?>