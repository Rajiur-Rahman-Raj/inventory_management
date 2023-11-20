<?php if(count($sharedProperties) > 0): ?>
    <div class="col-lg-12">
        <div class="row g-4 mb-5">
            <?php $__currentLoopData = $sharedProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shareProperty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-4">
                    <div class="property-box">
                        <div class="img-box">
                            <img class="img-fluid"
                                 src="<?php echo e(getFile(config('location.propertyThumbnail.path').optional($shareProperty->property)->thumbnail)); ?>"
                                 alt="<?php echo app('translator')->get('property thumbnail'); ?>"/>
                            <div class="content">
                                <div class="tag"><?php echo app('translator')->get('Buy'); ?></div>
                                <h4 class="price"><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)$shareProperty->amount); ?></h4>
                            </div>
                        </div>

                        <div class="text-box">
                            <div class="review-header d-flex justify-content-between">
                                <div class="review">
                                <span>
                                    <?php
                                        $isCheck = 0;
                                        $j = 0;
                                    ?>

                                    <?php if(optional($shareProperty->property)->avgRating() != intval(optional($shareProperty->property)->avgRating())): ?>
                                        <?php
                                            $isCheck = 1;
                                        ?>
                                    <?php endif; ?>
                                    <?php for($i = optional($shareProperty->property)->avgRating(); $i > $isCheck; $i--): ?>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endfor; ?>
                                    <?php if(optional($shareProperty->property)->avgRating() != intval(optional($shareProperty->property)->avgRating())): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endif; ?>

                                    <?php if(optional($shareProperty->property)->avgRating() == 0 || optional($shareProperty->property)->avgRating() != null): ?>
                                        <?php for($j; $j < 5; $j++): ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </span>

                                    <span>(<?php echo e(count($shareProperty->property->getReviews) <= 1 ? (count($shareProperty->property->getReviews). trans(' review')) : (count($shareProperty->property->getReviews). trans(' reviews'))); ?>)</span>
                                </div>
                                <div class="owner">
                                    <?php echo app('translator')->get('Owner: '); ?> <?php echo app('translator')->get(optional($shareProperty->user)->fullname); ?>
                                </div>
                            </div>

                            <a class="title"
                               href="<?php echo e(route('propertyDetails',[@slug(optional($shareProperty->property->details)->property_title), optional($shareProperty->property)->id])); ?>"><?php echo e(\Illuminate\Support\Str::limit(optional($shareProperty->property->details)->property_title, 30)); ?></a>
                            <p class="address">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo app('translator')->get(optional($shareProperty->property->getAddress->details)->title); ?>
                            </p>

                            <div class="aminities">
                                <?php $__currentLoopData = optional($shareProperty->property)->limitamenity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><i class="<?php echo e($amenity->icon); ?>"></i><?php echo e(optional($amenity->details)->title); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>


                            <div class="invest-btns d-flex justify-content-between">
                                <div class="sidebar-dropdown-items">
                                    <button
                                        type="button"
                                        class="dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fal fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <?php if($shareProperty->propertyOffer): ?>
                                            <li>
                                                <a class="dropdown-item btn disabled">
                                                    <i class="fal fa-check-circle"></i> <?php echo app('translator')->get('Already Offered'); ?>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a class="dropdown-item btn makeOffer <?php echo e(optional($shareProperty->user)->id == Auth::id() ? 'disabled' : ''); ?>"
                                                   data-route="<?php echo e(route('user.propertyMakeOfferStore', $shareProperty->id)); ?>"
                                                   data-propertyowner="<?php echo e(optional($shareProperty->user)->fullname); ?>"
                                                   data-property="<?php echo e(optional(optional($shareProperty->property)->details)->property_title); ?>">
                                                    <i class="fal fa-paper-plane"></i> <?php echo app('translator')->get('Make Offer'); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if(($shareProperty->propertyOffer && optional($shareProperty->propertyOffer)->offerlock) && (optional(optional($shareProperty->propertyOffer)->offerlock)->status == 0) || $shareProperty->forAllLock($shareProperty->id)): ?>
                                                <li>
                                                    <a class="dropdown-item btn disabled">
                                                        <i class="fal fa-lock"></i> <?php echo app('translator')->get('Share Locked'); ?>
                                                    </a>
                                                </li>

                                        <?php else: ?>
                                                <li>
                                                    <a class="dropdown-item btn buyShare directBuyShare <?php echo e(optional($shareProperty->user)->id == Auth::id() ? 'disabled' : ''); ?>"
                                                       data-route="<?php echo e(route('user.directBuyShare', $shareProperty->id)); ?>"
                                                       data-payableamount="<?php echo e($shareProperty->amount); ?>"
                                                       data-propertyowner="<?php echo e(optional($shareProperty->user)->fullname); ?>"
                                                       data-property="<?php echo e(optional(optional($shareProperty->property)->details)->property_title); ?>">
                                                        <i class="far fa-sack-dollar"></i> <?php echo app('translator')->get('Direct Buy Share'); ?>
                                                    </a>
                                                </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>



                                <a href="<?php echo e(route('investorProfile', [@slug(optional($shareProperty->user)->username), optional($shareProperty->user)->id])); ?>"
                                   target="_blank">
                                    <?php echo app('translator')->get('Contact Owner'); ?>
                                </a>

                            </div>


                            <div class="plan d-flex justify-content-between">
                                <div>
                                    <?php if(optional($shareProperty->property)->profit_type == 1): ?>
                                        <h5><?php echo e((int)optional($shareProperty->property)->profit); ?>% (<?php echo app('translator')->get('Fixed'); ?>)</h5>
                                    <?php else: ?>
                                        <h5><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)optional($shareProperty->property)->profit); ?>

                                            (<?php echo app('translator')->get('Fixed'); ?>)
                                        </h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Profit Range'); ?></span>
                                </div>
                                <div>
                                    <?php if(optional($shareProperty->property)->is_return_type == 1): ?>
                                        <h5><?php echo app('translator')->get('Lifetime'); ?></h5>
                                    <?php else: ?>
                                        <h5><?php echo e(optional($shareProperty->property->managetime)->time); ?> <?php echo app('translator')->get(optional($shareProperty->property->managetime)->time_type); ?></h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Return Interval'); ?></span>
                                </div>
                                <div>
                                    <h5><?php echo e(optional($shareProperty->property)->is_capital_back == 1 ? 'Yes' : 'No'); ?></h5>
                                    <span><?php echo app('translator')->get('Capital back'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php echo e($sharedProperties->appends($_GET)->links()); ?>

            </ul>
        </nav>
    </div>
<?php else: ?>
    <div class="custom-not-found mt-5">
        <img src="<?php echo e(asset($themeTrue.'img/no_data_found.png')); ?>" alt="<?php echo app('translator')->get('not found'); ?>" class="img-fluid">
    </div>
<?php endif; ?>

<?php $__env->startPush('loadModal'); ?>
    
    <div class="modal fade" id="directBuyShareModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <form action="" method="post" id="invest-form"
                  class="login-form direct_share_payment_form">
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Buy Share'); ?></h5>
                        <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="m-3 mb-0 payment-method-details property_title font-weight-bold">
                            </div>

                            <div class="card-body">
                                <div class="row g-3 investModalPaymentForm">
                                    <div class="input-box col-12">
                                        <label for=""><?php echo app('translator')->get('Property Owner'); ?></label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control property_owner"
                                                name="property_owner" id="property_owner"
                                                value=""
                                                autocomplete="off"
                                                readonly>
                                        </div>
                                    </div>

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

                                    <div class="input-box col-12">
                                        <label for=""><?php echo app('translator')->get('Payable Amount'); ?></label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="invest-amount payable_amount form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="amount" id="payable_amount"
                                                value="<?php echo e(old('amount')); ?>"
                                                onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                autocomplete="off"
                                                placeholder="<?php echo app('translator')->get('Enter amount'); ?>" required readonly>
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
                        <button type="submit" class="btn-custom"><?php echo app('translator')->get('Pay Now'); ?></button>
                    </div>

                </div>
            </form>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'
        $(document).on('click', '.directBuyShare', function () {
            var directBuyShare = new bootstrap.Modal(document.getElementById('directBuyShareModal'))
            directBuyShare.show();

            let dataRoute = $(this).data('route');
            console.log(dataRoute);
            let payableAmount = $(this).data('payableamount');
            let dataPropertyOwner = $(this).data('propertyowner');
            let dataProperty = $(this).data('property');

            $('.payable_amount').val(payableAmount);
            $('.property_owner').val(dataPropertyOwner);
            $('.property_title').text(`Property: ${dataProperty}`);
            $('.direct_share_payment_form').attr('action', dataRoute);
            $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/themes/original/user/property/shareProperty.blade.php ENDPATH**/ ?>