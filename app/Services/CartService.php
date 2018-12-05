<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-22
 * Time: 16:54
 */
namespace App\Services;

use App\Repositories\CartRepo;

class CartService
{
    use CommonService;

    public static function getCheckGoodsList($user_id)
    {
        return CartRepo::getList(['add_time'=>'desc'],['user_id'=>$user_id,'is_checked'=>1]);
    }

    /**
     * 获取用户购物车商品数
     * @param $user_id
     * @return mixed
     *
     */
    public static function getUserCartNum($user_id){
        return CartRepo::getTotalCount(['user_id'=>$user_id,'is_invalid'=>0]);
    }

    public static function deleteByFields($where)
    {
        return CartRepo::deleteByFields($where);
    }
}
