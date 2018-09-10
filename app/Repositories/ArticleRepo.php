<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class ArticleRepo
{
    use CommonRepo;

    //获取文章列表
    public static function getList($cat_id,$pageSize,$title)
    {
        $model =self::getBaseModel();
        $info = null;

        if($cat_id==0&&$title==""){
            $info = $model::orderBy('sort_order','asc')->paginate($pageSize);
        }elseif($cat_id!=0&&$title==""){
            $info = $model::where('cat_id',$cat_id)->orderBy('sort_order','asc')->paginate($pageSize);
        }elseif($cat_id==0&&$title!=""){
            $info = $model::where('title','like',"%".$title."%")->orderBy('sort_order','asc')->paginate($pageSize);
        }else{
            $info = $model::where('cat_id',$cat_id)->where('title','like',"%".$title."%")->orderBy('sort_order','asc')->paginate($pageSize);
        }
        if($info){
            return $info;
        }
        return [];
    }

    //获取总条数
    public static function getCount($cat_id,$title)
    {
        $model = self::getBaseModel();
        if($cat_id==0&&$title==""){
            return $model::count();
        }elseif($cat_id!=0&&$title==""){
            return $model::where('cat_id',$cat_id)->count();
        }elseif($cat_id==0&&$title!=""){
            return $model::where('title','like',"%".$title."%")->count();
        }else{
            return $model::where('cat_id',$cat_id)->where('title','like',"%".$title."%")->count();
        }


    }


    //存在验证
    public static function exist($title)
    {
        $model = self::getBaseModel();
        return $model::where('title',$title)->exists();
    }



}