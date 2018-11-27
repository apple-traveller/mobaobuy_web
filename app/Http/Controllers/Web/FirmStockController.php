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
            if(session('_curr_deputy_user')['is_self'] == 0 && !session('_curr_deputy_user')['can_stock_in']){
                return $this->error('无权访问');
            }
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
            if(session('_curr_deputy_user')['is_self'] == 0 && !session('_curr_deputy_user')['can_stock_out']){
                return $this->error('无权访问');
            }
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
            $stockInData['partner_name'] = $this->requestGetNotNull('partner_name','');
//            $stockInData['goods_name'] = $request->input('goods_name');
            $stockInData['number'] = $request->input('number', 1);
            $stockInData['flow_desc'] = $this->requestGetNotNull('flow_desc','');
            $stockInData['order_sn'] = $this->requestGetNotNull('order_sn','');
            $stockInData['price'] = $this->requestGetNotNull('price', 0);
            $stockInData['firm_id'] = session('_curr_deputy_user')['firm_id'];
            $stockInData['created_by'] = session('_web_user_id');
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
    public function stockFlowList(Request $request){
        $id = $request->input('id');
        $firm_id = session('_curr_deputy_user.firm_id');
        $firmStockInfo = FirmStockService::stockInfo($id, $firm_id);
        if(empty($firmStockInfo)){
            return $this->error('非法访问操作！');
        }
        $goods_id = $firmStockInfo['goods_id'];
        if($request->isMethod('get')){
            return $this->display('web.user.stock.waterList', compact('firmStockInfo'));
        }else{
            $page = $request->input('start', 0) / $request->input('length', 10) + 1;
            $page_size = $request->input('length', 10);
            $params = [
                'firm_id' => session('_curr_deputy_user.firm_id'),
                'goods_id' => $goods_id
            ];
            $rs_list = FirmStockService::stockFlowList($params, $page, $page_size);

            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $rs_list['total'], //数据总行数
                'recordsFiltered' => $rs_list['total'], //数据总行数
                'data' => $rs_list['list']
            ];
            return $this->success('', '', $data);
        }
    }

    //企业实时库存列表
    public function stockList(Request $request){
        if(session('_curr_deputy_user')['is_firm']){
            if(session('_curr_deputy_user')['is_self'] == 0 && !session('_curr_deputy_user')['can_stock_view']){
                return $this->error('无权访问');
            }
            $firm_id = session('_curr_deputy_user')['firm_id'];
            $page = $request->input('start', 0) / $request->input('length', 10) + 1;
            $page_size = $request->input('length', 10);
            $goods_name = $request->input('goods_name');
            $cat_id = $request->input('cat_id');
            if($request->isMethod('get')){
                $catInfo = FirmStockService::stockList($firm_id, $cat_id,$goods_name, $page, $page_size,0);
                return $this->display('web.user.stock.list',compact('catInfo'));
            }else{
                $rs_list = FirmStockService::stockList($firm_id,$cat_id,$goods_name, $page, $page_size,1);
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
            if(session('_curr_deputy_user')['is_self'] == 0 && !session('_curr_deputy_user')['can_stock_out']){
                return $this->error('无权访问');
            }
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
    public function stockInfo(Request $request){
        if(session('_curr_deputy_user')['is_firm']){
                $id = $request->input('id');
                $firm_id = session('_curr_deputy_user.firm_id');
                $firmStockInfo = FirmStockService::stockInfo($id, $firm_id);
                return $this->success('', '', $firmStockInfo);
        }
        return $this->error('非法访问');
    }

    //出库更新
    public function curStockSave(Request $request){
        if(session('_curr_deputy_user')['is_firm']){
            $currStockOut = [];
            $currStockOut['id'] = $request->input('id');
            $currStockOut['order_sn'] = $this->requestGetNotNull('order_sn', '');
            $currStockOut['partner_name'] = $this->requestGetNotNull('partner_name', '');
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

    //出入库检索供应商名称
    public function searchPartnerName(Request $request){
        $id = session('_web_user_id');
        $partnerName = $this->requestGetNotNull('partnerName','');
        $is_type = $request->input('is_type');


        try{
            $partnerNameInfo = FirmStockService::searchPartnerName($partnerName,$id,$is_type);
            return $this->success('','',$partnerNameInfo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
