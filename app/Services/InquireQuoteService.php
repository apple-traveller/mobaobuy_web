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

class InquireQuoteService
{
    use CommonService;

    public static function savebuy($buyQuote){
        $buyQuote['add_time'] = Carbon::now();
        if(empty($buyQuote['inquire_id'])){
            self::throwBizError('求购信息有误');
        }

        if(empty($buyQuote['price'])){
            self::throwBizError('报价价格不能为空');
        }

        if(empty($buyQuote['num'])){
            self::throwBizError('报价数量不能为空');
        }

        if(empty($buyQuote['delivery_area'])){
            self::throwBizError('交货地不能为空');
        }

        $inquireInfo = InquireRepo::getInfo($buyQuote['inquire_id']);
        $buyQuote['goods_name'] = $inquireInfo['goods_name'];
        $buyQuote['goods_id'] = $inquireInfo['goods_id'];
        $buyQuote['unit_name'] = $inquireInfo['unit_name'];
        $buyQuote['delivery_method'] = $inquireInfo['delivery_method'];
        $buyQuote['delivery_time'] = $inquireInfo['delivery_time'];
        return InquireQuoteRepo::create($buyQuote);
    }
}
