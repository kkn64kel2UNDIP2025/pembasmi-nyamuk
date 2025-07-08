<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MapController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Peta Pemantauan';
        
        return view('pages/map', $data);
    }
}
