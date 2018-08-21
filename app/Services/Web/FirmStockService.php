<?php

namespace App\Services\Web;
use App\Repositories\FirmStockRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Services\BaseService;

class FirmStockService extends BaseService
{
    public static function createFirmStock($data){
        return FirmStockRepository::create($data);
    }

}