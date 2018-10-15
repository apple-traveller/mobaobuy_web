<?php
namespace App\Services;
use App\Repositories\ArticleCatRepo;
use App\Repositories\ArticleRepo;
use App\Repositories\RegionRepo;
use App\Repositories\FirmUserRepo;
use App\Repositories\UserRepo;
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

    //个人选择哪家公司操作
    public static function getUserInfoByFirmId($userId){
        $firmUserInfo =  FirmUserRepo::getList([],['user_id'=>$userId]);
        $userInfo = [];
        if($firmUserInfo){
            foreach($firmUserInfo as $k=>$v){
        //                $firmUserInfo[$k]['firm_id'] = UserRepo::getInfo($v['firm_id'])['nick_name'];
                $userInfo[] = UserRepo::getInfo($v['firm_id']);
            }
            return $userInfo;
        }
        return [];
    }
}