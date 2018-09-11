<?php

namespace App\Services;
use App\Repositories\FirmPointsFlowRepo;
use App\Repositories\FirmRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class FirmPointsFlowService
{
    use CommonService;

    //增加积分流水
    public static function createPoints($data){
        $data['change_time'] = Carbon::now();
        $firmPointsFlowInfo = FirmPointsFlowRepo::create($data);
        $pointsInfo = FirmRepo::updatePoints($data['firm_id'],$data['change_type'],$data['points']);
        if($firmPointsFlowInfo && $pointsInfo){
            return true;
        }
        return false;
    }
    //
}