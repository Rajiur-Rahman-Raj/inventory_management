<?php $__env->startSection('title',trans($title)); ?>
<?php $__env->startSection('content'); ?>

    <?php $__env->startPush('style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap-datepicker.css')); ?>"/>
    <?php $__env->stopPush(); ?>

    <section class="transaction-history">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col ms-2">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Payout History'); ?></h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Payout History'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- search area -->
            <div class="search-bar p-0">
                <form action="<?php echo e(route('user.payout.history.search')); ?>" method="get">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-lg-3">
                            <input
                                type="text"
                                name="name"
                                value="<?php echo e(@request()->name); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Transaction ID'); ?>"
                            />
                        </div>

                        <div class="input-box col-lg-3">
                            <select name="status"
                                    class="form-select"
                                    id="salutation"
                                    aria-label="Default select example">
                                <option value=""><?php echo app('translator')->get('All Payment'); ?></option>
                                <option value="1"
                                        <?php if(@request()->status == '1'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Pending Payment'); ?></option>
                                <option value="2"
                                        <?php if(@request()->status == '2'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Complete Payment'); ?></option>
                                <option value="3"
                                        <?php if(@request()->status == '3'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Cancel Payment'); ?></option>
                            </select>
                        </div>

                        <div class="input-box col-lg-2">
                            <input
                                type="text" class="form-control datepicker from_date" name="from_date"
                                value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>"
                                autocomplete="off" readonly/>
                        </div>

                        <div class="input-box col-lg-2">
                            <input
                                type="text" class="form-control datepicker to_date" name="to_date"
                                value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>"
                                autocomplete="off" readonly disabled="true"/>
                        </div>

                        <div class="input-box col-lg-2">
                            <button class="btn-custom w-100" type="submit"><i class="fal fa-search"></i> <?php echo app('translator')->get('Search'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="row mt-4">
                <div class="col">
                    <div class="table-parent table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col"><?php echo app('translator')->get('Transaction ID'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Gateway'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Amount'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Charge'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Time'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Details'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $payoutLog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($item->trx_id); ?></td>
                                    <td><?php echo app('translator')->get(optional($item->method)->name); ?></td>
                                    <td><?php echo e(getAmount($item->amount)); ?> <?php echo app('translator')->get($basic->currency); ?></td>
                                    <td><?php echo e(getAmount($item->charge)); ?> <?php echo app('translator')->get($basic->currency); ?></td>
                                    <td>
                                        <?php if($item->status == 1): ?>
                                            <span class="badge bg-warning"><?php echo app('translator')->get('Pending'); ?></span>
                                        <?php elseif($item->status == 2): ?>
                                            <span class="badge bg-success"><?php echo app('translator')->get('Complete'); ?></span>
                                        <?php elseif($item->status == 3): ?>
                                            <span class="badge bg-danger"><?php echo app('translator')->get('Cancel'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(dateTime($item->created_at, 'd M Y h:i A')); ?></td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn bgPrimary btn-sm infoButton text-white"
                                            data-information="<?php echo e(json_encode($item->information)); ?>"
                                            data-feedback="<?php echo e($item->feedback); ?>"
                                            data-trx_id="<?php echo e($item->trx_id); ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#infoModal"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr class="text-center">
                                    <td colspan="100%"><?php echo e(__('No Data Found!')); ?></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                        <?php echo e($payoutLog->appends($_GET)->links($theme.'partials.pagination')); ?>


                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Modal -->
    <?php $__env->startPush('loadModal'); ?>
        <div
            class="modal fade"
            id="infoModal"
            tabindex="-1"
            data-bs-backdrop="static"
            aria-labelledby="infoModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title golden-text" id="infoModalLabel">
                            <?php echo app('translator')->get('Details'); ?>
                        </h4>
                        <button type="button" class="close-btn close_invest_modal" data-bs-dismiss="modal"
                                aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-primary bg-transparent lebelFont"><?php echo app('translator')->get('Transactions'); ?>
                                : <span class="trx"></span>
                            </li>
                            <li class="list-group-item list-group-item-primary bg-transparent lebelFont"><?php echo app('translator')->get('Admin Feedback'); ?>
                                : <span
                                    class="feedback"></span></li>
                        </ul>
                        <div class="payout-detail">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-custom text-white"
                            data-bs-dismiss="modal"
                        >
                            <?php echo app('translator')->get('Close'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <?php $__env->startPush('script'); ?>
        <script src="<?php echo e(asset('assets/global/js/bootstrap-datepicker.js')); ?>"></script>

        <script>
            'use strict'
            $(document).ready(function () {
                $(".datepicker").datepicker({
                    autoclose: true,
                    clearBtn: true
                });
                $('.from_date').on('change', function () {
                    $('.to_date').removeAttr('disabled');
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

    <script>
        "use strict";

        $(document).ready(function () {
            $('.infoButton').on('click', function () {
                var infoModal = $('#infoModal');
                infoModal.find('.trx').text($(this).data('trx_id'));
                infoModal.find('.feedback').text($(this).data('feedback'));
                var list = [];
                var information = Object.entries($(this).data('information'));

                var ImgPath = "<?php echo e(asset(config('location.withdrawLog.path'))); ?>/";
                var result = ``;
                for (var i = 0; i < information.length; i++) {
                    if (information[i][1].type == 'file') {
                        result += `<li class="list-group-item bg-transparent customborder lebelFont">
                                            <span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${information[i][1].field_name}" alt="..." class="w-100">
                                        </li>`;
                    } else {
                        result += `<li class="list-group-item bg-transparent customborder lebelFont text-dark"
                                            <span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${information[i][1].field_name}</span>
                                        </li>`;
                    }
                }

                if (result) {
                    infoModal.find('.payout-detail').html(`<br><h4 class="my-3 golden-text"><?php echo app('translator')->get('Payment Information'); ?></h4>  ${result}`);
                } else {
                    infoModal.find('.payout-detail').html(`${result}`);
                }
                infoModal.modal('show');
            });


            $('.closeModal').on('click', function (e) {
                $("#infoModal").modal("hide");
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/payout/log.blade.php ENDPATH**/ ?>