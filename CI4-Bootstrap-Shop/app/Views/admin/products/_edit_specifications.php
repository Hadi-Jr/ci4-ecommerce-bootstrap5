<?php
if (empty($features)) {
    ?>
    <p>There are no features for this product</p>
    <?php
} else {
    foreach ($features as $feature) {
        ?>
        <div class="feature-row d-flex gap-2 mb-2" data-feature-id="<?= $feature->id ?>">
            <input type="text" class="form-control" placeholder="Key (e.g., Color)"
                   name="feature_key[]" value="<?= $feature->key ?>"
                   required>
            <input type="text" class="form-control" placeholder="Value (e.g., Red)"
                   name="feature_value[]" value="<?= $feature->value ?>"
                   required>
            <button type="button" class="btn btn-danger remove-existing-feature">×</button>
        </div>
        <?php
    }
}
?>
