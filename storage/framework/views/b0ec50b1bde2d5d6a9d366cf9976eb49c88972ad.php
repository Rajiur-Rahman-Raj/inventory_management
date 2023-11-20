<?php $__env->startSection('title',trans('Edit Company')); ?>


<?php $__env->startSection('content'); ?>
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Edit Company'); ?></h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Edit Company'); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="<?php echo e(route('user.companyList')); ?>" class="btn btn-custom text-white create__ticket">
                                <i class="fas fa-backward"></i> <?php echo app('translator')->get('Back'); ?></a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col">
                <!-- profile setting -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-12">
                            <div id="tab1" class="content active">
                                <form action="<?php echo e(route('user.companyUpdate', $singleCompany->id)); ?>" method="post" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name"><?php echo app('translator')->get('Name'); ?> <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="<?php echo app('translator')->get('Company Name'); ?>"
                                                   value="<?php echo e(old('name', $singleCompany->name)); ?>"/>
                                            <?php if($errors->has('name')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('name')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email"><?php echo app('translator')->get('Email'); ?> <span class="text-danger">*</span></label>
                                            <input type="email"
                                                   name="email"
                                                   placeholder="<?php echo app('translator')->get('Company Email'); ?>"
                                                   class="form-control"
                                                   value="<?php echo e(old('email', $singleCompany->email)); ?>"/>
                                            <?php if($errors->has('email')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('email')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone"><?php echo app('translator')->get('Phone Number'); ?> <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="<?php echo app('translator')->get('Company Number'); ?>"
                                                   value="<?php echo e(old('phone', $singleCompany->phone)); ?>"
                                                   class="form-control"/>
                                            <?php if($errors->has('phone')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('phone')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="trade_id"><?php echo app('translator')->get('Trade Id'); ?> <span class="text-muted"> <sup>(optional)</sup> </span></label>
                                            <input type="text" name="trade_id" placeholder="<?php echo app('translator')->get('Trade Id'); ?>"
                                                   class="form-control" value="<?php echo e(old('trade_id', $singleCompany->trade_id)); ?>"/>
                                            <?php if($errors->has('trade_id')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('trade_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="address"><?php echo app('translator')->get('Company Address'); ?> <span class="text-danger">*</span></label>
                                            <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                      cols="30" rows="3" placeholder="<?php echo app('translator')->get('Company Address'); ?>"
                                                      name="address"><?php echo e(old('address', $singleCompany->address)); ?></textarea>
                                            <?php if($errors->has('address')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('address')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-12 mb-4 input-box">
                                            <label for="" class="golden-text"><?php echo app('translator')->get('Company Logo'); ?> <span class="text-danger"></span></label>
                                            <div class="attach-file">
                                               <span class="prev">
                                                  <?php echo app('translator')->get('Upload Logo'); ?>
                                               </span>
                                                <input type="file" name="logo" class="form-control"/>
                                            </div>
                                            <?php $__errorArgs = ['logo'];
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

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100" type="submit"><?php echo app('translator')->get('Update Company'); ?></button>
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

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/company/edit.blade.php ENDPATH**/ ?>