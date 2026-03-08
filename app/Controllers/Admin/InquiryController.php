<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InquiryModel;

class InquiryController extends BaseController
{
    protected $inquiryModel;
    
    public function __construct()
    {
        $this->inquiryModel = new InquiryModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Inquiries',
            'inquiries' => $this->inquiryModel
                          ->orderBy('created_at', 'DESC')
                          ->paginate(10),
            'pager' => $this->inquiryModel->pager
        ];
        
        return view('admin/inquiries/index', $data);
    }
    
   public function show($id)
{
    $inquiry = $this->inquiryModel->find($id);
    
    if (!$inquiry) {
        return redirect()->to('/admin/inquiries')
            ->with('error', 'Inquiry tidak ditemukan');
    }
    
    // // Debug: cek data
    // echo '<pre>';
    // print_r($inquiry);
    // echo '</pre>';
    // exit;
    
    // Kalo udah keluar datanya, hapus debug di atas
    
    $data = [
        'title' => 'Detail Inquiry',
        'inquiry' => $inquiry
    ];
    
    return view('admin/inquiries/show', $data);
}
    
    public function updateStatus($id)
    {
        // Debug: lihat semua POST
        log_message('error', 'POST data: ' . json_encode($_POST));
        
        $inquiry = $this->inquiryModel->find($id);
        
        if (!$inquiry) {
            return $this->response->setJSON(['success' => false, 'error' => 'Inquiry tidak ditemukan']);
        }
        
        $status = $this->request->getPost('status');
        
        if (!$status) {
            return $this->response->setJSON(['success' => false, 'error' => 'Status tidak diterima']);
        }
        
        $allowed = ['new', 'read', 'replied'];
        
        if (!in_array($status, $allowed)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Status tidak valid']);
        }
        
        if ($this->inquiryModel->update($id, ['status' => $status])) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Gagal update status']);
        }
    }
    public function delete($id)
    {
        $inquiry = $this->inquiryModel->find($id);
        
        if (!$inquiry) {
            return redirect()->to('/admin/inquiries')
                ->with('error', 'Inquiry tidak ditemukan');
        }
        
        // Hapus foto kalo ada (UPDATE: photos bisa multiple)
        if (!empty($inquiry['photos'])) {
            $photos = json_decode($inquiry['photos'], true);
            if (is_array($photos)) {
                foreach ($photos as $photo) {
                    $photoPath = FCPATH . 'uploads/inquiries/' . $photo;
                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }
                    
                    // Hapus juga versi webp
                    $webpPath = FCPATH . 'uploads/inquiries/webp/' . pathinfo($photo, PATHINFO_FILENAME) . '.webp';
                    if (file_exists($webpPath)) {
                        unlink($webpPath);
                    }
                }
            }
        } elseif (!empty($inquiry['photo'])) {
            // Untuk kompatibilitas dengan data lama (single photo)
            $photoPath = FCPATH . 'uploads/inquiries/' . $inquiry['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        
        $this->inquiryModel->delete($id);
        
        return redirect()->to('/admin/inquiries')
            ->with('success', 'Inquiry berhasil dihapus');
    }
}