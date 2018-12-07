<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-12-06
 * Time: 16:45
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ShopSalesmanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopSalesmanController extends Controller
{
    public function listView(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $shop_id = session('_seller_id')['shop_id'];
        $name = $request->input('name','');
        $condition['is_delete']= 0;
        $condition['shop_id']= $shop_id;
        $pageSize =5;
        $list = ShopSalesmanService::getListWithPage(['pageSize'=>$pageSize,'page'=>$currentPage],$condition);
        return $this->display('seller.shopSalesman.list',[
            'total'=>$list['total'],
            'list'=>$list['list'],
            'currentPage'=>$currentPage,
            'name' => $name,
            'pageSize'=>$pageSize
        ]);
    }

    /**
     * 编辑 添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $request->flash();
        $id = $request->input('id','');
        $currentPage = $request->input('currentPage',1);
        if (!empty($id)){
            $info = ShopSalesmanService::getInfoByFields(['id'=>$id]);
            return $this->display('seller.shopSalesman.edit',['info'=>$info,'currentPage'=>$currentPage]);
        } else {
            return $this->display('seller.shopSalesman.edit',['currentPage'=>$currentPage]);
        }
    }

    /**
     * 保存
     * @param Request $request
     * @return ShopSalesmanController|\Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $id = $request->input('id','');
        $shop_id = session('_seller_id')['shop_id'];
        $name = $request->input('name','');
        $mobile = $request->input('mobile','');
        $qq = $request->input('qq','');
        if (empty($name)){
            return $this->error('姓名不能为空');
        }

        if (empty($mobile)){
            return $this->error('电话不能为空');
        }

        $data = [
            'name' => $name,
            'mobile' => $mobile,
            'qq' => $qq,
            'shop_id' => $shop_id
        ];
        if (!empty($id)){
            $info = ShopSalesmanService::getList([],['name'=>$name,'id'=>'!'.$id]);
            if (!empty($info)){
                return $this->error('业务员已存在，请重新编辑');
            }
            $re = ShopSalesmanService::updateById($id,$data);
            if ($re){
                return $this->display('seller.shopSalesman.list');
        }
        } else {
            $info = ShopSalesmanService::getList([],['name'=>$name]);
            if (!empty($info)){
                return $this->error('业务员已存在，请重新添加');
            }
            $data['add_time'] = Carbon::now();
            $re = ShopSalesmanService::create($data);
            if ($re){
                return $this->display('seller.shopSalesman.list');
        }
        }

    }
}
