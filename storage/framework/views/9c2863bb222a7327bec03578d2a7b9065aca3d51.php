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
                                                    <h4><?php echo e($stock->last_cost_per_unit); ?> <?php echo e($basic->currency_symbol); ?></h4>
                                                    <button href="#"><i class="fa fa-cart-plus"></i></button>
                                                </div>
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
                                                aria-selected="true">Customer
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#contact-tab-pane" type="button" role="tab"
                                                aria-controls="contact-tab-pane" aria-selected="false">
                                            sales center
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="description-content mt-2">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                         aria-labelledby="home-tab" tabindex="0">

                                        <div class="cutomer-select">
                                            <select class="form-select js-example-basic-single selectedItems"
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
                                                <input type="email" class="form-control" id="exampleFormControlInput1"
                                                       placeholder="Email address">
                                            </div>
                                            <div class="mb-3">
                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                              placeholder="Message" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                         aria-labelledby="contact-tab" tabindex="0">
                                        <div class="cutomer-select">
                                            <select class="form-select js-example-basic-single"
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
                                                <input type="email" class="form-control" id="exampleFormControlInput1"
                                                       placeholder="Email address">
                                            </div>
                                            <div class="mb-3">
                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                              placeholder="Message" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-box">
                            <div class="cart-top d-flex align-items-center justify-content-between">
                                <h6>items in cart</h6>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                                    <i class="fa fa-times"></i>clear cart
                                </button>
                            </div>
                            <div class="cat-item d-flex">
                                <div class="tittle">UltraVision 4K Monitor</div>
                                <div class="quantity"><input type="number" value="1"></div>
                                <div class="prize">
                                    <h6>$190</h6>
                                </div>
                                <div class="remove">
                                    <a href="#"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="cat-item d-flex">
                                <div class="tittle">UltraVision 4K Monitor</div>
                                <div class="quantity"><input type="number" value="1"></div>
                                <div class="prize">
                                    <h6>$190</h6>
                                </div>
                                <div class="remove">
                                    <a href="#"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="cat-item d-flex">
                                <div class="tittle">UltraVision 4K Monitor</div>
                                <div class="quantity"><input type="number" value="1"></div>
                                <div class="prize">
                                    <h6>$190</h6>
                                </div>
                                <div class="remove">
                                    <a href="#"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="clear-cart">
                                <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModal"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="cartModal"></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>are you sure</h4>
                                                <h6>You won't be able to revert those!</h6>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary">Yes, remove it!</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total-box">
                            <div class="amount">
                                <div class="input-group mb-3">

                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
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
                                                            <label for="formFile" class="form-label">Document</label>
                                                            <input class="form-control" type="file" id="formFile">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formFile" class="form-label">Pay Date</label>
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
                                                    <button type="button" class="btn btn-primary">Comfirm Paid</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'

        $(document).ready(function () {
            $('.selectedItems').on('change', function () {
                let selectedValue = $(this).val();
                getSelectedItems(selectedValue);
            })
        })

        function getSelectedItems(value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                                             <button href="#"><i class="fa fa-cart-plus"></i></button>
                                          </div>
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

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xammp\htdocs\inventory_management\project\resources\views/themes/original/user/manageSales/index.blade.php ENDPATH**/ ?>