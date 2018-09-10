<?php

namespace App\Repositories;

class FirmUserRepo
{
    use CommonRepo;

    //根据firmid获取企业用户
    public static function getFirmUser($firm_id)
    {
        $model = self::getBaseModel();
        $info = $model::where('firm_id',$firm_id)->paginate(10);
        if($info){
            return $info;
        }
        return [];
    }
}
