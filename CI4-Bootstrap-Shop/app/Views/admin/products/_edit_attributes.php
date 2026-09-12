<?php
if (empty($product_attributes)) {
    ?>
    <p>There are no attributes for this product</p>
    <?php
} else {
foreach ($product_attributes as $key => $attribute) {
    ?>
    <div class="attr-row mb-3 d-flex gap-3">
        <select class="form-select attribute-name" name="attribute_name[]" required>
            <option value="<?= $attribute->attribute_id ?>" selected>
                <?= $attribute->attribute_name ?>
            </option>
            <?php
            foreach ($attribute_names as $attribute_name) {
                ?>
                <option value="<?= $attribute_name->id ?>"><?= $attribute_name->name ?></option>
                <?php
            }
            ?>
        </select>

        <select class="form-select attribute-value" name="attribute_value[]" required>
            <option value="<?= $attribute->attribute_value_id ?>" selected>
                <?= $attribute->attribute_value ?>
            </option>
        </select>

        <button type="button" class="btn btn-danger remove-existing-attribute">×</button>
    </div>
<?php
    }
}
?>


