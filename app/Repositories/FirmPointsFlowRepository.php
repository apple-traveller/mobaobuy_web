<?php

namespace App\Repositories;

class FirmPointsFlowRepository
{
    use CommonRepository;

    public static function getPointsByFirmid($firm_id)
    {
        $model = self::getBaseModel();
        $info = $model::where('firm_id',$firm_id)->paginate(10);
        if($info){
            return $info;
        }
        return [];
    }



}
