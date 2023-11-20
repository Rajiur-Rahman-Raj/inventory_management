<?php if(count($myOfferedProperties) > 0): ?>
    <div class="col-lg-12">
        <div class="row g-4 mb-5">
            <?php $__currentLoopData = $myOfferedProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $offerProperty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-4">
                    <div class="property-box">
                        <div class="img-box">
                            <img class="img-fluid"
                                 src="<?php echo e(getFile(config('location.propertyThumbnail.path').optional($offerProperty->property)->thumbnail)); ?>"
                                 alt="<?php echo app('translator')->get('property thumbnail'); ?>"/>
                            <div class="content">
                                <div class="tag"><?php echo app('translator')->get('Buy'); ?></div>
                                <div class="badges">
                                    <?php if($offerProperty->status == 0 && $offerProperty->payment_status == 0): ?>
                                        <span class="warning"><?php echo app('translator')->get('Offer Pending'); ?></span>
                                    <?php elseif($offerProperty->status == 1 && $offerProperty->payment_status == 0): ?>
                                        <span class="success"><?php echo app('translator')->get('Offer Accepted'); ?></span>
                                    <?php elseif($offerProperty->status == 2 && $offerProperty->payment_status == 0): ?>
                                        <span class="danger"><?php echo app('translator')->get('Offer Rejected'); ?></span>
                                    <?php elseif($offerProperty->status == 1 && $offerProperty->payment_status == 1): ?>
                                        <span class="featured"><?php echo app('translator')->get('Offer Completed'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h4 class="price"><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)optional($offerProperty->propertyShare)->amount); ?></h4>
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

                                    <?php if(optional($offerProperty->property)->avgRating() != intval(optional($offerProperty->property)->avgRating())): ?>
                                        <?php
                                            $isCheck = 1;
                                        ?>
                                    <?php endif; ?>
                                    <?php for($i = optional($offerProperty->property)->avgRating(); $i > $isCheck; $i--): ?>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endfor; ?>
                                    <?php if(optional($offerProperty->property)->avgRating() != intval(optional($offerProperty->property)->avgRating())): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endif; ?>

                                    <?php if(optional($offerProperty->property)->avgRating() == 0 || optional($offerProperty->property)->avgRating() != null): ?>
                                        <?php for($j; $j < 5; $j++): ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </span>

                                    <span>(<?php echo e(count($offerProperty->property->getReviews) <= 1 ? (count($offerProperty->property->getReviews). trans(' review')) : (count($offerProperty->property->getReviews). trans(' reviews'))); ?>)</span>
                                </div>
                                <div class="owner">
                                    <?php echo app('translator')->get('Owner: '); ?> <?php echo app('translator')->get(optional($offerProperty->owner)->fullname); ?>
                                </div>
                            </div>


                            <a class="title"
                               href="<?php echo e(route('propertyDetails',[slug(optional(optional($offerProperty->property)->details)->property_title), optional($offerProperty->property)->id])); ?>"><?php echo e(Str::limit(optional(optional($offerProperty->property)->details)->property_title, 30)); ?></a>
                            <p class="address">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo app('translator')->get(optional(optional(optional($offerProperty->property)->getAddress)->details)->title); ?>
                            </p>

                            <div class="aminities">
                                <?php $__currentLoopData = optional($offerProperty->property)->limitamenity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php if($offerProperty->status == 0 && optional($offerProperty->propertyShare)->status == 1): ?>
                                            <li>
                                                <a class="dropdown-item btn updateOffer"
                                                   data-route="<?php echo e(route('user.propertyOfferUpdate', $offerProperty->id)); ?>"
                                                   data-owner="<?php echo e(optional($offerProperty->owner)->fullname); ?>"
                                                   data-amount="<?php echo e($offerProperty->amount); ?>"
                                                   data-details="<?php echo e($offerProperty->description); ?>"
                                                   data-property="<?php echo e((optional(optional($offerProperty->property)->details)->property_title)); ?>">
                                                    <i class="fal fa-paper-plane"></i> <?php echo app('translator')->get('Update Offer'); ?>
                                                </a>
                                            </li>
                                        <?php elseif(optional($offerProperty->propertyShare)->status == 0 && $offerProperty->payment_status == 0): ?>
                                            <li>
                                                <a class="dropdown-item btn disabled">
                                                    <i class="fal fa-shopping-cart"></i> <?php echo app('translator')->get('Sold out'); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('user.offerConversation', $offerProperty->id)); ?>">
                                                <i class="fal fa-envelope" aria-hidden="true"></i> <?php echo app('translator')->get('Conversation'); ?>
                                            </a>
                                        </li>
                                        <?php if($offerProperty->status == 2 || (optional($offerProperty->propertyShare)->status == 0 && $offerProperty->payment_status == 0)): ?>
                                            <li>
                                                <a class="dropdown-item btn notiflix-confirm"
                                                   data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                   data-route="<?php echo e(route('user.propertyOfferRemove', $offerProperty->id)); ?>">
                                                    <i class="fal fa-trash-alt"></i> <?php echo app('translator')->get('Remove'); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <a href="<?php echo e(route('investorProfile', [slug(optional($offerProperty->owner)->username), optional($offerProperty->owner)->id])); ?>" target="_blank">
                                    <?php echo app('translator')->get('Contact Owner'); ?>
                                </a>
                            </div>

                            <div class="plan d-flex justify-content-between">
                                <div>
                                    <?php if(optional($offerProperty->property)->profit_type == 1): ?>
                                        <h5><?php echo e((int)optional($offerProperty->property)->profit); ?>% (<?php echo app('translator')->get('Fixed'); ?>)</h5>
                                    <?php else: ?>
                                        <h5><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)optional($offerProperty->property)->profit); ?>

                                            (<?php echo app('translator')->get('Fixed'); ?>)
                                        </h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Profit Range'); ?></span>
                                </div>
                                <div>
                                    <?php if(optional($offerProperty->property)->is_return_type == 1): ?>
                                        <h5><?php echo app('translator')->get('Lifetime'); ?></h5>
                                    <?php else: ?>
                                        <h5><?php echo e(optional(optional($offerProperty->property)->managetime)->time); ?> <?php echo app('translator')->get(optional(optional($offerProperty->property)->managetime)->time_type); ?></h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Return Interval'); ?></span>
                                </div>
                                <div>
                                    <h5><?php echo e(optional($offerProperty->property)->is_capital_back == 1 ? 'Yes' : 'No'); ?></h5>
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
                <?php echo e($myOfferedProperties->appends($_GET)->links()); ?>

            </ul>
        </nav>
    </div>
<?php else: ?>
    <div class="custom-not-found mt-5">
        <img src="<?php echo e(asset($themeTrue.'img/no_data_found.png')); ?>" alt="<?php echo app('translator')->get('not found'); ?>" class="img-fluid">
    </div>
<?php endif; ?>

<?php $__env->startPush('loadModal'); ?>
    
    <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?php echo app('translator')->get('Remove Confirmation'); ?></h5>
                    <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to remove this?'); ?></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-custom btn2 btn-secondary close_invest_modal close__btn"
                            data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="deleteRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button type="submit" class="btn-custom"><?php echo app('translator')->get('Remove'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'
        $('.notiflix-confirm').on('click', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/property/myOfferProperty.blade.php ENDPATH**/ ?>