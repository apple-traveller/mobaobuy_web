<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:27
 */
namespace App\Services;

use App\Repositories\InquireQuoteRepo;
use App\Repositories\InquireRepo;
use Carbon\Carbon;
use App\Repositories\UserRepo;

class InquireQuoteService
{
    use CommonService;

    /**web保存报价提交
     * @param $buyQuote
     * @return mixed
     */
    public static function savebuy($buyQuote){
        $buyQuote['add_time'] = Carbon::now();
        if(empty($buyQuote['inquire_id'])){
            self::throwBizError(trans('error.inquire_info_error'));
        }

        if(empty($buyQuote['price'])){
            self::throwBizError(trans('error.quote_price_cannot_empty'));
        }

        if(empty($buyQuote['num'])){
            self::throwBizError(trans('error.quote_num_cannot_empty'));
        }

        if(empty($buyQuote['delivery_area'])){
            self::throwBizError(trans('error.delivery_area_cannot_empty'));
        }

        $inquireInfo = InquireRepo::getInfo($buyQuote['inquire_id']);
        $buyQuote['goods_name'] = $inquireInfo['goods_name'];
        $buyQuote['unit_name'] = $inquireInfo['unit_name'];
        $buyQuote['delivery_method'] = $inquireInfo['delivery_method'];
        $buyQuote['delivery_time'] = $inquireInfo['delivery_time'];
        return InquireQuoteRepo::create($buyQuote);
    }

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
        $list = InquireQuoteRepo::getListBySearch($pager,$condition);
        foreach($list['list'] as &$vo){
            $user = UserRepo::getInfo($vo['user_id']);
            $vo['user_name'] = $user['user_name'];
            $vo['nick_name'] = $user['nick_name'];
        }
        return $list;
    }

    //获取一条信息
    public static function getInquireQuoteInfo($id)
    {
        return InquireQuoteRepo::getInfo($id);
    }

    //获取一条信息
    public static function getInquireQuoteInfoByCondition($condition)
    {
        return InquireQuoteRepo::getInfoByFields($condition);
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
