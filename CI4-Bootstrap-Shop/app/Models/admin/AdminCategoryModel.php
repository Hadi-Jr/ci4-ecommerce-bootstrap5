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
}