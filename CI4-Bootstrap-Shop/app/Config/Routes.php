<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

// Authentication
$routes->add('/register', 'UserController::register', ['filter' => 'guest']);
$routes->add('/login', 'UserController::login', ['filter' => 'guest']);
$routes->add('/logout', 'UserController::logout');

// Search
$routes->add('/search', 'Home::search');

// Categories
$routes->add('/category/(:any)', 'CategoryController::view/$1');

// Products
$routes->add('/product/(:any)', 'ProductController::view/$1');
$routes->add('/submit-rating', 'ReviewController::submit_rating');
$routes->add('/promotions', 'ProductController::promo_products');

// Carts
$routes->add('/add-to-cart', 'CartController::add_to_cart');
$routes->add('/my-cart', 'CartController::view');
$routes->add('/update-product-quantity', 'CartController::update_quantity');
$routes->add('/delete_item', 'CartController::delete_item');

// Orders
$routes->add('/checkout', 'OrderController::checkout');
$routes->add('/place-order', 'OrderController::place_order');
$routes->add('/order_confirmation/(:any)', 'OrderController::order_confirmation/$1');
$routes->add('/my-orders', 'OrderController::get_orders');
$routes->add('/order-details/(:any)', 'OrderController::order_details/$1');
$routes->add('/order-details-track-nr/(:any)', 'OrderController::order_details_by_tracking_nr/$1');
$routes->add('/order/track/(:any)', 'OrderController::get_order_by_tracking_nr/$1');
$routes->add('/cancel-order', 'OrderController::cancel_order', ['filters' => 'auth']);

// Favorites
$routes->add('/favorites', 'FavoritesController::view', ['filters' => 'auth']);
$routes->add('/add-favorite/(:any)', 'FavoritesController::add_favorite/$1', ['filters' => 'auth']);
$routes->add('/remove-favorite', 'FavoritesController::remove_favorite', ['filters' => 'auth']);

/************************************* ADMIN ROUTES *************************************/
// Dashboard
$routes->add('/dashboard', 'Admin\AdminDashboardController::view', ['filter' => 'admin']);

// Products
$routes->add('/add-product', 'Admin\AdminProductController::add_product', ['filter' => 'admin']);
$routes->add('/get-attribute-values/(:any)', 'Admin\AdminProductController::get_attribute_values/$1', ['filter' => 'admin']);
$routes->add('/products-list', 'Admin\AdminProductController::products_list', ['filter' => 'admin']);
$routes->add('/change-product-status', 'Admin\AdminProductController::change_product_status', ['filter' => 'admin']);
$routes->add('/edit-product-view/(:any)', 'Admin\AdminProductController::edit_product_view/$1', ['filter' => 'admin']);
$routes->add('/edit-product', 'Admin\AdminProductController::edit_product', ['filter' => 'admin']);
$routes->add('/edit-specs', 'Admin\AdminProductController::edit_specs', ['filter' => 'admin']);
$routes->add('/edit-attributes', 'Admin\AdminProductController::edit_attributes', ['filter' => 'admin']);
$routes->add('/edit-combinations', 'Admin\AdminProductController::edit_combinations', ['filter' => 'admin']);

// Categories
$routes->add('/categories', 'Admin\AdminCategoryController::view', ['filter' => 'admin']);
$routes->post('/change-category-status', 'Admin\AdminCategoryController::change_category_status', ['filter' => 'admin']);
$routes->add('/edit-category-view/(:any)', 'Admin\AdminCategoryController::edit_category_view/$1', ['filter' => 'admin']);
$routes->add('/edit-category-view/(:any)', 'Admin\AdminCategoryController::edit_category_view/$1', ['filter' => 'admin']);
$routes->add('/edit-category', 'Admin\AdminCategoryController::edit_category', ['filter' => 'admin']);
$routes->add('/add-category', 'Admin\AdminCategoryController::add_category', ['filter' => 'admin']);

// Orders
$routes->add('/admin/orders-list', 'Admin\AdminOrdersController::view', ['filter' => 'admin']);
$routes->add('/change-order-status', 'Admin\AdminOrdersController::change_status', ['filter' => 'admin']);
$routes->add('/admin/order_detail/(:any)', 'Admin\AdminOrdersController::order_details/$1', ['filter' => 'admin']);



