<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" <?php if(session()->get('rtl') == 1): ?> dir="rtl" <?php endif; ?> >
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/bootstrap.min.css')); ?>"/>
    <link href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/owl.carousel.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/owl.theme.default.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/range-slider.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/fancybox.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/notiflix-3.2.6.min.css')); ?>">

    <?php echo $__env->yieldPushContent('css-lib'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue.'css/style.css')); ?>">
    <script src="<?php echo e(asset($themeTrue.'js/fontawesomepro.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue.'js/modernizr.custom.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('style'); ?>

</head>
<body <?php if(session()->get('rtl') == 1): ?> class="rtl" <?php endif; ?> id="body">

<div class="bottom-nav fixed-bottom d-lg-none">
    <div class="link-item <?php echo e(menuActive(['user.propertyMarket'])); ?>">
        <a href="#">
            <i class="fal fa-project-diagram" aria-hidden="true"></i>
            <span><?php echo app('translator')->get('Invest'); ?></span>
        </a>
    </div>

    <div class="link-item">

        <a href="<?php echo e(route('user.addFund')); ?>">
            <i class="fal fa-funnel-dollar" aria-hidden="true"></i>
            <span><?php echo app('translator')->get('Deposit'); ?></span>
        </a>
    </div>

    <div class="link-item">
        <a href="<?php echo e(route('user.home')); ?>">
            <i class="fal fa-home-lg-alt"></i>
            <span><?php echo app('translator')->get('Home'); ?></span>
        </a>
    </div>

    <div class="link-item">
        <a href="#">
            <i class="fal fa-hand-holding-usd" aria-hidden="true"></i>
            <span><?php echo app('translator')->get('Withdraw'); ?></span>
        </a>
    </div>
    <div class="link-item">
        <button onclick="toggleSideMenu()">
            <i class="fal fa-ellipsis-v-alt"></i>
            <span><?php echo app('translator')->get('Menu'); ?></span>
        </button>
    </div>
</div>

<div class="wrapper">
    <!------ sidebar ------->
    <?php echo $__env->make($theme.'partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- content -->
    <div id="content">
        <div class="overlay">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand d-lg-none" href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>"
                             alt="<?php echo e(config('basic.site_title')); ?>">
                    </a>
                    <button class="sidebar-toggler d-none d-lg-block" onclick="toggleSideMenu()">
                        <i class="far fa-bars"></i>
                    </button>
                    <!-- navbar text -->
                    <span class="navbar-text" id="pushNotificationArea">
                            <!-- notification panel -->
                            <?php if(config('basic.push_notification') == 1): ?>

                        <?php endif; ?>
                        <!-- User panel -->
                        <?php echo $__env->make($theme.'partials.userDropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </span>
                </div>
            </nav>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<?php echo $__env->yieldPushContent('loadModal'); ?>
<script src="<?php echo e(asset($themeTrue.'js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/range-slider.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/socialSharing.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/fancybox.umd.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/apexcharts.min.js')); ?>"></script>

<?php echo $__env->yieldPushContent('extra-js'); ?>


<script src="<?php echo e(asset('assets/global/js/pusher.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/vue.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/notiflix-aio-3.2.6.min.js')); ?>"></script>
<!-- custom script -->
<script src="<?php echo e(asset($themeTrue.'js/script.js')); ?>"></script>


<script>

    'use strict';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(".card-boxes").owlCarousel({
        loop: true,
        margin: -25,
        rtl: false,
        nav: false,
        dots: false,
        autoplay: false,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
        },
    });

    // dashboard sidebar
    window.onload = function () {
        var el = document.getElementById('sidebarCollapse');
        if (el == null) {
            return 0;
        } else {

            el.addEventListener("click", () => {
                document.getElementById("sidebar").classList.toggle("active");
                document.getElementById("content").classList.toggle("active");
            });
        }

        // for datepicker
        $(function () {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $("#salutation").selectmenu();
        });
    }

    <?php if(config('basic.push_notification') == 1): ?>
    let pushNotificationArea = new Vue({
        el: "#pushNotificationArea",
        data: {
            items: [],
        },
        mounted() {
            this.getNotifications();
            this.pushNewItem();
        },
        methods: {
            getNotifications() {
                let app = this;
                axios.get("<?php echo e(route('user.push.notification.show')); ?>")
                    .then(function (res) {
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "<?php echo e(route('user.push.notification.readAt', 0)); ?>";
                url = url.replace(/.$/, id);
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.getNotifications();
                            if (link != '#') {
                                window.location.href = link
                            }
                        }
                    })
            },
            readAll() {
                let app = this;
                let url = "<?php echo e(route('user.push.notification.readAll')); ?>";
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.items = [];
                        }
                    })
            },
            pushNewItem() {
                let app = this;
                let pusher = new Pusher("<?php echo e(env('PUSHER_APP_KEY')); ?>", {
                    encrypted: true,
                    cluster: "<?php echo e(env('PUSHER_APP_CLUSTER')); ?>"
                });
                let channel = pusher.subscribe('user-notification.' + "<?php echo e(Auth::id()); ?>");
                channel.bind('App\\Events\\UserNotification', function (data) {
                    app.items.unshift(data.message);
                });
                channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                    app.getNotifications();
                });
            }
        }
    });
    <?php endif; ?>

</script>

<?php echo $__env->yieldPushContent('script'); ?>


<?php if(session()->has('success')): ?>
    <script>
        Notiflix.Notify.success("<?php echo app('translator')->get(session('success')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('error')): ?>
    <script>
        Notiflix.Notify.failure("<?php echo app('translator')->get(session('error')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('warning')): ?>
    <script>
        Notiflix.Notify.warning("<?php echo app('translator')->get(session('warning')); ?>");
    </script>
<?php endif; ?>

<?php echo $__env->make('plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/layouts/user.blade.php ENDPATH**/ ?>