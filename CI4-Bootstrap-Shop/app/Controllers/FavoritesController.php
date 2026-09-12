<?php

namespace App\Controllers;

use App\Models\FavoritesModel;
use Config\Database;

class FavoritesController extends BaseController
{
    protected $db;
    protected $favorites_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->favorites_model = new FavoritesModel($this->db);
    }

    public function view()
    {
        $user_id = $this->data['user_data']?->id;
        $favorite_products = $this->favorites_model->get_favorites($user_id);

        if (!$favorite_products) {
            $view = view('favorites/empty_favorites');
        } else {
            $this->data['favorites'] = $favorite_products;
            $view = view('favorites/favorites_view', $this->data);
        }

        return view('templates/meta', $this->data)
            . view('templates/header')
            . $view
            . view('templates/footer');
    }

    public function add_favorite($product_id)
    {
        $user_id = $this->data['user_data']?->id;
        $result = $this->favorites_model->add_favorite($product_id, $user_id);

        return $this->response->setJSON([
            'status' => $result['status'],
            'message' => $result['message']
        ]);
    }

    public function remove_favorite()
    {
        $user_id = $this->data['user_data']?->id;
        $product_id = $this->request->getPost('product_id');

        $result = $this->favorites_model->remove_favorite($product_id, $user_id);

        return $this->response->setJSON([
            'status' => $result['status'],
            'message' => $result['message']
        ]);
    }
}