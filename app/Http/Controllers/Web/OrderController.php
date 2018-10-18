<?php

namespace App\Http\Controllers\Web;

use App\Services\GoodsCategoryService;
use App\Services\OrderInfoService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    //我的订单
    public function orderList(Request $request){
        $tab_code = $request->input('tab_code', '');
        if($request->isMethod('get')){
            return $this->display('web.user.order.list', compact('tab_code'));
        }else{
            $page = $request->input('start', 0) / $request->input('length', 10) + 1;
            $page_size = $request->input('length', 10);
            $firm_id = session('_curr_deputy_user')['firm_id'];
            $order_no = $request->input('order_no');

            $condition['status'] = $tab_code;
            //todo 测试看数据，暂查询所有数据，不带订单用户ID条件
            /*if(session('_curr_deputy_user')['is_firm']){
                $condition['firm_id'] = $firm_id;
            }else{
                $condition['user_id'] = $firm_id;
                $condition['firm_id'] = 0;
            }*/
            if(!empty($order_no)){
                $condition['order_sn'] = '%'.$order_no.'%';
            }

            $rs_list = OrderInfoService::getWebOrderList($condition, $page, $page_size);

            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $rs_list['total'], //数据总行数
                'recordsFiltered' => $rs_list['total'], //数据总行数
                'data' => $rs_list['list']
            ];

            return $this->success('', '', $data);
        }
    }

    public function orderStatusCount(){
        $deputy_user = session('_curr_deputy_user');
        //todo 测试看数据，暂查询所有数据，不带订单用户ID条件
        /*if($deputy_user['is_firm']){
            $firm_id = $deputy_user['firm_id'];
            $status = OrderInfoService::getOrderStatusCount(0, $firm_id);
        }else{
            $status = OrderInfoService::getOrderStatusCount($deputy_user['firm_id'], 0);
        }*/
        $status = OrderInfoService::getOrderStatusCount(0, 0);
        return $this->success('', '', $status);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rule = [
            'cat_name'=>'required|unique:goods_category',
            'parent_id'=>'required|numeric',
            'is_nav_show'=>'required|numeric',
            'is_show'=>'required|numeric',
            'category_links'=>'required',
            'cat_alias_name'=>'nulleric'
        ];
        $data = $this->validate($request,$rule);
        try{
            GoodsCategoryService::categoryCreate($data);
        }catch (\Exception $e){
           return $this->error($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $id = $request->input('id');
        $rule = [
            'cat_name'=>'required|unique:goods_category',
            'parent_id'=>'required|numeric',
            'is_nav_show'=>'numeric',
            'is_show'=>'required|numeric',
            'category_links'=>'nullable',
            'cat_alias_name'=>'nullable'
        ];
        $data = $this->validate($request,$rule);
        try{
            GoodsCategoryService::categoryUpdate($id,$data);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        GoodsCategoryService::delete($id);
    }
}
