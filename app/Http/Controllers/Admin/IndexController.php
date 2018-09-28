<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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

    public function clear(){
        Cache::flush();
    }
}
