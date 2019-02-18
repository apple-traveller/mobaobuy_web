<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\GoodsService;
use App\Services\BrandService;
use App\Services\GoodsCategoryService;
class GoodsController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $goods_name = $request->input('goods_name','');
        $currpage = $request->input('currpage',1);
        $pageSize = 10;
        $condition = ['is_delete'=>0];
        if(!empty($goods_name)){
            $c['opt'] = "OR";
            $c['goods_full_name'] = "%".$goods_name."%";
            $c['goods_sn'] = $goods_name;
            $c['brand_name'] = $goods_name;
            $c['goods_model'] = $goods_name;
            $condition[] = $c;
        }
        $goods = GoodsService::getGoodsList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['id'=>'desc']],$condition);
        return $this->display('admin.goods.list',[
            'currpage'=>$currpage,
            'goods_name'=>$goods_name,
            'pageSize'=>$pageSize,
            'total'=>$goods['total'],
            'goods'=>$goods['list'],
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        //查询所有品牌
        $brands = BrandService::getBrandList([],['is_delete'=>0]);
        //查询所有的单位
        $units = GoodsService::getUnitList([],['is_delete'=>0]);
        //查询所有的分类
        $cates = GoodsCategoryService::getCates(['is_delete'=>0]);
        $cateTrees = GoodsCategoryService::getCatesTree($cates,0,1);
        //dd($goods_attr_ids);
        return $this->display('admin.goods.add',[
            'brands'=>$brands['list'],
            'units'=>$units['list'],
            'cateTrees'=>$cateTrees,
        ]);
    }



    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $good = GoodsService::getGoodInfo($id);
        $goods_attr = $good['goods_attr'];
        $attrArr = explode(";",$goods_attr);
        //查询所有品牌
        $brands = BrandService::getBrandList([],['is_delete'=>0]);
        //查询所有的单位
        $units = GoodsService::getUnitList([],['is_delete'=>0]);
        //查询所有的分类
        $cates = GoodsCategoryService::getCates(['is_delete'=>0]);
        $cateTrees = GoodsCategoryService::getCatesTree($cates,0,1);
        return $this->display('admin.goods.edit',[
            'brands'=>$brands['list'],
            'units'=>$units['list'],
            'cateTrees'=>$cateTrees,
            'currpage'=>$currpage,
            'good'=>$good,
            'attrArr'=>$attrArr,
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
        if($data['brand_id']==0 && $data['is_special'] == 0){
            $errorMsg[] = '商品品牌不能为空';
        }
        if(empty($data['goods_name'])){
            $errorMsg[] = '商品名称不能为空';
        }
        if(empty($data['keywords'])){
            $errorMsg[] = '商品关键字不能为空';
        }
        if(empty($data['packing_spec'])){
            $errorMsg[] = '包装规格不能为空';
        }
        if(empty($data['packing_unit'])){
            $errorMsg[] = '包装单位不能为空';
        }
        if(empty($data['market_price'])){
            $errorMsg[] = '市场价不能为空';
        }
        if(empty($data['goods_content'])){
            $errorMsg[] = '含量不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        if(!empty($data['original_img'])){
            $data['goods_img'] = $data['original_img'];
            $data['goods_thumb'] = $data['original_img'];
        }

        $data['goods_full_name'] = $data['brand_name']." ".$data['goods_content']." ".$data['goods_name'];
        $data['goods_full_name_en'] = $data['brand_name_en']." ".$data['goods_content_en']." ".$data['goods_name_en'];
        unset($data['brand_name_en']);
        try{
            if(!key_exists('id',$data)){
//                GoodsService::uniqueValidate($data['goods_name']);
                $data['add_time']=Carbon::now();
                $data['last_update']=Carbon::now();
                if(!empty($data['goods_attr'])){
                    $goods_attr_ids = $this->saveAttrbute($data['goods_attr']);
                    $data['goods_attr_ids']=$goods_attr_ids;
                }

                $data['goods_weight'] = 1;
                $info = GoodsService::create($data);
                if(empty($info)){
                    return $this->error('添加失败');
                }
                $mdata = ['id'=>$info['id'],'goods_sn'=>"P".str_pad($info['id'],6,'0',STR_PAD_LEFT )];
                GoodsService::modify($mdata);
                return $this->success('添加成功',url('/admin/goods/list'));
            }else{
                $data['last_update']=Carbon::now();
                if(!empty($data['goods_attr'])){
                    $goods_attr_ids = $this->saveAttrbute($data['goods_attr']);
                    $data['goods_attr_ids']=$goods_attr_ids;
                }
                $info = GoodsService::modify($data);
                if(empty($info)){
                    return $this->error('修改失败');
                }
                return $this->success('修改成功',url('/admin/goods/list')."?currpage=".$currpage);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }


    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $data['id']=$id;
        $data['is_delete']=1;
        try{
            #删除之前检测该商品是否存在对应的报价单或者活动
            $is_exist_res = GoodsService::checkGoodsExistOtherInfo($id);
            if(!$is_exist_res){
                return $this->error('存在对应的报价信息或者活动信息，不能删除');
            }

            $flag = GoodsService::modify($data);
            if(empty($flag)){
                return $this->error('删除失败');
            }
            return $this->success('删除成功',url('/admin/goods/list'));
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //查看详情
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $good = GoodsService::getGoodInfo($id);
        $goods_attr = $good['goods_attr'];
        $attrArr = explode(";",$goods_attr);
        //print_r($attrArr);
        //查询所有品牌
        $brands = BrandService::getBrandList([],['is_delete'=>0]);
        //查询所有的单位
        $units = GoodsService::getUnitList([],['is_delete'=>0]);
        //查询所有的分类
        $cates = GoodsCategoryService::getCates(['is_delete'=>0]);
        //dd($goods_attr_ids);
        return $this->display('admin.goods.detail',[
            'brands'=>$brands['list'],
            'units'=>$units['list'],
            'cates'=>$cates,
            'currpage'=>$currpage,
            'good'=>$good,
            'attrArr'=>$attrArr,
        ]);
    }

    //获取属性名
    public function getAttrs(Request $request)
    {
        $attr_name = $request->input('attr_name','');
        $attrs = GoodsService::getAttrs(['attr_name'=>"%".$attr_name."%"]);
        if(!empty($attrs)){
            return $this->result($attrs,200,'获取数据成功');
        }else{
            return $this->result('',400,'获取属性值失败');
        }
    }

    //获取属性值
    public function getAttrValues(Request $request)
    {
        $attr_value = $request->input('attr_value','');
        $attr_id = $request->input('attr_id');
        $condition = [];
        if(!empty($attr_value)){
            $condition['attr_value'] = "%".$attr_value."%";
        }
        if(!empty($attr_id)){
            $condition['attr_id'] = $attr_id;
        }
        $attr_values = GoodsService::getAttrValues($condition);
        if(!empty($attr_values)){
            return $this->result($attr_values,200,'获取数据成功');
        }else{
            return $this->result('',400,'获取属性值失败');
        }
    }

    //保存属性
    public function saveAttrbute($goods_attr)
    {
        $arr = explode(';',$goods_attr);
        $attrs = [];
        $goods_attr_ids = "";
        foreach($arr as $k=>$v){
            $attrs[explode(':',$v)[0]] = explode(':',$v)[1];
        }
        try{
            foreach($attrs as $k=>$v){
                $attrFlag = GoodsService::getAttr(['attr_name'=>$k,'is_delete'=>0]);//判断属性名是否存在
                $attr_id = 0;
                if(empty($attrFlag)){
                    $info = GoodsService::saveAttrName(['attr_name'=>$k]);
                    $attr_id = $info['id'];
                }else{
                    $attr_id = $attrFlag['id'];
                }
                $attrValueFlag = GoodsService::getAttrValue(['attr_value'=>$v,'is_delete'=>0]);//判断属性值是否存在
                $attr_value_id = 0;
                if(!empty($attrValueFlag)){
                    $attr_value_id = $attrValueFlag['id'];
                }else{
                    $info = GoodsService::saveAttrValue(['attr_id'=>$attr_id,'attr_value'=>$v]);
                    $attr_value_id = $info['id'];
                }
                $goods_attr_ids.=$attr_id."_".$attr_value_id.";";
            }
            return $goods_attr_ids;
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }




}
