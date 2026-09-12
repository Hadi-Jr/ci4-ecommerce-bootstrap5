<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class FavoritesModel
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function get_favorites($user_id)
    {
        $favorites = $this->db->table('favorites f')
            ->select('p.id,
                            p.name,
                            p.price,
                            p.promo,
                            p.slug,
                            p.stock_quantity,
                            i.image_url')
            ->join('products p', 'p.id = f.product_id')
            ->join('images i', 'i.product_id = p.id')
            ->where('f.user_id', $user_id)
            ->like('i.image_url', 'main-image')
            ->get()
            ->getResult();

        if (!$favorites) {
            return [];
        }

        return $favorites;
    }

    public function add_favorite($product_id, $user_id)
    {
        $existing = $this->db->table('favorites')
            ->where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if ($existing) {
            return [
                'status' => 'existing_favorite',
                'message' => 'You have already favorited this product'
            ];
        }

        if (!$this->db->table('favorites')->insert([
            'user_id' => $user_id,
            'product_id' => $product_id
        ])) {
            return [
                'status' => 'database',
                'message' => 'Something went wrong, try again later'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'This item has been added to your favorites'
        ];
    }

    public function remove_favorite($product_id, $user_id)
    {
        if (!$this->db->table('favorites')
            ->where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->delete()) {
            return [
                'status' => 'database',
                'message' => 'Something went wrong, try again later'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Item has been removed from favorites!'
        ];
    }

}