<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\AdminOrderModel;
use Config\Database;

class AdminOrdersController extends BaseController
{
    protected $db;
    protected $admin_orders_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->admin_orders_model = new AdminOrderModel($this->db);
    }

    public function view()
    {
        $orders_count_per_page = 15;
        $page = $this->request->getGet('page') ?? 1;

        $response_data = $this->admin_orders_model->all_orders($page, $orders_count_per_page);

        $this->data += [
            'orders'        => $response_data['orders'],
            'total_orders'  => $response_data['total_orders'],
            'total_pages'   => ceil($response_data['total_orders'] / $orders_count_per_page),
            'current_page'  => $page,
            'per_page'      => $orders_count_per_page
        ];

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header')
            . view('admin/orders/orders_list')
            . view('admin/templates/footer');
    }

    public function change_status()
    {
        $post_data = $this->request->getPost();

        $response = $this->admin_orders_model->change_status($post_data['order_id'], $post_data['status']);

        if (!$response) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Something went wrong, please try again later'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Order has been changed successfully'
        ]);
    }

    public function order_details($order_id)
    {
        $order_details = $this->admin_orders_model->get_order_details($order_id);

        $response_data = [
            'shipping_address' => $order_details['shipping_address'],
            'products' => $order_details['products']
        ];

        return view('/admin/orders/order_details', $response_data);
    }
}