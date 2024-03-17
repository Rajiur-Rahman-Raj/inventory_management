<?php
    $user = \Illuminate\Support\Facades\Auth::user();
?>

<meta name="description" content="<?php echo e(config('seo.meta_description')); ?>">
<meta name="keywords" content="<?php echo e(config('seo.meta_keywords')); ?>">
<?php if($user): ?>
    <link rel="shortcut icon"
          href="<?php echo e(getFile(optional($user->activeCompany)->driver, optional($user->activeCompany)->logo)); ?>"
          type="image/x-icon">
<?php endif; ?>

<link rel="apple-touch-icon" href="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>">
<?php if($user && userType() == 1): ?>

    <title><?php echo e(optional($user->activeCompany)->name); ?> | <?php echo $__env->yieldContent('title'); ?></title>
<?php elseif($user && userType() == 2): ?>
    <title><?php echo e(optional($user->salesCenter)->name); ?> | <?php echo $__env->yieldContent('title'); ?></title>
<?php else: ?>
    <title><?php echo $__env->yieldContent('title'); ?></title>
<?php endif; ?>


<?php if($user && userType() == 1): ?>

    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo e(getFile(optional($user->activeCompany)->driver, optional($user->activeCompany)->logo)); ?>">
<?php elseif($user && userType() == 2): ?>

    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo e(getFile( optional(optional($user->salesCenter)->company)->driver, optional(optional($user->salesCenter)->company)->logo)); ?>">
<?php endif; ?>


<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="<?php echo app('translator')->get($basic->site_title); ?> | <?php echo $__env->yieldContent('title'); ?>">

<meta itemprop="name" content="<?php echo app('translator')->get($basic->site_title); ?> | <?php echo $__env->yieldContent('title'); ?>">
<meta itemprop="description" content="<?php echo e(config('seo.meta_description')); ?>">
<meta itemprop="image" content="<?php echo e(getFile(config('location.logoIcon.path'). config('seo.meta_image'),'600x315')); ?>">

<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo e(config('seo.social_title')); ?>">
<meta property="og:description" content="<?php echo e(config('seo.social_description')); ?>">
<meta property="og:image" content="<?php echo e(getFile(config('location.logoIcon.path') . config('seo.meta_image'))); ?>"/>
<meta property="og:image:type"
      content="image/<?php echo e(pathinfo(getFile(config('location.logoIcon.path') . config('seo.meta_image')))['extension']); ?>"/>
<meta property="og:url" content="<?php echo e(url()->current()); ?>">

<meta name="twitter:card" content="summary_large_image">
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/partials/seo.blade.php ENDPATH**/ ?>