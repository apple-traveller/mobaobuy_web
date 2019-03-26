<?php
namespace App\Services;

use App\Repositories\ShopGoodsQuotePriceRepo;
use App\Repositories\ShopGoodsQuoteRepo;

class ShopGoodsQuotePriceService
{
    use CommonService;

    public static function create($data)
    {
        return ShopGoodsQuotePriceRepo::create($data);
    }

    public static function operation($data,$quote_id)
    {
        if(!empty($data)){
            foreach ($data as $k=>$v){//先判断存不存在id 存在则更新 不存在插入
                $v['quote_id'] = $quote_id;
                if(isset($v['id']) && !empty($v['id'])){
                    $id = $v['id'];
                    unset($v['id']);
                    ShopGoodsQuotePriceRepo::modify($id,$v);
                }else{//插入数据
                    self::create($v);
                }
            }
        }
        return true;
    }

    /**
     * 根据报价id获取最低价格
     * getMinPriceByQuoteId
     * @param $quote_id
     * @return bool
     */
    public static function getMinPriceByQuoteId($quote_id)
    {
        $res = ShopGoodsQuotePriceRepo::getList(['price'=>'asc'],['quote_id'=>$quote_id],['price']);
        if(!empty($res)){
            return $res[0]['price'];
        }
        $quote_info = ShopGoodsQuoteRepo::getInfo($quote_id);
        return $quote_info['shop_price'];
    }

    /**
     * 报价 根据任意下单数量 获取对应的价格
     * getPriceByNum
     * @param $quote_id
     * @param $num
     * @return mixed
     */
    public static function getPriceByNum($quote_id,$num)
    {
        $res = ShopGoodsQuotePriceRepo::getList(['min_num'=>'desc'],['min_num|<'=>$num,'quote_id'=>$quote_id],['price']);
        if(!empty($res)){
            return $res[0]['price'];
        }
        $quote_info = ShopGoodsQuoteRepo::getInfo($quote_id);
        return $quote_info['shop_price'];
    }
}