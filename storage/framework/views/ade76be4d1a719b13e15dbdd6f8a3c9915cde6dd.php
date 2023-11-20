<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Dashboard'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title"><?php echo app('translator')->get('User Statistics'); ?></h4>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($userRecord['totalUser'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Total Users'); ?>
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-users fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($userRecord['activeUser'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Active Users'); ?>
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-users fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($userRecord['bannedUser'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Banned Users'); ?>
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-users fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($userRecord['totalVerifiedUser']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Verified Users'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-users fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($userRecord['todayJoin']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Today Join User'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-users fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($userRecord['totalUserBalance'], config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Total User Fund'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fas fa-money-bill color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($userRecord['totalInterestBalance'], config('basic.fraction_number'))); ?> </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Total Interest Fund'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fas fa-money-bill color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($userRecord['totalReferralBonus'], config('basic.fraction_number'))); ?> </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Total Referral Bonus'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fas fa-money-bill color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title"><?php echo app('translator')->get('Property Statistics'); ?></h4>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($property['totalProperty']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Property"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-building fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($property['runningProperty']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Running Property"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-building fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($property['upcomingProperty']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Upcoming Property"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-building fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($property['expiredProperty']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Expired Property"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-building fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title"><?php echo app('translator')->get('Investment Statistics'); ?></h4>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($investment['totalInvestment']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Investment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-store fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($investment['activeInvestment']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Active Investment'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-store fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($investment['deactiveInvestment']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Deactive Investment'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-store fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($runningInvestment); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Running Investment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fa fa-running color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($investment['dueInvestment']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Due Investment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fa fa-calendar-minus color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($expiredInvestment); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Expired Investment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fa fa-calendar-minus color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($investment['completeInvestment']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Complete Investment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fas fa-calendar-check color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($investment['monthlyTotalInvestment']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("This Month Investment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fab fa-pagelines color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($investment['todayInvestment']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Today Investment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-dollar-sign fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($investment['totalInvestAmount'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Invested Amount"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-dollar-sign fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($investment['monthlyInvestmentAmount'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("This Month Invested"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-dollar-sign fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($investment['todayInvestmentAmount'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Today's Invested"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-dollar-sign fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title"><?php echo app('translator')->get("This Month's Summary"); ?></h4>
                                <div>
                                    <canvas id="line-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title"><?php echo app('translator')->get('Deposit Statistics'); ?></h4>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['totalAmountReceived'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Deposit"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fa fa-hand-holding-usd color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['monthlyDepositAmount'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("This Month Deposit"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fa fa-hand-holding-usd color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['todayDeposit'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Today's Deposit"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i
                                        class="fa fa-hand-holding-usd color-secondary fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['totalChargeReceived'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Deposit Charge"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-funnel-dollar fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['monthlyDepositCharge'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("This Month Deposit Charge"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-funnel-dollar fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($funding['pendingDeposit'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Pending Deposit'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fas fa-circle-notch fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title"><?php echo app('translator')->get('Payout Statistics'); ?></h4>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($payout['totalPayoutAmount'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Payout"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 color-secondary"><i class="fa fa-file-invoice-dollar fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($payout['monthlyPayoutAmount'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("This Month Payout"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 color-secondary"><i class="fa fa-file-invoice-dollar fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($payout['todayPayoutAmount'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Today's Payout"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 color-secondary"><i class="fa fa-file-invoice-dollar fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($payout['totalPayoutCharge'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Payout Charge"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-hand-holding-usd fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($payout['monthlyPayoutCharge'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("This Month Payout Charge"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-hand-holding-usd fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($payout['pendingPayout'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Pending Payout'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fas fa-circle-notch fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title"><?php echo app('translator')->get('Tickets'); ?></h4>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['pending'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Pending Ticket"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-spinner fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['answered'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Answered Ticket'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-check fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['replied'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Replied Ticket'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-reply fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['replied'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Closed Ticket'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-times-circle fa-2x"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(adminAccessRoute(config('role.manage_user.access.view'))): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo app('translator')->get('Latest User'); ?></h4>
                            <div class="table-responsive">
                                <table class="categories-show-table table table-hover table-striped table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Upline'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Email'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Balance'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Interest Balance'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                        <?php if(adminAccessRoute(config('role.manage_user.access.edit'))): ?>
                                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $latestUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-label="<?php echo app('translator')->get('Name'); ?>">
                                                <a href="<?php echo e(route('admin.user-edit',[$user->id])); ?>" target="_blank">
                                                    <div class="d-flex no-block align-items-center">
                                                        <div class="mr-3 thumb">
                                                            <img
                                                                src="<?php echo e(getFile(config('location.user.path').$user->image)); ?>"
                                                                alt="user" class="rounded-circle user-img" width="45"
                                                                height="45">
                                                            <?php if($user->last_level != null): ?>
                                                                <img
                                                                    src="<?php echo e(getFile(config('location.badge.path').optional($user->userBadge)->badge_icon)); ?>"
                                                                    alt="<?php echo app('translator')->get('badge icon'); ?>" class="rank-badge" data-toggle="tooltip" data-placement="top" title="<?php echo e(optional($user->userBadge->details)->rank_level); ?> (<?php echo e(optional($user->userBadge->details)->rank_name); ?>)">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="">
                                                            <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo app('translator')->get($user->firstname); ?> <?php echo app('translator')->get($user->lastname); ?> </h5>
                                                            <span class="text-muted font-14"><span>@</span><?php echo app('translator')->get($user->username); ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Upline'); ?>">
                                                <?php if(isset($user->referral_id)): ?>
                                                    <a href="<?php echo e(route('admin.user-edit',[$user->referral_id])); ?>"
                                                       target="_blank">
                                                        <div class="d-flex no-block align-items-center">
                                                            <div class="mr-3 thumb">
                                                                <img src="<?php echo e(getFile(config('location.user.path').optional($user->referral)->image)); ?>" alt="user" class="rounded-circle user-img" width="45" height="45">
                                                                <?php if($user->referral->last_level != null): ?>
                                                                    <img src="<?php echo e(getFile(config('location.badge.path').optional($user->referral->userBadge)->badge_icon)); ?>" alt="<?php echo app('translator')->get('badge icon'); ?>" class="rank-badge" data-toggle="tooltip" data-placement="top" title="<?php echo e(optional($user->referral->userBadge->details)->rank_level); ?> (<?php echo e(optional($user->referral->userBadge->details)->rank_name); ?>)">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="">
                                                                <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo app('translator')->get(optional($user->referral)->firstname); ?> <?php echo app('translator')->get(optional($user->referral)->lastname); ?></h5>
                                                                <span class="text-muted font-14"><span>@</span><?php echo app('translator')->get(optional($user->referral)->username); ?></span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-na"><?php echo app('translator')->get('N/A'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Email'); ?>"><?php echo app('translator')->get($user->email); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Balance'); ?>"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($user->balance, config('basic.fraction_number'))); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Interest Balance'); ?>"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($user->interest_balance, config('basic.fraction_number'))); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                            <span
                                                class="custom-badge badge-pill <?php echo e($user->status == 0 ? 'bg-danger' : 'bg-success'); ?>"><?php echo e($user->status == 0 ? 'Inactive' : 'Active'); ?></span>
                                            </td>
                                            <?php if(adminAccessRoute(config('role.manage_user.access.edit'))): ?>
                                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                                    <div class="dropdown show">
                                                        <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink"
                                                           data-toggle="dropdown"
                                                           aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item"
                                                               href="<?php echo e(route('admin.user-edit',$user->id)); ?>">
                                                                <i class="fa fa-edit text-warning pr-2"
                                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Edit'); ?>
                                                            </a>

                                                            <a class="dropdown-item"
                                                               href="<?php echo e(route('admin.send-email',$user->id)); ?>">
                                                                <i class="fa fa-envelope text-success pr-2"
                                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Send Email'); ?>
                                                            </a>
                                                            <a class="dropdown-item loginAccount" type="button"
                                                               data-toggle="modal"
                                                               data-target="#signIn"
                                                               data-route="<?php echo e(route('admin.login-as-user',$user->id)); ?>">
                                                                <i class="fas fa-sign-in-alt text-success pr-2"
                                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Login as User'); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td class="text-center text-na" colspan="100%"><?php echo app('translator')->get('No User Data'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <?php if($basic->is_active_cron_notification): ?>
        <div class="modal fade" id="cron-info" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle"></i>
                            <?php echo app('translator')->get('Cron Job Set Up Instruction'); ?>
                        </h5>
                        <button type="button" class="close cron-notification-close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="bg-orange text-white p-2">
                                    <i><?php echo app('translator')->get('**To sending emails and sms and updating Investment return automatically you need to setup cron job in your server. Make sure your job is running properly. We insist to set the cron job time as minimum as possible.**'); ?></i>
                                </p>
                            </div>
                            <div class="col-md-12 form-group">
                                <label><strong><?php echo app('translator')->get('Command for Email & SMS'); ?></strong></label>
                                <div class="input-group ">
                                    <input type="text" class="form-control copyText"
                                           value="curl -s <?php echo e(route('queue.work')); ?>" disabled>
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
                                            <i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label><strong><?php echo app('translator')->get('Command for investment update'); ?></strong></label>
                                <div class="input-group ">
                                    <input type="text" class="form-control copyText"
                                           value="curl -s <?php echo e(route('cron')); ?>"
                                           disabled>
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
                                            <i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class="bg-dark text-white p-2">
                                    <?php echo app('translator')->get('*To turn off this pop up go to '); ?>
                                    <a href="<?php echo e(route('admin.basic-controls')); ?>"
                                       class="text-orange"><?php echo app('translator')->get('Basic control'); ?></a>
                                    <?php echo app('translator')->get(' and disable `Cron Set Up Pop Up`.*'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Admin Login as a User Modal -->
    <div class="modal fade" id="signIn">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="" class="loginAccountAction" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <!-- Modal Header -->
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title"><?php echo app('translator')->get('Sing In Confirmation'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure to sign in this account?'); ?></p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span>
                        </button>
                        <button type="submit" class=" btn btn-primary "><span><?php echo app('translator')->get('Yes'); ?></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/admin/js/Chart.min.js')); ?>"></script>

    <script>
        "use strict";
        new Chart(document.getElementById("line-chart"), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($statistics['schedule']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo json_encode($statistics['investment']->values(), 15, 512) ?>,
                    label: "Investments",
                    borderColor: "#6fbbff",
                    fill: false
                }, {
                    data: <?php echo json_encode($statistics['gaveProfit']->values(), 15, 512) ?>,
                    label: "Profit",
                    borderColor: "#98df8a",
                    fill: false
                }, {
                    data: <?php echo json_encode($statistics['deposit']->values(), 15, 512) ?>,
                    label: "Deposits",
                    borderColor: "#ff6f62",
                    fill: false
                }, {
                    data: <?php echo json_encode($statistics['payout']->values(), 15, 512) ?>,
                    label: "Payout",
                    borderColor: "#8b6ef3",
                    fill: false
                }
                ]
            }
        });


        $(document).on('click', '#details', function () {
            var title = $(this).data('servicetitle');
            var description = $(this).data('description');
            $('#title').text(title);
            $('#servicedescription').text(description);
        });

        $(document).ready(function () {
            let isActiveCronNotification = '<?php echo e($basic->is_active_cron_notification); ?>';
            if (isActiveCronNotification == 1)
                $('#cron-info').modal('show');
            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).parents('.input-group-append').siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });


            $(document).on('click', '.loginAccount', function () {
                var route = $(this).data('route');
                $('.loginAccountAction').attr('action', route)
            });
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>