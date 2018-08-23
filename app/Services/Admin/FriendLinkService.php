<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\FriendLinkRepository;
class FriendLinkService extends BaseService
{
    //分页获取链接列表
    public static function getLinks($pageSize)
    {
        return FriendLinkRepository::search($pageSize);
    }

    //验证唯一性
    public static function uniqueValidate($link_name)
    {
        $info = FriendLinkRepository::getInfoBylinkname($link_name);
        if(!empty($info)){
            self::throwError('分类名称已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return FriendLinkRepository::create($data);
    }

    //修改
    public static function modify($id,$data)
    {
        return FriendLinkRepository::modify($id,$data);
    }

    //获取一条数据
    public static function getInfo($id)
    {
        return FriendLinkRepository::getInfo($id);
    }

    //删除
    public static function delete($id)
    {
        return FriendLinkRepository::delete($id);
    }


}