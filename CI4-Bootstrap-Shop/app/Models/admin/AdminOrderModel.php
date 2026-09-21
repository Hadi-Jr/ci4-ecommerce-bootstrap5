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

    public function all_orders($page = 1, $orders_count_per_page = 2)
    {
        $offset = ($page - 1) * $orders_count_per_page;

        $builder = $this->db->table('orders');

        $total_count = $builder->countAllResults(false);

        $orders = $builder->limit($orders_count_per_page, $offset)
            ->get()->getResult();

        return [
            'orders' => $orders,
            'total_orders' => $total_count
        ];
    }

    public function change_status($order_id, $status)
    {
        return $this->db->table('orders')
            ->where('id', $order_id)
            ->update([
                'status' => $status
            ]);
    }

    public function get_order_details($order_id)
    {
        $data = $this->db->table('orders o')
            ->select('p.name as product_name,
                              p.id as product_id,
                              p.slug,
                              p.sku,
                              ci.quantity,
                              ci.subtotal,
                              ci.unit_price,
                              i.image_url as main_image,
                              si.street,
                              si.country,
                              si.state,
                              si.zip_code,
                              si.city')
            ->join('cart_item ci', 'ci.cart_id = o.cart_id')
            ->join('products p', 'ci.product_id = p.id')
            ->join('images i', "i.product_id = p.id and i.image_url like '%main-image.%'")
            ->join('shipping_address si', 'si.order_id = o.id')
            ->where('o.id', $order_id)
            ->get()
            ->getResult();

        $details_map = [];
        foreach ($data as $datum) {
            if (!isset($details_map['shipping_address'])) {
                $details_map['shipping_address'] = [
                    'city'      => $datum->city,
                    'zip_code'  => $datum->zip_code,
                    'state'     => $datum->state,
                    'country'   => $datum->country,
                    'street'    => $datum->street
                ];
            }

            $details_map['products'][$datum->product_id] = [
                'slug'          => $datum->slug,
                'sku'           => $datum->sku,
                'quantity'      => $datum->quantity,
                'subtotal'      => $datum->subtotal,
                'unit_price'    => $datum->unit_price,
                'image_url'     => $datum->main_image,
                'product_name'  => $datum->product_name
            ];
        }

        return $details_map;
    }
}