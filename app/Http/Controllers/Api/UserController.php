<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class UserController extends Controller
{
    //账号信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return $this->result('',400,'请传入用户id');
        }
        //查询用户信息和实名信息
        $user = UserService::getApiUserInfo($id);
        return $this->result($user,200,'success');
    }
}