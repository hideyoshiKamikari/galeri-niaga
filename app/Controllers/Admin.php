<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        // AuthFilter otomatis ngecek session & role
        return view('admin/dashboard');
    }
}