<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-11
 * Time: 17:03
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        $shipping_name = $request->input('shipping_name','');
        $currentPage = $request->input('currentPage');
        $pageSize = 10;
        $condition = [];
        if(!empty($shipping_name)){
            $condition['shipping_name'] = '%'.$shipping_name.'%';
        }
        $shipping_list = ShippingService::getListBySearch([
            'pageSize' => $pageSize,
            'page' => $currentPage,
            'orderType' => []]
            , $condition);
        return $this->display('admin.shipping.list', [
            'shipping_list' => $shipping_list['list'],
            'total' => $shipping_list['total'],
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'shipping_name' => $shipping_name
        ]);
    }

    public function add()
    {
        return $this->display('admin.shipping.edit');
    }

    public function edit(Request $request)
    {
        $id = $request->input('id',0);
        if(!$id){
            return $this->error('无法获取参数ID');
        }
        $shipping_info = ShippingService::getInfo($id);
        return $this->display('admin.shipping.edit',compact('shipping_info'));
    }

    public function save(Request $request)
    {
        $data['id'] = $request->input('id',0);
        $data['shipping_code'] = $request->input('shipping_code','');
        $data['shipping_name'] = $request->input('shipping_name','');
        $data['shipping_desc'] = $request->input('shipping_desc','');

        if(empty($data['shipping_name'])){
            return $this->error('物流公司名称不能为空');
        }

        try{
            if(!empty($data['id'])){
                $goodsQuote = ShippingService::getInfo($data['id']);
                if(empty($goodsQuote)){
                    return $this->error('物流公司不存在');
                }
                $flag = ShippingService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/shipping'));
                }
            }else{
                $data['enabled'] = 1;
                $flag = ShippingService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/shipping'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
    /**
     * 启用禁用
     * setStatus
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function setStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status',0);//默认否 启用公司
        if(empty($id)){
            return $this->error('无法获取参数ID');
        }
        if($status == 1){//禁用
            $enabled = 0;
            $info = '禁用';
        }else{
            $enabled = 1;
            $info = '启用';
        }
        $res = ShippingService::modify(['id'=>$id,'enabled'=>$enabled]);
        if($res){
            return $this->success($info.'成功！');
        }else{
            return $this->error($info.'失败！');
        }
    }
}
