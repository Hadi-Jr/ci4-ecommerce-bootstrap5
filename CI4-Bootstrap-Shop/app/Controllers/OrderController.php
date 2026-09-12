<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\OrdersModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;

class OrderController extends BaseController
{
    protected $db;
    protected $orders_model;
    protected $cart_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->orders_model = new OrdersModel($this->db);
        $this->cart_model = new CartModel($this->db);
    }

    public function checkout()
    {
        $sessionId = $this->session->session_id;
        $user_id = $this->data['user_data']?->id;
        $cart_items = $this->cart_model->get_cart_details($sessionId, $user_id);

        $this->data += [
            'cart_items' => $cart_items['cart_items'],
            'subtotal' => $cart_items['subtotal']
        ];

        return view('templates/meta', $this->data)
            . view('templates/header')
            . view('orders/checkout')
            . view('templates/footer');
    }

    public function order_confirmation($order_id)
    {
        $session_id = $this->session->session_id;
        $user_id = $this->data['user_data']?->id;

        $order = $this->orders_model->check_order($session_id, $user_id, $order_id);

        if (!$order) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->data['order_id'] = $order_id;
        return view('templates/meta', $this->data)
            . view('templates/header')
            . view('orders/order_confirmation')
            . view('templates/footer');
    }

    public function place_order()
    {
        $post_data = $this->request->getPost();

        $user_id = $this->data['user_data']?->id;

        $rules = [
            'full_name' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'Full name is required',
                    'min_length' => 'Full name must be at least 2 characters',
                    'max_length' => 'Full name cannot exceed 100 characters'
                ]
            ],
            'email_address' => [
                'rules' => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required' => 'Email address is required',
                    'valid_email' => 'Please enter a valid email address'
                ]
            ],
            'phone_number' => [
                'rules' => 'required|min_length[7]|max_length[20]',
                'errors' => [
                    'required' => 'Phone number is required',
                    'min_length' => 'Phone number must be at least 7 characters',
                    'max_length' => 'Phone number cannot exceed 20 characters'
                ]
            ],
            'street' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Street address is required',
                    'min_length' => 'Street address must be at least 3 characters',
                    'max_length' => 'Street address cannot exceed 100 characters'
                ]
            ],
            'country' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'Country is required',
                    'min_length' => 'Country must be at least 2 characters',
                    'max_length' => 'Country cannot exceed 100 characters'
                ]
            ],
            'state' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'State/Province is required',
                    'min_length' => 'State must be at least 2 characters',
                    'max_length' => 'State cannot exceed 100 characters'
                ]
            ],
            'zip_code' => [
                'rules' => 'required|min_length[3]|max_length[20]',
                'errors' => [
                    'required' => 'ZIP/Postal code is required',
                    'min_length' => 'ZIP code must be at least 3 characters',
                    'max_length' => 'ZIP code cannot exceed 20 characters'
                ]
            ],
            'city' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'City is required',
                    'min_length' => 'City must be at least 2 characters',
                    'max_length' => 'City cannot exceed 100 characters'
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $response = $this->orders_model->place_order($post_data, $user_id);
        if (!$response['status']) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                'message' => 'Payment processing failed: Insufficient funds'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Your order has been placed successfully.',
            'order_id' => $response['order_id']
        ]);
    }

    public function get_orders()
    {
        $session_id = $this->session->session_id;
        $user_id = $this->data['user_data']?->id;

        $orders_data = $this->orders_model->get_orders($session_id , $user_id);

        $this->data += [
            'orders' => $orders_data['orders_map'],
            'overall_status' => $orders_data['overall_status']
        ];

        $view = view('templates/meta', $this->data)
              . view('templates/header');
        if (empty($orders_data['orders_map'])) {
            $view.= view('orders/no_orders');
        } else {
            $view.= view('orders/orders');
        }

        $view.= view('templates/footer');

        return $view;
    }

    public function order_details($order_id)
    {
        $session_id = $this->session->session_id;
        $user_id = $this->data['user_data']?->id;

        $order_details = $this->orders_model->get_order_details($session_id, $user_id, order_id: $order_id);

        $this->data['order_details'] = $order_details;

        return view('templates/meta', $this->data)
            . view('templates/header')
            . view('orders/order_details')
            . view('templates/footer');
    }

    public function order_details_by_tracking_nr($tracking_number)
    {
        $order_details = $this->orders_model->get_order_details(tracking_number: $tracking_number);

        $this->data['order_details'] = $order_details;

        return view('templates/meta', $this->data)
            . view('templates/header')
            . view('orders/order_details')
            . view('templates/footer');
    }

    public function get_order_by_tracking_nr($tracking_number)
    {
        $order_data = $this->orders_model->get_orders(tracking_number: $tracking_number);

        if (empty($order_data['orders_map'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'We couldn’t find an order associated with this tracking number.'
            ]);
        }

        $this->data += [
            'tracking_number' => $tracking_number,
            'orders' => $order_data['orders_map']
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'html' => view('/orders/order_search', $this->data)
        ]);
    }

    public function cancel_order()
    {
        $user_id = $this->data['user_data']?->id;

        $order_id = $this->request->getPost('order_id');

        $result = $this->orders_model->disable_order($user_id, $order_id);

        if (!$result) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unable to cancel your order. Please try again.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Your order has been cancelled successfully.'
        ]);
    }
}