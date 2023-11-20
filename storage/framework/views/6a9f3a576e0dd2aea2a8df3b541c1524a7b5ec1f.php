<?php $__env->startSection('title',__($page_title)); ?>

<?php $__env->startSection('content'); ?>
    <section class="transaction-history profile-setting">
        <div class="container-fluid">
            <div class="row mt-4 mb-2">
                <div class="col">
                    <div class="header-text-full ms-2">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Create New Ticket'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active " aria-current="page"><?php echo e(trans($page_title)); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-lg-12">
                <div class="sidebar-wrapper">
                    <div class="edit-area">
                        <form action="<?php echo e(route('user.ticket.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12 mb-4 input-box">
                                    <label for="subject" class="golden-text"><?php echo app('translator')->get('Subject'); ?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="subject"
                                        name="subject" value="<?php echo e(old('subject')); ?>" placeholder="<?php echo app('translator')->get('Enter Subject'); ?>"
                                    />
                                    <?php $__errorArgs = ['subject'];
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

                                <div class="col-12 mb-4 input-box">
                                    <label for="message" class="golden-text"><?php echo app('translator')->get('Message'); ?></label>
                                    <textarea
                                        class="form-control ticket-box"
                                        id="message"
                                        name="message"
                                        rows="5"
                                        placeholder="<?php echo app('translator')->get('Enter Message'); ?>"
                                    ><?php echo e(old('message')); ?></textarea>
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

                                <div class="col-12 mb-4 input-box">
                                    <label for="" class="golden-text"><?php echo app('translator')->get('Upload File'); ?></label>
                                    <div class="attach-file">
                           <span class="prev">
                              <?php echo app('translator')->get('Upload File'); ?>
                           </span>
                                        <input
                                            type="file"
                                            name="attachments[]"
                                            multiple
                                            class="form-control"
                                        />
                                    </div>
                                    <?php $__errorArgs = ['attachments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e(trans($message)); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <button type="submit" class="btn-custom"><?php echo app('translator')->get('Create'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/support/create.blade.php ENDPATH**/ ?>