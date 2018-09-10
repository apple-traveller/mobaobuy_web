<?php

namespace App\Services\Web;
use App\Repositories\FirmPointsFlowRepository;
use App\Repositories\FirmRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FirmPointsFlowService
{
    use BaseService;

    //增加积分流水
    public static function createPoints($data){
        $data['change_time'] = Carbon::now();
        $firmPointsFlowInfo = FirmPointsFlowRepository::create($data);
        $pointsInfo = FirmRepository::updatePoints($data['firm_id'],$data['change_type'],$data['points']);
        if($firmPointsFlowInfo && $pointsInfo){
            return true;
        }
        return false;
    }
    //
}