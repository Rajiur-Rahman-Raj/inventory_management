<?php $__env->startSection('title',trans('Item Stock Details')); ?>
<?php $__env->startSection('content'); ?>
    <!-- main -->
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col ms-2">
                <div class="header-text-full">
                    <h4 class="dashboard_breadcurmb_heading mb-1"><?php echo e(snake2Title($item)); ?> <?php echo app('translator')->get('Stock Details'); ?></h4>
                    <nav aria-label="breadcrumb" class="ms-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.stockList')); ?>"><?php echo app('translator')->get('Stock In'); ?></a>
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
                                                                class="far fa-calendar-check me-2 text-primary"></i> <?php echo app('translator')->get('Last Stock Date'); ?>
                                                            : </h6>
                                                        <p><?php echo e(dateTime(customDate($stock->last_stock_date))); ?></p>
                                                    </div>
                                                </div>

                                                <?php if(sizeof($singleStockDetails) > 0): ?>
                                                    <ul class="list-style-none p-0 stock_list_style">

                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Cost Per Unit</th>
                                                                <th scope="col">Total Unit Cost</th>
                                                                <th scope="col">Stock Date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>


                                                            <?php $__currentLoopData = $singleStockDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stockInDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <tr>
                                                                    <td data-label="Quantity"><?php echo e($stockInDetail->quantity); ?></td>
                                                                    <td data-label="Cost Per Unit"><?php echo e($stockInDetail->cost_per_unit); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                                    <td data-label="Total Unit Cost"><?php echo e($stockInDetail->total_unit_cost); ?> <?php echo e($basic->currency_symbol); ?></td>
                                                                    <td data-label="Stock Date"><?php echo e(customDate($stockInDetail->stock_date)); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <tr>
                                                                <td colspan="3" class="text-right"><?php echo app('translator')->get('Total Price'); ?></td>
                                                                <td> = <?php echo e($totalItemCost); ?> <?php echo e($basic->currency_symbol); ?></td>
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