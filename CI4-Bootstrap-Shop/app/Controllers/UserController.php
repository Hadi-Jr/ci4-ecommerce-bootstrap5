<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\UserModel;
use Config\Database;

class UserController extends BaseController
{
    protected $db;
    protected $user_model;
    protected $cart_model;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->user_model = new UserModel($this->db);
        $this->cart_model = new CartModel($this->db);
    }

    public function register()
    {
        $this->data += [
            'meta_data' => [
                'title' => 'Sign Up'
            ]
        ];

        if ($this->request->getMethod() == 'POST') {
            $register_data = $this->request->getPost();

            $rules = [
                'email' => [
                    'rules' => 'required|min_length[6]|max_length[100]|valid_email',
                    'errors' => [
                        'required' => lang('Errors.email_required'),
                        'min_length' => lang('Errors.email_min_length'),
                        'valid_email' => lang('Errors.valid_email')
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.password_required'),
                        'min_length' => lang('Errors.password_min_length'),
                        'max_length' => lang('Errors.password_max_length')
                    ]
                ],
                'full_name' => [
                    'rules' => 'required|min_length[6]|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.full_name_required'),
                        'min_length' => lang('Errors.full_name_min_length')
                    ]
                ],
                'username' => [
                    'rules' => 'required|min_length[4]|max_length[50]',
                    'errors' => [
                        'required' => lang('Errors.username_required'),
                        'min_length' => lang('Errors.username_min_length')
                    ]
                ],
                'confirm_password' => [
                    'rules' => 'required|min_length[6]|max_length[100]|matches[password]',
                    'errors' => [
                        'required' => lang('Errors.confirm_password_required'),
                        'min_length' => lang('Errors.min_length'),
                        'max_length' => lang('Errors.max_length'),
                        'matches' => lang('Errors.confirm_password')
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $new_user = $this->user_model->register($register_data);

            if (!$new_user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => [
                        'email' => lang('Errors.user_already_exists'),
                    ]
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => lang('App.successful_registration')
            ]);
        }

        return view('templates/meta', $this->data)
             . view('templates/header', $this->data)
             . view('user/signup', $this->data)
             . view('templates/footer', $this->data);
    }

    public function login()
    {
        $this->data += [
            'meta_data' => [
                'title' => 'Login'
            ]
        ];

        if ($this->request->getMethod() == 'POST') {
            $login_data = $this->request->getPost();

            $rules = [
                'email_username' => [
                    'rules' => 'required|min_length[6]|valid_email|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.email_required'),
                        'min_length' => lang('Errors.email_min_length')
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.password_required'),
                        'min_length' => lang('Errors.password_min_length'),
                        'max_length' => lang('Errors.password_max_length')
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $user = $this->user_model->get_user($login_data);

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => [
                        'password' => lang('Errors.wrong_credentials')
                    ]
                ]);
            }

            session()->set('user_data', $user);
            $session_id = $this->session->session_id;

            $cart = $this->cart_model->get_cart($session_id);
            if ($cart !== null) {
                $this->cart_model->transfer_cart_items($session_id, $user->id, $cart);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => lang('App.successful_login')
            ]);
        }

        return view('templates/meta', $this->data)
        . view('templates/header', $this->data)
        . view('user/login', $this->data)
        . view('templates/footer', $this->data);
    }

    public function logout()
    {
        session()->remove('user_data');
        return redirect()->to('/home');
    }
}