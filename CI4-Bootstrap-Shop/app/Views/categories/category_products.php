<!-- CATEGORY PRODUCTS START -->
<div class="row text-center mt-3">
    <h3 class="fw-bold"><?= $category->name ?> (<?= $total_products ?> items)</h3>
</div>

<div class="row mt-3">
    <div class="d-flex justify-content-between d-block d-md-none p-3">
        <button class="btn category-filter-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                aria-controls="offcanvasTop">
            All Filters
        </button>

        <div class="offcanvas offcanvas-top category-offcanvas-top" tabindex="-1" id="offcanvasTop"
             aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <?php
                foreach ($filters as $key => $filter) {
                    ?>
                    <div class="row">
                        <div class="col">
                            <button class="btn w-100 p-3 mt-3 d-flex justify-content-between category-filter-btn"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#mobile-<?= esc(strtolower(str_replace(' ', '-', $key))) ?>"
                                    aria-expanded="false"
                                    aria-controls="mobile-<?= esc(strtolower(str_replace(' ', '-', $key))) ?>">
                                <?= esc($key) ?>
                                <div><i class="fa-solid fa-chevron-down"></i></div>
                            </button>

                            <div class="collapse mt-2"
                                 id="mobile-<?= esc(strtolower(str_replace(' ', '-', $key))) ?>">
                                <div class="card card-body">
                                    <?php
                                    foreach ($filter['values'] as $value_key => $value) {
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input filter-checkbox"
                                                   type="checkbox"
                                                   data-filter-id="<?= esc($value) ?>"
                                                   id="mobile-<?= esc($value_key) ?>"
                                                   value="<?= esc($value) ?>"
                                                    <?= in_array($value, $selected_filters) ? 'checked' : '' ?>>

                                            <label class="form-check-label"
                                                   for="mobile-<?= esc($value_key) ?>">
                                                <?= esc($value_key) ?>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <button class="btn p-2 w-100 mt-4 green-btn fw-bold apply-filter-btn">
                            Apply Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown">
            <button class="btn dropdown-toggle category-sort-btn" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                Sort By
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item sort-option" href="#" data-sort="name_asc">Name (ascending order)</a></li>
                <li><a class="dropdown-item sort-option" href="#" data-sort="name_desc">Name (descending order)</a></li>
                <li><a class="dropdown-item sort-option" href="#" data-sort="price_asc">Price (ascending order)</a></li>
                <li><a class="dropdown-item sort-option" href="#" data-sort="price_desc">Price (descending order)</a></li>
            </ul>
        </div>
    </div>

    <div class="d-none d-md-block col-md-3 mt-3">
        <div class="row">
            <div class="col">
                <?php
                foreach ($filters as $key => $filter) {
                    ?>
                    <button class="btn w-100 p-md-2 p-lg-3 mt-3 d-flex justify-content-between category-filter-btn"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#<?= esc(strtolower(str_replace(' ', '-', $key))) ?>"
                            aria-expanded="false"
                            aria-controls="<?= esc(strtolower(str_replace(' ', '-', $key))) ?>">
                        <?= esc($key) ?>
                        <div><i class="fa-solid fa-chevron-down"></i></div>
                    </button>

                    <div class="collapse mt-2" id="<?= esc(strtolower(str_replace(' ', '-', $key))) ?>">
                        <div class="card card-body">
                        <?php
                        foreach ($filter['values'] as $value_key => $value) {
                            ?>
                            <div class="form-check ">
                                <input class="form-check-input filter-checkbox"
                                       type="checkbox"
                                       data-filter-id="<?= esc($value) ?>"
                                       id="desktop-<?= esc($value_key) ?>"
                                       value="<?= esc($value) ?>"
                                    <?= in_array($value, $selected_filters) ? 'checked' : '' ?>>

                                <label class="form-check-label"
                                       for="desktop-<?= esc($value_key) ?>">
                                    <?= esc($value_key) ?>
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <button class="btn p-md-1 p-lg-2 w-100 mt-4 green-btn fw-bold apply-filter-btn">Apply Filter</button>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <div class="row">
            <?php
            foreach ($category_banners ?? [] as $category_banner) {
                ?>
                <div class="col-12 col-lg-6">
                    <div class="card w-100 mt-2 mt-md-4">
                        <img class="card-img-top category-card-img" src="<?= base_url($category_banner->image_url) ?>"
                             alt="product">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="row mb-3 mt-5 category-selected-header">
            <div class="col-11">
                <h3>Selected Products</h3>
            </div>
            <div class="col-1 d-none d-lg-block">
                <div class="dropdown">
                    <button class="btn dropdown-toggle category-sort-btn" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        Sort By
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item sort-option" href="#" data-sort="name_asc">Name (ascending order)</a></li>
                        <li><a class="dropdown-item sort-option" href="#" data-sort="name_desc">Name (descending order)</a></li>
                        <li><a class="dropdown-item sort-option" href="#" data-sort="price_asc">Price (ascending order)</a></li>
                        <li><a class="dropdown-item sort-option" href="#" data-sort="price_desc">Price (descending order)</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!--       CATEGORY PRODUCTS      -->
        <div id="category-products">
            <?php
            if (empty($category_products)) {
                ?>
                <div class="row mt-lg-3 p-2">
                    <p class="alert alert-info">No products available in this category.</p>
                </div>
                <?php
            } else {
            ?>
            <div class="row g-4">
                <?php
                foreach ($category_products as $category_product) {
                    ?>
                    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="card h-100 overflow-hidden">
                            <img class="pointer" src="<?= base_url($category_product->image_url) ?>" alt="product">
                            <div class="card-body p-3">
                                <a href="<?= base_url('/product/' . $category_product->slug) ?>"
                                   class="card-title category-product-title">
                                    <?= $category_product->name ?>
                                </a>
                            </div>
                            <div class="prices ms-3 gap-1 gap-sm-2 gap-md-3 category-price-current">
                                <?php
                                if ($category_product->promo > 0.0) {
                                    ?>
                                    <div class="category-price-del">
                                        <del>
                                            <?= '€' . $category_product->price ?>
                                        </del>
                                    </div>

                                    <div class="category-price-current">
                                        <?= '€' . $category_product->promo ?>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="category-price-current">
                                        <?= '€' . $category_product->price ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="p-2 mt-2">
                                <button data-product-id="<?= $category_product->id ?>"
                                        class="d-none d-lg-block btn w-100 fw-bold green-btn
                                        add-to-cart-btn cat-products-atc-btn">
                                    <i class="fa-solid fa-bag-shopping me-1"></i> Add To Cart
                                </button >
                                <button data-product-id="<?= $category_product->id ?>"
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

<script>
    const state = {
        filters: [],
        sort: '',
        page: 1
    };

    function buildParams() {
        const params = new URLSearchParams();

        if (state.filters.length > 0) {
            params.set('filters', state.filters.join(','));
        }

        if (state.sort) {
            params.set('sort', state.sort);
        }

        params.set('page', state.page);

        return params;
    }

    $('.apply-filter-btn').on('click', function () {
        state.filters = [...new Set(
            $('.filter-checkbox:checked')
                .map(function () {
                    return this.value;
                })
                .get()
        )];

        state.page = 1;

        updateProducts();
    });

    $('.sort-option').on('click', function (e) {
        e.preventDefault();
        state.sort = $(this).data('sort');
        state.page = 1;

        updateProducts();
    });

    $(document).on('click', '.page-number', function (e) {
        e.preventDefault();

        state.page = $(this).data('page');
        updateProducts();
    });

    function updateProducts() {
        const params = buildParams();

        const url = '<?= base_url('/category/' . $slug) ?>' + '?' + params.toString();

        history.pushState({}, '', url)

        $.ajax({
            url: url,
            method: 'GET'
        }).done(function (response) {
            $('#category-products').html(response);
        });
    }
</script>