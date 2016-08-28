<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

class IndexController extends AdminController
{
    public function index()
    {
        return view('index');
    }
}
