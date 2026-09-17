<div class="row justify-content-center mt-5 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">

            <form id="edit-category-form">

                <div class="row justify-content-end mb-3 mb-md-0 p-2">
                    <div class="col-auto">
                        <div id="status" class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   id="categoryStatusSwitch"
                                   data-checked="Active"
                                   data-unchecked="In Active"
                                   name="status"
                                   checked>
                            <label class="form-check-label status-label" for="categoryStatusSwitch">Active</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Edit Category
                        </h3>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="category_name" class="form-label fw-bold">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name"
                               placeholder="Enter a category name" value="<?= $category->name ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            Parent Category
                        </label>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle w-100 text-center fw-bold" type="button"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                Select Parent Category
                            </button>

                            <ul class="dropdown-menu w-100 p-3" style="max-height: 500px; overflow-y: auto;">
                                <li class="fw-bold mb-1">
                                    <a class="dropdown-item category-option" href="#"
                                       data-id="null"
                                       data-name="null">
                                        No parent
                                    </a>
                                </li>
                                <?php
                                foreach ($all_categories as $c) {
                                    if ($c->id === $category->category_id) {
                                        continue;
                                    }
                                    ?>
                                    <li class="fw-bold mb-1">
                                        <a class="dropdown-item category-option" href="#"
                                           data-id="<?= esc($c->id, 'attr') ?>"
                                           data-name="<?= esc($c->name, 'attr')?>" >
                                            <?= esc($c->name) ?>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="parent_id" class="form-label fw-bold">Parent Id</label>
                        <input type="text" class="form-control" id="parent_id" name="parent_id"
                               placeholder="-" value="<?= $category->parent_id ?>" readonly>
                        <small class="text-muted">Auto-generated from parent category</small>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="parent_name" class="form-label fw-bold">Parent Name</label>
                        <input type="text" class="form-control" id="parent_name" name="parent_name"
                               placeholder="-" value="<?= $category->parent_name ?>" readonly>
                        <small class="text-muted">Auto-generated from parent category</small>

                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="slug" class="form-label fw-bold">Slug</label>
                        <input type="text" class="form-control" id="category_slug" name="slug"
                               value="<?= $category->slug ?>" readonly>
                        <small class="text-muted">Auto-generated from category name</small>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="transfer_children" class="form-label fw-bold">Transfer Children</label>
                        <select class="form-select" id="transfer_children" name="transfer_children" aria-label="Transfer child categories">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <small class="text-muted">This will transfer the parent category and its children to the new category.</small>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="edit-category-btn">
                            Edit Category
                        </button>
                    </div>
                </div>

                <input type="hidden" name="category_id" id="category_id" value="<?= $category->category_id ?>">
            </form>
            <div class="mt-4" id="general-error"></div>
        </div>
    </div>
</div>

<script>
    $('.category-option').on('click', function (e) {
        e.preventDefault();

        $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');
        let parent_id = $(this).data('id') === 'null' ? null : $(this).data('id');
        let parent_name = $(this).data('name');

        $('#parent_id').val(parent_id);
        $('#parent_name').val(parent_name);
    });


    $('#edit-category-btn').on('click', function (e) {
        e.preventDefault();

        const post_data = $('#edit-category-form').serializeArray();

        $.ajax({
            url: '<?= base_url('/edit-category') ?>',
            method: 'post',
            data: post_data,
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: response.message,
                    toast: true,
                    position: "bottom-left",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: "#fff",
                    color: "#333",
                });

                setTimeout(function () {
                    location.reload()
                }, 2000);
            } else if (response.status === 'error') {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('d-block');

                $.each(response.errors, function (field, message) {
                    const input = $(`#${field}`);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(message);
                });
            }
        }).fail(function (xhr) {
            let message = xhr.responseJSON?.message;
            $('#general-error').html(`
                    <div class="alert alert-danger">
                        <strong>Oops!</strong><br>
                        ${message}
                    </div>
                `);

            $('#edit-attr-btn').prop('disabled', true);
        });;
    })
</script>