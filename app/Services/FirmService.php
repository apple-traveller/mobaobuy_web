<?php

namespace App\Services\Admin;

<<<<<<< HEAD:app/Services/FirmService.php
use App\Services\BaseService;
use App\Repositories\FirmRepository;
use App\Repositories\FirmPointsFlowRepository;
class FirmService
=======
use App\Services\CommonService;
use App\Repositories\FirmRepo;
use App\Repositories\FirmPointsFlowRepo;

use App\Repositories\FirmUserRepo;
class FirmService extends BaseService

>>>>>>> 039764dbb692d11bb288c6921e8081269efa3aaf:app/Services/Admin/FirmService.php
{
    use BaseService;
    //获取企业列表（excel导出）
    public static function exportExcel($fields)
    {
        $info = FirmRepo::getFirms($fields);
        return $info;
    }

    //获取企业列表（分页）
    public static function getFirmList($pageSize,$firm_name)
    {
        $info = FirmRepo::search($pageSize,$firm_name);
        return $info;
    }

    //修改
    public static function modify($id,$data)
    {
        return FirmRepo::modify($id,$data);
    }

    //查询一条数据
    public static function getInfo($id)
    {
        $firm = FirmRepo::getInfo($id);
        return $firm;
    }

    //获取总条数
    public static function getCount($firm_name)
    {
        return FirmRepo::getCount($firm_name);
    }

    //根据firmid获取当前企业的积分列表
    public static function getPointsByFirmid($firm_id)
    {
        return FirmPointsFlowRepo::getPointsByFirmid($firm_id);
    }

    //根据firmid获取企业用户
    public static function getFirmUser($firm_id)
    {
        return FirmUserRepo::getFirmUser($firm_id);
    }




}