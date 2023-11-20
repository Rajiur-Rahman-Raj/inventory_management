<?php if(count($myProperties) > 0): ?>
    <div class="col-lg-12">
        <div class="row g-4 mb-5">
            <?php $__currentLoopData = $myProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-4">
                    <div class="property-box">
                        <div class="img-box">
                            <img class="img-fluid"
                                 src="<?php echo e(getFile(config('location.propertyThumbnail.path').optional($property->property)->thumbnail)); ?>"
                                 alt="<?php echo app('translator')->get('property thumbnail'); ?>"/>
                            <div class="content">
                                <?php if(optional($property->property)->is_invest_type == 0): ?>
                                    <div class="tag"><?php echo app('translator')->get('Fixed Invest'); ?></div>
                                <?php else: ?>
                                    <div class="tag"><?php echo app('translator')->get('Invest Range'); ?></div>
                                <?php endif; ?>

                                <div class="badges">
                                    <?php if(optional($property->property)->is_installment == 1): ?>
                                        <span class="featured"><?php echo app('translator')->get('Installment facility'); ?></span>
                                    <?php else: ?>
                                        <span class="featured"><?php echo app('translator')->get('No installment'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h4 class="price"><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)$property->amount); ?></h4>
                                <?php if($property->status == 0 && $property->invest_status == 1): ?>
                                    <span class="invest-completed"><i class="fad fa-check-circle"></i> <?php echo app('translator')->get('Running'); ?></span>
                                    <?php elseif($property->status == 1 && $property->invest_status == 1): ?>
                                    <span class="invest-completed"><i class="fad fa-check-circle text-success"></i> <?php echo app('translator')->get('Completed'); ?></span>
                                <?php else: ?>
                                    <span class="invest-completed"><i class="fad fa-times-circle text-danger"></i> <?php echo app('translator')->get('Due'); ?></span>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="text-box">
                            <div class="review">
                                <span>
                                    <?php
                                        $isCheck = 0;
                                        $j = 0;
                                    ?>

                                    <?php if(optional($property->property)->avgRating() != intval(optional($property->property)->avgRating())): ?>
                                        <?php
                                            $isCheck = 1;
                                        ?>
                                    <?php endif; ?>
                                    <?php for($i = optional($property->property)->avgRating(); $i > $isCheck; $i--): ?>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endfor; ?>
                                    <?php if(optional($property->property)->avgRating() != intval(optional($property->property)->avgRating())): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                        <?php
                                            $j = $j + 1;
                                        ?>
                                    <?php endif; ?>

                                    <?php if(optional($property->property)->avgRating() == 0 || optional($property->property)->avgRating() != null): ?>
                                        <?php for($j; $j < 5; $j++): ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </span>
                                <span>(<?php echo e(count($property->property->getReviews) <= 1 ? (count($property->property->getReviews). trans(' review')) : (count($property->property->getReviews). trans(' reviews'))); ?>)</span>
                            </div>
                            <a class="title"
                               href="<?php echo e(route('propertyDetails',[@slug(optional($property->property->details)->property_title), optional($property->property)->id])); ?>"><?php echo e(\Illuminate\Support\Str::limit(optional($property->property->details)->property_title, 30)); ?></a>
                            <p class="address">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo app('translator')->get(optional($property->property->getAddress->details)->title); ?>
                            </p>

                            <div class="aminities">
                                <?php $__currentLoopData = optional($property->property)->limitamenity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><i class="<?php echo e($amenity->icon); ?>"></i><?php echo e(optional($amenity->details)->title); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="invest-btns d-flex justify-content-between">

                                <?php if($property->propertyShare): ?>
                                    <button type="button" class="btn text-danger">
                                        <?php echo app('translator')->get('Already Shared'); ?>
                                    </button>
                                <?php else: ?>
                                    <?php if(optional($property->property)->is_investor == 1 && config('basic.is_share_investment') == 1): ?>
                                        <button type="button" class="sendOffer btn <?php echo e(($property->invest_status == 1 && $property->status == 1) || ($property->invest_status == 0) || (optional($property->property)->is_investor == 0) ? 'disabled' : ''); ?>"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="<?php echo app('translator')->get('You can sell this investment'); ?>"
                                                data-route="<?php echo e(route('user.propertyShareStore', $property->id)); ?>"
                                                data-property="<?php echo e(optional($property->property->details)->property_title); ?>">
                                            <?php echo app('translator')->get('Sell Share'); ?>
                                        </button>
                                    <?php else: ?>
                                        <button class="opacity-0"></button>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <a href="<?php echo e(route('contact')); ?>">
                                    <?php echo app('translator')->get('Contact Us'); ?>
                                </a>
                            </div>

                            <div class="plan d-flex justify-content-between">
                                <div>
                                    <?php if(optional($property->property)->profit_type == 1): ?>
                                        <h5><?php echo e(optional($property->property)->profit); ?>% (<?php echo app('translator')->get('Fixed'); ?>)</h5>
                                    <?php else: ?>
                                        <h5><?php echo e(config('basic.currency_symbol')); ?><?php echo e(optional($property->property)->profit); ?>

                                            (<?php echo app('translator')->get('Fixed'); ?>)</h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Profit Range'); ?></span>
                                </div>
                                <div>
                                    <?php if(optional($property->property)->is_return_type == 1): ?>
                                        <h5><?php echo app('translator')->get('Lifetime'); ?></h5>
                                    <?php else: ?>
                                        <h5><?php echo e(optional($property->property->managetime)->time); ?> <?php echo app('translator')->get(optional($property->property->managetime)->time_type); ?></h5>
                                    <?php endif; ?>
                                    <span><?php echo app('translator')->get('Return Interval'); ?></span>
                                </div>
                                <div>
                                    <h5><?php echo e(optional($property->property)->is_capital_back == 1 ? 'Yes' : 'No'); ?></h5>
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
                <?php echo e($myProperties->appends($_GET)->links()); ?>

            </ul>
        </nav>
    </div>
<?php else: ?>
    <div class="custom-not-found mt-5">
        <img src="<?php echo e(asset($themeTrue.'img/no_data_found.png')); ?>" alt="<?php echo app('translator')->get('not found'); ?>" class="img-fluid">
    </div>
<?php endif; ?>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/property/myProperty.blade.php ENDPATH**/ ?>