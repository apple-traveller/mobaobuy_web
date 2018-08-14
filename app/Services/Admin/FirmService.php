<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\FirmRepository;
class FirmService extends BaseService
{
    //获取企业列表（excel导出）
    public static function getFirms($fields)
    {

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
        return FirmRepository::getInfo($id);
    }

    //获取日志信息
    public static function getLogInfo($id,$pageSize)
    {

    }


}