<?php if(count($mySharedProperties) > 0): ?>
    <div class="col-lg-12">
        <div class="row g-4 mb-5">
            <?php $__currentLoopData = $mySharedProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shareProperty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-4">
                    <div class="property-box">
                        <div class="img-box">
                            <img class="img-fluid"
                                 src="<?php echo e(getFile(config('location.propertyThumbnail.path').optional($shareProperty->property)->thumbnail)); ?>"
                                 alt="<?php echo app('translator')->get('property thumbnail'); ?>"/>
                            <div class="content">
                                <div class="tag"><?php echo app('translator')->get('Sell'); ?></div>
                                <h4 class="price"><?php echo e(config('basic.currency_symbol')); ?><?php echo e((int)$shareProperty->amount); ?></h4>
                            </div>
                        </div>

                        <div class="text-box">
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
                                        <li>
                                            <a class="dropdown-item btn updateShare"
                                               data-route="<?php echo e(route('user.propertyShareUpdate', $shareProperty->id)); ?>"
                                               data-amount="<?php echo e($shareProperty->amount); ?>"
                                               data-property="<?php echo e((optional($shareProperty->property->details)->property_title)); ?>">
                                                <i class="fal fa-share-alt"></i> <?php echo app('translator')->get('Update Share'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn notiflix-confirm"
                                               data-bs-toggle="modal" data-bs-target="#delete-modal"
                                               data-route="<?php echo e(route('user.propertyShareRemove', $shareProperty->id)); ?>">
                                                <i class="fal fa-trash-alt"></i> <?php echo app('translator')->get('Remove'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <a href="<?php echo e(route('contact')); ?>">
                                    <?php echo app('translator')->get('Contact Us'); ?>
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
        <img src="<?php echo e(asset($themeTrue.'img/no_data_found.png')); ?>" alt="..." class="img-fluid">
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
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/property/myShareProperty.blade.php ENDPATH**/ ?>