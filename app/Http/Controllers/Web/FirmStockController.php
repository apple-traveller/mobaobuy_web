<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FirmStockService;




class FirmStockController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    //入库记录列表
    public function createFirmStock(Request $request){
        if($request->isMethod('get')){
            $firmstock = FirmStockService::firmStockIn(session('_web_info')['id']);
            return $this->display('web.xx',compact('firmstock'));
        }

    }

    //出库记录列表
    public function firmStockOut(Request $request){
        $firmstock = FirmStockService::firmStockOut(session('_web_info')['id']);
        return $this->display('web.xx',compact('firmstock'));
    }

    //新增出库记录
    public function addFirmSotckOut(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.xx');
        }else{
            $rule = [
                'partner_name'=>'nullable',
                'goods_name'=>'required',
                'order_sn'=>'nullable',
                'number'=>'required|numeric',
                'flow_desc'=>'nullable'
            ];
            $data = $this->validate($request,$rule);
            $data['firm_id'] = session('_web_info')['id'];
            try{
                FirmStockService::createFirmStock($data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
    }

    //新增入库记录
    public function addFirmStock(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.xx');
        }else{
            $rule = [
                'partner_name'=>'nullable',
                'goods_name'=>'required',
                'order_sn'=>'nullable',
                'number'=>'required|numeric',
                'flow_desc'=>'nullable'
            ];
            $data = $this->validate($request,$rule);
            $data['firm_id'] = session('_web_info')['id'];
            try{
                FirmStockService::createFirmStock($data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }

    }

    //企业库存商品流水
    public function stockFlowList(){
        $stockFlowInfo = FirmStockService::stockFlowList(session('_web_info')['id']);
        return $this->display('web.x',compact('stockFlowInfo'));
    }

    //企业实时库存列表
    public function stockList(){
        $firmStock = FirmStockService::stockList(session('_web_info')['id']);
        return $this->display('web',compact('firmStock'));
    }
}
