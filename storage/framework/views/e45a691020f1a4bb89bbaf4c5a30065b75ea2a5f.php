<?php $__env->startSection('title',trans('Add New Staff')); ?>

<?php $__env->startSection('content'); ?>
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Add New Staff'); ?></h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>

                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.role.staff')); ?>"><?php echo app('translator')->get('StaffList'); ?></a>
                                    </li>

                                    <li class="breadcrumb-item active"
                                        aria-current="page"><?php echo app('translator')->get('Create Staff'); ?></li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <a href="<?php echo e(route('user.role.staff')); ?>"
                               class="btn btn-custom text-white create__ticket">
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
                                <form action="<?php echo e(route('user.role.staffStore')); ?>" method="post"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">

                                        <div class="input-box col-md-6">
                                            <label for="role_id"><?php echo app('translator')->get('Role'); ?> </label>
                                            <select class="form-select js-example-basic-single"
                                                    name="role_id"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled><?php echo app('translator')->get('Select Role'); ?></option>
                                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($role->id); ?>" <?php echo e(old('role_id') == $role->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($role->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <?php if($errors->has('role_id')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('role_id')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="name"><?php echo app('translator')->get('Name'); ?></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="<?php echo app('translator')->get('Staff Name'); ?>"
                                                   value="<?php echo e(old('name')); ?>"/>
                                            <?php if($errors->has('name')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('name')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email"><?php echo app('translator')->get('Email'); ?> <span><sub>(optional)</sub></span></label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="<?php echo app('translator')->get('Email'); ?>"
                                                   value="<?php echo e(old('email')); ?>"/>
                                            <?php if($errors->has('email')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('email')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone"><?php echo app('translator')->get('Phone'); ?></label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="<?php echo app('translator')->get('Phone'); ?>"
                                                   class="form-control"
                                                   value="<?php echo e(old('phone')); ?>"/>
                                            <?php if($errors->has('phone')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('phone')); ?></div>
                                            <?php endif; ?>
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="username"><?php echo app('translator')->get('Username'); ?></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="username"
                                                   placeholder="<?php echo app('translator')->get('username'); ?>"
                                                   value="<?php echo e(old('username')); ?>"/>
                                            <?php if($errors->has('username')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('username')); ?></div>
                                            <?php endif; ?>
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="password"><?php echo app('translator')->get('password'); ?> <span
                                                    class="text-muted"> </span></label>
                                            <input type="text" name="password" placeholder="<?php echo app('translator')->get('password'); ?>"
                                                   class="form-control" value="<?php echo e(old('password')); ?>"/>
                                            <?php if($errors->has('password')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('password')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="" class="golden-text"><?php echo app('translator')->get('Photo'); ?> <span class="text-muted"> <sub>(optional)</sub></span> </label>
                                            <div class="attach-file">
                                               <span class="prev">
                                                  <?php echo app('translator')->get('Upload Photo'); ?>
                                               </span>
                                                <input type="file" name="image" class="form-control"/>
                                            </div>
                                            <?php $__errorArgs = ['image'];
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

                                        <div class="input-box col-md-6">
                                            <label for="status"><?php echo app('translator')->get('Status'); ?> </label>
                                            <select class="form-select js-example-basic-single" name="status"
                                                    aria-label="Default select example">
                                                <option
                                                    value="0" <?php echo e(old('status', @request()->status) == 0 ? 'selected' : ''); ?>> <?php echo app('translator')->get('Deactive'); ?> </option>
                                                <option
                                                    value="1" <?php echo e(old('status', @request()->status) == 1 ? 'selected' : ''); ?> selected> <?php echo app('translator')->get('Active'); ?> </option>
                                            </select>

                                            <?php if($errors->has('role_id')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('role_id')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit"><?php echo app('translator')->get('Create Staff'); ?></button>
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

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/role_permission/staffCreate.blade.php ENDPATH**/ ?>