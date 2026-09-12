<!-- CATEGORY PRODUCTS START -->
<div class="row text-center mt-3 justify-content-center">
    <div class="col-12 col-md-9">
        <div class="card w-100 mt-2 mt-md-4">
            <img class="card-img-top category-card-img" src="<?= base_url('/assets/images/promo-banner.jpg') ?>"
                 alt="product">
        </div>
    </div>
</div>

<div class="row mt-3 justify-content-center">
    <div class="col-12 col-md-9">

        <div class="row mb-3 mt-5 category-selected-header">
            <div class="col-8 col-sm-10">
                <h3>Promotions</h3>
            </div>
            <div class="col-4 col-sm-2 d-flex justify-content-end">
                <div class="dropdown">
                    <button class="btn dropdown-toggle category-sort-btn" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        Sort By
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item sort-option" href="#" data-sort="name_asc">Name (ascending order)</a></li>
                        <li><a class="dropdown-item sort-option" href="#" data-sort="name_desc">Name (descending order)</a></li>
                        <li><a class="dropdown-item sort-option" href="#" data-sort="price_asc">Price (ascending order)</a></li>
                        <li><a class="dropdown-item sort-option" href="#" data-sort="price_desc">Price (descending order)</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!--       CATEGORY PRODUCTS      -->
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
                                <button data-product-id="<?= $promo_product->id ?>"
                                        class="d-none d-lg-block btn w-100 fw-bold green-btn
                                        add-to-cart-btn cat-products-atc-btn">
                                    <i class="fa-solid fa-bag-shopping me-1"></i> Add To Cart
                                </button >
                                <button data-product-id="<?= $promo_product->id ?>"
                                        class="d-lg-none btn w-100 green-btn cat-products-atc-btn">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </button>
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
    </div>
</div>

<!-- CATEGORY PRODUCTS END -->

<script>
    const state = {
        sort: '',
        page: 1
    };

    function buildParams() {
        const params = new URLSearchParams();

        if (state.sort) {
            params.set('sort', state.sort);
        }

        params.set('page', state.page);

        return params;
    }

    $(document).on('click', '.page-number', function (e) {
        e.preventDefault();

        state.page = $(this).data('page');

        updateProducts();
    })


    $('.sort-option').on('click', function (e) {
        e.preventDefault();
        state.sort = $(this).data('sort');
        state.page = 1;

        updateProducts();
    });

    function updateProducts() {
        const params = buildParams();

        const url = '<?= base_url('/promotions') ?>' + '?' + params.toString();
        history.pushState({}, '', url);

        $.ajax({
            url: url,
            method: 'GET'
        }).done(function (response) {
            $('#promo-products').html(response);
        });
    }

</script>