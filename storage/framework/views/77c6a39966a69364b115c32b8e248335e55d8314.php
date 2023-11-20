<script>
    'use strict'

    $('.selectedItem').on('change', function (){
        let selectedItemId = $(this).val();
        getSelectedItemUnit(selectedItemId);
    });

    function selectedItemHandel(id = null){
        let selectedItemId = $(`.selectedItem_${id}`).val();
        getSelectedItemUnit(selectedItemId, id);
    }

    function getSelectedItemUnit(selectedItemId, id = null){
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
                let itemUnitClass = '.item_unit';
                if(id != null){
                    itemUnitClass = `.item_unit_${id}`;
                }
                $(itemUnitClass).text(response.unit);
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });
    }
</script>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/partials/getItemUnit.blade.php ENDPATH**/ ?>