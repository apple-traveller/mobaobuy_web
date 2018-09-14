<?php
namespace App\Services;
use App\Repositories\ArticleRepo;
use App\Repositories\ArticleCatRepo;
class ArticleService
{
    use CommonService;
    //分页获取数据
    public static function getArticleLists($pager,$condition)
    {
        $info = ArticleRepo::getListBySearch($pager,$condition);
        foreach($info['list'] as $k=>$v){
            $cate = ArticleCatRepo::getInfoByFields(['id'=>$v['cat_id']]);
            $info['list'][$k]['cat_name']=$cate['cat_name'];
        }
        return $info;
    }

    //验证唯一性
    public static function uniqueValidate($title)
    {
        $info = ArticleRepo::getInfoByFields(['title'=>$title]);
        if(!empty($info)){
            self::throwBizError('文章标题已经存在！');
        }
        return $info;
    }

    //获取一条数据
    public static function getInfo($id)
    {
        return ArticleRepo::getInfo($id);
    }

    //修改
    public static function modify($id,$data)
    {
        return ArticleRepo::modify($id,$data);
    }

    //保存
    public static function create($data)
    {
        return ArticleRepo::create($data);
    }

    //删除
    public static function delete($id)
    {
        return ArticleRepo::delete($id);
    }











}