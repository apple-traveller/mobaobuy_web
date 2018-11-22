<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ArticleService;
use App\Services\ArticleCatService;
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $cat_id = $request->input('cat_id',0);
        $title = $request->input('title',"");
        $currpage = $request->input('currpage',1);
        $condition = [];
        if(!empty($cat_id)){
            $condition['cat_id']=$cat_id;
        }
        if(!empty($title)){
            $condition['title']="%".$title."%";
        }
        $pageSize =10;//分页
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        //查询所有文章
        $articles = ArticleService::getArticleLists(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['sort_order'=>'asc']],$condition);
        //dd($articles);
        return $this->display('admin.article.list',
            [
                'cateTrees'=>$cateTrees,
                'articles'=>$articles['list'],
                'count'=>$articles['total'],
                'title'=>$title,
                'cat_id'=>$cat_id,
                'pageSize'=>$pageSize,
                'currpage'=>$currpage
            ]);
    }

    //添加
    public function addForm(Request $request)
    {
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        $cateHasChild = ArticleCatService::getCateHasChild($cateTrees);
        //dd($cateHasChild);
        return $this->display('admin.article.add',
            [
                'cateTrees'=>$cateHasChild,
            ]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        $cateHasChild = ArticleCatService::getCateHasChild($cateTrees);
        //查询
        $article = ArticleService::getInfo($id);
        return $this->display('admin.article.edit',
            [
                'cateTrees'=>$cateHasChild,
                'article'=>$article,
                'currpage'=>$currpage
            ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        unset($data['_token']);
        unset($data['currpage']);
        $errorMsg = [];
        //dd($data);
        if(empty($data['title'])){
            $errorMsg[] = '文章标题不能为空';
        }
        if(empty($data['content'])){
            $errorMsg[] = '文章内容不能为空';
        }
        if(empty($data['author'])){
            $errorMsg[] = '文章作者不能为空';
        }
        if(empty($data['keywords'])){
            $errorMsg[] = '文章关键字不能为空';
        }
        if(empty($data['cat_id'])){
            $errorMsg[] = '所属分类不能为空';
        }
        if(empty($data['image'])){
            $errorMsg[] = '图片不能为空';
        }

        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        try{
            if(empty($id)){
                ArticleService::uniqueValidate($data['title']);//唯一性验证
                $data['add_time']=Carbon::now();
                $info = ArticleService::create($data);
            }else{
                $info = ArticleService::modify($id,$data);
            }
            if(!$info){
                return $this->error('保存失败');
            }
            return $this->success('保存成功！',url("/admin/article/list")."?currpage=".$currpage);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //查看
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        //查询所有的分类
        $cates = ArticleCatService::getCates();
        $cateTrees = ArticleCatService::getCatesTree($cates);
        //查询
        $article = ArticleService::getInfo($id);
        return $this->display('admin.article.detail',
            [
                'cateTrees'=>$cateTrees,
                'article'=>$article,
                'currpage'=>$currpage
            ]);
    }

    //排序
    public function sort(Request $request)
    {
        $id = $request->input('id');
        $sort_order = $request->input('sort_order');
        try{
            $info = ArticleService::modify($id,['sort_order'=>$sort_order]);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/admin/article/list",200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');

        try{
            $flag = ArticleService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/article/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //ajax修改状态
    public function isShow(Request $request)
    {
        $id = $request->input("id");
        $is_show = $request->input("val", 0);
        try{
            ArticleService::modify($id, ['is_show' => $is_show]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }
}
