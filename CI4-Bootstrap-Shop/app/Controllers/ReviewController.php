<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use Config\Database;

class ReviewController extends BaseController
{
    protected $db;
    protected $review_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->review_model = new ReviewModel($this->db);
    }

    public function submit_rating()
    {
        $post_data = $this->request->getPost();

        $result = $this->review_model->submit_rating($post_data);
        if (!$result) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You already have a feedback for this product'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Thank you for your feedback'
        ]);
    }


}