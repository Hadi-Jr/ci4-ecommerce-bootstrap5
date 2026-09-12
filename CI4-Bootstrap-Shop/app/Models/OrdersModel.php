<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class OrdersModel
{
    protected $db;
    protected $cart_model;
    protected $product_model;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
        $this->cart_model = new CartModel($this->db);
        $this->product_model = new ProductModel($this->db);
    }

    public function place_order($post_data, $user_id)
    {
        $this->db->transStart();

        $sessionId = session()->session_id;
        $cart_details = $this->cart_model->get_cart_details($sessionId, $user_id);

        $order_date = date('Y-m-d');
        $delivery_date = date('Y-m-d', strtotime('+7 days'));
        $tracking_number = $this->generate_tracking_number();

        $order_data = [
            'full_name' => $post_data['full_name'],
            'email_address' => $post_data['email_address'],
            'phone_number' => $post_data['phone_number'],
            'tracking_number' => $tracking_number,
            'notes' => $post_data['notes'],
            'cart_id' => $cart_details['cart_id'],
            'payment_method' => $post_data['payment-method'],
            'total_amount' => $cart_details['subtotal'],
            'user_id' => $user_id,
            'session_id' => $sessionId,
            'delivery_time' => $delivery_date,
            'order_date' => $order_date,
        ];

        $order_id = $this->save_order($order_data);

        $shipping_address_data = [
            'user_id' => $user_id,
            'session_id' => $sessionId,
            'order_id' => $order_id,
            'street' => $post_data['street'],
            'country' => $post_data['country'],
            'state' => $post_data['state'],
            'zip_code' => $post_data['zip_code'],
            'city' => $post_data['city']
        ];

        $this->db->table('shipping_address')->insert($shipping_address_data);

        $this->product_model->update_stock_for_order($cart_details['cart_items']);

        $this->cart_model->update_cart_status($cart_details['cart_id']);

        $this->db->transComplete();
        return [
            'status' => $this->db->transStatus(),
            'order_id' => $order_id
        ];
    }

    function generate_tracking_number()
    {
        $date = date('Ymd');
        $random_chars = strtoupper(bin2hex(random_bytes(4)));
        return "TRK-{$date}-{$random_chars}";
    }

    public function save_order($order_data)
    {
        $this->db->table('orders')->insert($order_data);
        return $this->db->insertID();
    }

    public function check_order($session_id, $user_id, $order_id)
    {
        $builder = $this->db->table('orders');

        if ($user_id !== null) {
            $builder->where('user_id', $user_id)
                ->where('id', $order_id);
        } else {
            $builder
                ->where('session_id', $session_id)
                ->where('id', $order_id);
        }

        return $builder->get()->getRow();
    }

    public function get_orders($session_id=null, $user_id=null, $tracking_number=null)
    {
        $builder = $this->db->table('orders o')
            ->select('o.id as order_id,
                              o.full_name, 
                              o.email_address, 
                              o.phone_number, 
                              o.payment_method, 
                              o.total_amount, 
                              o.notes,
                              o.status,
                              o.delivery_time,
                              o.delivered_at,
                              o.order_date,
                              p.slug,
                              p.id as product_id,
                              i.image_url as main_image')
            ->join('cart_item ci', 'ci.cart_id = o.cart_id')
            ->join('products p', 'ci.product_id = p.id')
            ->join('images i', "i.product_id = p.id and i.image_url like '%main-image.%'");

        if ($tracking_number !== null) {
            $builder->where('tracking_number', $tracking_number);
        } else {
            if ($user_id !== null) {
                $builder->where('user_id', $user_id);
            } else {
                $builder->where('session_id', $session_id);
            }
        }

        $result = $builder->get()->getResult();

        /*
         *         Response Data Example
        $o = [
            1(order_id) => [
                'order_data' => [
                    'full_name' => '',
                    'email_address' => '',
                ],
                'product_data' => [
                    1(product_id) => [
                        'slug' => '',
                        'image' => ''
                    ],
                    2(product_id) => [
                        'slug' => '',
                        'image' => ''
                    ]
                ]
            ],
            2(order_id) => [
                'order_data' => [
                    'full_name' => '',
                    'email_address' => '',
                ],
                'product_data' => [
                    1(product_id) => [
                        'slug' => '',
                        'image' => ''
                    ],
                    2(product_id) => [
                        'slug' => '',
                        'image' => ''
                    ]
                ]
            ],
        ];
         */
        $pending_count = 0;
        $delivered_count = 0;
        $cancelled_count = 0;
        $orders_map = [];
        foreach ($result as $data) {
            if (!isset($orders_map[$data->order_id])) {
                $orders_map[$data->order_id]['order_data'] = [
                    'full_name'         => $data->full_name,
                    'email_address'     => $data->email_address,
                    'phone_number'      => $data->phone_number,
                    'payment_method'    => $data->payment_method,
                    'total_amount'      => $data->total_amount,
                    'status'            => $data->status,
                    'delivery_time'     => $data->delivery_time,
                    'delivered_at'      => $data->delivered_at,
                    'order_date'        => $data->order_date
                ];

                if ($data->status === 'pending') {
                    $pending_count++;
                } else if ($data->status === 'delivered') {
                    $delivered_count++;
                } else {
                    $cancelled_count++;
                }
            }
            $orders_map[$data->order_id]['product_data'][$data->product_id] = [
                'slug' => $data->slug,
                'image' => $data->main_image
            ];
        }

        $overall_status = [
            'pending_count' => $pending_count,
            'delivered_count' => $delivered_count,
            'cancelled_count' => $cancelled_count
        ];

        return [
            'orders_map' => $orders_map,
            'overall_status' => $overall_status
        ];
    }

    public function get_order_details($session_id=null, $user_id=null, $order_id=null, $tracking_number=null)
    {
        $builder = $this->db->table('orders o')
            ->select('o.id as order_id,
                              o.full_name, 
                              o.email_address, 
                              o.phone_number, 
                              o.payment_method, 
                              o.total_amount, 
                              o.notes,
                              o.status,
                              o.delivery_time,
                              o.delivered_at,
                              o.order_date,
                              p.slug,
                              p.id as product_id,
                              p.name,
                              i.image_url as main_image,
                              ci.quantity,
                              ci.unit_price,
                              sa.street,
                              sa.country,
                              sa.state,
                              sa.zip_code,
                              sa.city')
            ->join('cart_item ci', 'ci.cart_id = o.cart_id')
            ->join('products p', 'ci.product_id = p.id')
            ->join('images i', "i.product_id = p.id and i.image_url like '%main-image.%'")
            ->join('shipping_address sa', 'sa.order_id = o.id');

        if ($tracking_number !== null) {
            $builder->where('o.tracking_number', $tracking_number);
        } else {
            if ($user_id !== null) {
                $builder->where('o.user_id', $user_id);
            } else {
                $builder->where('o.session_id', $session_id);
            }

            if ($order_id !== null) {
                $builder->where('o.id', $order_id);
            }
        }

        $order_details = $builder->get()->getResult();

        /*
         * $o = [
            'order_data' => [],
            'product_data' => [
                    1 => [
                        'slug' => '',
                        'image' => ''
                    ],
                    2 => [
                        'slug' => '',
                        'image' => ''
                    ]
                ]
            ];
         */
        $order_map = [];
        foreach ($order_details as $data) {
            if (!isset($order_map['order_data'])) {
                $order_map['order_data'] = [
                    'order_id'          => $data->order_id,
                    'full_name'         => $data->full_name,
                    'email_address'     => $data->email_address,
                    'phone_number'      => $data->phone_number,
                    'payment_method'    => $data->payment_method,
                    'total_amount'      => $data->total_amount,
                    'status'            => $data->status,
                    'delivery_time'     => $data->delivery_time,
                    'delivered_at'      => $data->delivered_at,
                    'order_date'        => $data->order_date,
                    'street'            => $data->street,
                    'country'           => $data->country,
                    'state'             => $data->state,
                    'zip_code'          => $data->zip_code,
                    'city'              => $data->city,
                ];
            }

            $order_map['product_data'][$data->product_id] = [
                'slug'      => $data->slug,
                'image'     => $data->main_image,
                'quantity'  => $data->quantity,
                'name'      => $data->name,
                'price'     => $data->unit_price
            ];
        }

        return $order_map;
    }

    public function disable_order($user_id, $order_id)
    {
        $result = $this->db->table('orders')->where('user_id', $user_id)
            ->where('id', $order_id)
            ->update(['status' => 'cancelled']);

        if (!$result) {
            return false;
        }

        return true;
    }


}