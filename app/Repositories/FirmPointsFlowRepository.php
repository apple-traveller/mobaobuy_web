<?php

namespace App\Repositories;

class FirmPointsFlowRepository
{
    use CommonRepository;

    //根据firm_id查询企业积分
    public  static function getPointByfirmId($firmid)
    {
        $model = self::getBaseModel();
        $info = $model::where("firm_id",$firmid)->select('points')->first();
        if($info){
            return $info->toArray();
        }
        return "";
    }

}
