<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class CartModel
{
    protected $db;
    protected $product_model;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
        $this->product_model = new ProductModel($this->db);
    }

    public function add_product_to_cart($post_data, $user_id, $session_id)
    {
        $this->db->transStart();

        $product_id = $post_data['product_id'];

        if ($post_data['quick_add'] === "true") {
            $quantity = 1;
            $comb_value_id = $this->product_model->get_comb_value_id($product_id) ?: null;
        } else {
            $quantity = $post_data['quantity'];
            $comb_value_id = $post_data['comb_value_id'] ? $post_data['comb_value_id'] : null;
        }

        if ($comb_value_id !== null) {
            $unit_price = $this->product_model->get_combination_price($comb_value_id);
        } else {
            $unit_price = $this->product_model->get_price_by_id($product_id);
        }

        $sub_total = $unit_price * $quantity;

        $cart_id = $this->create_new_cart($session_id, $user_id);
        $this->add_item_to_cart($cart_id, $product_id, $sub_total, $quantity, $unit_price, $comb_value_id);

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function get_cart_details($session_id=null, $user_id=null)
    {
        $builder = $this->db->table('carts c')
            ->select('c.id as cart_id,
                              ci.id as item_id,
                              ci.product_id, 
                              ci.quantity, 
                              ci.cart_id, 
                              ci.unit_price, 
                              ci.subtotal, 
                              ci.comb_value_id, 
                              p.name,
                              p.price,
                              p.promo,
                              p.stock_quantity,
                              p.slug,
                              pcv.id as comb_value_id,
                              pcv.title,
                              pcv.comb_price,
                              pcv.comb_promo,
                              pcv.comb_qty,
                              pcv.image_url as comb_image,
                              im.image_url as main_image')
            ->join('cart_item ci', 'ci.cart_id = c.id')
            ->join('products p', 'ci.product_id = p.id')
            ->join('product_combination_value pcv', 'ci.comb_value_id = pcv.id', 'left')
            ->join('images im', 'p.id = im.product_id')
            ->like('im.image_url', 'main-image')
            ->where('c.status', 1);

        if ($user_id !== null) {
            $builder->where('user_id', $user_id);
        } else {
            $builder->where('session_id', $session_id);
        }

        $cart_details = $builder->get()->getResult();
        if (!$cart_details) {
            return [];
        }

        $subtotal = 0.0;
        foreach ($cart_details as $cart_detail) {
            $subtotal+= $cart_detail->subtotal;
        }

        return [
            'cart_items' => $cart_details,
            'subtotal' => $subtotal,
            'cart_id'  => $cart_details[0]->cart_id,
        ];
    }


    /**
     * @deprecated Use get_cart_details() instead.
     */
    public function get_cart_items($cart_id)
    {
        $cart_items = $this->db->table('cart_item ci')
            ->select('ci.id as item_id,
                              ci.product_id, 
                              ci.quantity, 
                              ci.cart_id, 
                              ci.unit_price, 
                              ci.subtotal, 
                              ci.comb_value_id, 
                              p.name,
                              p.price,
                              p.promo,
                              p.stock_quantity,
                              p.slug,
                              pcv.id as comb_value_id,
                              pcv.title,
                              pcv.comb_price,
                              pcv.comb_promo,
                              pcv.comb_qty,
                              pcv.image_url as comb_image,
                              im.image_url as main_image')
            ->join('products p', 'ci.product_id = p.id')
            ->join('product_combination_value pcv', 'ci.comb_value_id = pcv.id', 'left')
            ->join('images im', 'p.id = im.product_id')
            ->like('im.image_url', 'main-image')
            ->where('ci.cart_id', $cart_id)
            ->get()
            ->getResult();

        $subtotal = 0.0;
        foreach ($cart_items as $cart_item) {
            $subtotal+=  $cart_item->subtotal;
        }

        return [
            'cart_items' => $cart_items,
            'subtotal' => $subtotal
        ];
    }

    public function get_items_count($user_id, $session_id)
    {
        if ($user_id == null) {
            return $this->db->table('carts c')
                ->join('cart_item ci', 'ci.cart_id = c.id')
                ->where('c.session_id', $session_id)
                ->where('c.status', 1)
                ->countAllResults();
        }

        return $this->db->table('carts c')
            ->join('cart_item ci', 'ci.cart_id = c.id')
            ->where('c.user_id', $user_id)
            ->where('c.status', 1)
            ->countAllResults();
    }

    public function update_cart_item_quantity($item_id, $status)
    {
        if ($status === 'increase') {
            $this->db->table('cart_item')
                ->where('id', $item_id)
                ->set('quantity', 'quantity + 1', false)
                ->set('subtotal', 'subtotal + unit_price', false)
                ->update();
        } else if ($status === 'decrease') {
            $this->db->table('cart_item')
                ->where('id', $item_id)
                ->set('quantity', 'quantity - 1', false)
                ->set('subtotal', 'subtotal - unit_price', false)
                ->update();
        }

        $cart_item = $this->db
            ->table('cart_item')
            ->select('cart_id, subtotal')
            ->where('id', $item_id)
            ->get()
            ->getRow();

        $new_subtotal = $this->db->table('cart_item')
            ->selectSum('subtotal')
            ->where('cart_id', $cart_item->cart_id)
            ->get()
            ->getRow('subtotal');

        return [
            'new_item_subtotal' => $cart_item->subtotal,
            'new_subtotal' => $new_subtotal
        ];
    }

    public function delete_item($item_id, $cart_id)
    {
        $this->db->table('cart_item')->where('id', $item_id)->delete();

        $count_items = $this->db
            ->table('cart_item')
            ->where('cart_id', $cart_id)
            ->countAllResults();

        if ($count_items === 0) {
            $this->db->table('carts')->update([
                'status' => 0
            ]);
            return [
                'type' => 'count'
            ];
        }

        $subtotal = $this->db->table('cart_item')
            ->selectSum('subtotal')
            ->where('cart_id', $cart_id)
            ->get()
            ->getRow('subtotal');

        return [
            'type' => 'deleted',
            'subtotal' => $subtotal
        ];
    }

    private function update_qty($product_id, $comb_value_id, $quantity)
    {
        $this->db->table('products')
            ->where('id', $product_id)
            ->decrement('stock_quantity', $quantity);

        if ($comb_value_id !== null) {
            $this->db->table('product_combination_value')
                ->where('id', $comb_value_id)
                ->decrement('comb_qty', $quantity);
        }
    }

    private function create_new_cart($session_id, $user_id)
    {
        $existing_cart = $this->get_cart($session_id, $user_id);
        if ($existing_cart) {
            return $existing_cart->id;
        }

        $data = [
            'session_id' => $session_id,
            'user_id' => $user_id
        ];

        $this->db->table('carts')->insert($data);
        return $this->db->insertID();
    }

    public function get_cart($session_id=null, $user_id=null)
    {
        if ($user_id !== null) {
            $existing_cart = $this->db->table('carts')
                ->where('user_id', $user_id)
                ->where('status', 1)
                ->get()
                ->getRow();
        } else {
            $existing_cart = $this->db->table('carts')
                ->where('session_id', $session_id)
                ->where('status', 1)
                ->get()
                ->getRow();
        }

        return $existing_cart;
    }

    public function update_cart_status($cart_id)
    {
        $this->db->table('carts')
            ->where('id', $cart_id)
            ->update([
                'status' => 0
            ]);
    }

    public function transfer_cart_items($session_id, $user_id, $cart)
    {
        $this->db->transStart();

        $cart_items = $this->db
            ->table('cart_item')
            ->select('id')
            ->where('cart_id', $cart->id)
            ->get()
            ->getResultArray();

        $item_ids = array_column($cart_items, 'id');

        if (count($item_ids) > 0) {
            $existing_cart = $this->get_cart($session_id, $user_id);

            if ($existing_cart !== null) {
                $this->db->table('cart_item')
                    ->whereIn('id', $item_ids)
                    ->update([
                        'cart_id' => $existing_cart->id
                    ]);
            } else {
                $new_cart_id = $this->create_new_cart($session_id, $user_id);
                $this->db->table('cart_item')
                    ->whereIn('id', $item_ids)
                    ->update([
                        'cart_id' => $new_cart_id
                    ]);
            }

            $this->disable_guest_cart($cart->id);
        }

        $this->db->transComplete();
    }

    private function add_item_to_cart($cart_id, $product_id, $sub_total, $quantity, $unit_price, $comb_value_id)
    {
        if ($comb_value_id !== null) {
            $existing_item = $this->db->table('cart_item')
                ->where('cart_id', $cart_id)
                ->where('comb_value_id', $comb_value_id)
                ->get()->getRow();
        } else {
            $existing_item = $this->db->table('cart_item')
                ->where('cart_id', $cart_id)
                ->where('product_id', $product_id)
                ->get()->getRow();
        }

        if ($existing_item) {
            $this->db->table('cart_item')
                ->where('id', $existing_item->id)
                ->update([
                'quantity' => $existing_item->quantity + $quantity,
                'subtotal' => $existing_item->subtotal + $sub_total
            ]);
        } else {
            $this->db->table('cart_item')
                ->insert([
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'cart_id' => $cart_id,
                    'unit_price' => $unit_price,
                    'subtotal' => $sub_total,
                    'comb_value_id' => $comb_value_id
                ]);
        }
    }

    public function disable_guest_cart($cart_id)
    {
        $this->db->table('carts')
            ->where('id', $cart_id)
            ->update([
                'status' => 0
            ]);
    }

}