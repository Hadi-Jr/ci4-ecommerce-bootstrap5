<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class MetaModel
{
    protected $db;

    public function __construct(ConnectionInterface $db_connection)
    {
        $this->db = $db_connection;
    }

    public function get_meta_data()
    {
        return $this->db->table('meta')
            ->select('key, value')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }

}