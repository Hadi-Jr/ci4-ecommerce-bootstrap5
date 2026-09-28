<div class="row justify-content-center mt-3 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">

            <form id="add-attr-form">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Add Attributes
                        </h3>
                    </div>
                </div>

                <div class="mb-4">
                    <fieldset class="border rounded-3 p-3">
                        <legend class="float-none w-auto px-2 fs-6 fw-bold">Product Attributes</legend>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6 attribute-name">

                                <span class="new-name-wrapper <?= !empty($attribute_names) ? 'd-none' : '' ?>">
                                    <input type="text"
                                           class="form-control"
                                           id="attribute_name_new"
                                           name="attribute_name"
                                           placeholder="Enter an attribute name"
                                           <?= !empty($attribute_names) ? 'disabled' : 'required' ?>>
                                    <div class="invalid-feedback"></div>
                                </span>

                                <span class="existing-name-wrapper <?= empty($attribute_names) ? 'd-none' : '' ?>">
                                    <select class="form-select"
                                            id="attribute_name_existing"
                                            name="attribute_name"
                                            <?= empty($attribute_names) ? 'disabled' : 'required' ?>>

                                        <option value="" selected disabled>Attribute Name</option>

                                        <?php
                                        foreach ($attribute_names as $attribute_name) {
                                            ?>
                                            <option value="<?= $attribute_name->name ?>">
                                                <?= $attribute_name->name ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </span>
                            </div>

                            <div class="col-12 col-md-6 attribute-value">
                                <input type="text" class="form-control" id="attribute_value" name="attribute_value"
                                       placeholder="Enter an attribute value" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success btn-sm mt-2 fw-bold new-attr-name">
                            New Attribute Name
                        </button>
                        <button type="button" class="btn btn-info btn-sm mt-2 fw-bold existing-attr-name">
                            Select Attribute Name
                        </button>
                    </fieldset>

                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="add-attr-btn">
                            Add Attribute
                        </button>
                    </div>
                </div>
            </form>
            <div class="mt-4" id="general-error"></div>
        </div>
    </div>
</div>

<script>
    $('.new-attr-name').on('click', function (e) {
        e.preventDefault();

        $('.new-name-wrapper').removeClass('d-none');
        $('.new-name-wrapper input')
            .prop('disabled', false)
            .prop('required', true);

        $('.existing-name-wrapper').addClass('d-none');
        $('.existing-name-wrapper select')
            .prop('disabled', true)
            .prop('required', false);
    });


    $('.existing-attr-name').on('click', function (e) {
       e.preventDefault();

        $('.existing-name-wrapper').removeClass('d-none');
        $('.existing-name-wrapper select')
            .prop('disabled', false)
            .prop('required', true);

        $('.new-name-wrapper').addClass('d-none');
        $('.new-name-wrapper input')
            .prop('disabled', true)
            .prop('required', false);
    });
</script>

<script>
    $('#add-attr-btn').on('click', function (e) {
        e.preventDefault();

       const form_data = $('#add-attr-form').serializeArray();
       $.ajax({
          url: '<?= base_url('/add-attributes') ?>',
          method: 'post',
          data: form_data,
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
                   if (field.includes('general-error')) {
                       let general_error = $('#general-error');
                       general_error.text(message);
                       general_error.addClass('alert alert-danger');
                   } else {
                       const input = $(`[name="${field}"]:enabled`);
                       input.addClass('is-invalid');
                       input.siblings('.invalid-feedback').text(message);
                   }
               });
           }
       });
    });

</script>