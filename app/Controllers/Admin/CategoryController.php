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
        helper(['slug', 'alert']); // Load helpers
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
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => generate_category_slug($this->request->getPost('name'))
        ];
        
        if ($this->categoryModel->save($data)) {
            return redirect()->to('/admin/categories')
                ->with('success', 'Kategori berhasil ditambahkan');
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
            return redirect()->to('/admin/categories')
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
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'slug' => generate_category_slug(
                $this->request->getPost('name'), 
                $id
            )
        ];
        
        if ($this->categoryModel->save($data)) {
            return redirect()->to('/admin/categories')
                ->with('success', 'Kategori berhasil diupdate');
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
            return redirect()->to('/admin/categories')
                ->with('error', 'Kategori tidak ditemukan');
        }
        
        // Cek apakah kategori punya listing
        if ($this->categoryModel->hasListings($id)) {
            return redirect()->to('/admin/categories')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki listing');
        }
        
        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/categories')
                ->with('success', 'Kategori berhasil dihapus');
        } else {
            return redirect()->to('/admin/categories')
                ->with('error', 'Gagal menghapus kategori');
        }
    }
}