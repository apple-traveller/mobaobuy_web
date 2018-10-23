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
}
