<script>
    'use strict'
    $(document).ready(function () {
        $('.selectedDivision').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedDivisionDistrict(selectedValue);
        })

        function getSelectedDivisionDistrict(value) {
            $.ajax({
                url: "<?php echo e(route('user.getSelectedDivisionDistrict')); ?>",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    $('.selectedDistrict').empty();
                    let responseData = response;
                    responseData.forEach(res => {
                        $('.selectedDistrict').append(`<option value="${res.id}">${res.name}</option>`)
                    })

                    $('.selectedDistrict').prepend(`<option value="" selected disabled><?php echo app('translator')->get('Select District'); ?></option>`)
                },
                error: function (xhr, status, error) {
                    console.log(error)
                }
            });
        }


        $('.selectedDistrict').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedDistrictUpazila(selectedValue);
        })

        function getSelectedDistrictUpazila(value) {
            $.ajax({
                url: "<?php echo e(route('user.getSelectedDistrictUpazila')); ?>",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    $('.selectedUpazila').empty();
                    let responseData = response;
                    responseData.forEach(res => {
                        $('.selectedUpazila').append(`<option value="${res.id}">${res.name}</option>`)
                    })

                    $('.selectedUpazila').prepend(`<option value="" selected disabled><?php echo app('translator')->get('Select Upazila'); ?></option>`)
                },
                error: function (xhr, status, error) {
                    console.log(error)
                }
            });
        }


        $('.selectedUpazila').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedUpazilaUnion(selectedValue);
        })

        function getSelectedUpazilaUnion(value) {

            $.ajax({
                url: "<?php echo e(route('user.getSelectedUpazilaUnion')); ?>",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    $('.selectedUnion').empty();
                    let responseData = response;
                    responseData.forEach(res => {
                        $('.selectedUnion').append(`<option value="${res.id}">${res.name}</option>`)
                    })

                    $('.selectedUnion').prepend(`<option value="" selected disabled><?php echo app('translator')->get('Select Union'); ?></option>`)
                },
                error: function (xhr, status, error) {
                    console.log(error)
                }
            });
        }


        function getOldSelectedDivisionDistrict(){
            let divisionId = $('.selectedDivision').val();
            let OldDistrictId = $('.selectedDistrict').data('olddistrictid');
            $.ajax({
                url: "<?php echo e(route('user.getSelectedDivisionDistrict')); ?>",
                method: 'POST',
                data: {
                    id: divisionId,
                },
                success: function (response) {
                    let responseData = response;
                    responseData.forEach(res => {
                        $('.selectedDistrict').append(`<option value="${res.id}" ${res.id == OldDistrictId ? 'selected' : ''}>${res.name}</option>`)
                    })

                },
                error: function (xhr, status, error) {
                    console.log(error)
                }
            });
        }

        getOldSelectedDivisionDistrict();


        function getOldSelectedDistrictUpazila(){
            let districtId = $('.selectedDistrict').data('olddistrictid');
            let OldUpazilaId = $('.selectedUpazila').data('oldupazilaid');

            $.ajax({
                url: "<?php echo e(route('user.getSelectedDistrictUpazila')); ?>",
                method: 'POST',
                data: {
                    id: districtId,
                },
                success: function (response) {
                    let responseData = response;
                    responseData.forEach(res => {
                        $('.selectedUpazila').append(`<option value="${res.id}" ${res.id == OldUpazilaId ? 'selected' : ''}>${res.name}</option>`)
                    })
                },
                error: function (xhr, status, error) {
                    console.log(error)
                }
            });
        }

        getOldSelectedDistrictUpazila();


        function getOldSelectedUpazilaUnion(){
            let upazilaId = $('.selectedUpazila').data('oldupazilaid');
            let OldUnionId = $('.selectedUnion').data('oldunionid');

            $.ajax({
                url: "<?php echo e(route('user.getSelectedUpazilaUnion')); ?>",
                method: 'POST',
                data: {
                    id: upazilaId,
                },
                success: function (response) {
                    let responseData = response;
                    responseData.forEach(res => {
                        $('.selectedUnion').append(`<option value="${res.id}" ${res.id == OldUnionId ? 'selected' : ''}>${res.name}</option>`)
                    })
                },
                error: function (xhr, status, error) {
                    console.log(error)
                }
            });
        }

        getOldSelectedUpazilaUnion();

    });
</script>
<?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/partials/locationJs.blade.php ENDPATH**/ ?>