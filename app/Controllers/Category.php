<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('category/index', $data);
    }

    public function create()
    {
        helper(['form']);
        if ($this->request->getMethod() === 'post') {
            $name = $this->request->getPost('name');
            $this->categoryModel->save([
                'name' => $name,
                'slug' => url_title($name, '-', true)
            ]);
            return redirect()->to('/category')->with('success','Kategori berhasil ditambah');
        }
        return view('category/create');
    }

    public function edit($id)
    {
        helper(['form']);
        $data['category'] = $this->categoryModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $name = $this->request->getPost('name');
            $this->categoryModel->update($id, [
                'name' => $name,
                'slug' => url_title($name,'-',true)
            ]);
            return redirect()->to('/category')->with('success','Kategori berhasil diupdate');
        }

        return view('category/edit', $data);
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/category')->with('success','Kategori berhasil dihapus');
    }
}