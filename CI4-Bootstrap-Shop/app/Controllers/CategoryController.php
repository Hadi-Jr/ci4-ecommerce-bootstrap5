<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use Config\Database;

class CategoryController extends BaseController
{
    protected $db;
    protected $category_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->category_model = new CategoryModel($this->db);
    }

    public function view($slug)
    {
        $this->data += [
            'meta_data' => [
                'title' => 'Category Products'
            ]
        ];

        $products_count_per_page = 4;
        $page = $this->request->getGet('page') ?? 1;
        $sort = $this->request->getGet('sort') ?? '';
        $selected_filters = $this->request->getGet('filters') ?? '';

        if (!empty($selected_filters)) {
            $selected_filters = explode(',', $selected_filters);
        } else {
            $selected_filters = [];
        }

        $category = $this->category_model->get_category($slug);
        $result = $this->category_model->get_category_products($slug, $sort, $page, $selected_filters,
            $products_count_per_page);
        $category_banners = $this->category_model->get_category_banners($slug);
        $filters = $this->category_model->get_attributes_by_category($slug);

        $this->data += [
            'category' => $category,
            'category_products' => $result['products'],
            'total_products' => $result['total'],
            'slug' => $slug,
            'category_banners' => $category_banners,
            'filters' => $filters,
            'selected_filters' => $selected_filters,
            'current_sort' => $sort,
            'current_page' => $page,
            'total_pages' => ceil($result['total'] / $products_count_per_page)
        ];

        if ($this->request->isAJAX()) {
            return view('categories/_category_products', $this->data);
        } else {
            return view('templates/meta', $this->data)
                . view('templates/header', $this->data)
                . view('categories/category_products', $this->data)
                . view('templates/footer', $this->data);
        }
    }

}