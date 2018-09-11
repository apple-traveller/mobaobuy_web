<?php

namespace App\Services;

use App\Repositories\FirmBlacklistRepo;
use App\Repositories\FirmRepo;
use Illuminate\Support\Facades\Storage;

class FirmLoginService
{
    use CommonService;
    //用户注册
    public static function firmRegister($data){
        //查找黑名单表是否存在
        $firmBlack = FirmBlacklistRepo::getInfoByFields(['firm_name'=>$data['user_name']]);
        if($firmBlack){
            return 'error';
        }

        $data['password'] = bcrypt($data['password']);
        $filePath = Storage::putFile('public', $data['attorney_letter_fileImg']);
        $filePath = explode('/',$filePath);
        $data['attorney_letter_fileImg'] = '/storage/'.$filePath[1];
        $data['reg_time'] = Carbon::now();
        return FirmRepo::create($data);
    }
}