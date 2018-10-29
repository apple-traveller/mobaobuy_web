<?php
namespace App\Services;

use App\Repositories\DemandRepo;
use Carbon\Carbon;

class DemandService
{
    use CommonService;

    public static function getInfo($id){
        $info = DemandRepo::getInfo($id);
        return $info;
    }

    /**
     * 根据处理状态获取需求列表
     * @param $state
     * @param int $page
     * @param int $pageSize
     * @return mixed
     */
    public static function getListByState($state, $page = 1,$pageSize = 10){
        $condition['action_state'] = $state;
        return DemandRepo::getListBySearch(['pageSize'=>$pageSize,'page'=>$page,'orderType'=>['created_at'=>'asc']],$condition);
    }

    public static function getList($pager, $condition){
        return DemandRepo::getListBySearch($pager,$condition);
    }

    public static function create($data){
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        return DemandRepo::create($data);
    }

    public static function update($id, $data){
        $data['updated_at'] = Carbon::now();
        return DemandRepo::modify($id, $data);
    }
}