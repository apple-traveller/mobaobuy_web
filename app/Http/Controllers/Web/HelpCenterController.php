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
    public function helpController(Request $request)
    {
        $id = $request->input('id',4);
        $detail = ArticleService::getInfo($id);
        return $this->display('web.helpcenter.index',['detail'=>$detail,'id'=>$id]);
    }

    public function getSidebar(Request $request)
    {
        $cat_list = [];
        $Cates1 = ArticleCatService::getCates();
        $Cates2 = ArticleCatService::getCatesTree($Cates1,1);
        foreach ($Cates2 as $v){
            if ($v['parent_id']!=1 && $v['parent_id']!=0){
                $cat_list[] = $v;
            }
        }

        $cat_id = '';
       foreach ($cat_list as $k=>$v1){
           $cat_id .= '|'.$v1['id'];
       }
        $list = ArticleService::getList(['cat_id'=>$cat_id]);
        if (!empty($cat_list)){
            return $this->success('success','',$list);
        } else {
            return $this->error('数据为空');
        }
    }
}
