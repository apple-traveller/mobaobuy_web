<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\FirmRepository;
use App\Repositories\FirmPointsFlowRepository;
use App\Repositories\FirmUserRepository;
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
        return $firm;
    }

    //获取总条数
    public static function getCount($firm_name)
    {
        return FirmRepository::getCount($firm_name);
    }

    //根据firmid获取当前企业的积分列表
    public static function getPointsByFirmid($firm_id)
    {
        return FirmPointsFlowRepository::getPointsByFirmid($firm_id);
    }

    //根据firmid获取企业用户
    public static function getFirmUser($firm_id)
    {
        return FirmUserRepository::getFirmUser($firm_id);
    }




}