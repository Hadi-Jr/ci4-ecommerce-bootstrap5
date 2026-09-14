<div class="row justify-content-center mt-5 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">

            <form id="edit-attr-form">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Edit Attributes
                        </h3>
                    </div>
                </div>

                <div class="mb-3">
                    <select id="products-selector" name="product_id">
                        <option value="">Select an option</option>
                        <?php
                        foreach ($products as $product) {
                            ?>
                            <option value="<?= $product->id ?>"><?= $product->name . ' - SKU: ' . $product->sku ?></option>
                            <?php
                        }
                        ?>
                    </select>

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

                    <div id="removed-attributes-container"></div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="edit-attr-btn">
                            Edit Attribute
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

<script>
    $(document).on('click', '.remove-existing-attribute', function (e) {
        e.preventDefault();

        const attribute_row = $(this).closest('.attr-row');
        const attribute_id = attribute_row.find('.attribute-value').val();

        if ($('.attributeContainer .attr-row').length > 1) {
            attribute_row.remove();
        } else {
            $('#general-error').html(`
                    <div class="text-danger">
                        You can't remove all the attributes
                    </div>
            `);
        }

        $('#removed-attributes-container').append(`
            <input type="hidden" name="removed_attribute_value_ids[]" value="${attribute_id}">
        `);
    });

    $('#products-selector').on('change', function (e) {
        const product_id = $(this).val();
        $.ajax({
            url: '<?= base_url('/edit-attributes') ?>',
            method: 'get',
            data: {
                product_id: product_id
            }
        }).done(function (response) {
            $('.attributeContainer').html(response);
        });
    });
</script>

<script>
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

<script>
    $('#edit-attr-btn').on('click', function (e) {
        e.preventDefault();
        const post_data = $('#edit-attr-form').serializeArray();

        $.ajax({
            url: '<?= base_url('/edit-attributes') ?>',
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

                    if (field.includes('product')) {

                        $('#products-selector').addClass('is-invalid');

                        $('#products-selector')
                            .siblings('.invalid-feedback')
                            .text(message)
                            .addClass('d-block');

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
                    }
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
        });
    });
</script>