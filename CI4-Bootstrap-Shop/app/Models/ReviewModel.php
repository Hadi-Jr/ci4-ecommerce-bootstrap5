<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class ReviewModel
{
    protected $db;
    public function __construct(ConnectionInterface &$db)
    {
        $this->db = $db;
    }

    public function submit_rating($post_data)
    {
        $rating_value = (int) $post_data['rating'];
        $feedback = $post_data['feedback'];
        $product_id = (int) $post_data['product_id'];
        $user_id = session()->get('user_data')?->id;
        $session_id = session()->session_id;

        $name = isset($post_data['name']) ? $post_data['name'] : 'anonymous';
        $email = isset($post_data['email']) ? $post_data['email'] : null;

        if ($user_id !== null) {
            $existing_rating = $this->db->table('reviews')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->get()
                ->getRow();
        } else {
            $existing_rating = $this->db->table('reviews')
                ->where('session_id', $session_id)
                ->where('product_id', $product_id)
                ->get()
                ->getRow();
        }

        if ($existing_rating) {
            return false;
        }

        $this->db->table('reviews')->insert(
            [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'feedback' => $feedback,
                'rating' => $rating_value,
                'session_id' => $session_id,
                'name' => $name,
                'email' => $email
            ]
        );

        return true;
    }

}