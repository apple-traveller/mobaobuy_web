<?php

namespace App\Services\Web;
use App\Repositories\FirmStockRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Services\CommonService;
class FirmStockService
{
    use CommonService;
    public static function createFirmStock($data){
        return FirmStockRepo::create($data);
    }

}