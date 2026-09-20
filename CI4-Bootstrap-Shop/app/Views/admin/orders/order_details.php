<!-- Shipping Address -->
<h6 class="text-muted fw-bold mb-2">SHIPPING ADDRESS</h6>
<div class="mb-4">
    <p class="mb-1"><?= $shipping_address['street'] ?></p>
    <p class="mb-1">
        <?= $shipping_address['city'] ?>,
        <?= $shipping_address['state'] ?>
        <?= $shipping_address['zip_code'] ?>
    </p>
    <p class="mb-0"><?= $shipping_address['country'] ?></p>
</div>

<!-- Products -->
<h6 class="text-muted small fw-bold mb-2">PRODUCTS</h6>
<table class="table table-hover admin-order-details-table">
    <thead>
    <tr>
        <th>Image</th>
        <th>Product</th>
        <th>SKU</th>
        <th>Qty</th>
        <th>Unit Price</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($products as $product_id => $product) {
        ?>
        <tr>
            <td>
                <img src="<?= $product['image_url'] ?>"
                     alt="<?= $product['slug'] ?>"
                     class="rounded border"
                     width="80" height="80">
            </td>
            <td>
                <a href="<?= base_url('/product/' . $product['slug'] ) ?>"
                   class="d-block text-start"><?= $product['product_name'] ?></a>
            </td>
            <td><?= $product['sku'] ?></td>
            <td><?= $product['quantity'] ?></td>
            <td>$<?= number_format($product['unit_price'], 2) ?></td>
            <td>$<?= number_format($product['subtotal'], 2) ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
