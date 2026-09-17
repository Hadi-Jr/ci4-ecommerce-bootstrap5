<!-- ADD PRODUCT START -->

<div class="row justify-content-center mt-3 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">
            <form id="add-product-form">

                <div class="row justify-content-end mb-3 mb-md-0 p-2">
                    <div class="col-auto">
                        <div id="status" class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   id="statusSwitch"
                                   data-checked="Available"
                                   data-unchecked="Not Available"
                                   name="status" checked>
                            <label class="form-check-label status-label" for="statusSwitch">Available</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Add New Product
                        </h3>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-bold">Main Image</label>
                        <input type="file"
                               class="form-control"
                               name="main_image"
                               id="main_image"
                               accept=".jpg,.jpeg,.png,.webp"
                               required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="images" class="form-label fw-bold">Additional Images</label>
                        <input type="file" class="form-control" id="images" name="images[]"
                               multiple accept="image/jpeg,image/png,image/webp">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="product_name" class="form-label fw-bold">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name"
                               placeholder="Enter a product name" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="sku" class="form-label fw-bold">Product Code</label>
                        <input type="text" class="form-control" id="sku" name="sku"
                               placeholder="Enter a product code" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="barcode" class="form-label fw-bold">Barcode</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Enter a barcode">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="brand" class="form-label fw-bold">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter a brand">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="price" class="form-label fw-bold">Price</label>
                        <input type="number" class="form-control" id="price" name="price"
                               placeholder="0.00" min="0" step="0.01"
                               required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="promo" class="form-label fw-bold">Promo Price</label>
                        <input type="number" class="form-control" id="promo" name="promo" placeholder="0.00" min="0"
                               step="0.01" value="0.0">
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

                        <input type="hidden" name="category_id" id="category_id">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="quantity" class="form-label fw-bold">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               placeholder="Enter a quantity"
                               min="0" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label for="slug" class="form-label fw-bold">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" readonly>
                        <small class="text-muted">Auto-generated from product name</small>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mb-3 specs">
                    <fieldset class="border rounded-3 p-3">
                        <legend class="float-none w-auto px-2 fs-6 fw-bold">Product Specifications</legend>

                        <div id="featureContainer">
                            <div class="feature-row d-flex gap-2 mb-2">
                                <input type="text" class="form-control" placeholder="Key (e.g., Color)"
                                       name="feature_key[]"
                                       required>
                                <input type="text" class="form-control" placeholder="Value (e.g., Red)"
                                       name="feature_value[]"
                                       required>
                                <button type="button" class="btn btn-danger remove-feature" disabled>×</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success btn-sm mt-2 fw-bold" id="addFeature">
                            Add Feature
                        </button>
                    </fieldset>

                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-4 variants">
                    <fieldset class="border rounded-3 p-3">
                        <legend class="float-none w-auto px-2 fs-6 fw-bold">
                            Product Variants
                        </legend>

                        <div class="combNameContainer mb-3">
                            <div class="card mb-3 comb-card">
                                <div class="card-body">
                                    <p class="card-title fw-semibold mb-2 text-center comb-name"></p>
                                    <div class="d-flex gap-2 mb-3">
                                        <input type="text" class="form-control comb-title-value" placeholder="Title (e.g., Color)"
                                               required>
                                        <button type="button" class="btn btn-danger remove-comb-name">×</button>
                                    </div>

                                    <div class="row comb-values">
                                        <div class="col-12 col-md-6 combValueContainer mb-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="card-title fw-semibold mb-3 text-center comb-value"></p>

                                                    <input type="file" class="form-control mb-4 comb-image"
                                                            accept="image/*">

                                                    <input type="text" class="form-control mb-2 comb-value-title" placeholder="Title"
                                                           required>

                                                    <input type="text" class="form-control mb-2 sku" placeholder="Sku"
                                                           required>

                                                    <input type="number" class="form-control mb-2 price" placeholder="Price"
                                                           required>

                                                    <input type="text" class="form-control mb-2 promo" placeholder="Promo"
                                                           value="0.0">

                                                    <input type="number" class="form-control mb-2 qty" placeholder="Quantity"
                                                           required>

                                                    <button type="button" class="btn btn-danger btn-sm mt-2 fw-bold
                                                            removeCombValue">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-success btn-sm mt-2 fw-bold mt-2 add-comb-value">
                                        Add Comb Value
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="button" class="btn btn-success btn-sm mt-2 fw-bold" id="addCombination">
                                Add Combination
                            </button>
                            <button type="button" class="btn btn-danger btn-sm mt-2 fw-bold ms-2" id="removeCombinations">
                                Remove All Combinations
                            </button>
                        </div>
                    </fieldset>

                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-4 attributes">
                    <fieldset class="border rounded-3 p-3">
                        <legend class="float-none w-auto px-2 fs-6 fw-bold">Product Attributes</legend>

                        <div class="attributeContainer">
                            <div class="attr-row mb-3 d-flex gap-3">
                                <select class="form-select attribute-name" name="attribute_name[]" required>
                                    <option value="" selected>Attribute Name</option>
                                    <?php
                                        foreach ($attributes as $attribute) {
                                            ?>
                                            <option value="<?= $attribute->id ?>"><?= $attribute->name ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>

                                <select class="form-select attribute-value" name="attribute_value[]" required>
                                    <option value="" selected>Attribute Value</option>
                                </select>

                                <button type="button" class="btn btn-danger remove-attribute" disabled>×</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success btn-sm mt-2 fw-bold add-attribute">
                            Add Attribute
                        </button>
                    </fieldset>

                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="short-description" class="form-label fw-bold">Short Description</label>
                        <textarea class="form-control" id="short-description" name="short-description" rows="3"
                                  placeholder="Enter short description" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="method-of-use" class="form-label fw-bold">Method Of Use</label>
                        <textarea class="form-control" id="method-of-use" name="method-of-use" rows="3"
                                  placeholder="Enter method of use" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="long-description" class="form-label fw-bold">Long Description</label>
                    <textarea class="form-control" id="long-description" name="long-description" rows="4"
                              placeholder="Enter product description" required></textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="add-product-btn">
                            Add Product
                        </button>
                    </div>
                </div>
            </form>
            <div class="mt-4" id="general-error"></div>
        </div>
    </div>
</div>

<div id="attributeTemplate" class="d-none">
    <div class="attr-row mb-3 d-flex gap-3">
        <select class="form-select attribute-name" name="attribute_name[]" required>
            <option value="" selected>Attribute Name</option>

            <?php foreach ($attributes as $attribute): ?>
                <option value="<?= $attribute->id ?>">
                    <?= $attribute->name ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select class="form-select attribute-value" name="attribute_value[]" required>
            <option value="" selected>Attribute Value</option>
        </select>

        <button type="button" class="btn btn-danger remove-attribute">
            ×
        </button>
    </div>
</div>

<div id="combinationTemplate" class="d-none">
    <div class="card mb-3 comb-card">
        <div class="card-body">
            <p class="card-title fw-semibold mb-2 text-center comb-name"></p>
            <div class="d-flex gap-2 mb-3">
                <input type="text" class="form-control comb-title-value" placeholder="Title (e.g., Color)"
                       required>
                <button type="button" class="btn btn-danger remove-comb-name">×</button>
            </div>

            <div class="row comb-values">
                <div class="col-12 col-md-6 combValueContainer mb-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title fw-semibold mb-3 text-center comb-value"></p>

                            <input type="file" class="form-control mb-4 comb-image"
                                   accept="image/*">

                            <input type="text" class="form-control mb-2 comb-value-title" placeholder="Title"
                                   required>

                            <input type="text" class="form-control mb-2 sku" placeholder="Sku"
                                   required>

                            <input type="number" class="form-control mb-2 price" placeholder="Price"
                                   required>

                            <input type="text" class="form-control mb-2 promo" placeholder="Promo"
                                   value="0.0">

                            <input type="number" class="form-control mb-2 qty" placeholder="Quantity"
                                   required>

                            <button type="button" class="btn btn-danger btn-sm mt-2 fw-bold
                                        removeCombValue">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-success btn-sm mt-2 fw-bold mt-2 add-comb-value">
                Add Comb Value
            </button>
        </div>
    </div>
</div>

<div id="combValueTemplate" class="d-none">
    <div class="col-12 col-md-6 combValueContainer mb-2">
        <div class="card">
            <div class="card-body">
                <p class="card-title fw-semibold mb-3 text-center comb-value"></p>

                <input type="file" class="form-control mb-4 comb-image"
                       accept="image/*">

                <input type="text" class="form-control mb-2 comb-value-title" placeholder="Title"
                       required>

                <input type="text" class="form-control mb-2 sku" placeholder="Sku"
                       required>

                <input type="number" class="form-control mb-2 price" placeholder="Price"
                       required>

                <input type="text" class="form-control mb-2 promo" placeholder="Promo"
                       value="0.0">

                <input type="number" class="form-control mb-2 qty" placeholder="Quantity"
                       required>

                <button type="button" class="btn btn-danger btn-sm mt-2 fw-bold
                            removeCombValue">
                    Remove
                </button>
            </div>
        </div>
    </div>
</div>

<div id="featuresTemplate" class="d-none">
    <div class="feature-row d-flex gap-2 mb-2">
        <input type="text" class="form-control" placeholder="Key (e.g., Color)"
               name="feature_key[]" required>
        <input type="text" class="form-control" placeholder="Value (e.g., Red)"
               name="feature_value[]" required>
        <button type="button" class="btn btn-danger remove-feature">×</button>
    </div>
</div>
<!--  ADD PRODUCT END -->

<script>
    $('.category-option').on('click', function (e) {
        e.preventDefault();

        $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');

        let category_id = $(this).data('id');
        $('#category_id').val(category_id);
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

                        $('.attributes .invalid-feedback').text(message).addClass('d-block');
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

<script>
    $(document).ready(function () {
        calculateCombinations();
    });

    $(document).on('change', '.attribute-name', function () {
        const selected_value = $(this).val();
        const attribute_name = $(this);

        $.ajax({
            url: '<?= base_url('/get-attribute-values' ) ?>/' + selected_value,
            method: 'get'
        }).done(function (response) {
            let attribute_value = attribute_name.siblings('.attribute-value');
            attribute_value.prop('disabled', false);
            attribute_value.empty().append(response);
        });
    });
</script>