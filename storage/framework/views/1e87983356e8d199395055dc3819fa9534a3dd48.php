<?php $__env->startSection('title', trans('Purchase Reports')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Purchase Reports'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Purchase Reports'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data" class="searchForm">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-3">
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="<?php echo app('translator')->get('From Date'); ?>"
                                           class="form-control from_date"
                                           name="from_date"
                                           value="<?php echo e(old('from_date',request()->from_date)); ?>"
                                           data-input>
                                    <div class="input-group-append" readonly="">
                                        <div class="form-control">
                                            <a class="input-button cursor-pointer"
                                               title="clear" data-clear>
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block">
                                        <?php $__errorArgs = ['from_date'];
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

                        <div class="input-box col-lg-3">
                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="<?php echo app('translator')->get('To Date'); ?>"
                                           class="form-control to_date"
                                           name="to_date"
                                           value="<?php echo e(old('to_date',request()->to_date)); ?>"
                                           data-input>
                                    <div class="input-group-append" readonly="">
                                        <div class="form-control">
                                            <a class="input-button cursor-pointer"
                                               title="clear" data-clear>
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block">
                                        <?php $__errorArgs = ['to_date'];
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

                        <div class="input-box col-lg-3">
                            <select class="form-control js-example-basic-single" name="supplier_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All Suppliers'); ?></option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($supplier->id); ?>" <?php echo e(@request()->supplier_id == $supplier->id ? 'selected' : ''); ?>><?php echo e($supplier->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(isset($purchaseReportRecords) && count($search) > 0): ?>
                <div class="card card-table">
                    <div
                        class="card-header custom-card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="m-0 text-primary"><?php echo app('translator')->get('All Purchases'); ?></h5>

                        <div class="total-price">
                            <ul class="m-0 list-unstyled">
                                <li class="text-uppercase color-primary font-weight-bold">
                                    <span><?php echo app('translator')->get('Total Price'); ?> =</span>
                                    <span><?php echo e($totalPrice); ?> <?php echo e(config('basic.currency_text')); ?> </span></li>
                            </ul>

                        </div>

                        <a href="javascript:void(0)" data-route="<?php echo e(route('user.export.purchaseReports')); ?>"
                           class="btn text-white btn-custom2 reportsDownload downloadExcel"> <i
                                class="fa fa-download"></i> <?php echo app('translator')->get('Download Excel File'); ?></a>

                    </div>
                    <ul class="list-style-none p-0 stock_list_style">
                        <div class="table-responsive">
                            <table class="table custom-table table-bordered mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">Supplier</th>
                                    <th scope="col">Raw Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Cost Per Unit</th>
                                    <th scope="col">Purchase Date</th>
                                    <th scope="col">Sub Total</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(count($purchaseReportRecords) > 0): ?>
                                    <?php $__currentLoopData = $purchaseReportRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $purchaseIn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $purchaseIn->rawItemDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $purchaseInDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td data-label="Supplier"><?php echo e($purchaseIn->supplier->name); ?></td>
                                                <td data-label="Raw Item"><?php echo e($purchaseInDetails->rawItem->name); ?></td>
                                                <td data-label="Quantity"><?php echo e($purchaseInDetails->quantity); ?></td>
                                                <td data-label="Cost Per Unit"><?php echo e($purchaseInDetails->cost_per_unit); ?> <?php echo e(config('basic.currency_symbol')); ?></td>
                                                <td data-label="Purchase Date"><?php echo e(customDate($purchaseInDetails->purchase_date)); ?></td>
                                                <td data-label="Sub Total"><?php echo e($purchaseInDetails->total_unit_cost); ?> <?php echo e(config('basic.currency_symbol')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            <img
                                                src="http://127.0.0.1/inventory_management/project/assets/global/img/no_data.gif"
                                                class="card-img-top empty-state-img" alt="..." style="width: 300px">
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </ul>
                </div>

            <?php endif; ?>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>

    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>

    <script>
        'use script'
        var serachRoute = "<?php echo e(route('user.purchaseReports')); ?>"
        $(document).on("click", ".downloadExcel", function () {
            $('.searchForm').attr('action', $(this).data('route'));
            $('.searchForm').submit();
            $('.searchForm').attr('action', serachRoute);
        });

        $(document).ready(function () {
            $(".flatpickr").flatpickr({
                wrap: true,
                altInput: true,
                dateFormat: "Y-m-d H:i",
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/reports/purchase/index.blade.php ENDPATH**/ ?>