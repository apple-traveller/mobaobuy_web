<?php
namespace App\Services;
use App\Repositories\ArticleCatRepo;
use App\Repositories\ArticleRepo;
class ArticleCatService
{
    use CommonService;
    //获取列表数据
    public static function getList($parent_id)
    {
        return ArticleCatRepo::getList(['sort_order'=>'asc'],['parent_id'=>$parent_id]);
    }

    //验证唯一性
    public static function uniqueValidate($cat_name)
    {
        $info = ArticleCatRepo::getInfoByFields(['cat_name'=>$cat_name]);
        if(!empty($info)){
            self::throwBizError('分类名称已经存在！');
        }
        return $info;
    }


    //获取一条数据
    public static function getInfo($id)
    {
        return ArticleCatRepo::getInfo($id);
    }

    //修改
    public static function modify($id,$data)
    {
        return ArticleCatRepo::modify($id,$data);
    }

    //保存
    public static function create($data)
    {
        return ArticleCatRepo::create($data);
    }

    //删除
    public static function delete($ids)
    {
        try{
            foreach($ids as $k=>$v){
                $article = ArticleRepo::getInfo($v);
                if(!empty($article)){
                    self::throwBizError('该分类下有文章，不能删除');
                }
                $info = ArticleCatRepo::delete($v);
                if(!$info){
                    return false;
                }
            }
        }catch(\Exception $e){
            self::throwBizError($e->getMessage());
        }

        return true;
    }

    //获取所有的分类
    public static function getCates()
    {
        return ArticleCatRepo::getList();
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

    //获取所有子类id
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





}