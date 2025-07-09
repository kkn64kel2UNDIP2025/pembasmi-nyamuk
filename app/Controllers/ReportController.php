<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ReportController extends BaseController
{      
    protected $categoriesModel;
    protected $locationsModel;


    public function __construct()
    {
        $this->categoriesModel = new \App\Models\CategoryModel;
        $this->locationsModel = new \App\Models\LocationModel;
    }
    
    public function index()
    {
        $data = [
            'title' => 'Pelaporan Potensi',
            'categories' => $this->categoriesModel->findAll()
        ];

        return view('pages/report', $data);
    }

    public function LaporanBaru()
    {
        dd($this->request->getVar());
    }

    public function uploadImage()
    {
        $file = $this->request->getFile('image');

        $fileContent = file_get_contents($file->getTempName());
        $fileName = $file->getName();
        
        // d($file->getTempName());
        // d($fileContent);
        // d($fileName);
        // dd($file->getMimeType());

        $bucket = 'pelaporan';
        $projectUrl = 'https://gtlzsymniqibbspxbfrb.supabase.co';
        $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imd0bHpzeW1uaXFpYmJzcHhiZnJiIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc1MTM0MDY1MiwiZXhwIjoyMDY2OTE2NjUyfQ.8RrjDO5SrK05atiudwxXQliRB926SMidauC-1g0EbSQ';

        // PUT Requests
        $client = \Config\Services::curlrequest();
        
        $response = $client->put("$projectUrl/storage/v1/object/$bucket/$fileName", [
            'headers' => [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => $file->getMimeType()
            ],
            'body' => $fileContent
        ]);

        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
            d("Berhasil upload ke Supabase: $fileName");
        } else {
            d("Status: " . $response->getStatusCode());
            d($response->getBody());
        }
    }
}
