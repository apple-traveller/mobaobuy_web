<?php

namespace App\Repositories;

class GoodsCategoryRepo
{
    use CommonRepo;

//    public static function search($paper=[],$where=[])
//    {
//        $clazz = self::getBaseModel();
//        return $clazz::query()->paginate(10);
//    }

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


    //存在验证
    public static function exist($cat_name)
    {
        $model = self::getBaseModel();
        return $model::where('cat_name',$cat_name)->exists();
    }

    //删除
    public static function delete($ids)
    {
        $model = self::getBaseModel();
        $flag = $model::whereIn('id',$ids)->delete();
        return $flag;

    }
}
