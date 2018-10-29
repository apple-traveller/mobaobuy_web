<?php
namespace App\Services;

use App\Repositories\ActivityPromoteRepo;
use Carbon\Carbon;

class ActivityPromoteService
{
    use CommonService;

    public static function getList($params=[], $page = 1 ,$pageSize=10){
        $condition = [];
        if(isset($params['status'])){
            $condition['review_status'] = $params['status'];
        }
        if(!empty($params['goods_name'])){
            $condition['goods_name'] = '%'.$params['goods_name'].'%';
        }

        $info_list = ActivityPromoteRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['end_time'=>'desc']],$condition);
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
        return $info_list;
    }
}