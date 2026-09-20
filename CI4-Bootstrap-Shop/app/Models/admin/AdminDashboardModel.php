<?php

namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;

class AdminDashboardModel
{
    protected $db;
    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }
}