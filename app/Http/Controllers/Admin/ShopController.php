<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ShopService;
class ShopController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_name = $request->input('shop_name',"");
        $condition = [];
        if(!empty($title)){
            $condition['shop_name']="%".$shop_name."%";
        }
        $pageSize =5;
        $shops = ShopService::getShopList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        return $this->display('admin.shop.list',[
            'total'=>$shops['total'],
            'shops'=>$shops['list'],
            'currpage'=>$currpage,
            'shop_name'=>$shop_name,
            'pageSize'=>$pageSize
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        return $this->display('admin.shop.add');
    }

    //编辑
    public function editForm(Request $request)
    {

    }

    //保存
    public function save(Request $request)
    {

    }

    //查看
    public function detail(Request $request)
    {

    }

    //排序
    public function sort(Request $request)
    {

    }

    //删除
    public function delete(Request $request)
    {

    }

    //ajax修改状态
    public function status(Request $request)
    {

    }

    public function getUsers(Request $request)
    {
        $nick_name = $request->input('nick_name');
        $condition = [];
        if(!empty($nick_name)){
            $condition['nick_name']="%".$nick_name."%";
        }
        $users = ShopService::getUserList($condition);
        if(!empty($users['list'])){
            return $this->result($users['list'],200,'获取用户成功');
        }else{
            return $this->result('',400,'没有用户可以选择');
        }
    }
}
