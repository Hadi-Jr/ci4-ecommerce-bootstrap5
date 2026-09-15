<div class="row justify-content-center mb-5 p-5">
    <div class="card shadow border-0 table-responsive">
        <table id="categoriesTable" class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Parent ID</th>
                <th scope="col">Slug</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
            foreach ($categories as $category) {
                ?>
            <tr>
                <td><?= esc($category->id) ?></td>
                <td><?= esc($category->name) ?></td>
                <td><?= esc($category->parent_id ?? '-')  ?></td>
                <td><?= esc($category->slug) ?></td>
                <td><?= esc($category->is_active) ?></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>