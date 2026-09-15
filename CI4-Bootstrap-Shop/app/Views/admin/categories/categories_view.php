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
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
            foreach ($categories as $category) {
                ?>
            <tr>
                <td><?= esc($category->id) ?></td>
                <td>
                    <a href="<?= base_url('/category/' . $category->slug) ?>">
                        <?= esc($category->name) ?>
                    </a>
                </td>
                <td><?= esc($category->parent_id ?? '-')  ?></td>
                <td><?= esc($category->slug) ?></td>
                <td><?= esc($category->is_active) ?></td>
                <td data-id="<?= $category->id ?>">
                    <i class="fa-solid <?= $category->is_active ? 'fa-toggle-on' : 'fa-toggle-off' ?> pointer status-toggle-btn"
                       data-status="<?= $category->is_active ? 'activated' : 'deactivated' ?>"
                       style="font-size: 20px;"></i>
                    <a href="<?= base_url('/edit-product-view/') . $category->id ?>">
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

<script>
    $('.status-toggle-btn').on('click', function (e) {
        let toggle_btn = $(this);
        let category_id = toggle_btn.closest('td').data('id');
        let status = toggle_btn.data('status');

        Swal.fire({
            title:`Are you sure you want to ${status === 'activated' ? 'deactivate' : 'activate'} this category ?`,
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/change-category-status') ?>',
                    method: 'post',
                    data: {
                        category_id: category_id,
                    },
                    dataType: 'json'
                }).done(function (response) {
                    if (response.status === 'success') {
                        toggle_btn.toggleClass('fa-toggle-on fa-toggle-off');

                        status = status === 'activated' ? 'deactivated' : 'activated';
                        toggle_btn.data('status', status);

                        Swal.fire({
                            icon: 'info',
                            text: `Category has been ${status}`,
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