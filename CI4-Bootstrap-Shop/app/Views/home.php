<!-- HOME PAGE START -->

<!-- SINGLE CAROUSEL -->
<div class="row position-relative">
    <div id="mainCarousel" class="swiper rounded">
        <div class="swiper-wrapper">
            <a href="<?= base_url('/promotions') ?>" class="swiper-slide">
                <img src="<?= base_url('/assets/images/home/banners/banner1.jpg') ?>" class="d-block w-100" alt="...">
            </a>
            <a href="<?= base_url('/promotions') ?>" class="swiper-slide">
                <img src="<?= base_url('/assets/images/home/banners/banner2.jpg') ?>" class="d-block w-100" alt="...">
            </a>
        </div>
    </div>

    <div class="d-none d-md-block">
        <div class="swiper-button-next rounded-3"></div>
        <div class="swiper-button-prev rounded-3"></div>
    </div>
</div>

<!-- OFFERS BANNERS -->
<div class="row mt-5">
    <div class="col-12 text-center mb-4">
        <h3 class="fw-bold">Offers Of The Month</h3>
    </div>
    <div class="col-12 col-md-6 mt-2">
        <a href="<?= base_url('/promotions') ?>" class="card">
            <img class="card-img-top" src="<?= base_url('/assets/images/home/offers/offer1.jpg') ?>" alt="Card image cap">
        </a>
    </div>

    <div class="col-12 col-md-6 mt-2">
        <a href="<?= base_url('/promotions') ?>" class="card">
            <img class="card-img-top" src="<?= base_url('/assets/images/home/offers/offer2.jpg') ?>" alt="Card image cap">
        </a>
    </div>

    <div class="col-12 col-md-6 mt-2">
        <a href="<?= base_url('/promotions') ?>" class="card">
            <img class="card-img-top" src="<?= base_url('/assets/images/home/offers/offer3.jpg') ?>" alt="Card image cap">
        </a>
    </div>

    <div class="col-12 col-md-6 mt-2">
        <a href="<?= base_url('/promotions') ?>" class="card">
            <img class="card-img-top" src="<?= base_url('/assets/images/home/offers/offer4.jpg') ?>" alt="Card image cap">
        </a>
    </div>
</div>

<!-- TRENDING PRODUCTS -->
<div class="row mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h4 class="fw-bold">Trending Products</h4>
            </div>
        </div>

        <div class="position-relative">
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">

                    <?php
                    foreach ($trending_products as $product) {
                        ?>
                        <div class="swiper-slide">
                            <div class="card h-100">
                                <img class="card-img-top p-3" src="<?= base_url($product->image_url) ?>" alt="Product 1">
                                <div class="card-body p-3">
                                    <a href="<?= base_url('/product/'. $product->slug) ?>" class="card-title fw-semibold mb-2"><?= $product->name ?></a>
                                </div>
                                <div class="prices px-3 fw-bold text-secondary">
                                    <?php
                                    if ($product->promo > 0.0) {
                                        ?>
                                        <div class="related-price-del">
                                            <del>
                                                <?= '€' . $product->price ?>
                                            </del>
                                        </div>

                                        <div class="related-price-current">
                                            <?= '€' . $product->promo ?>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="related-price-current">
                                            <?= '€' . $product->price ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                $in_stock = true;
                                if ($product->stock_quantity == 0) {
                                    $in_stock = false;
                                }
                                ?>
                                <div class="p-2 mt-auto">
                                    <?php
                                    if ($user_data?->role === 'admin'){
                                        ?>
                                        <a  href="<?= base_url('/edit-product-view/') . $product->id ?>"
                                            class="d-none d-sm-block
                                            btn w-100 fw-bold btn-outline-secondary">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit Product
                                        </a>
                                        <a href="<?= base_url('/edit-product-view/') . $product->id ?>"
                                            class="d-sm-none btn w-100 swiper-icon-btn btn-outline-secondary">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <?php
                                    } else {
                                        $in_stock = true;
                                        if ($product->stock_quantity == 0) {
                                            $in_stock = false;
                                        }
                                        ?>
                                        <button data-product-id="<?= $product->id ?>" class="d-none d-sm-block
                                            btn w-100 fw-bold green-btn
                                            trending-products-atc-button add-to-cart-btn
                                            <?= !$in_stock ? 'disabled' : '' ?>">
                                            <i class="fa-solid fa-bag-shopping me-1"></i>
                                            <?= !$in_stock ? 'Out Of Stock' : 'Add to Cart' ?>
                                        </button>
                                        <button data-product-id="<?= $product->id ?>"
                                                class="d-sm-none btn w-100 swiper-icon-btn trending-products-atc-button">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </button>
                                        <?php
                                    }
                                    ?>

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

<!-- POPULAR CATEGORIES -->
<div class="row">
    <div class="container py-5">

        <div class="row">
            <div class="col-12 text-center mb-4">
                <h4 class="mb-4 fw-bold">Popular Categories</h4>
            </div>
        </div>

        <div class="position-relative">
            <div class="swiper popular-categories-swiper">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($child_categories as $category) {
                        ?>
                        <div class="swiper-slide mt-2">
                            <div class="card">
                                <div class="row align-items-center p-4">
                                    <div class="col-3">
                                        <img class="trending-image"
                                             src="<?= base_url('/assets/images/trending-icon.png') ?>">
                                    </div>
                                    <div class="col-9 ps-2">
                                        <div class="card-body p-0">
                                            <a href="<?= base_url('/category/' . $category->cat_slug) ?>"
                                                    class="fw-bold mb-0"><?= $category->cat_name ?></a>
                                            <p class="card-text mb-0"><?= $category->product_count ?> products</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mt-4 d-none d-md-block">
                    <div class="swiper-button-next rounded-3"></div>
                    <div class="swiper-button-prev rounded-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BRANDS -->
<div class="row mt-5 p-2">
    <div class="col-12 text-center mb-4">
        <h4 class="fw-bold">Our Top Brands</h4>
    </div>

    <div class="col-12 overflow-hidden">
        <div class="swiper brand-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/Medix_496x204.webp"
                         alt="Medix" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/_Logo_Mr_Proper_496x204px.webp"
                         alt="Mr Proper" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/Mixa_logo_1.webp" alt="Mixa" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/Pic_logo.webp" alt="Pic" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/_Logo_Duracell_496x204px.webp"
                         alt="Duracell" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/kool_patch_logo.webp"
                         alt="Kool Patch" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/Medix_496x204.webp"
                         alt="Medix" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/_Logo_Mr_Proper_496x204px.webp"
                         alt="Mr Proper" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/Mixa_logo_1.webp" alt="Mixa" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/Pic_logo.webp" alt="Pic" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/_Logo_Duracell_496x204px.webp"
                         alt="Duracell" />
                </div>

                <div class="swiper-slide">
                    <img src="https://galen.bg/media/amasty/shopby/option_images/slider/kool_patch_logo.webp"
                         alt="Kool Patch" />
                </div>
            </div>
        </div>
    </div>
</div>

<!-- HOME PAGE END -->

<script>
    $(document).on("click", ".trending-products-atc-button", function () {
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