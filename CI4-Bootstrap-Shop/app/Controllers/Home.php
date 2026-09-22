<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Config\Database;

class Home extends BaseController
{
    protected $db;
    protected $product_model;
    protected $category_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->product_model = new ProductModel($this->db);
        $this->category_model  = new CategoryModel($this->db);
    }

    public function index()
    {
        $categories = $this->category_model->get_popular_categories();
        $trending_products = $this->product_model->trending_products();

        $this->data += [
            'child_categories'      => $categories,
            'trending_products'     => $trending_products
        ];

        return view('/templates/meta', $this->data)
            . view('/templates/header', $this->data)
            . view('/home', $this->data)
            . view('/templates/footer', $this->data);
    }

    public function search()
    {
        $search_query = $this->request->getGet('query') ?? '';

        $search_result = $this->product_model->search_products($search_query);

        if (!$search_result) {
            return view('/templates/meta', $this->data)
                . view('/templates/header', $this->data)
                . view('/no_results_found', $this->data)
                . view('/templates/footer', $this->data);
        }

        $this->data['products'] = $search_result;
        return view('/templates/meta', $this->data)
            . view('/templates/header', $this->data)
            . view('/search_results', $this->data)
            . view('/templates/footer', $this->data);
    }
}
