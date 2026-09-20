<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class UserModel
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function register($register_data)
    {
        $user = $this->db
            ->table('users')
            ->where('email', $register_data['email'])
            ->orWhere('username', $register_data['username'])
            ->get()
            ->getRow();

        if ($user) {
            return false;
        }

        $user_data = [
            'username' => $register_data['username'],
            'password' => md5($register_data['password']),
            'full_name' => $register_data['full_name'],
            'email' => $register_data['email'],
            'role' => 'user'
        ];

        return $this->db->table('users')->insert($user_data);
    }

    public function get_user($login_data)
    {
        $user = $this->db
            ->table('users')
            ->groupStart()
                ->where('email', $login_data['email_username'])
                ->orWhere('username', $login_data['email_username'])
            ->groupEnd()
            ->where('password', md5($login_data['password']))
            ->get()
            ->getRow();

        if (!$user) {
            return false;
        }

        return $user;
    }

    public function registered_users()
    {
        return $this->db->table('users')
            ->where('role', 'user')
            ->countAllResults();
    }
}