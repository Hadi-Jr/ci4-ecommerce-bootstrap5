<!-- HEADER START -->
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="d-flex gap-2 gap-md-3 mx-auto">
                <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" class="bi" height="24"
                         width="24" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z">
                        </path>
                    </svg>
                </button>

                <a class="p-1 d-lg-none mx-auto" data-bs-toggle="collapse" href="#search-field" role="button"
                   aria-expanded="false" aria-controls="search-field">
                    <i class="fa-solid fa-magnifying-glass" style="color: rgb(28, 208, 199);"></i>
                </a>
            </div>

            <a class="navbar-brand ms-lg-5 me-lg-5" href="<?= base_url('/')?>">
                <img class="navbar-logo-lg d-none d-lg-block" src="<?= base_url('/assets/images/logo.png') ?>" alt="Logo">
                <img class="navbar-logo-md d-none d-md-block d-lg-none" src="<?= base_url('/assets/images/logo.png') ?>" alt="Logo">
                <img class="navbar-logo-sm d-block d-md-none" src="<?= base_url('/assets/images/logo.png') ?>" alt="Logo">
            </a>

            <div class="d-lg-none d-flex align-items-center gap-2 mx-auto">

                <?php
                if (session()->get('user_data') !== null) {
                    ?>
                    <a href="<?= base_url('/logout') ?>"
                       class="btn btn-outline-secondary rounded p-2 header-icons" aria-label="Account">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?= base_url('/login') ?>"
                       class="btn btn-outline-secondary rounded p-2 header-icons" aria-label="Account">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <?php
                }
                ?>

                <a class="btn green-btn rounded p-2 position-relative header-icons"
                   aria-label="Cart"
                   href="<?= base_url('/my-cart') ?>">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="items-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size: 10px;">
                        <?= $cart_items_count ?>
                    </span>
                </a>
            </div>

            <div class="collapse navbar-collapse p-2" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item d-none d-lg-block">
                        <button class="btn btn-outline-secondary rounded" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                            <i class="bi bi-grid-3x3-gap"></i>
                            Categories
                        </button>
                    </li>

                    <li class="nav-item d-none d-lg-block ms-lg-2">
                        <a class="nav-link active text-danger" aria-current="page"
                           href="<?= base_url('/promotions') ?>">
                            <i class="fa-solid fa-tag"></i>
                            Promotions
                        </a>
                    </li>

                    <li class="d-lg-none p-0">
                        <ul class="list-unstyled list-group mt-3">
                            <li class="border-0 list-group-item list-item-clickable">
                                <a class="d-flex align-items-center gap-2 mt-2" href="<?= base_url('/favorites') ?>">
                                    <i class="fa-solid fa-bookmark" style="color: rgb(28, 208, 199);"></i>
                                    My Favorites
                                </a>
                            </li>

                            <li class="border-0 list-group-item list-item-clickable">
                                <a class="d-flex align-items-center gap-2" href="<?= base_url('/my-orders') ?>">
                                    <i class="fa-solid fa-box" style="color: rgb(28, 208, 199);"></i>
                                    Orders
                                </a>
                            </li>

                            <li class="border-0 list-group-item list-item-clickable">
                                <a class="d-flex align-items-center gap-2" href="<?= base_url('/promotions') ?>">
                                    <i class="fa-solid fa-tag" style="color: rgb(28, 208, 199);"></i>
                                    Promotions
                                </a>
                            </li>

                            <li class="border-0 list-group-item">
                                <hr class="my-1">
                            </li>

                            <?php
                            renderCategories($categories ?? []);
                            ?>
                        </ul>
                    </li>
                </ul>

                <!--     SEARCH INPUT           -->
                <div class="w-50 mx-auto">
                    <form class="d-flex d-none d-lg-block" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-start-5" placeholder="Search" aria-label="Search">
                            <button class="input-group-text rounded-end-5 green-btn search-btn" type="submit">
                                <i class="fa-solid fa-magnifying-glass icon-teal"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-none d-lg-flex align-items-center gap-2 me-lg-5">

                <a href="<?= base_url('/favorites') ?>" class="btn btn-outline-secondary rounded p-2 header-icons"
                   aria-label="Orders" title="My Favorites">
                    <i class="fa-solid fa-bookmark"></i>
                </a>

                <a href="<?= base_url('/my-orders') ?>" class="btn btn-outline-secondary rounded p-2 header-icons" aria-label="Orders" title="My Orders">
                    <i class="fa-solid fa-box"></i>
                </a>
                <?php
                if (session()->get('user_data') !== null) {
                    ?>
                    <a href="<?= base_url('/logout') ?>" class="btn btn-outline-secondary rounded p-2 header-icons"
                       aria-label="Account" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                <?php
                } else {
                    ?>
                    <a href="<?= base_url('/login') ?>" class="btn btn-outline-secondary rounded p-2 header-icons"
                       aria-label="Account" title="Login">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php
                }
                ?>

                <a class="btn green-btn rounded p-2 position-relative header-icons"
                   aria-label="Cart"
                   title="My Cart"
                   href="<?= base_url('/my-cart') ?>">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="items-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size: 10px;">
                        <?= $cart_items_count ?>
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <div class="p-3 d-lg-none">
        <form class="collapse" id="search-field" role="search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                <button class="btn green-btn search-btn" type="submit" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass icon-white"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
         id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Categories</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled list-group">
                <?php renderCategories($categories ?? []); ?>
            </ul>
        </div>
    </div>
</header>
<!-- HEADER END -->

<script>
    $('.search-btn').on('click', function (e) {
        e.preventDefault();
        let search_value = $(this).siblings('input').val().trim();

        if (!search_value) {
            return;
        }

        window.location.href = '<?= base_url('/search') ?>' + '?query=' + encodeURIComponent(search_value);
    });
</script>

<!-- BODY START -->
<main class="container mb-5 my-md-4">