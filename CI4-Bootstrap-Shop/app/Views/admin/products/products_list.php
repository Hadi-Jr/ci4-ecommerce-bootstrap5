<!-- PRODUCTS LIST START -->
<h1 class="h3 mb-3"><strong>Products</strong> Table</h1>

<div class="row justify-content-center mb-5">
    <div class="card shadow border-0 table-responsive">
        <table id="productsTable" class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">SKU</th>
                <th scope="col">Price</th>
                <th scope="col">Promo</th>
                <th scope="col">Stock</th>
                <th scope="col">Units Sold</th>
                <th scope="col">Reviews</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
            foreach ($products as $product) {
                ?>
                <tr>
                    <td><?= $product->id ?></td>
                    <td><a href="<?= base_url('/product/' . $product->slug) ?>"><?= $product->name ?></a></td>
                    <td><?= $product->sku?></td>
                    <td class="text-center">€<?= $product->price?></td>
                    <td class="text-center">€<?= $product->promo?></td>
                    <td class="text-center"><?= $product->stock_quantity?></td>
                    <td class="text-center"><?= $product->total_units_sold?></td>
                    <td class="text-center"><?= number_format($product->avg_rating, 1) ?> / 5</td>
                    <td data-id="<?= $product->id ?>">
                        <i class="fa-solid <?= $product->status ? 'fa-toggle-on' : 'fa-toggle-off' ?> pointer status-toggle-btn"
                           data-status="<?= $product->status ? 'activated' : 'deactivated' ?>"
                           style="font-size: 20px;"></i>
                        <a href="<?= base_url('/edit-product-view/') . $product->id ?>">
                            <i class="fa-solid fa-pen-to-square pointer ms-1" style="font-size: 20px;"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
        if ($total_pages > 1) {
            $visible_pages = 5;
            $start_page = max(1, $current_page - 2);
            $end_page = min($total_pages, $start_page + $visible_pages - 1);

            if (($end_page - $start_page + 1) < $visible_pages) {
                $start_page = max(1, $end_page - $visible_pages + 1);
            }
            ?>
            <div class="row mb-2">
                <div class="col-12 text-end">
                    <a class="btn" href="<?= base_url('/products-list') . '?page=1' ?>">«</a>
                    <a class="btn" href="<?= base_url('/products-list') . '?page=' . max(1, $current_page - 1)?>">‹</a>
                    <?php
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        ?>
                        <a class="btn"
                           href="<?= base_url('/products-list') . '?page=' . $i?>"><?= $i ?></a>
                        <?php
                    }
                    ?>
                    <a class="btn" href="<?= base_url('/products-list') . '?page=' . min($total_pages, $current_page + 1) ?>">›</a>
                    <a class="btn" href="<?= base_url('/products-list') . '?page=' . $total_pages ?>">»</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!-- PRODUCTS LIST END -->

<script>
    $('.status-toggle-btn').on('click', function () {
        let toggle_btn = $(this);
        let product_id = toggle_btn.closest('td').data('id');
        let status = toggle_btn.data('status');

        Swal.fire({
            title:`Are you sure you want to ${status === 'activated' ? 'deactivate' : 'activate'} this product ?`,
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/change-product-status') ?>',
                    method: 'post',
                    data: {
                        product_id: product_id,
                    },
                    dataType: 'json'
                }).done(function (response) {
                    if (response.status === 'success') {
                        toggle_btn.toggleClass('fa-toggle-on fa-toggle-off');

                        status = status === 'activated' ? 'deactivated' : 'activated';
                        toggle_btn.data('status', status);

                        Swal.fire({
                            icon: 'info',
                            text: `Product has been ${status}`,
                            position: 'bottom-left',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            }
        });
    });
</script>