<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get("User List"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-4 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.users.search')); ?>" method="get">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Search By User'); ?></label>
                                <input type="text" name="search" value="<?php echo e(@request()->search); ?>" class="form-control"
                                       placeholder="<?php echo app('translator')->get('Type Here'); ?>">
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Status'); ?></label>
                                <select name="status" class="form-control">
                                    <option value=""><?php echo app('translator')->get('All'); ?></option>
                                    <option value="1"
                                            <?php if(@request()->status == '1'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Active User'); ?></option>
                                    <option value="0"
                                            <?php if(@request()->status == '0'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Inactive User'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3 col-12">
                            <label for="from_date"><?php echo app('translator')->get('From Date'); ?></label>
                            <input type="date" class="form-control from_date" name="from_date" value="<?php echo e(old('from_date',request()->from_date)); ?>" placeholder="<?php echo app('translator')->get('From date'); ?>" autocomplete="off"/>
                        </div>

                        <div class="col-md-3 col-lg-3 col-12">
                            <label for="to_date"><?php echo app('translator')->get('To Date'); ?></label>
                            <input type="date" class="form-control to_date" name="to_date" value="<?php echo e(old('to_date',request()->to_date)); ?>" placeholder="<?php echo app('translator')->get('To date'); ?>" autocomplete="off" disabled="true"/>
                        </div>


                        <div class="col-md-12 col-lg-12 col-12">
                            <div class="form-group">
                                <label for="" class="opacity-0"><?php echo app('translator')->get('...'); ?></label>
                                <button type="submit" class="btn w-100 d-block btn-primary btn-rounded"><i
                                        class="fas fa-search"></i> <?php echo app('translator')->get('Search'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <?php if(adminAccessRoute(config('role.manage_user.access.edit'))): ?>
                <div class="dropdown mb-2 text-right">
                    <button class="btn btn-sm  btn-primary btn-rounded dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fas fa-bars pr-2"></i> <?php echo app('translator')->get('Action'); ?></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" type="button" data-toggle="modal"
                                data-target="#all_active"><?php echo app('translator')->get('Active'); ?></button>
                        <button class="dropdown-item" type="button" data-toggle="modal"
                                data-target="#all_inactive"><?php echo app('translator')->get('Inactive'); ?></button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <?php if(adminAccessRoute(config('role.manage_user.access.edit'))): ?>
                            <th scope="col" class="text-center">
                                <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                       id="check-all">
                                <label for="check-all"></label>
                            </th>
                        <?php endif; ?>
                        <th scope="col"><?php echo app('translator')->get('No.'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Upline'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Main Balance'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Interest Balance'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Last Login'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <?php if(adminAccessRoute(config('role.manage_user.access.edit'))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <?php if(adminAccessRoute(config('role.manage_user.access.edit'))): ?>
                                <td class="text-center">
                                    <input type="checkbox" id="chk-<?php echo e($user->id); ?>"
                                           class="form-check-input row-tic tic-check" name="check" value="<?php echo e($user->id); ?>"
                                           data-id="<?php echo e($user->id); ?>">
                                    <label for="chk-<?php echo e($user->id); ?>"></label>
                                </td>
                            <?php endif; ?>
                            <td data-label="<?php echo app('translator')->get('No.'); ?>"><?php echo e(loopIndex($users) + $loop->index); ?></td>
                            <td data-label="<?php echo app('translator')->get('Name'); ?>">
                                <a href="<?php echo e(route('admin.user-edit',[$user->id])); ?>" target="_blank">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="mr-3 thumb">
                                            <img src="<?php echo e(getFile(config('location.user.path').$user->image)); ?>" alt="user" class="rounded-circle user-img" width="45" height="45">
                                            <?php if($user->last_level != null): ?>
                                                <img src="<?php echo e(getFile(config('location.badge.path').optional($user->userBadge)->badge_icon)); ?>" alt="<?php echo app('translator')->get('badge icon'); ?>" class="rank-badge" data-toggle="tooltip" data-placement="top" title="<?php echo e(optional($user->userBadge->details)->rank_level); ?> (<?php echo e(optional($user->userBadge->details)->rank_name); ?>)">
                                            <?php endif; ?>
                                        </div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo app('translator')->get($user->firstname); ?> <?php echo app('translator')->get($user->lastname); ?> </h5>
                                            <span class="text-muted font-14"><span>@</span><?php echo app('translator')->get($user->username); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Upline'); ?>">
                                <?php if(isset($user->referral_id)): ?>
                                    <a href="<?php echo e(route('admin.user-edit',[$user->referral_id])); ?>" target="_blank">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="mr-3 thumb">
                                                <img src="<?php echo e(getFile(config('location.user.path').optional($user->referral)->image)); ?>" alt="user" class="rounded-circle user-img" width="45" height="45">
                                                <?php if($user->referral->last_level != null): ?>
                                                    <img src="<?php echo e(getFile(config('location.badge.path').optional($user->referral->userBadge)->badge_icon)); ?>" alt="<?php echo app('translator')->get('badge icon'); ?>" class="rank-badge" data-toggle="tooltip" data-placement="top" title="<?php echo e(optional($user->referral->userBadge->details)->rank_level); ?> (<?php echo e(optional($user->referral->userBadge->details)->rank_name); ?>)">
                                                <?php endif; ?>
                                            </div>

                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo app('translator')->get(optional($user->referral)->firstname); ?> <?php echo app('translator')->get(optional($user->referral)->lastname); ?></h5>
                                                <span class="text-muted font-14"><span>@</span><?php echo app('translator')->get(optional($user->referral)->username); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <span class="text-na"><?php echo app('translator')->get('N/A'); ?></span>
                                <?php endif; ?>
                            </td>

                            <td data-label="<?php echo app('translator')->get('Main Balance'); ?>"><?php echo e(trans(config('basic.currency_symbol'))); ?><?php echo e(getAmount($user->balance, config('basic.fraction_number'))); ?></td>
                            <td data-label="<?php echo app('translator')->get('Interest Balance'); ?>"><?php echo e(trans(config('basic.currency_symbol'))); ?><?php echo e(getAmount($user->interest_balance, config('basic.fraction_number'))); ?></td>
                            <td data-label="<?php echo app('translator')->get('Last Login'); ?>"><?php echo e(diffForHumans($user->last_login)); ?></td>
                            <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                <span
                                    class="custom-badge badge-pill <?php echo e($user->status == 0 ? 'bg-danger' : 'bg-success'); ?>"><?php echo e($user->status == 0 ? 'Inactive' : 'Active'); ?></span>
                            </td>
                            <?php if(adminAccessRoute(config('role.manage_user.access.edit'))): ?>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <div class="dropdown show">
                                        <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="<?php echo e(route('admin.user-edit',$user->id)); ?>">
                                                <i class="fa fa-edit text-warning pr-2"
                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Edit'); ?>
                                            </a>
                                            <a class="dropdown-item" href="<?php echo e(route('admin.send-email',$user->id)); ?>">
                                                <i class="fa fa-envelope text-success pr-2"
                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Send Email'); ?>
                                            </a>
                                            <a class="dropdown-item loginAccount" type="button"
                                               data-toggle="modal"
                                               data-target="#signIn"
                                               data-route="<?php echo e(route('admin.login-as-user',$user->id)); ?>">
                                                <i class="fas fa-sign-in-alt text-success pr-2"
                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Login as User'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-center text-na" colspan="100%"><?php echo app('translator')->get('No User Data'); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($users->appends(@$search)->links('partials.pagination')); ?>


            </div>
        </div>
    </div>




    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Active User Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to active the User's"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary active-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="all_inactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('DeActive User Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to Inactive the User's"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary inactive-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Login as a User Modal -->
    <div class="modal fade" id="signIn">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="" class="loginAccountAction" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <!-- Modal Header -->
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title"><?php echo app('translator')->get('Sing In Confirmation'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure to sign in this account?'); ?></p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span>
                        </button>
                        <button type="submit" class=" btn btn-primary "><span><?php echo app('translator')->get('Yes'); ?></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('js'); ?>
    <script>
        "use strict";

        $(document).on('click', '#check-all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('change', ".row-tic", function () {
            let length = $(".row-tic").length;
            let checkedLength = $(".row-tic:checked").length;
            if (length == checkedLength) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });

        //dropdown menu is not working
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });

        //multiple active
        $(document).on('click', '.active-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            var strIds = allVals;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "<?php echo e(route('admin.user-multiple-active')); ?>",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                },
            });
        });

        //multiple deactive
        $(document).on('click', '.inactive-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            var strIds = allVals;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "<?php echo e(route('admin.user-multiple-inactive')); ?>",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                }
            });
        });

        $(document).on('click', '.loginAccount', function () {
            var route = $(this).data('route');
            $('.loginAccountAction').attr('action', route)
        });

        $('select').select2({
            selectOnClose: true,
            width: '100%'
        });

        $('.from_date').on('change', function (){
            $('.to_date').removeAttr('disabled');
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/admin/users/list.blade.php ENDPATH**/ ?>