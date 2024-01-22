<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($title); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $base_currency = config('basic.currency_symbol');
    ?>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <?php if(adminAccessRoute(config('role.manage_property.access.add'))): ?>
                    <a href="<?php echo e(route('admin.propertyCreate')); ?>" class="btn btn-sm btn-primary btn-rounded mr-2">
                        <span><i class="fas fa-plus"></i> <?php echo app('translator')->get('Create New'); ?></span>
                    </a>
                <?php endif; ?>

                <?php if(adminAccessRoute(config('role.manage_property.access.edit'))): ?>
                    <div class="dropdown mb-2 text-right">
                        <button class="btn btn-sm btn-rounded btn-primary dropdown-toggle" type="button"
                                id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="fas fa-bars pr-2"></i> <?php echo app('translator')->get('Action'); ?></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_active"><?php echo app('translator')->get('Active'); ?></button>
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_inactive"><?php echo app('translator')->get('Inactive'); ?></button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <?php if(adminAccessRoute(config('role.manage_property.access.edit'))): ?>
                            <th scope="col" class="text-center">
                                <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                       id="check-all">
                                <label for="check-all"></label>
                            </th>
                        <?php endif; ?>

                        <th scope="col"><?php echo app('translator')->get('Property'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Investment Amount'); ?> <span class="text-primary font-12">(<?php echo app('translator')->get('Range/fixed'); ?>)</span></th>
                        <th scope="col"><?php echo app('translator')->get('Total Investment Need'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Profit'); ?><span class="text-primary font-12">(<?php echo app('translator')->get('%/fixed'); ?>)</span></th>
                        <th scope="col"><?php echo app('translator')->get('Installment Facility'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <?php if(adminAccessRoute(config('role.manage_property.access.edit')) == true || adminAccessRoute(config('role.manage_property.access.delete')) == true): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>

                    </thead>
                    <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $manageProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <?php if(adminAccessRoute(config('role.manage_property.access.edit'))): ?>
                                <td class="text-center">
                                    <input type="checkbox" id="chk-<?php echo e($item->id); ?>"
                                           class="form-check-input row-tic tic-check" name="check"
                                           value="<?php echo e($item->id); ?>"
                                           data-id="<?php echo e($item->id); ?>">
                                    <label for="chk-<?php echo e($item->id); ?>"></label>
                                </td>
                            <?php endif; ?>

                            <td data-label="<?php echo app('translator')->get('Property'); ?>">
                                <?php echo app('translator')->get(optional($item->details)->property_title); ?>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Investment Amount'); ?>">
                                <p class="font-weight-bold"><?php echo e($item->investmentAmount); ?></p>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Total Invest'); ?>">
                                <p class="font-weight-bold"><?php echo e($basic->currency_symbol); ?><?php echo e($item->total_investment_amount); ?></p>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Profit'); ?>">
                                <p class="font-weight-bold"> <?php echo e($item->profit_type == 1 ? $item->profit . '%' : $base_currency . $item->profit); ?></p>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Installment'); ?>">
                                <p class="font-weight-bold">
                                    <?php if($item->is_installment == 0): ?>
                                        <span class="custom-badge bg-danger"><?php echo app('translator')->get('No'); ?></span>
                                    <?php else: ?>
                                        <span class="custom-badge bg-success"><?php echo app('translator')->get('yes'); ?></span>
                                    <?php endif; ?>
                                </p>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                <?php if($item->status == 0): ?>
                                    <span class="custom-badge bg-danger badge-pill"><?php echo app('translator')->get('Deactive'); ?></span>
                                <?php else: ?>
                                    <span class="custom-badge bg-success badge-pill"><?php echo app('translator')->get('Active'); ?></span>
                                <?php endif; ?>
                            </td>

                            <?php if(adminAccessRoute(config('role.manage_property.access.edit')) == true || adminAccessRoute(config('role.manage_property.access.delete')) == true): ?>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <?php if(adminAccessRoute(config('role.manage_property.access.edit')) == true): ?>
                                        <a href="<?php echo e(route('admin.propertyEdit',$item->id)); ?>"
                                           class="btn btn-sm btn-outline-primary btn-rounded btn-rounded edit-button">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>

                                    <button
                                        class="btn btn-sm btn-outline-primary btn-rounded btn-sm edit-button propertyInvestInfo"
                                        type="button"
                                        data-property="<?php echo e(optional($item->details)->property_title); ?>"
                                        data-totalinvestmentamount="<?php echo e($item->total_investment_amount); ?>"
                                        data-expiredate="<?php echo e(dateTime($item->expire_date)); ?>"
                                        data-startdate="<?php echo e(dateTime($item->start_date)); ?>"
                                        data-investment="<?php echo e(json_encode($item->totalInvestUserAndAmount())); ?>">
                                        <span><i class="fas fa-info"></i></span>
                                    </button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="100%" class="text-center text-na"><?php echo app('translator')->get('No Data Found'); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($manageProperties->links('partials.pagination')); ?>

            </div>
        </div>
    </div>

    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Active Property Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to active the properties"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary active-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="all_inactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('DeActive Property Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to Inactive the properties"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary inactive-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel"><?php echo app('translator')->get('Delete Confirmation'); ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to delete this?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="deleteRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="propertyInvestInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><?php echo app('translator')->get('Property Investment Information'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <ul class="list-group withdraw-detail">
                        <li class="list-group-item">
                            <span class="font-weight-bold"> <?php echo app('translator')->get('Property'); ?>: </span>
                            <span class="font-weight-bold ml-3 propertyName"></span>
                        </li>

                        <li class="list-group-item">
                            <span class="font-weight-bold "> <?php echo app('translator')->get('Total Invested User'); ?>: </span>
                            <span class="font-weight-bold ml-3 totalInvestedUser"></span>
                        </li>

                        <li class="list-group-item">
                            <span class="font-weight-bold"> <?php echo app('translator')->get('Need Total Invest Amount'); ?>: </span>
                            <span class="font-weight-bold ml-3 requiredAmount"></span>
                        </li>

                        <li class="list-group-item">
                            <span class="font-weight-bold "> <?php echo app('translator')->get('Received Amount'); ?>: </span>
                            <span class="font-weight-bold ml-3 receivedAmount"></span>
                        </li>

                        <li class="list-group-item">
                            <span class="font-weight-bold "> <?php echo app('translator')->get('Due Amount'); ?>: </span>
                            <span class="font-weight-bold ml-3 dueAmount"></span>
                        </li>

                        <li class="list-group-item">
                            <span class="font-weight-bold "> <?php echo app('translator')->get('Investment Start Date'); ?>: </span>
                            <span class="font-weight-bold ml-3 startDate"></span>
                        </li>

                        <li class="list-group-item">
                            <span class="font-weight-bold "> <?php echo app('translator')->get('Investment Expire Date'); ?>: </span>
                            <span class="font-weight-bold ml-3 expireDate"></span>
                        </li>
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">
                        <span><?php echo app('translator')->get('Cancel'); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('style-lib'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>




    <?php if($errors->any()): ?>
        <?php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        ?>
        <script>
            "use strict";
            <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            Notiflix.Notify.Failure("<?php echo e(trans($error)); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>

    <script>
        "use strict";
        $('.notiflix-confirm').on('click', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })

        $(document).ready(function () {
            $(document).on('click', '#check-all', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });


            $(document).on('click', '.propertyInvestInfo', function () {
                var propertyInvestInfoModal = new bootstrap.Modal(document.getElementById('propertyInvestInfoModal'))
                propertyInvestInfoModal.show();

                let property = $(this).data('property');
                let investment = $(this).data('investment');

                let totalInvestmentAmount = $(this).data('totalinvestmentamount');
                let expireDate = $(this).data('expiredate');
                let startDate = $(this).data('startdate');
                let totalInvestedAmount = investment.totalInvestedAmount;
                let totalInvestedUser = investment.totalInvestedUser;
                let dueAmount = totalInvestmentAmount - totalInvestedAmount;
                let symbol = "<?php echo e(trans($basic->currency_symbol)); ?>";


                $('.propertyName').text(property);
                $('.totalInvestedUser').text(totalInvestedUser);
                $('.requiredAmount').text(`${symbol}${totalInvestmentAmount}`);
                $('.receivedAmount').text(`${symbol}${totalInvestedAmount}`);
                $('.dueAmount').text(`${symbol}${dueAmount}`);
                $('.expireDate').text(expireDate);
                $('.startDate').text(startDate);
            });

            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });


            //multiple active
            $(document).on('click', '.active-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.property-active')); ?>",
                    data: {strIds: strIds},
                    datatType: 'json',
                    success: function (data) {
                        location.reload();
                    },
                });
            });

            //multiple deactive
            $(document).on('click', '.inactive-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('admin.property-inactive')); ?>",
                    data: {strIds: strIds},
                    datatType: 'json',
                    success: function (data) {
                        location.reload();
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/admin/property/list.blade.php ENDPATH**/ ?>