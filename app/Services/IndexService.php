<?php
namespace App\Services;
use App\Repositories\ArticleCatRepo;
use App\Repositories\ArticleRepo;
use App\Repositories\RegionRepo;
class IndexService
{
    use CommonService;
    public static function getProvince($city,$region_type){
        return RegionRepo::getProvince($region_type);
    }

    //资讯列表
    public static function information(){
        $articleInfo =  ArticleCatRepo::getList([],[]);
        foreach($articleInfo as $k=>$v){
            $child = ArticleRepo::getList([],['cat_id'=>$v['id']]);
            if($child){
                $articleInfo[$k]['child'] = $child;
            }
        }
        return $articleInfo;
    }

    public static function article($id){
        return ArticleRepo::getInfo($id);
    }
}