<div class="row g-4 mt-2">
    <div class="col-12 col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="bg-light rounded-top p-4 text-center">
                <img src="<?= base_url($product_data['image']) ?>"
                     alt="Product Name" class="img-fluid">
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <span class="badge bg-warning text-dark px-3 py-2">
                        <?php if ($product_data['avg_rating'] == 0) { ?>
                            No rating yet
                        <?php } else { ?>
                            <?= number_format($product_data['avg_rating'], 1) ?>
                            <i class="bi bi-star-fill"></i> / 5
                        <?php } ?>
                    </span>
                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i><?= $product_data['stock_quantity'] ?> In stock
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex flex-column">

                <div class="row text-start mt-2 mb-4">
                    <div class="col-10">
                        <h4 class="fw-bold mb-1"><?= $product_data['name'] ?></h4>
                        <span class="text-muted small">
                            by <span class="fw-semibold text-dark"><?= $product_data['brand'] ?></span>
                        </span>
                    </div>
                    <div class="col-2 text-end">
                        <span class="badge rounded-pill <?= $product_data['status'] === '1' ? 'bg-success' : 'bg-secondary' ?> px-3 py-2">
                            <?= $product_data['status'] === '1' ? 'Active' : 'Inactive' ?>
                        </span>
                    </div>
                </div>

                <div class="bg-light rounded p-3 mb-3 d-flex align-items-baseline gap-2">
                    <?php if ((float) $product_data['promo'] > 0.0) { ?>
                        <span class="text-danger fs-5"><del><?= '€' . $product_data['price'] ?></del></span>
                        <span class="fs-3 fw-bold text-dark"><?= '€' . $product_data['promo'] ?></span>
                        <span class="badge bg-danger ms-auto">Sale</span>
                    <?php } else { ?>
                        <span class="fs-3 fw-bold text-dark"><?= '€' . $product_data['price'] ?></span>
                    <?php } ?>
                </div>

                <div class="row g-2 small mb-3">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <div class="text-muted">SKU</div>
                            <div class="fw-semibold"><?= $product_data['sku'] ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <div class="text-muted">Barcode</div>
                            <div class="fw-semibold"><?= $product_data['barcode'] ?></div>
                        </div>
                    </div>
                </div>

                <h6 class="text-uppercase text-muted small fw-bold mb-2 mt-4">Specifications</h6>
                <table class="table table-sm table-borderless admin-product-details-table">
                    <tbody>
                    <?php foreach ($features as $key => $value) { ?>
                        <tr class="border-bottom">
                            <th scope="row" class="w-25 text-muted fw-normal"><?= $key ?></th>
                            <td class="fw-semibold"><?= $value ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
