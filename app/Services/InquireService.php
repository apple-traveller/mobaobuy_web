<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:27
 */
namespace App\Services;

use App\Repositories\InquireRepo;

class InquireService
{
    use CommonService;

    //获取列表数据
    public static function getInquireList($pager,$condition)
    {
        return InquireRepo::getListBySearch($pager,$condition);
    }

    //获取一条信息
    public static function getInquireInfo($id)
    {
        return InquireRepo::getInfo($id);
    }

    //添加
    public static function create($data)
    {
        return InquireRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return InquireRepo::modify($data['id'],$data);
    }

}
