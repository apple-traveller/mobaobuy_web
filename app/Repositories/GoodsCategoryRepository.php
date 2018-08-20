<?php

namespace App\Repositories;

class GoodsCategoryRepository
{
    use CommonRepository;

    //获取列表
    public static function search($paper=[],$where=[]){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        if(isset($where['parent_id'])){
            $query = $query->where('parent_id', $where['parent_id']);
        }
        if(isset($where['order'])){
            $query = $query->orderBy('sort_order', $where['order']);
        }
        return self::searchQuery($paper,$query);
    }

    //根据栏目名称获取数据
    public static function getInfoByCatname($cat_name)
    {
        $model = self::getBaseModel();
        $info = $model::where('cat_name',$cat_name)->select('id')->first();
        if($info){
            return $info->asArray();
        }
        return [];
    }

    //删除
    public static function delete($ids)
    {
        $model = self::getBaseModel();
        $flag = $model::whereIn('id',$ids)->delete();
        return $flag;
    }
}
