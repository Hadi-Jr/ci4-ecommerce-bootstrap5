<!-- ORDER DETAILS START -->
<div class="row text-center mt-3">
    <h3 class="fw-bold">Order Details</h3>
</div>

<div class="row mt-3 p-2">
    <div class="col-12">
        <div class="card p-3">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-5 fw-bold">Order ID:</div>
                        <div class="col-7">#ORD-<?=date('Y') . '-' . $order_details['order_data']['order_id']?></div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-5 fw-bold">Order Date:</div>
                        <div class="col-7"><?= $order_details['order_data']['order_date'] ?></div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-5 fw-bold">Status:</div>
                        <div class="col-7">
                            <?php
                            $bs_class = 'success';
                            if ($order_details['order_data']['status'] === 'pending') {
                                $bs_class = 'warning';
                            } else if ($order_details['order_data']['status'] === 'cancelled') {
                                $bs_class = 'danger';
                            }
                            ?>
                            <span class="badge bg-<?= $bs_class ?> bg-opacity-75 text-white">
                                <?= ucfirst($order_details['order_data']['status']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-5 fw-bold">Payment:</div>
                        <div class="col-7">
                            <span class="badge bg-success bg-opacity-75 text-white">Paid</span>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-5 fw-bold">Payment method:</div>
                        <div class="col-7"><?= ucwords($order_details['order_data']['payment_method']) ?></div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-5 fw-bold">Delivery Address:</div>
                        <div class="col-7">
                            <?= $order_details['order_data']['full_name'] ?><br>
                            <?= $order_details['order_data']['city'] . ', '
                            . $order_details['order_data']['state']  . ' , '
                            . $order_details['order_data']['country'] . ' - '
                            . $order_details['order_data']['street'] . ' '
                            . $order_details['order_data']['zip_code'] . ' '
                            . $order_details['order_data']['phone_number'] ?>

                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-5 fw-bold">Shipping method:</div>
                        <div class="col-7">Standard (7 days)</div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-5 fw-bold">Delivered on:</div>
                        <div class="col-7"><?= $order_details['order_data']['delivered_at'] ?? 'Not delivered yet' ?></div>
                    </div>

                    <div class="row mt-5 pt-3 border-top d-none d-md-block">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <span>Subtotal (<?= count($order_details['product_data']) ?> items):</span>
                                        <span>€<?= $order_details['order_data']['total_amount'] ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Shipping:</span>
                                        <span>€0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Tax:</span>
                                        <span>Included</span>
                                    </div>
                                    <div class="d-flex justify-content-between fw-bold fs-6 mt-2 pt-2 border-top">
                                        <span>Total:</span>
                                        <span>€<?= $order_details['order_data']['total_amount'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 mt-5 mt-md-0">
                    <?php
                    foreach ($order_details['product_data'] as $data) {
                        ?>
                        <div class="row mb-3">
                            <div class="col-12 d-flex gap-3 align-items-center">
                                <div class="border rounded p-1">
                                    <img class="img-fluid order-details-product-image"
                                         src="<?= base_url($data['image']) ?>" alt="Product">
                                </div>
                                <div class="small">
                                    <a class="mb-2" href="<?= base_url('/product/' . $data['slug']) ?>">
                                        <span class="line-clamp-2"><?= $data['name'] ?></span>
                                        <span class="fw-bold">x<?= $data['quantity']?></span>
                                    </a>
                                    <p class="mb-0">
                                        Price: €<?= $data['price'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="row mt-3 pt-3 border-top d-md-none">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <span>Subtotal (<?= count($order_details['product_data']) ?> items):</span>
                                        <span>€<?= $order_details['order_data']['total_amount'] ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Shipping:</span>
                                        <span>€0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Tax:</span>
                                        <span>Included</span>
                                    </div>
                                    <div class="d-flex justify-content-between fw-bold fs-6 mt-2 pt-2 border-top">
                                        <span>Total:</span>
                                        <span>€<?= $order_details['order_data']['total_amount'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 pt-3 border-top">
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-outline-danger btn-sm"
                            <?= $order_details['order_data']['status'] === 'pending' ? '' : 'disabled'?>> Cancel Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ORDER DETAILS END -->