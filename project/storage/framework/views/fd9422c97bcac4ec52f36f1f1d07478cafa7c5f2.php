<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Transaction'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap-datepicker.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Transaction History'); ?></h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('transaction'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>


            <!-- search area -->
            <div class="search-bar p-0">
                <form action="<?php echo e(route('user.transaction.search')); ?>" method="get">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-3">
                            <input
                                type="text"
                                name="transaction_id"
                                value="<?php echo e(@request()->transaction_id); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Transaction ID'); ?>"/>
                        </div>

                        <div class="input-box col-lg-3">
                            <input type="text" name="remark" value="<?php echo e(@request()->remark); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Remark'); ?>"/>
                        </div>


                        <div class="input-box col-lg-2">
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date" value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>" autocomplete="off" readonly/>
                        </div>

                        <div class="input-box col-lg-2">
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date" value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>" autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i> <?php echo app('translator')->get('Search'); ?> </button>
                        </div>
                    </div>
                </form>
            </div>


        <div class="row mt-4">
            <div class="col">
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('SL No.'); ?></th>
                                <th><?php echo app('translator')->get('Transaction ID'); ?></th>
                                <th><?php echo app('translator')->get('Amount'); ?></th>
                                <th><?php echo app('translator')->get('Remarks'); ?></th>
                                <th><?php echo app('translator')->get('Time'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(loopIndex($transactions) + $loop->index); ?></td>
                                    <td><?php echo app('translator')->get($transaction->trx_id); ?></td>
                                    <td>
                                        <span
                                        class="fontBold text-<?php echo e(($transaction->trx_type == "+") ? 'success': 'danger'); ?>"><?php echo e(($transaction->trx_type == "+") ? '+': '-'); ?><?php echo e(getAmount($transaction->amount, config('basic.fraction_number')). ' ' . trans(config('basic.currency'))); ?></span>
                                    </td>
                                    <td><?php echo app('translator')->get($transaction->remarks); ?></td>
                                    <td><?php echo e(dateTime($transaction->created_at, 'd M Y h:i A')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr class="text-center">
                                    <td colspan="100%"><?php echo e(__('No Data Found!')); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php echo e($transactions->appends($_GET)->links($theme.'partials.pagination')); ?>


                </div>
            </div>
        </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/bootstrap-datepicker.js')); ?>"></script>

    <script>
        'use strict'
        $(document).ready(function () {
            $( ".datepicker" ).datepicker({
                autoclose: true,
                clearBtn: true
            });

            $('.from_date').on('change', function (){
                $('.to_date').removeAttr('disabled');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/themes/original/user/transaction/index.blade.php ENDPATH**/ ?>