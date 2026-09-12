<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RequireGuestFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('user_data') !== null) {
            return redirect()->to('/home');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}