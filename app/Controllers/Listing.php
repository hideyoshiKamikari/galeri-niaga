<?php

namespace App\Controllers;

use App\Models\ListingModel;
use App\Models\CategoryModel;

class Listing extends BaseController
{
    protected $listingModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->listingModel = new ListingModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data['listings'] = $this->listingModel->join('categories','categories.id=listings.category_id')->select('listings.*, categories.name as category_name')->findAll();
        return view('listing/index', $data);
    }

    public function create()
    {
        helper(['form','url']);
        $data['categories'] = $this->categoryModel->findAll();

        if ($this->request->getMethod() === 'post') {
            $title = $this->request->getPost('title');
            $featured_image = $this->request->getFile('featured_image');

            if ($featured_image && $featured_image->isValid()) {
                $fileName = $featured_image->getRandomName();
                $featured_image->move(WRITEPATH.'uploads',$fileName);
            } else {
                $fileName = null;
            }

            $this->listingModel->save([
                'category_id' => $this->request->getPost('category_id'),
                'title'       => $title,
                'slug'        => url_title($title,'-',true),
                'description' => $this->request->getPost('description'),
                'price'       => $this->request->getPost('price'),
                'location'    => $this->request->getPost('location'),
                'featured_image' => $fileName,
                'status'      => 'active'
            ]);

            return redirect()->to('/listing')->with('success','Listing berhasil ditambah');
        }

        return view('listing/create',$data);
    }
    
        public function show($slug)
    {
        $listing = $this->listingModel
                        ->where('slug', $slug)
                        ->where('status', 'active')
                        ->first();

        if (!$listing) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('frontend/detail', [
            'listing' => $listing,
            'title'   => $listing['title']
        ]);
    }
    // edit & delete hampir sama logikanya
}