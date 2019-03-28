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

    public static function delete($id)
    {
        return ShopGoodsQuotePriceRepo::delete($id);
    }

    public static function operation($data,$quote_id)
    {
        if(!empty($data)){
            foreach ($data as $k=>$v){//先判断存不存在id 存在则更新 不存在插入
                if(!empty($v['price']) || !empty($v['min_num'])) {
                    $v['quote_id'] = $quote_id;
                    if (isset($v['id']) && !empty($v['id'])) {
                        $id = $v['id'];
                        unset($v['id']);
                        if (!empty($v['price']) || !empty($v['min_num'])) {
                            ShopGoodsQuotePriceRepo::modify($id, $v);
                        }else{
                            ShopGoodsQuotePriceRepo::delete($id);
                        }
                    } else {//插入数据
                        if (!empty($v['price']) || !empty($v['min_num'])) {
                            self::create($v);
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * 根据报价id获取最低价格和对应数量
     * getMinPriceByQuoteId
     * @param $quote_id
     * @return array
     */
    public static function getMinPriceByQuoteId($quote_id)
    {
        $res = ShopGoodsQuotePriceRepo::getList(['price'=>'asc'],['quote_id'=>$quote_id],['price','min_num']);
        if(!empty($res)){
            return [
                'price'=>$res[0]['price'],
                'num'=>$res[0]['min_num']
            ];
        }
        $quote_info = ShopGoodsQuoteRepo::getInfo($quote_id);
        return [
            'price'=>$quote_info['shop_price'],
            'num'=>$quote_info['min_limit']
        ];
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
        $res = ShopGoodsQuotePriceRepo::getList(['min_num'=>'desc'],['min_num|<='=>$num,'quote_id'=>$quote_id],['price']);
        if(!empty($res)){
            return $res[0]['price'];
        }
        $quote_info = ShopGoodsQuoteRepo::getInfo($quote_id);
        return $quote_info['shop_price'];
    }
}