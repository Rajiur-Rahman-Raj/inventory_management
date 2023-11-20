<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Add Fund'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- add fund -->
<section class="payment-gateway mt-4">
    <div class="container-fluid">
       <div class="row ms-2 mt-4 mb-2">
           <div class="col">
               <div class="header-text-full">
                   <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Add Fund'); ?></h3>
                   <nav aria-label="breadcrumb">
                       <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                           </li>
                           <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Add Fund'); ?></li>
                       </ol>
                   </nav>
               </div>
           </div>
       </div>

       <div class="row mt-4 ms-2 me-2">
            <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                    <div class="gateway-box">
                        <img
                            class="img-fluid gateway"
                            src="<?php echo e(getFile(config('location.gateway.path').$gateway->image)); ?>"
                            alt="<?php echo e($gateway->name); ?>"
                        >
                        <button type="button"
                            data-id="<?php echo e($gateway->id); ?>"
                            data-name="<?php echo e($gateway->name); ?>"
                            data-currency="<?php echo e($gateway->currency); ?>"
                            data-gateway="<?php echo e($gateway->code); ?>"
                            data-min_amount="<?php echo e(getAmount($gateway->min_amount, $basic->fraction_number)); ?>"
                            data-max_amount="<?php echo e(getAmount($gateway->max_amount,$basic->fraction_number)); ?>"
                            data-percent_charge="<?php echo e(getAmount($gateway->percentage_charge,$basic->fraction_number)); ?>"
                            data-fix_charge="<?php echo e(getAmount($gateway->fixed_charge, $basic->fraction_number)); ?>"
                            class="gold-btn addFund addFundCustomButton"
                            data-bs-toggle="modal" data-bs-target="#addFundModal"><?php echo app('translator')->get('Pay Now'); ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
    </div>
</section>

    <?php $__env->startPush('loadModal'); ?>
        <!-- Modal -->
        <div class="modal fade" id="addFundModal" tabindex="-1" aria-labelledby="planModalLabel" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title method-name" id="planModalLabel"></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="payment-form">
                            <?php if(0 == $totalPayment): ?>
                                <p class="depositLimit lebelFont"></p>
                                <p class="depositCharge lebelFont"></p>
                            <?php endif; ?>

                            <input type="hidden" class="gateway" name="gateway" value="">

                            <form>
                                <div class="form-group mb-30 mt-3">
                                    <div class="box">
                                        <h5 class="text-dark"><?php echo app('translator')->get('Amount'); ?></h5>

                                        <div class="input-group input-box">
                                            <input
                                                type="text" class="amount form-control" name="amount"
                                                <?php if($totalPayment != null): ?> value="<?php echo e($totalPayment); ?>" readonly <?php endif; ?>
                                            />
                                            <button class="show-currency btn-custom"></button>
                                        </div>
                                    </div>
                                    <pre class="text-danger errors"></pre>
                                </div>
                            </form>
                        </div>

                        <div class="payment-info text-center">
                            <img id="loading" src="<?php echo e(asset('assets/admin/images/loading.gif')); ?>" alt="<?php echo app('translator')->get('loader'); ?>" class="w-15"/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-custom checkCalc"><?php echo app('translator')->get('Next'); ?></button>
                    </div>

                </div>
            </div>
        </div>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>

    <script>
        $('#loading').hide();
        "use strict";
        var id, minAmount, maxAmount, baseSymbol, fixCharge, percentCharge, currency, amount, gateway;
        $('.addFund').on('click', function () {
            id = $(this).data('id');
            gateway = $(this).data('gateway');
            minAmount = $(this).data('min_amount');
            maxAmount = $(this).data('max_amount');
            baseSymbol = "<?php echo e(config('basic.currency_symbol')); ?>";
            fixCharge = $(this).data('fix_charge');
            percentCharge = $(this).data('percent_charge');
            currency = $(this).data('currency');
            $('.depositLimit').text(`<?php echo app('translator')->get('Transaction Limit:'); ?> ${minAmount} - ${maxAmount}  ${baseSymbol}`);

            var depositCharge = `<?php echo app('translator')->get('Charge:'); ?> ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' + percentCharge + ' % ' : ''}`;
            $('.depositCharge').text(depositCharge);

            $('.method-name').text(`<?php echo app('translator')->get('Payment By'); ?> ${$(this).data('name')} - ${currency}`);
            $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");
            $('.gateway').val(currency);

        });

        $(".checkCalc").on('click', function () {
            $('.payment-form').addClass('d-none');

            $('#loading').show();
            $('.modal-backdrop.fade').addClass('show');
            amount = $('.amount').val();
            $.ajax({
                url: "<?php echo e(route('user.addFund.request')); ?>",
                type: 'POST',
                data: {
                    amount,
                    gateway
                },
                success(data) {

                    $('.payment-form').addClass('d-none');
                    $('.checkCalc').closest('.modal-footer').addClass('d-none');

                    var htmlData = `
                     <ul class="list-group text-center">
                        <li class="list-group-item bg-transparent list-text customborder">
                            <img src="${data.gateway_image}"
                                style="max-width:100px; max-height:100px; margin:0 auto;"/>
                        </li>
                        <li class="list-group-item bg-transparent list-text customborder">
                            <?php echo app('translator')->get('Amount'); ?>:
                            <strong>${data.amount} </strong>
                        </li>
                        <li class="list-group-item bg-transparent list-text customborder"><?php echo app('translator')->get('Charge'); ?>:
                                <strong>${data.charge}</strong>
                        </li>
                        <li class="list-group-item bg-transparent list-text customborder">
                            <?php echo app('translator')->get('Payable'); ?>: <strong> ${data.payable}</strong>
                        </li>
                        <li class="list-group-item bg-transparent list-text customborder">
                            <?php echo app('translator')->get('Conversion Rate'); ?>: <strong>${data.conversion_rate}</strong>
                        </li>
                        <li class="list-group-item bg-transparent list-text customborder">
                            <strong>${data.in}</strong>
                        </li>

                        ${(data.isCrypto == true) ? `
                        <li class="list-group-item bg-transparent list-text customborder">
                            ${data.conversion_with}
                        </li>
                        ` : ``}

                        <li class="list-group-item bg-transparent">
                        <a href="${data.payment_url}" class="btn btn-custom addFund text-white"><?php echo app('translator')->get('Pay Now'); ?></a>
                        </li>
                        </ul>`;

                    $('.payment-info').html(htmlData)
                },
                complete: function () {
                    $('#loading').hide();
                },
                error(err) {
                    var errors = err.responseJSON;
                    for (var obj in errors) {
                        $('.errors').text(`${errors[obj]}`)
                    }

                    $('.payment-form').removeClass('d-none');
                }
            });
        });


        $('.close').on('click', function (e) {
            $('#loading').hide();
            $('.payment-form').removeClass('d-none');
            $('.checkCalc').closest('.modal-footer').removeClass('d-none');
            $('.payment-info').html(``)
            $('.amount').val(``);
            $("#addFundModal").modal("hide");
            $('.errors').text(``)
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/addFund.blade.php ENDPATH**/ ?>