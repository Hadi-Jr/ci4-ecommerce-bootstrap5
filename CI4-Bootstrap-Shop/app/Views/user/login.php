<!-- LOGIN START -->

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-12 col-md-8 col-lg-5">

        <div class="p-4 card shadow border-0">

            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h3 class="fw-bold">Sign Up</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form id="login_form">
                        <div class="mb-3">
                            <label for="email_username" class="fw-bold p-1">Username or Email</label>
                            <input type="text" class="form-control" id="email_username"
                                   placeholder="Enter username or email" name="email_username" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="fw-bold p-1">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password"
                                name="password" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row align-items-center mb-3">
                <span>
                    <a class="pointer small">Forgotten password ?</a>
                </span>
            </div>

            <div class="row gap-2 gap-md-0">
                <div class="col-12 col-md-6">
                    <button class="btn w-100 fw-bold green-btn" id="login_btn">
                        Login
                    </button>
                </div>
                <div class="col-12 col-md-6">
                    <a href="<?= base_url('/register') ?>" class="btn w-100 fw-bold btn-secondary">
                        Create New Account
                    </a>
                </div>
            </div>

            <div class="row alert_message mt-4"></div>
        </div>
    </div>
</div>

<!-- LOGIN END -->

<script>

    $('#login_btn').on('click', function (e) {
        e.preventDefault();

        let login_data = $('#login_form').serializeArray();

        $.ajax({
            url: '<?= base_url('/login') ?>',
            method: 'post',
            type: 'json',
            data: login_data
        }).done(function (response) {
            if (response.status === 'success') {

                Swal.fire({
                    icon: "success",
                    title: response.message,
                    toast: true,
                    position: "bottom-left",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    background: "#fff",
                    color: "#333",
                });

                let redirect = response.redirect;
                setTimeout(function () {
                    window.location.href = redirect
                }, 1000);
            } else if (response.status === 'error') {
                $('.is-invalid').removeClass('is-invalid');

                $.each(response.errors, function (field, message) {
                    const input = $(`#${field}`);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(message);
                });
            }
        }).fail(function () {
            $('.alert_message').html(`
                <div class="alert alert-danger">
                    <strong>Oops!</strong><br>
                    We couldn't complete your request. Please try again.
                </div>
            `);

            $('#login_btn').prop('disabled', true);
        })
    });

</script>
