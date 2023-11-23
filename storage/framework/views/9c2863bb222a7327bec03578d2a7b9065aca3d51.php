<?php $__env->startSection('title', 'Manage Sales'); ?>

<?php $__env->startSection('content'); ?>

    <section class="pos-section section-1 ">
        <div class="container-fluid ">
            <div class="row main">
                <div class="col-xl-8 col-lg-8">
                    <div class="product-bg">
                        <div class="row g-2">
                            <div class="col-md-12">
                                <div class="product-top d-flex align-items-center flex-wrap ">
                                    <div class="input-group">
                                        <label for="" class="mb-2"><?php echo app('translator')->get('Filter By Items'); ?></label>
                                        <select class="form-select js-example-basic-single selectedItems"
                                                name="item_id"
                                                aria-label="Default select example">
                                            <option value="all"><?php echo app('translator')->get('All Items'); ?></option>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($item->id); ?>" <?php echo e(old('item_id') == $item->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($item->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row pushItem">
                            <?php if(count($stocks) > 0): ?>
                                <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="product-box shadow-sm p-3 mb-5 bg-body rounded">
                                            <div class="product-title">
                                                <?php if($stock->quantity > 0): ?>
                                                    <a href="javascript:void(0)"><?php echo app('translator')->get('in stock'); ?></a>
                                                <?php else: ?>
                                                    <a href="javascript:void(0)"
                                                       class="text-danger border-danger"><?php echo app('translator')->get('out of stock'); ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-img">
                                                <a href="javascript:void(0)">
                                                    <img class="img-fluid"
                                                         src="<?php echo e(getFile(config('location.itemImage.path').optional($stock->item)->image)); ?>"
                                                         alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-box ">
                                                <div class="product-content">
                                                    <h6>
                                                        <a href="javascript:void(0)"><?php echo e(optional($stock->item)->name); ?></a>
                                                    </h6>

                                                </div>
                                                <div
                                                    class="shopping-icon d-flex align-items-center justify-content-between">
                                                    <h4>
                                                        <button class="sellingPriceButton updateUnitPrice"
                                                                data-property="<?php echo e($stock); ?>"
                                                                data-route="<?php echo e(route('user.updateItemUnitPrice', $stock->id)); ?>"><?php echo e($stock->selling_price); ?> <?php echo e($basic->currency_symbol); ?></button>
                                                    </h4>
                                                    <?php if($stock->quantity > 0): ?>
                                                        <button class="btn btn-sm addToCartButton"
                                                                data-property="<?php echo e($stock); ?>"><i
                                                                class="fa fa-cart-plus"></i></button>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm addToCartButton opacity-0 disabled"><i
                                                                class="fa fa-cart-plus"></i></button>
                                                    <?php endif; ?>
                                                </div>
                                                <p>
                                                    <span>Purchase Price:</span> <?php echo e($stock->last_cost_per_unit); ?> <?php echo e($basic->currency_symbol); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img
                                        src="<?php echo e(asset('assets/global/img/no_data.gif')); ?>"
                                        class="card-img-top empty-state-img" alt="...">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="cart-side">
                        <div class="tab-box">
                            <div class="tab-tille">
                                <h4><?php echo app('translator')->get('sales by'); ?></h4>
                            </div>
                            <div class="description-tab">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#home-tab-pane" type="button" role="tab"
                                                aria-controls="home-tab-pane"
                                                aria-selected="true"><?php echo app('translator')->get('Customer'); ?>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#contact-tab-pane" type="button" role="tab"
                                                aria-controls="contact-tab-pane" aria-selected="false">
                                            <?php echo app('translator')->get('Sales Center'); ?>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="description-content mt-2">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                         aria-labelledby="home-tab" tabindex="0">

                                        <div class="cutomer-select mt-2">
                                            <label for="sales_center_id"
                                                   class="mb-2"><?php echo app('translator')->get('Which Sales Center?'); ?></label>
                                            <select class="form-select js-example-basic-single select-sales-center"
                                                    name="customer_id"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled><?php echo app('translator')->get('Select Sales Center'); ?></option>
                                                <?php $__currentLoopData = $salesCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saleCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($saleCenter->id); ?>" <?php echo e(old('sales_center_id') == $saleCenter->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($saleCenter->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="cutomer-select mt-3">
                                            <select class="form-select js-example-basic-single select-customer"
                                                    name="customer_id"
                                                    aria-label="Default select example">
                                                <option value="" selected disabled><?php echo app('translator')->get('Select Customer'); ?></option>

                                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id') == $customer->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($customer->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="cautomer-details">
                                            <div class="mb-2">
                                                <input type="text" class="form-control customerPhone" value=""
                                                       id="exampleFormControlInput1"
                                                       placeholder="Customer Phone">
                                            </div>
                                            <div class="mb-3">
                                    <textarea class="form-control customerAddress" id="exampleFormControlTextarea1"
                                              placeholder="Customer Address" rows="3" name="address"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                         aria-labelledby="contact-tab" tabindex="0">
                                        <div class="cutomer-select">
                                            <select
                                                class="form-select js-example-basic-single select-sales-center selectSalesCenter"
                                                name="sales_center_id"
                                                aria-label="Default select example">
                                                <option value="" selected disabled><?php echo app('translator')->get('Select Sales Center'); ?></option>

                                                <?php $__currentLoopData = $salesCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saleCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option
                                                        value="<?php echo e($saleCenter->id); ?>" <?php echo e(old('sales_center_id') == $saleCenter->id ? 'selected' : ''); ?>> <?php echo app('translator')->get($saleCenter->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="cautomer-details">
                                            <div class="mb-2">
                                                <input type="email" class="form-control owner-name"
                                                       id="exampleFormControlInput1"
                                                       placeholder="Owner Name">
                                            </div>

                                            <div class="mb-2">
                                                <input type="email" class="form-control owner-phone"
                                                       id="exampleFormControlInput1"
                                                       placeholder="Owner Phone">
                                            </div>

                                            <div class="mb-3">
                                    <textarea class="form-control sales-center-address" id="exampleFormControlTextarea1"
                                              placeholder="Sales Center Address" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(count($cartItems) > 0): ?>
                            <div class="cart-box">
                                <div class="cart-top d-flex align-items-center justify-content-between">
                                    <h6>items in cart</h6>
                                    <button type="button" class="btn clearCart">
                                        <i class="fa fa-times"></i>clear cart
                                    </button>
                                </div>

                                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="cat-item d-flex">
                                        <div class="tittle"><?php echo e(optional($cartItem->item)->name); ?></div>
                                        <div class="quantity"><input type="number" value="<?php echo e($cartItem->quantity); ?>">
                                        </div>
                                        <div class="prize">
                                            <h6><?php echo e($cartItem->cost); ?> <?php echo e($basic->currency_symbol); ?></h6>
                                        </div>
                                        <div class="remove">
                                            <a href="javascript:void(0)" class="clearSingleCartItem" data-route="<?php echo e(route('user.clearSingleCartItem', $cartItem->id)); ?>" data-name="<?php echo e(optional($cartItem->item)->name); ?>"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>

                            <div class="total-box">
                                <div class="amount">
                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control"
                                               aria-label="Amount (to the nearest dollar)">
                                        <span class="input-group-text">$</span>
                                    </div>
                                </div>
                                <div class="total">
                                    <ul>
                                        <li>
                                            <h5>subtotal</h5>
                                            <h6>$2290</h6>
                                        </li>
                                        <li>
                                            <h5>Discount</h5>
                                            <h6>$0</h6>
                                        </li>
                                        <li>
                                            <h5>Vat</h5>
                                            <h6>(+6%) $68.70</h6>
                                        </li>
                                    </ul>
                                    <div class="total-amount d-flex align-items-center justify-content-between">
                                        <h5>total</h5>
                                        <h6>$2358.7</h6>
                                    </div>
                                    <div class="order-btn d-flex flex-wrap">
                                        <button class="cancel">cacel order</button>
                                        <button type="button" class="porcced" data-bs-toggle="modal"
                                                data-bs-target="#procced">procced order
                                        </button>
                                    </div>
                                    <div class="procced-modal">
                                        <div class="modal fade" id="procced" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog ">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">make
                                                            payment</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div
                                                            class="total-amount d-flex align-items-center justify-content-between">
                                                            <h5>total</h5>
                                                            <h6>$2358.7</h6>
                                                        </div>
                                                        <div
                                                            class="enter-amount d-flex justify-content-between align-items-center">
                                                            <h6>Enter amount customer paid</h6>
                                                            <input type="number" class="form-control"
                                                                   id="exampleFormControlInput1">
                                                        </div>
                                                        <div
                                                            class="change-amount d-flex align-items-center justify-content-between">
                                                            <h4>Change amount</h4>  <span>$-2358.70</span>
                                                        </div>
                                                        <div
                                                            class="total-amount d-flex align-items-center justify-content-between">
                                                            <h5>total</h5>
                                                            <h6>$2358.7</h6>
                                                        </div>
                                                        <div class="file">
                                                            <div class="mb-3">
                                                                <label for="formFile"
                                                                       class="form-label">Document</label>
                                                                <input class="form-control" type="file" id="formFile">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Pay
                                                                    Date</label>
                                                                <input class="form-control" type="date" id="formFile">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Payment
                                                                    Note</label>
                                                                <textarea class="form-control"
                                                                          id="exampleFormControlTextarea1"
                                                                          placeholder="Message" rows="5"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">cancel
                                                        </button>
                                                        <button type="button" class="btn btn-primary">Comfirm Paid
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="clear-cart profile-setting">
        <div class="modal fade" id="updateUnitPriceModal" tabindex="-1" aria-labelledby="cartModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cartModal">Update Unit Price</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="" class="m-0 p-0 updateItemUnitPriceRoute" method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>
                        <div class="modal-body">
                            <div class="input-box col-md-12">
                                <label for="selling_price"><?php echo app('translator')->get('Cost Per Unit'); ?></label>
                                <div class="input-group">
                                    <input type="text" name="selling_price"
                                           class="form-control selling_cost_per_unit <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                           value="<?php echo e(old('selling_price')); ?>">
                                    <div class="input-group-append" readonly="">
                                        <div class="form-control currency_symbol append_group">
                                            <?php echo e($basic->currency_symbol); ?>

                                        </div>
                                    </div>
                                    <?php if($errors->has('selling_price')): ?>
                                        <div
                                            class="error text-danger"><?php echo app('translator')->get($errors->first('selling_price')); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Update</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="clear-cart profile-setting">
        <div class="modal fade" id="clearCartModal" tabindex="-1" aria-labelledby="clearCartModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cartModal">Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="<?php echo e(route('user.clearCartItems')); ?>" class="m-0 p-0 updateItemUnitPriceRoute"
                          method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <div class="modal-body">
                            <p>Are you sure clear all cart items?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Clear</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="clear-cart profile-setting">
        <div class="modal fade" id="clearSingleCartModal" tabindex="-1" aria-labelledby="clearSingleCartModal"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cartModal">Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="" class="m-0 p-0 clearSingleCartItemRoute"
                          method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <div class="modal-body">
                            <p>Are you sure clear <span class="single-cart-item-name"></span> cart items?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Clear</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'

        $('.select-customer').select2({
            width: '100%',
        }).on('select2:open', () => {
            $(".select2-results:not(:has(a))").append(`<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="<?php echo e(route('user.createCustomer')); ?>"
                    class="btn btn-outline-primary" target="_blank">+ Create New Customer </a>
                    </li>`);
        });

        $('.select-sales-center').select2({
            width: '100%',
        }).on('select2:open', () => {
            $(".select2-results:not(:has(a))").append(`<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="<?php echo e(route('user.createSalesCenter')); ?>"
                    class="btn btn-outline-primary" target="_blank">+ Create Sales Center </a>
                    </li>`);
        });

        $(document).ready(function () {
            $('.selectedItems').on('change', function () {
                let selectedValue = $(this).val();
                getSelectedItems(selectedValue);
            })
        })

        function getSelectedItems(value) {
            $.ajax({
                url: "<?php echo e(route('user.getSelectedItems')); ?>",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    let stocks = response.stocks;
                    let itemsData = '';

                    if (stocks.length === 0) {
                        itemsData = `<div class="col-md-12 d-flex justify-content-center">
                                        <img src="<?php echo e(asset('assets/global/img/no_data.gif')); ?>" class="card-img-top empty-state-img" alt="..." style="width: 300px">
                                    </div>`
                    } else {
                        stocks.forEach(function (stock) {
                            itemsData += `
                                <div class="col-xl-4 col-lg-6">
                                    <div class="product-box shadow-sm p-3 mb-5 bg-body rounded">
                                       <div class="product-title">
                                            ${stock.quantity > 0 ? '<a href="javascript:void(0)">in stock</a>' : '<a href="javascript:void(0)" class="text-danger border-danger">out of stock</a>'}
                                       </div>

                                        <div class="product-img">
                                            <a href="javascript:void(0)">
                                                <img class="img-fluid" src="${stock.item.image}" alt="">
                                            </a>
                                        </div>
                                        <div class="product-content-box ">
                                          <div class="product-content">
                                            <h6>
                                                <a href="javascript:void(0)">${stock.item.name}</a>
                                            </h6>
                                          </div>
                                          <div class="shopping-icon d-flex align-items-center justify-content-between">
                                             <h4>${stock.last_cost_per_unit} <?php echo e($basic->currency_symbol); ?></h4>
                                             ${stock.quantity > 0 ? '<button href="#"><i class="fa fa-cart-plus"></i></button>' : '<button class="btn btn-sm addToCartButton opacity-0 disabled"><i class="fa fa-cart-plus"></i></button>'}
                                          </div>
                                           <p><span>Purchase Price:</span> ${stock.last_cost_per_unit} <?php echo e($basic->currency_symbol); ?></p>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    }

                    $('.pushItem').html(itemsData);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $('.select-customer').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedCustomer(selectedValue);
        });

        function getSelectedCustomer(value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "<?php echo e(route('user.getSelectedCustomer')); ?>",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    let customer = response.customer;
                    $('.customerPhone').val(customer.phone);
                    $('.customerAddress').val(customer.address);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $('.selectSalesCenter').on('change', function () {
            let selectedValue = $(this).val();
            getSelectedSalesCenter(selectedValue);
        });

        function getSelectedSalesCenter(value) {
            $.ajax({
                url: "<?php echo e(route('user.getSelectedSalesCenter')); ?>",
                method: 'POST',
                data: {
                    id: value,
                },
                success: function (response) {
                    let salesCenter = response.salesCenter;
                    $('.owner-name').val(salesCenter.owner_name);
                    $('.owner-phone').val(salesCenter.user.phone);
                    $('.sales-center-address').val(salesCenter.address);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $('.addToCartButton').on('click', function () {
            let dataProperty = $(this).data('property');
            getAddToCartItems(dataProperty);
        });

        function getAddToCartItems(dataProperty) {
            $.ajax({
                url: "<?php echo e(route('user.storeCartItems')); ?>",
                method: 'POST',
                data: {
                    data: dataProperty,
                },
                success: function (response) {
                    console.log(response.cartItems);
                    if (response.status){
                        Notiflix.Notify.Success(response.message);
                    }else{
                        Notiflix.Notify.Warning(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }


        $(document).on('click', '.updateUnitPrice', function () {
            var updateUnitPriceModal = new bootstrap.Modal(document.getElementById('updateUnitPriceModal'))
            updateUnitPriceModal.show();

            let dataRoute = $(this).data('route');
            let dataProperty = $(this).data('property');
            $('.updateItemUnitPriceRoute').attr('action', dataRoute)
            $('.selling_cost_per_unit').val(dataProperty.selling_price);

        });

        $(document).on('click', '.clearCart', function () {
            var clearCartModal = new bootstrap.Modal(document.getElementById('clearCartModal'))
            clearCartModal.show();
        });

        $(document).on('click', '.clearSingleCartItem', function () {
            var clearSingleCartModal = new bootstrap.Modal(document.getElementById('clearSingleCartModal'))
            clearSingleCartModal.show();

            let dataName = $(this).data('name');
            let route    = $(this).data('route');

            $('.single-cart-item-name').text(dataName);
            $('.clearSingleCartItemRoute').attr('action', route);
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/manageSales/index.blade.php ENDPATH**/ ?>