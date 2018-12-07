<?php
namespace App\Services;

use App\Repositories\DemandRepo;
use App\Repositories\UserSaleRepo;
use App\Repositories\UserWholeSingleRepo;
use Carbon\Carbon;
use App\Services\UserService;
class DemandService
{
    use CommonService;

    public static function getInfo($id){
        $info = DemandRepo::getInfo($id);
        if($info['user_id']){
            $user_info = UserService::getInfo($info['user_id']);
            $info['nick_name']= $user_info['nick_name'];
        }else{
            $info['nick_name']="游客";
        }

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
            $user = UserService::getInfo($v['user_id']);
            if(!empty($user)){
                $demand['list'][$k]['nick_name']=$user['nick_name'];
            }else{
                $demand['list'][$k]['nick_name']="游客";
            }
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

    //获取用户需求列表
    public static function getUserSaleList($pager, $condition)
    {
        $list = UserSaleRepo::getListBySearch($pager, $condition);
        foreach ($list['list'] as $k => $v) {
            $userInfo = UserService::getInfo($v['user_id']);
            if(!empty($userInfo)){
                $list['list'][$k]['nick_name'] = $userInfo['nick_name'];
            }else{
                $list['list'][$k]['nick_name'] = '';
            }
        }
        unset($userInfo);
        return $list;
    }
    //修改用户需求为已读
    public static function userSaleModify($id,$data)
    {
        return UserSaleRepo::modify($id,$data);
    }

    /**
     * 获取整单采购需求列表
     */
    public static function getUserWholeSingleList($pager, $condition){
        $list = UserWholeSingleRepo::getListBySearch($pager, $condition);
        foreach ($list['list'] as $k => $v) {
            $userInfo = UserService::getInfo($v['user_id']);
            if(!empty($userInfo)){
                $list['list'][$k]['nick_name'] = $userInfo['nick_name'];
            }else{
                $list['list'][$k]['nick_name'] = '';
            }
        }
        unset($userInfo);
        return $list;
    }

    //修改采购需求为已读
    public static function userWholeSaleModify($id,$data)
    {
        return UserWholeSingleRepo::modify($id,$data);
    }
}