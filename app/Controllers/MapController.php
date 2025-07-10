<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MapController extends BaseController
{
    protected $locationsModel;

    public function __construct()
    {
        $this->locationsModel = new \App\Models\LocationModel;
    } 
    
    public function index()
    {
        $data['title'] = 'Peta Pemantauan';
        $data['locations'] = $this->locationsModel->getLocationsWithCategory();

        return view('pages/map', $data);
    }
}
