<?php

namespace App\Models\admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class AdminOrderModel extends BaseController
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function get_order_financials()
    {
        return $this->db->table('orders')
            ->select('avg(total_amount) as avg_order_value, sum(total_amount) as earnings')
            ->where('status', 'delivered')
            ->get()
            ->getRow();
    }

    public function canceled_orders_count()
    {
        return $this->db->table('orders')
            ->where('status', 'cancelled')
            ->countAllResults();
    }

    public function recent_orders()
    {
        return $this->db->table('orders')
            ->orderBy('order_date')
            ->limit(10)
            ->get()
            ->getResult();
    }

    public function all_orders()
    {
        return $this->db->table('orders')
            ->get()
            ->getResult();
    }

    public function change_status($order_id, $status)
    {
        return $this->db->table('orders')
            ->where('id', $order_id)
            ->update([
                'status' => $status
            ]);
    }
}