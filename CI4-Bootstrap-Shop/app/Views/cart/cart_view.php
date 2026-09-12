<!-- CART START -->

<div class="row text-center mt-3">
    <h3 class="fw-bold">Shopping Cart</h3>
</div>
<div class="row mt-lg-5">
    <div class="col-12 col-lg-8">

        <!-- MOBILE LAYOUT  -->
        <div class="cart-products-sm d-md-none">
            <?php
            foreach ($cart_items as $cart_item) {
                ?>
                <div class="row mt-4 cart_item">
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="row d-flex align-items-center">
                        <div class="col-4">
                            <img class="cart-img-sm"
                                 src="<?= base_url($cart_item->comb_image ? $cart_item->comb_image : $cart_item->main_image) ?>"
                                 alt="Product">
                        </div>
                        <div class="col-7">
                            <a class="cart-title-sm" href="<?= base_url('/product/' . $cart_item->slug) ?>">
                                <?= $cart_item->name . ' ' . $cart_item->title ?? '' ?>
                            </a>
                        </div>
                        <div class="col-1 delete-icon"
                             data-id="<?= $cart_item->item_id ?>">
                            <i class="fa-solid fa-trash text-danger pointer"></i>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row mt-4" style="margin: 0;">
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <p class="cart-price-sm">
                                    <?php
                                    if ($cart_item->promo > 0 && $cart_item->comb_promo > 0) {
                                        ?>
                                        <span class="old-price">
                                        <?= $cart_item->comb_price ?: $cart_item->price ?> €</span>
                                        <?php
                                    }
                                    ?>

                                    <?= $cart_item->unit_price ?> €

                                    <span class="fw-bold">Each</span>
                                </p>
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-stretch qty-container"
                                         data-id="<?= $cart_item->item_id ?>">
                                        <button class="btn decrease-qty" type="button" id="decrease-qty">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input class="qty-input" id="quantity-input"
                                               value=<?= $cart_item->quantity ?>
                                               min="1"
                                               max="<?= $cart_item->comb_qty ?: $cart_item->stock_quantity ?>"
                                               data-id="<?= $cart_item->item_id ?>">
                                        <button class="btn increase-qty" type="button" id="increase-qty">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <p class="cart-price-sm"><?= $cart_item->subtotal ?> €
                                    <span class="fw-bold">Total</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <!--  DESKTOP LAYOUT      -->
        <div class="d-none d-md-block">
            <table class="table">
                <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>QUANTITY</th>
                    <th>TOTAL</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($cart_items as $cart_item) {
                    ?>
                    <tr class="align-middle cart_item">
                        <td>
                            <img class="img-fluid cart-img-md cart-img-lg"
                                 src="<?= base_url($cart_item->comb_image ? $cart_item->comb_image : $cart_item->main_image) ?>"
                                 alt="Product">
                        </td>
                        <td class="cart-title-md cart-title-lg">
                            <a href="<?= base_url('/product/' . $cart_item->slug) ?>">
                                <?= $cart_item->name . ' ' . $cart_item->title ?? '' ?>
                            </a>

                            <p class="cart-price-md cart-price-lg mt-2">
                                <?php
                                if ($cart_item->comb_promo === null && $cart_item->promo > 0) {
                                    ?>
                                    <span class="old-price"><?= $cart_item->price ?> €</span>
                                    <?php
                                } else if ($cart_item->comb_promo > 0 && $cart_item->promo > 0) {
                                    ?>
                                    <span class="old-price"><?= $cart_item->comb_price ?> €</span>
                                    <?php
                                }
                                ?>

                                <?= $cart_item->unit_price ?> €
                                <span class="fw-bold">Each</span>
                            </p>
                        </td>
                        <td class="delete-icon" data-id="<?= $cart_item->item_id ?>">
                            <i class="fa-solid fa-trash text-danger" style="cursor: pointer;"></i>
                        </td>
                        <td></td>
                        <td>
                            <div class="d-flex align-items-stretch qty-container qty-md qty-lg"
                                 data-id="<?= $cart_item->item_id ?>">
                                <button class="btn decrease-qty" type="button" id="decrease-qty">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input class="qty-input" id="quantity-input"
                                       value=<?= $cart_item->quantity ?>
                                       min="1"
                                       max="<?= $cart_item->comb_qty ?: $cart_item->stock_quantity ?>"
                                       data-id="<?= $cart_item->item_id ?>">
                                <button class="btn increase-qty" type="button" id="increase-qty">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td class="cart-price-md cart-price-lg fw-bold item_subtotal"><?= $cart_item->subtotal ?> €</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--        SUMMARY BLOCK -->
    <div class="col-12 col-lg-4 mt-4 mt-lg-3">
        <div class="d-lg-none">
            <div class="summary-content">
                <div class="row mt-5 mt-md-0">
                    <div class="col-12 d-md-none">
                        <hr>
                    </div>
                    <div class="col-9">
                        <p class="fw-bold">Subtotal</p>
                    </div>
                    <div class="col-3 text-end">
                        <p class="fw-bold total"><?= number_format($subtotal, 2) ?>€</p>
                    </div>

                    <div class="col-12 cart-summary-list-sm cart-summary-list-md">
                        <div class="row">
                            <div class="col-9">Delivery:</div>
                            <div class="col-3 text-end">0.00 €</div>
                        </div>
                    </div>
                    <div class="col-12 cart-summary-list-sm cart-summary-list-md">
                        <div class="row">
                            <div class="col-9">You saved:</div>
                            <div class="col-3 text-end">0.00 €</div>
                        </div>
                    </div>
                    <div class="col-12 cart-summary-list-sm cart-summary-list-md">
                        <div class="row">
                            <div class="col-9">Tax:</div>
                            <div class="col-3 text-end">0.00 €</div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row p-2">
                            <a href="<?='/checkout'?>" class="btn fw-bold green-btn">Checkout</a>
                        </div>
                        <div class="row p-2">
                            <a href="/" class="btn fw-bold gray-btn">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="d-none d-lg-block">
            <div class="card">
                <div class="card-body card-body-lg">
                    <div class="summary-content">
                        <div class="row cart-summary-list-lg">
                            <div class="col-9">
                                <p class="fw-bold">Subtotal</p>
                            </div>
                            <div class="col-3 text-end">
                                <p class="fw-bold total"><?= number_format($subtotal, 2) ?> €</p>
                            </div>

                            <div class="col-12 cart-summary-list-lg">
                                <div class="row">
                                    <div class="col-9">Delivery:</div>
                                    <div class="col-3 text-end">0.00 €</div>
                                </div>
                            </div>
                            <div class="col-12 cart-summary-list-lg">
                                <div class="row">
                                    <div class="col-9">You saved:</div>
                                    <div class="col-3 text-end">0.00 €</div>
                                </div>
                            </div>
                            <div class="col-12 cart-summary-list-lg">
                                <div class="row">
                                    <div class="col-9">Tax:</div>
                                    <div class="col-3 text-end">0.00 €</div>
                                </div>
                            </div>
                            <br>

                            <div class="col-12 mt-3">
                                <div class="row p-2">
                                    <a href="<?='/checkout'?>" class="btn fw-bold green-btn">Checkout</a>
                                </div>
                                <div class="row p-2">
                                    <a href="/" class="btn fw-bold gray-btn">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CART END -->

<script>
    $('.increase-qty').on('click', function () {
        let item_id = $(this).closest('.qty-container').data('id');
        let qtyInput = $(`input[data-id="${item_id}"]`);
        let count = qtyInput.val();
        count++;

        $.ajax({
            url: '<?= base_url('/update-product-quantity') ?>',
            method: 'post',
            data: {
                item_id: item_id,
                status: 'increase'
            },
            type: 'json'
        }).done(function (response) {
            if (response.status === 'success') {
                qtyInput.closest('td').next('.item_subtotal').html(response.new_item_subtotal + ' €');
                $('.total').html(response.new_subtotal + ' €');
                Swal.fire({
                    icon: 'info',
                    text: 'Quantity increased',
                    position: 'bottom-left',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });

        qtyInput.val(count);
    });

    $(document).on('click', '.delete-icon', function () {
        let item_id = $(this).data('id');
        let cart_id = <?= $cart_id ?>;

        Swal.fire({
            title: 'Are you sure you want to delete the item ?',
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/delete_item') ?>',
                    method: 'post',
                    data: {
                        item_id: item_id,
                        cart_id: cart_id
                    },
                    type: 'json'
                }).done(function (response) {
                    if (response.type === 'deleted') {
                        $('.total').html(response.subtotal + ' €');
                        $(`input[data-id="${item_id}"]`).closest('.cart_item').remove();

                        Swal.fire({
                            icon: 'info',
                            text: 'Item has been removed!',
                            position: 'bottom-left',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            }
        });
    });

    $('.decrease-qty').on('click', function () {
        let item_id = $(this).closest('.qty-container').data('id');
        let qtyInput = $(`input[data-id="${item_id}"]`);
        let count = qtyInput.val();
        count--;

        if (count === 0) {
            Swal.fire({
                title: 'Are you sure you want to delete the item ?',
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('/delete_item') ?>',
                        method: 'post',
                        data: {
                            item_id: item_id,
                            cart_id: <?= $cart_id ?>
                        },
                        type: 'json'
                    }).done(function (response) {
                        if (response.type === 'deleted') {
                            $('.total').html(response.subtotal + ' €');
                            $(`input[data-id="${item_id}"]`).closest('.cart_item').remove();

                            Swal.fire({
                                icon: 'info',
                                text: 'Item has been removed!',
                                position: 'bottom-left',
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    qtyInput.val(1);
                }
            });
        } else {
            $.ajax({
                url: '<?= base_url('/update-product-quantity') ?>',
                method: 'post',
                data: {
                    item_id: item_id,
                    status: 'decrease'
                },
                type: 'json'
            }).done(function (response) {
                if (response.status === 'success') {
                    qtyInput.closest('td').next('.item_subtotal').html(response.new_item_subtotal + ' €');
                    $('.total').html(response.new_subtotal + ' €');
                    Swal.fire({
                        icon: 'info',
                        text: 'Quantity decreased',
                        position: 'bottom-left',
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
            qtyInput.val(count);
        }
    });
</script>