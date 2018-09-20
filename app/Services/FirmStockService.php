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

    //入库记录列表
    public static function firmStockIn($id){
       return FirmStockFlowRepo::getList([],['firm_id'=>$id,'flow_type'=>2]);
    }

    //出库记录列表
    public static function stockList($id){
        return FirmStockFlowRepo::getList([],['firm_id'=>$id]);
    }
    //库存商品流水
    public static function stockFlowList($id){
        return FirmStockFlowRepo::getList([],['firm_id'=>$id]);
    }


}