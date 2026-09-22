<div class="row justify-content-center mt-3 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">
            <form id="edit-comb-form">

                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Edit Combinations
                        </h3>
                    </div>
                </div>

                <div class="mb-4">
                    <select id="products-selector" name="product_id">
                        <option value="">Select an option</option>
                        <?php
                        foreach ($products ?? [] as $product) {
                            ?>
                            <option value="<?= $product->id ?>"><?= $product->name . ' - SKU: ' . $product->sku ?></option>
                            <?php
                        }
                        ?>
                    </select>
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

                                                    <div class="mb-2">
                                                        <input type="file" class="form-control comb-image"
                                                               accept="image/*">
                                                        <small class="text-muted">1:1 aspect ratio image</small>
                                                    </div>

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

                    <div id="removed-comb-names"></div>
                    <div id="removed-comb-values"></div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="edit-comb-btn">
                            Edit Combinations
                        </button>
                    </div>
                </div>
            </form>
            <div class="mt-4" id="general-error"></div>
        </div>
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

                            <div class="mb-2">
                                <input type="file" class="form-control comb-image"
                                       accept="image/*">
                                <small class="text-muted">1:1 aspect ratio image</small>
                            </div>

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

                <div class="mb-2">
                    <input type="file" class="form-control comb-image"
                           accept="image/*">
                    <small class="text-muted">1:1 aspect ratio image</small>
                </div>

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

<script>
    $(document).ready(function () {
        $('.old-comb-image.disabled').prop('disabled', true);
        calculateCombinations();
    });

    $(document).on('click', '.remove-existing-comb-value', function (e) {
        e.preventDefault();

        const comb_value_container = $(this).closest('.combValueContainer');
        const comb_value_id = comb_value_container.data('combv-id');

        const comb_card = comb_value_container.closest('.comb-card');

        comb_value_container.remove();

        if (comb_card.find('.combValueContainer').length === 0) {
            const comb_name_id = comb_card.data('combn-id');
            comb_card.remove();
            $('#removed-comb-names').append(`
                <input type="hidden" name="removed_comb_name_ids[]" value="${comb_name_id}">
            `);
            $('.combNameContainer').html(`
                    <div class="text-warning">
                        No combinations available
                    </div>
            `);
        }

        $('#removed-comb-values').append(`
            <input type="hidden" name="removed_comb_value_ids[]" value="${comb_value_id}">
        `);
    });

    $(document).on('click', '.remove-existing-comb-name', function (e) {
        e.preventDefault();

        const comb_card = $(this).closest('.comb-card');
        const comb_name_id = comb_card.data('combn-id');
        comb_card.remove();

        $('#removed-comb-names').append(`
              <input type="hidden" name="removed_comb_name_ids[]" value="${comb_name_id}">
        `);

        if ($('.variants .comb-card').length === 0) {
            $('.combNameContainer').html(`
                    <div class="text-warning">
                        No combinations available
                    </div>
            `);
        }
    });

    $('#removeCombinations').on('click', function (e) {
        e.preventDefault();

        $('.combNameContainer .comb-card').each(function () {
            const comb_name_id = $(this).data('combn-id');

            $('#removed-comb-names').append(`
                <input type="hidden" name="removed_comb_name_ids[]" value="${comb_name_id}">
            `);
        })

       $('.variants .combNameContainer').html(`
                <div class="text-warning">
                    No combinations available
                </div>
        `);
    });

    $('#products-selector').on('change', function (e) {
        const product_id = $(this).val();

        $.ajax({
            url: '<?= base_url('/edit-combinations') ?>',
            method: 'get',
            data: {
                product_id: product_id
            }
        }).done(function (response) {
            $('.combNameContainer').html(response);
        });
    });
</script>

<script>
    $('#edit-comb-btn').on('click', function (e) {
        e.preventDefault();

        let post_data = new FormData($('#edit-comb-form')[0]);

        $.ajax({
            url: '<?= base_url('/edit-combinations') ?>',
            method: 'post',
            data: post_data,
            processData: false,
            contentType: false,
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

                        $('#products-selector').siblings('.invalid-feedback').text(message);
                    } else if (field.includes('combinations')) {
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

            $('#edit-comb-btn').prop('disabled', true);
        });
    });
</script>

<script>
    $(document).on('input', '.saved_combination .comb-title-value', function () {
        let new_value = $(this).val();
        $(this).closest('.comb-card').find('.comb_name_title_input').val(new_value);
    });

    $(document).on('input', '.saved_combination .comb-value-title', function () {
        let new_value = $(this).val();
        $(this).closest('.combValueContainer').find('.comb_value_title_input').val(new_value);
    });

    $(document).on('input', '.saved_combination .sku', function () {
        let new_value = $(this).val();
        $(this).closest('.combValueContainer').find('.sku_input').val(new_value);
    });

    $(document).on('input', '.saved_combination .price', function () {
        let new_value = $(this).val();
        $(this).closest('.combValueContainer').find('.price_input').val(new_value);
    });

    $(document).on('input', '.saved_combination .promo', function () {
        let new_value = $(this).val();
        $(this).closest('.combValueContainer').find('.promo_input').val(new_value);
    });

    $(document).on('input', '.saved_combination .qty', function () {
        let new_value = $(this).val();
        $(this).closest('.combValueContainer').find('.qty_input').val(new_value);
    });
</script>