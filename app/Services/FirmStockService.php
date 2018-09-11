<?php

namespace App\Services;
use App\Repositories\FirmStockRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
class FirmStockService
{
    use CommonService;
    public static function createFirmStock($data){
        return FirmStockRepo::create($data);
    }

}