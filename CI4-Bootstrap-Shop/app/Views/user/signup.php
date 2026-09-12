<!-- SIGN UP START -->

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-12 col-md-8 col-lg-5">

        <div class="card p-4 shadow border-0">
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h3 class="fw-bold">Sign Up</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form id="register_form">
                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control" id="full_name" placeholder="Enter your full name"
                                   name="full_name" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Choose a username"
                                   name="username" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email"
                                   name="email" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Create a password"
                                   name="password" required>
                            <div class="invalid-feedback"></div>
                        </div>


                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-bold">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password"
                                   name="confirm_password" placeholder="Confirm your password" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row align-items-center gap-2">
                <div class="col-12">
                    <div>
                        <span class="p-1 small">
                            <a href="<?= base_url('/login') ?>" class="pointer">Already have an account ?</a>
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn w-100 fw-bold gray-btn" id="signup_btn">
                        Sign Up
                    </button>
                </div>
            </div>

            <div class="alert-message mt-4"></div>
        </div>

    </div>
</div>

<!-- SIGN UP END -->

<script>

    $('#signup_btn').on('click', function (e) {
        e.preventDefault();
        let register_data = $('#register_form').serializeArray();

        $.ajax({
            url: '<?= base_url('/register') ?>',
            method: 'post',
            data: register_data,
            type: 'json'
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
                    window.location.href = '/login';
                }, 2000);
            } else if (response.status === 'error') {
                $('.is-invalid').removeClass('is-invalid');

                $.each(response.errors, function (field, message) {
                    const input = $(`#${field}`);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(message);
                });
            }
        }).fail(function (){
            $('.alert-message').html(`
                <div class="alert alert-danger">
                    <strong>Oops!</strong><br>
                    We couldn't complete your request. Please try again later.
                </div>
            `);

            $('#signup_btn').prop('disabled', true);
        })
    });

</script>
