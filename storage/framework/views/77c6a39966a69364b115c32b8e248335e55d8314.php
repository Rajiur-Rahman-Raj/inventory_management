<script>
    'use strict'

    $(document).on('change', '.selectedItem', function (){
        let _this = $(this);
        getSelectedItemUnit(_this);
    });


    function getSelectedItemUnit(_this){
        let selectedItemId = _this.val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "<?php echo e(route('user.getSelectedItemUnit')); ?>",
            method: 'POST',
            data: {
                itemId: selectedItemId,
            },
            success: function (response) {
                _this.parents('.parentItemRow').find('.item_unit').text(response.unit);
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });
    }


    $(document).on('change', '.selectedRawItem', function (){
        let _this = $(this);
        getSelectedRawItemUnit(_this);
    });

    function getSelectedRawItemUnit(_this){
        let selectedRawItemId = _this.val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "<?php echo e(route('user.getSelectedRawItemUnit')); ?>",
            method: 'POST',
            data: {
                itemId: selectedRawItemId,
            },
            success: function (response) {
                _this.parents('.parentRawItemRow').find('.raw_item_unit').text(response.unit);
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });
    }



</script>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/partials/getItemUnit.blade.php ENDPATH**/ ?>