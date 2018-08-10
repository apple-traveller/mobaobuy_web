<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserController extends Controller
{
    //用户列表
    public function list()
    {
        return $this->display('admin.user.list');
    }

}
