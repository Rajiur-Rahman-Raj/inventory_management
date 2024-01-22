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
            url: "{{ route('user.getSelectedItemUnit') }}",
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


    $('.selectedRawItem').on('change', function (){
        let selectedRawItemId = $(this).val();
        getSelectedRawItemUnit(selectedRawItemId);
    });

    function selectedRawItemHandel(id = null){
        let selectedRawItemId = $(`.selectedRawItem_${id}`).val();
        getSelectedRawItemUnit(selectedRawItemId, id);
    }

    function getSelectedRawItemUnit(selectedRawItemId, id = null){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('user.getSelectedRawItemUnit') }}",
            method: 'POST',
            data: {
                itemId: selectedRawItemId,
            },
            success: function (response) {
                let rawItemUnitClass = '.raw_item_unit';
                if(id != null){
                    rawItemUnitClass = `.raw_item_unit_${id}`;
                }
                $(rawItemUnitClass).text(response.unit);
            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });
    }



</script>
