<?php $__env->startSection('title', trans('Affiliate Commission Report')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Affiliate Commission Report'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page"><?php echo app('translator')->get('Affiliate Commission Report'); ?></li>
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
                            <select class="form-control js-example-basic-single" name="central_promoter_id"
                                    aria-label="Default select example">
                                <?php $__currentLoopData = $centralPromoter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promoter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($promoter->id); ?>" <?php echo e(@request()->central_promoter_id == $promoter->id ? 'selected' : ''); ?>><?php echo e(kebab2Title($promoter->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-3">
                            <select class="form-control js-example-basic-single" name="affiliate_member_id"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All Members'); ?></option>
                                <?php $__currentLoopData = $affiliateMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($member->id); ?>" <?php echo e(@request()->affiliate_member_id == $member->id ? 'selected' : ''); ?>><?php echo e($member->member_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="input-box col-lg-12">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if(isset($affiliateReportRecords) && count($search) > 0): ?>
                <div class="card card-table">
                    <?php if(count($affiliateReportRecords) > 0): ?>
                        <div
                            class="card-header custom-card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="m-0 text-primary"><?php echo app('translator')->get('All Affiliate Commissions'); ?></h5>

                            <div class="total-price">
                                <ul class="m-0 list-unstyled">
                                    <li class="text-uppercase color-primary font-weight-bold">
                                        <span><?php echo app('translator')->get('Total Commission'); ?> =</span>
                                        <span><?php echo e($totalCommission); ?> <?php echo e(config('basic.currency_text')); ?> </span></li>
                                </ul>

                            </div>

                            <?php if(adminAccessRoute(config('permissionList.Manage_Reports.Affiliation_Report.permission.export'))): ?>
                                <a href="javascript:void(0)" data-route="<?php echo e(route('user.export.affiliateReports')); ?>"
                                   class="btn text-white btn-custom2 reportsDownload downloadExcel"> <i
                                        class="fa fa-download"></i> <?php echo app('translator')->get('Download Excel File'); ?></a>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                    <ul class="list-style-none p-0 stock_list_style">
                        <div class="table-responsive">
                            <table class="table custom-table table-bordered mt-4">
                                <thead>
                                <tr>
                                    <th scope="col">Affiliator</th>
                                    <th scope="col">Commission</th>
                                    <th scope="col">Date Of Commission</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(count($affiliateReportRecords) > 0): ?>
                                    <?php $__currentLoopData = $affiliateReportRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td data-label="Affiliator">
                                                <?php echo e($key == 0 ? $commission->centralPromoter->name : $commission->affiliateMember->member_name); ?>

                                            </td>
                                            <td data-label="Commission"><?php echo e($commission->amount); ?></td>
                                            <td data-label="Date Of Commission"><?php echo e($commission->commission_date); ?></td>
                                        </tr>
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
        var serachRoute = "<?php echo e(route('user.affiliateReports')); ?>"
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/reports/affiliate/index.blade.php ENDPATH**/ ?>