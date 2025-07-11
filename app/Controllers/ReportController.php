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
            'title' => 'Pelaporan Lokasi | Pembasmi Nyamuk',
            'categories' => $this->categoriesModel->findAll()
        ];

        return view('pages/report', $data);
    }

    public function LaporanBaru()
    {
        $resultUpload = $this->uploadImage();

        $data = [
            'name' => $this->request->getVar('name'),
            'phone' => $this->request->getVar('phone'),
            'latitude' => $this->request->getVar('latitude'),
            'longitude' => $this->request->getVar('longitude'),
            'category_id' => $this->request->getVar('category'),
            'level' => $this->request->getVar('level'),
            'description' => $this->request->getVar('description'),
            'evidence_image' => $resultUpload['fileName'],
            'resolve_at' => null,
        ];

        $this->locationsModel->insert($data);
        session()->setFlashdata($resultUpload['status'], $resultUpload['message']);
        return redirect()->back();
    }

    private function uploadImage()
    {
        $file = $this->request->getFile('evidence_image');

        $fileContent = file_get_contents($file->getTempName());
        $fileName = $file->getRandomName();

        $bucket = 'pelaporan';
        $projectUrl = 'https://nbqxohqnlurhpzlqybmg.supabase.co';
        $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5icXhvaHFubHVyaHB6bHF5Ym1nIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc1MjAxMDg2MSwiZXhwIjoyMDY3NTg2ODYxfQ.cK6zlfzpc7pDRqSRfLFie2N1zGeCC9-62m2_PqG8y2E';

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
            $message = 'Laporan berhasil dikirim!';
            $status = 'success';
        } else {
            $message = 'Gagal mengunggah gambar. Silakan coba lagi.';
            $status = 'error';
        }

        return [
            'fileName' => $fileName,
            'status' => $status,
            'message' => $message
        ];
    }


}
