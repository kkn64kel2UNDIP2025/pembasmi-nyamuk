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
            'title' => 'Pelaporan Lokasi | Si Jempang',
            'categories' => $this->categoriesModel->findAll()
        ];

        return view('pages/report', $data);
    }

    public function LaporanBaru()
    {
        // Validasi input
        $validation = [
            'name' => [
                'rules' => 'required|max_length[75]',
                'errors' => [
                    'required' => 'Nama pelapor harus diisi.',
                    'max_length' => 'Nama pelapor maksimal 75 karakter.'
                ]
            ],
            'phone' => [
                'rules' => 'permit_empty|regex_match[/^[0-9]{10,15}$/]',
                'errors' => [
                    'regex_match' => 'Nomor telepon tidak valid.'
                ]
            ],
            'latitude' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Latitude harus diisi.',
                    'decimal' => 'Latitude harus berupa angka desimal.'
                ]
            ],
            'longitude' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Longitude harus diisi.',
                    'decimal' => 'Longitude harus berupa angka desimal.'
                ]
            ],
            'category' => [
                'rules' => 'required|is_not_unique[categories.id]',
                'errors' => [
                    'required' => 'Kategori harus dipilih.',
                    'is_not_unique' => 'Kategori tidak valid.'
                ]
            ],
            'level' => [
                'rules' => 'required|in_list[1,2,3]',
                'errors' => [
                    'required' => 'Level harus dipilih.',
                    'in_list' => 'Level tidak valid.'
                ]
            ],
            'description' => [
                'rules' => 'permit_empty|max_length[500]',
                'errors' => [
                    'max_length' => 'Deskripsi maksimal 500 karakter.'
                ]
            ],
            'evidence_image' => [
                'rules' => 'uploaded[evidence_image]|is_image[evidence_image]|max_size[evidence_image,1024]',
                'errors' => [
                    'uploaded' => 'Gambar bukti harus diunggah.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB.'
                ]
            ]
        ];

        if (!$this->validate($validation)) {
            return redirect()->back()->withInput()->with('val_errors', $this->validator->getErrors());
        }
        
        $resultUpload = $this->uploadImage();

        // Ambil data dari input
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
