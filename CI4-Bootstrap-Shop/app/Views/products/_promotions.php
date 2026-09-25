<div id="promo-products">
    <?php
    if (empty($promo_products)) {
        ?>
        <div class="row mt-lg-3 p-2">
            <p class="alert alert-info">No products available in this category.</p>
        </div>
        <?php
    } else {
    ?>
    <div class="row g-4">
        <?php
        foreach ($promo_products as $promo_product) {
            ?>
            <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                <div class="card h-100 overflow-hidden">
                    <img class="pointer" src="<?= base_url($promo_product->image_url) ?>" alt="product">
                    <div class="card-body p-3">
                        <a href="<?= base_url('/product/' . $promo_product->slug) ?>"
                           class="card-title category-product-title">
                            <?= $promo_product->name ?>
                        </a>
                    </div>
                    <div class="prices ms-3 gap-1 gap-sm-2 gap-md-3 category-price-current">
                        <?php
                        if ($promo_product->promo > 0.0) {
                            ?>
                            <div class="category-price-del">
                                <del>
                                    <?= '€' . $promo_product->price ?>
                                </del>
                            </div>

                            <div class="category-price-current">
                                <?= '€' . $promo_product->promo ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="category-price-current">
                                <?= '€' . $promo_product->price ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="p-2 mt-2">
                        <?php
                        if ($user_data?->role === 'admin') {
                            ?>
                            <a href="<?= base_url('/edit-product-view/') . $promo_product->id ?>"
                               class="d-none d-sm-block
                                            btn w-100 fw-bold btn-outline-secondary">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Edit Product
                            </a>
                            <a href="<?= base_url('/edit-product-view/') . $promo_product->id ?>"
                               class="d-sm-none btn w-100 swiper-icon-btn btn-outline-secondary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <?php
                        } else {
                            $in_stock = true;
                            if ($promo_product->stock_quantity == 0) {
                                $in_stock = false;
                            }
                            ?>
                            <button data-product-id="<?= $promo_product->id ?>" class="d-none d-sm-block
                                            btn w-100 fw-bold green-btn
                                            trending-products-atc-button add-to-cart-btn
                                            <?= !$in_stock ? 'disabled' : '' ?>">
                                <i class="fa-solid fa-bag-shopping me-1"></i>
                                <?= !$in_stock ? 'Out Of Stock' : 'Add to Cart' ?>
                            </button>
                            <button data-product-id="<?= $promo_product->id ?>"
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
        }
        ?>
    </div>

    <?php
    if ($total_pages > 1) {
        $visible_pages = 5;
        $start_page = max(1, $current_page - 2);
        $end_page = min($total_pages, $start_page + $visible_pages - 1);

        if (($end_page - $start_page + 1) < $visible_pages) {
            $start_page = max(1, $end_page - $visible_pages + 1);
        }
        ?>
        <div class="row mt-5">
            <div class="col d-flex justify-content-center">
                <nav aria-label="Page navigation">

                    <ul class="pagination">
                        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link page-number"
                               href="#"
                               data-page="<?= max(1, $current_page - 1) ?>"
                               aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>


                        <?php
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            ?>
                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                <a class="page-link page-number"
                                   data-page="<?= $i ?>"
                                   href="#">
                                    <?= $i ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>

                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link page-number"
                               href="#"
                               aria-label="Next"
                               data-page="<?= min($total_pages, $current_page + 1) ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <?php
    }
    ?>
</div>