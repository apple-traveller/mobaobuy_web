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
class InquireService
{
    use CommonService;


    /**
     * 求购列表
     */
    public static function inquireList($pager,$condition){
//        return InquireRepo::getListBySearch($pager,$condition);
        $res = InquireRepo::getListBySearch($pager,$condition);
        if(!empty($res['list'])){
            foreach ($res['list'] as $k=>$v){
                $goodsInfo = GoodsService::getGoodInfo($v['goods_id']);
                $res['list'][$k]['goods_name_en'] = $goodsInfo['goods_full_name_en'];
            }
        }
        return $res;
    }


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
        try{
            return InquireRepo::modify($data['id'],$data);
        }catch(\Exception $e){
            self::throwBizError($e->getMessage());
        }
    }

    //删除
    public static function delete($data)
    {
        try{
            $inquire_quote = InquireQuoteRepo::getInfoByFields(['inquire_id'=>$data['id']]);
            if(!empty($inquire_quote)){
                self::throwBizError('该求购信息有报价，不能删除');
            }
            return InquireRepo::modify($data['id'],$data);
        }catch(\Exception $e){
            self::throwBizError($e->getMessage());
        }
    }

    //ajax 我要报价弹层
    public static function asingle($id){
        return InquireRepo::getInfo($id);
    }



}
