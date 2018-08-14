<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request)
    {

        return $this->display('admin.index');
    }

    public function home()
    {
        return $this->display('admin.home');
    }


}
