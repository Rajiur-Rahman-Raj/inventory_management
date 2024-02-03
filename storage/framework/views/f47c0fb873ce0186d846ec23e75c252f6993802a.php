<?php $__env->startSection('title',__('Recover Password')); ?>

<?php $__env->startSection('content'); ?>
    <!-- Forget Password Section -->
    <section class="login-section">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-lg-7">
                    <div class="img-box">
                        <img src="<?php echo e(asset($themeTrue.'img/login.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>" class="img-fluid" />
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-wrapper d-flex align-items-center h-100">
                        <div class="form-box">
                            <form action="<?php echo e(route('password.email')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <?php if(session('status')): ?>
                                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                                <?php echo e(trans(session('status'))); ?>

                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>
                                        <h4><?php echo app('translator')->get('Recover Password'); ?></h4>
                                    </div>
                                    <div class="input-box col-12">
                                        <input type="email"
                                               name="email"
                                               class="form-control"
                                               value="<?php echo e(old('email')); ?>"
                                               placeholder="<?php echo app('translator')->get('Enter Your Email Address'); ?>" />
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger mt-1"><?php echo e(trans($message)); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="input-box col-12">
                                        <button class="btn-custom" type="submit"><?php echo app('translator')->get('Submit'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/auth/passwords/email.blade.php ENDPATH**/ ?>