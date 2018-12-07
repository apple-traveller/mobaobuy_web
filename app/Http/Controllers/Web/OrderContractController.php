<?php

namespace App\Http\Controllers\Web;
use App\Services\OrderContractService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderContractController extends Controller
{
    public function checkOrderContract(Request $request){
        $orderContractInfo = [];
        $orderContractInfo['from_id'] = session('_web_user_id');
        $orderContractInfo['contract'] = $request->input('contract');
        $orderContractInfo['order_id'] = $request->input('orderno');
        $orderContractInfo['equipment']  = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : '';
        $orderContractInfo['ip'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '';
        try{
            OrderContractService::checkOrderContract($orderContractInfo);
            return $this->success('上传成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
