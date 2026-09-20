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
        $all_orders = $this->admin_orders_model->all_orders();

        $this->data['orders'] = $all_orders;

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
}