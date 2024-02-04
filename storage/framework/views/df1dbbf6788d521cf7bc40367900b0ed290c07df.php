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

<script>

    $(document).ready(function () {
        $('.notiflix-confirm').on('click', function () {

        })
    })
</script>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/admin/layouts/notification.blade.php ENDPATH**/ ?>