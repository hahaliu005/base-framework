<?php
namespace App\Http\Controllers\Portal;

use App\Http\Controllers\PortalController;

class IndexController extends PortalController
{
    public function index()
    {
        return view('index');
    }
}
