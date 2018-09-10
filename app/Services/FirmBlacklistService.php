<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\FirmBlacklistRepository;
class FirmBlacklistService
{
    use BaseService;

    //获取黑名单列表(导出excel表)
    public static function getBlacklists($fields)
    {
        $info = FirmBlacklistRepository::getBlacklists($fields);
        return $info;
    }

    //获取黑名单列表（分页）
    public static function getList($pageSize,$firm_name)
    {
        $info = FirmBlacklistRepository::search($pageSize,$firm_name);
        return $info;
    }

    //添加
    public static function create($data)
    {
        $flag = FirmBlacklistRepository::create($data);
        return $flag;
    }



    //获取黑名单总条数
    public static function getCount($firm_name)
    {
        return FirmBlacklistRepository::getCount($firm_name);
    }

    //检测企业名称是否已经存在
    public static function validateUnique($firm_name)
    {
        return FirmBlacklistRepository::getInfoByFields(['firm_name'=>$firm_name]);
    }

    //删除
    public static function delete($id)
    {
        return FirmBlacklistRepository::delete($id);
    }



}