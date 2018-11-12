<?php
namespace App\Services;
use App\Repositories\ArticleCatRepo;
use App\Repositories\ArticleRepo;
use App\Repositories\RegionRepo;
use App\Repositories\FirmUserRepo;
use App\Repositories\ShopGoodsQuoteRepo;
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
    //创建首页假数据
    public static function createFalseData()
    {
        //先随机获取几条报价
        $quote = ShopGoodsQuoteRepo::getRandList(10);
        $data = [];
        foreach (\App\Helpers\object_array($quote) as $k=>$v){
            //先组装报价信息
            $data[$k]['goods_name'] = $v['goods_name'];
            //生成随机数量
            $data[$k]['goods_number'] = (int)mt_rand(1, 10)*$v['packing_spec'];
            //再生成随机时间
            $h = (int)mt_rand(8,18);
            $i = (int)mt_rand(8,18);
            $s = (int)mt_rand(8,18);
            $data[$k]['add_time'] = date('Y-m-d').' '.timeFormat($h).':'.timeFormat($i).':'.timeFormat($s);
        }
        return $data;
    }
}