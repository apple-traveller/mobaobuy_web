<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ArticleCatService;
use App\Services\ArticleService;
class ArticleController extends ApiController
{
    //咨询列表
    public function getList(Request $request)
    {
        $currpage= $request->input('currpage',1);
        $pageSize = $request->input('pagesize', 8);
        $today = $request->input("today",'');
        $orderType = $request->input("orderType","id:desc");
        $cat_id = $request->input('cat_id','');
        $title = $request->input('title','');
        $condition['is_show'] = 1;
        $orderBy = [];
        if(!empty($today)){
            $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $condition['add_time|>'] = date("Y-m-d H:i:s",$beginToday);
            $condition['add_time|<'] = date("Y-m-d H:i:s",$endToday);
        }
        if(!empty($orderType)){
            $t = explode(":",$orderType);
            $orderBy[$t[0]] = $t[1];
        }
        if(!empty($cat_id)){
            $condition['cat_id'] = $cat_id;
        }
        if(!empty($title)){
            $con['opt'] = "OR";
            $con['title'] = '%'.$title.'%';
            $con['keywords'] = '%'.$title.'%';
            $con['author'] = '%'.$title.'%';
            $con['content'] = '%'.$title.'%';
            $condition[] = $con;
        }

        $goodsList= ArticleService::getArticleLists(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>$orderBy],$condition);
        foreach($goodsList['list'] as $k=>$v){
            $goodsList['list'][$k]['image'] = getFileUrl($goodsList['list'][$k]['image']);
            $goodsList['list'][$k]['content'] = stripslashes($goodsList['list'][$k]['content']);
        }

        return $this->success([
            'list'=>$goodsList['list'],
            'total'=>$goodsList['total'],
            'currpage'=>$currpage,
            'pagesize'=>$pageSize
        ],'success');
    }

    //咨询详情
    public function getDetail(Request $request)
    {
        $id = $request->input('id','');
        if(empty($id)){
            return $this->error('缺少参数，id');
        }
        #更新点击量
        ArticleService::updateClick($id);

        $article = ArticleService::getInfo($id);
        if(empty($article)){
            return $this->error('该文章不存在');
        }
        $article['image'] = getFileUrl($article['image']);

        $cat_info = ArticleCatService::getInfo($article['cat_id']);

        // 获取上下页
        $page_data = ArticleService::getUpDown($id);

        return $this->success(['cat'=>$cat_info,'page_data'=>$page_data,'article'=>$article],'success');
    }

}