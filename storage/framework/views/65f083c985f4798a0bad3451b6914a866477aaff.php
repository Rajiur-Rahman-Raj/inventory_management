<?php $__env->startSection('title',trans('Create Sales Center')); ?>

<?php $__env->startSection('content'); ?>
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Create Sales Center'); ?></h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page"><?php echo app('translator')->get('Create Sales Center'); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="<?php echo e(route('user.salesCenterList')); ?>"
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
                                <form action="<?php echo e(route('user.storeSalesCenter')); ?>" method="post"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-4">
                                            <label for="name"><?php echo app('translator')->get('Center Name'); ?> </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="<?php echo app('translator')->get('Sales Center Name'); ?>"
                                                   value="<?php echo e(old('name')); ?>"/>
                                            <?php if($errors->has('name')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('name')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-4">
                                            <label for="name"><?php echo app('translator')->get('Code'); ?> </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="code"
                                                   placeholder="<?php echo app('translator')->get('Sales Center code'); ?>"
                                                   value="<?php echo e(old('code')); ?>"/>
                                            <?php if($errors->has('name')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('name')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-4">
                                            <label for="name"><?php echo app('translator')->get('Discount'); ?> </label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" aria-label="" name="discount_percent" placeholder="discount" value="5">
                                                <span class="input-group-text">%</span>
                                                <?php if($errors->has('discount_percent')): ?>
                                                    <div class="error text-danger"><?php echo app('translator')->get($errors->first('discount_percent')); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="center_address"><?php echo app('translator')->get('Center Location'); ?> </label>
                                            <textarea class="form-control <?php $__errorArgs = ['center_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                      cols="30" rows="3" placeholder="<?php echo app('translator')->get('Sales Center Address'); ?>"
                                                      name="center_address" value="<?php echo e(old('center_address')); ?>"><?php echo e(old('center_address')); ?></textarea>
                                            <?php if($errors->has('center_address')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('center_address')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="owner_name"><?php echo app('translator')->get('Owner Name'); ?></label>
                                            <input type="text"
                                                   name="owner_name"
                                                   placeholder="<?php echo app('translator')->get('Owner Name'); ?>"
                                                   class="form-control"
                                                   value="<?php echo e(old('owner_name')); ?>"/>
                                            <?php if($errors->has('owner_name')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('owner_name')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone"><?php echo app('translator')->get('Phone'); ?></label>
                                            <input type="text"
                                                   name="phone"
                                                   placeholder="<?php echo app('translator')->get('Owner Phone Number'); ?>"
                                                   value="<?php echo e(old('phone')); ?>"
                                                   class="form-control"/>
                                            <?php if($errors->has('phone')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('phone')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-4">
                                            <label for="email"><?php echo app('translator')->get('Email'); ?></label>
                                            <input type="email"
                                                   name="email"
                                                   placeholder="<?php echo app('translator')->get('Owner Email'); ?>"
                                                   value="<?php echo e(old('email')); ?>"
                                                   class="form-control"/>
                                            <?php if($errors->has('email')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('email')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-4">
                                            <label for="username"><?php echo app('translator')->get('Username'); ?> </label>
                                            <input type="test"
                                                   name="username"
                                                   placeholder="<?php echo app('translator')->get('username'); ?>"
                                                   value="<?php echo e(old('username')); ?>"
                                                   class="form-control"/>
                                            <?php if($errors->has('username')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('username')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-4">
                                            <label for="password"><?php echo app('translator')->get('Password'); ?> </label>
                                            <input type="password"
                                                   name="password"
                                                   placeholder="<?php echo app('translator')->get('password'); ?>"
                                                   value="<?php echo e(old('password')); ?>"
                                                   class="form-control"/>
                                            <?php if($errors->has('password')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('password')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="national_id"><?php echo app('translator')->get('National Id'); ?> <span class="text-muted"> <sub>(optional)</sub></span></label>
                                            <input type="text" name="national_id" placeholder="<?php echo app('translator')->get('National Id'); ?>"
                                                   class="form-control" value="<?php echo e(old('national_id')); ?>"/>
                                            <?php if($errors->has('national_id')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('national_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="trade_id"><?php echo app('translator')->get('Trade Id'); ?> <span class="text-muted"> <sub>(optional)</sub></span></label>
                                            <input type="text" name="trade_id" placeholder="<?php echo app('translator')->get('Trade Id'); ?>"
                                                   class="form-control" value="<?php echo e(old('trade_id')); ?>"/>
                                            <?php if($errors->has('trade_id')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('trade_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="division_id"><?php echo app('translator')->get('Division'); ?></label>
                                            <select class="form-select js-example-basic-single selectedDivision"
                                                    name="division_id"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled><?php echo app('translator')->get('Select Division'); ?></option>
                                                <?php $__currentLoopData = $allDivisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($division->id); ?>" <?php echo e(old('division_id') == $division->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($division->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            <?php if($errors->has('division_id')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('division_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="district_id"><?php echo app('translator')->get('District'); ?> </label>
                                            <select class="form-select js-example-basic-single selectedDistrict"
                                                    name="district_id"
                                                    aria-label="Default select example"
                                                    data-olddistrictid="<?php echo e(old('district_id')); ?>">
                                            </select>

                                            <?php if($errors->has('district_id')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('district_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="district_id"><?php echo app('translator')->get('Upazila'); ?> <span class="text-muted"> <sub>(optional)</sub></span></label>
                                            <select class="form-select js-example-basic-single selectedUpazila"
                                                    name="upazila_id"
                                                    aria-label="Default select example"
                                                    data-oldupazilaid="<?php echo e(old('upazila_id')); ?>">
                                            </select>

                                            <?php if($errors->has('upazila_id')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('upazila_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="union_id"><?php echo app('translator')->get('Union'); ?> <span class="text-muted"> <sub>(optional)</sub></span></label>
                                            <select class="form-select js-example-basic-single selectedUnion"
                                                    name="union_id"
                                                    aria-label="Default select example"
                                                    data-oldunionid="<?php echo e(old('union_id')); ?>">
                                            </select>

                                            <?php if($errors->has('union_id')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('union_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="owner_address"><?php echo app('translator')->get('Owner Address'); ?> </label>
                                            <textarea class="form-control <?php $__errorArgs = ['owner_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                      cols="30" rows="3" placeholder="<?php echo app('translator')->get('Owner Address'); ?>"
                                                      name="owner_address" value="<?php echo e(old('owner_address')); ?>"><?php echo e(old('owner_address')); ?></textarea>
                                            <?php if($errors->has('owner_address')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('owner_address')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-12 mb-4 input-box">
                                            <label for="" class="golden-text"><?php echo app('translator')->get('Owner Photo'); ?> <span class="text-muted"> <sub>(optional)</sub></span> </label>
                                            <div class="attach-file">
                                               <span class="prev">
                                                  <?php echo app('translator')->get('Upload Logo'); ?>
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

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit"><?php echo app('translator')->get('Create Sales Center'); ?></button>
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
    <?php echo $__env->make($theme.'user.partials.locationJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/salesCenter/create.blade.php ENDPATH**/ ?>