<?php $__env->startSection('title',trans('Purchased Raw Item Details')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a></li>
                            <li class="breadcrumb-item"><a
                                    href="<?php echo e(route('user.purchaseRawItemList')); ?>"><?php echo app('translator')->get('Purchase List'); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Details'); ?></li>
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
                                        <?php if($singlePurchaseItem->payment_status != 1): ?>
                                            <a href="javascript:void(0)"
                                               class="btn btn-sm btn-primary text-white me-2 invest-details-back paidDueAmountBtn"
                                               data-route="<?php echo e(route('user.purchaseRawItemDueAmountUpdate', $singlePurchaseItem->id)); ?>"
                                               data-property="<?php echo e($singlePurchaseItem); ?>">
                                                <span> <?php echo app('translator')->get('Pay Due Amount'); ?> </span>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('user.purchaseRawItemList')); ?>"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?> </span>
                                        </a>
                                    </div>

                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="fal fa-user me-2 text-info"></i> <?php echo app('translator')->get('Purchased From: '); ?>
                                                        </h6>
                                                        <h6 class="ms-2"><?php echo e(optional($singlePurchaseItem->supplier)->name); ?></h6>
                                                    </div>

                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Purchased Date: '); ?>
                                                        </h6>
                                                        <h6 class="ms-2"><?php echo e(dateTime(customDate($singlePurchaseItem->purchase_date))); ?></h6>
                                                    </div>

                                                    <div class="investmentDate d-flex justify-content-start">
                                                        <h6 class="font-weight-bold text-dark"> <?php if($singlePurchaseItem->payment_status == 1): ?>
                                                                <i class="fal fa-check-double me-2 text-success"></i>
                                                            <?php else: ?>
                                                                <i class="fal fa-money-check-alt text-success"></i>
                                                            <?php endif; ?>  <?php echo app('translator')->get('Payment Status'); ?>
                                                            : </h6>
                                                        <?php if($singlePurchaseItem->payment_status == 1): ?>
                                                            <h6 class="ms-2"><span
                                                                    class="badge bg-success"><?php echo app('translator')->get('Paid'); ?></span></h6>
                                                        <?php else: ?>
                                                            <h6 class="ms-2"><span
                                                                    class="badge bg-warning"><?php echo app('translator')->get('Due'); ?></span></h6>
                                                        <?php endif; ?>
                                                    </div>

                                                </div>

                                                <?php if(count($singlePurchaseItemDetails) > 0): ?>
                                                    <ul class="list-style-none p-0 stock_list_style">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col"><?php echo app('translator')->get('Item'); ?></th>
                                                                <th scope="col"><?php echo app('translator')->get('Quantity'); ?></th>
                                                                <th scope="col"><?php echo app('translator')->get('Cost Per Unit'); ?></th>
                                                                <th scope="col"><?php echo app('translator')->get('Total Unit Cost'); ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            <?php $__currentLoopData = $singlePurchaseItemDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $purchaseInDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td data-label="Quantity"><?php echo e(optional($purchaseInDetail->rawItem)->name); ?></td>
                                                                    <td data-label="Quantity"><?php echo e($purchaseInDetail->quantity); ?></td>
                                                                    <td data-label="Cost Per Unit"><?php echo e($purchaseInDetail->cost_per_unit); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                                    <td data-label="Total Unit Cost"><?php echo e($purchaseInDetail->total_unit_cost); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <tr>
                                                                <td colspan="3"
                                                                    class="text-right"><?php echo app('translator')->get('Total Price'); ?></td>
                                                                <td>
                                                                    = <?php echo e($totalItemCost); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </ul>
                                                <?php endif; ?>
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

    <!-- Modal -->
    <div class="procced-modal">
        <div class="modal fade" id="paidDueAmountModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog ">
                <form action="" method="post" class="paidDueAmountRoute">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo app('translator')->get('Make Payment'); ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="total-amount d-flex align-items-center justify-content-between">
                                <h5><?php echo app('translator')->get('Total Due Amount'); ?></h5>
                                <h6 class="total-due-amount"></h6>
                            </div>

                            <div class="enter-amount d-flex justify-content-between align-items-center">
                                <h6><?php echo app('translator')->get('Discount Amount'); ?></h6>
                                <div class="input-group d-flex ">
                                    <input type="text" name="discount_amount" value="0" min="0" max="100" class="form-control bg-white text-dark discount-amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                </div>
                            </div>

                            <div class="enter-amount d-flex justify-content-between align-items-center">
                                <h6><?php echo app('translator')->get('Paid Amount'); ?></h6>
                                <div class="input-group d-flex ">
                                    <input type="text" class="form-control paid-amount" value="0" min="0"
                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                           id="exampleFormControlInput1" name="paid_amount">
                                </div>

                            </div>

                            <div class="change-amount d-flex align-items-center justify-content-between">
                                <h4 class="m-2 due-or-change-text">Due Amount</h4>  <span
                                    class="due-or-change-amount"></span>
                                <input type="hidden" name="due_or_change_amount" class="due_or_change_amount_input"
                                       value="">
                            </div>
                            <div class="total-amount d-flex align-items-center justify-content-between">
                                <h5>Total Payable Amount</h5>
                                <h6 class="total-payable-amount"></h6>
                                <input type="hidden" name="total_payable_amount" class="total_payable_amount_input"
                                       value="">
                            </div>
                            <div class="file">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Payment
                                        Date</label>
                                    <div class="flatpickr">
                                        <div class="input-group">
                                            <input type="hidden" placeholder="Select Payment Date"
                                                   class="form-control payment_date flatpickr-input" name="payment_date"
                                                   value="" data-input="">
                                            <div class="input-group-append" readonly="">
                                                <div class="form-control payment-date-times">
                                                    <a class="input-button cursor-pointer" title="clear" data-clear="">
                                                        <i class="fas fa-times" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback d-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label"><?php echo app('translator')->get('Note'); ?>
                                        <span><sub>(optional)</sub></span></label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                              placeholder="Details note write here" rows="4" name="note"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>

    <?php if($errors->has('payment_date')): ?>
        <script>
            var myModal = new bootstrap.Modal(document.getElementById("paidDueAmountModal"), {});
            document.onreadystatechange = function () {
                myModal.show();
                payDueAmountPaymentModal();
            };

        </script>
    <?php endif; ?>

    <script>
        'use strict'

        $(".flatpickr").flatpickr({
            wrap: true,
            maxDate: "today",
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

        $(document).on('click', '.paidDueAmountBtn', function () {
            payDueAmountPaymentModal();
        });

        function payDueAmountPaymentModal(_this) {
            var paidDueAmountModal = new bootstrap.Modal(document.getElementById('paidDueAmountModal'));
            paidDueAmountModal.show();

            let dataRoute = $('.paidDueAmountBtn').data('route');
            $('.paidDueAmountRoute').attr('action', dataRoute)

            let dataProperty = $('.paidDueAmountBtn').data('property');
            $('.total-due-amount').text(`${dataProperty.due_amount} <?php echo e($basic->currency_symbol); ?>`);

            $('.due-or-change-text').text('Due Amount');
            $('.due-or-change-amount').text(`${dataProperty.due_amount} <?php echo e($basic->currency_symbol); ?>`)
            $('.total-payable-amount').text(`${dataProperty.due_amount} <?php echo e($basic->currency_symbol); ?>`)

            $('.due_or_change_amount_input').val(`${dataProperty.due_amount}`)
            $('.total_payable_amount_input').val(`${dataProperty.due_amount}`)
        }


        $(document).on('keyup', '.paid-amount', function () {
            makeDuePaymentCal();
        });

        function makeDuePaymentCal(_this){
            let totalAmount = parseFloat($('.total-due-amount').text().match(/[\d.]+/)[0]);
            var discountAmount = isNaN(parseFloat($('.discount-amount').val())) ? 0 : parseFloat($('.discount-amount').val());
            let customerPaidAmount = isNaN(parseFloat($('.paid-amount').val())) ? 0 : parseFloat($('.paid-amount').val());


            if(discountAmount > totalAmount){
                Notiflix.Notify.warning('Discount amount can not exceed the total due amount');
                $(this).val(totalAmount);
            }

            let newTotalAmount = totalAmount - discountAmount;

            let dueOrChangeAmount = newTotalAmount - customerPaidAmount;

            if (dueOrChangeAmount >= 0) {
                $('.due-or-change-text').text('Due Amount')
                $('.due-or-change-amount').text(`${dueOrChangeAmount.toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)
                $('.total-payable-amount').text(`${customerPaidAmount.toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${customerPaidAmount.toFixed(2)}`)

            } else {
                $('.due-or-change-text').text('Change Amount')
                $('.due-or-change-amount').text(`${Math.abs(dueOrChangeAmount).toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)
                $('.total-payable-amount').text(`${newTotalAmount.toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${newTotalAmount.toFixed(2)}`)
            }
        }


        $(document).on('keyup', '.discount-amount', function (){
            makeDuePaymentCal();
        });


    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/rawItems/purchaseRawItemDetails.blade.php ENDPATH**/ ?>