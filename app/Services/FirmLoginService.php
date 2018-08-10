<?php

namespace App\Services;
use App\Repositories\FirmRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FirmLoginService extends BaseService
{
    //用户注册
    public static function firmRegister($data){
        $data['password'] = bcrypt($data['password']);
        $data['attorney_letter_fileImg'] = Storage::putFile('public', $data['attorney_letter_fileImg']);
        $data['reg_time'] = Carbon::now();
        return FirmRepository::create($data);
    }
}