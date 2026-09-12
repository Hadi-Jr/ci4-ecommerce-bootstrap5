<!-- EDIT PRODUCT START -->

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">

            <form id="edit-product-form">
                <div class="row justify-content-end mb-2 mb-md-0 p-2">
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-black"
                                    type="button"
                                    data-bs-toggle="dropdown">
                                <i class="fa-solid fa-code-branch fs-4"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item" type="button">
                                        Edit Specifications
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button">
                                        Edit Combinations
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button">
                                        Edit Attributes
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button">
                                        Edit Images
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Edit Product
                        </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="product_name" class="form-label fw-bold">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name"
                               placeholder="Enter a product name" value="<?= $product->name ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="sku" class="form-label fw-bold">Product Code</label>
                        <input type="text" class="form-control" id="sku" name="sku"
                               placeholder="Enter a product code" value="<?= $product->sku ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="barcode" class="form-label fw-bold">Barcode</label>
                        <input type="text" class="form-control" id="barcode" name="barcode"
                               placeholder="Enter a barcode" value="<?= $product->barcode ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="brand" class="form-label fw-bold">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand"
                               placeholder="Enter a brand" value="<?= $product->brand ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="price" class="form-label fw-bold">Price</label>
                        <input type="number" class="form-control" id="price" name="price"
                               placeholder="0.00" min="0" step="0.01" value="<?= $product->price ?>"
                               required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="promo" class="form-label fw-bold">Promo Price</label>
                        <input type="number" class="form-control" id="promo" name="promo" placeholder="0.00" min="0"
                               step="0.01" value="<?= $product->promo ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6 mb-3">

                        <label class="form-label fw-bold">
                            Product Category
                        </label>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle w-100 text-center fw-bold" type="button"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                Select Category
                            </button>

                            <ul class="dropdown-menu w-100 p-3">
                                <?php renderCategoriesAdmin($categories ?? []) ?>
                            </ul>
                        </div>

                        <input type="hidden" name="category_id" id="category_id" value="<?= $product->category_id ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="quantity" class="form-label fw-bold">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               placeholder="Enter a quantity"
                               min="0" required value="<?= $product->stock_quantity ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label for="slug" class="form-label fw-bold">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug"
                               value="<?= $product->slug ?>" readonly>
                        <small class="text-muted">Auto-generated from product name</small>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="short-description" class="form-label fw-bold">Short Description</label>
                        <textarea class="form-control" id="short-description" name="short-description" rows="3"
                                  placeholder="Enter short description" required>
                            <?= $product->short_description ?>
                        </textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="method-of-use" class="form-label fw-bold">Method Of Use</label>
                        <textarea class="form-control" id="method-of-use" name="method-of-use" rows="3"
                                  placeholder="Enter method of use" required>
                            <?= $product->method_of_use ?>
                        </textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="long-description" class="form-label fw-bold">Long Description</label>
                    <textarea class="form-control" id="long-description" name="long-description" rows="4"
                              placeholder="Enter product description" required>
                        <?= $product->description ?>
                    </textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="edit-product-btn">
                            Edit Product
                        </button>
                    </div>
                </div>

                <input type="hidden" name="product_id" value="<?= $product->id ?>">
            </form>
            <div class="mt-4" id="general-error"></div>
        </div>
    </div>
</div>

<!--  EDIT PRODUCT END -->

<script>
    $('.category-option').on('click', function (e) {
        e.preventDefault();

        $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');

        let category_id = $(this).data('id');
        $('#category_id').val(category_id);
    });

    $('#edit-product-btn').on('click', function (e) {
        e.preventDefault();

        let data = $('#edit-product-form').serializeArray();

        $.ajax({
            url: '<?= base_url('/edit-product') ?>',
            method: 'post',
            data: data,
            dataType: 'json',
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
            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('d-block');

                $.each(response.errors, function (field, message) {
                    if (field.includes('general-error')) {
                        let general_error = $('#general-error');
                        general_error.text(message);
                        general_error.addClass('alert alert-danger');
                    } else {
                        const input = $(`#${field}`);
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').text(message);
                    }
                });
            }
        }).fail(function () {
            $('#general-error').html(`
                        <div class="alert alert-danger">
                            <strong>Oops!</strong><br>
                            We couldn't complete your request. Please try again.
                        </div>
                    `);

            $('#edit-product-btn').prop('disabled', true);
        });
    });

    $('#add-product-btn').on('click', function (e) {
        e.preventDefault();

        let product_data = new FormData($('#add-product-form')[0]);

        $.ajax({
            url: '<?= base_url('/add-product') ?>',
            method: 'post',
            data: product_data,
            dataType: 'json',
            contentType: false,
            processData: false
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
                    if (field.includes('feature')) {
                        $('.feature-row').each(function () {
                            const feature_key = $(this).find('input[name="feature_key[]"]');
                            const feature_value = $(this).find('input[name="feature_value[]"]');

                            if (feature_key.val().trim() === '') {
                                feature_key.addClass('is-invalid');
                            }

                            if (feature_value.val().trim() === '') {
                                feature_value.addClass('is-invalid');
                            }
                        });

                        $('.specs .invalid-feedback').text(message).addClass('d-block');
                    } else if(field.includes('comb')) {
                        $('.comb-card').each(function () {
                            const comb_name = $(this).find('.comb-title-value');

                            if (comb_name.val().trim() === '') {
                                comb_name.addClass('is-invalid');
                            }

                            $(this).find('.combValueContainer').each(function () {
                                const comb_title = $(this).find('.comb-value-title');
                                const comb_sku = $(this).find('.sku');
                                const comb_price = $(this).find('.price');
                                const comb_qty = $(this).find('.qty');

                                if (comb_title.val().trim() === '') {
                                    comb_title.addClass('is-invalid');
                                }

                                if (comb_sku.val().trim() === '') {
                                    comb_sku.addClass('is-invalid');
                                }

                                if (comb_price.val().trim() === '') {
                                    comb_price.addClass('is-invalid');
                                }

                                if (comb_qty.val().trim() === '') {
                                    comb_qty.addClass('is-invalid');
                                }

                                $('.variants .invalid-feedback').text(message).addClass('d-block');
                            });
                        });
                    } else if (field.includes('attribute')) {
                        $('.attr-row').each(function () {
                            let attr_name = $(this).find('.attribute-name');
                            let attr_value = $(this).find('.attribute-value');

                            if (attr_name.val() === '') {
                                attr_name.addClass('is-invalid');
                            }

                            if (attr_value.val() === '') {
                                attr_value.addClass('is-invalid');
                            }
                        });

                        $('.attributes .invalid-feedback').text(message);
                    } else {
                        if (field.includes('general-error')) {
                            let general_error = $('#general-error');
                            general_error.text(message);
                            general_error.addClass('alert alert-danger');
                        } else {
                            const input = $(`#${field}`);
                            input.addClass('is-invalid');
                            input.siblings('.invalid-feedback').text(message);
                        }
                    }
                });
            }
        }).fail(function () {
            $('#general-error').html(`
                    <div class="alert alert-danger">
                        <strong>Oops!</strong><br>
                        We couldn't complete your request. Please try again.
                    </div>
                `);

            $('#add-product-btn').prop('disabled', true);
        });
    });
</script>