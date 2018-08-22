<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\FirmRepository;
use App\Repositories\FirmPointsFlowRepository;
class FirmService extends BaseService
{
    //获取企业列表（excel导出）
    public static function exportExcel($fields)
    {
        $info = FirmRepository::getFirms($fields);
        return $info;
    }

    //获取企业列表（分页）
    public static function getFirmList($pageSize,$firm_name)
    {
        $info = FirmRepository::search($pageSize,$firm_name);
        return $info;
    }



    //修改
    public static function modify($id,$data)
    {
        return FirmRepository::modify($id,$data);
    }

    //查询一条数据
    public static function getInfo($id)
    {
        $firm = FirmRepository::getInfo($id);
        //查询企业积分
        //$points = FirmPointsFlowRepository::getPointByfirmId($id)['points'];
        $points = FirmPointsFlowRepository::getPointByfirmId($id);
        if($points){
            $firm['points']=$points['points'];
        }else{
            $firm['points']= 0 ;
        }

        return $firm;
    }

    //获取总条数
    public static function getCount($firm_name)
    {
        return FirmRepository::getCount($firm_name);
    }




}