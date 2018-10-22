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
    public function FirmStockIn(Request $request){
        if(session('_curr_deputy_user')['is_firm']) {
            if ($request->isMethod('get')) {
                return $this->display('web.user.stock.stockIn');
            } else {
                try{
                    $page = $request->input('start', 0) / $request->input('length', 10) + 1;
                    $page_size = $request->input('length', 10);
                    $params = [
                        'firm_id' => session('_curr_deputy_user')['firm_id'],
                        'goods_name' => $request->input('goods_name'),
                        'begin_time' => $request->input('begin_time'),
                        'end_time' => $request->input('end_time')
                    ];
                    $rs_list = FirmStockService::firmStockIn($params, $page, $page_size);

                    $data = [
                        'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                        'recordsTotal' => $rs_list['total'], //数据总行数
                        'recordsFiltered' => $rs_list['total'], //数据总行数
                        'data' => $rs_list['list']
                    ];
                    return $this->success('', '', $data);
                }catch (\Exception $e){
                    $data = [
                        'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                        'recordsTotal' => 0, //数据总行数
                        'recordsFiltered' => 0, //数据总行数
                        'data' => []
                    ];
                    return $this->success('', '', $data);
                }

            }
        }
        return $this->error('非法访问');
    }

    //出库记录列表
    public function firmStockOut(Request $request,$goodsName='',$beginTime='',$endTime=''){
        if(session('_curr_deputy_user')['is_firm']) {
            if ($request->isMethod('get')) {
                return $this->display('web.user.stock.stockOut');
            } else {
                $page = $request->input('start', 0) / $request->input('length', 10) + 1;
                $page_size = $request->input('length', 10);
                $params = [
                    'firm_id' => session('_curr_deputy_user')['firm_id'],
                    'goods_name' => $request->input('goods_name'),
                    'begin_time' => $request->input('begin_time'),
                    'end_time' => $request->input('end_time')
                ];
                $rs_list = FirmStockService::firmStockOut($params, $page, $page_size);

                $data = [
                    'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                    'recordsTotal' => $rs_list['total'], //数据总行数
                    'recordsFiltered' => $rs_list['total'], //数据总行数
                    'data' => $rs_list['list']
                ];
                return $this->success('', '', $data);
            }
        }
        return $this->error('非法访问');
    }

    //新增入库记录
    public function addFirmStock(Request $request){
        if(session('_curr_deputy_user')['is_firm']) {
            $stockInData = [];
            $stockInData['goods_id'] = $request->input('goods_id');
            $stockInData['created_by'] = session('_web_user_id');
            $stockInData['partner_name'] = $this->requestGetNotNull('partner_name','');
            $stockInData['goods_name'] = $request->input('goods_name');
            $stockInData['number'] = $request->input('number', 1);
            $stockInData['flow_desc'] = $this->requestGetNotNull('flow_desc','');
            $stockInData['order_sn'] = $this->requestGetNotNull('order_sn','');
            $stockInData['price'] = $this->requestGetNotNull('price', 0);
            $stockInData['firm_id'] = session('_curr_deputy_user')['firm_id'];
            $stockInData['flow_type'] = 2;
            try {
                FirmStockService::createFirmStock($stockInData);
                return $this->success();
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return $this->error('非法访问');
    }

    //企业库存商品流水
    public function stockFlowList(){
        $stockFlowInfo = FirmStockService::stockFlowList(session('_web_info')['id']);
        return $this->display('web.firm.stockFlowList',compact('stockFlowInfo'));
    }

    //企业实时库存列表
    public function stockList(Request $request){
        if(session('_curr_deputy_user')['is_firm']){
            if($request->isMethod('get')){
                return $this->display('web.user.stock.list');
            }else{
                $page = $request->input('start', 0) / $request->input('length', 10) + 1;
                $page_size = $request->input('length', 10);
                $firm_id = session('_curr_deputy_user')['firm_id'];
                $goods_name = $request->input('goods_name');
                $rs_list = FirmStockService::stockList($firm_id, $goods_name, $page, $page_size);

                $data = [
                    'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                    'recordsTotal' => $rs_list['total'], //数据总行数
                    'recordsFiltered' => $rs_list['total'], //数据总行数
                    'data' => $rs_list['list']
                ];
                return $this->success('', '', $data);
            }
        }

        return $this->error('非法访问');
    }

    //企业可出库列表
    public function canStockOut(Request $request){
        if(session('_curr_deputy_user')['is_firm']){
            if($request->isMethod('get')){
                return $this->display('web.user.stock.canStockOut');
            }else{
                $page = $request->input('start', 0) / $request->input('length', 10) + 1;
                $page_size = $request->input('length', 10);
                $firm_id = session('_curr_deputy_user')['firm_id'];
                $goods_name = $request->input('goods_name');
                $rs_list = FirmStockService::canStockOut($firm_id, $goods_name, $page, $page_size);

                $data = [
                    'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                    'recordsTotal' => $rs_list['total'], //数据总行数
                    'recordsFiltered' => $rs_list['total'], //数据总行数
                    'data' => $rs_list['list']
                ];
                return $this->success('', '', $data);
            }
        }

        return $this->error('非法访问');
    }

    //获取单条可出库数据
    public function curCanStock(Request $request){
        if(session('_curr_deputy_user')['is_firm']){
                $id = $request->input('id');
//                $firm_id = session('_curr_deputy_user')['firm_id'];
                $firmStockInfo = FirmStockService::curCanStock($id);
                return $this->success('', '', $firmStockInfo);
        }
        return $this->error('非法访问');
    }

    //出库更新
    public function curStockSave(Request $request){
        if(session('_curr_deputy_user')['is_firm']){
            $currStockOut = [];
            $currStockOut['id'] = $request->input('id');
            $currStockOut['currStockNum'] = $this->requestGetNotNull('currStockNum', 0);
            $currStockOut['flow_desc'] = $this->requestGetNotNull('flow_desc', '');
            $currStockOut['firm_id']= session('_curr_deputy_user')['firm_id'];
            $currStockOut['created_by'] = session('_web_user_id');
            $currStockOut['price'] = $this->requestGetNotNull('price', '0');
            try{
                FirmStockService::createFirmStockOut($currStockOut);
                return $this->success();
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
        return $this->error('非法访问');
    }

    //入库检索商品名称
    public function searchGoodsName(Request $request){
        $goodsName = $request->input('goodsName');
        try{
            $goodsInfo = FirmStockService::searchGoodsName($goodsName);
            return $this->success('','',$goodsInfo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }
}
