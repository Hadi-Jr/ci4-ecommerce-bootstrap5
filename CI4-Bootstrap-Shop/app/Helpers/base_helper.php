<?php

function getMeta(array $meta_data, $meta_key)
{
    $value = '';

    foreach ($meta_data as $meta) {
        if ($meta['key'] === $meta_key) {
            $value = $meta['value'];
        }
    }

    return $value;
}

function renderCategories($categories)
{
    foreach ($categories ?? [] as $category) {
        if (!empty($category->children)) {
            ?>
            <li class="border-0 list-group-item list-item-clickable">
                <a href="#cat-<?= esc($category->id, 'attr') ?>" class="d-flex justify-content-between"
                   data-bs-toggle="collapse" role="button" aria-expanded="false"
                   aria-controls="cat-<?= esc($category->id, 'attr') ?>">
                    <?= esc($category->name) ?>
                    <i class="fa-solid fa-sort-down" style="color: rgb(125, 112, 112)"></i>
                </a>
                <ul class="collapse list-unstyled ms-1 mt-2 list-group" id="cat-<?= esc($category->id, 'attr') ?>">
                    <?php
                    renderCategories($category->children);
                    ?>
                </ul>
            </li>
            <?php
        } else {
            ?>
            <li class="border-0 list-group-item list-item-clickable">
                <a href="<?= site_url('category/' . esc($category->slug, 'url')) ?>">
                    <?= esc($category->name) ?>
                </a>
            </li>
            <?php
        }
    }
}

function renderCategoriesAdmin($categories)
{
    foreach ($categories ?? [] as $category) {
        if (!empty($category->children)) {
            ?>
            <li>
                <details>
                    <summary class="mb-1" style="list-style: none;">
                        <i class="fa-solid fa-caret-down fs-5 me-2"></i>
                        <?= esc($category->name) ?>
                    </summary>

                    <ul class="list-unstyled ps-3">
                        <?php renderCategoriesAdmin($category->children);?>
                    </ul>
                </details>
            </li>
            <?php
        } else {
            ?>
            <li class="fw-bold mb-1">
                <a class="dropdown-item category-option" href="#" data-id="<?= esc($category->id, 'attr') ?>">
                    <?= esc($category->name) ?>
                </a>
            </li>
            <?php
        }
    }
}

function delete_directory($path)
{
    if (!is_dir($path)) {
        return;
    }

    $files = array_diff(scandir($path), ['.', '..']);
    foreach ($files as $file) {
        $file_path = $path . DIRECTORY_SEPARATOR . $file;

        if (is_dir($file_path)) {
            delete_directory($file_path);
        } else {
            unlink($file_path);
        }
    }

    rmdir($path);
}