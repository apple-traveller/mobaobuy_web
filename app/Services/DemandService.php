<?php
namespace App\Services;

use App\Repositories\DemandRepo;
use Carbon\Carbon;
use App\Repositories\UserRepo;
class DemandService
{
    use CommonService;

    public static function getInfo($id){
        $info = DemandRepo::getInfo($id);
        $info['user_name']=UserRepo::getList([],['id'=>$info['user_id']],['user_name','nick_name'])[0]['user_name'];
        $info['nick_name']=UserRepo::getList([],['id'=>$info['user_id']],['user_name','nick_name'])[0]['nick_name'];
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
        return  DemandRepo::getListBySearch(['pageSize'=>$pageSize,'page'=>$page,'orderType'=>['created_at'=>'asc']],$condition);

    }

    public static function getList($pager, $condition){
        $demand = DemandRepo::getListBySearch($pager,$condition);
        foreach($demand['list'] as $k=>$v){
            $user = UserRepo::getList([],['id'=>$v['user_id']],['user_name','nick_name'])[0];
            $demand['list'][$k]['user_name'] = $user['user_name'];
            $demand['list'][$k]['nick_name'] = $user['nick_name'];
        }
        return $demand;
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