<?php $__env->startSection('title', trans('Profit Loss Reports')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Profit Loss Reports'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Reports'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data" class="searchForm">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-4">
                            <label for="from_date"><?php echo app('translator')->get('From Date'); ?></label>

                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="<?php echo app('translator')->get('Select date'); ?>"
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

                        <div class="input-box col-lg-4">
                            <label for="to_date"><?php echo app('translator')->get('To Date'); ?></label>

                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="date" placeholder="<?php echo app('translator')->get('Select date'); ?>"
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

                        <div class="input-box col-lg-4">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if(isset($profitLossReportRecords) && count($search) > 0): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" data-route="<?php echo e(route('user.export.profitLossReports')); ?>"
                       class="btn btn-custom text-white reportsDownload downloadExcel"> <i
                            class="fa fa-download"></i> <?php echo app('translator')->get('Download Excel'); ?></a>
                </div>
            <?php endif; ?>

            <?php if(isset($profitLossReportRecords) && count($search) > 0): ?>
                <div class="report-box">
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th class="bg-white">
                                <h5 class="text-primary"><?php echo app('translator')->get('Reports Summery'); ?></h5>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo app('translator')->get('Total Purchase'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['totalPurchase'], false)); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo app('translator')->get('Total Stock'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['totalStocks'], false)); ?> </td>
                        </tr>

                        <?php if(userType() == 1): ?>
                            <tr>
                                <td><?php echo app('translator')->get('Total Sales'); ?></td>
                                <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['totalSales'], false)); ?> </td>
                            </tr>

                            <tr>
                                <td><?php echo app('translator')->get('Total Wastage'); ?></td>
                                <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['totalWastage'], false)); ?> </td>
                            </tr>

                            <tr>
                                <td><?php echo app('translator')->get('Total Affiliate Commission'); ?></td>
                                <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['totalAffiliateCommission'], false)); ?> </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td><?php echo app('translator')->get('Total Expense'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['totalExpense'], false)); ?> </td>
                        </tr>

                        <tr>
                            <td><?php echo app('translator')->get('Revenue'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['revenue'], false)); ?> </td>
                        </tr>

                        <tr>
                            <td><?php echo app('translator')->get('Net Profit'); ?></td>
                            <td class="<?php echo e($profitLossReportRecords['netProfit'] < 0 ? 'text-danger' : 'text-success'); ?>">
                                <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($profitLossReportRecords['netProfit'], false)); ?>

                            </td>
                        </tr>














                        </tbody>
                    </table>
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

        var serachRoute = "<?php echo e(route('user.profitLossReports')); ?>"
        $(document).on("click", ".downloadExcel", function () {
            $('.searchForm').attr('action', $(this).data('route'));
            $('.searchForm').submit();
            $('.searchForm').attr('action', serachRoute);
        });

        $(document).ready(function () {
            // $(".datepicker").datepicker({
            //     autoclose: true,
            //     clearBtn: true
            // });

            $(".flatpickr").flatpickr({
                wrap: true,
                altInput: true,
                dateFormat: "Y-m-d H:i",
            });

            // $('.from_date').on('change', function () {
            //     $('.to_date').removeAttr('disabled');
            // });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/reports/profitLoss/index.blade.php ENDPATH**/ ?>