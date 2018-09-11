<?php

namespace App\Services;

use App\Repositories\NavRepo;
class NavService
{
    use CommonService;
    //列表(分页)
    public static function getList($pageSize)
    {
        return NavRepo::getList($pageSize);
    }

    public static function getInfo($id)
    {
        return NavRepo::getInfo($id);
    }

    //获取总条数
    public static function getCount()
    {
        return NavRepo::getCount();
    }

    //唯一性验证
    public static function uniqueValidate($name)
    {
        $flag = NavRepo::exist($name);
        if($flag){
            self::throwError('该导航名称已经存在');
        }
        return $flag;
    }

    //保存
    public static function create($data)
    {
        return NavRepo::create($data);
    }

    //修改
    public static function modify($id,$data)
    {
        return NavRepo::modify($id,$data);
    }

    //删除
    public static function delete($id)
    {
        return NavRepo::delete($id);
    }

}