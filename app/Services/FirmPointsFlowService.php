<?php

namespace App\Services\Web;
use App\Repositories\FirmPointsFlowRepo;
use App\Repositories\FirmRepo;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

<<<<<<< HEAD:app/Services/FirmPointsFlowService.php
class FirmPointsFlowService
=======
class FirmPointsFlowService extends CommonService
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/Web/FirmPointsFlowService.php
{
    use BaseService;

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