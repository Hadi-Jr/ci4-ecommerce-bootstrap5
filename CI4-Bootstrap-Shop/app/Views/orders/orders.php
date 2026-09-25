<!-- MY ORDERS STARTS -->
<div class="orders-page">
    <div class="row mb-4 mt-2 mt-lg-5">
        <div class="col-12 text-center">
            <h3 class="fw-bold">My Orders</h3>
        </div>
        <div class="col-12 text-md-end mt-3 mt-md-0">
        <span class="badge bg-info bg-opacity-10 text-info rounded px-3 py-2 me-2">
            <span class="fw-bold"><?= $overall_status['pending_count'] ?></span> Active
        </span>
            <span class="badge bg-success bg-opacity-10 text-success rounded px-3 py-2 me-2">
            <span class="fw-bold"><?= $overall_status['delivered_count'] ?></span> Delivered
        </span>
            <span class="badge bg-danger bg-opacity-10 text-danger rounded px-3 py-2">
            <span class="fw-bold"><?= $overall_status['cancelled_count'] ?></span> Canceled
        </span>
        </div>
    </div>

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
                                <?php
                                $delivery = '-';
                                if ($order['order_data']['status'] === 'pending') {
                                    $delivery = (int) ((strtotime($order['order_data']['delivery_time'])
                                                    - strtotime('today')) / 86400);
                                }
                                ?>
                                Delivery in <?= $delivery ?> days
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mt-2 mt-md-0 text-md-end">
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
                            <?php
                            if (count($order['product_data']) > 1) {
                                ?>
                                <div class="border rounded d-flex align-items-center justify-content-center
                                    bg-light order-image-border">
                                    <a href="<?= base_url('/order-details-track-nr/' . $tracking_number) ?>"
                                       class="text-secondary fw-bold small">+<?= count($order['product_data']) - 2 ?></a>
                                </div>
                                <span class="text-secondary small ms-2">+<?= count($order['product_data']) - 2 ?> more items</span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mt-2 mt-md-0 text-md-end">
                        <span class="badge bg-light text-secondary rounded px-3 py-2">Free Shipping</span>
                    </div>
                </div>


                <div class="row align-items-center g-2 mt-4">
                    <div class="col-12 col-md-6">
                        <div class="d-flex gap-2">
                            <button
                                    data-id="<?= $order_id ?>"
                                    class="cancel-order btn btn-outline-danger btn-sm rounded px-4
                                flex-grow-1 flex-md-grow-0 <?= $order['order_data']['status'] === 'pending' ? '' : 'disabled'?>">
                                Cancel
                            </button>

                            <a href="https://www.dhl.com/bg-en/home/tracking.html"
                               class="track-order btn btn-outline-secondary btn-sm rounded px-4
                                flex-grow-1 flex-md-grow-0">
                                Track
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-md-end">
                        <a href="<?= base_url('/order-details/' . $order_id) ?>"
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

</div>
<!-- MY ORDERS ENDS -->

<script>
    $(".cancel-order").on("click", function () {
        let order_id = $(this).data('id');
        Swal.fire({
            title: "Are you sure you want to cancel this order ?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            confirmButtonColor: "#f03434",
            cancelButtonColor: "#5a6771",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/cancel-order') ?>',
                    method: 'post',
                    data: {
                        order_id: order_id
                    },
                    dataType: 'json'
                }).done(function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Order Cancelled!",
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: "#46c82c",
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            title: "Request failed!",
                            text: response.message,
                            icon: "error",
                            confirmButtonColor: "#46c82c",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                });
            }
        });
    });
</script>