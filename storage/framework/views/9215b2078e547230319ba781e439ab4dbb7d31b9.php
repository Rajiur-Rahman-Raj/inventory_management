<?php $__env->startSection('title',trans('Purchased Raw Item Details')); ?>
<?php $__env->startSection('content'); ?>
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
                                               data-route="<?php echo e(route('user.salesOrderUpdate', $singlePurchaseItemDetails->id)); ?>"
                                               data-property="<?php echo e($singlePurchaseItemDetails); ?>">
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
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"> <i class="fal fa-user me-2 text-info"></i> <?php echo app('translator')->get('Purchased From'); ?></h6>
                                                        <p><?php echo e(optional($singlePurchaseItem->supplier)->name); ?></p>
                                                    </div>

                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Purchased Date'); ?></h6>
                                                        <p><?php echo e(dateTime(customDate($singlePurchaseItem->purchase_date))); ?></p>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/rawItems/purchaseRawItemDetails.blade.php ENDPATH**/ ?>