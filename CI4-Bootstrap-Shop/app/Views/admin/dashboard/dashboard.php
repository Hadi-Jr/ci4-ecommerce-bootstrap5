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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck align-middle"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" >$<?= number_format($avg_order_value, 2) ?></div>
                            <div class="mb-0" >
                                <span class="text-danger"></span>
                                <span class="text-muted"></span>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users align-middle"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $products_sold ?></div>
                            <div class="mb-0" >
                                <span class="text-danger"></span>
                                <span class="text-muted"></span>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" >$<?=$earnings ?></div>
                            <div class="mb-0" >
                                <span class="text-success"></span>
                                <span class="text-muted"></span>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $customers ?></div>
                            <div class="mb-0" >
                                <span class="text-danger"></span>
                                <span class="text-muted"></span>
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
                                    <div class="stat text-primary" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $canceled_orders ?></div>
                            <div class="mb-0" >
                                <span class="text-success"></span>
                                <span class="text-muted"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body" >
                            <div class="row" >
                                <div class="col mt-0" >
                                    <h5 class="card-title">Low Stock Products</h5>
                                </div>

                                <div class="col-auto" >
                                    <div class="stat text-primary" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mt-1 mb-3" ><?= $low_stock_products_count ?></div>
                            <div class="mb-0" >
                                <span class="text-danger"></span>
                                <span class="text-muted"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 d-flex">
        <div class="card flex-fill">
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
                            <a href="<?= base_url('/product/' . $trending_product->slug) ?>">
                                <i class="fa-solid fa-link"></i>
                            </a>
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
                                    <a href="<?= base_url('/product/' . $product->slug) ?>">
                                        <i class="fa-solid fa-link"></i>
                                    </a>
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
        <div class="card flex-fill">
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
                showCloseButton: true
            });
        });
    });
</script>