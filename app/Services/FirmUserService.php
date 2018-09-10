<?php

namespace App\Services\Web;
use App\Repositories\FirmUserRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FirmUserService
{
    use BaseService;
    public static function firmUserList(){

    }

    //增加企业用户
    public static function create($data){
        return FirmUserRepository::create($data);
    }

    //
    public static function update($id,$data){
        return FirmUserRepository::modify($id,$data);
    }

    public static function delete($id){
        return FirmUserRepository::delete($id);
    }

    public static function search($name){
        return UserRepository::getInfoByUserName($name);
    }

}