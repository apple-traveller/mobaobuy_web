<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-12-06
 * Time: 16:45
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShopSalesmanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesmanController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $name = $request->input('name','');
        $condition['is_delete']= 0;
        $condition['is_freeze']= 0;
        $pageSize =10;
        $list = ShopSalesmanService::getListWithPage(['pageSize'=>$pageSize,'page'=>$currentPage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('admin.shopSalesman.list',[
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
            return $this->display('admin.shopSalesman.edit',['info'=>$info,'currentPage'=>$currentPage]);
        } else {
            return $this->display('admin.shopSalesman.edit',['currentPage'=>$currentPage]);
        }
    }

    /**
     * 保存
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $id = $request->input('id','');
        $shop_id = $request->input('shop_id','');
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
            #同一个商家  业务员名称唯一
            $info = ShopSalesmanService::getList([],['name'=>$name,'id'=>'!'.$id,'shop_id'=>$shop_id]);
            if (!empty($info)){
                return $this->error('业务员已存在，请重新编辑');
            }
            $re = ShopSalesmanService::updateById($id,$data);
            if ($re){
                return $this->success('修改成功',url('/admin/salesman/list'));
            }
        } else {
            $info = ShopSalesmanService::getList([],['name'=>$name,'shop_id'=>$shop_id]);
            if (!empty($info)){
                return $this->error('业务员已存在，请重新添加');
            }
            $data['add_time'] = Carbon::now();
            $re = ShopSalesmanService::create($data);
            if ($re){
                return $this->success('添加成功',url('/admin/salesman/list'));
            }
        }
    }

    //ajax获取获取业务员名称
    public function getsalemanByShopId(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $salesman = ShopSalesmanService::getList([],['shop_id'=>$shop_id]);
        if(!empty($salesman)){
            return $this->result($salesman,200,'success');
        }
        return $this->result('',400,'error');
    }
}
