<?php
namespace App\Services;

use App\Repositories\ActivityWholesaleRepo;
use Carbon\Carbon;

class ActivityWholesaleService
{
    use CommonService;

    /**
     * 根据条件查询列表 —— 分页
     * @param $pager
     * @param $where
     * @return mixed
     */
    public static function getListBySearch($pager,$where)
    {
        return ActivityWholesaleRepo::getListBySearch($pager,$where);
    }

    /**
     * 根据id获取详情
     * @param $id
     * @return array
     */
    public static function getInfoById($id)
    {
        $res = ActivityWholesaleRepo::getInfo($id);
        $goods_info = GoodsService::getGoodInfo($res['goods_id']);
        $cat_info = GoodsCategoryService::getInfo($goods_info['cat_id']);
        $res['cat_id'] = $goods_info['cat_id'];
        $res['cat_name'] = $cat_info['cat_name'];
        return $res;
    }

    /**
     * 创建
     * @param $data
     * @return mixed
     */
    public static function create($data)
    {
        $data['add_time'] = Carbon::now();
        return ActivityWholesaleRepo::create($data);
    }

    /**
     * 编辑
     * @param $id
     * @param $data
     * @return bool
     */
    public static function updateById($id,$data)
    {
        return ActivityWholesaleRepo::modify($id,$data);
    }

    /**
     * delete
     * @param $id
     * @return bool
     */
    public static function delete($id)
    {
        return ActivityWholesaleRepo::delete($id);
    }

    public static function getList($params=[], $page = 1 ,$pageSize=10){
        $condition = [];
        if(isset($params['status'])){
            $condition['review_status'] = $params['status'];
        }
        if(isset($params['end_time'])){
            $condition['end_time|>'] = Carbon::now();
        }
        if(!empty($params['goods_name'])){
            $condition['goods_name'] = '%'.$params['goods_name'].'%';
        }

        $info_list = ActivityWholesaleRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['end_time'=>'desc']],$condition);
        foreach ($info_list['list'] as &$item){
            if(Carbon::now()->gt($item['end_time'])){
                $item['is_over'] = true;
            }else{
                $item['is_over'] = false;
            }

            if(Carbon::now()->lt($item['begin_time'])){
                $item['is_soon'] = true;
            }else{
                $item['is_soon'] = false;
            }
        }
        unset($item);
        return $info_list;
    }

}