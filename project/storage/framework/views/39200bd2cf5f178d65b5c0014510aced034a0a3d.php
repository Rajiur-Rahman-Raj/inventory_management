<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Edit a Property'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media justify-content-end">
                <a href="<?php echo e(route('admin.propertyList',['all'])); ?>" class="btn btn-sm  btn-primary btn-rounded mr-2">
                    <span><i class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?></span>
                </a>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($loop->first ? 'active' : ''); ?> language_tab" data-toggle="tab"
                           href="#lang-tab-<?php echo e($key); ?>" role="tab" aria-controls="lang-tab-<?php echo e($key); ?>"
                           aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>" data-languageid="<?php echo e($language->id); ?>"><?php echo app('translator')->get($language->name); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <div class="tab-content mt-5" id="myTabContent">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" id="lang-tab-<?php echo e($key); ?>"
                         role="tabpanel">
                        <form method="post" action="<?php echo e(route('admin.propertyUpdate', [$id, $language->id])); ?>"
                              enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>
                            <div class="card">
                                <div class="card-header text-primary">
                                    <li><span class="propertyDetailsLabel"><?php echo app('translator')->get('Update Property Details'); ?></span></li>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label><?php echo app('translator')->get('Title'); ?> <span class="text-danger">*</span></label>
                                                <input type="text" name="property_title[<?php echo e($language->id); ?>]"
                                                       value="<?php echo old('property_title'.$language->id, isset($singlePropertyDetails[$language->id]) ? $singlePropertyDetails[$language->id][0]->property_title : '') ?>"
                                                       class="form-control">
                                                <?php $__errorArgs = ['property_title'.'.'.$language->id];
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
                                        </div>
                                        <?php if($loop->index == 0): ?>
                                            <div class="col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label class=""><?php echo app('translator')->get('Address'); ?> <span
                                                            class="text-danger">*</span></label>
                                                    <select name="address_id" class="form-control  type addressList">
                                                        <?php $__currentLoopData = $allAddress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                value="<?php echo e($address->id); ?>" <?php echo e(optional($singlePropertyDetails[$language->id][0]->manageProperty)->address_id == $address->id ? 'selected' : ''); ?>><?php echo app('translator')->get(optional($address->details)->title); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <?php $__errorArgs = ['address_id'];
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

                                            <div class="col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Location'); ?></label>
                                                    <input type="text" name="location"
                                                           value="<?php echo e($singlePropertyDetails[$language->id][0]->manageProperty->location); ?>"
                                                           class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <?php $__errorArgs = ['location'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <label for="before_expiry_date"> <?php echo app('translator')->get('Amenities'); ?></label>
                                                <select name="amenity_id[]"
                                                        class="form-control propertyAmenities <?php $__errorArgs = ['amenity_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        multiple>
                                                    <option disabled><?php echo app('translator')->get('Choose items'); ?></option>
                                                    <?php $__currentLoopData = $allAmenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            value="<?php echo e($amenity->id); ?>" <?php echo e(in_array($amenity->id, $singlePropertyDetails[$language->id][0]->manageProperty->amenity_id) ? 'selected' : ''); ?>><?php echo app('translator')->get(optional($amenity->details)->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['amenity_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo app('translator')->get($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 col-xl-12 col-12 property__details">
                                            <div class="form-group">
                                                <label for="details"> <?php echo app('translator')->get('Details'); ?> </label>
                                                <textarea
                                                    class="form-control summernote <?php $__errorArgs = ['details'.'.'.$language->id];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="details[<?php echo e($language->id); ?>]" id="summernote" rows="15"
                                                    value="<?php echo old('details'.$language->id, isset($singlePropertyDetails[$language->id]) ? $singlePropertyDetails[$language->id][0]->details : '') ?>"><?php echo e(@$singlePropertyDetails[$language->id][0]->details); ?></textarea>
                                                <?php $__errorArgs = ['details'];
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
                                        </div>
                                        <?php if($loop->index == 0): ?>
                                            <div class="col-md-5 col-xl-5 col-12">
                                                <div class="form-group">
                                                    <label for="thumbnail"><?php echo e(('Thumbnail')); ?></label>
                                                    <div class="image-input property_image_input">
                                                        <label for="image-upload" id="image-label"><i
                                                                class="fas fa-upload"></i></label>
                                                        <input type="file" name="thumbnail"
                                                               placeholder="<?php echo app('translator')->get('Choose image'); ?>"
                                                               id="image"
                                                               class="form-control <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <img id="image_preview_container" class="preview-image"
                                                             src="<?php echo e(asset(getFile(config('location.propertyThumbnail.path').(isset($singlePropertyDetails[$language->id]) ? @$singlePropertyDetails[$language->id][0]->manageProperty->thumbnail : '')))); ?>"
                                                             alt="<?php echo app('translator')->get('preview image'); ?>">
                                                    </div>
                                                    <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-7 col-xl-7 col-12">
                                                <div class="form-group" id="tab3">
                                                    <label for="details"> <?php echo app('translator')->get('Property Galary Images'); ?> </label>
                                                    <div class="property-image"></div>
                                                    <?php $__errorArgs = ['property_image.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo app('translator')->get($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Video Url'); ?></label>
                                                    <input type="text" name="video" value="<?php echo e(old('video', $singlePropertyDetails[$language->id][0]->manageProperty->video)); ?>"
                                                           placeholder="<?php echo app('translator')->get('only iframe embed url accepted'); ?>"
                                                           class="form-control <?php $__errorArgs = ['video'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <?php $__errorArgs = ['video'];
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
                                            </div>

                                            <div class="col-md-4 col-xl-4">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Is Featured Property?'); ?> (<span class="text-primary font-14"><?php echo app('translator')->get('For available also home page'); ?></span>)</label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name="is_featured" <?php echo e(old('is_featured', $singlePropertyDetails[$language->id][0]->manageProperty->is_featured) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="is_featured" id="is_featured"
                                                               class="custom-switch-checkbox"
                                                               value="0" <?php echo e(old('is_featured', $singlePropertyDetails[$language->id][0]->manageProperty->is_featured) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="is_featured">
                                                            <span class="custom-switch-checkbox-for-installments"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xl-4">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Can investors see property available funds for investment?'); ?></label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name="is_available_funding" <?php echo e(old('is_available_funding', $singlePropertyDetails[$language->id][0]->manageProperty->is_available_funding) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="is_available_funding" id="is_available_funding"
                                                               class="custom-switch-checkbox"
                                                               value="0" <?php echo e(old('is_available_funding', $singlePropertyDetails[$language->id][0]->manageProperty->is_available_funding) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="is_available_funding">
                                                            <span class="custom-switch-checkbox-for-installments"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 col-xl-6 mt-4 mb-3 pl-2 pr-2 pt-1 pb-1 ml-2">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-rounded generate" data-lang="<?php echo e($language->id); ?>"><i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add FAQ'); ?></a>
                                        </div>
                                    </div>

                                    <?php if(!empty($singlePropertyDetails[$language->id][0]->faq)): ?>
                                        <?php $__currentLoopData = $singlePropertyDetails[$language->id][0]->faq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row">
                                                <div class="col-md-12 col-log-12 col-12">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input name="faq_title[]"
                                                                   class="form-control" type="text"
                                                                   value="<?php echo e(@$value->field_name); ?>">
                                                            <textarea class="form-control" name="faq_details[]" rows="1"
                                                                      placeholder="<?php echo app('translator')->get('Answer'); ?>"><?php echo e(@$value->field_value); ?></textarea>
                                                            <span class="input-group-btn">
                                                            <button class="btn btn-danger delete_desc" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                    <?php
                                        $maxNum = old('faq_title') && old('faq_details') ? max(count(old('faq_title')), count(old('faq_details'))) : (old('faq_title') && !old('faq_details') ? count(old('faq_title')) : (!old('faq_title') && old('faq_details') ? count(old('faq_title')) : 0));
                                    ?>

                                    <div class="row addedField<?php echo e($language->id); ?>">
                                        <?php for($i = 0; $i < $maxNum; $i++): ?>
                                            <div class="col-md-12 col-log-12 col-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input name="faq_title[]" class="form-control" type="text"
                                                               value="<?php echo e(old('faq_title.'.$i)); ?>"
                                                               placeholder="<?php echo e(trans('question')); ?>">
                                                        <textarea class="form-control" name="faq_details[]"
                                                                  id="summernote" rows="1"
                                                                  placeholder="<?php echo app('translator')->get('Answer'); ?>"><?php echo e(old('faq_details.'.$i)); ?></textarea>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-danger delete_desc" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    </div>

                                </div>
                            </div>

                            <?php if($loop->index == 0): ?>
                                <div class="card">
                                    <div class="card-header text-primary">
                                        <li><span class="propertyDetailsLabel"> <?php echo app('translator')->get('Add Investment Details'); ?></span></li>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Invest Type'); ?></label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name="is_invest_type" <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="is_invest_type" id="is_invest_type"
                                                               class="custom-switch-checkbox"
                                                               value="0" <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="is_invest_type">
                                                            <span class="custom-switch-checkbox-for-investType"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-xl-3 fixedAmount <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" ? 'd-block' : 'd-none'); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Fixed Invest Amount'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="fixed_amount"
                                                               class="form-control <?php $__errorArgs = ['fixed_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="0.00" value="<?php echo e(old('fixed_amount', $singlePropertyDetails[$language->id][0]->manageProperty->fixed_amount)); ?>" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                               id="fixedAmount"
                                                               autocomplete="off">
                                                        <div class="input-group-append">
                                                        <span
                                                            class="input-group-text"><?php echo app('translator')->get(config('basic.currency_symbol')); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['fixed_amount'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3 rangeAmount <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" ? 'd-none' : ''); ?> ">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Minimum Invest Amount'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="minimum_amount"
                                                               class="form-control <?php $__errorArgs = ['minimum_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="0.00" value="<?php echo e(old('minimum_amount', $singlePropertyDetails[$language->id][0]->manageProperty->minimum_amount)); ?>"
                                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                        <div class="input-group-append">
                                                <span
                                                    class="input-group-text"><?php echo app('translator')->get(config('basic.currency_symbol')); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['minimum_amount'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3 rangeAmount <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" ? 'd-none' : ''); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Maximum Invest Amount'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="maximum_amount"
                                                               class="form-control <?php $__errorArgs = ['maximum_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="0.00" value="<?php echo e(old('maximum_amount', $singlePropertyDetails[$language->id][0]->manageProperty->maximum_amount)); ?>"
                                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                        <div class="input-group-append">
                                                <span
                                                    class="input-group-text"><?php echo app('translator')->get(config('basic.currency_symbol')); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['maximum_amount'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Need Total Invest Amount'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="total_investment_amount"
                                                               class="form-control <?php $__errorArgs = ['total_investment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="0.00"
                                                               value="<?php echo e(old('total_investment_amount', $singlePropertyDetails[$language->id][0]->manageProperty->total_investment_amount)); ?>"
                                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                        <div class="input-group-append">
                                                        <span
                                                            class="input-group-text"><?php echo app('translator')->get(config('basic.currency_symbol')); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['total_investment_amount'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Profit Range'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="profit"
                                                               class="form-control <?php $__errorArgs = ['profit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="0.00" value="<?php echo e(old('profit', $singlePropertyDetails[$language->id][0]->manageProperty->profit)); ?>">
                                                        <div class="input-group-append">
                                                            <select name="profit_type" id="profit_type"
                                                                    class="form-control">
                                                                <option value="1" <?php echo e($singlePropertyDetails[$language->id][0]->manageProperty->profit_type == 1 ? 'selected' : ''); ?>>%</option>
                                                                <option
                                                                    value="0" <?php echo e($singlePropertyDetails[$language->id][0]->manageProperty->profit_type == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get(config('basic.currency_symbol')); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['profit'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3 acceptInstallments <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" ? '' : 'd-none'); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Accept Installments'); ?></label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name="is_installment" <?php echo e(old('is_installment', $singlePropertyDetails[$language->id][0]->manageProperty->is_installment) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="is_installment" id="is_installment"
                                                               class="custom-switch-checkbox"
                                                               value="0" <?php echo e(old('is_installment', $singlePropertyDetails[$language->id][0]->manageProperty->is_installment) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="is_installment">
                                                            <span class="custom-switch-checkbox-for-installments"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-xl-3 installmentField <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" && old('is_installment', $singlePropertyDetails[$language->id][0]->manageProperty->is_installment) == "1" ? '' : 'd-none'); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Total Installments'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="total_installments"
                                                               class="form-control <?php $__errorArgs = ['total_installments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               id="totalInstallments"
                                                               placeholder="min 1"
                                                               value="<?php echo e(old('total_installments', $singlePropertyDetails[$language->id][0]->manageProperty->total_installments)); ?>"
                                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                    </div>
                                                    <?php $__errorArgs = ['total_installments'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3 installmentField <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" && old('is_installment', $singlePropertyDetails[$language->id][0]->manageProperty->is_installment) == "1" ? '' : 'd-none'); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Installment Amount'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="installment_amount"
                                                               class="form-control <?php $__errorArgs = ['installment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="0.00" value="<?php echo e(old('installment_amount', $singlePropertyDetails[$language->id][0]->manageProperty->installment_amount)); ?>"
                                                               id="installmentAmount"
                                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" readonly autocomplete="off">
                                                        <div class="input-group-append">
                                                        <span
                                                            class="input-group-text"><?php echo app('translator')->get(config('basic.currency_symbol')); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['installment_amount'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3 installmentField <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" && old('is_installment', $singlePropertyDetails[$language->id][0]->manageProperty->is_installment) == "1" ? '' : 'd-none'); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Installment Duration'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="installment_duration"
                                                               class="form-control expiry_time <?php $__errorArgs = ['installment_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               value="<?php echo e(old('installment_duration', $singlePropertyDetails[$language->id][0]->manageProperty->installment_duration)); ?>"
                                                               placeholder="min 1" min="1" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                        <div class="input-group-append">
                                                            <select class="form-control installment_duration_type"
                                                                    id="installment_duration_type"
                                                                    name="installment_duration_type">
                                                                <option value="Days" <?php echo e(old('installment_duration_type', $singlePropertyDetails[$language->id][0]->manageProperty->installment_duration_type) == 'Days' ? 'selected' : ''); ?>><?php echo app('translator')->get('Day(s)'); ?></option>
                                                                <option value="Months" <?php echo e(old('installment_duration_type', $singlePropertyDetails[$language->id][0]->manageProperty->installment_duration_type) == 'Months' ? 'selected' : ''); ?>><?php echo app('translator')->get('Month(s)'); ?></option>
                                                                <option value="Years" <?php echo e(old('installment_duration_type', $singlePropertyDetails[$language->id][0]->manageProperty->installment_duration_type) == 'Years' ? 'selected' : ''); ?>><?php echo app('translator')->get('Year(s)'); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['installment_duration'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3 installmentField <?php echo e(old('is_invest_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_invest_type) == "0" && old('is_installment', $singlePropertyDetails[$language->id][0]->manageProperty->is_installment) == "1" ? '' : 'd-none'); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Installment Late Fee'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="installment_late_fee"
                                                               class="form-control <?php $__errorArgs = ['installment_late_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="0.00" value="<?php echo e(old('installment_late_fee', $singlePropertyDetails[$language->id][0]->manageProperty->installment_late_fee)); ?>"
                                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                        <div class="input-group-append">
                                                        <span
                                                            class="input-group-text"><?php echo app('translator')->get(config('basic.currency_symbol')); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php $__errorArgs = ['installment_late_fee'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Profit Return Type'); ?></label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name="is_return_type" <?php echo e(old('is_return_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_return_type) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="is_return_type" id="is_return_type"
                                                               class="custom-switch-checkbox"
                                                               value="0" <?php echo e(old('is_return_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_return_type) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="is_return_type">
                                                            <span class="custom-switch-checkbox-for-returnType"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-xl-3 howManyTimes <?php echo e(old('is_return_type', $singlePropertyDetails[$language->id][0]->manageProperty->is_return_type) == "0" ? '' : 'd-none'); ?>">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('how many times get profit?'); ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="how_many_times"
                                                               class="form-control <?php $__errorArgs = ['how_many_times'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               placeholder="min 1" value="<?php echo e(old('how_many_times', $singlePropertyDetails[$language->id][0]->manageProperty->how_many_times)); ?>"
                                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                    </div>
                                                    <?php $__errorArgs = ['how_many_times'];
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
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Profit Return Schedule'); ?> (<span class="text-primary font-weight-normal font-14"><?php echo app('translator')->get('after how many days'); ?></span>)</label>
                                                    <select name="how_many_days" id="how_many_days"
                                                            class="form-control <?php $__errorArgs = ['how_many_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <option value="" disabled><?php echo app('translator')->get('Select a Period'); ?></option>
                                                        <?php $__currentLoopData = $allSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                value="<?php echo e($schedule->id); ?>" <?php echo e(old('how_many_days', $singlePropertyDetails[$language->id][0]->manageProperty->how_many_days)  == $schedule->id ? 'selected' : ''); ?>><?php echo app('translator')->get($schedule->time); ?> <?php echo app('translator')->get($schedule->time_type); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <?php $__errorArgs = ['how_many_days'];
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

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Can the investor sell his investment for this property?'); ?></label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name="is_investor" <?php echo e(old('is_investor', $singlePropertyDetails[$language->id][0]->manageProperty->is_investor) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="is_investor" id="is_investor"
                                                               class="custom-switch-checkbox"
                                                               value="0" <?php echo e(old('is_investor', $singlePropertyDetails[$language->id][0]->manageProperty->is_investor) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="is_investor">
                                                            <span class="custom-switch-checkbox-for-installments"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Capital Back'); ?></label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name="is_capital_back" <?php echo e(old('is_capital_back', $singlePropertyDetails[$language->id][0]->manageProperty->is_capital_back) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="is_capital_back" id="is_capital_back"
                                                               class="custom-switch-checkbox"
                                                               value="0" <?php echo e(old('is_capital_back', $singlePropertyDetails[$language->id][0]->manageProperty->is_capital_back) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="is_capital_back">
                                                            <span class="custom-switch-checkbox-for-installments"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Investment Start Date-Time'); ?></label>
                                                    <input type="datetime-local" class="form-control start_date" name="start_date" value="<?php echo e(\Illuminate\Support\Carbon::parse($singlePropertyDetails[$language->id][0]->manageProperty->start_date)); ?>" autocomplete="off"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Investment Expire Date-Time'); ?></label>
                                                    <input type="datetime-local" class="form-control expire_date" name="expire_date" value="<?php echo e(\Illuminate\Support\Carbon::parse($singlePropertyDetails[$language->id][0]->manageProperty->expire_date)); ?>" autocomplete="off"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-xl-3">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Status'); ?></label>
                                                    <div class="custom-switch-btn">
                                                        <input type='hidden' value='1'
                                                               name='status' <?php echo e(old('status', $singlePropertyDetails[$language->id][0]->manageProperty->status) == "1" ? 'checked' : ''); ?>>
                                                        <input type="checkbox" name="status" class="custom-switch-checkbox"
                                                               id="status"
                                                               value="0" <?php echo e(old('status', $singlePropertyDetails[$language->id][0]->manageProperty->status) == "0" ? 'checked' : ''); ?>>
                                                        <label class="custom-switch-checkbox-label" for="status">
                                                            <span class="custom-switch-checkbox-propertyStatus"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-md-12">
                                <button type="submit"
                                        class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                                    <span><i class="fas fa-save pr-2"></i> <?php echo app('translator')->get('Save Changes'); ?></span></button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/summernote.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/image-uploader.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/summernote.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/image-uploader.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>

    <script>
        'use strict'

        $('.summernote').summernote({
            height: 250,
            callbacks: {
                onBlurCodeview: function () {
                    let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                    $(this).val(codeviewHtml);
                }
            }
        });

        $('#image').on("change",function () {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview_container').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $(document).ready(function (){
            $(".generate").on('click', function () {
                var lang = $(this).data('lang');
                var form = `<div class="col-md-12 col-log-12 col-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="faq_title[]" class="form-control" type="text"
                                        placeholder="<?php echo e(trans('question')); ?>">
                                        <textarea class="form-control summernote " name="faq_details[]" rows="1" placeholder="<?php echo app('translator')->get('Answer'); ?>"></textarea>
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>`;

                $(`.addedField${lang}`).append(form)
            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });

            $('.propertyAmenities').select2({
                width: '100%',
                placeholder: '<?php echo app('translator')->get("Select Amenities"); ?>',
            });

            var property_images = <?php echo json_encode(optional(optional($singlePropertyDetails[1][0]->manageProperty)->image)->toArray()); ?>;

            let preloaded = [];
            property_images.forEach(function (value, index) {
                preloaded.push({
                    id: value.id,
                    image_name: value.image,
                    src: "<?php echo e(asset(config('location.property.path'))); ?>/" + value.image
                });
            });

            let propertyImageOptions = {
                preloaded: preloaded,
                imagesInputName: 'property_image',
                preloadedInputName: 'old_property_image',
                label: 'Drag & Drop files here or click to browse images',
                extensions: ['.jpg', '.jpeg', '.png'],
                mimes: ['image/jpeg', 'image/png'],
                maxSize: 5242880
            };

            $('.property-image').imageUploader(propertyImageOptions);

            $(document).on('input', '#totalInstallments', function (){
                let total_installments = $('#totalInstallments').val();
                let fixed_amount = $('#fixedAmount').val();
                let installment_amount = parseInt(fixed_amount) / parseInt(total_installments);
                let final_installment_amount = installment_amount.toFixed(2);
                $('#installmentAmount').val(final_installment_amount);
            });


            $(document).on('change', '#is_invest_type', function () {
                var isCheck = $(this).prop('checked');
                if (isCheck == false) {
                    $('.rangeAmount').addClass('d-block');
                    $('.rangeAmount').removeClass('d-none');
                    $('.fixedAmount').removeClass('d-block');
                    $('.fixedAmount').addClass('d-none');
                    $('.acceptInstallments').addClass('d-none')
                    $('.installmentField').addClass('d-none');
                } else {
                    $('.rangeAmount').addClass('d-none');
                    $('.rangeAmount').removeClass('d-block');
                    $('.fixedAmount').removeClass('d-none');
                    $('.acceptInstallments').removeClass('d-none');
                    $('.installmentField').removeClass('d-none');
                    $('#is_installment').prop('checked', false);
                }
            });

            $(document).on('change', '#is_return_type', function () {
                var isCheck = $(this).prop('checked');

                if (isCheck == false) {
                    $('.howManyTimes').removeClass('d-block');
                    $('.howManyTimes').addClass('d-none');
                } else {
                    $('.howManyTimes').removeClass('d-none');
                    $('.howManyTimes').addClass('d-block');
                }
            });

            $(document).on('change', '#is_installment', function () {
                var isCheck = $(this).prop('checked');
                if (isCheck == false) {
                    $('.installmentField').removeClass('d-none');
                } else {
                    $('.installmentField').addClass('d-none');
                }
            });

            $('.propertyAmenities').select2({
                width: '100%',
                placeholder: '<?php echo app('translator')->get("Select Amenities"); ?>',
            });

            $('.addressList').select2({
                width: '100%',
                placeholder: '<?php echo app('translator')->get("Select Address"); ?>',
            });

            $('select[name=period_duration]').select2({
                selectOnClose: true
            });

        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/admin/property/edit.blade.php ENDPATH**/ ?>