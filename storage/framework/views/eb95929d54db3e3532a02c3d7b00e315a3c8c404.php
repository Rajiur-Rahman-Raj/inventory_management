<?php $__env->startSection('title', trans('Wastage Reports')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Wastage Reports'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Wastage Reports'); ?></li>
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

                        <div class="input-box col-lg-3">
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


                        <div class="input-box col-lg-3">
                            <label for=""><?php echo app('translator')->get('Raw Item'); ?></label>
                            <select class="form-control js-example-basic-single" name="raw_item_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All Items'); ?></option>
                                <?php $__currentLoopData = $rawItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rawItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($rawItem->id); ?>" <?php echo e(@request()->raw_item_id == $rawItem->id ? 'selected' : ''); ?>><?php echo e($rawItem->name); ?></option>
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
            <?php if(isset($wastageReportRecords) && count($wastageReportRecords) > 0 && count($search) > 0): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="javascript:void(0)" data-route="<?php echo e(route('user.export.wastageReports')); ?>"
                       class="btn btn-custom text-white reportsDownload downloadExcel"> <i
                            class="fa fa-download"></i> <?php echo app('translator')->get('Download Excel'); ?></a>
                </div>
            <?php endif; ?>

            <?php if(isset($wastageReportRecords) && count($search) > 0): ?>
                <ul class="list-style-none p-0 stock_list_style">
                    <table class="table table-bordered mt-4">
                        <thead>
                        <tr>
                            <th scope="col">Raw Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date Of Wastage</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if(count($wastageReportRecords) > 0): ?>
                            <?php $__currentLoopData = $wastageReportRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wastage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="Raw Item"><?php echo e($wastage->rawItem->name); ?></td>
                                    <td data-label="Quantity"><?php echo e($wastage->quantity); ?></td>
                                    <td data-label="Date Of Wastage"><?php echo e(customDate($wastage->wastage_date)); ?></td>
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
                        <?php if(count($wastageReportRecords) > 0): ?>
                            <tr>
                                <td colspan="1" class="text-end font-weight-bold"><?php echo app('translator')->get('Total Wastage'); ?>  </td>
                                <td class="font-weight-bold"><?php echo e($totalWastage); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </ul>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>

    <script>
        'use script'
        var serachRoute = "<?php echo e(route('user.wastageReports')); ?>"
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/reports/wastage/index.blade.php ENDPATH**/ ?>