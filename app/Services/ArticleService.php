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

    public static function getInfoByfields($where)
    {
        return ArticleRepo::getInfoByFields($where);
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

    public static function getFooterArticle(){
        $cat_list = ArticleCatService::getList(3);
        foreach ($cat_list as &$cat){
            $cat['articles'] = ArticleRepo::getList(['sort_order'=>'asc'],['is_show'=>1,'cat_id'=>$cat['id']]);
        }
        return $cat_list;
    }

    /**
     * 资讯中心文章列表
     * @param $cat_id
     * @param $title
     * @param $page
     * @param $page_size
     * @return mixed
     */
    public static function getNewsList($cat_id,$title,$page=1,$page_size=10)
    {
        $condition = [];
        if($cat_id > 0 && $cat_id != 2){
            $condition['cat_id'] = $cat_id;
        } else {
            $cat_list = ArticleCatRepo::getList([],['parent_id'=>2],['id']);
            $cat_id = '';
            foreach ($cat_list as $k=>$v){
                $cat_id .= $v['id'].'|';
            }
            $condition['cat_id'] = $cat_id;
        }
        if(!empty($title)){
            $con['opt'] = "OR";
            $con['title'] = '%'.$title.'%';
            $con['keywords'] = '%'.$title.'%';
            $con['author'] = '%'.$title.'%';
//            $con['content'] = '%'.$title.'%';
            $condition[] = $con;
        }
        $condition['is_show'] = 1;
        return ArticleRepo::getListBySearch(['pageSize'=>$page_size, 'page'=>$page, 'orderType'=>['add_time'=>'desc']],$condition);
    }

    /**
     * 热门资讯
     * getTopClick
     * @param int $page
     * @param int $page_size
     * @param array $orderBy
     * @return mixed
     */
    public static function getTopClick($page=1,$page_size=6,$orderBy=['click'=>'desc','add_time'=>'desc'])
    {
//        getTopClick(1,7,['add_time'=>'desc'])['list']
        $cat_list = ArticleCatRepo::getList([],['parent_id'=>2],['id','cat_name']);
//        dump($cat_list);
//        $condition['cat_id'] = $cat_id;
        $condition['is_show'] = 1;
        $artArr = [];
//        $cat_id = '';
//        foreach ($cat_list as $k=>$v){
//            $cat_id .= $v['id'].'|';
//        }
        foreach($cat_list as $k=>$v){
            $condition['cat_id'] = $v['id'];
            $artArr[$v['id']] = ArticleRepo::getListBySearch(['pageSize'=>$page_size, 'page'=>$page, 'orderType'=>$orderBy],$condition);
            $artArr[$v['id']]['cat_name'] = $v['cat_name'];
        }
//        dump($cat_id);
//
//         $a = ArticleRepo::getListBySearch(['pageSize'=>$page_size, 'page'=>$page, 'orderType'=>$orderBy],$condition);
         return $artArr;
    }

    /**
     * 更新点击量
     * @param $id
     * @return bool
     */
    public static function updateClick($id)
    {
        $article = ArticleRepo::getInfo($id);
        $data = ['click'=>$article['click']+1];
        return ArticleRepo::modify($id,$data);
    }

    /**
     * 判断文章是否在该分类下
     * @param $id
     * @param $cat_id
     * @return bool
     */
    public static function check_cat($id,$cat_id)
    {
        $cat = ArticleCatRepo::getList([],['parent_id'=>$cat_id],['id']);
        $article_cat = ArticleRepo::getInfo($id);
        $cat_ids = [];
        foreach ($cat as $k=>$v){
            $cat_ids[] = $v['id'];
        }
        if (in_array($article_cat['cat_id'],$cat_ids)){
            return true;
        }else{
            return false;
        };
    }

    /**
     * 获取上下页
     * @param $id
     * @return array
     */
    public static function getUpDown($id)
    {
        $article_info = ArticleRepo::getInfo($id);
        $cat = ArticleCatRepo::getInfoByFields(['id'=>$article_info['cat_id']]);

        $cat_ids = ArticleCatRepo::getList([],['parent_id'=>$cat['parent_id']],['id']);
        $cat_id = '';
        foreach ($cat_ids as $k=>$v){
            $cat_id .= $v['id'].'|';
        }
        $condition['is_show'] = 1;
        $condition['cat_id'] = $cat_id;
        $condition['id|<'] = $id;

        $up_page = ArticleRepo::getListBySearch(['page'=>1,'pageSize'=>1,'orderType'=>['id'=>'desc']],$condition);
        unset($condition['id|<']) ;
        $condition['id|>'] = $id;
        $down_page = ArticleRepo::getListBySearch(['page'=>1,'pageSize'=>1,'orderType'=>['id'=>'asc']],$condition);
        if(!empty($up_page['list'])){
            $up_news_title = $up_page['list'][0]['title'];
            $up_news_id = $up_page['list'][0]['id'];
        }else{
            $up_news_title = '没有了哦';
            $up_news_id = '';
        }
        if(!empty($down_page['list'])){
            $down_news_title = $down_page['list'][0]['title'];
            $down_news_id = $down_page['list'][0]['id'];
        }else{
            $down_news_title = '没有了哦';
            $down_news_id = '';
        }
        $data = [
            "up_news_title" => $up_news_title,
            "up_news_id" => $up_news_id,
            "down_news_title" => $down_news_title,
            "down_news_id" => $down_news_id,
        ];
        return $data;
    }

    /**
     * 列表不带分页
     * @param $condition
     * @return mixed
     */
    public static function getList($condition)
    {
        return ArticleRepo::getList([],$condition);
    }

}
