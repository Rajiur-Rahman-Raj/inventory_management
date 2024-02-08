 
<?php $__env->startSection('title'); ?>
    <?php echo e($page_title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="bd-callout bd-callout-warning m-0 mb-4">
            <i class="fas fa-info-circle mr-2"></i> <?php echo app('translator')->get("N.B: Pull up or down the rows to sort the ranking list order that how do you want to display the ranking in admin and user panel."); ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <table class="table table-light-border table-md">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                <?php if(adminAccessRoute(config('role.payment_settings.access.edit'))): ?>
                                    <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            <?php if(count($methods) > 0): ?>
                                <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-code="<?php echo e($method->code); ?>">
                                        <td data-label="<?php echo app('translator')->get('Name'); ?>">
                                            <div class="d-flex no-block align-items-center">
                                                <div class="mr-3">
                                                    <img src="<?php echo e(getFile(config('location.gateway.path').$method->image)); ?>" alt="<?php echo e($method->name); ?>" class="rounded-circle" width="45" height="45">
                                                </div>
                                                <div class="mr-3">
                                                    <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo e($method->name); ?></h5>
                                                </div>
                                            </div>

                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Status'); ?>">

                                            <?php echo $method->status == 1 ? '<span class="custom-badge bg-success badge-sm">'.trans('Active').'</span>' : '<span class="custom-badge bg-danger badge-sm">'.trans('Inactive').'</span>'; ?>

                                        </td>
                                        <?php if(adminAccessRoute(config('role.payment_settings.access.edit'))): ?>
                                        <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                            <a href="<?php echo e(route('admin.edit.payment.methods', $method->id)); ?>"
                                               class="btn btn-outline-primary btn-rounded btn-sm"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               data-original-title="<?php echo app('translator')->get('Edit this Payment Methods info'); ?>">
                                                <i class="fa fa-edit"></i></a>
                                            <button type="button"
                                                    data-code="<?php echo e($method->code); ?>"
                                                    data-status="<?php echo e($method->status); ?>"
                                                    data-message="<?php echo e(($method->status == 0)?'Enable':'Disable'); ?>"
                                                    class="btn btn-sm btn-rounded btn-<?php echo e(($method->status == 0)?'outline-success':'outline-danger'); ?> disableBtn"
                                                    data-toggle="modal" data-target="#disableModal" ><i class="fa fa-<?php echo e(($method->status == 0)?'check':'ban'); ?>"></i>
                                            </button>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td class="text-center text-na" colspan="100%">
                                        <?php echo app('translator')->get('No Data Found'); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <div id="disableModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><span class="messageShow"></span> <?php echo app('translator')->get('Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.payment.methods.deactivate')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p class="font-weight-bold"><?php echo app('translator')->get('Are you sure to'); ?> <span class="messageShow"></span> <?php echo e(trans('this?')); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn waves-effect waves-light btn-danger btn-rounded" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn waves-effect waves-light btn-primary btn-rounded messageShow"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/jquery-ui.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/jquery-ui.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $("#sortable").sortable({
                update: function (event, ui) {
                    var methods = [];
                    $('#sortable tr').each(function (key, val) {
                        let methodCode = $(val).data('code');
                        methods.push(methodCode);
                    });

                    $.ajax({
                        'url': "<?php echo e(route('admin.sort.payment.methods')); ?>",
                        'method': "POST",
                        'data': {sort: methods}
                    })
                }
            });
            $("#sortable").disableSelection();
        });


        $('.disableBtn').on('click', function () {
            var status  = $(this).data('status');
            $('.messageShow').text($(this).data('message'));
            var modal = $('#disableModal');
            modal.find('input[name=code]').val($(this).data('code'));
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/admin/payment_methods/index.blade.php ENDPATH**/ ?>