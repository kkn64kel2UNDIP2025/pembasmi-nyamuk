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
        // Add additional validation for mobile uploads
        $validation = \Config\Services::validation();
        $validation->setRules([
            'evidence_image' => [
                'label' => 'Bukti Foto',
                'rules' => 'uploaded[evidence_image]|is_image[evidence_image]|max_size[evidence_image,5120]',
                'errors' => [
                    'uploaded' => 'Bukti foto harus diunggah.',
                    'is_image' => 'File harus berupa gambar.',
                    'max_size' => 'Ukuran file maksimal 5MB.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', implode(' ', $validation->getErrors()));
            return redirect()->back()->withInput();
        }

        $resultUpload = $this->uploadImage();

        // If image upload failed, return with error
        if ($resultUpload['status'] === 'error') {
            session()->setFlashdata('error', $resultUpload['message']);
            return redirect()->back()->withInput();
        }

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

        try {
            $this->locationsModel->insert($data);
            session()->setFlashdata('success', $resultUpload['message']);
        } catch (\Exception $e) {
            log_message('error', 'Database insert failed: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal menyimpan laporan. Silakan coba lagi.');
        }
        
        return redirect()->back();
    }

    private function uploadImage()
    {
        $file = $this->request->getFile('evidence_image');

        // Validate file upload
        if (!$file || !$file->isValid()) {
            return [
                'fileName' => null,
                'status' => 'error',
                'message' => 'File tidak valid atau gagal diunggah.'
            ];
        }

        // Check if file has been uploaded properly
        if (!$file->hasMoved() && $file->getError() !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
                UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
                UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi PHP'
            ];
            
            $errorMessage = $errorMessages[$file->getError()] ?? 'Upload error: ' . $file->getError();
            log_message('error', 'File upload error: ' . $errorMessage);
            
            return [
                'fileName' => null,
                'status' => 'error',
                'message' => $errorMessage
            ];
        }

        // Get temp file path and validate it exists
        $tempPath = $file->getTempName();
        if (empty($tempPath) || !file_exists($tempPath)) {
            // Log for debugging
            log_message('error', 'File upload issue - TempPath: ' . ($tempPath ?: 'empty') . ', File exists: ' . (file_exists($tempPath) ? 'yes' : 'no'));
            log_message('error', 'File details - Name: ' . $file->getName() . ', Size: ' . $file->getSize() . ', Error: ' . $file->getError());
            
            return [
                'fileName' => null,
                'status' => 'error',
                'message' => 'File temporary tidak ditemukan. Silakan coba lagi.'
            ];
        }

        // Validate file size (max 5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            return [
                'fileName' => null,
                'status' => 'error',
                'message' => 'Ukuran file terlalu besar. Maksimal 5MB.'
            ];
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return [
                'fileName' => null,
                'status' => 'error',
                'message' => 'Tipe file tidak didukung. Gunakan JPG, PNG, atau GIF.'
            ];
        }

        $fileContent = file_get_contents($tempPath);
        if ($fileContent === false) {
            // Try alternative method for mobile devices
            try {
                // Alternative approach: move file first then read
                $uploadDir = WRITEPATH . 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $targetPath = $uploadDir . 'temp_' . uniqid();
                if ($file->move(dirname($targetPath), basename($targetPath))) {
                    $fileContent = file_get_contents($targetPath);
                    unlink($targetPath); // Clean up temporary file
                }
            } catch (\Exception $e) {
                log_message('error', 'Failed to read file with alternative method: ' . $e->getMessage());
            }
            
            if (!$fileContent) {
                return [
                    'fileName' => null,
                    'status' => 'error',
                    'message' => 'Gagal membaca file. Silakan coba lagi.'
                ];
            }
        }

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

    /**
     * Debug method to check PHP upload settings
     * Can be accessed via /pelaporan/debug-upload (for testing purposes only)
     */
    public function debugUpload()
    {
        if (ENVIRONMENT !== 'development') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $settings = [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'file_uploads' => ini_get('file_uploads') ? 'enabled' : 'disabled',
            'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: 'default',
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
            'writable_uploads_dir' => is_writable(WRITEPATH . 'uploads/') ? 'writable' : 'not writable'
        ];

        return $this->response->setJSON($settings);
    }
}
