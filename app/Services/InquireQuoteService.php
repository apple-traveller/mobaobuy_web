<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:27
 */
namespace App\Services;

use App\Repositories\InquireRepo;
use App\Repositories\InquireQuoteRepo;
class InquireQuoteService
{
    use CommonService;


    /**
     * 求购报价列表
     */
    public static function inquireQuoteList($pager){
        $condition = [];
        $condition['is_delete'] = 0;
        return InquireQuoteRepo::getListBySearch($pager,$condition);
    }

    //获取列表数据
    public static function getInquireQuoteList($pager,$condition)
    {
        return InquireQuoteRepo::getListBySearch($pager,$condition);
    }

    //获取一条信息
    public static function getInquireQuoteInfo($id)
    {
        return InquireQuoteRepo::getInfo($id);
    }

    //添加
    public static function create($data)
    {
        return InquireQuoteRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return InquireQuoteRepo::modify($data['id'],$data);
    }


}
