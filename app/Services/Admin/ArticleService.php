<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\ArticleRepository;
class ArticleService extends BaseService
{

    //分页获取数据
    public static function getList($cat_id,$pageSize,$title)
    {
        return ArticleRepository::getList($cat_id,$pageSize,$title);
    }

    //验证唯一性
    public static function uniqueValidate($cat_name)
    {
        $info = ArticleRepository::exist($cat_name);
        if(!empty($info)){
            self::throwError('文章标题已经存在！');
        }
        return $info;
    }

    //获取总条数
    public static function getCount($cat_id,$title)
    {
        return ArticleRepository::getCount($cat_id,$title);
    }


    //获取一条数据
    public static function getInfo($id)
    {
        return ArticleRepository::getInfo($id);
    }

    //修改
    public static function modify($id,$data)
    {
        return ArticleRepository::modify($id,$data);
    }

    //保存
    public static function create($data)
    {
        return ArticleRepository::create($data);
    }

    //删除
    public static function delete($id)
    {
        return ArticleRepository::delete($id);
    }











}