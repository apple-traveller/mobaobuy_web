<?php
namespace App\Services;
use App\Repositories\FirmStockRepo;
class FirmStockService
{
    use CommonService;
    public static function createFirmStock($data){
        return FirmStockRepo::create($data);
    }

}