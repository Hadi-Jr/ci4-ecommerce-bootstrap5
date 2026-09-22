<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class CategoryModel
{
    protected $db;

    public function __construct(ConnectionInterface $db_connection)
    {
        $this->db = $db_connection;
    }

    public function get_all_Categories()
    {
        return $this->db
            ->table('categories')
            ->select('id, name, slug, parent_id')
            ->where('is_active', true)
            ->get()
            ->getResult();
    }

    public function get_nested_categories($categories, $parent_id=null)
    {
        $nested_categories = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parent_id) {
                $children = $this->get_nested_categories($categories, $category->id);

                if ($children) {
                    $category->children = $children;
                } else {
                    $category->children = [];
                }

                $nested_categories[] = $category;
            }
        }

        return $nested_categories;
    }

    public function get_category_products($slug, $sort = null, $page = 1, $filters = [], $per_page = 4)
    {
        if (empty($slug)) {
            return [];
        }

        $builder = $this->db
            ->table('products p')
            ->select('p.id, p.name, p.price, p.promo, p.slug, i.image_url')
            ->join('categories c', 'c.id = p.category_id')
            ->join('images i', 'i.product_id = p.id')
            ->where('c.slug', $slug)
            ->where('p.status', 1)
            ->like('i.image_url', 'main-image');

        if ($sort) {
            $split = explode('_', $sort);
            $builder->orderBy($split[0], $split[1]);
        }

        if ($filters) {
            $attribute_values = $this->db
                ->table('attribute_value')
                ->select('id, attribute_id')
                ->whereIn('id', $filters)
                ->get()
                ->getResultArray();

            $grouped_filters = [];

            foreach ($attribute_values as $attribute_value) {
                $grouped_filters[$attribute_value['attribute_id']][] = $attribute_value['id'];
            }

            foreach ($grouped_filters as $attribute_value_ids) {
                $product_ids = $this->db
                    ->table('product_attribute_values')
                    ->select('product_id')
                    ->whereIn('attribute_value_id', $attribute_value_ids)
                    ->get()
                    ->getResultArray();

                $builder->whereIn('p.id', array_column($product_ids, 'product_id'));
            }
        }

        $total = $builder->countAllResults(false);

        $offset = ($page - 1) * $per_page;
        $builder->limit($per_page, $offset);

        $products = $builder->get()->getResult();
        return [
            'products' => $products,
            'total' => $total
        ];
    }

    public function get_category_banners($slug)
    {
        return $this->db
            ->table('category_image ci')
            ->select('ci.*')
            ->join('categories c', 'c.id = ci.category_id')
            ->where('c.slug', $slug)
            ->get()
            ->getResult();
    }

    public function get_category($slug)
    {
        return $this->db
            ->table('categories')
            ->select('name, slug')
            ->where('slug', $slug)
            ->get()
            ->getRow();
    }

    public function get_attributes_by_category($slug)
    {
        $attributes_data = $this->db->table('categories c')
            ->select('attr_v.*, attr_n.name, attr_n.type')
            ->join('products p', 'p.category_id = c.id')
            ->join('product_attribute_values atv', 'atv.product_id = p.id')
            ->join('attribute_value attr_v', 'atv.attribute_value_id = attr_v.id')
            ->join('attributes attr_n', 'attr_v.attribute_id = attr_n.id')
            ->where('c.slug', $slug)
            ->where('p.status', 1)
            ->get()
            ->getResult();

        /*
         * [
                'Product Type' => [
                    'values' => [
                        'Tablets' => 3
                    ]
                ],
                'Brand' => [
                    'values' => [
                        'Sisley' => 4
                    ]
                ]
           ]
         */
        $attr_map = [];
        foreach ($attributes_data as $data) {
            $attr_map[$data->name]['values'][$data->value] = $data->id;
        }

        return $attr_map;
    }

    public function get_popular_categories()
    {
        return $this->db->table('categories c')
            ->select('c.name as cat_name,
                            c.slug as cat_slug,
                            count(p.id) as product_count,
                            sum(p.total_units_sold) as total_units_sold')
            ->join('products p', 'p.category_id = c.id', 'left')
            ->where('c.parent_id is not null')
            ->where('is_active', 1)
            ->groupBy('c.id')
            ->having('total_units_sold >=', 0) // temporary 0 for testing purposes
            ->get()
            ->getResult();
    }
}