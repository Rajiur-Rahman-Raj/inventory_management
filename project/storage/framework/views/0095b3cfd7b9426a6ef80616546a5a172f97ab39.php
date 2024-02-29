<?php $__env->startSection('title',trans('Sales Invoice')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"> <?php echo app('translator')->get('Sales Invoice'); ?></h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.salesList')); ?>"><?php echo app('translator')->get('Sales List'); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Sales Invoice'); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="main row p-0">
            <div class="col-12">
                <div class="section-invoice section-1">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-box" id="salesInvoice">
                                    <div
                                        class="invoice-top d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="invoice-img">
                                            <img src="<?php echo e(asset('assets/global/img/invoice.png')); ?>" alt="">
                                            <h3><?php echo app('translator')->get('Invoice'); ?> - <span><?php echo e($singleSalesDetails->invoice_id); ?></span>
                                            </h3>
                                            <h4>Date - <span> <?php echo e(customDate($singleSalesDetails->latest_payment_date)); ?></span>
                                            </h4>
                                        </div>

                                        <div class="invoice-top-content">
                                            <h3><?php echo e(optional($singleSalesDetails->company)->name); ?></h3>
                                            <h5><?php echo e(optional($singleSalesDetails->company)->address); ?></h5>
                                            <?php if(optional($singleSalesDetails->company)->email): ?>
                                                <h5><?php echo e(optional($singleSalesDetails->company)->email); ?></h5>
                                            <?php endif; ?>
                                            <?php if(optional($singleSalesDetails->company)->phone): ?>
                                                <h5><?php echo e(optional($singleSalesDetails->company)->phone); ?></h5>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    <div class="invoice-date-box d-flex flex-wrap justify-content-between mt-5">
                                        <?php if($singleSalesDetails->customer_id): ?>
                                            <div class="invoice-number">
                                                <h3 class="font-weight-bold"><?php echo app('translator')->get('Bill To'); ?></h3>
                                                <h4><?php echo e(optional($singleSalesDetails->salesCenter)->name); ?></h4>
                                                <h5><?php echo e(optional($singleSalesDetails->salesCenter)->address); ?> <?php echo e(optional(optional($singleSalesDetails->salesCenter)->upazila)->name); ?>

                                                    , <?php echo e(optional(optional($singleSalesDetails->salesCenter)->district)->name); ?></h5>
                                                <?php if(optional(optional($singleSalesDetails->salesCenter)->user)->email): ?>
                                                    <h5><?php echo e(optional(optional($singleSalesDetails->salesCenter)->user)->email); ?></h5>
                                                <?php endif; ?>
                                                <?php if(optional(optional($singleSalesDetails->salesCenter)->user)->phone): ?>
                                                    <h5><?php echo e(optional(optional($singleSalesDetails->salesCenter)->user)->phone); ?></h5>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="invoice-number">
                                                <h3 class="font-weight-bold"><?php echo app('translator')->get('Bill To'); ?></h3>
                                                <h4><?php echo e(optional($singleSalesDetails->company)->name); ?></h4>
                                                <h5><?php echo e(optional($singleSalesDetails->company)->address); ?></h5>
                                                <?php if(optional($singleSalesDetails->company)->email): ?>
                                                    <h5><?php echo e(optional($singleSalesDetails->company)->email); ?></h5>
                                                <?php endif; ?>
                                                <?php if(optional($singleSalesDetails->company)->phone): ?>
                                                    <h5><?php echo e(optional($singleSalesDetails->company)->phone); ?></h5>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($singleSalesDetails->customer_id): ?>
                                            <div class="invoice-id">
                                                <h3 class="font-weight-bold"><?php echo app('translator')->get('Invoiced To'); ?></h3>
                                                <h4><?php echo e(optional($singleSalesDetails->customer)->name); ?></h4>
                                                <h5><?php echo e(optional($singleSalesDetails->customer)->address); ?> <?php echo e(optional(optional($singleSalesDetails->customer)->upazila)->name); ?>

                                                    , <?php echo e(optional(optional($singleSalesDetails->customer)->district)->name); ?></h5>
                                                <?php if(optional($singleSalesDetails->customer)->phone): ?>
                                                    <h5><?php echo e(optional($singleSalesDetails->customer)->phone); ?></h5>
                                                <?php endif; ?>
                                                <?php if(optional($singleSalesDetails->customer)->email): ?>
                                                    <h5><?php echo e(optional($singleSalesDetails->customer)->email); ?></h5>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="invoice-id">
                                                <h3 class="font-weight-bold"><?php echo app('translator')->get('Invoiced To'); ?></h3>
                                                <h4><?php echo e(optional($singleSalesDetails->salesCenter)->name); ?></h4>
                                                <h5><?php echo e(optional($singleSalesDetails->salesCenter)->address); ?> <?php echo e(optional(optional($singleSalesDetails->salesCenter)->upazila)->name); ?>

                                                    , <?php echo e(optional(optional($singleSalesDetails->salesCenter)->district)->name); ?></h5>
                                                <?php if(optional(optional($singleSalesDetails->salesCenter)->user)->email): ?>
                                                    <h5><?php echo e(optional(optional($singleSalesDetails->salesCenter)->user)->email); ?></h5>
                                                <?php endif; ?>
                                                <?php if(optional(optional($singleSalesDetails->salesCenter)->user)->phone): ?>
                                                    <h5><?php echo e(optional(optional($singleSalesDetails->salesCenter)->user)->phone); ?></h5>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="invoice-table">

                                        <table class="table table-hover">
                                            <thead>
                                            <th scope="col"><?php echo app('translator')->get('item'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('quantity'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('Price'); ?></th>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $singleSalesDetails->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($item['item_name']); ?></td>
                                                    <td><?php echo e($item['item_quantity']); ?></td>
                                                    <td><?php echo e($item['item_price']); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="note-box d-flex align-items-center justify-content-between">
                                        <div class="invoice-note">
                                            <h4><?php echo app('translator')->get('Subtotal'); ?>
                                                <span><?php echo e($singleSalesDetails->sub_total); ?> <?php echo e($basic->currency_symbol); ?></span>
                                            </h4>
                                            <h4><?php echo app('translator')->get('Discount'); ?>
                                                <span><?php echo e($singleSalesDetails->discount); ?> <?php echo e($basic->currency_symbol); ?></span>
                                            </h4>
                                            <h4><?php echo app('translator')->get('Payable'); ?>
                                                <span><?php echo e($singleSalesDetails->total_amount); ?> <?php echo e($basic->currency_symbol); ?></span>
                                            </h4>
                                            <?php if($singleSalesDetails->payment_status == 0): ?>
                                                <h4><?php echo app('translator')->get('Due Amount'); ?>
                                                    <span><?php echo e($singleSalesDetails->due_amount); ?> <?php echo e($basic->currency_symbol); ?></span>
                                                </h4>
                                            <?php endif; ?>
                                        </div>

                                        <div class="invoice-total">
                                            <h3><?php echo app('translator')->get('You Paid'); ?></h3>
                                            <?php if($singleSalesDetails->payment_status == 0): ?>
                                                <h1><?php echo e($singleSalesDetails->customer_paid_amount); ?> <?php echo e($basic->currency_symbol); ?></h1>
                                            <?php else: ?>
                                                <h1><?php echo e($singleSalesDetails->total_amount); ?> <?php echo e($basic->currency_symbol); ?></h1>
                                            <?php endif; ?>

                                        </div>
                                    </div>


                                </div>

                                <div class="invoice-btn clearfix text-end">
                                    <a class="float-right" href="javascript:void(0)" id="salesInvoicePrint"><i
                                            class="fas fa-print"></i> <?php echo app('translator')->get('Print'); ?> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'
        $(document).on('click', '#salesInvoicePrint', function () {
            let allContents = document.getElementById('body').innerHTML;
            let printContents = document.getElementById('salesInvoice').innerHTML;
            document.getElementById('body').innerHTML = printContents;
            window.print();
            document.getElementById('body').innerHTML = allContents;
        })

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/manageSales/salesInvoice.blade.php ENDPATH**/ ?>