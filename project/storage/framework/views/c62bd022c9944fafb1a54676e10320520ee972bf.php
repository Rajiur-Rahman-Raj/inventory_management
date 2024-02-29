<?php $__env->startSection('title', trans('Reports')); ?>
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
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Reports'); ?></h3>
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
            <?php if(isset($reportRecords) && count($search) > 0): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" data-route="<?php echo e(route('user.export.stockExpenseSalesProfitReports')); ?>"
                       class="btn btn-custom text-white reportsDownload downloadExcel"> <i
                            class="fa fa-download"></i> <?php echo app('translator')->get('Download Excel'); ?></a>
                </div>
            <?php endif; ?>
            
            <?php if(isset($reportRecords) && count($search) > 0): ?>
                <div class="report-box">
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th class="bg-white"><?php echo app('translator')->get('Reports Summery'); ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo app('translator')->get('Total Stock'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['totalStockAmount'], false)); ?>


                            </td>
                        </tr>

                        <tr>
                            <td><?php echo app('translator')->get('Total Sale'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['totalSalesAmount'], false)); ?> </td>
                        </tr>


                        <?php if(userType() == 1): ?>
                            <tr>
                                <td><?php echo app('translator')->get('Sold To Sales Center'); ?></td>
                                <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['soldSalesCenterAmount'], false)); ?> </td>
                            </tr>

                            <tr>
                                <td><?php echo app('translator')->get('Sales Center Due'); ?></td>
                                <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['dueSalesCenterAmount'], false)); ?> </td>
                            </tr>

                            <tr>
                                <td><?php echo app('translator')->get('Sold To Customer'); ?></td>
                                <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['soldCustomerAmount'], false)); ?> </td>
                            </tr>

                        <?php endif; ?>

                        <tr>
                            <td><?php echo app('translator')->get('Customer Due'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['dueCustomerAmount'], false)); ?> </td>
                        </tr>


                        <?php if(userType() == 1): ?>
                            <tr>
                                <td><?php echo app('translator')->get('Expense'); ?></td>
                                <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['totalExpenseAmount'], false)); ?> </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td><?php echo app('translator')->get('Sales profit'); ?></td>
                            <td> <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['salesProfit'], false)); ?> </td>
                        </tr>

                        <?php if(userType() == 1): ?>
                            <tr>
                                <td><?php echo app('translator')->get('Net profit'); ?></td>
                                
                                <td class="<?php echo e($reportRecords['netProfit'] < 0 ? 'text-danger' : 'text-success'); ?>">
                                    <?php echo e(config('basic.currency_text')); ?> <?php echo e(fractionNumber($reportRecords['netProfit'], false)); ?>

                                </td>
                            </tr>
                        <?php endif; ?>


                        
                        
                        
                        
                        
                        
                        
                        
                        

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

        var serachRoute = "<?php echo e(route('user.stockExpenseSalesProfitReports')); ?>"
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/reports/index.blade.php ENDPATH**/ ?>