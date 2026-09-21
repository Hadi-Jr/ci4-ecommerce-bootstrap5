<?php
foreach ($orders as $order_id => $order) {
    ?>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3 p-md-4">

            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded p-2 me-2">
                            <span class="text-secondary fw-bold small">#</span>
                        </div>
                        <div>
                            <div class="fw-bold">Order #ORD-2026-<?= $order_id ?></div>
                            <div class="text-secondary small">Placed on <?= $order['order_data']['order_date'] ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-2 mt-md-0">
                    <div class="d-flex align-items-center gap-3">
                        <?php
                        $bs_class = 'success';
                        if ($order['order_data']['status'] === 'pending') {
                            $bs_class = 'warning';
                        } else if ($order['order_data']['status'] === 'cancelled') {
                            $bs_class = 'danger';
                        }
                        ?>
                        <span class="fw-semibold text-<?= $bs_class ?> d-flex align-items-center">
                                <div class="bg-<?= $bs_class ?> rounded-circle me-2 p-1"></div>
                                <?= ucfirst($order['order_data']['status']) ?>
                            </span>
                        <span class="text-secondary small">
                                Delivery in <?= (int) ((strtotime($order['order_data']['delivery_time'])
                                    - strtotime('today')) / 86400) ?> days
                            </span>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-2 mt-md-0 text-start text-md-end">
                    <span class="fw-bold fs-5">€<?= $order['order_data']['total_amount'] ?></span>
                    <span class="text-secondary small d-block d-md-inline ms-md-2">Total</span>
                </div>
            </div>

            <hr class="my-3">

            <div class="row align-items-center">
                <div class="col-12 col-md-8">
                    <div class="d-flex align-items-center gap-2 flex-wrap">

                        <?php
                        foreach (array_slice($order['product_data'], 0, 2, True)
                                 as $product_id => $product_data) {
                            ?>
                            <div class="border rounded p-1 order-image-border">
                                <a href="<?= base_url('/product/'. $product_data['slug']) ?>">
                                    <img class="img-fluid w-100 h-100" style="object-fit:cover;"
                                         src="<?= base_url($product_data['image']) ?>"
                                         alt="Product">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="border rounded d-flex align-items-center justify-content-center
                                    bg-light order-image-border">
                            <a href="<?= base_url('/order-details-track-nr/' . $tracking_number) ?>"
                               class="text-secondary fw-bold small">+<?= count($order['product_data']) - 2 ?></a>
                        </div>
                        <span class="text-secondary small ms-2"><?= count($order['product_data']) - 2 ?> more items</span>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-2 mt-md-0 text-start text-md-end">
                    <span class="badge bg-light text-secondary rounded px-3 py-2">Free Shipping</span>
                </div>
            </div>

            <div class="row align-items-center g-2 mt-4">
                <div class="col-12 col-md-6">
                    <div class="d-flex gap-2">
                        <a href="https://www.dhl.com/bg-en/home/tracking.html" class="cancel-order btn btn-outline-secondary btn-sm rounded px-4
                                flex-grow-1 flex-md-grow-0">
                            Track
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <a href="<?= base_url('/order-details-track-nr/' . $tracking_number) ?>"
                       class="btn gray-btn rounded px-4 w-100 w-md-auto">
                        View Full Order
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>