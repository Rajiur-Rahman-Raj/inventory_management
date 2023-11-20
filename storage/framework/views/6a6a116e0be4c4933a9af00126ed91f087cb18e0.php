<?php $__env->startSection('title',trans('Property Market')); ?>

<?php $__env->startSection('content'); ?>
    <!-- Property Market -->
    <div class="container-fluid shop-section py-0">
        <div class="main row">

            <div class="col">
                <div class="header-text-full">
                    <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Property Market'); ?></h3>

                    <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn-custom <?php echo e(($type == 'investment-properties') ? 'active':''); ?>"
                                    id="pills-all-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
                                    aria-selected="true"><?php echo app('translator')->get('Investment Properties'); ?></button>
                        </li>
                        <?php if(config('basic.is_share_investment') == 1): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn-custom <?php echo e(($type == 'property-share-market') ? 'active':''); ?>"
                                        id="pills-allshare-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-allshare" type="button" role="tab"
                                        aria-controls="pills-allshare"
                                        aria-selected="false"><?php echo app('translator')->get('Share Market'); ?></button>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link btn-custom <?php echo e(($type == 'my-investment-properties') ? 'active':''); ?>"
                                id="pills-myproperty-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-myproperty" type="button" role="tab"
                                aria-controls="pills-myproperty"
                                aria-selected="false"><?php echo app('translator')->get('My Properties'); ?></button>
                        </li>

                        <?php if(config('basic.is_share_investment') == 1): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn-custom <?php echo e(($type == 'my-shared-properties') ? 'active':''); ?>"
                                        id="pills-myshareproperty-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-myshareproperty" type="button" role="tab"
                                        aria-controls="pills-myshareproperty"
                                        aria-selected="false"><?php echo app('translator')->get('My Shared Properties'); ?></button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn-custom <?php echo e(($type == 'my-offered-properties') ? 'active':''); ?>"
                                        id="pills-myofferproperty-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-myofferproperty" type="button" role="tab"
                                        aria-controls="pills-myofferproperty"
                                        aria-selected="false"><?php echo app('translator')->get('Send Offer'); ?></button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn-custom <?php echo e(($type == 'receive-offered-properties') ? 'active':''); ?>"
                                        id="pills-receiveofferedproperties-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-receiveofferedproperties" type="button" role="tab"
                                        aria-controls="pills-receiveofferedproperties"
                                        aria-selected="false"><?php echo app('translator')->get('Receive Offer'); ?>
                                </button>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>


            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade <?php echo e(($type == 'investment-properties') ? 'show active':''); ?>" id="pills-all"
                     role="tabpanel" aria-labelledby="pills-all-tab"
                     tabindex="0">
                    <?php echo $__env->make($theme.'user.property.allProperty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <?php if(config('basic.is_share_investment') == 1): ?>
                    <div class="tab-pane fade <?php echo e(($type == 'property-share-market') ? 'show active':''); ?>" id="pills-allshare"
                         role="tabpanel"
                         aria-labelledby="pills-allshare-tab"
                         tabindex="0">
                        <?php echo $__env->make($theme.'user.property.shareProperty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endif; ?>

                <div class="tab-pane fade <?php echo e(($type == 'my-investment-properties') ? 'show active':''); ?>"
                     id="pills-myproperty" role="tabpanel" aria-labelledby="pills-myproperty-tab"
                     tabindex="0">
                    <?php echo $__env->make($theme.'user.property.myProperty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <?php if(config('basic.is_share_investment') == 1): ?>
                    <div class="tab-pane fade <?php echo e(($type == 'my-shared-properties') ? 'show active':''); ?>"
                         id="pills-myshareproperty" role="tabpanel"
                         aria-labelledby="pills-myshareproperty-tab" tabindex="0">
                        <?php echo $__env->make($theme.'user.property.myShareProperty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>


                    <div class="tab-pane fade <?php echo e(($type == 'my-offered-properties') ? 'show active':''); ?>"
                         id="pills-myofferproperty" role="tabpanel"
                         aria-labelledby="pills-myofferproperty-tab" tabindex="0">
                        <?php echo $__env->make($theme.'user.property.myOfferProperty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="tab-pane fade <?php echo e(($type == 'receive-offered-properties') ? 'show active':''); ?>"
                         id="pills-receiveofferedproperties" role="tabpanel"
                         aria-labelledby="pills-receiveofferedproperties-tab" tabindex="0">
                        <?php echo $__env->make($theme.'user.property.receiveOfferProperty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $__env->startPush('loadModal'); ?>

        
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
                                            <input type="hidden" name="investment_id" class="investment_id">
                                            <label for=""><?php echo app('translator')->get('Share Amount'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="invest-amount form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="amount" id="amount"
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

        
        <div class="modal fade" id="updateShareModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <form action="" method="post" id="invest-form" class="login-form update_share">
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
                                <div class="m-3 mb-0 payment-method-details property-title font-weight-bold"></div>
                                <div class="card-body">
                                    <div class="row g-3 investModalPaymentForm">
                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Share Amount'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="invest-amount form-control amount <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="amount" id="amount"
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
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <form action="" method="post" id="invest-form"
                      class="login-form update_offer_form">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Property Offer Details'); ?></h5>
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
                                            <label for=""><?php echo app('translator')->get('Property Owner'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control property_owner"
                                                    value=""
                                                    autocomplete="off"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Offer Amount'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="invest-amount amount form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="amount"
                                                    value=""
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

                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Description'); ?></label>
                                            <div class="input-group">
                                                <textarea name="description"
                                                          class="form-control details <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                          cols="10" rows="3"></textarea>
                                            </div>
                                            <?php $__errorArgs = ['description'];
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
                            <button type="submit" class="btn-custom investModalSubmitBtn"><?php echo app('translator')->get('Update Offer'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="modal fade" id="makeOfferModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <form action="" method="post" id="invest-form"
                      class="login-form make_offer_form">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Make Offer Details'); ?></h5>
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
                                            <label for=""><?php echo app('translator')->get('Offer Amount'); ?></label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="invest-amount form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="amount" id="amount"
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

                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Description'); ?></label>
                                            <div class="input-group">
                                                <textarea name="description"
                                                          class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                          id="description" cols="10" rows="3"></textarea>
                                            </div>
                                            <?php $__errorArgs = ['description'];
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
                            <button type="submit" class="btn-custom investModalSubmitBtn"><?php echo app('translator')->get('Send Offer'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        var isAuthenticate = '<?php echo e(Auth::check()); ?>';

        $(document).ready(function () {
            $('.wishList').on('click', function () {
                var _this = this.id;
                let property_id = $(this).data('property');
                if (isAuthenticate == 1) {
                    wishList(property_id, _this);
                } else {
                    window.location.href = '<?php echo e(route('login')); ?>';
                }
            });
        });

        function wishList(property_id = null, id = null) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "<?php echo e(route('user.wishList')); ?>",
                type: "POST",
                data: {
                    property_id: property_id,
                },
                success: function (data) {
                    if (data.data == 'added') {
                        $(`.save${id}`).removeClass("fal fa-heart");
                        $(`.save${id}`).addClass("fas fa-heart");
                        Notiflix.Notify.Success("Wishlist added");
                    }
                    if (data.data == 'remove') {
                        $(`.save${id}`).removeClass("fas fa-heart");
                        $(`.save${id}`).addClass("fal fa-heart");
                        Notiflix.Notify.Success("Wishlist removed");
                    }
                },
            });
        }

        $(document).on('click', '.sendOffer', function () {
            var propertysendOfferModal = new bootstrap.Modal(document.getElementById('sendOfferModal'))
            propertysendOfferModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');

            $('.send_offer_modal').attr('action', dataRoute);
            $('.property-title').text(`Property: ${dataProperty}`);
            $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");
        });

        $(document).on('click', '.updateShare', function () {
            var propertyUpdateShareModal = new bootstrap.Modal(document.getElementById('updateShareModal'))
            propertyUpdateShareModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');
            let amount = $(this).data('amount');

            $('.update_share').attr('action', dataRoute);
            $('.property-title').text(`Property: ${dataProperty}`);
            $('.amount').val(amount);
            $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");
        });

        $(document).on('click', '.updateOffer', function () {
            var propertyUpdateOfferModal = new bootstrap.Modal(document.getElementById('updateOfferModal'))
            propertyUpdateOfferModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');
            let dataPropertyOwner = $(this).data('owner');
            let amount = $(this).data('amount');
            let details = $(this).data('details');

            $('.update_offer_form').attr('action', dataRoute);
            $('.property_owner').val(dataPropertyOwner);
            $('.property-title').text(`Property: ${dataProperty}`);
            $('.details').text(details);
            $('.amount').val(amount);
            $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");
        });

        $(document).on('click', '.makeOffer', function () {

            var propertymakeOfferModal = new bootstrap.Modal(document.getElementById('makeOfferModal'))
            propertymakeOfferModal.show();

            let dataRoute = $(this).data('route');
            $('.make_offer_form').attr('action', dataRoute);
            let dataPropertyOwner = $(this).data('propertyowner');
            let dataProperty = $(this).data('property');

            $('.property_owner').val(dataPropertyOwner);
            $('.property-title').text(`Property: ${dataProperty}`);
            $('.show-currency').text("<?php echo e(config('basic.currency')); ?>");

        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/themes/original/user/property/index.blade.php ENDPATH**/ ?>