<!-- PRODUCTS LIST START -->
<div class="row justify-content-center mb-5 p-5">
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
                    <td><?= esc($product->id) ?></td>
                    <td><a href="<?= base_url('/product/' . $product->slug) ?>"><?= esc($product->name)?></a></td>
                    <td><?= esc($product->sku)?></td>
                    <td class="text-center">€<?= esc($product->price)?></td>
                    <td class="text-center">€<?= esc($product->promo)?></td>
                    <td class="text-center"><?= esc($product->stock_quantity)?></td>
                    <td class="text-center"><?= esc($product->total_units_sold)?></td>
                    <td class="text-center"><?= esc(number_format($product->avg_rating, 1)) ?> / 5</td>
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
                    type: 'json'
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