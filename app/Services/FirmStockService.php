<?php

namespace App\Services\Web;
use App\Repositories\FirmStockRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Services\CommonService;

<<<<<<< HEAD:app/Services/FirmStockService.php
class FirmStockService
=======
class FirmStockService extends CommonService
>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/Web/FirmStockService.php
{
    use BaseService;
    public static function createFirmStock($data){
        return FirmStockRepo::create($data);
    }

}