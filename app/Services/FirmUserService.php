<?php

namespace App\Services;
use App\Repositories\FirmUserRepo;
use App\Repositories\UserRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class FirmUserService
{
    use CommonService;
    public static function firmUserList(){

    }

    //增加企业用户
    public static function create($data){
        return FirmUserRepo::create($data);
    }

    //
    public static function update($id,$data){
        return FirmUserRepo::modify($id,$data);
    }

    public static function delete($id){
        return FirmUserRepo::delete($id);
    }

    public static function search($name){
        return UserRepo::getInfoByUserName($name);
    }

}