<?php $__env->startSection('title',trans('Sales Details')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"><?php echo e(snake2Title(optional($singleSalesDetails->salesCenter)->name)); ?> <?php echo app('translator')->get('Sales Details'); ?></h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.salesList')); ?>"><?php echo app('translator')->get('Sales List'); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Sales Details'); ?></li>
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
                                        <?php if($singleSalesDetails->payment_status != 1): ?>
                                            <a href="javascript:void(0)"
                                               class="btn btn-sm btn-primary text-white me-2 invest-details-back paidDueAmountBtn" data-route="<?php echo e(route('user.salesOrderUpdate', $singleSalesDetails->id)); ?>" data-property="<?php echo e($singleSalesDetails); ?>">
                                                <span> <?php echo app('translator')->get('Paid Due Amount'); ?> </span>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('user.salesList')); ?>"
                                           class="btn btn-sm bgPrimary text-white invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?> </span>
                                        </a>
                                    </div>

                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <?php if($singleSalesDetails->customer): ?>
                                                        <div class="investmentDate d-flex justify-content-between">
                                                            <h6 class="font-weight-bold text-dark"><i
                                                                    class="fal fa-user me-2 text-primary"></i> <?php echo app('translator')->get('Sales To Customer'); ?>
                                                                : </h6>
                                                            <p><?php echo e(optional($singleSalesDetails->customer)->name); ?></p>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-success"></i> <?php echo app('translator')->get('Sales Date'); ?>
                                                            : </h6>
                                                        <p><?php echo e(dateTime(customDate($singleSalesDetails->created_at))); ?></p>
                                                    </div>
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="fa fa-bangladeshi-taka-sign me-2 text-warning">
                                                                ৳ </i> <?php echo app('translator')->get('Last Payment Date'); ?>
                                                            : </h6>
                                                        <p><?php echo e(dateTime(customDate($singleSalesDetails->payment_date))); ?></p>
                                                    </div>
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"> <?php if($singleSalesDetails->payment_status == 1): ?>
                                                                <i class="fal fa-check-double me-2 text-success"></i>
                                                            <?php else: ?>
                                                                <i class="fal fa-times me-2 text-danger"></i>
                                                            <?php endif; ?>  <?php echo app('translator')->get('Payment Status'); ?>
                                                            : </h6>
                                                        <?php if($singleSalesDetails->payment_status == 1): ?>
                                                            <p><span class="badge bg-success"><?php echo app('translator')->get('Paid'); ?></span></p>
                                                        <?php else: ?>
                                                            <p><span class="badge bg-warning"><?php echo app('translator')->get('Due'); ?></span></p>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>

                                                <ul class="list-style-none p-0 stock_list_style">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Item</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Cost</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $__currentLoopData = $singleSalesDetails->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td data-label="Item"><?php echo e(ucwords($item['item_name'])); ?></td>
                                                                <td data-label="Quantity"><?php echo e($item['item_quantity']); ?></td>
                                                                <td data-label="Cost"><?php echo e($item['item_price']); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <tr>
                                                            <td colspan="2"
                                                                class="text-right font-weight-bold"><?php echo app('translator')->get('Total Amount'); ?></td>
                                                            <td class="font-weight-bold">
                                                                = <?php echo e($singleSalesDetails->sub_total); ?> <?php echo e($basic->currency_symbol); ?></td>

                                                        </tr>

                                                        <tr>
                                                            <td colspan="2"
                                                                class="text-right font-weight-bold"><?php echo app('translator')->get('Discount'); ?></td>
                                                            <td class="font-weight-bold">
                                                                = <?php echo e($singleSalesDetails->discount); ?> <?php echo e($basic->currency_symbol); ?></td>

                                                        </tr>

                                                        <tr>
                                                            <td colspan="2"
                                                                class="text-right font-weight-bold"> <?php echo e($singleSalesDetails->payment_status == 1 ? 'Paid Amount' : 'Payable Amount'); ?></td>
                                                            <td class="font-weight-bold">
                                                                = <?php echo e($singleSalesDetails->total_amount); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                        </tr>

                                                        <?php if($singleSalesDetails->payment_status == 0): ?>
                                                            <tr>
                                                                <td colspan="2"
                                                                    class="text-right font-weight-bold"><?php echo app('translator')->get('Customer Paid'); ?></td>
                                                                <td class="font-weight-bold">
                                                                    = <?php echo e($singleSalesDetails->customer_paid_amount); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2"
                                                                    class="text-right font-weight-bold"><?php echo app('translator')->get('Due Amount'); ?></td>
                                                                <td class="font-weight-bold">
                                                                    = <?php echo e($singleSalesDetails->due_amount); ?> <?php echo e($basic->currency_symbol); ?>

                                                                </td>
                                                            </tr>

                                                        <?php endif; ?>

                                                        </tbody>
                                                    </table>

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


    <div class="procced-modal">
        <div class="modal fade" id="paidDueAmountModal" tabindex="-1"
             aria-labelledby="proccedOrderModal" aria-hidden="true">
            <div class="modal-dialog ">
                <form action="" method="post" class="paidDueAmountRoute">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5"
                                id="exampleModalLabel"><?php echo app('translator')->get('Make Payment Due Amount'); ?></h1>
                            <button type="button" class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div
                                class="total-amount d-flex align-items-center justify-content-between">
                                <h5><?php echo app('translator')->get('Total Due Amount'); ?></h5>
                                <h6 class="total-due-amount"></h6>
                            </div>
                            <div
                                class="enter-amount d-flex justify-content-between align-items-center">
                                <h6>Customer Paid Amount</h6>
                                <input type="text"
                                       class="form-control customer-paid-amount"
                                       value="0" min="0"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                       id="exampleFormControlInput1"
                                       name="customer_paid_amount">
                            </div>
                            <div
                                class="change-amount d-flex align-items-center justify-content-between">
                                <h4 class="m-2 due-or-change-text"></h4>  <span
                                    class="due-or-change-amount"></span>
                                <input type="hidden" name="due_or_change_amount"
                                       class="due_or_change_amount_input">
                            </div>
                            <div
                                class="total-amount d-flex align-items-center justify-content-between">
                                <h5><?php echo app('translator')->get('Total Payable Amount'); ?></h5>
                                <h6 class="total-payable-amount"></h6>
                                <input type="hidden" name="total_payable_amount"
                                       class="total_payable_amount_input">
                            </div>
                            <div class="file">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Payment
                                        Date</label>
                                    <input type="date" name="payment_date"
                                           placeholder="<?php echo app('translator')->get('payment date'); ?>"
                                           class="form-control payment_date"
                                           value="<?php echo e(old('payment_date',request()->payment_date)); ?>" required>
                                    <div class="invalid-feedback d-block">
                                        <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="formFile"
                                           class="form-label"><?php echo app('translator')->get('Payment Note'); ?>
                                        <span><sup>(<?php echo app('translator')->get('optional'); ?>)</sup></span></label>
                                    <textarea class="form-control"
                                              id="exampleFormControlTextarea1"
                                              placeholder="Write payment note"
                                              rows="4"
                                              name="payment_note"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">cancel
                            </button>
                            <button type="submit"
                                    class="btn btn-primary"><?php echo app('translator')->get('Confirm'); ?>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        'use strict'
        $(document).on('click', '.paidDueAmountBtn', function () {
            var paidDueAmountModal = new bootstrap.Modal(document.getElementById('paidDueAmountModal'))
            paidDueAmountModal.show();

            let dataRoute = $(this).data('route');
            $('.paidDueAmountRoute').attr('action', dataRoute)

            let dataProperty = $(this).data('property');
            $('.total-due-amount').text(`${dataProperty.due_amount} <?php echo e($basic->currency_symbol); ?>`);

            $('.due-or-change-text').text('Due Amount');
            $('.due-or-change-amount').text(`${dataProperty.due_amount} <?php echo e($basic->currency_symbol); ?>`)
            $('.total-payable-amount').text(`${dataProperty.due_amount} <?php echo e($basic->currency_symbol); ?>`)

            $('.due_or_change_amount_input').val(`${dataProperty.due_amount}`)
            $('.total_payable_amount_input').val(`${dataProperty.due_amount}`)

        });


        $(document).on('keyup', '.customer-paid-amount', function () {
            var totalAmount = parseFloat($('.total-due-amount').text().match(/[\d.]+/)[0]);
            let customerPaidAmount = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());

            let dueOrChangeAmount = totalAmount - customerPaidAmount;

            if (dueOrChangeAmount >= 0) {
                $('.due-or-change-text').text('Due Amount')
                $('.due-or-change-amount').text(`${dueOrChangeAmount.toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)
                $('.total-payable-amount').text(`${customerPaidAmount.toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${customerPaidAmount.toFixed(2)}`)

            } else {
                $('.due-or-change-text').text('Change Amount')
                $('.due-or-change-amount').text(`${dueOrChangeAmount.toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)
                $('.total-payable-amount').text(`${totalAmount.toFixed(2)} <?php echo e($basic->currency_symbol); ?>`)

                $('.due_or_change_amount_input').val(`${dueOrChangeAmount.toFixed(2)}`)
                $('.total_payable_amount_input').val(`${totalAmount.toFixed(2)}`)
            }
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/manageSales/salesDetails.blade.php ENDPATH**/ ?>