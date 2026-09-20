<!-- SEARCH RESULTS START -->
<div class="row text-center mt-5">
    <h3 class="fw-bold">Search Results</h3>
</div>

<div class="row mt-4 justify-content-center">
    <div class="col-6">
        <input type="text" class="form-control rounded" placeholder="Search" aria-label="Search">
    </div>
    <div class="col-auto">
        <button class="btn green-btn fw-bold">Search</button>
    </div>
</div>

<div class="row mt-5 justify-content-center">
    <div class="col-12 col-md-9">
        <div class="row g-4">
            <?php
            foreach ($products as $product) {
                ?>
                <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <img class="category-card-img" src="<?= $product->image_url ?>" class="card-img-top"
                             alt="product">
                        <div class="card-body p-3">
                            <a href="<?= base_url('/product/' . $product->slug) ?>"
                               class="card-title category-product-title">
                                <?= $product->name ?>
                            </a>
                        </div>
                        <div class="prices ms-3 gap-1 gap-sm-2 gap-md-3 category-price-current">
                            <?php
                            if ($product->promo > 0.0) {
                                ?>
                                <div class="category-price-del">
                                    <del>
                                        <?= '€' . $product->price ?>
                                    </del>
                                </div>

                                <div class="category-price-current">
                                    <?= '€' . $product->promo ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="category-price-current">
                                    <?= '€' . $product->price ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="p-2 mt-2">
                            <button data-product-id="<?= $product->id ?>"
                                    class="d-none d-lg-block btn w-100 fw-bold green-btn
                                        add-to-cart-btn cat-products-atc-btn">
                                <i class="fa-solid fa-bag-shopping me-1"></i> Add To Cart
                            </button >
                            <button data-product-id="<?= $product->id ?>"
                                    class="d-lg-none btn w-100 green-btn cat-products-atc-btn">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".cat-products-atc-btn", function () {
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

<!-- SEARCH RESULTS END -->