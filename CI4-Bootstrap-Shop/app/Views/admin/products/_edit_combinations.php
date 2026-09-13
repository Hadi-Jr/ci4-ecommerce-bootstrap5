<?php
if (empty($product_combinations)) {
    ?>
    <p>There are no combinations for this product</p>
    <?php
} else {
foreach ($product_combinations as $comb_name_id => $combination) {
    ?>
    <div class="card mb-3 comb-card saved_combination"
         data-combn-id="<?= $comb_name_id ?>">
        <div class="card-body">
            <p class="card-title fw-semibold mb-2 text-center comb-name"></p>
            <div class="d-flex gap-2 mb-3">
                <input type="text" class="form-control comb-title-value" placeholder="Title (e.g., Color)"
                       value="<?= $combination['comb_name_title'] ?>" required>
                <button type="button" class="btn btn-danger remove-existing-comb-name">×</button>
            </div>

            <div class="row comb-values">
                <?php
                foreach ($combination['comb_values'] as $key => $comb_value) {
                    ?>
                    <div class="col-12 col-md-6 combValueContainer mb-2"
                         data-combv-id="<?= $comb_value['comb_value_id'] ?>">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title fw-semibold mb-3 text-center comb-value"></p>

                                <input type="text" class="form-control mb-2 comb-value-title" placeholder="Title"
                                       value="<?= $comb_value['comb_value_title'] ?>" required>

                                <input type="text" class="form-control mb-2 sku" placeholder="Sku"
                                       value="<?= $comb_value['comb_sku'] ?>" required>

                                <input type="number" class="form-control mb-2 price" placeholder="Price"
                                       value="<?= $comb_value['comb_price'] ?>"required>

                                <input type="text" class="form-control mb-2 promo" placeholder="Promo"
                                       value="<?= $comb_value['comb_promo'] ?? 0.0 ?>">

                                <input type="number" class="form-control mb-2 qty" placeholder="Quantity"
                                       value="<?= $comb_value['comb_qty'] ?>" required>

                                <button type="button" class="btn btn-danger btn-sm mt-2 fw-bold
                                                            remove-existing-comb-value">
                                    Remove
                                </button>
                            </div>
                        </div>

                        <input type="hidden" class="comb_value_title_input"
                               name="old_combinations[<?= $comb_name_id ?>][values][<?= $comb_value['comb_value_id'] ?>][title]"
                               value="<?= $comb_value['comb_value_title'] ?>">

                        <input type="hidden" class="sku_input"
                               name="old_combinations[<?= $comb_name_id ?>][values][<?= $comb_value['comb_value_id'] ?>][sku]"
                               value="<?= $comb_value['comb_sku'] ?>">

                        <input type="hidden" class="price_input"
                               name="old_combinations[<?= $comb_name_id ?>][values][<?= $comb_value['comb_value_id'] ?>][price]"
                               value="<?= $comb_value['comb_price'] ?>">

                        <input type="hidden" class="promo_input"
                               name="old_combinations[<?= $comb_name_id ?>][values][<?= $comb_value['comb_value_id'] ?>][promo]"
                               value="<?= $comb_value['comb_promo'] ?? 0.0 ?>">

                        <input type="hidden" class="qty_input"
                               name="old_combinations[<?= $comb_name_id ?>][values][<?= $comb_value['comb_value_id'] ?>][qty]"
                               value="<?= $comb_value['comb_qty'] ?>">
                    </div>
                <?php
                }
                ?>
            </div>

            <button type="button" class="btn btn-success btn-sm mt-2 fw-bold mt-2 add-comb-value">
                Add Comb Value
            </button>
        </div>

        <input type="hidden" class="comb_name_title_input"
               name="old_combinations[<?= $comb_name_id ?>][title]"
               value="<?= $combination['comb_name_title'] ?>">
    </div>
<?php
    }
}

