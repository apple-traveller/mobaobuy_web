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
        return FirmStockFlowRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['flow_time'=>'desc']],$condition);
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
//        dump($condition);
        $firmStockInfo = FirmStockRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['number'=>'desc']],$condition);
//        dump($firmStockInfo);
        $catInfo = [];
        foreach($firmStockInfo['list'] as $k=>$v){
            $goodsInfo = GoodsRepo::getInfo($v['goods_id']);
            $goodsCatInfo = GoodsCategoryRepo::getInfo($goodsInfo['cat_id']);
            if(empty($goodsCatInfo)){
                self::throwBizError('找不到对应的分类');
            }

            //顶部多选框分类名
            if(!in_array($goodsCatInfo['id'],$catInfo)){
                $catInfo[$k]['cat_name'] = $goodsCatInfo['cat_name'];
                $catInfo[$k]['cat_id'] = $goodsCatInfo['id'];
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
//        dump($firmStockInfo['list']);

        //重置list键名
        $resetArr = [];
        foreach($firmStockInfo['list'] as $v){
            $resetArr[] = $v;
        }
//        dump($resetArr);
        $firmStockInfo['list'] = $resetArr;
//        dump($firmStockInfo['list']);

        //post返回table数据
        if($method){
            return $firmStockInfo;
        }
        //get返回分类列表
        return $catInfo;
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
        $condition['goods_name'] = '%'.$goodsName.'%';
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


}
