<?php

namespace App\Http\Controllers\Web;
use App\Repositories\FirmStockFlowRepo;
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
        $goods_name = $request->input('goods_name');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        if($goods_name && $start_time &&$end_time){
            $firmstock = FirmStockService::search($goods_name,$start_time,$end_time);
        }else{
            $firmstock = FirmStockService::firmStockIn(session('_web_info')['id']);
        }
        return view('default.web.firm.stockIn',['firmstock'=>$firmstock]);
    }

    //出库记录列表
    public function firmStockOut(Request $request){
        $firmstock = FirmStockService::firmStockOut(session('_web_info')['id']);
        return $this->display('web.firm.stockOut',compact('firmstock'));
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
            $message = [
                'required' => ':attribute 不能为空'
            ];
            $attributes = [
                'partner_name'=>'业务伙伴名称',
                'goods_name'=>'商品名称',
                'order_sn'=>'订单号',
                'number'=>'数量',
                'flow_desc'=>'描述'
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
