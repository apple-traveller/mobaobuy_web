<?php
namespace App\Services;

use App\Repositories\GoodsCategoryRepo;
use App\Repositories\GoodsRepo;

class GoodsCategoryService
{
    use CommonService;

    //获取所有分类的树型数据
    public static function getCategoryTree($only_show = 1){
        $condition = [];
        if($only_show){
            $condition['is_show'] = 1;
        }
        $condition['is_delete'] = 0;
        $all_list = GoodsCategoryRepo::getList(['sort_order'=>'asc'],$condition);
        return make_treeTable($all_list, 'id', 'parent_id','_child');
    }
    //获取所有分类的树型数据
    public static function getCategoryTreeAdmin($id = 0,$only_show = 1){
        $condition = [];
        if($only_show){
            $condition['is_show'] = 1;
        }
        $condition['is_delete'] = 0;
        $condition['parent_id'] = $id;
        $all_list = GoodsCategoryRepo::getList('',$condition,['*','cat_name as name']);
        foreach ($all_list as $k=>$v){
            //检测是否存在下级分类
            $res = GoodsCategoryRepo::getTotalCount(['parent_id'=>$v['id'],'is_delete'=>0]);
            if($res > 0){//有子分类
                $all_list[$k]['isParent'] = true;
            }
        }
        return $all_list;
//        return make_treeTable($all_list, 'id', 'parent_id','children');
    }

    public static function GoodsCategoryInfo($where=[]){
        return GoodsCategoryRepo::getListBySearch([],$where);
    }

    //分类添加
    public static function categoryCreate($data){
        return GoodsCategoryRepo::create($data);
    }

    //分类编辑
    public static function categoryUpdate($id,$data){
        return GoodsCategoryRepo::modify($id,$data);
    }

    //根据id获取一条数据
    public static function getInfo($id)
    {
        $res = GoodsCategoryRepo::getInfo($id);
        return $res;
    }

    //根据parent_id获取数据
    public static function getInfoByParentId($parent_id)
    {
        $res = GoodsCategoryRepo::getList(['sort_order'=>'asc'],['parent_id'=>$parent_id]);
        return $res;
    }

    //获取列表
    public static function getList($parent_id)
    {
        $res = GoodsCategoryRepo::getList(['sort_order'=>'asc'],['parent_id'=>$parent_id,'is_delete'=>0]);
        return $res;
    }

    //获取图标库文件所有文件
    public static function getIcons()
    {
        $path = $_SERVER['DOCUMENT_ROOT'].'/default/icon';
        $filedata = array();
        if(!is_dir($path)) return [];
        $handle = opendir($path);
        if($handle){
            while(($fl = readdir($handle)) !== false){
                if($fl!="."&&$fl!=".."){
                    $filedata[]=$fl;
                }
            }
        }
        return $filedata;
    }

    //验证唯一性
    public static function uniqueValidate($cat_name)
    {
        $info = GoodsCategoryRepo::getList([],['cat_name'=>$cat_name,['is_delete'=>0]]);
        if(!empty($info)){
            self::throwBizError('分类名称已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return GoodsCategoryRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return GoodsCategoryRepo::modify($data['id'],$data);
    }

    //获取所有分类
    public static function getCates($condition=[])
    {
        $res = GoodsCategoryRepo::getListBySearch([],$condition);
        return $res['list'];
    }

    //获取所有分类
    public static function getCatesByCondition($condition)
    {
        $res = GoodsCategoryRepo::getList([],$condition);
        return $res;
    }

    //分类树,获取所有分类
    public static function getCatesTree($cates,$id=0,$level=1)
    {
        static $data;
        foreach($cates as $k=>$v){
            if($v['parent_id']==$id){
                $data[$k]=$v;
                $data[$k]['level']=$level;
                self::getCatesTree($cates,$v['id'],$level+1);
            }
        }
        return $data;
    }

    //判断当前分类是第几级
    public static function getLevel($parent_id){
        $data = self::getCates();
        $cates = self::getCatesTree($data);
        $level = 1;
        if(!empty($cates)){
            foreach($cates as $k=>$v){
                if($v['parent_id']==$parent_id){
                    $level = $v['level'];
                    break;
                }
            }
        }

        return $level;
    }

    //获取下级ld
    public static function getChilds($cates,$id)
    {
        static $ids;
        foreach($cates as $k=>$v){
            if($v['parent_id']==$id){
                $ids[] = $v['id'];
                self::getChilds($cates,$v['id']);
            }
        }

        return $ids;
    }

    //删除
    public static function delete($id)
    {
        $good = GoodsRepo::getInfoByFields(['cat_id'=>$id,'is_delete'=>0]);
        if(!empty($good)){
            self::throwBizError(trans('error.cat_cannot_delete'));
            return false;
        }
        return GoodsCategoryRepo::modify($id,['is_delete'=>1]);
    }

    //商品报价页面
    public static function getCatesByGoodsList($goodList)
    {
        $cates = [];
        foreach($goodList as $vo)
        {
            $good = GoodsRepo::getList([],['id'=>$vo['goods_id']],['id','cat_id'])[0];
            $cates[] = GoodsCategoryRepo::getList([],['id'=>$good['cat_id']],['id','cat_name'])[0];
        }
        $cates_id = [];
        foreach($cates as $k=>$v)
        {
            $cates_id[] = $v['id'];
        }
        $unique_cateids = array_unique($cates_id);
        $unique_cates = [];
        foreach ($unique_cateids as $item) {
            $unique_cates[] = GoodsCategoryRepo::getList([],['id'=>$item],['id','cat_name'])[0];
        }

        return $unique_cates;
    }

    //根据cat_id获取goods数据
    public static function getGoodsIds($cat_id)
    {
        $goods_id = GoodsRepo::getList([],['cat_id'=>$cat_id],['id']);
        $res = [];
        foreach ($goods_id as $item){
            $res[] = $item['id'];
        }
        return $res;
    }

    public static function getTopCatByCatId($cat_id)
    {
        $cat_info = GoodsCategoryRepo::getInfo($cat_id);
        $top_id = $cat_id;
        $top_name = $cat_info['cat_name'];
        $top_name_en = $cat_info['cat_name_en'];
        if(!empty($cat_info['parent_id'])){
            $top_info = self::getTopCatByCatId($cat_info['parent_id']);
            $top_id = $top_info['top_id'];
            $top_name = $top_info['top_name'];
            $top_name_en = $top_info['top_name_en'];
        }
        return [
            'top_id'=>$top_id,
            'top_name'=>$top_name,
            'top_name_en'=>$top_name_en
        ];
    }

}