<?php

foreach ($attribute_values as $attribute_value) {
?>
<option value="<?= $attribute_value->id ?>" selected>
    <?= $attribute_value->value ?>
</option>
<?php
}
?>

