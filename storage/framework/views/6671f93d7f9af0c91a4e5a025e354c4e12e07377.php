<?php $__env->startSection('title',trans('Dashboard')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <style>
            .balance-box {
                background: linear-gradient(to right,<?php echo e(hex2rgba(config('basic.base_color'))); ?>,<?php echo e(hex2rgba(config('basic.secondary_color'))); ?>);
            }
        </style>
    <?php $__env->stopPush(); ?>
    <!-- Balance Box -->
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card-box balance-box p-0 h-100">
                            <div class="user-account-number p-4 h-100">
                                <i class="account-wallet far fa-wallet"></i>
                                <div class="mb-4">
                                    <h5 class="text-white mb-2">
                                        <?php echo app('translator')->get('Main Balance'); ?>
                                    </h5>
                                    <h3>
                                        <span class="text-white"><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($walletBalance, config('basic.fraction_number'))); ?></span>
                                    </h3>
                                </div>
                                <div class="">
                                    <h5 class="text-white mb-2">
                                        <?php echo app('translator')->get('Interest Balance'); ?>
                                    </h5>
                                    <h3><span class="text-white otal_available__balance"><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($interestBalance, config('basic.fraction_number'))); ?></span></h3>
                                </div>
                                <a href="#" class="cash-in"><i class="fal fa-plus me-1"></i> <?php echo app('translator')->get('Cash In'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 d-sm-block d-none">
                        <div class="row g-3">
                            <div class="col-lg-12 col-6">
                                <div class="dashboard-box gr-bg-1">
                                    <h5 class="text-white"><?php echo app('translator')->get('Total Deposit'); ?></h5>
                                    <h3 class="text-white"><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><span><?php echo e(getAmount($totalDeposit, config('basic.fraction_number'))); ?></span></h3>
                                    <i class="fal fa-file-invoice-dollar text-white"></i>
                                </div>
                            </div>

                            <div class="col-lg-12 col-6">
                                <div class="dashboard-box gr-bg-2">
                                    <h5 class="text-white"><?php echo app('translator')->get('Total Payout'); ?></h5>
                                    <h3 class="text-white"><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><span><?php echo e(getAmount($totalPayout)); ?></span></h3>
                                    <i class="fal fa-usd-circle text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-sm-block d-none">
                        <div class="row g-3">
                            <div class="col-xl-12 col-6">
                                <div class="dashboard-box gr-bg-3">
                                    <h5 class="text-white"><?php echo app('translator')->get('Total Invest'); ?></h5>
                                    <h3 class="text-white"><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><span><?php echo e(getAmount($investment['totalInvestAmount'])); ?></span></h3>
                                    <i class="far fa-funnel-dollar text-white"></i>
                                </div>
                            </div>
                            <div class="col-xl-12 col-6 box">
                                <div class="dashboard-box gr-bg-4">
                                    <h5 class="text-white"><?php echo app('translator')->get('Running Invest'); ?></h5>
                                    <h3 class="text-white"><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><span> <?php echo e(getAmount($investment['runningInvestAmount'])); ?></span></h3>
                                    <i class="far fa-funnel-dollar text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- main -->
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-box-wrapper d-none d-lg-block">
                    <div class="row g-3 mb-4">

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Total Investment'); ?></h5>
                                <h3><?php echo e($investment['totalInvestment']); ?></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Running Investment'); ?></h5>
                                <h3><?php echo e($investment['runningInvestment']); ?></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Due Investment'); ?></h5>
                                <h3><?php echo e($investment['dueInvestment']); ?></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Completed Investment'); ?></h5>
                                <h3><?php echo e($investment['completedInvestment']); ?></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Total Referral Bonus'); ?></h5>
                                <h3><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($depositBonus + $investBonus + $profitBonus)); ?></h3>
                                <i class="fal fa-lightbulb-dollar"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Last Referral Bonus'); ?></h5>
                                <h3><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><span><?php echo e(getAmount($lastBonus)); ?></span></h3>
                                <i class="far fa-badge-dollar"></i>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Total Earn'); ?></h5>
                                <h3><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><span><?php echo e(getAmount($totalInterestProfit, config('basic.fraction_number'))); ?></span></h3>
                                <i class="far fa-hand-holding-usd"></i>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h5><?php echo app('translator')->get('Total Ticket'); ?></h5>
                                <h3><?php echo e($ticket); ?></h3>
                                <i class="fal fa-ticket"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-lg-none mb-4">
                    <div class="card-box-wrapper owl-carousel card-boxes">
                        <div class="dashboard-box gr-bg-1">
                            <h5 class="text-white"><?php echo app('translator')->get('Main Balance'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($walletBalance, config('basic.fraction_number'))); ?>

                            </h3>
                            <i class="fal fa-funnel-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-2">
                            <h5 class="text-white"><?php echo app('translator')->get('Interest Balance'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($interestBalance, config('basic.fraction_number'))); ?>

                            </h3>
                            <i class="fal fa-hand-holding-usd text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-3">
                            <h5 class="text-white"><?php echo app('translator')->get('Total Deposit'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($totalDeposit, config('basic.fraction_number'))); ?>

                            </h3>
                            <i class="fal fa-box-usd text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-5">
                            <h5 class="text-white"><?php echo app('translator')->get('Total Invest'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($investment['totalInvestAmount'])); ?>

                            </h3>
                            <i class="fal fa-search-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-5">
                            <h5 class="text-white"><?php echo app('translator')->get('Running Invest'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($investment['runningInvestAmount'])); ?>

                            </h3>
                            <i class="fal fa-search-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-4">
                            <h5 class="text-white"><?php echo app('translator')->get('Total Earn'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($totalInterestProfit, config('basic.fraction_number'))); ?>

                            </h3>
                            <i class="fal fa-badge-dollar text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-6">
                            <h5 class="text-white"><?php echo app('translator')->get('Total Payout'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($totalPayout)); ?>

                            </h3>
                            <i class="fal fa-usd-circle text-white"></i>
                        </div>
                        <div class="dashboard-box gr-bg-7">
                            <h5 class="text-white"><?php echo app('translator')->get('Total Referral Bonus'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($depositBonus + $investBonus)); ?>

                            </h3>
                            <i class="fal fa-lightbulb-dollar text-white"></i>
                        </div>

                        <div class="dashboard-box gr-bg-8">
                            <h5 class="text-white"><?php echo app('translator')->get('Last Referral Bonus'); ?></h5>
                            <h3 class="text-white">
                                <small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><?php echo e(getAmount($lastBonus, config('basic.fraction_number'))); ?>

                            </h3>
                            <i class="fal fa-box-open text-white"></i>
                        </div>

                        <div class="dashboard-box gr-bg-9">
                            <h5 class="text-white"><?php echo app('translator')->get('Total Ticket'); ?></h5>
                            <h3 class="text-white"><?php echo e($ticket); ?></h3>
                            <i class="fal fa-ticket text-white"></i>
                        </div>
                    </div>
                </div>

                <!---- charts ----->
                <div class="chart-information d-none d-lg-block">
                    <div class="row justify-content-center">
                        <div class="row">
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="progress-wrapper">
                                    <div id="container" class="apexcharts-canvas"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="progress-wrapper2">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 box mb-3">
                                            <div class="badge-dashboard-box2" id="custom_badge_dashboad_box2">
                                                <h5 class="mb-0"><?php echo app('translator')->get('Current Level'); ?></h5>
                                                <div>

                                                    <div class="level-box">
                                                        <h6 class="m-0">
                                                            <?php if($lastInvestorBadge == null): ?>
                                                                <i class="fa fa-times"></i>
                                                            <?php else: ?>
                                                                <?php echo app('translator')->get(optional($investorBadge->details)->rank_level); ?>
                                                            <?php endif; ?>
                                                        </h6>
                                                        <?php if($lastInvestorBadge != null && optional($investorBadge->details)->rank_level != null): ?>
                                                            <img src="<?php echo e(getFile(config('location.badge.path').$lastInvestorBadge->badge_icon)); ?>" alt="" class="level-badge" />
                                                        <?php endif; ?>
                                                    </div>

                                                    <?php if($lastInvestorBadge != null): ?>
                                                        <p class="custom__p <?php echo e(optional($investorBadge->details)->rank_level == null ? 'opacity-0' : ''); ?>"> <?php echo e(optional($investorBadge->details)->rank_level == null ? '...' : trans(optional($investorBadge->details)->rank_name)); ?></p>
                                                    <?php else: ?>
                                                        <p class="opacity-0"><?php echo app('translator')->get('no level'); ?></p>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 box mb-3">
                                            <div class="badge-dashboard-box1">
                                                <h5><?php echo app('translator')->get('Level Bonus'); ?></h5>
                                                <h3><small><sup><?php echo e(trans(config('basic.currency_symbol'))); ?></sup></small><span><?php echo e($totalBadgeBonus); ?></span></h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div>
                                                <div class="badge-dashboard-box2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5><?php echo app('translator')->get('All Badges'); ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <?php $__currentLoopData = $allBadges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-xl-3 col-md-6 box">
                                                                <div class="badge-box badge-box-two <?php echo e(Auth::user()->ranking($badge->id) == 'true' ? '' : 'locked'); ?>" id="badge-box-two">
                                                                    <img src="<?php echo e(getFile(config('location.badge.path').$badge->badge_icon)); ?>" alt="" />
                                                                    <p class="mb-3 text-center m-auto"><?php echo app('translator')->get(optional($badge->details)->rank_name); ?></p>
                                                                    <div class="lock-icon">
                                                                        <i class="far fa-lock-alt"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                <!-- refferal-information -->
                <div class="search-bar refferal-link  g-4 mt-4 mb-4 coin-box-wrapper">
                    <form class="mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="input-box col-lg-12">
                                <label for=""><?php echo app('translator')->get('Referral Link'); ?></label>
                                <div class="input-group mt-0">
                                    <input
                                        type="text"
                                        value="<?php echo e(route('register.sponsor',[Auth::user()->username])); ?>"
                                        class="form-control"
                                        id="sponsorURL"
                                        readonly />
                                    <button class="gold-btn copyReferalLink" type="button"><i class="fal fa-copy"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset($themeTrue.'js/apexcharts.js')); ?>"></script>

    <script>
        "use strict";

        var options = {
            theme: {
                mode: "light",
            },

            series: [
                {
                    name: "<?php echo e(trans('Deposit')); ?>",
                    color: 'rgba(255, 72, 0, 1)',
                    data: <?php echo $monthly['funding']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Deposit Bonus')); ?>",
                    color: 'rgba(39, 144, 195, 1)',
                    data: <?php echo $monthly['referralFundBonus']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Investment')); ?>",
                    color: 'rgba(247, 147, 26, 1)',
                    data: <?php echo $monthly['investment']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Investment Bonus')); ?>",
                    color: 'rgba(136, 203, 245, 1)',
                    data: <?php echo $monthly['referralInvestBonus']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Profit')); ?>",
                    color: 'rgba(247, 147, 26, 1)',
                    data: <?php echo $monthly['monthlyGaveProfit']->flatten(); ?>

                },
                {
                    name: "<?php echo e(trans('Payout')); ?>",
                    color: 'rgba(240, 16, 16, 1)',
                    data: <?php echo $monthly['payout']->flatten(); ?>

                },
            ],
            chart: {
                type: 'bar',
                height: 350,
                background: '#fff',
                toolbar: {
                    show: false
                }

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo $monthly['investment']->keys(); ?>,

            },
            yaxis: {
                title: {
                    text: ""
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                colors: ['#000'],
                y: {
                    formatter: function (val) {
                        return "<?php echo e(trans($basic->currency_symbol)); ?>" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#container"), options);
        chart.render();

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

            $(document).on('click', '.copyReferalLink', function () {
                var _this = $(this)[0];
                var copyText = $(this).siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Copied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fal fa-copy"></i>');
                }, 500)
            });
        })
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/dashboard.blade.php ENDPATH**/ ?>