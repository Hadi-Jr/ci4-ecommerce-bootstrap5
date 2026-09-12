<?php

namespace App\Controllers;

use Config\Database;

class Home extends BaseController
{

    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $this->data += [
            'meta_data' => []
        ];

        return view('/templates/meta', $this->data)
        . view('/templates/header', $this->data)
        . view('/home', $this->data)
        . view('/templates/footer', $this->data);
    }
}
