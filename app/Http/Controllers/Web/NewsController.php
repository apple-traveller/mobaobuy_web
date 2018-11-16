<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-17
 * Time: 10:53
 */
namespace App\Http\Controllers\Web;

use function App\Helpers\createPage;
use App\Http\Controllers\Controller;
use App\Services\ArticleCatService;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request,$cat_id=0,$page=1)
    {

//        $page = $request->input('page',1);
//        $page_size = $request->input('length', 2);
        $page_size = 2;
        if ($request->isMethod('get')){
//            $cat_id = $request->input('cat_id','');
            $title = $request->input('title','');

            // 路径
            if (!empty($cat_id)){
                $cat_info = ArticleCatService::getInfo($cat_id);
            } else {
                $cat_info = ArticleCatService::getInfo(2);
            }

            // 新闻列表
            $list = ArticleService::getNewsList($cat_id,$title,$page,$page_size);

            // 分页/news/list/{cat_id}/page/{page}.html

            $url = '/news/list/'.$cat_id.'/page/%d.html';
//            $url = '/news.html?page=%d';

            if(!empty($list['list'])){
                $linker = createPage($url, $page,$list['totalPage']);
            }else{
                $linker = createPage($url, 1, 1);
            }
            return $this->display('web.news.index',['cat'=>$cat_info,'list'=>$list,'linker'=>$linker]);
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
     * @param string $id
     * @return NewsController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
//        $check_id = ArticleService::check_cat($id,$cat_id);
        if (empty($id)){
            return $this->error('没有这个页面');
        }

        $article = ArticleService::getInfo($id);

        if (!empty($article)){
            #更新点击量
            ArticleService::updateClick($id);

        }
        $cat_info = ArticleCatService::getInfo($article['cat_id']);

        // 获取上下页
        $page_data = ArticleService::getUpDown($id);

        return $this->display('web.news.detail',['cat'=>$cat_info,'page_data'=>$page_data,'article'=>$article]);
    }
}
