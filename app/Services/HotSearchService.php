<?php
namespace App\Services;

use App\Repositories\HotSearchRepo;

class HotSearchService
{
    use CommonService;

    public static function getListBySearch($pager, $condition){
        return HotSearchRepo::getListBySearch($pager, $condition);
    }

    public static function getList($order, $condition)
    {
        return HotSearchRepo::getList($order, $condition);
    }

    public static function getInfo($id)
    {
        return HotSearchRepo::getInfo($id);
    }

    public static function getInfoByFields($where)
    {
        return HotSearchRepo::getInfoByFields($where);
    }

    //唯一性验证
    public static function uniqueValidate($name)
    {
        $flag = HotSearchRepo::getInfoByFields(['name'=>$name]);
        if($flag){
            self::throwBizError('该导航名称已经存在');
        }
        return $flag;
    }

    //保存
    public static function create($data)
    {
        return HotSearchRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return HotSearchRepo::modify($data['id'],$data);
    }

    //删除
    public static function delete($id)
    {
        return HotSearchRepo::delete($id);
    }
}