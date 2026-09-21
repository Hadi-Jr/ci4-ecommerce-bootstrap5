<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\AdminProductModel;
use Config\Database;

class AdminProductController extends BaseController
{
    protected $db;
    protected $admin_product_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->admin_product_model = new AdminProductModel($this->db);
    }

    public function edit_combinations()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $rules = [
                'product_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Please choose a product'
                    ]
                ],
                'combinations' => [
                    'rules' => 'permit_empty',
                    'errors' => []
                ],
                'combinations.*.title' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.title' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.sku' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.price' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.promo' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.qty' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $files = $this->request->getFiles();
            $response = $this->admin_product_model->update_combinations($data, $files);
            if (!$response) {
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Something went wrong, please try again later'
                    ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product has been updated successfully'
            ]);
        }

        $product_id = $this->request->getGet('product_id');
        if ($product_id) {
            $product_combinations = $this->admin_product_model->get_product_combinations($product_id);
            return view('admin/products/_edit_combinations', [
                'product_combinations' => $product_combinations
            ]);
        }

        $this->data += [
            'products' =>$this->admin_product_model->get_all_products()
        ];

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header', $this->data)
            . view('admin/products/edit_combinations', $this->data)
            . view('admin/templates/footer', $this->data);
    }

    public function edit_attributes()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $rules = [
                'product_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Please choose a product'
                    ]
                ],
                'attribute_name.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required')
                    ]
                ],
                'attribute_value.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required')
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $response = $this->admin_product_model->update_attributes($data);
            if (!$response) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => [
                        'general-error' => 'Something went wrong, please try again later'
                    ]
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product has been updated successfully'
            ]);
        }

        $attribute_names = $this->admin_product_model->get_attributes_names();
        $product_id = $this->request->getGet('product_id');
        if ($product_id) {
            $product_attributes = $this->admin_product_model->get_product_attributes_details($product_id);
            return view('admin/products/_edit_attributes', [
                'product_attributes' => $product_attributes,
                'attribute_names' => $attribute_names
            ]);
        }

        $this->data += [
            'attributes' => $attribute_names,
            'products' =>$this->admin_product_model->get_all_products()
        ];

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header', $this->data)
            . view('admin/products/edit_attributes', $this->data)
            . view('admin/templates/footer', $this->data);
    }

    public function edit_specs()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $rules = [
                'product_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Please choose a product'
                    ]
                ],
                'feature_key.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required'),
                    ]
                ],
                'feature_value.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required'),
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $response = $this->admin_product_model->update_features($data);
            if (!$response) {
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                    'status' => 'error',
                    'message' => 'Something went wrong, please try again later'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product has been updated successfully'
            ]);
        }

        $product_id = $this->request->getGet('product_id');
        if ($product_id) {
            $features = $this->admin_product_model->get_features($product_id);
            return view('admin/products/_edit_specifications', ['features' => $features]);
        }

        $products = $this->admin_product_model->get_all_products();
        $this->data['products'] = $products ?? [];

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header', $this->data)
            . view('admin/products/edit_specifications', $this->data)
            . view('admin/templates/footer', $this->data);
    }

    public function edit_product_view($product_id)
    {
        $product = $this->admin_product_model->get_product($product_id);

        if (!$product) {
            return view('admin/templates/meta', $this->data)
                . view('admin/templates/header', $this->data)
                . view('404_page')
                . view('admin/templates/footer', $this->data);
        }

        $this->data['product'] = $product;

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header', $this->data)
            . view('admin/products/edit_product', $this->data)
            . view('admin/templates/footer', $this->data);
    }

    public function edit_product()
    {
        $data = $this->request->getPost();

        $rules = [
            'product_name' => [
                'rules' => "required|is_unique[products.name,id,{$data['product_id']}]",
                'errors' => [
                    'required' => lang('Errors.product_name_required'),
                    'is_unique' => lang('Errors.name_already_exists'),
                ]
            ],
            'sku' => [
                'rules' => "required|is_unique[products.sku,id,{$data['product_id']}]",
                'errors' => [
                    'required' => lang('Errors.sku_required'),
                    'is_unique' => lang('Errors.sku_already_exists')
                ]
            ],
            'barcode' => [
                'rules' => 'required|max_length[13]',
                'errors' => [
                    'required' => lang('Errors.barcode_required'),
                    'max_length' => lang('Errors.barcode_length')
                ]
            ],
            'price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.price_required')
                ]
            ],
            'promo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.promo_required')
                ]
            ],
            'quantity' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.quantity_required')
                ]
            ],
            'brand' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.brand_required')
                ]
            ],
            'long-description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.description_required')
                ]
            ],
            'category_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.category_required')
                ]
            ],
            'method-of-use' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.method_required')
                ]
            ],
            'short-description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Errors.short_required')
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'validation',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $response = $this->admin_product_model->edit_product($data);
        if (!$response) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'errors' => [
                    'general-error' => 'Something went wrong please try again later'
                ]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Product has been added updated'
        ]);
    }

    public function add_product()
    {
        $this->data += [
            'meta_data' => [
                'title' => 'Category Products'
            ]
        ];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'product_name' => [
                    'rules' => 'required|is_unique[products.name]',
                    'errors' => [
                        'required' => lang('Errors.product_name_required'),
                        'is_unique' => lang('Errors.name_already_exists'),
                    ]
                ],
                'sku' => [
                    'rules' => 'required|is_unique[products.sku]',
                    'errors' => [
                        'required' => lang('Errors.sku_required'),
                        'is_unique' => lang('Errors.sku_already_exists')
                    ]
                ],
                'barcode' => [
                    'rules' => 'required|max_length[13]',
                    'errors' => [
                        'required' => lang('Errors.barcode_required'),
                        'max_length' => lang('Errors.barcode_length')
                    ]
                ],
                'price' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.price_required')
                    ]
                ],
                'promo' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.promo_required')
                    ]
                ],
                'quantity' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.quantity_required')
                    ]
                ],
                'brand' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.brand_required')
                    ]
                ],
                'long-description' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.description_required')
                    ]
                ],
                'main_image' => [
                    'rules' => 'uploaded[main_image]|is_image[main_image]|mime_in[main_image,image/jpeg,image/png,image/webp]|ext_in[main_image,jpg,jpeg,png,webp]|max_size[main_image,10240]',
                    'errors' => [
                        'uploaded' => 'Please upload a main image.',
                        'is_image' => 'The main image must be a valid image.',
                        'mime_in' => 'Only JPG, JPEG, PNG, and WEBP images are allowed.',
                        'ext_in' => 'Only JPG, JPEG, PNG, and WEBP images are allowed.',
                        'max_size' => 'Image size cannot exceed 10MB.',
                    ]
                ],
                'feature_key.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required'),
                    ]
                ],
                'feature_value.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required'),
                    ]
                ],
                'attribute_name.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required')
                    ]
                ],
                'attribute_value.*' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.features_required')
                    ]
                ],
                'category_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.category_required')
                    ]
                ],
                'method-of-use' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.method_required')
                    ]
                ],
                'short-description' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.short_required')
                    ]
                ],
                'combinations' => [
                    'rules' => 'permit_empty',
                    'errors' => []
                ],
                'combinations.*.title' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.title' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.sku' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.price' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.promo' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
                'combinations.*.values.*.qty' => [
                    'rules' => 'required_with[combinations]',
                    'errors' => [
                        'required_with' => lang('Errors.combination_data_required')
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $product_data = $this->request->getPost();
            $files = $this->request->getFiles();

            $new_product = $this->admin_product_model->add_new_product($product_data, $files);
            if (!$new_product) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'errors' => [
                        'general-error' => lang('Errors.failed_to_add_product')
                    ]
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product has been added successfully'
            ]);
        }

        $this->data['attributes'] = $this->admin_product_model->get_attributes_names();

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header', $this->data)
            . view('admin/products/add_product', $this->data)
            . view('admin/templates/footer', $this->data);
    }

    public function get_attribute_values($attr_id)
    {
        $attribute_values = $this->admin_product_model->get_attribute_values($attr_id);
        if (!$attribute_values) {
            return '';
        }

        return view('/admin/products/templates/attribute_values', ['attribute_values' => $attribute_values]);
    }

    public function products_list()
    {
        $products_count_per_page = 15;
        $page = $this->request->getGet('page') ?? 1;
        $response_data = $this->admin_product_model->get_all_products($page, $products_count_per_page);

        $this->data += [
            'products'  => $response_data['products'],
            'total_products' => $response_data['total_products'],
            'total_pages' => ceil($response_data['total_products'] / $products_count_per_page),
            'current_page' => $page,
            'per_page' => $products_count_per_page
        ];

        return view('admin/templates/meta', $this->data)
            . view('admin/templates/header', $this->data)
            . view('admin/products/products_list', $this->data)
            . view('admin/templates/footer', $this->data);
    }

    public function change_product_status()
    {
        $post_data = $this->request->getPost();

        $this->admin_product_model->change_product_status($post_data['product_id']);

        return $this->response->setJSON([
            'status' => 'success',
        ]);
    }

    public function product_details($product_id)
    {
        $product_details = $this->admin_product_model->get_product_details($product_id);

        if (!$product_details) {
            return view('admin/templates/meta', $this->data)
                    . view('admin/templates/header', $this->data)
                    . view('404_page')
                    . view('admin/templates/footer', $this->data);
        }

        $this->data += [
            'product_data' => $product_details['product_data'],
            'features' => $product_details['features']
        ];

        return view('/admin/products/product_details', $this->data);
    }
}