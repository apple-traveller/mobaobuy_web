<?php

namespace App\Services\Web;
use App\Repositories\FirmStockRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Services\CommonService;

class FirmStockService extends CommonService
{
    public static function createFirmStock($data){
        return FirmStockRepo::create($data);
    }

}