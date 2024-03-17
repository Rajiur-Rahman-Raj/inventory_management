<?php $__env->startSection('title',trans('Edit Employee')); ?>

<?php $__env->startPush('style'); ?>
    <link href="<?php echo e(asset('assets/global/css/flatpickr.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Edit Employee'); ?></h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Edit Employee'); ?></li>
                                </ol>
                            </nav>
                        </div>

                        <div>
                            <a href="<?php echo e(route('user.employeeList')); ?>"
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
                                <form action="<?php echo e(route('user.employeeUpdate', $singleEmployeeInfo->id)); ?>" method="post"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name"><?php echo app('translator')->get('Name'); ?> </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="<?php echo app('translator')->get('Employee Name'); ?>"
                                                   value="<?php echo e(old('name', $singleEmployeeInfo->name)); ?>"/>
                                            <?php if($errors->has('name')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('name')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="phone"><?php echo app('translator')->get('Phone'); ?> </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="phone"
                                                   placeholder="<?php echo app('translator')->get('Phone Number'); ?>"
                                                   value="<?php echo e(old('phone', $singleEmployeeInfo->phone)); ?>"/>
                                            <?php if($errors->has('phone')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('phone')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="email"><?php echo app('translator')->get('Email'); ?> </label>
                                            <input type="email"
                                                   class="form-control"
                                                   name="email"
                                                   placeholder="<?php echo app('translator')->get('Email Address'); ?>"
                                                   value="<?php echo e(old('email', $singleEmployeeInfo->email)); ?>"/>
                                            <?php if($errors->has('email')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('email')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="national_id"><?php echo app('translator')->get('National Id'); ?> <span
                                                    class="text-muted"> <sub>(optional)</sub></span></label>
                                            <input type="text" name="national_id" placeholder="<?php echo app('translator')->get('National Id'); ?>"
                                                   class="form-control" value="<?php echo e(old('national_id', $singleEmployeeInfo->national_id)); ?>"/>
                                            <?php if($errors->has('national_id')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('national_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="date_of_birth"><?php echo app('translator')->get('Date of Birth'); ?> <span
                                                    class="text-dark"><sub>(optional)</sub></span></label>
                                            <div class="flatpickr">
                                                <div class="input-group">
                                                    <input type="date"
                                                           placeholder="<?php echo app('translator')->get('select date'); ?>"
                                                           class="form-control date_of_birth"
                                                           name="date_of_birth"
                                                           value="<?php echo e(old('date_of_birth',$singleEmployeeInfo->date_of_birth)); ?>"
                                                           data-input>
                                                    <div class="input-group-append"
                                                         readonly="">
                                                        <div
                                                            class="form-control">
                                                            <a class="input-button cursor-pointer"
                                                               title="clear" data-clear>
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback d-block">
                                                        <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="joining_date"><?php echo app('translator')->get('Joining Date'); ?> <span
                                                    class="text-dark"></span></label>
                                            <div class="flatpickr">
                                                <div class="input-group">
                                                    <input type="date"
                                                           placeholder="<?php echo app('translator')->get('select date'); ?>"
                                                           class="form-control joining_date"
                                                           name="joining_date"
                                                           value="<?php echo e(old('joining_date',$singleEmployeeInfo->joining_date)); ?>"
                                                           data-input>
                                                    <div class="input-group-append"
                                                         readonly="">
                                                        <div
                                                            class="form-control">
                                                            <a class="input-button cursor-pointer"
                                                               title="clear" data-clear>
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback d-block">
                                                        <?php $__errorArgs = ['joining_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="designation"><?php echo app('translator')->get('Designation'); ?> </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="designation"
                                                   placeholder="<?php echo app('translator')->get('Employee Designation'); ?>"
                                                   value="<?php echo e(old('designation', $singleEmployeeInfo->designation)); ?>"/>
                                            <?php if($errors->has('designation')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('designation')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="employee_type"><?php echo app('translator')->get('Employment Type'); ?> </label>
                                            <select class="form-select js-example-basic-single"
                                                    name="employee_type"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled><?php echo app('translator')->get('Select Employee Type'); ?></option>
                                                <option value="1" <?php echo e(old('employee_type', $singleEmployeeInfo->employee_type) == 1 ? 'selected' : ''); ?>> <?php echo app('translator')->get('Full Time'); ?> </option>
                                                <option value="2" <?php echo e(old('employee_type', $singleEmployeeInfo->employee_type) == 2 ? 'selected' : ''); ?>> <?php echo app('translator')->get('Part Time'); ?> </option>
                                            </select>

                                            <?php if($errors->has('employee_type')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('employee_type')); ?></div>
                                            <?php endif; ?>
                                        </div>


                                        <div class="input-box col-md-6">
                                            <label for="joining_salary"> <?php echo app('translator')->get('Joining Salary'); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="joining_salary"
                                                       class="form-control <?php $__errorArgs = ['joining_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       value="<?php echo e(old('joining_salary', $singleEmployeeInfo->joining_salary)); ?>">
                                                <div class="input-group-append" readonly="">
                                                    <div class="form-control currency_symbol append_group">
                                                        <?php echo e($basic->currency_symbol); ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invalid-feedback">
                                                <?php $__errorArgs = ['joining_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="current_salary"> <?php echo app('translator')->get('Current Salary'); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="current_salary"
                                                       class="form-control <?php $__errorArgs = ['current_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       value="<?php echo e(old('current_salary', $singleEmployeeInfo->current_salary)); ?>">
                                                <div class="input-group-append" readonly="">
                                                    <div class="form-control currency_symbol append_group">
                                                        <?php echo e($basic->currency_symbol); ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invalid-feedback">
                                                <?php $__errorArgs = ['current_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>


                                        <div class="input-box col-12">
                                            <label for="present_address"><?php echo app('translator')->get('Present Address'); ?> </label>
                                            <textarea
                                                class="form-control <?php $__errorArgs = ['present_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                cols="30" rows="3" placeholder="<?php echo app('translator')->get('Present Address'); ?>"
                                                name="present_address"
                                                value="<?php echo e(old('present_address', $singleEmployeeInfo->present_address)); ?>"><?php echo e(old('present_address', $singleEmployeeInfo->present_address)); ?></textarea>
                                            <?php if($errors->has('present_address')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('present_address')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <label for="permanent_address"><?php echo app('translator')->get('Permanent Address'); ?> </label>
                                            <textarea
                                                class="form-control <?php $__errorArgs = ['permanent_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                cols="30" rows="3" placeholder="<?php echo app('translator')->get('Permanent Address'); ?>"
                                                name="permanent_address"
                                                value="<?php echo e(old('permanent_address', $singleEmployeeInfo->permanent_address)); ?>"><?php echo e(old('permanent_address', $singleEmployeeInfo->permanent_address)); ?></textarea>
                                            <?php if($errors->has('permanent_address')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('permanent_address')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-6 mb-4 input-box">
                                            <label for="" class="golden-text"><?php echo app('translator')->get('Employee Photo'); ?> <span
                                                    class="text-muted"> <sub>(optional)</sub></span> </label>
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
                                            <select class="form-select js-example-basic-single"
                                                    name="status"
                                                    aria-label="Default select example">
                                                <option value="1" <?php echo e(old('status', $singleEmployeeInfo->status) == 1 ? 'selected' : ''); ?>> <?php echo app('translator')->get('Active'); ?> </option>
                                                <option value="0" <?php echo e(old('status', $singleEmployeeInfo->status) == 2 ? 'selected' : ''); ?>> <?php echo app('translator')->get('Deactive'); ?> </option>
                                            </select>

                                            <?php if($errors->has('status')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('status')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom w-100"
                                                    type="submit"><?php echo app('translator')->get('Create Employee'); ?></button>
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
    <script src="<?php echo e(asset('assets/global/js/flatpickr.js')); ?>"></script>
    <?php echo $__env->make($theme.'user.partials.locationJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        'use strict'
        $(".flatpickr").flatpickr({
            wrap: true,
            altInput: true,
            dateFormat: "Y-m-d H:i",
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/employee/edit.blade.php ENDPATH**/ ?>