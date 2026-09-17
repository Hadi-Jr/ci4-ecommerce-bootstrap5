<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand mt-1" href="<?= base_url('/admin-home-page') ?>">
                <img style="width: 30px" src="<?= base_url('admin-assets/src/img/icons/icon-48x48.png') ?>">
                <span class="align-middle small ms-2">Inventory Management</span>
            </a>

            <ul class="sidebar-nav">

                <li class="sidebar-header">
                    Inventory and operations
                </li>

                <!-- Dashboard -->
                <li class="sidebar-item active">
                    <a class="sidebar-link" href="<?= base_url('/dashboard') ?>">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <!--  Categories   -->
                <li class="sidebar-item parent">
                    <a data-bs-target="#category" data-bs-toggle="collapse" class="sidebar-link collapsed" href="#">
                        <i class="align-middle" data-feather="grid"></i>
                        <span class="align-middle">Categories</span>
                    </a>

                    <ul id="category" class="sidebar-dropdown list-unstyled collapse ms-3">
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center" href="<?= base_url('/categories') ?>">
                                <i class="align-middle" data-feather="minus"></i>
                                <span>Categories List</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center" href="<?= base_url('/add-category') ?>">
                                <i class="align-middle" data-feather="minus"></i>
                                <span>Add Category</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Inventory -->
                <li class="sidebar-item parent">
                    <a data-bs-target="#inventory" data-bs-toggle="collapse" class="sidebar-link collapsed" href="#">
                        <i class="align-middle" data-feather="package"></i>
                        <span class="align-middle">Products</span>
                    </a>

                    <ul id="inventory" class="sidebar-dropdown list-unstyled collapse ms-3">
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center" href="<?= base_url('/add-product') ?>">
                                <i class="align-middle" data-feather="minus"></i>
                                <span>Add Product</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center" href="<?= base_url('/products-list') ?>">
                                <i class="align-middle" data-feather="minus"></i>
                                <span>Products List</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center" href="<?= base_url('/edit-specs') ?>">
                                <i class="align-middle" data-feather="minus"></i>
                                <span>Edit Features</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center" href="<?= base_url('/edit-attributes') ?>">
                                <i class="align-middle" data-feather="minus"></i>
                                <span>Edit Attributes</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link d-flex align-items-center" href="<?= base_url('/edit-combinations') ?>">
                                <i class="align-middle" data-feather="minus"></i>
                                <span>Edit Combinations</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle">
                <i class="hamburger align-self-center"></i>
            </a>

            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                            <i class="align-middle" data-feather="settings"></i>
                        </a>

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                            <img src="<?= base_url('admin-assets/src/img/icons/user-icon.png') ?>" class="avatar img-fluid rounded me-1" />
                            <span class="text-dark">
                                <?= $user_data->full_name?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                            <a class="dropdown-item" href="<?= base_url('/logout') ?>">Log out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>




