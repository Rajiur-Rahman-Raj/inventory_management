<?php $__env->startSection('title',__($page_title)); ?>

<?php $__env->startSection('content'); ?>
    <!-- Transfer Money -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2">
                <div class="col">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo e(trans($page_title)); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Balance Transfer'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col">
                <!-- Transfer Money -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-12">
                            <div id="tab1"
                                 class="content p-0 <?php echo e($errors->has('email') ? ' active' : (($errors->has('amount') || $errors->has('wallet_type') || $errors->has('password')) ? '' :  ' active')); ?>">
                                <form class="form-row" action="" method="post">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-12">
                                            <label for="firstname"><?php echo app('translator')->get('Receiver Email Address'); ?></label>
                                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo app('translator')->get('Receiver Email Address'); ?>" class="form-control" id="email"/>

                                            <?php $__errorArgs = ['email'];
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
                                            <label for="lastname"><?php echo app('translator')->get('Amount'); ?></label>
                                            <input type="text" name="amount" value="<?php echo e(old('amount')); ?>" placeholder="<?php echo app('translator')->get('Enter Amount'); ?>"  onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" id="lastname" class="form-control"/>

                                            <?php $__errorArgs = ['amount'];
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
                                            <label for="language_id"><?php echo app('translator')->get('Select Wallet'); ?></label>
                                            <select class="form-select"
                                                    name="wallet_type" id="wallet_type"
                                                    aria-label="Default select example">
                                                <option value="balance"><?php echo e(trans('Main balance')); ?></option>
                                                <option value="interest_balance"><?php echo e(trans('Interest Balance')); ?></option>
                                            </select>

                                            <?php $__errorArgs = ['wallet_type'];
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
                                            <label for="email"><?php echo app('translator')->get('Enter Password'); ?></label>
                                            <input type="password" name="password" value="<?php echo e(old('password')); ?>" placeholder="<?php echo app('translator')->get('Your Password'); ?>"
                                                   class="form-control"/>
                                            <?php $__errorArgs = ['password'];
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

                                        <div class="input-box col-12">
                                            <button class="btn-custom" type="submit"><?php echo app('translator')->get('Transfer'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/themes/original/user/money-transfer.blade.php ENDPATH**/ ?>