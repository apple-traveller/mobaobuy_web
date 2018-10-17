<?php
namespace App\Services;
use App\Repositories\FirmStockFlowRepo;
use App\Repositories\FirmStockRepo;
class FirmStockService
{
    use CommonService;

    //新增出入库记录
    public static function createFirmStock($data){
        $insertData = [];
        $insertData['firm_id'] = $data['firm_id'];
        $insertData['goods_name'] = $data['goods_name'];
//        $insertData['goods_id'] = $data[''];
        $result = FirmStockRepo::getInfoByFields($insertData);
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
            $stockData['goods_id'] = $data[''];
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

    //出入库查询
    public static function search($goods_name,$start_time,$end_time){
//        if(empty($goods_name) && !empty($start_time) && !empty($end_time)){
//            return FirmStockFlowRepo::search($start_time,$end_time);
//        }
        return  FirmStockFlowRepo::search($goods_name,$start_time,$end_time);
    }

    //入库记录列表
    public static function firmStockIn($id){
       return FirmStockFlowRepo::getListByStockIn($id);
    }

    //出库记录列表
    public static function firmStockOut($id){
        return FirmStockFlowRepo::getListByStockOut($id);
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


}