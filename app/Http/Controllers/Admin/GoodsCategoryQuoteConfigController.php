<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\GoodsCategoryRepo;
use App\Services\GoodsCategoryQuoteConfigService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\GoodsCategoryService;
class GoodsCategoryQuoteConfigController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $cat_name = $request->input('cat_name','');
        $currpage = $request->input('currpage',1);
        $pageSize = 10;
        $condition = [];
        if(!empty($cat_name)){
            $condition['cat_name'] = '%'.$cat_name.'%';
        }
        $goods = GoodsCategoryQuoteConfigService::getListBySearch(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['id'=>'desc']],$condition);
        return $this->display('admin.goodscategoryquoteconfig.list',[
            'currpage'=>$currpage,
            'cat_name'=>$cat_name,
            'pageSize'=>$pageSize,
            'total'=>$goods['total'],
            'list'=>$goods['list'],
        ]);
    }

    //添加
    public function addForm()
    {
        //查询所有的分类
        $cates = GoodsCategoryService::getCates(['is_delete'=>0]);
        $cateTrees = GoodsCategoryService::getCatesTree($cates,0,1);
        //dd($goods_attr_ids);
        return $this->display('admin.goodscategoryquoteconfig.add',['cateTrees'=>$cateTrees,]);
    }



    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $info = GoodsCategoryQuoteConfigService::getInfo($id);

        //查询所有的分类
        $cates = GoodsCategoryService::getCates(['is_delete'=>0]);
        $cateTrees = GoodsCategoryService::getCatesTree($cates,0,1);
        return $this->display('admin.goodscategoryquoteconfig.edit',[
            'cateTrees'=>$cateTrees,
            'currpage'=>$currpage,
            'info'=>$info,
            'id'=>$id
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $currpage = $request->input('currpage');
        unset($data['currpage']);
        unset($data['_token']);
        $errorMsg = [];
        if($data['cat_id']==0){
            $errorMsg[] = '商品分类不能为空';
        }
        #检测分类是否存在
        $info = GoodsCategoryService::getInfo($data['cat_id']);
        if(!$info){
            $errorMsg[] = '找不到该分类的信息';
        }
        if(empty($data['max'])){
            $errorMsg[] = '最大值不能为空';
        }
        if(empty($data['min'])){
            $errorMsg[] = '最小值不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        $data['cat_name'] = $info['cat_name'];
        try{
            if(!key_exists('id',$data)){
                #判断该分类是否设置过
                $check = GoodsCategoryQuoteConfigService::getTotalCount(['cat_id'=>$data['cat_id']]);
                if($check > 0){//已经添加过
                    return $this->error('该分类已经配置过参数，请勿重复配置');
                }
//                GoodsService::uniqueValidate($data['goods_name']);
                $data['add_time']=Carbon::now();
                $info = GoodsCategoryQuoteConfigService::create($data);
                if(empty($info)){
                    return $this->error('添加失败');
                }
                return $this->success('添加成功',url('/admin/goodscategoryquoteconfig/list'));
            }else{
                $info = GoodsCategoryQuoteConfigService::modify($data);
                if(empty($info)){
                    return $this->error('修改失败');
                }
                return $this->success('修改成功',url('/admin/goodscategoryquoteconfig/list')."?currpage=".$currpage);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }


    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = GoodsCategoryQuoteConfigService::delete($id);
            if(empty($flag)){
                return $this->error('删除失败');
            }
            return $this->success('删除成功',url('/admin/goodscategoryquoteconfig/list'));
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
