<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-11
 * Time: 17:02
 */
namespace App\Services;

use App\Repositories\SeckillGoodsRepo;
use App\Repositories\SeckillRepo;
use App\Repositories\SeckillTimeBucketRepo;
use App\Repositories\ShopGoodsRepo;
use Carbon\Carbon;

class SeckillService
{
    use CommonService;

    public static function getSellerSeckillList($pager,$where)
    {
        $list = SeckillRepo::getListBySearch($pager,$where);

        foreach ($list['list'] as $k=>$v){

            // 将商品信息塞入list
            $goods = SeckillGoodsRepo::getList([],['seckill_id'=>$v['id']]);
           foreach ($goods as $k1=>$v1){
               $goods[$k1]['goods_name'] = ShopGoodsRepo::getInfo($v1['goods_id']);
               $list['list'][$k1]['goods'] = $goods;
           }
            // 将秒杀时间段塞入list
            $SeckillTime = SeckillTimeBucketRepo::getInfo($goods[0]['tb_id']);
            $list['list'][$k]['seckill_time'] = $SeckillTime['title'];
        }

        return $list;
    }

    public static function getSeckillTime()
    {
        return SeckillTimeBucketRepo::getList([],[]);
    }

    /**
     * 商家申请秒杀保存
     * @param $shop_info
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public static function sellerSeckillSave($shop_info,$data)
    {
        $secKill_data = [
            'shop_id' =>$shop_info['id'],
            'shop_name' =>$shop_info['shop_name'],
            'add_time' => Carbon::now(),
            'review_status' => 1
        ];
        try{
            self::beginTransaction();
            $re_secKill = SeckillRepo::create($secKill_data);

        foreach ($data as $k=>$v){
            $seckill_goods_data = [
                'seckill_id' => $re_secKill['id'],
                'tb_id' => $v['tb_id'],
                'goods_id' => $v['goods_id'],
                'sec_price' => $v['sec_price'],
                'sec_num' => $v['sec_num'],
                'sec_limit' => $v['sec_limit'],
            ];
            SeckillGoodsRepo::create($seckill_goods_data);
            self::commit();
        }
            return true;
        }catch (\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    public static function deleteSellerSeckll($seckill_id)
    {
        try{
            self::beginTransaction();
            $res_seckill = SeckillRepo::delete($seckill_id);

            if ($res_seckill){
                $res_seckill_goods = SeckillGoodsRepo::deleteByFields(['seckill_id'=>$seckill_id]);
            }
            if ($res_seckill_goods){
                self::commit();
            }
            return true;
        }catch (\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }


    /**
     * 以下，后台代码
     */
    //获取秒杀列表
    public static function getAdminSeckillList($pager,$condition)
    {
        return SeckillRepo::getListBySearch($pager,$condition);
    }
}
