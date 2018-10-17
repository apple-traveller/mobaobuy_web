<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-11
 * Time: 17:02
 */
namespace App\Services;

use App\Repositories\GoodsRepo;
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
        return $list;
    }

    public static function listInfo($seckill_id)
    {
        $goods = SeckillGoodsRepo::getList([],['seckill_id'=>$seckill_id]);
        foreach ($goods as $k1=>$v1) {
            $goods[$k1]['goods_name'] = GoodsRepo::getInfo($v1['goods_id'])['goods_name'];
        }
        return $goods;
    }
    /**
     * 时间段列表
     * @return mixed
     */
    public static function getSeckillTime()
    {
        return SeckillTimeBucketRepo::getList([],[]);
    }

    /**
     * 时间段详情
     * @param $tb_id
     * @return array
     */
    public static function timeInfo($tb_id)
    {
        return SeckillTimeBucketRepo::getInfo($tb_id);
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
        $time_bucket = SeckillService::timeInfo($data[0]['tb_id']);
        $secKill_data = [
            'shop_id' =>$shop_info['id'],
            'shop_name' =>$shop_info['shop_name'],
            'tb_id' => $data[0]['tb_id'],
            'begin_time' => date('Y-m-d H:i:s',strtotime($data[0]['date_time'].$time_bucket['begin_time'])),
            'end_time' => date('Y-m-d H:i:s',strtotime($data[0]['date_time'].$time_bucket['end_time'])),
            'add_time' => Carbon::now(),
            'review_status' => 1
        ];
        try{
            self::beginTransaction();
            $re_secKill = SeckillRepo::create($secKill_data);

        foreach ($data as $k=>$v){
            $seckill_goods_data = [
                'seckill_id' => $re_secKill['id'],
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

    /**
     * @param $seckill_id
     * @return bool
     * @throws \Exception
     */
    public static function deleteSellerSeckill($seckill_id)
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

    //修改
    public static function modify($data)
    {
        return SeckillRepo::modify($data['id'],$data);
    }

    //保存
    public static function create($data,$gdata)
    {
        try{
            self::beginTransaction();
            $seckill = SeckillRepo::create($data);
            if(empty($seckill)){
                return false;
            }
            $flag = "";
            foreach($gdata as $vo){
                $vo['seckill_id'] = $seckill['id'];
                $flag = SeckillGoodsRepo::create($vo);
                if(empty($flag)){
                    return false;
                }
            }
            self::commit();
            return true;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }

    }

    //获取商品信息
    public static function getSeckillGoods($pager,$condition)
    {
        $seckill_goods = SeckillGoodsRepo::getListBySearch($pager,$condition);
        foreach($seckill_goods['list'] as $k=>$v){
            $good = GoodsRepo::getList([],['id'=>$v['goods_id']],['goods_name'])[0];
            $seckill_goods['list'][$k]['goods_name']=$good['goods_name'];
        }
        return $seckill_goods;
    }

    //获取一条商品的数据
    public static function getSeckillInfo($id)
    {
        return SeckillRepo::getInfo($id);
    }

    //获取时间段列表
    public static function getSeckillTimeList($pager,$condition)
    {
        return SeckillTimeBucketRepo::getListBySearch($pager,$condition);
    }

    //保存时间
    public static function createSeckillTime($data)
    {
        return SeckillTimeBucketRepo::create($data);
    }

    //编辑时间
    public static function modifySeckillTime($data)
    {
        return SeckillTimeBucketRepo::modify($data['id'],$data);
    }

    //删除秒杀时间段
    public static function deleteTime($id)
    {
        return SeckillTimeBucketRepo::delete($id);
    }

    //获取数据库中最大的id值
    public static function getMaxSeckillTimeId()
    {
        return SeckillTimeBucketRepo::getMax('id',[]);
    }

    //获取一个秒杀时间信息
    public static function getSeckillTimeInfo($id)
    {
        return SeckillTimeBucketRepo::getInfo($id);
    }




}
