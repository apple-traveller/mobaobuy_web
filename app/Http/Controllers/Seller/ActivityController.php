<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:28
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function promoter(Request $request)
    {
        $shop_id = session()->get('_seller_id')['shop_id'];
        $currentPage = $request->input('currentPage',1);
        $condition = [];
        $condition['shop_id'] = $shop_id;
        $pageSize = 10;
        $list = ActivityService::getListBySearch([['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['add_time' => 'desc']]],$condition);
        return $this->display('seller.Activity.promoter',[
            'list' => $list['list'],
            'total' => $list['total'],
            'pageSize' => $pageSize,
            'currentPage' => $currentPage
        ]);
    }
}
