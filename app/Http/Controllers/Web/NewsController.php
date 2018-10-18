<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-17
 * Time: 10:53
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ArticleCatService;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('start', 0) / $request->input('length', 10) + 1;
        $page_size = $request->input('length', 10);
        if ($request->isMethod('get')){
            // 分类列
            $cat = ArticleCatService::getList(2);
            // 热门
            $hot_news = ArticleService::getTopClick($page,$page_size);
            // 搜索条件
            $cat_id = $request->input('cat_id','');
            $title = $request->input('title','');
            // 新闻列表
            $list = ArticleService::getNewsList($cat_id,$title,$page,$page_size);
            return $this->display('web.news.index',['cat'=>$cat,'hot_news'=>$hot_news['list'],'list'=>$list]);
        } else {
            $cat_id = $request->input('cat_id','');
            $title = $request->input('title','');

            $list = ArticleService::getNewsList($cat_id,$title,$page,$page_size);

            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $list['total'], //数据总行数
                'recordsFiltered' => $list['total'], //数据总行数
                'data' => $list['list']
            ];
            return $this->success('', '', $data);
        }

    }

    /**
     * 详情页
     * @param Request $request
     * @return NewsController
     */
    public function detail(Request $request)
    {
        $id = $request->input('id','');
        $cat_id = 2;
        $check_id = ArticleService::check_cat($id,$cat_id);
        if (empty($id) || !$check_id){
            return $this->error('没有这个页面');
        }
        #更新点击量
        ArticleService::updateClick($id);

        $article = ArticleService::getInfo($id);

        return $this->display('web.news.detail');
    }
}
