<?php $__env->startSection('title',trans('Add New Stock')); ?>
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
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Add New Stock'); ?></h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page"><?php echo app('translator')->get('Add New Stock'); ?></li>
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
                                <form action="<?php echo e(route('user.stockStore')); ?>" method="post"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-12">
                                            <label for="name"><?php echo app('translator')->get('Stock In Date'); ?> </label>
                                            <div class="flatpickr">
                                                <div class="input-group input-box">
                                                    <input type="date" placeholder="<?php echo app('translator')->get('Stock Date'); ?>"
                                                           class="form-control stock_date"
                                                           name="stock_date"
                                                           value="<?php echo e(old('stock_date',request()->stock_date)); ?>"
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
                                                        <?php $__errorArgs = ['stock_date'];
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
                                    <div class="row mt-4">
                                        <div class="col-md-12 d-flex justify-content-between">
                                            <div>
                                                <h6 class="text-dark font-weight-bold"> <?php echo app('translator')->get('Add Stock Item'); ?> </h6>
                                            </div>
                                            <div class="addStockItemFieldButton">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)"
                                                       class="btn add-more-btn-custom float-end"
                                                       id="stockItemGenerate"><i
                                                            class="fa fa-plus-circle"></i> <?php echo e(trans('Add More')); ?>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stockItemField">
                                        
                                        <div class="row parentItemRow">
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
                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($item->id); ?>" <?php echo e(old('item_id.0') == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php if($errors->has('item_id')): ?>
                                                    <div
                                                        class="error text-danger"><?php echo app('translator')->get($errors->first('item_id.0')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-box col-md-2">
                                                <label for="item_quantity"> <?php echo app('translator')->get('Quantity'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" name="item_quantity[]"
                                                           class="form-control <?php $__errorArgs = ['item_quantity.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalQuantity"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="<?php echo e(old('item_quantity.0')); ?>">
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
                                            <div class="input-box col-md-2 cost_per_unit_parent">
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
                                                           value="<?php echo e(old('total_unit_cost.0')); ?>" readonly="">
                                                    <div class="input-group-append">
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

                                            <div class="input-box col-md-2">
                                                <label for="selling_price"> <?php echo app('translator')->get('Selling Price'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" name="selling_price[]"
                                                           class="form-control <?php $__errorArgs = ['selling_price.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="<?php echo e(old('selling_price.0')); ?>">
                                                    <div class="input-group-append" readonly="">
                                                        <div class="form-control currency_symbol append_group">
                                                            <?php echo e($basic->currency_symbol); ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    <?php $__errorArgs = ['selling_price.0'];
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

                                        
                                        <div class="row parentRawItemRow">
                                            <div class="input-box col-md-6 mt-3">
                                                <label for="raw_item_id"><?php echo app('translator')->get('Select Raw Item'); ?></label>
                                                <select
                                                    class="form-select js-example-basic-single selectedRawItem raw_item_id <?php $__errorArgs = ['raw_item_id.0.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="raw_item_id[0][]"
                                                    aria-label="Default select example">
                                                    <option value="" selected
                                                            disabled><?php echo app('translator')->get('Select Raw Item'); ?></option>
                                                    <?php $__currentLoopData = $rawItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rawItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($rawItem->id); ?>" <?php echo e(old('raw_item_id.0') == $rawItem->id ? 'selected' : ''); ?>><?php echo e($rawItem->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <?php if($errors->has('raw_item_id')): ?>
                                                    <div
                                                        class="error text-danger"><?php echo app('translator')->get($errors->first('raw_item_id.0')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-box col-md-5 mt-3">
                                                <label for="raw_item_quantity"> <?php echo app('translator')->get('Expense Quantity'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" name="raw_item_quantity[0][]"
                                                           class="form-control raw_item_quantity <?php $__errorArgs = ['raw_item_quantity.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalRawItemQuantity"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                           value="<?php echo e(old('raw_item_quantity.0.0')); ?>">
                                                    <div class="input-group-append" readonly="">
                                                        <div
                                                            class="form-control currency_symbol append_group raw_item_unit"></div>
                                                    </div>
                                                </div>

                                                <div class="invalid-feedback">
                                                    <?php $__errorArgs = ['raw_item_quantity.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="input-box col-md-1 mt-5">
                                                <span class="input-group-btn">
                                                    <button
                                                        class="btn btn-outline-success mt-2 rawItemFieldBtn rawItemFieldGenerate"
                                                        type="button"
                                                        id="rawItemFieldGenerate">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <?php
                                            $oldRawItemCounts = old('raw_item_id') ? count(old('raw_item_id')) : 0;
                                        ?>

                                        <?php if($oldRawItemCounts > 1): ?>
                                            <?php for($i = 1; $i < $oldRawItemCounts; $i++): ?>
                                                
                                                <div class="row parentRawItemRow">
                                                    <div class="input-box col-md-6 mt-3">
                                                        <label for="raw_item_id"><?php echo app('translator')->get('Select Raw Item'); ?></label>
                                                        <select
                                                            class="form-select js-example-basic-single raw_item_id <?php $__errorArgs = ["raw_item_id.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="raw_item_id[0][]"
                                                            onchange="selectedRawItemHandel(<?php echo e($i); ?>)"
                                                            aria-label="Default select example">
                                                            <option value="" selected
                                                                    disabled><?php echo app('translator')->get('Select Raw Item'); ?></option>
                                                            <?php $__currentLoopData = $rawItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rawItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option
                                                                    value="<?php echo e($rawItem->id); ?>" <?php echo e(old("raw_item_id.$i") == $rawItem->id ? 'selected' : ''); ?>><?php echo e($rawItem->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <?php if($errors->has("raw_item_id.$i")): ?>
                                                            <div
                                                                class="error text-danger"><?php echo app('translator')->get($errors->first("raw_item_id.$i")); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="input-box col-md-5 mt-3">
                                                        <label
                                                            for="raw_item_quantity"> <?php echo app('translator')->get('Expense Quantity'); ?></label>
                                                        <div class="input-group">
                                                            <input type="text" name="raw_item_quantity[0][]"
                                                                   value="<?php echo e(old("raw_item_quantity.$i")); ?>"
                                                                   class="form-control raw_item_quantity <?php $__errorArgs = ["item_quantity.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalRawItemQuantity">
                                                            <div class="input-group-append" readonly="">
                                                                <div
                                                                    class="form-control currency_symbol append_group"></div>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            <?php $__errorArgs = ["raw_item_quantity.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>
                                                    <div class="input-box col-md-1 mt-5">
                                                            <span class="input-group-btn">
                                                                <button
                                                                    class="btn btn-outline-danger delete_raw_item_field mt-2"
                                                                    type="button">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </span>
                                                    </div>
                                                </div>
                                                <?php $__env->startPush('script'); ?>
                                                    <script>
                                                        const rawItemSelect2Class<?php echo e($i); ?> = `.js-example-basic-single<?php echo e($i); ?>`;
                                                        $(document).ready(function () {
                                                            $(rawItemSelect2Class<?php echo e($i); ?>).select2({
                                                                width: '100%',
                                                            });
                                                        });
                                                    </script>
                                                <?php $__env->stopPush(); ?>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                        

                                        
                                        <?php
                                            $oldItemCounts = old('item_id') ? count(old('item_id')) : 0;
                                        ?>

                                        <?php if($oldItemCounts > 1): ?>
                                            <?php for($i = 1; $i < $oldItemCounts; $i++): ?>
                                                <div id="removeItemField<?php echo e($i); ?>">
                                                    
                                                    <div class="row mt-4 addMoreItemBox parentItemRow">
                                                        <div class="col-md-12 d-flex justify-content-end">
                                                            <button
                                                                class="btn btn-danger delete_item_desc custom_delete_desc_padding mt-4"
                                                                type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>

                                                        <div class="input-box col-md-3">
                                                            <label for="item_id"><?php echo app('translator')->get('Select Item'); ?> </label>
                                                            <select
                                                                class="form-select js-example-basic-single<?php echo e($i); ?> selectedItem_<?php echo e($i); ?> <?php $__errorArgs = ["item_id.$i"];
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
                                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option
                                                                        value="<?php echo e($item->id); ?>" <?php echo e(old("item_id.$i") == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>

                                                            <?php if($errors->has("item_id.$i")): ?>
                                                                <div
                                                                    class="error text-danger"><?php echo app('translator')->get($errors->first("item_id.$i")); ?></div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="input-box col-md-2">
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
                                                                       value="<?php echo e(old("item_quantity.$i")); ?>">
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

                                                        <div class="input-box col-md-2 cost_per_unit_parent">
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
                                                                    <div
                                                                        class="form-control currency_symbol append_group">
                                                                        <?php echo e($basic->currency_symbol); ?>

                                                                    </div>
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

                                                        <div class="input-box col-md-3 mt-3">
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
                                                                       value="<?php echo e(old("total_unit_cost.$i")); ?>" readonly>
                                                                <div class="input-group-append">
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

                                                        <div class="input-box col-md-2">
                                                            <label for="selling_price"> <?php echo app('translator')->get('Selling Price'); ?></label>
                                                            <div class="input-group">
                                                                <input type="text" name="selling_price[]"
                                                                       class="form-control <?php $__errorArgs = ["selling_price.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                                       value="<?php echo e(old("selling_price.$i")); ?>">
                                                                <div class="input-group-append" readonly="">
                                                                    <div class="form-control currency_symbol append_group">
                                                                        <?php echo e($basic->currency_symbol); ?>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="invalid-feedback">
                                                                <?php $__errorArgs = ["selling_price.$i"];
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

                                                    <div class="row">
                                                        <div class="input-box col-md-6 mt-3">
                                                            <label for="raw_item_id"><?php echo app('translator')->get('Select Raw Item'); ?></label>
                                                            <select
                                                                class="form-select js-example-basic-single raw_item_id <?php $__errorArgs = ["raw_item_id.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> selectedRawItem is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                name="raw_item_id[0][]"
                                                                aria-label="Default select example">
                                                                <option value="" selected
                                                                        disabled><?php echo app('translator')->get('Select Raw Item'); ?></option>
                                                                <?php $__currentLoopData = $rawItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rawItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option
                                                                        value="<?php echo e($rawItem->id); ?>" <?php echo e(old("raw_item_id.$i") == $rawItem->id ? 'selected' : ''); ?>><?php echo e($rawItem->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>

                                                            <?php if($errors->has("raw_item_id.$i")): ?>
                                                                <div
                                                                    class="error text-danger"><?php echo app('translator')->get($errors->first("raw_item_id.$i")); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="input-box col-md-5 mt-3">
                                                            <label
                                                                for="raw_item_quantity"> <?php echo app('translator')->get('Expense Quantity'); ?></label>
                                                            <div class="input-group">
                                                                <input type="text" name="raw_item_quantity[0][]"
                                                                       class="form-control raw_item_quantity <?php $__errorArgs = ["raw_item_quantity.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> totalRawItemQuantity"
                                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                                       value="<?php echo e(old("raw_item_quantity.$i")); ?>">
                                                                <div class="input-group-append" readonly="">
                                                                    <div
                                                                        class="form-control currency_symbol append_group raw_item_unit_<?php echo e($i); ?>"></div>
                                                                </div>
                                                            </div>

                                                            <div class="invalid-feedback">
                                                                <?php $__errorArgs = ["raw_item_quantity.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                        </div>

                                                        <div class="input-box col-md-1 mt-5">
                                                            <span class="input-group-btn">
                                                                <button
                                                                    class="btn btn-outline-success mt-2 rawItemFieldBtn rawItemFieldGenerate"
                                                                    type="button"
                                                                    id="rawItemFieldGenerate">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="addRawItemField_<?php echo e($i); ?>">
                                                        
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="border-line-area mt-5">
                                        <h6 class="border-line-title"><?php echo app('translator')->get('Summary'); ?></h6>
                                    </div>

                                    <div class=" d-flex justify-content-end mt-2">
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <span class="fw-bold mt-2 me-3"><?php echo app('translator')->get('Sub Total'); ?></span>
                                            <div class="input-group w-50">
                                                <input type="number" name="sub_total"
                                                       value="<?php echo e(old('sub_total') ?? '0'); ?>"
                                                       class="form-control bg-white text-dark itemSubTotal"
                                                       data-subtotal="<?php echo e(old('sub_total')); ?>"
                                                       readonly>
                                                <div class="input-group-append" readonly="">
                                                    <div class="form-control">
                                                        <?php echo e($basic->currency_symbol); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4 mt-4">
                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit"><?php echo app('translator')->get('Add Stock'); ?></button>
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

        // Get the current date
        var currentDate = new Date();

        // Calculate the minimum date based on the current day
        var minDate;
        if (currentDate.getDay() === 0) {
            // If today is Sunday, set minDate to Friday
            minDate = new Date(currentDate.getTime() - 2 * 24 * 60 * 60 * 1000);
        } else {
            // For other days, set minDate to yesterday
            minDate = new Date(currentDate.getTime() - 24 * 60 * 60 * 1000);
        }

        $(".flatpickr").flatpickr({
            wrap: true,
            // minDate: minDate,
            // maxDate: new Date(currentDate.getTime() + 24 * 60 * 60 * 1000), // Set maxDate to tomorrow
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });


        $("#stockItemGenerate").on('click', function () {
            let parentLength = $('.parentItemRow').length;

            let itemMarkup = $('.parentItemRow:eq(0)').clone();
            itemMarkup.prepend(`<div class="col-md-12 d-flex justify-content-end">
                                    <button class="btn btn-danger itemRemoveBtn delete_item_desc custom_delete_desc_padding mt-4" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>`);

            itemMarkup.addClass('mt-4').find('input').val('');
            itemMarkup.find('.input-group-append > .item_unit').text('');

            $('.stockItemField').append(itemMarkup);

            let rawItemMarkup = $('.parentRawItemRow:eq(0)').clone();
            rawItemMarkup.find('input').val('');
            rawItemMarkup.find('.raw_item_id').attr('name', `raw_item_id[${parentLength}][]`);
            rawItemMarkup.find('.raw_item_quantity').attr('name', `raw_item_quantity[${parentLength}][]`);
            rawItemMarkup.find('.input-group-append > .raw_item_unit').text('');

            $('.stockItemField').append(rawItemMarkup);

            $('.js-example-basic-single').each(function () {
                $(this).select2({
                    width: '100%',
                });

                if ($(this).siblings('.select2').length > 1)
                    $(this).siblings('.select2').not(':first').remove();
            });
        });

        $(document).on('click', '.rawItemFieldGenerate', function () {

            var closestParentRawItemRow = $(this).closest('.parentRawItemRow');
            var parentItemRowIndex = closestParentRawItemRow.prevAll('.parentItemRow').not('.parentRawItemRow').length - 1;
            let parentLength = $('.parentItemRow').length;

            let rawItemMarkup = $('.parentRawItemRow:eq(0)').clone();
            rawItemMarkup.find('input').val('');
            rawItemMarkup.find('.raw_item_id').attr('name', `raw_item_id[${parentItemRowIndex}][]`);
            rawItemMarkup.find('.raw_item_quantity').attr('name', `raw_item_quantity[${parentItemRowIndex}][]`);
            rawItemMarkup.find('.input-group-append > .raw_item_unit').text('');
            rawItemMarkup.find('.rawItemFieldBtn').removeClass('btn-outline-success rawItemFieldGenerate').addClass('btn-outline-danger rawItemFieldRemove').find('i').removeClass('fa-plus').addClass('fa-minus');
            $(this).parents('.parentRawItemRow').after(rawItemMarkup);
            $('.js-example-basic-single').each(function () {
                $(this).select2({
                    width: '100%',
                });

                if ($(this).siblings('.select2').length > 1)
                    $(this).siblings('.select2').not(':first').remove();
            });
        });

        $(document).on('click', '.itemRemoveBtn', function () {
            $(this).parents('.parentItemRow').nextUntil('.parentItemRow').remove();
            $(this).parents('.parentItemRow').remove();
        });

        $(document).on('click', '.rawItemFieldRemove', function () {
            $(this).parents('.parentRawItemRow').remove();
        });


        $(document).on('input', '.costPerUnit', function () {
            calculateItemTotalPrice();
        });

        function calculateItemTotalPrice() {
            let subTotal = 0;

            $('.costPerUnit').each(function (key, value) {
                let costPerUnit = parseFloat($(this).val()).toFixed(2);
                let quantity = parseFloat($(value).parents('.cost_per_unit_parent').siblings().find('.totalQuantity').val()).toFixed(2);
                let cost = isNaN(quantity) || isNaN(costPerUnit) ? 0 : quantity * costPerUnit;
                subTotal = parseFloat(subTotal) + parseFloat(cost);
                $(value).parents('.cost_per_unit_parent').siblings().find('.totalItemCost').val(cost);
            });

            let updateSubTotal = parseFloat(subTotal).toFixed(2);

            $('.itemSubTotal').val(subTotal);
            $('.updateSubTotal').val(updateSubTotal);
            totalSubCount(subTotal);
        }

        function totalSubCount(subtotal) {
            let total = parseFloat($('.updateSubTotal').val()).toFixed(2);
            $('.itemSubTotal').val(total);
        }
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/stock/create.blade.php ENDPATH**/ ?>