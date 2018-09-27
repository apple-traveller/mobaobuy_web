<?php
namespace App\Services;
use App\Repositories\FriendLinkRepo;
class FriendLinkService
{
     use CommonService;
    //分页获取链接列表
    public static function getPageList($pager,$condition)
    {
        return FriendLinkRepo::getListBySearch($pager,$condition);
    }

    //添加
    public static function create($data)
    {
        return FriendLinkRepo::create($data);
    }

    //修改
    public static function modify($id,$data)
    {
        return FriendLinkRepo::modify($id,$data);
    }

    //获取一条数据
    public static function getInfo($id)
    {
        return FriendLinkRepo::getInfo($id);
    }

    //删除
    public static function delete($id)
    {
        return FriendLinkRepo::delete($id);
    }


}