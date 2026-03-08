<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========== FRONTEND ROUTES ==========
$routes->get('/', 'Home::index');
$routes->get('listing/(:segment)', 'Home::detail/$1');
$routes->get('kategori', 'Home::kategori');
$routes->get('kategori/(:segment)', 'Home::category/$1');
$routes->get('search', 'Home::search');
$routes->get('titip-jual', 'Home::titipJual');
$routes->post('titip-jual/store', 'Home::storeTitipJual');
$routes->get('titip-jual/success', 'Home::titipJualSuccess');
$routes->get('tentang', 'Home::tentang');     
$routes->get('kontak', 'Home::kontak');        

// ========== AUTH ROUTES ==========
$routes->group('', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login/attempt', 'Auth::attempt');  // lebih eksplisit
    $routes->get('logout', 'Auth::logout');
    $routes->post('logout', 'Auth::logout');
});

// ========== ADMIN ROUTES (Protected) ==========
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard - root admin
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');
    
    // Categories CRUD
    // Categories
    $routes->group('categories', function($routes) {
        $routes->get('/', 'Admin\CategoryController::index', ['as' => 'admin.categories']);  // <-- KASIH NAMA
        $routes->get('create', 'Admin\CategoryController::create', ['as' => 'admin.categories.create']);
        $routes->post('store', 'Admin\CategoryController::store', ['as' => 'admin.categories.store']);
        $routes->get('edit/(:num)', 'Admin\CategoryController::edit/$1', ['as' => 'admin.categories.edit']);
        $routes->post('update/(:num)', 'Admin\CategoryController::update/$1', ['as' => 'admin.categories.update']);
        $routes->get('delete/(:num)', 'Admin\CategoryController::delete/$1', ['as' => 'admin.categories.delete']);
    });
    
    // // Listings (nanti)
    // $routes->group('listings', function($routes) {
    //     $routes->get('/', 'Admin\ListingController::index');
    //     $routes->get('create', 'Admin\ListingController::create');
    //     $routes->post('store', 'Admin\ListingController::store');
    //     $routes->get('edit/(:num)', 'Admin\ListingController::edit/$1');
    //     $routes->post('update/(:num)', 'Admin\ListingController::update/$1');
    //     $routes->get('delete/(:num)', 'Admin\ListingController::delete/$1');
    // });
    
    // Listings
    $routes->group('listings', function($routes) {
        $routes->get('/', 'Admin\ListingController::index', ['as' => 'admin.listings']);
        $routes->get('create', 'Admin\ListingController::create', ['as' => 'admin.listings.create']);
        $routes->post('store', 'Admin\ListingController::store', ['as' => 'admin.listings.store']);
        $routes->get('edit/(:num)', 'Admin\ListingController::edit/$1', ['as' => 'admin.listings.edit']);
        $routes->post('update/(:num)', 'Admin\ListingController::update/$1', ['as' => 'admin.listings.update']);
        $routes->get('delete/(:num)', 'Admin\ListingController::delete/$1', ['as' => 'admin.listings.delete']);
        // Upload routes
        $routes->post('upload/(:num)', 'Admin\ListingController::uploadImage/$1');
        $routes->post('set-primary/(:num)', 'Admin\ListingController::setPrimaryImage/$1');
        // $routes->delete('delete-image/(:num)', 'Admin\ListingController::deleteImage/$1');
        $routes->post('delete-image/(:num)', 'Admin\ListingController::deleteImage/$1');
        
        $routes->get('create-from-inquiry/(:num)', 'Admin\ListingController::createFromInquiry/$1');
    });

    // Inquiries
$routes->group('inquiries', function($routes) {
    $routes->get('/', 'Admin\InquiryController::index');
    $routes->get('view/(:num)', 'Admin\InquiryController::show/$1');
    $routes->post('update-status/(:num)', 'Admin\InquiryController::updateStatus/$1');
    $routes->get('delete/(:num)', 'Admin\InquiryController::delete/$1'); // <-- UNTUK HAPUS
});
});

// ========== API ROUTES (Future) ==========
$routes->group('api', function($routes) {
    // Nanti untuk frontend AJAX
});

