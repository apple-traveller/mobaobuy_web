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
use App\Services\ShopUserService;
use App\Services\UserService;
use Illuminate\Http\Request;

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

    /**
     * 店铺详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = session()->get('_seller_id')['shop_id'];
        $shop = ShopService::getShopById($id);
        return $this->display('seller.shop.detail',[
            'currentPage'=>$currentPage,
            'shop'=>$shop
        ]);
    }

}
