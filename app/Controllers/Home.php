<?php

namespace App\Controllers;

use App\Models\ListingModel;
use App\Models\CategoryModel;
use WebPConvert\WebPConvert; // <-- TAMBAH INI

class Home extends BaseController
{
    protected $listingModel;
    protected $categoryModel;
    
    public function __construct()
    {
        $this->listingModel = new ListingModel();
        $this->categoryModel = new CategoryModel();
        helper(['text', 'wa']);
    }
    
    public function index()
    {
        $categoryId = $this->request->getGet('category');
        $keyword = $this->request->getGet('q');
        $sort = $this->request->getGet('sort') ?: 'terbaru';
        $minPrice = $this->request->getGet('min');
        $maxPrice = $this->request->getGet('max');
        
        $query = $this->listingModel
                    ->select('listings.*, categories.name as category_name')
                    ->join('categories', 'categories.id = listings.category_id')
                    ->where('listings.status', 'active');
        
        // FILTER KATEGORI
        if ($categoryId && is_numeric($categoryId)) {
            $query->where('listings.category_id', $categoryId);
        }
        
        // FILTER KEYWORD (SEARCH)
        if ($keyword) {
            $query->groupStart()
                  ->like('listings.title', $keyword)
                  ->orLike('listings.description', $keyword)
                  ->orLike('listings.location', $keyword)
                  ->groupEnd();
        }
        
        // FILTER HARGA
        if ($minPrice && is_numeric($minPrice)) {
            $query->where('listings.price >=', $minPrice);
        }
        
        if ($maxPrice && is_numeric($maxPrice)) {
            $query->where('listings.price <=', $maxPrice);
        }
        
        // SORTING
        switch ($sort) {
            case 'termurah':
                $query->orderBy('listings.price', 'ASC');
                break;
            case 'termahal':
                $query->orderBy('listings.price', 'DESC');
                break;
            case 'terbaru':
            default:
                $query->orderBy('listings.created_at', 'DESC');
                break;
        }
        
        $data = [
            'title' => $keyword ? "Hasil Pencarian: $keyword" : 'Home',
            'listings' => $query->paginate(12),
            'pager' => $this->listingModel->pager,
            'categories' => $this->categoryModel->findAll(),
            'selectedCategory' => $categoryId,
            'keyword' => $keyword,
            'sort' => $sort,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'featured' => $this->listingModel
                        ->select('listings.*, categories.name as category_name')
                        ->join('categories', 'categories.id = listings.category_id')
                        ->where('listings.status', 'active')
                        ->orderBy('listings.created_at', 'DESC')
                        ->limit(3)
                        ->find()
        ];
        
        return view('frontend/home', $data);
    }
    
    public function kategori()
    {
        $data = [
            'title' => 'Semua Kategori',
            'categories' => $this->categoryModel
                          ->orderBy('name', 'ASC')
                          ->findAll()
        ];
        
        return view('frontend/kategori', $data);
    }
    
    public function detail($slug)
    {
        $listing = $this->listingModel
                    ->select('listings.*, categories.name as category_name')
                    ->join('categories', 'categories.id = listings.category_id')
                    ->where('listings.slug', $slug)
                    ->where('listings.status', 'active')
                    ->first();
        
        if (!$listing) {
            return redirect()->to('/')->with('error', 'Listing tidak ditemukan');
        }
        
        // Ambil gambar
        $images = model('App\Models\ListingImageModel')
                  ->where('listing_id', $listing['id'])
                  ->findAll();
        
        $data = [
            'title' => $listing['title'],
            'listing' => $listing,
            'images' => $images,
            'related' => $this->listingModel
                        ->select('listings.*, categories.name as category_name')
                        ->join('categories', 'categories.id = listings.category_id')
                        ->where('listings.category_id', $listing['category_id'])
                        ->where('listings.id !=', $listing['id'])
                        ->where('listings.status', 'active')
                        ->limit(4)
                        ->find()
        ];
        
        return view('frontend/detail', $data);
    }
    
    public function category($slug)
    {
        $category = $this->categoryModel->where('slug', $slug)->first();
        
        if (!$category) {
            return redirect()->to('/')->with('error', 'Kategori tidak ditemukan');
        }
        
        $data = [
            'title' => 'Kategori: ' . $category['name'],
            'category' => $category,
            'listings' => $this->listingModel
                          ->select('listings.*, categories.name as category_name')
                          ->join('categories', 'categories.id = listings.category_id')
                          ->where('listings.category_id', $category['id'])
                          ->where('listings.status', 'active')
                          ->orderBy('listings.created_at', 'DESC')
                          ->paginate(12),
            'pager' => $this->listingModel->pager
        ];
        
        return view('frontend/category', $data);
    }
    
    public function search()
    {
        $keyword = $this->request->getGet('q');
        $category = $this->request->getGet('category');
        
        $query = $this->listingModel
                    ->select('listings.*, categories.name as category_name')
                    ->join('categories', 'categories.id = listings.category_id')
                    ->where('listings.status', 'active');
        
        // Filter berdasarkan keyword
        if ($keyword) {
            $query->groupStart()
                ->like('listings.title', $keyword)
                ->orLike('listings.description', $keyword)
                ->orLike('listings.location', $keyword)
                ->groupEnd();
        }
        
        // Filter berdasarkan kategori
        if ($category && is_numeric($category)) {
            $query->where('listings.category_id', $category);
        }
        
        $data = [
            'title' => 'Hasil Pencarian',
            'listings' => $query->paginate(12),
            'pager' => $this->listingModel->pager,
            'keyword' => $keyword,
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('frontend/search', $data);
    }

    public function titipJual()
    {
        $data = [
            'title' => 'Titip Jual',
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('frontend/titip-jual', $data);
    }

    public function storeTitipJual()
    {
        // Validasi
        $rules = [
            'name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi',
                    'min_length' => 'Nama minimal 3 karakter'
                ]
            ],
            'phone' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Nomor WhatsApp harus diisi',
                    'min_length' => 'Nomor WhatsApp minimal 10 digit'
                ]
            ],
            'email' => 'permit_empty|valid_email',
            'listing_type' => [
                'rules' => 'required|in_list[product,property,service]',
                'errors' => [
                    'required' => 'Jenis listing harus dipilih',
                    'in_list' => 'Jenis listing tidak valid'
                ]
            ],
            'message' => [
                'rules' => 'required|min_length[20]',
                'errors' => [
                    'required' => 'Deskripsi harus diisi',
                    'min_length' => 'Deskripsi minimal 20 karakter'
                ]
            ],
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // ========== MULTIPLE UPLOAD + WEBP ==========
        $photos = [];
        $files = $this->request->getFiles();
        
        // Buat folder upload kalo belum ada
        $uploadPath = FCPATH . 'uploads/inquiries';
        $webpPath = FCPATH . 'uploads/inquiries/webp';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        if (!is_dir($webpPath)) {
            mkdir($webpPath, 0777, true);
        }
        
        // Proses multiple upload
        if (isset($files['photos'])) {
            foreach ($files['photos'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Validasi type
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!in_array($file->getMimeType(), $allowedTypes)) {
                        continue;
                    }
                    
                    // Validasi size (2MB)
                    if ($file->getSize() > 2 * 1024 * 1024) {
                        continue;
                    }
                    
                    // Batasi maksimal 5 foto
                    if (count($photos) >= 5) {
                        break;
                    }
                    
                    // Generate nama file
                    $originalName = $file->getRandomName();
                    
                    // Upload file asli
                    if ($file->move($uploadPath, $originalName)) {
                        
                        // Convert ke WebP
                        try {
                            $sourceFile = $uploadPath . '/' . $originalName;
                            $webpName = pathinfo($originalName, PATHINFO_FILENAME) . '.webp';
                            $destFile = $webpPath . '/' . $webpName;
                            
                            WebPConvert::convert($sourceFile, $destFile, [
                                'quality' => 80,
                                'encoding' => 'auto',
                                'metadata' => 'none'
                            ]);
                            
                            // Simpan nama file asli (WebP akan dipanggil di view)
                            $photos[] = $originalName;
                            
                        } catch (\Exception $e) {
                            // Kalo gagal convert, tetap simpan file asli
                            $photos[] = $originalName;
                        }
                    }
                }
            }
        }
        
        // Data yang akan disimpan
        $data = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'listing_type' => $this->request->getPost('listing_type'),
            'message' => $this->request->getPost('message'),
            'photos' => json_encode($photos), // Simpan sebagai JSON
            'status' => 'new'
        ];
        
        // Simpan ke database
        $inquiryModel = model('App\Models\InquiryModel');
        
        if ($inquiryModel->save($data)) {
            return redirect()->to('/titip-jual/success')
                ->with('success', 'Form titip jual berhasil dikirim!');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $inquiryModel->errors());
        }
    }

    public function titipJualSuccess()
    {
        $data = [
            'title' => 'Titip Jual Berhasil'
        ];
        
        return view('frontend/titip-jual-success', $data);
    }

    public function tentang()
    {
        $data = [
            'title' => 'Tentang Kami',
            'description' => 'Platform UMKM untuk memasarkan produk, properti, dan jasa'
        ];
        
        return view('frontend/tentang', $data);
    }

    public function kontak()
    {
        $data = [
            'title' => 'Kontak Kami',
            'description' => 'Hubungi kami untuk informasi lebih lanjut'
        ];
        
        return view('frontend/kontak', $data);
    }
}