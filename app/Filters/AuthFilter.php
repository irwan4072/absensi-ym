<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Daftar controller yang tidak memerlukan login
        $excludedControllers = [
            'DataReceived',
            'Login'
        ];

        // Ambil nama controller dari URI
        $controller = $request->uri->getSegment(1);

        // Jika controller tidak ada dalam daftar pengecualian, periksa login
        if (!in_array($controller, $excludedControllers)) {
            if (!$session->get('isLoggedIn')) {
                return redirect()->to('/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request yang diperlukan
    }
}
