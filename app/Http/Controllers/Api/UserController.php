<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Request;
class UserController extends ApiController
{
    //账号信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return $this->error('请传入用户id');
        }
        //查询用户信息和实名信息
        $user = UserService::getApiUserInfo($id);
        return $this->success($user,'success');
    }
}