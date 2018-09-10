<?php

<<<<<<< HEAD:app/Services/FirmLoginService.php
namespace App\Services;
use App\Repositories\FirmBlacklistRepository;
use App\Repositories\FirmRepository;
=======
namespace App\Services\Web;
use App\Repositories\FirmBlacklistRepo;
use App\Repositories\FirmRepo;
use App\Services\CommonService;
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/Web/FirmLoginService.php
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

<<<<<<< HEAD:app/Services/FirmLoginService.php
class FirmLoginService
=======
class FirmLoginService extends CommonService
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/Web/FirmLoginService.php
{
    use BaseService;
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