<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ListingModel;
use App\Models\CategoryModel;
use App\Models\ListingImageModel;
use WebPConvert\WebPConvert;

class ListingController extends BaseController
{
    protected $listingModel;
    protected $categoryModel;
    protected $imageModel;
    
    public function __construct()
    {
        $this->listingModel = new ListingModel();
        $this->categoryModel = new CategoryModel();
        $this->imageModel = new ListingImageModel();
        helper(['slug', 'text']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Listings',
            'listings' => $this->listingModel
                          ->select('listings.*, categories.name as category_name')
                          ->join('categories', 'categories.id = listings.category_id')
                          ->orderBy('listings.created_at', 'DESC')
                          ->paginate(10),
            'pager' => $this->listingModel->pager
        ];
        
        return view('admin/listings/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Listing',
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('admin/listings/create', $data);
    }
    
    public function store()
    {
        // Validasi manual
        $errors = [];
        
        $title = trim($this->request->getPost('title'));
        $category_id = $this->request->getPost('category_id');
        $description = trim($this->request->getPost('description'));
        
        // BERSIHKAN HARGA DULU!
        $priceRaw = $this->request->getPost('price');
        $price = !empty($priceRaw) ? preg_replace('/[^0-9]/', '', $priceRaw) : '';
        
        $location = trim($this->request->getPost('location'));
        $status = $this->request->getPost('status') ?: 'active';
        
        // Cek required
        if (empty($title)) {
            $errors['title'] = 'Judul harus diisi';
        } elseif (strlen($title) < 5) {
            $errors['title'] = 'Judul minimal 5 karakter';
        }
        
        if (empty($category_id)) {
            $errors['category_id'] = 'Kategori harus dipilih';
        }
        
        if (empty($description)) {
            $errors['description'] = 'Deskripsi harus diisi';
        } elseif (strlen($description) < 20) {
            $errors['description'] = 'Deskripsi minimal 20 karakter';
        }
        
        // Validasi harga setelah dibersihkan
        if (!empty($priceRaw)) {
            if (!is_numeric($price)) {
                $errors['price'] = 'Harga harus angka';
            }
        }
        
        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }
        
        // Data untuk disimpan
        $data = [
            'title' => $title,
            'slug' => generate_listing_slug($title),
            'category_id' => $category_id,
            'description' => $description,
            'price' => !empty($price) ? $price : null, // Simpan angka doang
            'location' => $location ?: null,
            'status' => $status,
            'featured_image' => null
        ];
        
        if ($this->listingModel->save($data)) {
            $listingId = $this->listingModel->getInsertID();
            
            return redirect()->to(route_to('admin.listings.edit', $listingId))
                ->with('success', 'Listing berhasil ditambahkan! Sekarang upload gambar.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->listingModel->errors());
        }
    }
    
    public function edit($id)
    {
        $listing = $this->listingModel->find($id);
        
        if (!$listing) {
            return redirect()->to(route_to('admin.listings'))
                ->with('error', 'Listing tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Listing',
            'listing' => $listing,
            'categories' => $this->categoryModel->findAll(),
            'images' => $this->imageModel->where('listing_id', $id)->findAll()
        ];
        
        return view('admin/listings/edit', $data);
    }
    
    public function update($id)
    {
        $listing = $this->listingModel->find($id);
        
        if (!$listing) {
            return redirect()->to(route_to('admin.listings'))
                ->with('error', 'Listing tidak ditemukan');
        }
        
        $errors = [];
        
        $title = trim($this->request->getPost('title'));
        $category_id = $this->request->getPost('category_id');
        $description = trim($this->request->getPost('description'));
        
        // BERSIHKAN HARGA
        $priceRaw = $this->request->getPost('price');
        $price = !empty($priceRaw) ? preg_replace('/[^0-9]/', '', $priceRaw) : '';
        
        $location = trim($this->request->getPost('location'));
        $status = $this->request->getPost('status') ?: 'active';
        
        if (empty($title)) {
            $errors['title'] = 'Judul harus diisi';
        } elseif (strlen($title) < 5) {
            $errors['title'] = 'Judul minimal 5 karakter';
        }
        
        if (empty($category_id)) {
            $errors['category_id'] = 'Kategori harus dipilih';
        }
        
        if (empty($description)) {
            $errors['description'] = 'Deskripsi harus diisi';
        } elseif (strlen($description) < 20) {
            $errors['description'] = 'Deskripsi minimal 20 karakter';
        }
        
        if (!empty($priceRaw) && !is_numeric($price)) {
            $errors['price'] = 'Harga harus angka';
        }
        
        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }
        
        $data = [
            'id' => $id,
            'title' => $title,
            'slug' => generate_listing_slug($title, $id),
            'category_id' => $category_id,
            'description' => $description,
            'price' => !empty($price) ? $price : null,
            'location' => $location ?: null,
            'status' => $status
        ];
        
        if ($this->listingModel->save($data)) {
            return redirect()->to(route_to('admin.listings'))
                ->with('success', 'Listing "' . $data['title'] . '" berhasil diupdate!');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->listingModel->errors());
        }
    }
    
    public function uploadImage($id)
    {
        $listing = $this->listingModel->find($id);
        if (!$listing) {
            return $this->response->setJSON(['error' => 'Listing tidak ditemukan']);
        }
        
        $files = $this->request->getFiles();
        $uploaded = [];
        $errors = [];
        
        // Buat folder upload kalo belum ada
        $uploadPath = FCPATH . 'uploads/listings/' . $id;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // Proses setiap file
        if (isset($files['images'])) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Validasi
                    $fileType = $file->getMimeType();
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    
                    if (!in_array($fileType, $allowedTypes)) {
                        $errors[] = 'Tipe file harus JPG/PNG';
                        continue;
                    }
                    
                    if ($file->getSize() > 5 * 1024 * 1024) {
                        $errors[] = 'Ukuran file maksimal 5MB';
                        continue;
                    }
                    
                    // Generate nama file
                    $originalName = $file->getRandomName();
                    $tempName = 'temp_' . $originalName;
                    $webpName = pathinfo($originalName, PATHINFO_FILENAME) . '.webp';
                    
                    // Upload file temp dulu
                    if ($file->move($uploadPath, $tempName)) {
                        
                        // CONVERT KE WEBP
                        try {
                            $sourcePath = $uploadPath . '/' . $tempName;
                            $destPath = $uploadPath . '/' . $webpName;
                            
                            WebPConvert::convert($sourcePath, $destPath, [
                                'quality' => 80,
                                'encoding' => 'auto',
                                'metadata' => 'none'
                            ]);
                            
                            // Hapus file temp
                            unlink($sourcePath);
                            
                            // Simpan ke database
                            $imageData = [
                                'listing_id' => $id,
                                'image_path' => $id . '/' . $webpName,
                                'is_primary' => false // SEMUA false dulu
                            ];
                            
                            $this->imageModel->save($imageData);
                            $uploaded[] = $webpName;
                            
                        } catch (\Exception $e) {
                            $errors[] = 'Gagal convert gambar: ' . $e->getMessage();
                            if (file_exists($uploadPath . '/' . $tempName)) {
                                unlink($uploadPath . '/' . $tempName);
                            }
                        }
                    }
                }
            }
        }
        
        // ========== LOGIC PRIMARY YANG BENER ==========
        // Hitung total gambar untuk listing ini
        $totalImages = $this->imageModel->where('listing_id', $id)->countAllResults();
        
        // Kalo total gambar == jumlah yang baru diupload (berarti ini upload pertama kali)
        if ($totalImages == count($uploaded) && !empty($uploaded)) {
            // Ambil gambar pertama yang baru diupload
            $firstImage = $this->imageModel
                            ->where('listing_id', $id)
                            ->orderBy('id', 'ASC')
                            ->first();
            
            if ($firstImage) {
                // Reset semua primary dulu (jaga-jaga)
                $this->imageModel->where('listing_id', $id)
                                ->set(['is_primary' => false])
                                ->update();
                
                // Set gambar pertama jadi primary
                $this->imageModel->update($firstImage['id'], ['is_primary' => true]);
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'uploaded' => $uploaded,
            'errors' => $errors
        ]);
    }

    public function setPrimaryImage($imageId)
    {
        $image = $this->imageModel->find($imageId);
        if (!$image) {
            return $this->response->setJSON(['error' => 'Gambar tidak ditemukan']);
        }
        
        // Reset semua primary untuk listing ini
        $this->imageModel->where('listing_id', $image['listing_id'])
                        ->set(['is_primary' => false])
                        ->update();
        
        // Set yang dipilih jadi primary
        $this->imageModel->update($imageId, ['is_primary' => true]);
        
        return $this->response->setJSON(['success' => true]);
    }

    public function deleteImage($imageId)
    {
        $image = $this->imageModel->find($imageId);
        if (!$image) {
            return $this->response->setJSON(['error' => 'Gambar tidak ditemukan']);
        }
        
        // Hapus file
        $filePath = FCPATH . 'uploads/listings/' . $image['image_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Hapus dari database
        $this->imageModel->delete($imageId);
        
        // Set primary baru kalo yang dihapus adalah primary
        if ($image['is_primary']) {
            $newPrimary = $this->imageModel->where('listing_id', $image['listing_id'])
                                        ->orderBy('id', 'ASC')
                                        ->first();
            if ($newPrimary) {
                $this->imageModel->update($newPrimary['id'], ['is_primary' => true]);
            }
        }
        
        return $this->response->setJSON(['success' => true]);
    }

    public function createFromInquiry($inquiryId)
    {
        // Ambil data inquiry
        $inquiryModel = new \App\Models\InquiryModel();
        $inquiry = $inquiryModel->find($inquiryId);
        
        if (!$inquiry) {
            return redirect()->to('/admin/inquiries')
                ->with('error', 'Inquiry tidak ditemukan');
        }
        
        // Mapping jenis inquiry ke kategori (opsional)
        // Bisa pilih kategori default atau biar admin milih nanti
        $categoryMap = [
            'product' => 1,  // ID kategori untuk Produk
            'property' => 2, // ID kategori untuk Properti
            'service' => 3,  // ID kategori untuk Jasa
        ];
        
        $data = [
            'title' => 'Buat Listing dari Inquiry',
            'inquiry' => $inquiry,
            'categories' => $this->categoryModel->findAll(),
            'defaultCategory' => $categoryMap[$inquiry['listing_type']] ?? null
        ];
        
        return view('admin/listings/create-from-inquiry', $data);
    }
    public function delete($id)
    {
        $listing = $this->listingModel->find($id);
        
        if (!$listing) {
            return redirect()->to(route_to('admin.listings'))
                ->with('error', 'Listing tidak ditemukan');
        }
        
        // Hapus semua gambar terkait
        $images = $this->imageModel->where('listing_id', $id)->findAll();
        foreach ($images as $img) {
            $filePath = FCPATH . 'uploads/listings/' . $img['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Hapus dari database
        $this->imageModel->where('listing_id', $id)->delete();
        
        // Hapus listing (soft delete)
        if ($this->listingModel->delete($id)) {
            return redirect()->to(route_to('admin.listings'))
                ->with('success', 'Listing "' . $listing['title'] . '" berhasil dihapus');
        } else {
            return redirect()->to(route_to('admin.listings'))
                ->with('error', 'Gagal menghapus listing');
        }
    }
}