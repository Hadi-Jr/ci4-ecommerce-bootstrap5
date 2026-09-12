<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;
use Config\Database;

class ProductController extends BaseController
{
    protected $db;
    protected $product_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->product_model = new ProductModel($this->db);
    }

    public function view($slug)
    {
        $this->data += [
            'meta_data' => [
                'title' => 'Product'
            ]
        ];

        $product_details = $this->product_model->get_product_details($slug);

        $this->data += [
            'product' => $product_details['product'],
            'images' => $product_details['images'],
            'combinations' => $product_details['combinations'],
            'features' => $product_details['features'],
            'reviews' => $product_details['reviews'],
            'related_products' => $product_details['related_products']
        ];

        return view('templates/meta', $this->data)
            . view('templates/header')
            . view('products/product_details')
            . view('templates/footer');
    }

    public function promo_products()
    {
        $products_count_per_page = 24;
        $page = $this->request->getGet('page') ?? 1;
        $sort = $this->request->getGet('sort') ?? '';

        $result = $this->product_model->get_promo_products($sort, $page, $products_count_per_page);

        $this->data += [
            'promo_products' => $result['products'],
            'total_products' => $result['total'],
            'current_sort' => $sort,
            'current_page' => $page,
            'total_pages' => ceil($result['total'] / $products_count_per_page)
        ];

        if ($this->request->isAJAX()) {
            return view('products/_promotions', $this->data);
        } else {
            return view('templates/meta', $this->data)
                . view('templates/header')
                . view('products/promotions')
                . view('templates/footer');
        }
    }


}