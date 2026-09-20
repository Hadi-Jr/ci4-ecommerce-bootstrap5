<!-- PRODUCT START -->
<div class="row mt-lg-5">
    <div class="col-12 col-md-6 mb-3">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded">
                <?php
                foreach ($images ?? [] as $index => $image) {
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img class="img-fluid d-block mx-auto"
                             src="<?= base_url($image->image_url) ?>" alt="Second slide">
                    </div>
                    <?php
                }
                ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- Thumbnails -->
        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
            <?php
            foreach ($images ?? [] as $index => $image) {
                ?>
                <img src="<?= base_url($image->image_url) ?>" class="thumbnail"
                     data-bs-target="#carouselExampleControls" data-bs-slide-to="<?= $index ?>">
                <?php
            }
            ?>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="col-12 d-flex gap-2 align-items-center">
            <div id="fast-product-rater"></div>
            <a href="#reviews" class="small text-secondary">(<?= $reviews['reviews_count'] ?> customer reviews)</a>
            <input type="hidden" id="fast-product-rating" data-rating="<?= $reviews['overall_rating'] ?? 1 ?>" value="1">
        </div>
        <div class="row mt-2">
            <div class="col-10">
                <h3><?= $product->name ?></h3>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-5">
                <p class="bold">SKU: <span class="sku"><?= $product->sku ?></span></p>
            </div>
            <div class="col-7">
                <p class="bold">EAN: <?= $product->barcode ?> </p>
            </div>
        </div>

        <div class="row mt-2 short-description">
            <div class="col-12">
                <?= $product->short_description ?>
            </div>
        </div>

        <div class="row mt-2 align-items-center gap-lg-4">
            <div class="product-prices price col-12 col-md-5 col-lg-5">
                <div id="price-box">
                    <?php
                    if ($product->promo == 0.0) {
                        ?>
                        <div class="regular-price text-success">
                            <?= $product->price ?> €
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="price-through">
                            <?= $product->price ?> €
                        </div>
                        <div class="promo-price">
                            <?= $product->promo ?> €
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div>
                    <i class="text-secondary small">
                        *incl. VAT
                    </i>
                </div>
            </div>
        </div>

        <?php
        foreach ($combinations as $key => $combination) {
            ?>
            <div class="variants-links mt-4 mb-4">
                <label class="mb-2 fw-bold"><?= $combination['comb_name'] ?></label>
                <div class="gap-2 row ms-1">
                    <?php
                    foreach ($combination['combination_values'] as $comb_value) {
                        ?>
                        <div class="variant col-auto border rounded p-2 text-center d-flex flex-column
                                <?= $comb_value->comb_sku == $product->sku ? 'selected' : '' ?>">

                            <a href="#">
                                <img src="<?= $comb_value->image_url ?>" alt="Variant">
                            </a>

                            <?php if ((float) $comb_value->comb_promo > 0) {
                                ?>

                                <p class="mb-0 mt-1 fw-bold comb-price-through">
                                    <?= $comb_value->comb_price ?> €
                                </p>

                                <p class="mb-0 fw-bold text-danger">
                                    <?= $comb_value->comb_promo ?> €
                                </p>

                            <?php }
                                else {
                                ?>
                                <p class="mb-0 mt-1 fw-bold">
                                    <?= $comb_value->comb_price ?> €
                                </p>
                            <?php }
                                ?>

                            <p class="mb-0 mt-auto">
                                <?= $comb_value->comb_value ?>
                            </p>

                            <input type="hidden"
                                   class="selected-comb-value"
                                   data-comb-sku="<?= $comb_value->comb_sku ?>"
                                   data-comb-price="<?= $comb_value->comb_price ?>"
                                   data-comb-promo="<?= $comb_value->comb_promo ?>"
                                   value="<?= $comb_value->comb_value_id ?>">
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="row align-items-center mt-3 mb-3">
            <div class="col-12">
                <div class="d-flex align-items-center gap-3 flex-wrap">

                    <div class="d-flex align-items-stretch qty-container">
                        <button class="btn" type="button" id="decrease-qty">
                            <i class="fa-solid fa-minus"></i>
                        </button>

                        <input class="qty-input" id="quantity-input" value="1" min="1" max="<?= $product->stock_quantity ?>">

                        <button class="btn" type="button" id="increase-qty">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>


                    <?php
                        $in_stock = true;
                        if ($product->stock_quantity == 0) {
                            $in_stock = false;
                        }
                    ?>
                    <button class="btn green-btn fw-bold add-to-cart-btn pro-det-adc-btn
                            <?= !$in_stock ? 'disabled' : '' ?>">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <?= !$in_stock ? 'Out Of Stock' : 'Add to Cart' ?>
                    </button>
                </div>
            </div>
        </div>

        <hr>

        <div class="row product-info">
            <div class="col-5 add-to-favorite">
                <i class="fa-regular fa-heart"></i>
                Add To Favorite
            </div>
            <div class="col-4">
                <i class="fa-regular <?= !$in_stock ? 'text-danger' : '' ?> fa-circle-<?= !$in_stock ? 'xmark' : 'check' ?>"
                   style="color: rgb(5, 187, 2);"></i>
                <?= !$in_stock ? 'Out Of Stock' : 'Available' ?>
            </div>
            <div class="col-3">
                <span><?= $product->brand ?></span>
            </div>
        </div>

        <div class="row mt-5 p-1">
            <div class="overflow-auto">
                <ul class="nav nav-tabs flex-nowrap" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-black" data-bs-toggle="tab" data-bs-target="#description"
                                type="button">
                            Description
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-black" data-bs-toggle="tab" data-bs-target="#method" type="button">
                            Method of use
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-black" data-bs-toggle="tab" data-bs-target="#features"
                                type="button">
                            Features
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content mt-3">

                <div class="tab-pane fade show active" id="description">
                    <?= $product->description ?>
                </div>

                <div class="tab-pane fade" id="method">
                    <?= $product->method_of_use ?>
                </div>

                <div class="tab-pane fade" id="features">
                    <table class="table">
                        <tbody>
                        <?php
                            foreach ($features as $feature) {
                            ?>
                            <tr>
                                <th><?= $feature->key ?></th>
                                <td><?= $feature->value ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (!empty($related_products)) {
    ?>
    <div class="row mt-5">
        <div class="container py-5">

            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h4 class="fw-bold">Related Products</h4>
                </div>
            </div>

            <div class="position-relative">
                <div class="swiper product-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($related_products as $related_product) {
                            ?>
                            <div class="swiper-slide">
                                <div class="card h-100">
                                    <img class="card-img-top p-3" src="<?= base_url($related_product->image_url) ?>" alt="Product 1">
                                    <div class="card-body p-3">
                                        <a href="<?= base_url('/product/' . $related_product->slug)?>"
                                           class="card-title fw-semibold mb-2"><?= $related_product->name ?></a>
                                    </div>
                                    <div class="prices px-3 fw-bold text-secondary">
                                        <?php
                                        if ($related_product->promo > 0.0) {
                                            ?>
                                            <div class="related-price-del">
                                                <del>
                                                    <?= '€' . $related_product->price ?>
                                                </del>
                                            </div>

                                            <div class="related-price-current">
                                                <?= '€' . $related_product->promo ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="related-price-current">
                                                <?= '€' . $related_product->price ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $in_stock = true;
                                    if ($related_product->stock_quantity == 0) {
                                        $in_stock = false;
                                    }
                                    ?>
                                    <div class="p-2 mt-auto">
                                        <button data-product-id="<?= $related_product->id ?>"
                                                class="d-none d-sm-block btn w-100 fw-bold green-btn
                                            add-to-cart-btn rel-products-atc-button
                                            <?= !$in_stock ? 'disabled' : '' ?>">
                                            <i class="fa-solid fa-bag-shopping me-1"></i>
                                            <?= !$in_stock ? 'Out Of Stock' : 'Add to Cart' ?>
                                        </button>
                                        <button data-product-id="<?= $related_product->id ?>"
                                                class="d-sm-none btn w-100 swiper-icon-btn green-btn add-to-cart-btn
                                            rel-products-atc-button">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="mt-2 d-none d-md-block">
                        <div class="swiper-button-next rounded-3"></div>
                        <div class="swiper-button-prev rounded-3"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>


<div class="row mt-5">
    <div class="col-12 text-center mb-4">
        <h4 class="fw-bold">Reviews (<?= $reviews['reviews_count'] ?>)</h4>
        <p>
            <?= $reviews['reviews_count'] == 0 ? 'No reviews yet. Be the first to share your experience.' : '' ?>
        </p>
    </div>

    <?php
    if (!empty($reviews['reviews_data'])) {
        foreach ($reviews['reviews_data'] as $review) {
            ?>
            <div class="col-12">

                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="review-rater" data-rating=<?= $review->rating ?>></div>
                    </div>
                    <div class="col-6 text-end text-muted">
                        <small><?= $review->created_at ?></small>
                    </div>
                </div>

                <p class="mt-3 mb-3">
                    <?= $review->feedback ?>
                </p>

                <p class="fw-bold">- <?= $review->name ?></p>
                <hr class="mt-3">
            </div>
            <?php
        }
    }
    ?>

    <div class="col-12 mt-4" id="reviews">
        <h5 class="fw-bold">Your Rating</h5>

        <div id="main-product-rater"></div>
        <input type="hidden" id="main-product-rating" value="1">

        <textarea placeholder="Your review"
                  class="form-control mt-3"
                  id="exampleFormControlTextarea1"
                  rows="5"
                  name="feedback"></textarea>

        <div class="row mt-4">
            <div class="col-6">
                <input class="form-control" type="text" name="name" placeholder="Name">
            </div>

            <div class="col-6">
                <input class="form-control" type="text" name="email" placeholder="Email">
            </div>
        </div>

        <button class="btn gray-btn mt-3 submit-review-btn">
            Submit Your Review
        </button>
    </div>
</div>
<!-- PRODUCT END -->

<script>
    $('.add-to-favorite').on('click', function (e) {
        let product_id = <?= $product->id ?>;

        $.ajax({
            url: '<?= base_url('/add-favorite/') ?>' + product_id,
            method: 'GET'
        }).done(function (response) {
            let title;
            let icon;

            if (response.status === 'success') {
               icon = "success";
               title = "Added to favorites!";
            } else if (response.status === 'existing_favorite') {
                icon = "info";
                title = "Already saved";
            } else {
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
                timer: 3000,
                timerProgressBar: true,
                background: "#fff",
                color: "#333",
            });
        });
    })
</script>

<script>
    $('.pro-det-adc-btn').on('click', function (e) {
        e.preventDefault();

        let comb_value_id = $('.variant.selected .selected-comb-value').val() || null;
        let product_id = <?= $product->id ?>;
        let quantity = $('#quantity-input').val();

        $.ajax({
           url: '<?= base_url('/add-to-cart')?>',
           method: 'post',
           data: {
               comb_value_id: comb_value_id,
               product_id: product_id,
               quantity: quantity,
               quick_add: false
           },
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

    $(document).on("click", ".rel-products-atc-button", function () {
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
</script>

<script>
    $(".variant").on("click", function (e) {
        e.preventDefault();
        let element = $(this);
        $(".variant").removeClass("selected");
        element.addClass("selected");

        let selected_input = $('.variant.selected .selected-comb-value');
        let comb_sku = selected_input.data('comb-sku');
        $('.sku').empty().append(comb_sku);

        let comb_price = Number(selected_input.data('comb-price')).toFixed(2);
        let comb_promo = Number(selected_input.data('comb-promo')).toFixed(2);

        if (comb_promo > 0) {
            $('#price-box').html(
                `
            <div class="price-through">
                ${comb_price} €
            </div>
            <div class="promo-price">
                ${comb_promo} €
            </div>
            `
            );
        } else {
            $('#price-box').html(
                `
            <div class="regular-price text-success">
                ${comb_price} €
            </div>
            `
            );
        }
    });
</script>

<script>
    $('#decrease-qty').on('click', function () {
        let qty_val = Number($('#quantity-input').val());
        if (qty_val !== 1) {
            $('#quantity-input').val(qty_val - 1);
        }
    });

    $('#increase-qty').on('click', function () {
        let qty_val = Number($('#quantity-input').val());
        if (qty_val <= 99) {
            $('#quantity-input').val(qty_val + 1);
        }
    });
</script>

<script>

    $('#fast-product-rater').on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: "How Was Your Experience?",
            input: "textarea",
            inputAttributes: {
                autocapitalize: "off",
                placeholder: "Tell us about your experience..."
            },
            showCancelButton: true,
            confirmButtonText: "Send",
            showLoaderOnConfirm: true,
            confirmButtonColor: "#46c82c",
            cancelButtonColor: "#5a6771",
            preConfirm: (feedback) => {
                let ratingStars = $('#fast-product-rating').val();
                return $.ajax({
                    url: '<?= base_url('/submit-rating') ?>',
                    method: 'post',
                    data: {
                        rating: ratingStars,
                        feedback: feedback,
                        product_id: '<?= $product->id ?>'
                    }
                });
            }
        }).then((response) => {
            if (response.isConfirmed) {
                const result = response.value;

                if (result.success) {
                    Swal.fire({
                        title: "Thank you for your feedback",
                        text: "Your feedback helps us improve!",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else {
                    Swal.fire({
                        title: result.message,
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                }
            }
        });
    });

    $('#fast-product-rater').on('touchstart', function(e) {
        e.preventDefault();
        $(this).trigger('click');
    });

    $('.submit-review-btn').on('click', function (e) {
        let rating = $('#main-product-rating').val();
        let feedback = $('textarea[name="feedback"]').val();
        let name = $('input[name="name"]').val();
        let email = $('input[name="email"]').val();

        $.ajax({
            url: '<?= base_url('/submit-rating') ?>',
            method: 'post',
            data: {
                rating: rating,
                feedback: feedback,
                name: name,
                email: email,
                product_id: '<?= $product->id ?>'
            },
            dataType: 'json',
            success: function (response) {
                if (response.success === true) {
                    Swal.fire({
                        title: response.message,
                        text: "Your feedback helps us improve!",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                }
            }
        });
    });
</script>


