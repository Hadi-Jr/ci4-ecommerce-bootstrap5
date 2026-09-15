<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\AdminCategoryModel;
use Config\Database;

class AdminCategoryController extends BaseController
{
    protected $db;
    protected $admin_category_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->admin_category_model = new AdminCategoryModel($this->db);
    }

    public function view()
    {
        $all_categories = $this->admin_category_model->get_categories();

        $this->data['categories'] = $all_categories;

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header')
            . view('admin/categories/categories_view')
            . view('admin/templates/footer' );
    }
}