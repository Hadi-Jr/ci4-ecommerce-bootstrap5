<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\UserController;
use App\Models\admin\AdminDashboardModel;
use App\Models\admin\AdminOrderModel;
use App\Models\admin\AdminProductModel;
use App\Models\UserModel;
use Config\Database;

class AdminDashboardController extends BaseController
{
    protected $db;
    protected $admin_dashboard_model;
    protected $admin_product_model;
    protected $user_model;
    protected $admin_order_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->admin_dashboard_model = new AdminDashboardModel($this->db);
        $this->admin_product_model = new AdminProductModel($this->db);
        $this->user_model = new UserModel($this->db);
        $this->admin_order_model = new AdminOrderModel($this->db);
    }

    public function view()
    {
        $order_financials = $this->admin_order_model->get_order_financials();
        $low_stock_products = $this->admin_product_model->low_stock_products();

        $this->data += [
            'earnings'                  => $order_financials->earnings,
            'avg_order_value'           => $order_financials->avg_order_value,
            'customers'                 => $this->user_model->registered_users(),
            'products_sold'             => $this->admin_product_model->get_products_sold(),
            'canceled_orders'           => $this->admin_order_model->canceled_orders_count(),
            'recent_orders'             => $this->admin_order_model->recent_orders(),
            'low_stock_products_count'  => count($low_stock_products),
            'trending_products'         => $this->admin_product_model->trending_products(),
            'low_stock_products'        => $low_stock_products,
            'total_orders'              => $order_financials->total_orders
        ];

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header')
            . view('admin/dashboard/dashboard')
            . view('admin/templates/footer');
    }
}