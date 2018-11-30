<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Services\FirmStockService;
class FirmStockController extends ApiController
{
    //入库记录列表
    public function firmStockIn(Request $request){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_self'] == 0 && !$deputy_user['can_stock_in']){
            return $this->error('无权访问');
        }
        if($deputy_user['is_firm']) {
            try{
                $page = $request->input('currpage', 1);
                $page_size = $request->input('pagesize', 10);
                $params = [
                    'firm_id' => $deputy_user['firm_id'],
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
                return $this->success($data,'');
            }catch (\Exception $e){
                $data = [
                    'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                    'recordsTotal' => 0, //数据总行数
                    'recordsFiltered' => 0, //数据总行数
                    'data' => []
                ];
                return $this->error( $data,'success');
            }
        }
        return $this->error('非法访问');
    }

    //出库记录列表
    public function firmStockOut(Request $request,$goodsName='',$beginTime='',$endTime=''){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_self'] == 0 && !$deputy_user['can_stock_out']){
            return $this->error('无权访问');
        }
        if($deputy_user['is_firm']) {
            $page = $request->input('currpage', 1);
            $page_size = $request->input('pagesize', 10);
            $params = [
                'firm_id' => $deputy_user['firm_id'],
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
            return $this->success( $data,'success');
        }
        return $this->error('非法访问');
    }

    //新增入库记录
    public function addFirmStock(Request $request){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm']){
            $stockInData = [];
            $stockInData['goods_id'] = $request->input('goods_id');
            $stockInData['created_by'] = $this->getUserID($request);
            $stockInData['partner_name'] = $this->requestGetNotNull('partner_name','');
            $stockInData['goods_name'] = $request->input('goods_name');
            $stockInData['number'] = $request->input('number', 1);
            $stockInData['flow_desc'] = $this->requestGetNotNull('flow_desc','');
            $stockInData['order_sn'] = $this->requestGetNotNull('order_sn','');
            $stockInData['price'] = $this->requestGetNotNull('price', 0);
            $stockInData['firm_id'] = $deputy_user['firm_id'];
            $stockInData['flow_type'] = 2;
            try {
                FirmStockService::createFirmStock($stockInData);
                return $this->success('','success');
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return $this->error('非法访问');
    }

    //入库检索商品名称
    public function searchGoodsName(Request $request){
        $goodsName = $request->input('goodsName');
        if(empty($goodsName)){
            return $this->error('缺少参数，goodsName');
        }
        try{
            $goodsInfo = FirmStockService::searchGoodsName($goodsName);
            $result = [];
            foreach($goodsInfo as $val){
                $result[] = $val['goods_name'];
            }
            return $this->success($result,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //出入库检索供应商名称
    public function searchPartnerName(Request $request){
        $id = $this->getUserID($request);
        $partnerName = $this->requestGetNotNull('partnerName','');
        $is_type = $request->input('is_type');
        if(empty($id)){
            return $this->error('缺少参数，id');
        }
        try{
            $partnerNameInfo = FirmStockService::searchPartnerName($partnerName,$id,$is_type);
            return $this->success($partnerNameInfo,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //企业库存商品流水
    public function stockFlowList(Request $request){
        $id = $request->input('id');
        $firm_id = $this->getDeputyUserInfo($request)['firm_id'];
        $firmStockInfo = FirmStockService::stockInfo($id, $firm_id);
        if(empty($firmStockInfo)){
            return $this->error('非法访问操作！');
        }
        if(empty($id)){
            return $this->error('缺少参数，id');
        }
        $goods_id = $firmStockInfo['goods_id'];
        $page = $request->input('currpage', 0);
        $page_size = $request->input('pagesize', 10);
        $params = [
            'firm_id' => $firm_id,
            'goods_id' => $goods_id
        ];
        $rs_list = FirmStockService::stockFlowList($params, $page, $page_size);
        foreach($rs_list['list'] as $k=>$v){
            if($v['flow_type']==1){
                $rs_list['list'][$k]['flow_type'] = '平台采购入库';
            }elseif($v['flow_type']==2){
                $rs_list['list'][$k]['flow_type'] = '其他入库';
            }else{
                $rs_list['list'][$k]['flow_type'] = '销售出库';
            }
        }

        $data = [
            'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
            'recordsTotal' => $rs_list['total'], //数据总行数
            'recordsFiltered' => $rs_list['total'], //数据总行数
            'data' => $rs_list['list']
        ];
        return $this->success( $data,'success');
    }

    //企业实时库存列表
    public function stockList(Request $request){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm']){
            $firm_id = $deputy_user['firm_id'];
            $page = $request->input('currpage', 0);
            $page_size = $request->input('pagesize', 10);
            $goods_name = $request->input('goods_name');
            $cat_id = $request->input('cat_id');
            $rs_list = FirmStockService::stockList($firm_id,$cat_id,$goods_name, $page, $page_size,1);
            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $rs_list['total'], //数据总行数
                'recordsFiltered' => $rs_list['total'], //数据总行数
                'data' => $rs_list['list']
            ];
            return $this->success($data,'success');
        }

        return $this->error('非法访问');
    }

    //企业可出库列表
    public function canStockOut(Request $request){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm']){
            $page = $request->input('currpage', 0);
            $page_size = $request->input('pagesize', 10);
            $firm_id = $deputy_user['firm_id'];
            $goods_name = $request->input('goods_name');
            $rs_list = FirmStockService::canStockOut($firm_id, $goods_name, $page, $page_size);
            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $rs_list['total'], //数据总行数
                'recordsFiltered' => $rs_list['total'], //数据总行数
                'data' => $rs_list['list']
            ];
            return $this->success($data,'success');
        }
        return $this->error('非法访问');
    }


    //获取单条可出库数据
    public function stockInfo(Request $request){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm']){
                $id = $request->input('id');
                $firm_id = $deputy_user['firm_id'];
                $firmStockInfo = FirmStockService::stockInfo($id, $firm_id);
                return $this->success($firmStockInfo,'success');
        }
        return $this->error('非法访问');
    }

    //出库更新
    public function curStockSave(Request $request){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm']){
            $currStockOut = [];
            $currStockOut['id'] = $request->input('id');
            $currStockOut['order_sn'] = $this->requestGetNotNull('order_sn', '');
            $currStockOut['partner_name'] = $this->requestGetNotNull('partner_name', '');
            $currStockOut['currStockNum'] = $this->requestGetNotNull('currStockNum', 0);
            $currStockOut['flow_desc'] = $this->requestGetNotNull('flow_desc', '');
            $currStockOut['firm_id']= $deputy_user['firm_id'];
            $currStockOut['created_by'] = $this->getUserID($request);
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


}
