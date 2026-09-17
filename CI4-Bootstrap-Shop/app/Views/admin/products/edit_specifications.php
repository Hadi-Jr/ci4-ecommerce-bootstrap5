<div class="row justify-content-center mt-3 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">

            <form id="edit-specs-form">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Edit Specifications
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

                    <div id="removed-features-container"></div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="edit-specs-btn">
                            Edit Specifications
                        </button>
                    </div>
                </div>
            </form>
            <div class="mt-4" id="general-error"></div>
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

<script>
    $('#products-selector').on('change', function (e) {
        const product_id = $(this).val();

        $.ajax({
            url: '<?= base_url('/edit-specs') ?>',
            method: 'get',
            data: {
                product_id: product_id
            }
        }).done(function (response) {
            $('#featureContainer').html(response);
        });
    });
</script>

<script>
    $(document).on('click', '.remove-existing-feature', function (e) {
        e.preventDefault();

        const feature_row = $(this).closest('.feature-row');
        const feature_id = feature_row.data('feature-id');

        if ($('#featureContainer .feature-row').length > 1) {
            feature_row.remove();
        } else {
            $('#general-error').html(`
                    <div class="text-danger">
                        You can't remove all the attributes
                    </div>
            `);
        }

        $('#removed-features-container').append(`
            <input type="hidden" name="removed_feature_ids[]" value="${feature_id}">
        `);
    });

    $('#edit-specs-btn').on('click', function (e) {
        e.preventDefault();
        const post_data = $('#edit-specs-form').serializeArray();

        $.ajax({
            url: '<?= base_url('/edit-specs') ?>',
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

                        $('#products-selector').siblings('.invalid-feedback').text(message);
                    } else if (field.includes('feature')) {
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

            $('#edit-specs-btn').prop('disabled', true);
        });
    });
</script>