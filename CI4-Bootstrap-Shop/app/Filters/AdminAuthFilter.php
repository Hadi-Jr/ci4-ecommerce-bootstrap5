<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $user = session()->get('user_data');

        if ($user === null) {
            return redirect()->to('/login');
        }

        if ($user->role !== 'admin') {
            return redirect()->to('/home');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}