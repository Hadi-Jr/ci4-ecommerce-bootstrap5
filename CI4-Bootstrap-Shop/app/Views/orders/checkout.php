<!-- CHECKOUT START -->
<div class="container">
    <div class="row text-center mt-3">
        <h3 class="fw-bold">Checkout</h3>
    </div>

    <div class="row mt-4" id="checkout">
        <div class="col-12 col-lg-6">
            <h5 class="mt-3 mt-lg-0">Billing Details</h5>
            <hr>
            <form id="place-order-form">
                <div class="form-group mt-3">
                    <label for="full_name" class="fw-bold p-1">
                        Full name
                        <span class="required-field">*</span>
                    </label>
                    <input type="text" class="form-control" name="full_name"
                           id="full_name" placeholder="Enter full name" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mt-2">
                    <label for="email_address" class="fw-bold p-1">
                        Email address
                        <span class="required-field">*</span>
                    </label>
                    <input type="email" class="form-control" name="email_address"
                           id="email_address" placeholder="Enter email address" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mt-2">
                    <label for="phone_number" class="fw-bold p-1">
                        Phone Number <span class="required-field">*</span>
                    </label>
                    <input type="tel" class="form-control" id="phone_number"
                           name="phone_number" placeholder="Enter phone number" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mt-2">
                    <label for="address" class="fw-bold p-1">
                        Street <span class="required-field">*</span>
                    </label>
                    <input type="text" class="form-control" id="street"
                           name="street" placeholder="Enter street" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <label for="myCountry" class="fw-bold p-1">
                            Country
                            <span class="required-field">*</span>
                        </label>

                        <select id="myCountry" style="min-width: 0; width: 100%;" name="country" required>
                            <option value="">Select a country</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="CA">Bulgaria</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-6">
                        <label for="state" class="fw-bold p-1">
                            State <span class="required-field">*</span>
                        </label>
                        <input type="text" class="form-control" id="state"
                               name="state" placeholder="Enter state" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <label for="zip_code" class="fw-bold p-1">
                            ZIP Code <span class="required-field">*</span>
                        </label>
                        <input type="text" class="form-control" id="zip_code"
                               name="zip_code" placeholder="Enter ZIP code" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-6">
                        <label for="city" class="fw-bold p-1">
                            City <span class="required-field">*</span>
                        </label>
                        <input type="text" class="form-control"
                               name="city" id="city" placeholder="Enter city" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <label for="notes" class="fw-bold p-1">Order Notes (Optional)</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <input type="hidden" name="payment-method" id="payment-method" value="credit card">
            </form>

            <?php
            if (!$user_data?->id) {
                ?>
                <p class="mt-3">Returning customer?
                    <a href="<?= base_url('/login') ?>">
                        Click here to login
                    </a>
                </p>
                <?php
            }
            ?>
        </div>

        <!-- Spacer -->
        <div class="col-lg-1 d-none d-lg-block"></div>

        <div class="col-12 col-lg-5 mt-5 mt-lg-0">

            <!-- Review Cart -->
            <h5>Review Your Cart</h5>
            <hr>

            <div class="rounded bg-light p-4">
                <?php
                $saved = 0.0;
                foreach ($cart_items as $cart_item) {
                    ?>
                    <div class="d-flex align-items-center gap-3 p-3">
                        <img src="<?= $cart_item->main_image ?>" class="border rounded"
                             style="width:90px;height:90px;object-fit:cover; padding: 2px;" alt="Product">
                        <div>
                            <a href="<?= base_url('/product/' . $cart_item->slug) ?>"
                               class="mb-1 fw-semibold line-clamp-2">
                                <?= $cart_item->name ?>
                            </a>
                            <p class="mb-2 text-muted checkout-product-qty">
                                x <?= $cart_item->comb_qty ?: $cart_item->quantity ?>
                            </p>
                            <p class="mb-0 fw-bold cart-items-price-checkout">
                                <?php
                                if ($cart_item->promo > 0) {
                                    $saved += ($cart_item->comb_price ?? $cart_item->price)
                                    - ($cart_item->comb_promo ?? $cart_item->promo)
                                    ?>
                                    <span class="old-price">
                                        €<?= $cart_item->comb_price ?: $cart_item->price ?>
                                    </span>
                                    <span>
                                        €<?= $cart_item->comb_promo ?: $cart_item->promo ?>
                                    </span>
                                <?php
                                } else {
                                   ?>
                                    <span>
                                        €<?= $cart_item->comb_price ?: $cart_item->price ?>
                                    </span>
                                <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php
                }
                ?>

                <hr>

                <div class="row">
                    <div class="col-9">
                        <p class="fw-semibold mb-2">Subtotal</p>
                    </div>
                    <div class="col-3 text-end">
                        <p class="fw-semibold mb-2">€<?= number_format($subtotal, 2) ?></p>
                    </div>

                    <div class="col-9">
                        <p class="mb-2">Delivery</p>
                    </div>
                    <div class="col-3 text-end">
                        <p class="mb-2">€0.00</p>
                    </div>

                    <div class="col-9">
                        <p class="mb-2">You saved</p>
                    </div>
                    <div class="col-3 text-end">
                        <p class="mb-2">€<?= number_format($saved, 2) ?></p>
                    </div>

                    <div class="col-9">
                        <p class="mb-0">Tax</p>
                    </div>
                    <div class="col-3 text-end">
                        <p class="mb-0">Included</p>
                    </div>
                </div>

            </div>

            <!-- Payment -->
            <div class="mt-5">

                <h5>Payment</h5>
                <hr>

                <div class="rounded bg-light p-4">
                    <div class="row">
                        <div class="col-12 col-md-6 text-center mb-3 mb-md-0">
                            <div class="fw-bold fs-5">
                                <i class="fa-solid fa-shield-halved me-2"></i>
                                Secured Payment
                            </div>
                        </div>

                        <div class="col-12 col-md-6 text-center mb-4">
                            <div class="fs-4">
                                <i class="fa-brands fa-cc-visa"></i>
                                <i class="fa-brands fa-cc-paypal"></i>
                                <i class="fa-brands fa-cc-amex"></i>
                                <i class="fa-brands fa-cc-apple-pay"></i>
                                <i class="fa-brands fa-cc-mastercard"></i>
                                <i class="fa-brands fa-cc-stripe"></i>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input payment-method-radio" type="radio" name="payment_method_choice"
                                       id="paymentCreditCard" value="credit card" checked>
                                <label class="form-check-label" for="paymentCreditCard">
                                    Credit Card / Debit Card
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input payment-method-radio" type="radio" name="payment_method_choice"
                                       value="paypal" id="paymentPayPal">
                                <label class="form-check-label" for="paymentPayPal">
                                    PayPal
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input payment-method-radio" type="radio" name="payment_method_choice"
                                       value="bank transfer" id="paymentBankTransfer">
                                <label class="form-check-label" for="paymentBankTransfer">
                                    Bank Transfer
                                </label>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input payment-method-radio" type="radio" name="payment_method_choice"
                                       value="cash on delivery" id="paymentCashOnDelivery">
                                <label class="form-check-label" for="paymentCashOnDelivery">
                                    Cash on Delivery
                                </label>
                            </div>

                            <button class="btn w-100 fw-bold text-white green-btn place-order-btn">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CHECKOUT END -->

<script>
    $('.payment-method-radio').on('change', function () {
        let selected = $(this).val();
        $('#payment-method').val(selected);
    })
    $('.place-order-btn').on('click', function (e) {
        let form_data = $('#place-order-form').serializeArray();

        $.ajax({
            url: '<?= base_url('/place-order') ?>',
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
                    window.location.href = `/order_confirmation/${response.order_id}`;
                }, 2000);
            } else if (response.status === 'error') {
                $('.is-invalid').removeClass('is-invalid');

                $.each(response.errors, function (field, message) {
                    const input = $(`#${field}`);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(message);
                });
            }
        }).fail(function (xhr){
            let message = 'We could not complete your request. Please try again later.';

            if (xhr.status === 500) {
                message = xhr.responseJSON?.message || message;
            }

            $('.alert-message').html(`
                <div class="alert alert-danger">
                    <strong>Oops!</strong><br>
                    ${message}
                </div>
            `);

            $('.place-order-btn').prop('disabled', true);
        });
    });
</script>