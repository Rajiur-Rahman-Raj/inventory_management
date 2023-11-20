<!-- sidebar -->
<?php
    $user = \Illuminate\Support\Facades\Auth::user();
    $user_badge = \App\Models\Badge::with('details')->where('id', @$user->last_level)->first();
?>
<div id="sidebar" class="">
    <div class="sidebar-top">
        <a class="navbar-brand d-none d-lg-block" href="<?php echo e(url('/')); ?>"> <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" alt="<?php echo e(config('basic.site_title')); ?>" /></a>
        <div class="mobile-user-area d-lg-none">
            <div class="thumb">
                <img class="img-fluid user-img" src="<?php echo e(getFile(config('location.user.path').auth()->user()->image)); ?>" alt="...">
                <?php if(optional($user->userBadge)->badge_icon): ?>
                    <img src="<?php echo e(getFile(config('location.badge.path').optional($user->userBadge)->badge_icon)); ?>" alt="" class="rank-badge">
                <?php endif; ?>
            </div>
            <div class="content">
                <h5 class="mt-1 mb-1"><?php echo e(__(auth()->user()->fullname)); ?></h5>
                <span class=""><?php echo e(__(auth()->user()->username)); ?></span>
                <?php if(@$user->last_level != null && $user_badge): ?>
                    <p class="text-small mb-0"><?php echo app('translator')->get(optional($user->userBadge->details)->rank_name); ?> - (<?php echo app('translator')->get((optional($user->userBadge->details)->rank_level)); ?>)</p>
                <?php endif; ?>
            </div>
        </div>
        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    <ul class="main">
        <li>
            <a class="<?php echo e(menuActive(['user.home'])); ?>" href="<?php echo e(route('user.home')); ?>"><i class="fal fa-house-flood"></i><?php echo app('translator')->get('Dashboard'); ?></a>
        </li>

        <?php
            $segments = request()->segments();
            $last  = end($segments);
            $propertyMarketSegments = ['investment-properties', 'property-share-market', 'my-investment-properties', 'my-shared-properties', 'my-offered-properties', 'receive-offered-properties', 'offer-conversation'];
        ?>

        <li>
            <a
                class="dropdown-toggle <?php echo e(in_array($last, $propertyMarketSegments) || in_array($segments[1], $propertyMarketSegments) ? 'propertyMarketActive' : ''); ?>"
                data-bs-toggle="collapse"
                href="#dropdownCollapsible"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample">
                <i class="fal fa-car-building"></i><?php echo app('translator')->get('Property Market'); ?>
            </a>
            <div class="collapse <?php echo e(menuActive(['user.propertyMarket','user.offerList', 'user.offerConversation'],4)); ?> dropdownCollapsible" id="dropdownCollapsible">
                <ul class="">
                    <li>
                        <a class="<?php echo e(($last == 'investment-properties') ? 'active' : ''); ?>" href="<?php echo e(route('user.propertyMarket', 'investment-properties')); ?>"><i class="fal fa-sack-dollar"></i><?php echo app('translator')->get('Investment Properties'); ?></a>
                    </li>
                    <?php if(config('basic.is_share_investment') == 1): ?>
                        <li>
                            <a class="<?php echo e(($last == 'property-share-market') ? 'active' : ''); ?>"  href="<?php echo e(route('user.propertyMarket', 'property-share-market')); ?>"><i class="fal fa-house-return"></i><?php echo app('translator')->get('Share Market'); ?></a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a  class="<?php echo e(($last == 'my-investment-properties') ? 'active' : ''); ?>" href="<?php echo e(route('user.propertyMarket', 'my-investment-properties')); ?>"><i class="fal fa-building"></i><?php echo app('translator')->get('My Properties'); ?></a>
                    </li>
                    <?php if(config('basic.is_share_investment') == 1): ?>
                        <li>
                            <a  class="<?php echo e(($last == 'my-shared-properties') ? 'active' : ''); ?>" href="<?php echo e(route('user.propertyMarket', 'my-shared-properties')); ?>"><i class="fal fa-share-alt"></i><?php echo app('translator')->get('My Shared Properties'); ?></a>
                        </li>
                        <li>
                            <a  class="<?php echo e(($last == 'my-offered-properties') ? 'active' : ''); ?>" href="<?php echo e(route('user.propertyMarket', 'my-offered-properties')); ?>"><i class="fal fa-paper-plane"></i><?php echo app('translator')->get('Send Offer'); ?></a>
                        </li>
                        <li>
                            <a  class="<?php echo e(($last == 'receive-offered-properties' || request()->routeIs('user.offerList')) ? 'active' : ''); ?>" href="<?php echo e(route('user.propertyMarket', 'receive-offered-properties')); ?>"><i class="fal fa-bell-on"></i><?php echo app('translator')->get('Receive Offer'); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.invest-history'])); ?>" href="<?php echo e(route('user.invest-history')); ?>"><i class="fal fa-history"></i><?php echo app('translator')->get('Invest History'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.wishListProperty'])); ?>" href="<?php echo e(route('user.wishListProperty')); ?>"><i class="fal fa-heart"></i><?php echo app('translator')->get('WishList'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.addFund'])); ?>" href="<?php echo e(route('user.addFund')); ?>"><i class="fal fa-funnel-dollar"></i><?php echo app('translator')->get('Add Fund'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.fund-history', 'user.fund-history.search'])); ?>" href="<?php echo e(route('user.fund-history')); ?>"><i class="fal fa-file-invoice-dollar"></i><?php echo app('translator')->get('Fund History'); ?></a>
        </li>


        <li>
            <a class="<?php echo e(menuActive(['user.money-transfer'])); ?>" href="<?php echo e(route('user.money-transfer')); ?>"><i class="fal fa-exchange-alt"></i><?php echo app('translator')->get('Money Transfer'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.transaction', 'user.transaction.search'])); ?>" href="<?php echo e(route('user.transaction')); ?>"><i class="fal fa-money-check-alt"></i><?php echo app('translator')->get('Transaction'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.payout.money','user.payout.preview'])); ?>" href="<?php echo e(route('user.payout.money')); ?>"><i class="fal fa-credit-card"></i><?php echo app('translator')->get('Payout'); ?></a>
        </li>
        <li>
            <a class="<?php echo e(menuActive(['user.payout.history','user.payout.history.search'])); ?>" href="<?php echo e(route('user.payout.history')); ?>"><i class="fal fa-usd-square"></i><?php echo app('translator')->get('Payout History'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.referral'])); ?>" href="<?php echo e(route('user.referral')); ?>"><i class="fal fa-sync"></i><?php echo app('translator')->get('My Referral'); ?></a>
        </li>
        <li>
            <a class="<?php echo e(menuActive(['user.referral.bonus', 'user.referral.bonus.search'])); ?>" href="<?php echo e(route('user.referral.bonus')); ?>"><i class="fal fa-hand-holding-usd"></i><?php echo app('translator')->get('Referral Bonus'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.badges'])); ?>" href="<?php echo e(route('user.badges')); ?>"><i class="fal fa-badge-check"></i><?php echo app('translator')->get('Badges'); ?></a>
        </li>

        <li>
            <a class="<?php echo e(menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view'])); ?>" href="<?php echo e(route('user.ticket.list')); ?>"><i class="fal fa-ticket"></i><?php echo app('translator')->get('Support ticket'); ?></a>
        </li>

        <li class="d-lg-none">
            <a href="<?php echo e(route('user.twostep.security')); ?>">
                <i class="fal fa-lock"></i> <?php echo app('translator')->get('2FA Security'); ?>
            </a>
        </li>

        <li class="d-lg-none">
            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fal fa-sign-out-alt"></i> <?php echo app('translator')->get('Logout'); ?>
            </a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
        </li>
    </ul>
</div>
<?php /**PATH D:\xammp\htdocs\chaincity_update\project\resources\views/themes/original/partials/sidebar.blade.php ENDPATH**/ ?>