<?php if(count($receivedOfferedList) > 0): ?>
    <div class="col-lg-12">
        <div class="row g-4 mb-5">
            <?php $__currentLoopData = $receivedOfferedList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $offerList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-4">
                    <div class="property-box">
                        <div class="img-box">
                            <img class="img-fluid"
                                 src="<?php echo e(getFile(config('location.propertyThumbnail.path').optional($offerList->property)->thumbnail)); ?>"
                                 alt="<?php echo app('translator')->get('property thumbnail'); ?>"/>
                            <div class="content">
                                <div class="tag"><?php echo app('translator')->get('Sell'); ?></div>
                                <h4 class="price"><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)optional($offerList->propertyShare)->amount); ?></h4>
                            </div>
                        </div>

                        <div class="text-box">
                            <div class="review">
                                <span>
                                    <?php
                                        $isCheck = 0;
                                        $j = 0;
                                    ?>

                                    <?php if(optional($offerList->property)->avgRating() != intval(optional($offerList->property)->avgRating())): ?>
                                        <?php
                                            $isCheck = 1;
                                        ?>
                                    <?php endif; ?>
                                    <?php for($i = optional($offerList->property)->avgRating(); $i > $isCheck; $i--): ?>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endfor; ?>
                                    <?php if(optional($offerList->property)->avgRating() != intval(optional($offerList->property)->avgRating())): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endif; ?>

                                    <?php if(optional($offerList->property)->avgRating() == 0 || optional($offerList->property)->avgRating() != null): ?>
                                        <?php for($j; $j < 5; $j++): ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </span>
                                <span>(<?php echo e(count(optional($offerList->property)->getReviews) <= 1 ? (count(optional($offerList->property)->getReviews). trans(' review')) : (count(optional($offerList->property)->getReviews). trans(' reviews'))); ?>)</span>
                            </div>

                            <a class="title"
                               href="<?php echo e(route('propertyDetails',[slug(optional($offerList->property->details)->property_title), optional($offerList->property)->id])); ?>"><?php echo e(Str::limit(optional($offerList->property->details)->property_title, 30)); ?></a>
                            <p class="address">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo app('translator')->get(optional($offerList->property->getAddress->details)->title); ?>
                            </p>

                            <div class="aminities">
                                <?php $__currentLoopData = optional($offerList->property)->limitamenity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><i class="<?php echo e($amenity->icon); ?>"></i><?php echo e(optional($amenity->details)->title); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>



                            <div class="invest-btns d-flex justify-content-between">
                                <a class="btn" href="<?php echo e(route('user.offerList', $offerList->property_share_id)); ?>">
                                    <?php echo app('translator')->get('Offer List'); ?> <span class="badge bg-secondary"><?php echo e($offerList->totalOfferList($offerList->property_share_id)); ?></span>
                                </a>

                                <a href="<?php echo e(route('contact')); ?>">
                                    <?php echo app('translator')->get('Contact Us'); ?>
                                </a>
                            </div>

                            <div class="plan d-flex justify-content-between">
                                <div>
                                    <?php if(optional($offerList->property)->profit_type == 1): ?>
                                        <h5><?php echo e((int)optional($offerList->property)->profit); ?>% (<?php echo app('translator')->get('Fixed'); ?>)</h5>
                                    <?php else: ?>
                                        <h5><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)optional($offerList->property)->profit); ?>

                                            (<?php echo app('translator')->get('Fixed'); ?>)
                                        </h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Profit Range'); ?></span>
                                </div>
                                <div>
                                    <?php if(optional($offerList->property)->is_return_type == 1): ?>
                                        <h5><?php echo app('translator')->get('Lifetime'); ?></h5>
                                    <?php else: ?>
                                        <h5><?php echo e(optional($offerList->property->managetime)->time); ?> <?php echo app('translator')->get(optional($offerList->property->managetime)->time_type); ?></h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Return Interval'); ?></span>
                                </div>
                                <div>
                                    <h5><?php echo e(optional($offerList->property)->is_capital_back == 1 ? 'Yes' : 'No'); ?></h5>
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
                <?php echo e($receivedOfferedList->appends($_GET)->links()); ?>

            </ul>
        </nav>
    </div>
<?php else: ?>
    <div class="custom-not-found mt-5">
        <img src="<?php echo e(asset($themeTrue.'img/no_data_found.png')); ?>" alt="..." class="img-fluid">
    </div>
<?php endif; ?>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/property/receiveOfferProperty.blade.php ENDPATH**/ ?>