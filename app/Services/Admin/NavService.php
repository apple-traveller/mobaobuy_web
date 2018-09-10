<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\NavRepository;
class NavService extends BaseService
{
    //列表(分页)
    public static function getList($pageSize)
    {
        return NavRepository::getList($pageSize);
    }

    public static function getInfo($id)
    {
        return NavRepository::getInfo($id);
    }

    //获取总条数
    public static function getCount()
    {
        return NavRepository::getCount();
    }

    //唯一性验证
    public static function uniqueValidate($name)
    {
        $flag = NavRepository::exist($name);
        if($flag){
            self::throwError('该导航名称已经存在');
        }
        return $flag;
    }

    //保存
    public static function create($data)
    {
        return NavRepository::create($data);
    }

    //修改
    public static function modify($id,$data)
    {
        return NavRepository::modify($id,$data);
    }

    //删除
    public static function delete($id)
    {
        return NavRepository::delete($id);
    }

}