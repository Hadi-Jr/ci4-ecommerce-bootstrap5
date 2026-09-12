<!-- ALERT MESSAGE START -->

<?php
    if (!empty($alert_message)) {
        ?>
        <div class="alert alert-<?= $alert_message['type'] ?>">
            <?= $alert_message['message'] ?>
        </div>
        <?php
    }
?>

<!-- ALERT MESSAGE END -->
