<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ListingModel;
use App\Models\InquiryModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'totalCategories' => model(CategoryModel::class)->countAll(),
            'totalListings' => model(ListingModel::class)->countAll(),
            'totalInquiries' => model(InquiryModel::class)->countAll(),
            'latestListings' => model(ListingModel::class)
                                ->orderBy('created_at', 'DESC')
                                ->limit(5)
                                ->find(),
            'latestInquiries' => model(InquiryModel::class)
                                ->orderBy('created_at', 'DESC')
                                ->limit(5)
                                ->find(),
        ];
        
        return view('admin/dashboard', $data);
    }
}