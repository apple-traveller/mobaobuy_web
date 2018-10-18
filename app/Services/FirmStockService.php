<?php
namespace App\Services;
use App\Repositories\FirmStockFlowRepo;
use App\Repositories\FirmStockRepo;
use App\Repositories\UserRepo;
use Carbon\Carbon;
class FirmStockService
{
    use CommonService;

    //新增入库记录
    public static function createFirmStock($data){
        $data['flow_time'] = Carbon::now();
        $insertData = [];
        $insertData['firm_id'] = $data['firm_id'];
        $insertData['goods_name'] = $data['goods_name'];
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
            $stockData = [];
            $stockData['firm_id'] = $data['firm_id'];
            $stockData['goods_id'] = '';
            $stockData['goods_name'] = $data['goods_name'];
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
        dd($data);
        $currStockInfo = FirmStockRepo::getInfo($data['id']);
        if(empty($currStockInfo)){
            self::throwBizError('库存商品不存在');
        }
        $data['flow_time'] = Carbon::now();
        $data['flow_type'] = 3 ;
        $data['number'] = $data['currStockNum'];

        //更新库存表，新增库存流水记录
        if($currStockInfo){
            try{
                self::beginTransaction();
                FirmStockFlowRepo::create($data);
                FirmStockRepo::modify($data['id'],['number'=>$currStockInfo['number'] - $data['currStockNum']]);
                self::commit();
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }
        }
    }

    //出入库查询
    public static function search($goods_name,$start_time,$end_time){
//        if(empty($goods_name) && !empty($start_time) && !empty($end_time)){
//            return FirmStockFlowRepo::search($start_time,$end_time);
//        }
        return  FirmStockFlowRepo::search($goods_name,$start_time,$end_time);
    }

    //入库记录列表
    public static function firmStockIn($firm_id, $goods_name, $page = 1 ,$pageSize=10){
        $condition = [];
        if($firm_id > 0){
            $condition['firm_id'] = $firm_id;
        }
        if(!empty($goods_name)){
            $condition['goods_name'] = '%'.$goods_name.'%';
        }
        $condition['flow_type'] = 2;
        $firmStockFlowInfo =  FirmStockFlowRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['number'=>'desc']],$condition);
        foreach($firmStockFlowInfo['list'] as $k=>$v){
            $v['nick_name'] = UserRepo::getInfo($v['created_by'])['nick_name'];
            $firmStockFlowInfo['list'][$k] = $v;
        }
        return $firmStockFlowInfo;
    }

    //出库记录列表
    public static function firmStockOut($firm_id, $goods_name, $page = 1 ,$pageSize=10){
        $condition = [];
        if($firm_id > 0){
            $condition['firm_id'] = $firm_id;
        }
        if(!empty($goods_name)){
            $condition['goods_name'] = '%'.$goods_name.'%';
        }
        $condition['flow_type'] = 3;
        return FirmStockFlowRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['number'=>'desc']],$condition);
    }

    //库存记录列表
    public static function stockList($firm_id, $goods_name, $page = 1 ,$pageSize=10){
        $condition = [];
        if($firm_id > 0){
            $condition['firm_id'] = $firm_id;
        }
        if(!empty($goods_name)){
            $condition['goods_name'] = '%'.$goods_name.'%';
        }

        return FirmStockRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['number'=>'desc']],$condition);
    }
    //库存商品流水
    public static function stockFlowList($id){
        return FirmStockFlowRepo::getList([],['firm_id'=>$id]);
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
        $condition['number'] = '>|0';
        return FirmStockRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['number'=>'desc']],$condition);
    }
    //单挑可出库
    public static function curCanStock($id){
        return FirmStockRepo::getInfo($id);
    }


}