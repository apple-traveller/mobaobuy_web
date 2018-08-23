<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\SeoRepository;
class SeoService extends BaseService
{
    //获取所有的配置信息
    public static function getList()
    {
        return SeoRepository::getList();
    }

    //根据id获取一条信息
    public static function getInfo($id)
    {
        return SeoRepository::getInfo($id);
    }

    public static function modify($data)
    {
       return SeoRepository::modify($data['id'],$data);
    }


}