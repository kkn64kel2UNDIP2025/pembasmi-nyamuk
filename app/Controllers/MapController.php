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
        $data['title'] = 'Peta Pemantauan | Si Jempang';
        $data['locations'] = $this->locationsModel->getLocationsWithCategory();

        return view('pages/map', $data);
    }

    public function UpdateStatus()
    {
        $id = $this->request->getVar('location_id');
        $status = $this->request->getVar('status');

        if ($status === 'laporan palsu' || $status === 'terselesaikan') {
            $this->locationsModel->update($id, [
                'status' => $status,
                'resolve_at' => date('Y-m-d H:i:s')
            ]);
            session()->setFlashdata('success', 'Laporan berhasil ditandai sebagai ' . $status . '.');
        } else {
            session()->setFlashdata('error', 'Status tidak valid.');
        }

        return redirect()->back();
    }
}
