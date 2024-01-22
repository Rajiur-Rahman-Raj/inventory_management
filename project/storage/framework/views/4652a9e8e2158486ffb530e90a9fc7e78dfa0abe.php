<?php $__env->startSection('title',trans('Profile Settings')); ?>

<?php $__env->startPush('css-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrapicons-iconpicker.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2">
                <div class="col">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1"><?php echo app('translator')->get('Profile Settings'); ?></h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('Profile'); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col">
                <!-- profile setting -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-4">
                            <div class="sidebar-wrapper">
                                <div class="profile">
                                    <div class="img">
                                        <img id="profile" src="<?php echo e(getFile(config('location.user.path'). $user->image)); ?>"
                                             alt="<?php echo app('translator')->get('not found'); ?>" class="img-fluid profile-image-preview"/>
                                        <button class="upload-img">
                                            <i class="fal fa-camera"></i>
                                            <input
                                                class="form-control" id="userPorfileImage" name="image"
                                                accept="image/*" type="file"/>
                                        </button>
                                    </div>
                                    <div class="text">
                                        <h5 class="name"><?php echo app('translator')->get($user->fullname); ?></h5>
                                        <span><?php echo app('translator')->get($user->email); ?></span>
                                    </div>
                                </div>
                                <div class="profile-navigator">
                                    <button tab-id="tab1"
                                            class="tab <?php echo e($errors->has('profile') ? 'active' : (($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification')) ? '' : ' active')); ?>">
                                        <i class="fal fa-user"></i> <?php echo app('translator')->get('Profile information'); ?>
                                    </button>
                                    <button tab-id="tab2" class="tab <?php echo e($errors->has('password') ? 'active' : ''); ?>">
                                        <i class="fal fa-key"></i> <?php echo app('translator')->get('Password setting'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="tab1"
                                 class="content <?php echo e($errors->has('profile') ? ' active' : (($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification')) ? '' :  ' active')); ?>">
                                <form action="<?php echo e(route('user.updateInformation')); ?>" method="post">
                                    <?php echo method_field('put'); ?>
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="firstname"><?php echo app('translator')->get('First Name'); ?></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="firstname"
                                                   id="firstname"
                                                   placeholder="<?php echo app('translator')->get('first name'); ?>"
                                                   value="<?php echo e(old('firstname')?: $user->firstname); ?>"/>
                                            <?php if($errors->has('firstname')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('firstname')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="lastname"><?php echo app('translator')->get('Last Name'); ?></label>
                                            <input type="text"
                                                   id="lastname"
                                                   name="lastname"
                                                   placeholder="<?php echo app('translator')->get('last name'); ?>"
                                                   class="form-control"
                                                   value="<?php echo e(old('lastname')?: $user->lastname); ?>"/>
                                            <?php if($errors->has('lastname')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('lastname')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="username"><?php echo app('translator')->get('Username'); ?></label>
                                            <input type="text"
                                                   id="username"
                                                   name="username"
                                                   placeholder="<?php echo app('translator')->get('username'); ?>"
                                                   value="<?php echo e(old('username')?: $user->username); ?>"
                                                   class="form-control"/>
                                            <?php if($errors->has('username')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('username')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="email"><?php echo app('translator')->get('Email Address'); ?></label>
                                            <input type="email"
                                                   id="email"
                                                   placeholder="<?php echo app('translator')->get('email'); ?>"
                                                   value="<?php echo e($user->email); ?>"
                                                   readonly
                                                   class="form-control"/>
                                            <?php if($errors->has('email')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('email')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="phone"><?php echo app('translator')->get('Phone Number'); ?></label>
                                            <input type="text"
                                                   id="phone"
                                                   placeholder="<?php echo app('translator')->get('phone'); ?>"
                                                   readonly
                                                   class="form-control"
                                                   value="<?php echo e(old('phone', $user->phone)); ?>"/>
                                            <?php if($errors->has('phone')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('phone')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="language_id"><?php echo app('translator')->get('Preferred language'); ?></label>
                                            <select class="form-select"
                                                    name="language_id"
                                                    id="language_id"
                                                    aria-label="Default select example">
                                                <option value="" disabled><?php echo app('translator')->get('Select Language'); ?></option>
                                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $la): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($la->id); ?>" <?php echo e(old('language_id', $user->language_id) == $la->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($la->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php if($errors->has('language_id')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('language_id')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-12">
                                            <label for=""><?php echo app('translator')->get('Address'); ?></label>
                                            <input
                                                class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="address"
                                                name="address"
                                                type="text"
                                                placeholder="<?php echo app('translator')->get('address'); ?>"
                                                value="<?php echo e(old('address', $user->address)); ?>"/>
                                            <?php if($errors->has('address')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('address')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Bio'); ?></label>
                                            <textarea
                                                class="form-control <?php $__errorArgs = ['Bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                cols="30"
                                                rows="3"
                                                placeholder="<?php echo app('translator')->get('bio'); ?>"
                                                name="bio"><?php echo app('translator')->get($user->bio); ?></textarea>
                                            <?php if($errors->has('bio')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('bio')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <label for=""><?php echo app('translator')->get('Social Links'); ?></label>
                                            <div class="form website_social_links">
                                                <?php
                                                    $oldSocialCounts = max(old('social_icon', $social_links) ? count(old('social_icon', $social_links)) : 1, 1);
                                                ?>

                                                <?php if($oldSocialCounts > 0): ?>
                                                    <?php for($i = 0; $i < $oldSocialCounts; $i++): ?>
                                                        <div
                                                            class="d-flex justify-content-between append_new_social_form removeSocialLinksInput">
                                                            <div class="input-group mt-1">
                                                                <input type="text" name="social_icon[]" value="<?php echo e(old("social_icon.$i", $social_links[$i]->social_icon ?? '')); ?>" class="form-control demo__icon__picker iconpicker1 <?php $__errorArgs = ["social_icon.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Pick a icon" aria-label="Pick a icon"
                                                                       aria-describedby="basic-addon1" readonly>

                                                                <div class="invalid-feedback">
                                                                    <?php $__errorArgs = ["social_icon.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>

                                                            <div class="input-box w-100 my-1 me-1">
                                                                <input type="url" name="social_url[]"
                                                                       value="<?php echo e(old("social_url.$i", $social_links[$i]->social_url ?? '')); ?>"
                                                                       class="form-control <?php $__errorArgs = ["social_url.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                       placeholder="<?php echo app('translator')->get('URL'); ?>"/>
                                                                <?php $__errorArgs = ["social_url.$i"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <span class="text-danger"><?php echo e($message); ?></span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                                            </div>
                                                            <div class="my-1 me-1">
                                                                <?php if($i == 0): ?>
                                                                    <button class="btn-custom add-new" type="button"
                                                                            id="add_social_links">
                                                                        <i class="fal fa-plus"></i>
                                                                    </button>
                                                                <?php else: ?>
                                                                    <button
                                                                        class="btn-custom add-new btn-custom-danger remove_social_link_input_field"
                                                                        type="button">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endfor; ?>
                                                <?php endif; ?>

                                                <div class="new_social_links_form append_new_social_form">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom" type="submit"><?php echo app('translator')->get('Update User'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="tab2" class="content <?php echo e($errors->has('password') ? 'active' : ''); ?>">
                                <form method="post" action="<?php echo e(route('user.updatePassword')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for=""><?php echo app('translator')->get('Current Password'); ?></label>
                                            <input type="password"
                                                   id="current_password"
                                                   name="current_password"
                                                   autocomplete="off"
                                                   class="form-control"
                                                   placeholder="<?php echo app('translator')->get('Enter Current Password'); ?>"/>
                                            <?php if($errors->has('current_password')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('current_password')); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for=""><?php echo app('translator')->get('New Password'); ?></label>
                                            <input type="password"
                                                   id="password"
                                                   name="password"
                                                   autocomplete="off"
                                                   class="form-control"
                                                   placeholder="<?php echo app('translator')->get('Enter New Password'); ?>"/>
                                            <?php if($errors->has('password')): ?>
                                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('password')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="password_confirmation"><?php echo app('translator')->get('Confirm Password'); ?></label>
                                            <input type="password"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   autocomplete="off"
                                                   class="form-control"
                                                   placeholder="<?php echo app('translator')->get('Confirm Password'); ?>"/>
                                            <?php if($errors->has('password_confirmation')): ?>
                                                <div
                                                    class="error text-danger"><?php echo app('translator')->get($errors->first('password_confirmation')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom" type="submit"><?php echo app('translator')->get('Update Password'); ?></button>
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

    <?php $__env->startPush('loadModal'); ?>
        <!-- Modal -->
        <div class="modal fade" id="profileImage" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="planModalLabel"><?php echo app('translator')->get('Confirmation'); ?></h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h6 id="imageChangeText"></h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="button" class="btn-custom profile-image-save"><?php echo app('translator')->get('Save changes'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('css-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/bootstrap-fileinput.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra-js'); ?>
    <script src="<?php echo e(asset($themeTrue.'js/bootstrap-fileinput.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/bootstrapicon-iconpicker.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        'use strict'
        $(document).ready(function () {
            let curIconFirst = $($(`#iconpicker1`)).data('icon');
            setIconpicker('.iconpicker1');
            function setIconpicker(selector = '.iconpicker1') {
                $(selector).iconpicker({
                    title: 'Search Social Icons',
                    selected: false,
                    defaultValue: false,
                    placement: "top",
                    collision: "none",
                    animation: true,
                    hideOnSelect: true,
                    showFooter: false,
                    searchInFooter: false,
                    mustAccept: false,
                    icons: [{
                        title: "bi bi-facebook",
                        searchTerms: ["facebook", "text"]
                    }, {
                        title: "bi bi-twitter",
                        searchTerms: ["twitter", "text"]
                    }, {
                        title: "bi bi-linkedin",
                        searchTerms: ["linkedin", "text"]
                    }, {
                        title: "bi bi-youtube",
                        searchTerms: ["youtube", "text"]
                    }, {
                        title: "bi bi-instagram",
                        searchTerms: ["instagram", "text"]
                    }, {
                        title: "bi bi-whatsapp",
                        searchTerms: ["whatsapp", "text"]
                    }, {
                        title: "bi bi-discord",
                        searchTerms: ["discord", "text"]
                    }, {
                        title: "bi bi-globe",
                        searchTerms: ["website", "text"]
                    }, {
                        title: "bi bi-google",
                        searchTerms: ["google", "text"]
                    }, {
                        title: "bi bi-camera-video",
                        searchTerms: ["vimeo", "text"]
                    }, {
                        title: "bi bi-skype",
                        searchTerms: ["skype", "text"]
                    }, {
                        title: "bi bi-camera-video-fill",
                        searchTerms: ["tiktalk", "text"]
                    }, {
                        title: "bi bi-badge-tm-fill",
                        searchTerms: ["tumbler", "text"]
                    }, {
                        title: "bi bi-blockquote-left",
                        searchTerms: ["blogger", "text"]
                    }, {
                        title: "bi bi-file-word-fill",
                        searchTerms: ["wordpress", "text"]
                    }, {
                        title: "bi bi-badge-wc",
                        searchTerms: ["weixin", "text"]
                    }, {
                        title: "bi bi-telegram",
                        searchTerms: ["telegram", "text"]
                    }, {
                        title: "bi bi-bell-fill",
                        searchTerms: ["snapchat", "text"]
                    }, {
                        title: "bi bi-three-dots",
                        searchTerms: ["flickr", "text"]
                    }, {
                        title: "bi bi-file-ppt",
                        searchTerms: ["pinterest", "text"]
                    }],
                    selectedCustomClass: "bg-primary",
                    fullClassFormatter: function (e) {
                        return e;
                    },
                    input: "input,.iconpicker-input",
                    inputSearch: false,
                    container: false,
                    component: ".input-group-addon,.iconpicker-component",
                })
            }

            let newSocialForm = $('.append_new_social_form').length + 1;
            for (let i = 2; i <= newSocialForm; i++) {
                setIconpicker(`#iconpicker${i}`);
            }

            $("#add_social_links").on('click', function () {
                let newSocialForm = $('.append_new_social_form').length + 2;
                var form = `<div class="d-flex justify-content-between append_new_social_form removeSocialLinksInput">
                                <div class="input-group mt-1">
                                    <input type="text" name="social_icon[]" class="form-control demo__icon__picker iconpicker${newSocialForm}" placeholder="Pick a icon" aria-label="Pick a icon"
                                   aria-describedby="basic-addon1" readonly>
                                </div>

                                <div class="input-box w-100 my-1 me-1">
                                    <input type="url" name="social_url[]" class="form-control" placeholder="<?php echo app('translator')->get('URL'); ?>"/>
                                </div>
                                <div class="my-1 me-1">
                                    <button class="btn-custom add-new btn-custom-danger remove_social_link_input_field" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>`;

                $('.new_social_links_form').append(form)
                setIconpicker(`.iconpicker${newSocialForm}`);
            });

            $(document).on('click', '.remove_social_link_input_field', function () {
                $(this).parents('.removeSocialLinksInput').remove();
            });

            // User profile image change
            $('#userPorfileImage').on('change', function () {
                $('#imageChangeText').text(`<?php echo app('translator')->get('Do you want to change your profile image?'); ?>`)
                $('#profileImage').modal('show');
            });

            $(document).on('click', '.profile-image-save', function () {
                $('#profileImage').modal('hide');
                let formData = new FormData();
                console.log(formData);
                formData.append('profile_image', document.getElementById('userPorfileImage').files[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "<?php echo e(route('user.profileImageUpdate')); ?>",
                    type: "post",
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.src) {
                            $('.profile-image-preview').attr('src', data.src);
                        }
                    }
                });
            })

            $(document).on('click', '#image-label', function () {
                $('#image').trigger('click');
            });
            $(document).on('change', '#image', function () {
                var _this = $(this);
                var newimage = new FileReader();
                newimage.readAsDataURL(this.files[0]);
                newimage.onload = function (e) {
                    $('#image_preview_container').attr('src', e.target.result);
                }
            });
            $(document).on('change', "#identity_type", function () {
                let value = $(this).find('option:selected').val();
                window.location.href = "<?php echo e(route('user.profile')); ?>/?identity_type=" + value
            });

        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/profile/myprofile.blade.php ENDPATH**/ ?>