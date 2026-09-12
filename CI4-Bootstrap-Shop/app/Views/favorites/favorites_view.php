<!-- FAVORITES START -->
<div class="row text-center mt-3">
    <h3 class="fw-bold">Favorites</h3>
</div>

<div class="row mt-lg-5">
    <div class="col-12">

        <!-- MOBILE LAYOUT -->
        <div class="cart-products-sm d-md-none mt-4">

            <?php
            foreach ($favorites as $favorite) {
                ?>
                <div class="card border-0 mb-3 border-top">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <img class="img-fluid rounded" src="<?= base_url($favorite->image_url) ?>" alt="Product">
                            </div>
                            <div class="col-8">
                                <p class="cart-title-sm fw-bold mb-1 line-clamp-2">
                                    <a href="<?= $favorite->slug ?>">
                                        <?= $favorite->name ?>
                                    </a></p>
                                <p class="fw-bold favorite-price-sm">
                                    <?php
                                    if ($favorite->promo > 0) {
                                        ?>
                                        <span class="old-price">
                                        <?= $favorite->price ?>€
                                        </span>

                                        <span class="text-danger ms-1">
                                            <?= $favorite->promo ?>€
                                        </span>
                                        <?php
                                    } else {
                                        ?>
                                        <span>
                                           <?= $favorite->price ?>€
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </p>
                                <div class="d-flex gap-2 mt-3">
                                    <button class="btn btn-outline-danger btn-sm flex-fill fw-bold favorite-btns remove-fav">
                                        Remove
                                    </button>
                                    <?php
                                    $in_stock = true;
                                    if ($favorite->stock_quantity == 0) {
                                        $in_stock = false;
                                    }
                                    ?>
                                    <button data-product-id="<?= $favorite->id ?>"
                                            class="btn btn-outline-success btn-sm flex-fill
                                            fw-bold favorite-btns add-fav-to-cart <?= !$in_stock ? 'disabled' : '' ?>">
                                        <?= !$in_stock ? 'Out Of Stock' : 'Add to Cart' ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <!-- DESKTOP LAYOUT -->
        <div class="d-none d-md-block text-center">
            <table class="table">
                <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th></th>
                    <th></th>
                    <th>PRICE</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($favorites as $favorite) {
                    ?>
                    <tr class="align-middle">
                        <td>
                            <img class="img-fluid cart-img-md cart-img-lg" src="<?= base_url($favorite->image_url) ?>"
                                 alt="Product">
                        </td>
                        <td class="cart-title-md">
                            <a class="line-clamp-2" href="<?= $favorite->slug ?>">
                                <?= $favorite->name ?>
                            </a>
                        </td>
                        <td>
                            <i data-product-id="<?= $favorite->id ?>"
                               class="fa-solid fa-trash text-danger pointer remove-fav"></i>
                        </td>
                        <td class="cart-price-md cart-price-lg fw-bold">
                            <p class="fw-bold mt-3">
                                <?php
                                if ($favorite->promo > 0) {
                                    ?>
                                    <span class="old-price">
                                        <?= $favorite->price ?>€
                                    </span>

                                    <span class="text-danger ms-1">
                                            <?= $favorite->promo ?>€
                                    </span>
                                    <?php
                                } else {
                                    ?>
                                    <span>
                                       <?= $favorite->price ?>€
                                    </span>
                                    <?php
                                }
                                ?>
                            </p>
                        </td>
                        <td>
                            <?php
                            $in_stock = true;
                            if ($favorite->stock_quantity == 0) {
                                $in_stock = false;
                            }
                            ?>
                            <button data-product-id="<?= $favorite->id ?>" class="btn btn-outline-success btn-sm
                             fw-bold add-fav-to-cart <?= !$in_stock ? 'disabled' : '' ?> ">
                                <?= !$in_stock ? 'Out Of Stock' : 'Add to Cart' ?>
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- FAVORITES END -->

<script>


$('.add-fav-to-cart').on("click", function () {
    let product_id = $(this).data('product-id');

    $.ajax({
        url: '<?= base_url('/add-to-cart') ?>',
        data: {
            product_id: product_id,
            quick_add: true
        },
        method: 'post',
        dataType: 'json'
    }).done(function (response) {
        if (response.status === 'success') {
            Swal.fire({
                icon: "success",
                title: "Added to cart!",
                text: response.message,
                toast: true,
                position: "bottom-left",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: "#fff",
                color: "#333",
            });

            $('.items-count').html(response.items_count);
        }

        if (response.status === 'error') {
            Swal.fire({
                icon: "error",
                title: "Failed",
                text: response.message,
                toast: true,
                position: "bottom-left",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: "#fff",
                color: "#333",
            });
        }
    });
});

$('.remove-fav').on('click', function () {
    let product_id = $(this).data('product-id');

    $.ajax({
        url: '<?= base_url('/remove-favorite/') ?>',
        method: 'post',
        data: {
            product_id: product_id
        }
    }).done(function (response) {
        let title;
        let icon;

        if (response.status === 'success') {
            icon = "success";
            title = "Removed Successfully";
        } else if (response.status === 'database') {
            icon = "error";
            title = "Error";
        }

        Swal.fire({
            icon: icon,
            title: title,
            text: response.message,
            toast: true,
            position: "bottom-left",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            background: "#fff",
            color: "#333",
        });

        setTimeout(function () {
            window.location.reload()
        }, 2000);
    });
});

</script>