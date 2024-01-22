<?php $__env->startSection('title',trans('Invest Details')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Investment Details'); ?></h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Invest Details'); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="main row p-0">
            <div class="col-12">
                <div class="view-property-details">
                    <div class="row ms-2 me-2">
                        <div class="col-md-12 p-0">
                            <div class="card investment-details-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end investment__block">
                                        <a href="<?php echo e(route('user.invest-history')); ?>" class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?> </span>
                                        </a>
                                    </div>

                                    <div class="p-4 border shadow-sm rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"> <i class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Investment Date'); ?>: </h6>
                                                        <p><?php echo e(dateTime($singleInvestDetails->created_at)); ?></p>
                                                    </div>
                                                    <div class="property d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"> <i class="far fa-building me-2 text-success"></i> <?php echo app('translator')->get('Property'); ?>:</h6>
                                                        <p class="float-end">
                                                            <a href="<?php echo e(route('propertyDetails',[@slug(optional($singleInvestDetails->property->details)->property_title), optional($singleInvestDetails->property)->id])); ?>">
                                                                <?php echo app('translator')->get(optional($singleInvestDetails->property->details)->property_title); ?>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>

                                                <ul class="invest-history-details-ul">
                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color" aria-hidden="true"></i> <?php echo app('translator')->get('Transaction Id'); ?> : <span class="font-weight-bold text-dark"><?php echo e($singleInvestDetails->trx); ?></span></span>
                                                    </li>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary" aria-hidden="true"></i> <?php echo app('translator')->get('Invest'); ?> : <span class="font-weight-bold text-primary"><?php echo e(config('basic.currency_symbol')); ?><?php echo e($singleInvestDetails->amount); ?></span></span>
                                                    </li>

                                                    <li class="my-3 list-style-none">
                                                        <span><i class="fal fa-check-circle site__color text-primary" aria-hidden="true"></i> <?php echo app('translator')->get('Profit'); ?> : <span class="font-weight-bold text-primary"><?php echo e(config('basic.currency_symbol')); ?><?php echo e($singleInvestDetails->net_profit); ?></span></span>
                                                    </li>


                                                    <?php if($singleInvestDetails->is_installment == 1): ?>
                                                        <li class="my-3">
                                                            <span class="font-weight-bold"><i class="fal fa-check-circle site__color text-success" aria-hidden="true"></i> <?php echo app('translator')->get('Total Installment'); ?> : <span class="font-weight-bold text-success"><?php echo e($singleInvestDetails->total_installments); ?></span></span>
                                                        </li>

                                                        <li class="my-3">
                                                            <span class="font-weight-bold"><i class="fal fa-times-circle text-warning" aria-hidden="true"></i> <?php echo app('translator')->get('Due Installment'); ?> : <span class="font-weight-bold text-success"><?php echo e($singleInvestDetails->due_installments); ?></span></span>
                                                        </li>

                                                        <li class="my-3">
                                                            <span class="font-weight-bold"><i class="fal fa-check-circle site__color text-purple" aria-hidden="true"></i> <?php echo app('translator')->get('Next Installment Start'); ?> : <span class="font-weight-bold text-purple"><?php echo e(dateTime($singleInvestDetails->next_installment_date_start)); ?></span></span>
                                                        </li>

                                                        <li class="my-3">
                                                            <span class="font-weight-bold"><i class="fal fa-check-circle site__color text-purple" aria-hidden="true"></i> <?php echo app('translator')->get('Next Installment End'); ?> : <span class="font-weight-bold text-purple"><?php echo e(dateTime($singleInvestDetails->next_installment_date_end)); ?></span></span>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color" aria-hidden="true"></i> <?php echo app('translator')->get('Profit Return Interval'); ?> : <span class="font-weight-bold text-primary"><?php echo e($singleInvestDetails->return_time); ?> <?php echo e($singleInvestDetails->return_time_type); ?></span></span>
                                                    </li>

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color <?php echo e($singleInvestDetails->how_many_times == 0 ? 'text-danger' : 'text-success'); ?>" aria-hidden="true"></i> <?php echo app('translator')->get('Return How Many Times'); ?> : <span class="font-weight-bold text-success"><?php echo e($singleInvestDetails->how_many_times == null ? 'Lifetime' : $singleInvestDetails->how_many_times); ?></span></span>
                                                    </li>

                                                    <li class="my-3">
                                                            <span><i class="fal fa-check-circle site__color" aria-hidden="true"></i> <?php echo app('translator')->get('Next Profit Return Date'); ?> :
                                                                <span class="font-weight-bold">
                                                                    <?php if($singleInvestDetails->invest_status == 0): ?>
                                                                        <span class="badge bg-danger"><?php echo app('translator')->get('After All Installment completed'); ?></span>
                                                                    <?php elseif($singleInvestDetails->invest_status == 1 && $singleInvestDetails->return_date == null && $singleInvestDetails->status == 1): ?>
                                                                        <span class="badge bg-success"><?php echo app('translator')->get('Completed'); ?></span>
                                                                    <?php else: ?>
                                                                        <?php echo e(customDate($singleInvestDetails->return_date)); ?>

                                                                    <?php endif; ?>
                                                                </span>
                                                            </span>
                                                    </li>

                                                    <li class="my-3">
                                                        <span><i class="<?php echo e($singleInvestDetails->last_return_date != null ? 'fal fa-check-circle text-success' : 'fal fa-times-circle text-danger'); ?>" aria-hidden="true"></i> <?php echo app('translator')->get('Last Profit Return Date'); ?> : <span class="<?php echo e($singleInvestDetails->last_return_date != null ? 'text-dark font-weight-bold' : 'text-danger font-weight-bold'); ?>"><?php echo e($singleInvestDetails->last_return_date != null ? customDate($singleInvestDetails->last_return_date) : 'N/A'); ?></span></span>
                                                    </li>

                                                    <li class="my-3">
                                                        <span><i class="fal <?php echo e($singleInvestDetails->invest_status == 1 ? 'fa-check-circle' : 'fa-times-circle'); ?> site__color" aria-hidden="true"></i> <?php echo app('translator')->get('Investment Payment Status'); ?> : <span class="badge <?php echo e($singleInvestDetails->invest_status == 1 ? 'bg-success' : 'bg-warning'); ?>"><?php echo e($singleInvestDetails->invest_status == 1 ? trans('Complete'): trans('Due')); ?></span></span>
                                                    </li>

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color"
                                                                 aria-hidden="true"></i> <?php echo app('translator')->get('Profit Return Status'); ?> : <span
                                                                class="badge
                                                        <?php if($singleInvestDetails->status == 1 && $singleInvestDetails->invest_status == 1): ?>
                                                            bg-success
                                                        <?php elseif($singleInvestDetails->status == 0 && $singleInvestDetails->invest_status == 0): ?>
                                                            bg-warning
                                                        <?php elseif($singleInvestDetails->status == 0 && $singleInvestDetails->invest_status == 1): ?>
                                                            bg-primary
                                                        <?php endif; ?>">
                                                            <?php if($singleInvestDetails->status == 1 && $singleInvestDetails->invest_status == 1): ?>
                                                                    <?php echo app('translator')->get('Completed'); ?>
                                                                <?php elseif($singleInvestDetails->status == 0 && $singleInvestDetails->invest_status == 0): ?>
                                                                    <?php echo app('translator')->get('Upcoming'); ?>
                                                                <?php elseif($singleInvestDetails->status == 0 && $singleInvestDetails->invest_status == 1): ?>
                                                                    <?php echo app('translator')->get('Running'); ?>
                                                                <?php endif; ?>
                                                            </span>
                                                        </span>
                                                    </li>

                                                    <li class="my-3">
                                                        <span><i class="fal fa-check-circle site__color" aria-hidden="true"></i> <?php echo app('translator')->get('Investment Status'); ?> : <span class="badge <?php echo e($singleInvestDetails->is_active == 1 ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($singleInvestDetails->is_active == 1 ? trans('Active') : trans('Deactive')); ?></span></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/transaction/investDetails.blade.php ENDPATH**/ ?>