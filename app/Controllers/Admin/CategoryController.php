<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;
    
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        helper(['slug', 'alert']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kategori',
            'categories' => $this->categoryModel
                            ->orderBy('created_at', 'DESC')
                            ->paginate(10),
            'pager' => $this->categoryModel->pager
        ];
        
        return view('admin/categories/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori'
        ];
        
        return view('admin/categories/create', $data);
    }
    
    public function store()
    {
        $name = trim($this->request->getPost('name'));
        
        // Manual validation
        $errors = [];
        
        if (empty($name)) {
            $errors['name'] = 'Nama kategori harus diisi';
        } elseif (strlen($name) < 3) {
            $errors['name'] = 'Nama kategori minimal 3 karakter';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama kategori maksimal 100 karakter';
        } else {
            // Check unique (case insensitive)
            $existing = $this->categoryModel
                ->where('LOWER(name)', strtolower($name))
                ->first();
                
            if ($existing) {
                $errors['name'] = 'Nama kategori sudah ada';
            }
        }
        
        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }
        
        $data = [
            'name' => $name,
            'slug' => generate_category_slug($name)
        ];
        
        if ($this->categoryModel->save($data)) {
            return redirect()->to(route_to('admin.categories'))
                ->with('success', 'Kategori "' . $data['name'] . '" berhasil ditambahkan! 🎉');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->categoryModel->errors());
        }
    }
    
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to(route_to('admin.categories'))
                ->with('error', 'Kategori tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Kategori',
            'category' => $category
        ];
        
        return view('admin/categories/edit', $data);
    }
    
    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to(route_to('admin.categories'))
                ->with('error', 'Kategori tidak ditemukan');
        }
        
        $name = trim($this->request->getPost('name'));
        
        // Manual validation
        $errors = [];
        
        if (empty($name)) {
            $errors['name'] = 'Nama kategori harus diisi';
        } elseif (strlen($name) < 3) {
            $errors['name'] = 'Nama kategori minimal 3 karakter';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama kategori maksimal 100 karakter';
        } else {
            // Case insensitive check, exclude current ID
            $existing = $this->categoryModel
                ->where('LOWER(name)', strtolower($name))
                ->where('id !=', $id)
                ->first();
                
            if ($existing) {
                $errors['name'] = 'Nama kategori sudah ada';
            }
        }
        
        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }
        
        $data = [
            'id' => $id,
            'name' => $name,
            'slug' => generate_category_slug($name, $id)
        ];
        
        if ($this->categoryModel->save($data)) {
            return redirect()->to(route_to('admin.categories'))
                ->with('success', 'Kategori "' . $data['name'] . '" berhasil diupdate! ✨');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->categoryModel->errors());
        }
    }
    
    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to(route_to('admin.categories'))
                ->with('error', 'Kategori tidak ditemukan');
        }
        
        // Cek apakah kategori punya listing
        if ($this->categoryModel->hasListings($id)) {
            return redirect()->to(route_to('admin.categories'))
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki listing');
        }
        
        if ($this->categoryModel->delete($id)) {
            return redirect()->to(route_to('admin.categories'))
                ->with('success', 'Kategori berhasil dihapus');
        } else {
            return redirect()->to(route_to('admin.categories'))
                ->with('error', 'Gagal menghapus kategori');
        }
    }
}