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
}