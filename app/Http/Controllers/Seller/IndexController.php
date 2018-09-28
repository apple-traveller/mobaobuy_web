<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-27
 * Time: 11:13
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ShopService;

class IndexController extends Controller
{
    public function index()
    {
        $info = session()->get('_seller');
        $data = [
            'user_name'=>$info['user_name'],
            'shop_name'=> $info['shop_info']['shop_name'],
            'is_super'=>'',
            'last_log'=>$info['shop_info']['last_time']
        ];
        return $this->display('seller.index',compact('data'));
    }


}
