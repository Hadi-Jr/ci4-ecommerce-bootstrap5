<?php

namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;

class AdminCategoryModel
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function get_categories()
    {
        return $this->db->table('categories')
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResult();
    }

    public function change_category_status($category_id)
    {
        $category_status = $this->db->table('categories')
            ->where('id', $category_id)
            ->get()
            ->getRow('is_active');

        $new_status = $category_status == 1 ? 0 : 1;

        $this->db->table('categories')
            ->where('id', $category_id)
            ->update([
                'is_active' => $new_status
            ]);
    }

    public function get_category($category_id)
    {
        return $this->db->table('categories c1')
            ->select('c1.id category_id,
                            c1.parent_id,
                            c1.name,
                            c1.slug,
                            c1.is_active,
                            c2.name parent_name')
            ->join('categories c2', 'on c1.parent_id = c2.id', 'left')
            ->where('c1.id', $category_id)
            ->get()
            ->getRow();
    }

    public function update_category($post_data)
    {
        $this->db->transStart();

        $parent_id = $post_data['parent_id'] ?? null;
        $category_id = $post_data['category_id'];
        $category_name = $post_data['category_name'];
        $status = $post_data['status'] === 'on' ? 1 : 0;
        $slug = $post_data['slug'];
        $transfer_children = $post_data['transfer_children'];
        $parent_category_products = $this->get_category_products($parent_id);

        if (!empty($parent_category_products)) {
            $this->db->table('categories')
                ->insert([
                    'name' => 'Others',
                    'parent_id' => $parent_id,
                    'slug' => 'others-' . $parent_id
                ]);

            $others_cat_id = $this->db->insertID();
            $this->transfer_products_to_category($others_cat_id, $parent_category_products);
        }

        $child_ids = array_column($this->get_category_child($category_id), 'id');
        if ($parent_id) {
            if (in_array($parent_id, $child_ids)) {
                if ($transfer_children) {
                    $this->remove_parent([$category_id]);
                } else {
                    $this->remove_parent($child_ids);
                }
                $this->make_child_of($category_id, $parent_id);
            } else if ($child_ids && !$transfer_children) {
                $this->remove_parent($child_ids);
            }
        } else {
            if ($child_ids && !$transfer_children) {
                $this->remove_parent($child_ids);
            }
        }

        $this->db->table('categories')
            ->where('id', $category_id)
            ->update([
                'id' => $category_id,
                'name' => $category_name,
                'is_active' => $status,
                'parent_id' => $parent_id,
                'slug' => $slug
            ]);

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    public function make_child_of($old_parent_id, $new_parent_id)
    {
        $this->db->table('categories')
            ->where('id', $old_parent_id)
            ->update([
                'parent_id' => $new_parent_id
            ]);
    }

    public function get_category_child($category_id)
    {
        return $this->db->table('categories')
            ->select('id')
            ->where('parent_id', $category_id)
            ->get()
            ->getResultArray();
    }

    private function remove_parent($child_ids)
    {
        $data = [];
        foreach ($child_ids as $id) {
            $data[] = [
                'id' => $id,
                'parent_id' => null
            ];
        }

        if (!empty($data)) {
            $this->db->table('categories')->updateBatch($data, 'id');
        }
    }

    public function get_category_products($parent_id)
    {
        return $this->db->table('products')
            ->where('category_id', $parent_id)
            ->get()
            ->getResult();
    }

    public function transfer_products_to_category($category_id, $products)
    {
        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'category_id' => $category_id
            ];
        }

        $this->db->table('products')
            ->updateBatch($data, 'id');
    }
}