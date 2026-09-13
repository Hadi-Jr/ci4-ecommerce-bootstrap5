<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class ProductModel
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function get_product_details($slug)
    {
        $product = $this->db
            ->table('products')
            ->where('slug', $slug)
            ->get()
            ->getRow();

        if (!$product) {
            return false;
        }

        $images = $this->get_images($product->id);

        /*
         * $comb_map = [
                            9 => [
                                'comb_name' => 'Объем',
                                'combination_values' => [
                                    // 90 мл.
                                    // 240 мл.
                                ],
                            ],
                            10 => [
                                'comb_name' => 'Цвет',
                                'combination_values' => [
                                    // Красный
                                    // Черный
                                ],
                            ],
                        ];
         */
        $comb_map = $this->get_combinations($product->id);

        $features = $this->get_features($product->id);

        $reviews = $this->get_reviews($product->id);

        $related_products = $this->get_related_products($product->id);

        return [
            'product' => $product,
            'images' => $images,
            'combinations' => $comb_map,
            'features' => $features,
            'reviews' => $reviews,
            'related_products' => $related_products
        ];
    }

    public function get_reviews($product_id)
    {
        $reviews = $this->db->table('reviews')
            ->where('product_id', $product_id)
            ->get()
            ->getResult();

        $overall_rating = 0;
        if (count($reviews) > 0) {
            foreach ($reviews as $review) {
                $overall_rating += $review->rating;
            }
            $overall_rating /= count($reviews);
        }

        return [
            'reviews_data' => $reviews,
            'overall_rating' => $overall_rating,
            'reviews_count' => count($reviews)
        ];
    }

    public function get_combinations($product_id)
    {
        $comb_map = [];
        $combinations = $this->db
            ->table('product_combination_name pcn')
            ->select('pcn.title as comb_name, 
                    pcn.comb_type,
                    pcv.title as comb_value, 
                    pcv.comb_sku, 
                    pcv.comb_price, 
                    pcv.comb_promo, 
                    pcv.comb_name_id, 
                    pcv.comb_qty,
                    pcv.image_url,
                    pcv.id as comb_value_id')
            ->join('product_combination_value pcv', 'pcn.id = pcv.comb_name_id')
            ->where('product_id', $product_id)
            ->where('pcv.is_active', 1)
            ->where('pcn.is_active', 1)
            ->get()
            ->getResult();

        if (!$combinations) {
            return [];
        }

        foreach ($combinations as $combination) {
            $comb_map[$combination->comb_name_id]['comb_name'] = $combination->comb_name;
            $comb_map[$combination->comb_name_id]['comb_type'] = $combination->comb_type;
            $comb_map[$combination->comb_name_id]['combination_values'][] = $combination;
        }

        return $comb_map;
    }

    public function get_images($product_id)
    {
        $images = $this->db
            ->table('images')
            ->where('product_id', $product_id)
            ->get()
            ->getResult();

        if (!$images) {
            return [];
        }

        return $images;
    }

    public function get_features($product_id)
    {
        $features = $this->db
            ->table('features')
            ->where('product_id', $product_id)
            ->get()
            ->getResult();

        if (!$features) {
            return [];
        }

        return $features;
    }

    public function get_related_products($product_id)
    {
        $viewed_product = $this->db->table('products')
            ->where('id', $product_id)
            ->get()
            ->getRow();

        $related_products = $this->get_products_by_attributes($viewed_product->id);
        if (!$related_products) {
            return [];
        }

        return $related_products;
    }

    public function find_products_by_brand($brand, $product_id)
    {
        return $this->db
            ->table('products p')
            ->select('p.id, p.name, p.price, p.promo, p.slug, i.image_url')
            ->join('images i', 'i.product_id = p.id')
            ->where('p.brand', $brand)
            ->where('p.status', 1)
            ->where('p.id !=', $product_id)
            ->like('i.image_url', 'main-image')
            ->limit(12)
            ->get()
            ->getResult();
    }

    public function get_products_by_attributes($product_id)
    {
        $sub_query = $this->db->table('product_attribute_values')
            ->select('attribute_value_id')
            ->where('product_id', $product_id);

        return $this->db->table('product_attribute_values atv2')
            ->select('atv2.product_id, 
                            p.id, 
                            p.name, 
                            p.price, 
                            p.promo, 
                            p.slug,
                            p.stock_quantity,
                            i.image_url')
            ->distinct()
            ->join('products p', 'p.id = atv2.product_id')
            ->join('images i', 'i.product_id = p.id')
            ->where('p.id !=', $product_id)
            ->whereIn('atv2.attribute_value_id', $sub_query)
            ->where('p.status', 1)
            ->like('i.image_url', 'main-image')
            ->limit(12)
            ->get()
            ->getResult();
    }

    public function get_price_by_id($product_id)
    {
        $product = $this->db->table('products')
            ->where('id', $product_id)
            ->get()
            ->getRow();

        if ($product->promo > 0) {
            $unit_price = $product->promo;
        } else {
            $unit_price = $product->price;
        }

        return $unit_price;
    }

    /**
     * @param $product_id
     * @return string|null
     * It gets the comb value id depending on the lowest comb price when the user adds a product
     * directly from the category products page or from the related products list
     */
    public function get_comb_value_id($product_id)
    {
        $sub_query = $this->db
            ->table('product_combination_value v1')
            ->selectMin('v1.comb_price')
            ->where('v1.comb_name_id = n.id', null, false)
            ->getCompiledSelect();

        return $this->db
            ->table('product_combination_name n')
            ->select('v.id as comb_value_id')
            ->join('product_combination_value v', 'n.id = v.comb_name_id', 'left')
            ->where('v.comb_price = (' . $sub_query . ')', null, false)
            ->where('n.product_id', $product_id)
            ->get()
            ->getRow('comb_value_id');
    }

    public function get_combination_price($comb_value_id)
    {
        $comb_value = $this->db->table('product_combination_value')
            ->select('comb_price, comb_promo')
            ->where('id', $comb_value_id)
            ->get()
            ->getRow();

        if ($comb_value->comb_promo > 0) {
            $unit_price = $comb_value->comb_promo;
        } else {
            $unit_price = $comb_value->comb_price;
        }

        return $unit_price;
    }

    public function update_stock_for_order($cart_items)
    {
        $product_ids = [];
        $comb_ids = [];
        $product_case = "CASE id";
        $comb_case = "CASE id";
        $sold_case = "CASE id";

        foreach ($cart_items as $cart_item) {
            $product_ids[] = $cart_item->product_id;
            $product_case .= " WHEN {$cart_item->product_id} THEN stock_quantity - {$cart_item->quantity}";
            $sold_case .= " WHEN {$cart_item->product_id} THEN total_units_sold + {$cart_item->quantity}";

            if ($cart_item->comb_value_id !== null) {
                $comb_ids[] = $cart_item->comb_value_id;
                $comb_case .= " WHEN {$cart_item->comb_value_id} THEN comb_qty - {$cart_item->quantity}";
            }
        }

        $product_case .= " END";
        $comb_case .= " END";
        $sold_case .= " END";

        $this->db->table('products')
            ->set('stock_quantity', $product_case, false)
            ->set('total_units_sold', $sold_case, false)
            ->whereIn('id', $product_ids)
            ->update();

        if (!empty($comb_ids)) {
            $this->db->table('product_combination_value')
                ->set('comb_qty', $comb_case, false)
                ->whereIn('id', $comb_ids)
                ->update();
        }
    }

    public function get_promo_products($sort=null, $page=1, $products_count_per_page=12)
    {
        $builder = $this->db
            ->table('products p')
            ->select('p.id, p.name, p.price, p.promo, p.slug, i.image_url')
            ->join('images i', 'i.product_id = p.id')
            ->where('p.promo >', 0)
            ->where('p.status', 1)
            ->like('i.image_url', 'main-image');

        if ($sort) {
            $split = explode('_', $sort);
            $builder->orderBy($split[0], $split[1]);
        }

        $total = $builder->countAllResults(false);

        $offset = ($page - 1) * $products_count_per_page;
        $builder->limit($products_count_per_page, $offset);

        $products = $builder->get()->getResult();
        return [
            'products' => $products,
            'total' => $total
        ];
    }
}