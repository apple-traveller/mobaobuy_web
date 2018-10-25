<?php
namespace App\Services;
use App\Repositories\AdRepo;
use App\Repositories\AdPositionRepo;
class AdService
{
    use CommonService;

    //列表
    public static function getAdvertList($pager,$condition)
    {
        $ads = AdRepo::getListBySearch($pager,$condition);
        foreach ($ads['list'] as $k=>$v)
        {
            $ad_position = AdPositionRepo::getInfo($v['position_id']);
            $ads['list'][$k]['position_name'] = $ad_position['position_name'];
        }
        return $ads;
    }


    //单条数据
    public static function getAdInfo($id)
    {
        return AdRepo::getInfo($id);
    }

    //修改
    public static function modify($data)
    {
        return AdRepo::modify($data['id'],$data);
    }

    //保存
    public static function create($data)
    {
        return AdRepo::create($data);
    }

    //删除
    public static function delete($id){
        return AdRepo::delete($id);
    }

}