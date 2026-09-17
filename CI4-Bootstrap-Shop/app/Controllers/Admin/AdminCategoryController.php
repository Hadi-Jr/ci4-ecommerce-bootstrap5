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

    public function add_category()
    {
        if ($this->request->getMethod() === 'POST') {
            $post_data = $this->request->getPost();

            $rules = [
                'category_name' => [
                    'rules' => 'required|is_unique[categories.name]',
                    'errors' => [
                        'required' => 'Please enter a category name',
                        'is_unique' => 'Category already exists',
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $response = $this->admin_category_model->add_category($post_data);
            if (!$response) {
                return $this->response
                    ->setStatusCode(500)->setJSON([
                        'status' => 'error',
                        'errors' => [
                            'general-error' => 'Something went wrong, please try again later'
                        ]
                    ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Category has been added successfully'
            ]);
        }

        $all_categories = $this->admin_category_model->get_categories();
        $this->data['all_categories'] = $all_categories;

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header')
            . view('admin/categories/add_category')
            . view('admin/templates/footer' );
    }

    public function change_category_status()
    {
        $post_data = $this->request->getPost();

        $this->admin_category_model->change_category_status($post_data['category_id']);

        return $this->response->setJSON([
            'status' => 'success',
        ]);
    }

    public function edit_category_view($category_id)
    {
        $category = $this->admin_category_model->get_category($category_id);

        $all_categories = $this->admin_category_model->get_categories();

        $this->data += [
            'category' => $category,
            'all_categories' => $all_categories
        ];

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header')
            . view('admin/categories/edit_category_view')
            . view('admin/templates/footer' );
    }

    public function edit_category()
    {
        $post_data = $this->request->getPost();

        $rules = [
            'category_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter a category name'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $response = $this->admin_category_model->update_category($post_data);
        if (!$response) {
            return $this->response
                ->setStatusCode(500)->setJSON([
                'status' => 'error',
                'errors' => [
                    'general-error' => 'Something went wrong, please try again later'
                ]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Category has been updated successfully'
        ]);
    }
}