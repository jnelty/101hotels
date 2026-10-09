<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GuestFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userId = session()->get('user_id');

        if (! is_numeric($userId) || (int) $userId < 1) {
            return;
        }

        $previousUrl = previous_url(true);

        return redirect()->to($previousUrl);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
