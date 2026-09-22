<?php

namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;

class AdminProductModel
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function add_new_product($product_data, $files)
    {
        $this->db->transStart();

        // Saving product
        $data = [
            'name' => $product_data['product_name'],
            'description' => $product_data['long-description'],
            'price' => $product_data['price'],
            'promo' => $product_data['promo'],
            'stock_quantity' => $product_data['quantity'],
            'sku' => $product_data['sku'],
            'barcode' => $product_data['barcode'],
            'status' => $product_data['status'] === 'on' ? 1 : 0,
            'brand' => $product_data['brand'],
            'slug' => $product_data['slug'],
            'category_id' => $product_data['category_id'],
            'method_of_use' => $product_data['method-of-use'],
            'short_description' => $product_data['short-description']
        ];

        if (!$this->save_product($data)) {
            return false;
        };

        $product_id = $this->db->insertID();

        // Saving Features
        $feature_keys = $product_data['feature_key'];
        $feature_values = $product_data['feature_value'];
        $features = array_combine($feature_keys, $feature_values);

        if (!$this->save_features($features, $product_id)) {
            return false;
        }

        //Saving Combinations
//        $combinations = [
//            [
//                'title' => '',
//                'values' => [
//                    [
//                        'title' => '',
//                        'sku' => '',
//                        'price' => '',
//                        'promo' => '',
//                        'qty' => '',
//
//                    ]
//                ]
//            ],
//            [
//                'name' => '',
//                'values' => '...'
//            ]
//        ];
        $combinations = $product_data['combinations'] ?? [];
        if (!empty($combinations)) {
            if (!$this->save_combinations($combinations, $product_id, $files)) {
                log_message('error', 'Error saving combination');
                return false;
            }
        }

        // Saving Attributes
        $attribute_names = $product_data['attribute_name'];
        $attribute_values = $product_data['attribute_value'];
        $attributes = array_combine($attribute_names, $attribute_values);
        if (!empty($attributes)) {
            if (!$this->save_attributes($attributes, $product_id)) {
                log_message('error', 'Error saving attributes');
                return false;
            }
        }

        // Saving Images
        $folder_path = FCPATH . '/assets/images/products/' . $product_id . '/';
        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, true);
        }

        if (!$this->save_images($folder_path, $product_id, $files)) {
            $this->delete_directory($folder_path);
            return false;
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function get_attributes_names()
    {
        return $this->db
            ->table('attributes')
            ->get()
            ->getResult();
    }

    public function get_attribute_values($attr_id)
    {
        return $this->db->table('attribute_value')
            ->where('attribute_id', $attr_id)
            ->get()
            ->getResult();
    }

    public function get_products_sold()
    {
        return $this->db->table('products')
            ->selectSum('total_units_sold')
            ->get()
            ->getRow()
            ->total_units_sold;
    }

    public function low_stock_products()
    {
        return $this->db->table('products')
            ->select('id,
                            name,
                            stock_quantity,
                            slug,
                            total_units_sold,
                            sku')
            ->where('stock_quantity < ', 50)
            ->get()
            ->getResult();
    }

    public function trending_products()
    {
        return $this->db->table('products')
            ->select('id,
                            name, 
                            stock_quantity, 
                            slug, 
                            (total_units_sold * coalesce(nullif(promo, 0), price)) as total_sales, 
                            total_units_sold,
                            sku')
            ->where('total_units_sold >', 1)
            ->get()
            ->getResult();
    }

    public function save_combinations($combinations, $product_id, $files)
    {
        foreach ($combinations as $comb_name_index => $combination) {

            $comb_name_data = [
                'title' => $combination['title'],
                'product_id' => $product_id
            ];

            if (!$this->db->table('product_combination_name')->insert($comb_name_data)) {
                log_message('error', 'Error saving combination name');
                return false;
            }

            $comb_name_id = $this->db->insertId();
            $comb_values = $combination['values'];

            foreach ($comb_values as $comb_value_index => $comb_value) {

                $filename = '';
                $comb_image = $files['combinations'][$comb_name_index]['values'][$comb_value_index]['comb-image'];
                if ($comb_image && $comb_image->getError() !== UPLOAD_ERR_NO_FILE) {
                    $folder_path = FCPATH . '/assets/images/products/' . $product_id . '/comb-images/';
                    if (!is_dir($folder_path)) {
                        mkdir($folder_path, 0777, true);
                    }
                    if ($comb_image->isValid() && !$comb_image->hasMoved()) {

                        $filename = 'comb-image-' . $comb_value_index + 1 . '.' . $comb_image->getExtension();

                        if (!$comb_image->move($folder_path, $filename)) {
                            log_message('error', 'Error saving combination image');
                            return false;
                        }
                    } else {
                        log_message('error', 'Error saving combination image, not valid or has moved');
                        $this->delete_directory($folder_path);
                        return false;
                    }
                }

                $comb_value_data = [
                    'title' => $comb_value['title'],
                    'comb_name_id' => $comb_name_id,
                    'comb_sku' => $comb_value['sku'],
                    'comb_price' => $comb_value['price'],
                    'comb_promo' => $comb_value['promo'],
                    'comb_qty' => $comb_value['qty'],
                    'image_url' => ('/assets/images/products/' . $product_id . '/comb-images/' . $filename) ?? ''
                ];

                if (!$this->db->table('product_combination_value')->insert($comb_value_data)) {
                    log_message('error', 'Error saving combination value');
                    return false;
                }
            }
        }

        return true;
    }

    public function save_product($data)
    {
        if ($data['promo'] === $data['price']) {
            $data['promo'] = 0.0;
        }

        if (!$this->db->table('products')->insert($data)) {
            log_message('error', 'Error saving product');
            return false;
        }

        return true;
    }

    public function save_features($features, $product_id)
    {
        $processed_keys = [];
        foreach ($features as $key => $value) {
            $features_data = [
                'key' => trim($key),
                'value' => trim($value),
                'product_id' => $product_id
            ];

            if (in_array($key, $processed_keys)) {
                continue;
            }

            $processed_keys[] = $key;

            if (!$this->db->table('features')->insert($features_data)) {
                log_message('error', 'DB Error: ' . print_r($this->db->error(), true));
                return false;
            }
        }

        return true;
    }

    public function save_images($folder_path, $product_id, $files)
    {
        $main_image = $files['main_image'];
        if ($main_image->isValid() && !$main_image->hasMoved()) {
            $filename = 'main-image' . '.' . $main_image->getExtension();
            if (!$main_image->move($folder_path, $filename)) {
                return false;
            }

            $main_image_data = [
                'image_url' => '/assets/images/products/' . $product_id . DIRECTORY_SEPARATOR . $filename,
                'product_id' => $product_id
            ];

            if (!$this->db->table('images')->insert($main_image_data)) {
                log_message('error', 'Error saving main image');
                return false;
            }
        }

        if (!empty($files['images'])) {
            $img_counter = 1;

            foreach ($files['images'] as $image) {
                if ($image->getError() === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                if ($image->isValid() && !$image->hasMoved()) {
                    $filename = 'image-' . $img_counter . '.' . $image->getExtension();

                    if (!$image->move($folder_path, $filename)) {
                        return false;
                    }

                    $image_data = [
                        'image_url' => '/assets/images/products/' . $product_id . DIRECTORY_SEPARATOR . $filename,
                        'product_id' => $product_id
                    ];

                    if (!$this->db->table('images')->insert($image_data)) {
                        log_message('error', 'Error saving additional image');
                        return false;
                    }

                    $img_counter++;
                } else {
                    log_message('error', 'Invalid additional image file');
                    return false;
                }
            }
        }

        return true;
    }

    private function delete_directory($path)
    {
        if (!is_dir($path)) {
            return;
        }

        $files = array_diff(scandir($path), ['.', '..']);
        foreach ($files as $file) {
            $file_path = $path . DIRECTORY_SEPARATOR . $file;

            if (is_dir($file_path)) {
                $this->delete_directory($file_path);
            } else {
                unlink($file_path);
            }
        }

        rmdir($path);
    }

    private function save_attributes($attributes, $product_id)
    {
        $rows = [];
        foreach ($attributes as $attr_value_id) {
            $rows[] = [
                'product_id' => $product_id,
                'attribute_value_id' => $attr_value_id
            ];
        }

        if (!$this->db->table('product_attribute_values')->insertBatch($rows)) {
            log_message('error', 'Error saving attributes');
            return false;
        }

        return true;
    }

    public function get_all_products()
    {
        return $this->db->table('products')
            ->get()
            ->getResult();
    }

    public function get_all_products_per_page($page = 1, $products_count_per_page = 2)
    {
        $offset = ($page - 1) * $products_count_per_page;
        $builder = $this->db->table('products p')
            ->select('p.id, 
                            p.name, 
                            p.price, 
                            p.promo, 
                            p.stock_quantity, 
                            p.sku, 
                            p.status, 
                            p.slug, 
                            p.total_units_sold,
                            avg(r.rating) avg_rating')
            ->join('reviews r', 'r.product_id = p.id', 'left')
            ->groupBy('p.id');

        $total_count = $builder->countAllResults(false);

        $products = $builder
            ->limit($products_count_per_page, $offset)
            ->get()->getResult();

        return [
            'products' => $products,
            'total_products' => $total_count
        ];
    }

    public function change_product_status($product_id)
    {
        $product_status = $this->db->table('products')
            ->where('id', $product_id)
            ->get()
            ->getRow('status');

        $new_status = $product_status == 1 ? 0 : 1;

        $this->db->table('products')
            ->where('id', $product_id)
            ->update([
                'status' => $new_status
            ]);
    }

    public function get_product($product_id)
    {
        return $this->db->table('products')
            ->where('id', $product_id)
            ->get()
            ->getRow();
    }

    public function edit_product($data)
    {
        $response = $this->db->table('products')
            ->where('id', $data['product_id'])
            ->update([
                'name' => $data['product_name'],
                'description' => $data['long-description'],
                'price' => $data['price'],
                'promo' => $data['promo'],
                'stock_quantity' => $data['quantity'],
                'category_id' => $data['category_id'],
                'sku' => $data['sku'],
                'barcode' => $data['barcode'],
                'brand' => $data['brand'],
                'slug' => $data['slug'],
                'method_of_use' => $data['method-of-use'],
                'short_description' => $data['short-description'],
            ]);

        if (!$response) {
            return false;
        }

        return true;
    }

    public function get_features($product_id)
    {
        return $this->db->table('features')
            ->where('product_id', $product_id)
            ->get()
            ->getResult();
    }

    public function update_features($data)
    {
        $this->db->transStart();

        $product_id = $data['product_id'];

        $removed_feature_ids = $data['removed_feature_ids'] ?? [];
        if (!empty($removed_feature_ids)) {
            $this->remove_features($removed_feature_ids);
        }

        $update_existing_features = [];
        $new_features = [];

        $feature_keys = $data['feature_key'];
        $feature_values = $data['feature_value'];

        $features = array_combine($feature_keys, $feature_values);
        $saved_features = $this->get_features($product_id);

        foreach ($features as $key_feature => $value_feature) {
            $exists = false;
            foreach ($saved_features as $saved_feature) {
                if ($key_feature === $saved_feature->key) {
                    $exists = true;

                    $update_existing_features[] = [
                        'id' => $saved_feature->id,
                        'key' => $saved_feature->key,
                        'value' => $value_feature,
                        'product_id' => $product_id
                    ];

                    break;
                }
            }

            if (!$exists) {
                $new_features[] = [
                    'key' => $key_feature,
                    'value' => $value_feature,
                    'product_id' => $product_id
                ];
            }
        }

        if (!empty($update_existing_features)) {
            $this->db->table('features')->updateBatch($update_existing_features, 'id');
        }

        if (!empty($new_features)) {
            $this->db->table('features')->insertBatch($new_features);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function update_combinations($data, $files)
    {
        $this->db->transStart();

        $product_id = $data['product_id'];
        $removed_comb_name_ids = $data['removed_comb_name_ids'] ?? [];
        $removed_comb_value_ids = $data['removed_comb_value_ids'] ?? [];

        if (!empty($removed_comb_value_ids)) {
            $this->disable_comb_values($removed_comb_value_ids);
        }

        if (!empty($removed_comb_name_ids)) {
            $this->disable_comb_names($removed_comb_name_ids);
        }

        $new_combinations = $data['combinations'] ?? [];
        $old_combinations = $data['old_combinations'] ?? [];

        foreach ($new_combinations as $comb_name_id => $combination) {
            log_message('debug', 'Updating comb_name_id=' . $comb_name_id . ' with title=' . $combination['title']);

            if (isset($old_combinations[$comb_name_id])) {

                $this->db->table('product_combination_name')
                    ->where('id', $comb_name_id)
                    ->update([
                        'title' => $combination['title'],
                    ]);

                log_message('debug', 'Updating comb_name_id=' . $comb_name_id . ' with title=' . $combination['title']);

                $old_values = $old_combinations[$comb_name_id]['values'] ?? [];

                foreach ($combination['values'] as $comb_value_id => $comb_value) {

                    if (isset($old_values[$comb_value_id])) {
                        $comb_value_data = [
                            'comb_name_id' => $comb_name_id,
                            'title'        => $comb_value['title'],
                            'comb_sku'     => $comb_value['sku'],
                            'comb_price'   => $comb_value['price'],
                            'comb_promo'   => $comb_value['promo'] ?? 0,
                            'comb_qty'     => $comb_value['qty'],
                        ];

                        $this->update_comb_value($comb_value_id, $comb_value_data);
                    } else {
                        $filename = '';
                        $comb_image = $files['combinations'][$comb_name_id]['values'][$comb_value_id]['comb-image'];
                        if ($comb_image && $comb_image->getError() !== UPLOAD_ERR_NO_FILE) {
                            $folder_path = FCPATH . '/assets/images/products/' . $product_id . '/comb-images/';
                            if (!is_dir($folder_path)) {
                                mkdir($folder_path, 0777, true);
                            }
                            if ($comb_image->isValid() && !$comb_image->hasMoved()) {

                                $filename = 'comb-image-' . $comb_value_id + 1 . '.' . $comb_image->getExtension();

                                if (!$comb_image->move($folder_path, $filename)) {
                                    log_message('error', 'Error saving combination image');
                                }
                            } else {
                                log_message('error', 'Error saving combination image, not valid or has moved');
                                $this->delete_directory($folder_path);
                            }
                        }

                        $comb_value_data = [
                            'title' => $comb_value['title'],
                            'comb_name_id' => $comb_name_id,
                            'comb_sku' => $comb_value['sku'],
                            'comb_price' => $comb_value['price'],
                            'comb_promo' => $comb_value['promo'],
                            'comb_qty' => $comb_value['qty'],
                            'image_url' => ('/assets/images/products/' . $product_id . '/comb-images/' . $filename) ?? ''
                        ];

                        $this->db->table('product_combination_value')->insert($comb_value_data);
                    }
                }
            } else {
                $new_comb_name_id =
                    $this->add_new_comb_name($combination['title'], $product_id);

                foreach ($combination['values'] as $comb_value_id => $comb_value) {
                    $filename = '';
                    $comb_image = $files['combinations'][$comb_name_id]['values'][$comb_value_id]['comb-image'];
                    if ($comb_image && $comb_image->getError() !== UPLOAD_ERR_NO_FILE) {
                        $folder_path = FCPATH . '/assets/images/products/' . $product_id . '/comb-images/';
                        if (!is_dir($folder_path)) {
                            mkdir($folder_path, 0777, true);
                        }
                        if ($comb_image->isValid() && !$comb_image->hasMoved()) {

                            $filename = 'comb-image-' . $comb_value_id + 1 . '.' . $comb_image->getExtension();

                            if (!$comb_image->move($folder_path, $filename)) {
                                log_message('error', 'Error saving combination image');
                            }
                        } else {
                            log_message('error', 'Error saving combination image, not valid or has moved');
                            $this->delete_directory($folder_path);
                        }
                    }

                    $comb_value_data = [
                        'title' => $comb_value['title'],
                        'comb_name_id' => $new_comb_name_id,
                        'comb_sku' => $comb_value['sku'],
                        'comb_price' => $comb_value['price'],
                        'comb_promo' => $comb_value['promo'],
                        'comb_qty' => $comb_value['qty'],
                        'image_url' => ('/assets/images/products/' . $product_id . '/comb-images/' . $filename) ?? ''
                    ];

                    $this->db->table('product_combination_value')->insert($comb_value_data);
                }
            }
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function add_new_comb_name($comb_name_title, $product_id)
    {
        $this->db->table('product_combination_name')->insert([
            'title'      => $comb_name_title,
            'product_id' => $product_id
        ]);
        return $this->db->insertID();
    }

    public function update_comb_value($comb_value_id, $comb_value_data)
    {
        $this->db->table('product_combination_value')
            ->where('id', $comb_value_id)
            ->update($comb_value_data);
    }

    public function remove_features($feature_ids)
    {
        $this->db->table('features')
            ->whereIn('id', $feature_ids)
            ->delete();
    }

    public function get_product_attributes_details($product_id)
    {
        return $this->db->table('product_attribute_values pav')
            ->select('a.id as attribute_id,
                            a.name as attribute_name,
                            av.value as attribute_value,
                            av.id as attribute_value_id')
            ->join('attribute_value av', 'av.id = pav.attribute_value_id')
            ->join('attributes a', 'a.id = av.attribute_id')
            ->where('pav.product_id', $product_id)
            ->get()
            ->getResult();
    }

    public function product_attribute_values($product)
    {
        return $this->db->table('product_attribute_values')
            ->where('product_id', $product)
            ->get()
            ->getResult();
    }

    public function update_attributes($data)
    {
        $this->db->transStart();

        $product_id = $data['product_id'];

        $removed_attribute_value_ids = $data['removed_attribute_value_ids'] ?? [];
        if (!empty($removed_attribute_value_ids)) {
            $this->remove_attributes($removed_attribute_value_ids);
        }

        $attr_value_ids = $data['attribute_value'];
        $existing_value_ids = array_map(fn($attr) => $attr->attribute_value_id,
            $this->product_attribute_values($product_id));

        $new_value_ids = array_diff($attr_value_ids, $existing_value_ids);

        $new_attributes = [];
        foreach ($new_value_ids as $attr_value_id) {
            $new_attributes[] = [
                'product_id' => $product_id,
                'attribute_value_id' => $attr_value_id
            ];
        }

        if (!empty($new_attributes)) {
            $this->db->table('product_attribute_values')->insertBatch($new_attributes);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    private function remove_attributes($removed_attribute_ids)
    {
        $this->db->table('product_attribute_values')
            ->whereIn('attribute_value_id', $removed_attribute_ids)
            ->delete();
    }

    public function get_product_combinations($product_id)
    {
        $combinations = $this->db->table('product_combination_name pcn')
            ->select('pcn.id as comb_name_id,
                            pcn.title as comb_name_title,
                            pcv.id as comb_value_id,
                            pcv.title as comb_value_title,
                            pcv.comb_sku,
                            pcv.comb_price,
                            pcv.comb_promo,
                            pcv.comb_qty,
                            pcv.image_url')
            ->join('product_combination_value pcv', 'pcv.comb_name_id = pcn.id')
            ->where('pcn.product_id', $product_id)
            ->where('pcn.is_active', 1)
            ->where('pcv.is_active', 1)
            ->get()
            ->getResult();

        if (!$combinations) {
            return [];
        }

        //        $combinations_map = [
//            9 => [
//                'comb_name_title' => 'Обем',
//                'comb_values' => [
//                    0 => [
//                         'comb_value_id' => ''
//                    ],
//                ],
//            ],
//        ];
        $combinations_map = [];
        foreach ($combinations as $combination) {
            $combinations_map[$combination->comb_name_id]['comb_name_title'] = $combination->comb_name_title;
            $combinations_map[$combination->comb_name_id]['comb_values'][] = [
                'comb_value_id' => $combination->comb_value_id,
                'comb_value_title' => $combination->comb_value_title,
                'comb_sku' => $combination->comb_sku,
                'comb_price' => $combination->comb_price,
                'comb_promo' => $combination->comb_promo,
                'comb_qty' => $combination->comb_qty,
                'comb_image' => $combination->image_url
            ];
        }

        return $combinations_map;
    }

    private function disable_comb_names($removed_comb_name_ids)
    {
        $this->db->table('product_combination_name')
            ->whereIn('id', $removed_comb_name_ids)
            ->update([
                'is_active' => 0
            ]);

        $this->db->table('product_combination_value')
            ->whereIn('comb_name_id', $removed_comb_name_ids)
            ->update([
                'is_active' => 0
            ]);
    }

    private function disable_comb_values($removed_comb_value_ids)
    {
        $this->db->table('product_combination_value')
            ->whereIn('id', $removed_comb_value_ids)
            ->update([
                'is_active' => 0
            ]);
    }

    public function get_product_details($product_id)
    {
        $sub_query = $this->db->table('reviews r')
            ->select('avg(r.rating) as avg_rating')
            ->where('r.product_id', $product_id)
            ->getCompiledSelect();

        $result = $this->db->table('products p')
            ->select("
                    p.*,
                    im.image_url,
                    f.key,
                    f.value,
                    COALESCE(($sub_query), 0) AS avg_rating", false)
            ->join('images im', 'im.product_id = p.id')
            ->join('features f', 'f.product_id = p.id')
            ->like('im.image_url', 'main-image')
            ->where('p.id', $product_id)
            ->get()
            ->getResult();

        if (!$result) {
            return false;
        }

        $product_details_map = [];
        foreach ($result as $r) {
            if (!isset($product_details_map['product_data'])) {
                $product_details_map['product_data'] = [
                    'product_id'        => $r->id,
                    'name'              => $r->name,
                    'price'             => $r->price,
                    'promo'             => $r->promo,
                    'stock_quantity'    => $r->stock_quantity,
                    'sku'               => $r->sku,
                    'barcode'           => $r->barcode,
                    'status'            => $r->status,
                    'brand'             => $r->brand,
                    'slug'              => $r->slug,
                    'image'             => $r->image_url,
                    'avg_rating'        => $r->avg_rating
                ];
            }

            $product_details_map['features'][$r->key] = $r->value;
        }

        return [
            'product_data' => $product_details_map['product_data'],
            'features' => $product_details_map['features'],
        ];
    }

}