<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AboutController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Tentang Aplikasi | SI JEMPANG'
        ];

        return view('pages/about', $data);
    }
}
