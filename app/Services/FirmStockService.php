<?php
namespace App\Services;
use App\Repositories\FirmStockFlowRepo;
use App\Repositories\FirmStockRepo;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\UserRepo;
use Carbon\Carbon;
class FirmStockService
{
    use CommonService;

    //新增入库记录
    public static function createFirmStock($data){
        $goodsInfo = GoodsRepo::getInfo($data['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('商品信息有误');
        }
        $data['goods_name']  = $goodsInfo['goods_full_name'];
        $data['flow_time'] = Carbon::now();
        $insertData = [];
        $insertData['firm_id'] = $data['firm_id'];
        $insertData['goods_id'] = $data['goods_id'];
        $result = FirmStockRepo::getInfoByFields($insertData);

        //如果库存表里有此商品就更新
        if($result){
            try{
                self::beginTransaction();
                FirmStockFlowRepo::create($data);
                FirmStockRepo::modify($result['id'],['number'=>$result['number'] + $data['number']]);
                self::commit();
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }
        }else{
            //没有则新增
            $stockData = [];
            $stockData['firm_id'] = $data['firm_id'];
            $stockData['goods_id'] = $data['goods_id'];
            $stockData['goods_name'] = $goodsInfo['goods_full_name'];
            $stockData['number'] = $data['number'];
            try{
                self::beginTransaction();
                FirmStockFlowRepo::create($data);
                FirmStockRepo::create($stockData);
                self::commit();
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }
        }
    }
    //出库
    public static function createFirmStockOut($data){
        $currStockInfo = FirmStockRepo::getInfo($data['id']);
        if(empty($currStockInfo)){
            self::throwBizError('库存商品不存在');
        }
        $firmStockData = [];
        $firmStockData['flow_time'] = Carbon::now();
        $firmStockData['flow_type'] = 3 ;
        $firmStockData['order_sn'] = $data['order_sn'];
        $firmStockData['partner_name'] = $data['partner_name'];
        $firmStockData['number'] = $data['currStockNum'];
        $firmStockData['firm_id'] = $data['firm_id'];
        $firmStockData['flow_desc'] = $data['flow_desc'];
        $firmStockData['price'] = $data['price'];
        $firmStockData['created_by'] = $data['created_by'];
        $firmStockData['goods_name'] = $currStockInfo['goods_name'];
        $firmStockData['goods_id'] = $currStockInfo['goods_id'];

        //更新库存表，新增库存流水记录
        if($currStockInfo){
            if($currStockInfo['number'] < $data['currStockNum']){
                self::throwBizError('出库数量不能大于库存数量！');
            }

            try{
                self::beginTransaction();
                FirmStockFlowRepo::create($firmStockData);
                FirmStockRepo::modify($data['id'],['number'=>$currStockInfo['number'] - $data['currStockNum']]);
                self::commit();
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }
        }
    }

    public static function modifyFirmStockOut($data)
    {
        $currStockInfo = FirmStockFlowRepo::getInfo($data['id']);
        if(empty($currStockInfo)){
            self::throwBizError('库存商品不存在');
        }
        $firmStockData = [];
        $firmStockData['flow_time'] = Carbon::now();
        $firmStockData['flow_type'] = 3 ;
        $firmStockData['order_sn'] = $data['order_sn'];
        $firmStockData['partner_name'] = $data['partner_name'];
        $firmStockData['number'] = $data['currStockNum'];
        $firmStockData['firm_id'] = $data['firm_id'];
        $firmStockData['flow_desc'] = $data['flow_desc'];
        $firmStockData['price'] = $data['price'];
        $firmStockData['created_by'] = $data['created_by'];
        $firmStockData['goods_name'] = $currStockInfo['goods_name'];
        $firmStockData['goods_id'] = $currStockInfo['goods_id'];
        try{
            self::beginTransaction();
            FirmStockFlowRepo::modify($currStockInfo['id'],$firmStockData);
            $firm_stock = FirmStockRepo::getInfoByFields(['goods_id'=>$firmStockData['goods_id'],'firm_id'=>$data['firm_id']]);
            FirmStockRepo::modify($data['id'],['number'=>$firm_stock['number'] - $data['currStockNum']]);
            self::commit();
            return true;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    //入库记录列表
    public static function firmStockIn($params, $page = 1 ,$pageSize=10){
        $condition = [];
        $condition['firm_id'] = $params['firm_id'];
        if(!empty($params['goods_name'])){
            $condition['goods_name'] = '%'.$params['goods_name'].'%';
        }
        if(!empty($params['begin_time'])){
            $condition['flow_time|>='] = $params['begin_time'] . ' 00:00:00';
        }
        if(!empty($params['end_time'])){
            $condition['flow_time|<='] = $params['end_time'] . ' 23:59:59';
        }
        $condition['flow_type'] = '1|2';
        $firmStockFlowInfo =  FirmStockFlowRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['flow_time'=>'desc']],$condition);
        if(!empty($firmStockFlowInfo['list'])){
            foreach ($firmStockFlowInfo['list'] as $k=>$v){
                $goodsInfo = GoodsRepo::getInfo($v['goods_id']);
                $firmStockFlowInfo['list'][$k]['number_full'] = $v['number'].$goodsInfo['unit_name'];
                $firmStockFlowInfo['list'][$k]['price_full'] = '￥'.$v['price'].'/'.$goodsInfo['unit_name'];
            }
        }
        return $firmStockFlowInfo;
    }

    //出库记录列表
    public static function firmStockOut($params, $page = 1 ,$pageSize=10){
        $condition = [];
        $condition['firm_id'] = $params['firm_id'];
        if(!empty($params['goods_name'])){
            $condition['goods_name'] = '%'.$params['goods_name'].'%';
        }
        if(!empty($params['begin_time'])){
            $condition['flow_time|>='] = $params['begin_time'] . ' 00:00:00';
        }
        if(!empty($params['end_time'])){
            $condition['flow_time|<='] = $params['end_time'] . ' 23:59:59';
        }

        $condition['flow_type'] = 3;
        $firmStockFlowOutfo = FirmStockFlowRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['flow_time'=>'desc']],$condition);
        if(!empty($firmStockFlowOutfo['list'])){
            foreach ($firmStockFlowOutfo['list'] as $k=>$v){
                $goodsInfo = GoodsRepo::getInfo($v['goods_id']);
                $firmStockFlowOutfo['list'][$k]['number_full'] = $v['number'].$goodsInfo['unit_name'];
                $firmStockFlowOutfo['list'][$k]['price_full'] = '￥'.$v['price'].'/'.$goodsInfo['unit_name'];
                $stock_info = FirmStockRepo::getInfoByFields(['goods_id'=>$v['goods_id'],'firm_id'=>$v['firm_id']]);
                $firmStockFlowOutfo['list'][$k]['stock_id'] = $stock_info['id'];
                $firmStockFlowOutfo['list'][$k]['stock_num'] = $stock_info['number'];//库存数量
            }
        }
        return $firmStockFlowOutfo;
    }

    //库存记录列表
    public static function stockList($firm_id,$cat_id,$goods_name, $page = 1 ,$pageSize=10,$method){
        $condition = [];
        if($firm_id > 0){
            $condition['firm_id'] = $firm_id;
        }
        if(!empty($goods_name)){
            $condition['goods_name'] = '%'.$goods_name.'%';
        }
        $firmStockInfo = FirmStockRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['number'=>'desc']],$condition);
        $catInfo = [];
        $catName = [];
        foreach($firmStockInfo['list'] as $k=>$v){
            $goodsInfo = GoodsRepo::getInfo($v['goods_id']);
            $firmStockInfo['list'][$k]['number'] .= $goodsInfo['unit_name'];

            $goodsCatInfo = GoodsCategoryRepo::getInfo($goodsInfo['cat_id']);
            if(empty($goodsCatInfo)){
                self::throwBizError('找不到对应的分类');
            }

            //顶部多选框分类名
            if(!in_array($goodsCatInfo['id'],$catInfo)){
//                $catInfo[$k]['cat_name'] = $goodsCatInfo['cat_name'];
//                $catInfo[$k]['cat_id'] = $goodsCatInfo['id'];
                $catName[] = $goodsCatInfo['cat_name'];
                $catInfo[] = $goodsCatInfo['id'];
            }

            if(!empty($cat_id)){
                //分类塞选数据
                if(in_array($goodsInfo['cat_id'],$cat_id)){
                    $firmStockInfo['list'][$k]['cat_name'] = $goodsCatInfo['cat_name'];
                }else{
                    unset($firmStockInfo['list'][$k]);
                }
            }else{
                //全部数据
                $firmStockInfo['list'][$k]['cat_name'] =  $goodsCatInfo['cat_name'];
            }
        }

        //重置list键名
        $resetArr = [];
        foreach($firmStockInfo['list'] as $v){
            $resetArr[] = $v;
        }
        $firmStockInfo['list'] = $resetArr;

        //post返回table数据
        if($method){
            return $firmStockInfo;
        }
        //get返回分类列表
        return ['catName'=>$catName,'catInfo'=>$catInfo];
    }

    //出库记录详情
    public static function getFirmStockDetail($id)
    {
        $flow_info = FirmStockFlowRepo::getInfo($id);
        return $flow_info;
    }



    //库存商品流水
    public static function stockFlowList($params, $page = 1, $pageSize = 10){
        $condition = [];
        $condition['firm_id'] = $params['firm_id'];
        $condition['goods_id'] = $params['goods_id'];

        return FirmStockFlowRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['flow_time'=>'desc']],$condition);
    }

    //可出库列表
    public static function canStockOut($firm_id, $goods_name, $page = 1 ,$pageSize=10){
        $condition = [];
        if($firm_id > 0){
            $condition['firm_id'] = $firm_id;
        }
        if(!empty($goods_name)){
            $condition['goods_name'] = '%'.$goods_name.'%';
        }
        $condition['number|>'] = '0';
        return FirmStockRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['number'=>'desc']],$condition);
    }

    //单条可出库
    public static function stockInfo($id, $firm_id=0){
        if($firm_id > 0){
            return FirmStockRepo::getInfoByFields(['id'=>$id, 'firm_id'=>$firm_id]);
        }else{
            return FirmStockRepo::getInfo($id);
        }

    }

    //入库检索商品名称
    public static function searchGoodsName($goodsName){
        $condition = [];
        $condition['goods_full_name'] = '%'.$goodsName.'%';
        return GoodsRepo::getList([],$condition);
    }

    //入库检索供应商名称
    public static function searchPartnerName($partnerName,$id,$is_type){
        if($is_type == 2){
            $flow_type = 2;
            if($partnerName){
                //输入输入框检索
                $condition = [];
                $condition['partner_name'] = '%'.$partnerName.'%';
                $condition['firm_id'] = $id;
                $condition['flow_type'] = $flow_type;
                return FirmStockFlowRepo::getList([],$condition);
            }else{
                //点击输入框检索
                $condition = [];
                $condition['firm_id'] = $id;
                $condition['flow_type'] = $flow_type;
                $firmStockFlowInfo = FirmStockFlowRepo::getList([],$condition);
                foreach($firmStockFlowInfo as $k=>$v){
                    if(!$v['partner_name']){
                        unset($firmStockFlowInfo[$k]);
                    }
                }
                return $firmStockFlowInfo;
            }
        }elseif($is_type == 3){
            $flow_type = 3;
            if($partnerName){
                //输入输入框检索
                $condition = [];
                $condition['partner_name'] = '%'.$partnerName.'%';
                $condition['firm_id'] = $id;
                $condition['flow_type'] = $flow_type;
                return FirmStockFlowRepo::getList([],$condition);
            }else{
                //点击输入框检索
                $condition = [];
                $condition['firm_id'] = $id;
                $condition['flow_type'] = $flow_type;
                $firmStockFlowInfo = FirmStockFlowRepo::getList([],$condition);
                foreach($firmStockFlowInfo as $k=>$v){
                    if(!$v['partner_name']){
                        unset($firmStockFlowInfo[$k]);
                    }
                }
                return $firmStockFlowInfo;
            }
        }else{
            self::throwBizError('没有对应的出入库信息');
        }
    }

    /**
     * 后台
     */
    public static function getFirmStocksByFirmId($pager,$condition)
    {
        $stocks = FirmStockRepo::getListBySearch($pager,$condition);
        foreach ($stocks['list'] as $k=>$v) {
            $user = UserRepo::getList([],['id'=>$v['firm_id']],['nick_name'])[0];
            $stocks['list'][$k]['nick_name']=$user['nick_name'];
        }
        return $stocks;
    }


    //库存流水
    public static function getStockFlowList($pager,$condition)
    {
        $stockFlow = FirmStockFlowRepo::getListBySearch($pager,$condition);
        foreach($stockFlow['list'] as $k=>$v){
            if($v['flow_type']==1){
                $stockFlow['list'][$k]['flow_type'] = "平台购物入库";
            }elseif($v['flow_type']==2){
                $stockFlow['list'][$k]['flow_type'] = "其它入库";
            }else{
                $stockFlow['list'][$k]['flow_type'] = "库存出库";
            }
        }
        return $stockFlow;
    }

    /**
     *
     * modify
     * @param $id
     * @param $data
     * @param int $count
     * @return bool
     */
    public static function in_modify($id,$data,$count = 0)
    {
        self::beginTransaction();
        FirmStockFlowRepo::modify($id,$data);
        if($count != 0){//数量没有发生变化，不用改变库存
            $info = FirmStockRepo::getInfoByFields(['goods_id'=>$data['goods_id'],'firm_id'=>$data['firm_id']]);
            FirmStockRepo::modify($info['id'],['number'=>$info['number'] + $count]);
        }
        self::commit();
        return true;
    }

    public static function out_modify($id,$data,$count = 0)
    {
        $currStockInfo = FirmStockRepo::getInfo($data['id']);
        if(empty($currStockInfo)){
            self::throwBizError('库存商品不存在');
        }
        if($currStockInfo['number'] < $data['currStockNum']){
            self::throwBizError('出库数量不能大于库存数量！');
        }
        $firmStockData['flow_type'] = 3 ;
        $firmStockData['order_sn'] = $data['order_sn'];
        $firmStockData['partner_name'] = $data['partner_name'];
        $firmStockData['number'] = $data['currStockNum'];
        $firmStockData['firm_id'] = $data['firm_id'];
        $firmStockData['flow_desc'] = $data['flow_desc'];
        $firmStockData['price'] = $data['price'];
        $firmStockData['goods_name'] = $currStockInfo['goods_name'];
        $firmStockData['goods_id'] = $currStockInfo['goods_id'];
        self::beginTransaction();
        FirmStockFlowRepo::modify($id,$firmStockData);
        if($count != 0){//数量没有发生变化，不用改变库存
            FirmStockRepo::modify($currStockInfo['id'],['number'=>$currStockInfo['number'] + $count]);
        }
        self::commit();
        return true;
    }

    public static function deleteFlow($id)
    {
        self::beginTransaction();
        $flow_info = FirmStockFlowRepo::getInfo($id);
        $info = FirmStockRepo::getInfoByFields(['goods_id'=>$flow_info['goods_id'],'firm_id'=>$flow_info['firm_id']]);
        FirmStockRepo::modify($info['id'],['number'=>$info['number'] - $flow_info['number']]);
        FirmStockFlowRepo::delete($id);
        self::commit();
        return true;
    }
}
