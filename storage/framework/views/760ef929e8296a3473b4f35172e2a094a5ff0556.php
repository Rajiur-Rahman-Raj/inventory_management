<?php $__env->startSection('title', trans('Investment History')); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap-datepicker.css')); ?>" />
    <?php $__env->stopPush(); ?>
    <!-- Invest history -->
    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Investment History'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Invest History'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar mt-3 me-2 ms-2 p-0">
                <form action="" method="get" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-2">
                            <label for=""><?php echo app('translator')->get('Property'); ?></label>
                            <input
                                type="text"
                                name="property"
                                value="<?php echo e(@request()->property); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Search property'); ?>"
                            />
                        </div>

                        <div class="input-box col-lg-2">
                            <label for=""><?php echo app('translator')->get('Invest Status'); ?></label>
                            <select class="form-select" name="invest_status" aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All Invest'); ?></option>
                                <option value="1" <?php if(@request()->invest_status == '1'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Complete'); ?></option>
                                <option value="0" <?php if(@request()->invest_status == '0'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Due'); ?></option>
                            </select>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for=""><?php echo app('translator')->get('Return Status'); ?></label>
                            <select class="form-select" name="return_status" aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All'); ?></option>
                                <option value="0" <?php if(@request()->return_status == '0'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Running'); ?></option>
                                <option value="1" <?php if(@request()->return_status == '1'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Completed'); ?></option>
                            </select>
                        </div>

                        <div class="input-box col-lg-2">
                            <label for="from_date"><?php echo app('translator')->get('From Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date" value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>" autocomplete="off" readonly/>
                        </div>
                        <div class="input-box col-lg-2">
                            <label for="to_date"><?php echo app('translator')->get('To Date'); ?></label>
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date" value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>" autocomplete="off" readonly disabled="true"/>
                        </div>
                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i><?php echo app('translator')->get('Search'); ?></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-parent table-responsive me-2 ms-2 mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Property'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Investment Amount'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Profit'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Upcoming Payment'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(loopIndex($investments) + $key); ?></td>

                            <td class="company-logo" data-label="<?php echo app('translator')->get('Property'); ?>">
                                <div>
                                    <a href="<?php echo e(route('propertyDetails',[@slug(optional($invest->property->details)->property_title), optional($invest->property)->id])); ?>" target="_blank">
                                        <img src="<?php echo e(getFile(config('location.propertyThumbnail.path').optional($invest->property)->thumbnail)); ?>">
                                    </a>
                                </div>
                                <div>
                                    <a href="<?php echo e(route('propertyDetails',[@slug(optional($invest->property->details)->property_title), optional($invest->property)->id])); ?>" target="_blank"><?php echo app('translator')->get(\Illuminate\Support\Str::limit(optional($invest->property->details)->property_title, 30)); ?></a> <br>
                                    <span class="text-muted font-14"><span class="text-danger"><?php echo app('translator')->get('Invested: '); ?></span><span><?php echo e(config('basic.currency_symbol')); ?></span><?php echo e((int)$invest->amount); ?></span>
                                </div>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Invest Amount'); ?>"><?php echo e(optional($invest->property)->investmentAmount); ?></td>

                            <td data-label="<?php echo app('translator')->get('Profit'); ?>">
                                <?php if($invest->invest_status == 1): ?>
                                    <?php echo e($invest->profit_type == 0 ? config('basic.currency_symbol').$invest->profit : config('basic.currency_symbol').$invest->net_profit); ?>

                                <?php else: ?>
                                    <span class="badge bg-danger"><?php echo app('translator')->get('N/A'); ?></span>
                                <?php endif; ?>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Upcoming Payment'); ?>">
                                <?php if($invest->invest_status == 0): ?>
                                    <span class="badge bg-warning"><?php echo app('translator')->get('After Installments complete'); ?></span>
                                <?php elseif($invest->invest_status == 1 && $invest->return_date == null && $invest->status == 1): ?>
                                    <span class="badge bg-success"><?php echo app('translator')->get('All completed'); ?></span>
                                <?php else: ?>
                                    <?php echo e(customDate($invest->return_date)); ?>

                                <?php endif; ?>
                            </td>

                            <td data-label="Action">
                                <div class="sidebar-dropdown-items">
                                    <button
                                        type="button"
                                        class="dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i class="fal fa-cog"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="<?php echo e(route('user.invest-history-details', $invest->id)); ?>" class="dropdown-item"> <i class="fal fa-eye"></i> <?php echo app('translator')->get('Details'); ?> </a>
                                        </li>
                                        <?php if($invest->invest_status == 0): ?>
                                            <li>
                                                <a class="dropdown-item btn duePayment"
                                                   data-route="<?php echo e(route('user.completeDuePayment', $invest->id)); ?>"
                                                   data-property="<?php echo e(optional($invest->property->details)->property_title); ?>"
                                                   data-fixedamount="<?php echo e(optional($invest->property)->fixed_amount); ?>"
                                                   data-previouspay="<?php echo e($invest->amount); ?>"
                                                   data-investtype="<?php echo e(optional($invest->property)->is_invest_type); ?>"
                                                   data-isinstallment="<?php echo e($invest->is_installment); ?>"
                                                   data-totalinstallments="<?php echo e($invest->total_installments); ?>"
                                                   data-dueinstallments="<?php echo e($invest->due_installments); ?>"
                                                   data-installmentamount="<?php echo e(optional($invest->property)->installment_amount); ?>"
                                                   data-installmentduration="<?php echo e(optional($invest->property)->installment_duration); ?>"
                                                   data-installmentlastdate="<?php echo e(customDate($invest->next_installment_date_end)); ?>"
                                                   data-getinstallmentdate="<?php echo e($invest->getInstallmentDate()); ?>"
                                                   data-installmentlatefee="<?php echo e(optional($invest->property)->installment_late_fee); ?>"
                                                   data-installmentdurationtype="<?php echo e(optional($invest->property)->installment_duration_type); ?>"> <i class="far fa-sack-dollar"></i> <?php echo app('translator')->get('Due Make Payment'); ?> </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if($invest->invest_status == 1 && $invest->status == 0): ?>
                                            <?php if($invest->propertyShare): ?>
                                                <li>
                                                    <a class="dropdown-item btn updateOffer"
                                                       data-route="<?php echo e(route('user.propertyShareUpdate', optional($invest->propertyShare)->id)); ?>"
                                                       data-amount="<?php echo e(optional($invest->propertyShare)->amount); ?>"
                                                       data-property="<?php echo e(optional($invest->property->details)->property_title); ?>">
                                                        <i class="far fa-sack-dollar"></i> <?php echo app('translator')->get('Update Share'); ?>
                                                    </a>
                                                </li>
                                            <?php else: ?>
                                                <?php if(optional($invest->property)->is_investor == 1 && config('basic.is_share_investment') == 1): ?>
                                                    <li>
                                                        <a class="dropdown-item btn sendOffer"
                                                           data-route="<?php echo e(route('user.propertyShareStore', $invest->id)); ?>"
                                                           data-property="<?php echo e(optional(optional($invest->property)->details)->property_title); ?>">
                                                            <i class="far fa-sack-dollar"></i> <?php echo app('translator')->get('Sell Share'); ?>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                                <td colspan="100%" class="text-danger text-center"><?php echo e(trans('No Data Found!')); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php $__env->startPush('loadModal'); ?>
        <!-- Modal -->
        
        <div class="modal fade" id="duePaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <form action="" method="post" id="invest-form" class="login-form due_payment_modal">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Due Make Payment'); ?></h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="card">
                                <div class="m-3 mb-0 payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="estimation-box">
                                        <div class="details_list">
                                            <ul>
                                                <li class="d-flex justify-content-between"><span><?php echo app('translator')->get('Fixed Invest'); ?></span>
                                                    <span class="fixed_invest"></span></li>
                                                <li class="d-flex justify-content-between totalInstallment">
                                                    <span><?php echo app('translator')->get('Total Installment'); ?></span><span
                                                        class="total_installments"></span></li>

                                                <li class="d-flex justify-content-between dueInstallment">
                                                    <span><?php echo app('translator')->get('Due Installment'); ?></span><span
                                                        class="due_installments"></span></li>

                                                <li class="d-flex justify-content-between dueInstallment">
                                                    <span><?php echo app('translator')->get('Installment Amount'); ?></span><span
                                                        class="installment_amount"></span></li>

                                                <li class="d-flex justify-content-between installmentDuration">
                                                    <span><?php echo app('translator')->get('Installment Duration'); ?></span> <span
                                                        class="installment_duration"></span></li>

                                                <li class="d-flex justify-content-between installmentLastDate">
                                                    <span><?php echo app('translator')->get('Installment Last Date'); ?></span> <span
                                                        class="installment_last_date"></span></li>

                                                <li class="d-flex justify-content-between installmentLateFee">
                                                    <span><?php echo app('translator')->get('Installment Late Fee'); ?></span> <span
                                                        class="installment_late_fee"></span></li>

                                                <li class="d-flex justify-content-between previousTotalPay">
                                                    <span><?php echo app('translator')->get('Previous Total Pay'); ?></span> <span
                                                        class="previous_total_pay"></span></li>

                                                <li class="d-flex justify-content-between previousTotalPay">
                                                    <span><?php echo app('translator')->get('Due Amount'); ?></span> <span
                                                        class="total_due_amount"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Select Wallet'); ?></label>
                                            <select class="form-control form-select" id="exampleFormControlSelect1"
                                                    name="balance_type">
                                                <?php if(auth()->guard()->check()): ?>
                                                    <option
                                                        value="balance"><?php echo app('translator')->get('Deposit Balance - '.$basic->currency_symbol.getAmount(auth()->user()->balance)); ?></option>
                                                    <option
                                                        value="interest_balance"><?php echo app('translator')->get('Interest Balance -'.$basic->currency_symbol.getAmount(auth()->user()->interest_balance)); ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="input-box col-12 payInstallment d-none">
                                            <div class="form-check">
                                                <input type="hidden" value="" class="set_installment_amount">
                                                <input type="hidden" value="" class="set_totalDue_amount">
                                                <input type="hidden" value="" class="set_get_installment_date">
                                                <input type="hidden" value="" class="set_total_due_amount">
                                                <input type="hidden" value="" class="set_installment_late_fee">
                                                <input class="form-check-input" type="checkbox" value="0"
                                                       name="pay_installment" id="pay_installment"/>
                                                <label class="form-check-label"
                                                       for="pay_installment"><?php echo app('translator')->get('Pay Installment'); ?></label>
                                            </div>
                                        </div>

                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Amount'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="invest-amount form-control" name="amount" id="amount"
                                                    value="<?php echo e(old('amount')); ?>"
                                                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                    autocomplete="off"
                                                    placeholder="<?php echo app('translator')->get('Enter amount'); ?>" required>
                                                <button class="show-currency"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn-custom investModalSubmitBtn"><?php echo app('translator')->get('Submit'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="modal fade" id="sendOfferModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <form action="" method="post" id="invest-form" class="login-form send_offer_modal">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Set Share Amount'); ?></h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="card">
                                <div class="m-3 mb-0 payment-method-details property-title font-weight-bold">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Share Amount'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="invest-amount form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="amount" id="amount"
                                                    value="<?php echo e(old('amount')); ?>"
                                                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                    autocomplete="off"
                                                    placeholder="<?php echo app('translator')->get('Enter amount'); ?>" required>
                                                <button class="show-currency" type="button"></button>
                                            </div>
                                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn-custom investModalSubmitBtn"><?php echo app('translator')->get('Share'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="modal fade" id="updateOfferModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <form action="" method="post" id="invest-form" class="login-form update_offer_modal">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Update Share Amount'); ?></h5>
                            <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                    aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header payment-method-details property-title primary_color">
                                </div>

                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Share Amount'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text" class="invest-amount form-control amount <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="amount" id="amount"
                                                    value="<?php echo e(old('amount')); ?>"
                                                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                    autocomplete="off"
                                                    placeholder="<?php echo app('translator')->get('Enter amount'); ?>" required>
                                                <button class="show-currency" type="button"></button>
                                            </div>
                                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn-custom investModalSubmitBtn"><?php echo app('translator')->get('Share'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/global/js/bootstrap-datepicker.js')); ?>"></script>
    <script>
        'use strict'
        $(document).ready(function (){
            $( ".datepicker" ).datepicker({
                autoclose: true,
                clearBtn: true
            });

            $('.from_date').on('change', function (){
                $('.to_date').removeAttr('disabled');
            });

            $(document).on('click', '.duePayment', function () {
                var propertyInvestModal = new bootstrap.Modal(document.getElementById('duePaymentModal'))
                propertyInvestModal.show();

                let symbol = "<?php echo e(trans($basic->currency_symbol)); ?>";
                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');
                let dataFixedAmount = $(this).data('fixedamount');
                let dataPreviousPay = $(this).data('previouspay');
                let isInstallment = $(this).data('isinstallment');
                let totalInstallments = $(this).data('totalinstallments');
                let totalDueInstallments = $(this).data('dueinstallments');
                let installmentAmount = $(this).data('installmentamount');
                let installmentDuration = $(this).data('installmentduration') + ' ' + $(this).data('installmentdurationtype');
                let installmentLastDate = $(this).data('installmentlastdate');
                let getInstallmentDate = $(this).data('getinstallmentdate');
                let installmentLateFee = $(this).data('installmentlatefee');
                $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");

                $('.due_payment_modal').attr('action', dataRoute);
                $('.property-title').text( `Property: ${dataProperty}`);
                $('.fixed_invest').text(`${symbol}${dataFixedAmount}`);
                $('.total_installments').text(totalInstallments);
                $('.due_installments').text(totalDueInstallments);
                $('.installment_duration').text(installmentDuration);
                $('.installment_last_date').text(installmentLastDate);
                $('.installment_last_date').text(installmentLastDate);
                $('.installment_late_fee').text(`${symbol}${installmentLateFee}`);
                $('.previous_total_pay').text(`${symbol}${parseInt(dataPreviousPay)}`);
                let totalDueAmount = parseInt(dataFixedAmount) - parseInt(dataPreviousPay);
                $('.total_due_amount').text(`${symbol}${totalDueAmount}`);
                $('.installment_amount').text(`${symbol}${installmentAmount}`);



                if (isInstallment == 1 && totalDueInstallments > 1){
                    $('.set_installment_amount').val(installmentAmount);
                    $('.set_totalDue_amount').val(totalDueAmount);
                    $('.set_get_installment_date').val(getInstallmentDate);
                    $('.set_total_due_amount').val(totalDueAmount);
                    $('.set_installment_late_fee').val(installmentLateFee);
                    $('.payInstallment').removeClass('d-none');
                }

                if (getInstallmentDate == 0){
                    let dueAmountWithLateFee = parseInt(totalDueAmount) + parseInt(installmentLateFee);
                    $('.invest-amount').val(dueAmountWithLateFee);
                    $('#amount').attr('readonly', true);
                }else{
                    $('.invest-amount').val(totalDueAmount);
                    $('#amount').attr('readonly', true);
                }
            });


            $(document).on('click', '#pay_installment', function () {
                let getInstallmentDate = $('.set_get_installment_date').val();
                let installmentAmount = $('.set_installment_amount').val();
                let installmentLateFee = $('.set_installment_late_fee').val();
                let totalDueAmount = $('.set_total_due_amount').val();

                if ($(this).prop("checked") == true) {
                    $(this).val(1);
                    if (getInstallmentDate == 0){
                        let dueAmountWithLateFee = parseInt(installmentAmount) + parseInt(installmentLateFee);
                        $('.invest-amount').val(dueAmountWithLateFee);
                        $('#amount').attr('readonly', true);
                    }else{
                        $('.invest-amount').val(installmentAmount);
                        $('#amount').attr('readonly', true);
                    }

                } else {
                    $(this).val(0);
                    if (getInstallmentDate == 0){
                        let dueAmountWithLateFee = parseInt(totalDueAmount) + parseInt(installmentLateFee);
                        $('.invest-amount').val(dueAmountWithLateFee);
                        $('#amount').attr('readonly', true);
                    }else{
                        $('.invest-amount').val(totalDueAmount);
                        $('#amount').attr('readonly', true);
                    }
                }
            });

            $(document).on('click', '.close_invest_modal', function () {
                if ($('#pay_installment').prop("checked") == true) {
                    $("#pay_installment").prop("checked", false);
                }
            });

            $(document).on('click', '.sendOffer', function () {
                var propertysendOfferModal = new bootstrap.Modal(document.getElementById('sendOfferModal'))
                propertysendOfferModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');

                $('.send_offer_modal').attr('action', dataRoute);
                $('.property-title').text(`Property: ${dataProperty}`);
                $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");

            });

            $(document).on('click', '.updateOffer', function () {
                var propertyupdateOfferModal = new bootstrap.Modal(document.getElementById('updateOfferModal'))
                propertyupdateOfferModal.show();

                let dataRoute = $(this).data('route');
                let dataProperty = $(this).data('property');
                let amount = $(this).data('amount');
                $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");

                $('.update_offer_modal').attr('action', dataRoute);
                $('.property-title').text(`Property: ${dataProperty}`);
                $('.amount').val(amount);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/transaction/investLog.blade.php ENDPATH**/ ?>