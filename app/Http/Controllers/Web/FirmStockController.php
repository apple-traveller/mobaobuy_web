<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\FirmStockService;



class FirmStockController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function createFirmStock(Request $request){
        $data = $request->all();
        try{
            FirmStockService::createFirmStock($data);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
        FirmStockService::createFirmStock($data);
    }
}
