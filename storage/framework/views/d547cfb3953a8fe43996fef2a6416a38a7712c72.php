<?php $__env->startSection('title', trans('Stock Missing Reports')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Stock Missing Reports'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page"><?php echo app('translator')->get('Stock Missing Reports'); ?></li>
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
                            <select class="form-control js-example-basic-single" name="item_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All Items'); ?></option>
                                <?php $__currentLoopData = $stockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e(optional($stockItem->item)->id); ?>" <?php echo e(@request()->item_id == optional($stockItem->item)->id ? 'selected' : ''); ?>><?php echo e(optional($stockItem->item)->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?></button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(isset($stockMissingReportRecords) && count($search) > 0): ?>
                <div class="card card-table">
                    <?php if(count($stockMissingReportRecords) > 0): ?>
                        <div
                            class="card-header custom-card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="m-0 text-primary"><?php echo app('translator')->get('All Missing Stocks'); ?></h5>

                            <div class="total-price">
                                <ul class="m-0 list-unstyled">
                                    <li class="text-uppercase  color-primary font-weight-bold mb-1">
                                        <span><?php echo app('translator')->get('Total Quantity'); ?> = </span>
                                        <span><?php echo e($totalMissing); ?> </span></li>

                                    <li class="text-uppercase color-primary font-weight-bold">
                                        <span><?php echo app('translator')->get('Total Amount'); ?> =</span>
                                        <span><?php echo e($totalMissingAmount); ?> <?php echo e(config('basic.currency_text')); ?></span></li>
                                </ul>
                            </div>

                            <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Stock_Missing_Report.permission.export'))): ?>
                                <a href="javascript:void(0)" data-route="<?php echo e(route('user.export.stockMissingReports')); ?>"
                                   class="btn text-white btn-custom2 reportsDownload downloadExcel"> <i
                                        class="fa fa-download"></i> <?php echo app('translator')->get('Download Excel File'); ?></a>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <ul class="list-style-none p-0 stock_list_style">
                            <table class="table custom-table table-bordered mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Cost Per Unit</th>
                                    <th scope="col">Sub Total</th>
                                    <th scope="col">Date Of Missing</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(count($stockMissingReportRecords) > 0): ?>
                                    <?php $__currentLoopData = $stockMissingReportRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stockMissing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td data-label="Item"><?php echo e(optional($stockMissing->item)->name); ?></td>
                                            <td data-label="Quantity"><?php echo e($stockMissing->quantity); ?></td>
                                            <td data-label="Cost Per Unit"><?php echo e(config('basic.currency_symbol')); ?> <?php echo e($stockMissing->cost_per_unit); ?></td>
                                            <td data-label="Sub Total"><?php echo e(config('basic.currency_symbol')); ?> <?php echo e($stockMissing->total_cost); ?></td>
                                            <td data-label="Date Of Missing"><?php echo e(customDate($stockMissing->missing_date)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            <img
                                                src="<?php echo e(asset('assets/global/img/no_data.gif')); ?>"
                                                class="card-img-top empty-state-img" alt="..." style="width: 300px">
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>

    <script>
        'use script'
        var serachRoute = "<?php echo e(route('user.stockMissingReports')); ?>"
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/reports/stockMissing/index.blade.php ENDPATH**/ ?>