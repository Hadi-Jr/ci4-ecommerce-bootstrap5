<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\MetaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

     protected $session;
     protected $data;
     protected $default_meta_data;
     protected $category_tree;

     //Models
     protected $category_model;
     protected $meta_model;
     protected $cart_model;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = ['form', 'url', 'array', 'base', 'seo', 'text'];

        parent::initController($request, $response, $logger);

        //DB Connection for BaseController only
        $db = Database::connect();

        //Session
        $this->session = service('session');
        $session_id = $this->session->session_id;

        //User data
        $user_data = $this->session->get('user_data');

        //Locale
        $locale = $this->session->get('locale');
        if ($locale) {
            $this->request->setLocale($locale);
        } else {
            $this->session->set('locale', config('app')->defaultLocale);
        }

        //Meta Data
        $this->meta_model = new MetaModel($db);
        $this->default_meta_data = $this->meta_model->get_meta_data();

        //Categories
        $this->category_model = new CategoryModel($db);

//        $cache = cache();
//        $all_categories = $cache->get('all_categories');
//        if ($all_categories === null) {
//            $all_categories = $this->category_model->get_all_Categories();
//            $cache->save('all_categories', $all_categories, 3600);
//        }

        $all_categories = $this->category_model->get_all_Categories();

        $this->category_tree = $this->category_model->get_nested_categories($all_categories);

        //Cart items count
        $this->cart_model = new CartModel($db);
        $cart_items_count = $this->cart_model->get_items_count($user_data?->id, $session_id);

        //Building Base Data
        $this->data = [
            'user_data' => $user_data,
            'default_meta_data' => $this->default_meta_data,
            'categories' => $this->category_tree,
            'cart_items_count' => $cart_items_count
        ];
    }
}
