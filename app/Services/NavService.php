<?php
namespace App\Services;
use App\Repositories\NavRepo;
class NavService
{
    use CommonService;
    //列表(分页)
    public static function getNavs($pager,$condition)
    {
        return NavRepo::getListBySearch($pager,$condition);
    }

    public static function getPositionList($type){
        return NavRepo::getList(['sort_order'=>'asc'],['type'=>$type, 'is_show'=>1]);
    }

    public static function getInfo($id)
    {
        return NavRepo::getInfo($id);
    }

    //唯一性验证
    public static function uniqueValidate($name)
    {
        $flag = NavRepo::getInfoByFields(['name'=>$name]);
        if($flag){
            self::throwBizError('该导航名称已经存在');
        }
        return $flag;
    }

    //保存
    public static function create($data)
    {
        return NavRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return NavRepo::modify($data['id'],$data);
    }

    //删除
    public static function delete($id)
    {
        return NavRepo::delete($id);
    }

}