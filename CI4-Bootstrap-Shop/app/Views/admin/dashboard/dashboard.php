<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

<div class="row">
    <div class="col-xl-6 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" >
                                <div class="col mt-0" >
                                    <h5 class="card-title">Average Order Value</h5>
                                </div>

                                <div class="col-auto" >
                                    <div class="stat text-primary" >
                                        <i class="fa-solid fa-gauge" style="font-size: 20px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" >$<?= number_format($avg_order_value, 2) ?></div>
                            <div class="mb-0">
                                <span class="text-success"><?=$total_orders?></span>
                                <span class="text-muted">total orders</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" >
                            <div class="row" >
                                <div class="col mt-0" >
                                    <h5 class="card-title">Products Sold</h5>
                                </div>

                                <div class="col-auto" >
                                    <div class="stat text-primary" >
                                        <i class="fa-solid fa-cart-shopping" style="font-size: 17px"></i>                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $products_sold ?></div>
                            <div class="mb-0" >
                                <div class="mb-0">
                                    <span class="text-muted">Customer purchases</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body" >
                            <div class="row" >
                                <div class="col mt-0" >
                                    <h5 class="card-title">Earnings</h5>
                                </div>

                                <div class="col-auto" >
                                    <div class="stat text-primary" >
                                        <i class="fa-solid fa-dollar-sign" style="font-size: 20px"></i>                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" >$<?=$earnings ?></div>
                            <div class="mb-0">
                                <span class="text-success">Current earnings</span>
                                <span class="text-muted">from all orders</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" >
                            <div class="row" >
                                <div class="col mt-0" >
                                    <h5 class="card-title">Customers</h5>
                                </div>

                                <div class="col-auto" >
                                    <div class="stat text-primary" >
                                        <i class="fa-solid fa-user" style="font-size: 18px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $customers ?></div>
                            <div class="mb-0">
                                <span class="text-muted">Registered customers</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body" >
                            <div class="row" >
                                <div class="col mt-0" >
                                    <h5 class="card-title">Canceled Orders</h5>
                                </div>

                                <div class="col-auto" >
                                    <div class="stat text-primary">
                                        <i class="fa-solid fa-ban" style="font-size: 20px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $canceled_orders ?></div>
                            <div class="mb-0" >
                                <span class="text-muted">Overall</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card table-responsive">
                        <div class="card-body" >
                            <div class="row" >
                                <div class="col mt-0" >
                                    <h5 class="card-title">Low Stock Products</h5>
                                </div>

                                <div class="col-auto" >
                                    <div class="stat text-primary" >
                                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px"></i>                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $low_stock_products_count ?></div>
                            <div class="mb-0">
                                <span class="text-muted">Below threshold of 50 units</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 d-flex">
        <div class="card flex-fill table-responsive">
            <div class="card-header">
                <h5 class="card-title mb-0">Trending Products</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                <tr>
                    <th>View</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Units sold</th>
                    <th>Sales</th>
                    <th>Stock</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($trending_products as $trending_product) {
                    ?>
                    <tr>
                        <td>
                            <button data-id="<?= $trending_product->id ?>" class="btn btn-primary btn-sm view-product-btn">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                        <td>
                            <div class="line-clamp-2">
                                <?= $trending_product->name ?>
                            </div>
                        </td>
                        <td><?= $trending_product->sku ?></td>
                        <td><?= $trending_product->total_units_sold ?></td>
                        <td>$<?= $trending_product->total_sales ?></td>
                        <td><?= $trending_product->stock_quantity ?></td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Low Stock Products</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                <tr>
                    <th>View</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>SKU</th>
                    <th>Units sold</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($low_stock_products)) {
                        ?>
                            <tr>
                                <td colspan="3">No products are currently low in stock.</td>
                            </tr>
                    <?php
                    } else {
                        foreach ($low_stock_products as $product) {
                            ?>
                            <tr>
                                <td>
                                    <button data-id="<?= $product->id ?>" class="btn btn-primary btn-sm view-product-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                                <td><?= $product->name ?></td>
                                <td><?= $product->stock_quantity ?></td>
                                <td><?= $product->sku ?></td>
                                <td><?= $product->total_units_sold ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xl-6 d-flex">
        <div class="card flex-fill table-responsive">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Orders</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                <tr>
                    <th>View</th>
                    <th>Customer Email</th>
                    <th>Units sold</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($recent_orders as $recent_order) {
                    ?>
                    <tr>
                        <td>
                            <button data-id="<?= $recent_order->id ?>" class="btn btn-primary btn-sm view-order-btn">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                        <td><?= $recent_order->email_address ?></td>
                        <td>$<?= $recent_order->total_amount ?></td>
                        <td>
                            <?php
                                $cls_status = 'success';
                                if ($recent_order->status === 'cancelled') {
                                    $cls_status = 'danger';
                                } else if ($recent_order->status === 'pending') {
                                    $cls_status = 'warning';
                                }
                            ?>
                            <span class="badge bg-<?= $cls_status ?>"><?= $recent_order->status ?></span>
                        </td>
                        <td><?= $recent_order->order_date ?></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('.view-order-btn').on('click', function (e) {
        e.preventDefault();
        const order_id = $(this).data('id');

        $.ajax({
            url: '<?= base_url('/admin/order_detail/') ?>' + order_id,
            method: 'GET',
        }).done(function (response) {
            Swal.fire({
                title: 'Order Details',
                html: response,
                width: 1000,
                showCloseButton: true,
                showConfirmButton: false
            });
        });
    });

    $('.view-product-btn').on('click', function (e) {
        e.preventDefault();
        const product_id = $(this).data('id');

        $.ajax({
            url: '<?= base_url('/admin/product_details/') ?>' + product_id,
            method: 'GET',
        }).done(function (response) {
            Swal.fire({
                title: 'Product Details',
                html: response,
                width: 1000,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Edit Product'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `http://localhost:8080/edit-product-view/${product_id}`;
                }
            });
        });
    });
</script>