<?php $__env->startSection('title',__($title)); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-4 shadow">
        <form action="<?php echo e(route('admin.ticket')); ?>" method="get">
            <div class="row justify-content-between align-items-center">

                <div class="col-md-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="name"><?php echo app('translator')->get('Filter By User'); ?></label>
                        <input type="text" name="name" value="<?php echo e(@request()->name); ?>" class="form-control"
                               placeholder="<?php echo app('translator')->get('User name'); ?>">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4 col-12">
                    <div class="form-group">
                        <label for="user"><?php echo app('translator')->get('Ticket Id'); ?></label>
                        <input type="text" name="ticket_id" value="<?php echo e(@request()->ticket_id); ?>" class="form-control"
                               placeholder="<?php echo app('translator')->get('Ticket no'); ?>">
                    </div>
                </div>


                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <label><?php echo app('translator')->get('Ticket Status'); ?></label>
                        <select name="status" class="form-control">
                            <option value=""><?php echo app('translator')->get('All Ticket'); ?></option>
                            <option value="0"
                                    <?php if(@request()->status == '0'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Open Ticket'); ?></option>
                            <option value="1"
                                    <?php if(@request()->status == '1'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Answered Ticket'); ?></option>
                            <option value="2"
                                    <?php if(@request()->status == '2'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Replied Ticket'); ?></option>
                            <option value="3"
                                    <?php if(@request()->status == '3'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Closed Ticket'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4 col-12">
                    <label for="from_date"><?php echo app('translator')->get('From Date'); ?></label>
                    <input type="date" class="form-control from_date" name="from_date" value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>" autocomplete="off"/>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <label for="to_date" class="to_date_margin"><?php echo app('translator')->get('To Date'); ?></label>
                    <input type="date" class="form-control to_date" name="to_date" value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>" autocomplete="off" disabled="true"/>
                </div>


                <div class="col-lg-4 col-md-4 col-12">
                    <label class="opacity-0"><?php echo app('translator')->get('...'); ?></label>
                    <button type="submit" class="btn waves-effect w-100 waves-light btn-primary btn-rounded"><i
                            class="fas fa-search"></i> <?php echo app('translator')->get('Search'); ?></button>
                </div>
            </div>
        </form>

    </div>


    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('Ticket Id'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('User'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Subject'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Last Reply'); ?></th>
                        <?php if(adminAccessRoute(config('role.support_ticket.access.view')) || adminAccessRoute(config('role.support_ticket.access.delete'))): ?>
                        <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="Ticket Id">
                                <a href="<?php echo e(route('admin.ticket.view', $ticket->id)); ?>" class="font-weight-bold"
                                   target="_blank">
                                    <?php echo e(trans('#').$ticket->ticket); ?> </a>
                            </td>

                            <td data-label="Submitted By">
                                <?php if($ticket->user_id): ?>
                                    <a href="<?php echo e(route('admin.user-edit',[$ticket->user_id])); ?>" target="_blank">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="mr-3"><img src="<?php echo e(getFile(config('location.user.path').optional($ticket->user)->image)); ?>" alt="user" class="rounded-circle" width="45" height="45">
                                            </div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">
                                                    <?php echo app('translator')->get(optional($ticket->user)->firstname); ?> <?php echo app('translator')->get(optional($ticket->user)->lastname); ?>
                                                </h5>
                                                <span class="text-muted font-14"><span>@</span><?php echo app('translator')->get(optional($ticket->user)->username); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <p class="font-weight-bold"> <?php echo e($ticket->name); ?></p>
                                <?php endif; ?>
                            </td>

                            <td data-label="Subject">
                                <a href="<?php echo e(route('admin.ticket.view', $ticket->id)); ?>" class="font-weight-bold"
                                   target="_blank">
                                    <?php echo app('translator')->get($ticket->subject); ?></a>
                            </td>


                            <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                <?php if($ticket->status == 0): ?>
                                    <span class="custom-badge badge-pill bg-success"><?php echo app('translator')->get('Open'); ?></span>
                                <?php elseif($ticket->status == 1): ?>
                                    <span class="custom-badge badge-pill bg-primary"><?php echo app('translator')->get('Answered'); ?></span>
                                <?php elseif($ticket->status == 2): ?>
                                    <span
                                        class="custom-badge badge-pill bg-warning"><?php echo app('translator')->get('Customer Reply'); ?></span>
                                <?php elseif($ticket->status == 3): ?>
                                    <span class="custom-badge badge-pill badge-dark"><?php echo app('translator')->get('Closed'); ?></span>
                                <?php endif; ?>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Last Reply'); ?>">
                                <?php echo e(diffForHumans($ticket->last_reply)); ?>

                            </td>

                            <?php if(adminAccessRoute(config('role.support_ticket.access.view')) || adminAccessRoute(config('role.support_ticket.access.delete'))): ?>
                            <td data-label="Action">
                                <?php if(adminAccessRoute(config('role.support_ticket.access.view'))): ?>
                                <a href="<?php echo e(route('admin.ticket.view', $ticket->id)); ?>"
                                   class="btn btn-sm btn-rounded btn-outline-info"
                                   data-toggle="tooltip" title="" data-original-title="Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(adminAccessRoute(config('role.support_ticket.access.delete'))): ?>
                                <button type="button" class="btn btn-sm btn-rounded btn-outline-danger notiflix-confirm"
                                        data-toggle="modal" data-target="#delete-modal"
                                        data-route="<?php echo e(route('admin.ticket.delete', $ticket->id)); ?>">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="100%">
                                <p class="text-center text-na"><?php echo app('translator')->get($empty_message); ?></p>
                            </td>
                        </tr>

                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($tickets->appends($_GET)->links('partials.pagination')); ?>

            </div>
        </div>
    </div>

    <!-- Delete Modal -->
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
                    <button type="button" class="btn btn-danger btn-rounded"
                            data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="deleteRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button type="submit" class="btn btn-primary btn-rounded"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        'use strict'
        $('.from_date').on('change', function (){
            $('.to_date').removeAttr('disabled');
        });

        $('.notiflix-confirm').on('click', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/admin/ticket/index.blade.php ENDPATH**/ ?>