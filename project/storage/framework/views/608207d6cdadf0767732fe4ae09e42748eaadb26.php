<?php $__env->startSection('title',__($page_title)); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="main row" id="supportTicketView">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">
                        <span class="ticket-span-view">
                            <?php if($ticket->status == 0): ?>
                                <span class="badge rounded-pill bg-primary"><?php echo app('translator')->get('Open'); ?></span>
                            <?php elseif($ticket->status == 1): ?>
                                <span class=" badge rounded-pill bg-success"><?php echo app('translator')->get('Answered'); ?></span>
                            <?php elseif($ticket->status == 2): ?>
                                <span class="badge rounded-pill bg-dark"><?php echo app('translator')->get('Customer Reply'); ?></span>
                            <?php elseif($ticket->status == 3): ?>
                                <span class="badge rounded-pill bg-danger"><?php echo app('translator')->get('Closed'); ?></span>
                            <?php endif; ?>
                        </span>
                        <?php echo e(trans('Ticket #'). $ticket->ticket); ?> [<?php echo e($ticket->subject); ?>]

                    </h4>
                    <div class="col-sm-2 text-sm-right mt-sm-0 mt-3">
                        <button type="button" class="btn btn-sm btn-danger btn-rounded float-end"
                                data-bs-toggle="modal"
                                data-bs-target="#closeTicketModal"><i
                                class="fas fa-times-circle"></i> <?php echo e(trans('Close')); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-12 col-12 ps-4 pe-4">
                <div class="my-search-bar p-0">
                    <form action="<?php echo e(route('user.ticket.reply', $ticket->id)); ?>" method="post"
                          enctype="multipart/form-data" class="p-0">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="basic-form ticket-reply-basic-form">
                            <div class="p-3">
                                <div class="row g-3">
                                    <div class="input-box col-md-12">
                                        <label><?php echo app('translator')->get('Message'); ?></label>
                                        <textarea class="form-control ticket-box" name="message" rows="5"
                                                  id="textarea1"
                                                  placeholder="<?php echo app('translator')->get('Type here'); ?>"><?php echo e(old('message')); ?></textarea>
                                        <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="error text-danger"><?php echo app('translator')->get($message); ?> </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="input-box col-md-12">
                                        <div
                                            class="justify-content-sm-end justify-content-start mt-sm-0 mt-2 align-items-center d-flex h-100">
                                            <div class="upload-btn">
                                                <div class="btn btn-primary new-file-upload mr-3 mt-3"
                                                     title="<?php echo e(trans('Image Upload')); ?>">
                                                    <a href="#">
                                                        <i class="fa fa-image"></i>
                                                    </a>
                                                    <input type="file" name="attachments[]" id="upload" class="upload-box"
                                                           multiple
                                                           placeholder="<?php echo app('translator')->get('Upload File'); ?>">
                                                </div>
                                                <p class="text-danger select-files-count"></p>
                                            </div>

                                            <button type="submit"
                                                    class="btn btn-circle btn-lg btn-success float-right text-white"
                                                    title="<?php echo e(trans('Reply')); ?>" name="replayTicket"
                                                    value="1"><i class="fas fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <?php if(count($ticket->messages) > 0): ?>
                                <div class="ticket-reply-section">
                                    <?php $__currentLoopData = $ticket->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($item->admin_id == null): ?>
                                            <div class="bug_fixing_inbox_start_new">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="bug_fixing_inbox_start__msg d-flex flex-column get_message_dropdown">
                                                            <div class="bug_fixing_inbox_start__msg__rec_msg me-auto d-flex user-product-message">
                                                                <div class="bug_fixing_inbox_start__msg__rec_msg__img">
                                                                </div>
                                                                <div class="bug_fixing_inbox_start__msg__rec_msg__text">
                                                                    <div class="bug_fixing_inbox_start__msg__rec_msg__text__one message">
                                                                        <div class="image__title d-flex align-items-center">
                                                                            <img src="<?php echo e(getFile(config('location.user.path').optional($ticket->user)->image)); ?>" class="ticket-user-img" class="me-2" alt="<?php echo app('translator')->get('not found'); ?>">
                                                                            <h6 class="m-0"><?php echo e(optional($ticket->user)->username); ?></h6>
                                                                        </div>

                                                                        <p class="m-0 ticket-user-name"> <?php echo e($item->message); ?> </p>
                                                                        <?php if(0 < count($item->attachments)): ?>
                                                                            <div class="d-flex justify-content-end">
                                                                                <?php $__currentLoopData = $item->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <a href="<?php echo e(route('user.ticket.download',encrypt($image->id))); ?>"
                                                                                       class="ml-3 nowrap ticket-file-icon"><i
                                                                                            class="fa fa-file"></i> <?php echo app('translator')->get('File'); ?> <?php echo e(++$k); ?>

                                                                                    </a>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div
                                                class="bug_fixing_inbox_start__msg__outgoing_msg d-flex flex-row-reverse">
                                                <div class="bug_fixing_inbox_start__msg__outgoing_msg__new border_down customer-product-message">
                                                    <div class="image__title d-flex  align-items-center">
                                                        <img src="<?php echo e(getFile(config('location.admin.path').optional($item->admin)->image)); ?>" class="me-2 ticket-user-img" >
                                                        <h6 class="m-0"><?php echo e(optional($item->admin)->name); ?></h6>
                                                    </div>

                                                    <p class="m-0 ticket-user-name"> <?php echo e($item->message); ?> </p>
                                                    <?php if(0 < count($item->attachments)): ?>
                                                        <div class="d-flex justify-content-start">
                                                            <?php $__currentLoopData = $item->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <a href="<?php echo e(route('user.ticket.download',encrypt($image->id))); ?>"
                                                                   class="mr-3 nowrap ticket-file-icon2"><i
                                                                        class="fa fa-file"></i> <?php echo app('translator')->get('File'); ?> <?php echo e(++$k); ?>

                                                                </a>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('loadModal'); ?>
        <div class="modal fade" id="closeTicketModal" tabindex="-1" aria-labelledby="addListingmodal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                        <h4 class="modal-title" id="editModalLabel"><?php echo app('translator')->get('Confirmation'); ?></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <form method="post" action="<?php echo e(route('user.ticket.reply', $ticket->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="modal-body">
                            <p><?php echo app('translator')->get('Are you want to close ticket?'); ?></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-custom close__btn" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button class="btn-custom" type="submit" name="replayTicket"
                                    value="2"><?php echo app('translator')->get('Confirm'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="planModalLabel"><?php echo app('translator')->get('Verify Your OTP to Disable'); ?></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <form action="<?php echo e(route('user.twoStepDisable')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="input-box col-12">
                                    <input type="text" class="form-control" name="code" placeholder="<?php echo app('translator')->get('Enter Google Authenticator Code'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn-danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button class="btn-custom" type="submit"><?php echo app('translator')->get('Verify'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function () {
            'use strict';
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            })

            $(document).on('change', '#upload', function () {
                var fileCount = $(this)[0].files.length;
                $('.select-files-count').text(fileCount + ' file(s) selected')
            })
        });
    </script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/support/view.blade.php ENDPATH**/ ?>