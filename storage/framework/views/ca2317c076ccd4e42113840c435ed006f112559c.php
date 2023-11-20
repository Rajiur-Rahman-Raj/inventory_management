<?php $__env->startSection('title',trans('Item Stock Details')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Item Stock Details'); ?></h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Item Stock Details'); ?></li>
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
                                        <a href="<?php echo e(route('user.stockList')); ?>"
                                           class="btn btn-sm bgPrimary text-white mr-2 invest-details-back">
                                            <span><i class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?> </span>
                                        </a>
                                    </div>

                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="border-bottom">
                                                    <div class="investmentDate d-flex justify-content-between">
                                                        <h6 class="font-weight-bold text-dark"><i
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Stock Date'); ?>
                                                            : </h6>
                                                        <p><?php echo e(dateTime(customDate($singleStock->stock_date))); ?></p>
                                                    </div>
                                                </div>

                                                <?php if($singleStock->items != null): ?>
                                                    <ul class="list-style-none p-0 stock_list_style">
                                                        <li class="my-3">
                                                        <span class="custom-text">
                                                            <i class="far fa-check-circle mr-2 text-success"
                                                               aria-hidden="true"></i>
                                                            <?php echo app('translator')->get('Item Details'); ?>
                                                        </span>
                                                        </li>

                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Item</th>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Cost</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            <?php
                                                                $totalItemCost = 0;
                                                            ?>

                                                            <?php $__currentLoopData = $singleStock->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td data-label="Item"><?php echo e($singleStock->item($item['item_id'])->name); ?></td>
                                                                    <td data-label="Quantity"><?php echo e($item['item_quantity']); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                                    <td data-label="Cost"><?php echo e($item['item_total_cost']); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <tr>
                                                                <td colspan="2" class="text-right">Total Price</td>
                                                                <td><?php echo e($singleStock->sub_total); ?> <?php echo e($basic->currency_symbol); ?></td>
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/stock/details.blade.php ENDPATH**/ ?>