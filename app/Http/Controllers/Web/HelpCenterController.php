<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-01
 * Time: 11:40
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ArticleCatService;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    public function helpController($id=4)
    {
        $detail = ArticleService::getInfo($id);
        return $this->display('web.helpcenter.index',['detail'=>$detail,'id'=>$id]);
    }

    public function getSidebar(Request $request)
    {
        $cat_list = [];
        $Cates1 = ArticleCatService::getList(1);

        foreach ($Cates1 as $k1=>$v1){
            $cat_list[$k1] = ArticleCatService::getList($v1['id']);
            if ($k1>0){
                $cat_list =  array_merge($cat_list[$k1-1],$cat_list[$k1]);
            }
        }

        foreach ($cat_list as $k2=>$v2){
            $cat_list[$k2]['_child'] = ArticleService::getList(['cat_id'=>$v2['id']]);
        }
     return $this->jsonResult($cat_list);
    }
}
