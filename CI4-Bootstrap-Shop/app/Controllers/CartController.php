<?php

namespace App\Controllers;

use App\Models\CartModel;
use Config\Database;

class CartController extends BaseController
{
    protected $db;
    protected $cart_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->cart_model = new CartModel($this->db);
    }

    public function add_to_cart()
    {
        $post_data = $this->request->getPost();
        $user_id = $this->data['user_data']?->id;
        $session_id = session()->session_id;

        $saved = $this->cart_model->add_product_to_cart($post_data, $user_id, $session_id);
        if (!$saved) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error while adding product to cart'
            ]);
        }

        $items_count = $this->cart_model->get_items_count($user_id, $session_id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Item has been added successfully.',
            'items_count' => $items_count
        ]);
    }

    public function view()
    {
        $this->data += [
            'meta_data' => [
                'title' => 'My Cart'
            ]
        ];

        $sessionId = $this->session->session_id;
        $user_id = $this->data['user_data']?->id;
        $cart_data = $this->cart_model->get_cart_details($sessionId, $user_id);

        if (empty($cart_data['cart_items'])) {
            return view('templates/meta', $this->data)
                . view('templates/header', $this->data)
                . view('cart/empty_cart', $this->data)
                . view('templates/footer', $this->data);
        }

        $this->data += [
            'cart_items' => $cart_data['cart_items'],
            'subtotal' => $cart_data['subtotal'],
            'cart_id' => $cart_data['cart_id']
        ];

        return view('templates/meta', $this->data)
            . view('templates/header', $this->data)
            . view('cart/cart_view', $this->data)
            . view('templates/footer', $this->data);
    }

    public function delete_item()
    {
        $post_data = $this->request->getPost();

        $result = $this->cart_model->delete_item($post_data['item_id'], $post_data['cart_id']);
        if (isset($result['subtotal'])) {
            return $this->response->setJSON([
                'type' => $result['type'],
                'subtotal' => $result['subtotal']
            ]);
        } else {
            return $this->response->setJSON([
                'type' => $result['type']
            ]);
        }
    }

    public function update_quantity()
    {
        $post_data = $this->request->getPost();

        $result = $this->cart_model->update_cart_item_quantity($post_data['item_id'], $post_data['status']);
        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'new_item_subtotal' => $result['new_item_subtotal'],
                'new_subtotal' => $result['new_subtotal']
            ]);
        }
    }
}