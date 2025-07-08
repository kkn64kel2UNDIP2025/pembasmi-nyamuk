<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ReportController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Pelaporan Potensi';

        return view('pages/report', $data);
    }
}
