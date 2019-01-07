<?php

namespace App\Http\Controllers\Api;
use App\Services\OrderContractService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderContractController extends ApiController
{
    public function checkOrderContract(Request $request){
        $orderContractInfo = [];
        $orderContractInfo['from_id'] = $this->getUserID($request);
        $orderContractInfo['contract'] = $request->input('contract');
        $orderContractInfo['order_id'] = $request->input('order_id');
        $orderContractInfo['equipment']  = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : '';
        $orderContractInfo['ip'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '';
        try{
            OrderContractService::checkOrderContract($orderContractInfo);
            return $this->success('',200);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
